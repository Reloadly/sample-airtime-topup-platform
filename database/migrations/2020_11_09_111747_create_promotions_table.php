<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromotionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string('rid');
            $table->unsignedBigInteger('operator_id');
            $table->foreign('operator_id')->references('id')->on('operators');
            $table->longText('title');
            $table->longText('title2')->nullable();
            $table->longText('description');
            $table->string('start_date')->nullable();
            $table->string('end_date')->nullable();
            $table->string('denominations')->nullable();
            $table->string('localDenominations')->nullable();
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
        Schema::dropIfExists('promotions');
    }
}
