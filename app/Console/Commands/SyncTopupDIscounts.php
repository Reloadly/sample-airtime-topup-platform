<?php

namespace App\Console\Commands;

use App\Models\AccountTransaction;
use App\Models\Topup;
use App\Models\User;
use Illuminate\Console\Command;
use OTIFSolutions\ACLMenu\Models\UserRole;
use OTIFSolutions\Laravel\Settings\Models\Setting;

class SyncTopupDIscounts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:topup_discounts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add Discounted amount to Reseller Wallet for sending topup';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->line("");
        $this->line("****************************************************************");
        $this->info("Started Sync of Topup Discounts");
        $this->line("****************************************************************");
        $this->line("Searching Database for Resellers.");
        $resellers = User::where('user_role_id', UserRole::where('name', 'RESELLER')->first()['id'])->get();
        $this->info(sizeof($resellers) . " Reseller(s) Found.");

        $this->line("Syncing with Topups for Discount.");
        foreach ($resellers as $reseller) {
            $accountTransactions = $reseller->account_transactions()->where('topup_id', '!=' , NULL)->where('type', 'CREDIT')->pluck('topup_id')->toArray();
            $topups = $reseller->topups()->where('status', 'SUCCESS')->whereNotIn('id',$accountTransactions)->get();
            $this->info(count($topups) . " Topup(s) Found for ".$reseller['name']);
            foreach ($topups as $topup) {
                if (isset($topup['invoice'], $topup['operator'])) {
                    $discountPercentage = 0;
                    $operator = $reseller->operators()->where('operator_id', $topup['operator']['id'])->first();
                    if ($topup['is_local'] && $operator->pivot->local_discount)
                        $discountPercentage = $operator->pivot->local_discount;
                    elseif (!$topup['is_local'] && $operator->pivot->international_discount)
                        $discountPercentage = $operator->pivot->international_discount;
                    if ($discountPercentage) {
                        $discount = $topup['amount'] * ($discountPercentage / 100);
                        AccountTransaction::firstOrCreate(['topup_id' => $topup['id']], [
                            'user_id' => $topup['user_id'],
                            'topup_id' => $topup['id'],
                            'amount' => $discount,
                            'currency' => $topup['invoice']['currency_code'],
                            'type' => 'CREDIT',
                            'description' => 'Commission Paid. Topup # ' . $topup['id'] . ' @' . $discountPercentage . '%',
                            'ending_balance' => $reseller['balance_value'] + $discount
                        ]);
                    }
                }
            }
        }
        $this->line("****************************************************************");
        $this->info("Reseller Topup Discounts Synced");
        $this->line("****************************************************************");

    }
}
