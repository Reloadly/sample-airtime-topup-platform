<?php

namespace App\Console\Commands;

use App\Models\GiftCardTransaction;
use App\Models\User;
use Illuminate\Console\Command;

class SyncGiftTransactions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:gift_transactions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync Reloadly Gift Card Transactions with Reloadly Platform';

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
     * @return mixed
     */
    public function handle()
    {
        $this->line("");
        $this->line("****************************************************************");
        $this->info("Started Sync of Money Transfers");
        $this->line("****************************************************************");
        $this->line("Syncing with PAID invoices");

        $reloadlyGiftCardTransactions = GiftCardTransaction::where('status','PENDING_PAYMENT')->get();
        $this->info(count($reloadlyGiftCardTransactions)." Reloadly Gift Transactions Found");
        foreach ($reloadlyGiftCardTransactions as $transaction){
            if($transaction['invoice']['status'] === 'PAID'){
                $transaction['status'] = 'PENDING';
                $transaction->save();
            }
        }
        $this->line("Getting Reloadly Gift Card Transactions that are PENDING");
        GiftCardTransaction::where('status','PENDING')->chunk(100, function($giftTransactions)
        {
            $this->info(count($giftTransactions)." Reloadly Gift Transactions Found.");
            foreach ($giftTransactions as $reloadlyGiftCardTransaction){
                $response = User::admin()->orderReloadlyGiftProducts($reloadlyGiftCardTransaction['product']['rid'],$reloadlyGiftCardTransaction['product']['country']['isoName'],1,$reloadlyGiftCardTransaction['recipient_amount'],$reloadlyGiftCardTransaction['reference'],$reloadlyGiftCardTransaction['user']['name'],$reloadlyGiftCardTransaction['email']);

                if((isset($response->status)) && ($response->status === 'SUCCESSFUL')){
                    $reloadlyGiftCardTransaction['transaction_id'] = $response->transactionId;
                    $reloadlyGiftCardTransaction['status'] = 'SUCCESS';
                }else{
                    $reloadlyGiftCardTransaction['status'] = 'FAIL';
                }
                $reloadlyGiftCardTransaction['response'] = $response;
                $reloadlyGiftCardTransaction->save();
            }
            $this->info(count($giftTransactions)." Transactions Synced !!!");
        });
        $this->line("****************************************************************");
        $this->info("All Reloadly Gift Transactions Synced !!! ");
        $this->line("****************************************************************");
        $this->line("");
    }
}
