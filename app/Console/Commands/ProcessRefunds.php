<?php

namespace App\Console\Commands;

use App\Models\Topup;
use App\Traits\PaypalSystem;
use App\Traits\StripeSystem;
use Illuminate\Console\Command;
use App\Models\AccountTransaction;

class ProcessRefunds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'process:refunds';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process Refunds of Failed Orders';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->line("");
        $this->line("****************************************************************");
        $this->info("Started Sync of Countries with Reloadly Platform");
        $this->line("****************************************************************");
        try{
            $topups = Topup::query()
                ->where('status', 'FAIL')
                ->with('invoice', 'user')
                ->get();
            foreach ($topups as $topup) {
                switch ($topup['invoice']['payment_method']) {
                    case "BALANCE":
                        $accountTransaction = AccountTransaction::query()->updateOrCreate([
                            'invoice_id' => $topup['invoice']['id'],
                            'user_id' => $topup['user_id'],
                            'amount' => $topup['invoice']['amount'],
                            'currency' => $topup['invoice']['currency_code'],
                            'type' => 'CREDIT',
                            'description' => 'Invoice Refunded. Invoice: '.$topup['invoice']['id']
                        ], [
                            'ending_balance' => $topup['user']['balance_value'] + $topup['invoice']['amount']
                        ]);
                        if ($accountTransaction) {
                            $topup['status'] = 'REFUNDED';
                            $topup->save();
                            $topup['invoice']['status'] = 'REFUNDED';
                            $topup['invoice']->save();
                        }
                        break;
                    case "STRIPE":
                        if (StripeSystem::refundInvoice($topup['invoice'])) {
                            $topup['status'] = 'REFUNDED';
                            $topup->save();
                            $topup['invoice']['status'] = 'REFUNDED';
                            $topup['invoice']->save();
                        }
                        break;
                    case "PAYPAL":
                        if (PaypalSystem::refundPaypalOrder($topup['invoice'])) {
                            $topup['status'] = 'REFUNDED';
                            $topup->save();
                            $topup['invoice']['status'] = 'REFUNDED';
                            $topup['invoice']->save();
                        }
                        break;
                    default:
                        break;
                }
            }
        }catch (\Exception $exception){
            $this->error($exception->getMessage());
        }

        $this->line("****************************************************************");
        $this->info("Sync Complete !!! ".count($topups)." Topups Refunded.");
        $this->line("****************************************************************");
        $this->line("");
        return 0;
    }
}
