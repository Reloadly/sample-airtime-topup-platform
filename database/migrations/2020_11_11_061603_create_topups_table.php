<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTopupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('topups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('operator_id');
            $table->foreign('operator_id')->references('id')->on('operators');
            $table->unsignedBigInteger('invoice_id');
            $table->foreign('invoice_id')->references('id')->on('invoices');
            $table->boolean('is_local')->nullable();
            $table->double('topup');
            $table->double('amount');
            $table->double('number');
            $table->string('sender_currency')->nullable();
            $table->string('receiver_currency')->nullable();
            $table->enum('status',['PENDING','SUCCESS','FAIL','PENDING_PAYMENT'])->default('PENDING_PAYMENT');
            $table->enum('type',['USER_INITIATED','SYSTEM_INITIATED'])->default('USER_INITIATED');
            $table->date('subscription_date')->nullable();
            $table->json('system_initiated_logs')->nullable();
            $table->json('response')->nullable();
            $table->json('pin')->nullable();
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
        Schema::dropIfExists('topups');
    }
}
