<?php
namespace App\Traits;


use App\Models\AccountTransaction;
use App\Models\Invoice;
use App\Models\StripePaymentMethod;
use App\Models\System;
use App\Models\Topup;
use App\Models\User;
use Stripe\StripeClient;
use OTIFSolutions\Laravel\Settings\Models\Setting;

trait StripeSystem {

    public static function isStripeEnabled(){
        return @Setting::get('stripe_publishable_key') && @Setting::get('stripe_secret_key');
    }

    public static function registerUserWithStripe($user){
        if (!StripeSystem::isStripeEnabled()) return;
        try {
            \Stripe\Stripe::setApiKey(Setting::get('stripe_secret_key'));
            $customers = \Stripe\Customer::all(['email' => $user['email']]);
            $customer = null;
            if (sizeof($customers->data) == 0)
                $customer = \Stripe\Customer::create([
                    'email' => $user['email'],
                    'name' => $user['name'],
                    'metadata' => [
                        'id' => $user['id'],
                        'user_role_id' => $user['user_role_id']
                    ]
                ]);
            else
                $customer = $customers->data[0];
            $user['stripe_id'] = $customer->id;
            $user['stripe_response'] = $customer;
        }catch (\Exception $ex){
            $user['stripe_response'] = $ex;
        }
        $user->save();
        StripeSystem::updatePaymentMethods($user);
    }

    public static function updatePaymentIntent(\App\Models\Invoice $invoice){
        if (!StripeSystem::isStripeEnabled()) return false;
        if ($invoice['user']['stripe_id'] === null) StripeSystem::registerUserWithStripe($invoice['user']);
        try{
            \Stripe\Stripe::setApiKey(Setting::get('stripe_secret_key'));
            if ($invoice['payment_intent_id'] == null){
                $multiplier = 100;
                switch (strtolower($invoice['currency_code']))
                {
                    case 'mga':
                    case 'bif':
                    case 'clp':
                    case 'pyg':
                    case 'djf':
                    case 'rwf':
                    case 'gnf':
                    case 'jpy':
                    case 'vnd':
                    case 'vuv':
                    case 'xaf':
                    case 'kmf':
                    case 'xof':
                    case 'krw':
                    case 'xpf':
                        $multiplier = 1;
                    break;
                }
                $intent =  \Stripe\PaymentIntent::create([
                    'amount' => (int)($invoice['amount']*$multiplier),
                    'currency' => strtolower($invoice['currency_code']),
                    'customer' => $invoice['user']['stripe_id'],
                    'metadata' => [
                        'invoice_id' => $invoice['id']
                    ],
                    'receipt_email' => $invoice['user']['email']
                ]);
                $invoice['payment_intent_id'] = $intent->id;
            }else{
                $intent = \Stripe\PaymentIntent::retrieve($invoice['payment_intent_id']);
            }
            $invoice['payment_intent_response'] = $intent;
            if (isset($invoice['payment_intent_response']['status']) && $invoice['payment_intent_response']['status'] == "succeeded")
            {
                $invoice['payment_method'] = 'STRIPE';
                $invoice['status'] = 'PAID';
                if($invoice['type'] == 'AddFunds') {
                    AccountTransaction::firstOrCreate(['invoice_id' => $invoice['id']],[
                        'user_id' => $invoice['user_id'],
                        'invoice_id' => $invoice['id'],
                        'amount' => $invoice['amount'],
                        'currency' => $invoice['currency_code'],
                        'type' => 'CREDIT',
                        'description' => 'Funds Added. Invoice: '.$invoice['id'],
                        'response' => $invoice['payment_intent_response'],
                        'ending_balance' => @$invoice['user']['balance_value'] + $invoice['amount']
                    ]);
                }elseif($invoice['type'] == 'Topup') {
                    $ids = $invoice->topups()->pluck('id');
                    Topup::whereIn('id', $ids)->where('status', 'PENDING_PAYMENT')->update([
                        'status' => 'PENDING'
                    ]);
                }
                StripeSystem::updatePaymentMethods($invoice['user']);
                System::sendEmail($invoice['user']['email'],'mails.invoices.paid', ['invoice' => $invoice]);
            }
            $invoice->save();
            return true;
        }catch (\Exception $ex){
            $invoice['payment_intent_response'] = [
                'Error' => $ex->getMessage()
            ];
            $invoice->save();
            return false;
        }
    }

    public static function updatePaymentMethods(\App\Models\User $user){

        if (!StripeSystem::isStripeEnabled()) return false;
        if ($user['stripe_id'] === null) StripeSystem::registerUserWithStripe($user);
        try{
            \Stripe\Stripe::setApiKey(Setting::get('stripe_secret_key'));
            $cards = \Stripe\PaymentMethod::all(['customer' => $user['stripe_id'], 'type' => 'card',]);
            foreach ($cards->data as $card){
                StripePaymentMethod::updateOrCreate(['stripe_id' => $card->id],[
                    'user_id' => $user['id'],
                    'stripe_id' => $card->id,
                    'stripe_customer_id' => $user['stripe_id'],
                    'type' => $card->type,
                    'name' => $card->card->brand.' - '.$card->card->last4,
                    'exp_month' => $card->card->exp_month,
                    'exp_year' => $card->card->exp_year,
                    'response' => $card
                ]);
            }
            return true;
        }catch (\Exception $ex){
            return false;
        }
    }

    public static function updateAccountEntries(\App\Models\User $user){

        if (!StripeSystem::isStripeEnabled()) return false;
        if ($user['stripe_id'] === null) StripeSystem::registerUserWithStripe($user);
        try{
            $stripe = new StripeClient(Setting::get('stripe_secret_key'));
            $transactions =  $stripe->customers->allBalanceTransactions(
                $user['stripe_id'],
                ['limit' => 100]
            );
            foreach ($transactions->data as $transaction){
                AccountTransaction::firstOrCreate(['stripe_id' => $transaction->id],[
                    'user_id' => $user['id'],
                    'stripe_id' => $transaction->id,
                    'stripe_invoice_id' => $transaction->invoice,
                    'credit_note_id' => $transaction->credit_note,
                    'amount' => $transaction->amount,
                    'currency' => $transaction->currency,
                    'description' => $transaction->description,
                    'ending_balance' => $transaction->ending_balance,
                    'metadata' => $transaction->metadata,
                    'type' => $transaction->type,
                    'created' => $transaction->created,
                    'response' => $transaction
                ]);
            }
            return true;
        }catch (\Exception $ex){
            return false;
        }
    }

    public static function removePaymentMethod(\App\Models\StripePaymentMethod $method){

        if (!StripeSystem::isStripeEnabled() || $method['stripe_id'] === null) return false;
        try{
            \Stripe\Stripe::setApiKey(Setting::get('stripe_secret_key'));
            \Stripe\PaymentMethod::retrieve($method['stripe_id'])->detach();
            $method->delete();
            return true;
        }catch (\Exception $ex){
            return false;
        }
    }

    public static function createSetupIntent(\App\Models\User $user){

        if (!StripeSystem::isStripeEnabled()) return false;
        if ($user['stripe_id'] === null) StripeSystem::registerUserWithStripe($user);
        \Stripe\Stripe::setApiKey(Setting::get('stripe_secret_key'));
        return \Stripe\SetupIntent::create( ['customer' => $user['stripe_id'] ]);
    }

    public static function makePaymentIntentOffline(\App\Models\Invoice $invoice){

        if (!StripeSystem::isStripeEnabled()) return false;
        if ($invoice['user']['stripe_id'] === null) StripeSystem::registerUserWithStripe($invoice['user']);
        StripeSystem::updatePaymentMethods($invoice['user']);
        if (sizeof($invoice['user']['stripe_payment_methods']) == 0){
            System::sendEmail($invoice['user']['email'],'mails.invoices.failed', ['invoice' => $invoice]);
            return false;
        }
        if ($invoice['user']['default_stripe_payment_method'] === null){
            $invoice['user']['stripe_payment_method_id'] = $invoice['user']['stripe_payment_methods'][0]['id'];
            $invoice['user']->save();
            $invoice = Invoice::find($invoice['id']);
        }
        try {
            \Stripe\Stripe::setApiKey(Setting::get('stripe_secret_key'));
            $multiplier = 100;
            switch (strtolower($invoice['currency_code']))
            {
                case 'mga':
                case 'bif':
                case 'clp':
                case 'pyg':
                case 'djf':
                case 'rwf':
                case 'gnf':
                case 'jpy':
                case 'vnd':
                case 'vuv':
                case 'xaf':
                case 'kmf':
                case 'xof':
                case 'krw':
                case 'xpf':
                    $multiplier = 1;
                    break;
            }
            $intent = \Stripe\PaymentIntent::create([
                'amount' => (int)($invoice['amount']*$multiplier),
                'currency' => strtolower($invoice['currency_code']),
                'customer' => $invoice['user']['stripe_id'],
                'payment_method' => $invoice['user']['default_stripe_payment_method']['stripe_id'],
                'off_session' => true,
                'confirm' => true,
            ]);
            $invoice['payment_intent_id'] = $intent->id;
            $invoice['payment_intent_response'] = $intent;
            $invoice->save();
            System::updatePaymentIntent($invoice);
            return true;
        } catch (\Stripe\Exception\CardException $e) {
            System::sendEmail($invoice['user']['email'],'mails.invoices.failed', ['invoice' => $invoice]);
            return $e;
        }
    }

    public static function refundInvoice(Invoice $invoice){
        self::updatePaymentIntent($invoice);
        if (isset($invoice['payment_intent_response']['charges']['data'])){
            if (!StripeSystem::isStripeEnabled()) return false;
            if ($invoice['user']['stripe_id'] === null) StripeSystem::registerUserWithStripe($invoice['user']);
            \Stripe\Stripe::setApiKey(Setting::get('stripe_secret_key'));
            try{
                foreach ($invoice['payment_intent_response']['charges']['data'] as $charge){
                    if (!$charge['refunded']){
                        $response = \Stripe\Refund::create(['charge' => $charge['id']]);
                    }
                }
            }catch (\Exception $ex){
                return false;
            }
        }
        self::updatePaymentIntent($invoice);
        return true;
    }

}
