<?php
namespace App\Traits;

use App\Models\AccountTransaction;
use App\Models\System;
use App\Models\Topup;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Core\ProductionEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersGetRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use OTIFSolutions\Laravel\Settings\Models\Setting;
use PayPalCheckoutSdk\Payments\CapturesRefundRequest;

trait PaypalSystem {

    public static function isPaypalSupported($invoice){
        return in_array(
            strtoupper($invoice['currency_code']),
            ['AUD','CAD','CZK','DKK','EUR','HKD','ILS','MXN','NZD','NOK','PHP','PLN','GBP','RUB','SGD','SEK','CHF','THB','USD']
        );
    }

    public static function getPaypalClient(){
        $environment = null;
        if (@Setting::get('paypal_api_mode') == 'TEST')
            $environment = new SandboxEnvironment(@Setting::get('paypal_client_id'),@Setting::get('paypal_secret'));
        else
            $environment = new ProductionEnvironment(@Setting::get('paypal_client_id'),@Setting::get('paypal_secret'));
        return new PayPalHttpClient($environment);
    }

    public static function updatePaypalOrder($invoice){
        $client = System::getPaypalClient();
        if ($invoice['paypal_order_id'] === null){
            $request = new OrdersCreateRequest();
            $request->prefer('return=representation');
            $request->body = [
                'intent' => 'CAPTURE',
                'purchase_units' => [
                    [
                        'amount' => [
                            'currency_code' => $invoice['currency_code'],
                            'value' => number_format($invoice['amount'],2)
                        ],
                        'description' => 'Topup Purchased. Invoice : '.$invoice['id'],
                        'invoice_id' => $invoice['id']
                    ]
                ]
            ];
            $invoice['paypal_response'] = $client->execute($request)->result;
            $invoice['paypal_order_id'] = $invoice['paypal_response']['id'];
        }else{
            try{
                $invoice['paypal_response'] = $client->execute(new OrdersGetRequest($invoice['paypal_order_id']))->result;
            }catch (\Exception $ex){
                $invoice['paypal_order_id'] = null;
                $invoice['status'] = 'PENDING';
                $invoice->save();
                return;
            }
            if ($invoice['paypal_response']['status'] === 'COMPLETED'){
                $invoice['payment_method'] = 'PAYPAL';
                $invoice['status'] = 'PAID';
                if($invoice['type'] == 'AddFunds') {
                    AccountTransaction::firstOrCreate(['invoice_id' => $invoice['id']],[
                        'user_id' => $invoice['user_id'],
                        'invoice_id' => $invoice['id'],
                        'amount' => $invoice['amount'],
                        'currency' => $invoice['currency_code'],
                        'type' => 'CREDIT',
                        'description' => 'Funds Added. Invoice: '.$invoice['id'],
                        'response' => $invoice['paypal_response'],
                        'ending_balance' => @$invoice['user']['balance_value'] + $invoice['amount']
                    ]);
                }elseif($invoice['type'] == 'Topup') {
                    $ids = $invoice->topups()->pluck('id');
                    Topup::whereIn('id', $ids)->where('status', 'PENDING_PAYMENT')->update([
                        'status' => 'PENDING'
                    ]);
                }
                System::sendEmail($invoice['user']['email'],'mails.invoices.paid', ['invoice' => $invoice]);
            }elseif ($invoice['paypal_response']['status'] === 'APPROVED'){
                $request = new OrdersCaptureRequest($invoice['paypal_order_id']);
                $request->prefer('return=representation');
                $invoice['paypal_response'] = $client->execute($request)->result;
                if ($invoice['paypal_response']['status'] === 'COMPLETED'){
                    $invoice['payment_method'] = 'PAYPAL';
                    $invoice['status'] = 'PAID';
                    if($invoice['type'] == 'AddFunds') {
                        AccountTransaction::firstOrCreate(['invoice_id' => $invoice['id']],[
                            'user_id' => $invoice['user_id'],
                            'invoice_id' => $invoice['id'],
                            'amount' => $invoice['amount'],
                            'currency' => $invoice['currency_code'],
                            'type' => 'CREDIT',
                            'description' => 'Funds Added. Invoice: '.$invoice['id'],
                            'response' => $invoice['paypal_response'],
                            'ending_balance' => @$invoice['user']['balance_value'] + $invoice['amount']
                        ]);
                    }elseif($invoice['type'] == 'Topup') {
                        $ids = $invoice->topups()->pluck('id');
                        Topup::whereIn('id', $ids)->where('status', 'PENDING_PAYMENT')->update([
                            'status' => 'PENDING'
                        ]);
                    }
                    System::sendEmail($invoice['user']['email'],'mails.invoices.paid', ['invoice' => $invoice]);
                }else{
                    $invoice['payment_method'] = 'PAYPAL';
                    $invoice['status'] = 'PROCESSING';
                }

            }
        }
        $invoice->save();
    }

    public static function refundPaypalOrder($invoice){
        self::updatePaypalOrder($invoice);
        $client = self::getPaypalClient();
        if ($invoice['paypal_order_id'] !== null){
            try{
                $invoice['paypal_response'] = $client->execute(new OrdersGetRequest($invoice['paypal_order_id']))->result;
            }catch (\Exception $ex){
                return false;
            }
            if ($invoice['status'] === 'PAID'){
                if (isset($invoice['paypal_response']['purchase_units'])){
                    foreach ($invoice['paypal_response']['purchase_units'] as $purchaseUnit){
                        if (isset($purchaseUnit['payments']['captures'])){
                            foreach ($purchaseUnit['payments']['captures'] as $capture){
                                if ($capture['status'] === "COMPLETED"){
                                    $request = new CapturesRefundRequest($capture['id']);
                                    $response = $client->execute($request);
                                }
                            }
                        }
                    }
                }
            }
        }
        self::updatePaypalOrder($invoice);
        return true;
    }

}
