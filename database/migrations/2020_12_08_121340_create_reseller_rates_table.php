<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResellerRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reseller_rates', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('operator_id');
            $table->foreign('operator_id')->references('id')->on('operators');
            $table->double('international_discount')->nullable();
            $table->double('local_discount')->nullable();
            $table->primary(['user_id', 'operator_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reseller_rates');
    }
}
