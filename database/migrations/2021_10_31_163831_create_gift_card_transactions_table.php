<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGiftCardTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gift_card_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('invoice_id');
            $table->foreign('invoice_id')->references('id')->on('invoices');
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('gift_card_products');
            $table->unsignedBigInteger('sender_currency_id');
            $table->foreign('sender_currency_id')->references('id')->on('currencies');
            $table->unsignedBigInteger('recipient_currency_id');
            $table->foreign('recipient_currency_id')->references('id')->on('currencies');
            $table->json('product');
            $table->double('sender_amount');
            $table->double('reloadly_fee');
            $table->double('recipient_amount');
            $table->string('email');
            $table->string('reference');
            $table->string('transaction_id')->nullable()->default(NULL);
            $table->enum('status',['PENDING_PAYMENT','PENDING','SUCCESS','FAIL'])->default('PENDING_PAYMENT');
            $table->json('response')->nullable()->default(NULL);
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
        Schema::dropIfExists('gift_card_transactions');
    }
}
