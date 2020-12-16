<?php

namespace App\Console\Commands;

use App\Models\Invoice;
use App\Models\System;
use App\Models\User;
use Illuminate\Console\Command;
use OTIFSolutions\ACLMenu\Models\UserRole;

class SyncStripe extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:stripe';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync Invoices and PaymentMethods with Stripe';

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
        $this->info("Started Sync of Stripe");
        $this->line("****************************************************************");

        $this->line("Searching Database for users not registered with Stripe.");
        $users = User::all();
        $this->info(sizeof($users)." User(s) Found.");

        $this->line("Syncing with Stripe.");
        foreach ($users as $user)
            System::registerUserWithStripe($user);
        $this->info("Users Synced with Stripe.");

        $this->line("Searching Database for PENDING Invoices");
        $invoices = Invoice::where('status','PENDING')->get();
        $this->info(sizeof($invoices)." Invoice(s) Found.");

        $this->line("Syncing with Stripe.");
        foreach ($invoices as $invoice)
            System::updatePaymentIntent($invoice);
        $this->info("Invoices Synced with Stripe.");

        $this->line("Searching Database for all stripe Clients");
        $users = User::where('stripe_id','!=',null)->where('user_role_id',UserRole::where('name','CUSTOMER')->first()['id'])->get();
        $this->info(sizeof($users)." Customer(s) Found.");

        $this->line("Syncing with Stripe.");
        foreach ($users as $user)
            System::updatePaymentMethods($user);
        $this->info("Customers Payment Methods Synced with Stripe.");
        $this->line("****************************************************************");
        $this->info("Stripe Sync Completed (Pending Invoices, Users, Payment Methods) !!! ");
        $this->line("****************************************************************");
        $this->line("");

    }
}
