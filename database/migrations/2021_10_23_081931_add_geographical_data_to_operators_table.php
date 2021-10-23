<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGeographicalDataToOperatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('operators', function (Blueprint $table) {
            $table->boolean('supports_geographical_recharge_plans')->after('supports_local_amounts');
            $table->json('geographical_recharge_plans')->after('suggested_amounts_map')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('operators', function (Blueprint $table) {
            $table->dropColumn(['supports_geographical_recharge_plans','geographical_recharge_plans']);
        });
    }
}
