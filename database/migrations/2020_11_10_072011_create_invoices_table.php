<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('currency_code');
            $table->string('payment_intent_id')->nullable();
            $table->string('paypal_order_id')->nullable();
            $table->double('amount');
            $table->enum('type',['AddFunds','Topup','NONE'])->default('NONE');
            $table->enum('status',['PENDING','PAID','FAIL','CANCELLED','PROCESSING'])->default('PENDING');
            $table->enum('payment_method',['STRIPE','PAYPAL','NONE'])->default('NONE');
            $table->json('payment_intent_response')->nullable();
            $table->json('paypal_response')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
