<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOperatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('operators', function (Blueprint $table) {
            $table->id();
            $table->string('rid');
            $table->unsignedBigInteger('country_id');
            $table->foreign('country_id')->references('id')->on('countries');
            $table->string('name');
            $table->string('bundle');
            $table->boolean('data')->nullable();
            $table->boolean('pin')->nullable();
            $table->boolean('supports_local_amounts')->nullable();
            $table->string('denomination_type');
            $table->string('sender_currency_code');
            $table->string('sender_currency_symbol');
            $table->string('destination_currency_code');
            $table->string('destination_currency_symbol');
            $table->double('commission')->nullable();
            $table->double('international_discount')->nullable();
            $table->double('local_discount')->nullable();
            $table->double('most_popular_amount')->nullable();
            $table->double('min_amount')->nullable();
            $table->double('local_min_amount')->nullable();
            $table->double('max_amount')->nullable();
            $table->double('local_max_amount')->nullable();
            $table->double('fx_rate');
            $table->json('logo_urls');
            $table->json('fixed_amounts');
            $table->json('fixed_amounts_descriptions');
            $table->json('local_fixed_amounts');
            $table->json('local_fixed_amounts_descriptions');
            $table->json('suggested_amounts');
            $table->json('suggested_amounts_map');
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
        Schema::dropIfExists('operators');
    }
}
