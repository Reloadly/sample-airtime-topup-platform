<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBalanceForPaymentMethodToInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            DB::statement("ALTER TABLE invoices MODIFY payment_method ENUM('STRIPE','PAYPAL','BALANCE','NONE') DEFAULT 'NONE'");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            DB::statement("ALTER TABLE invoices MODIFY payment_method ENUM('STRIPE','PAYPAL','NONE') DEFAULT 'NONE'");
        });
    }
}
