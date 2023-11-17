<?php

namespace App\Console\Commands;

use App\Models\System;
use App\Models\Invoice;
use Illuminate\Console\Command;

class SyncPaypal extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:paypal';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync Invoices with Paypal';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->line("");
        $this->line("****************************************************************");
        $this->info("Started Sync of Invoices with Paypal");
        $this->line("****************************************************************");
        $this->line("Searching Database for PENDING/PROCESSING Invoices");
        $invoices = Invoice::query()
            ->where('status','PENDING')
            ->orWhere('status','PROCESSING')
            ->get();
        $this->info(count($invoices)." Invoice(s) Found.");

        $this->line("Syncing with Paypal.");
        foreach ($invoices as $invoice) {
            try {
                $this->info('Processing Invoice : ' . $invoice['id']);
                System::updatePaypalOrder($invoice);
            } catch (\Exception $ex) {
                $this->error($ex->getMessage());
            }
        }
        $this->info("Sync Completed.");

        $this->line("****************************************************************");
        $this->info("All Invoices Synced !!! ");
        $this->line("****************************************************************");
        $this->line("");
        return 0;
    }
}
