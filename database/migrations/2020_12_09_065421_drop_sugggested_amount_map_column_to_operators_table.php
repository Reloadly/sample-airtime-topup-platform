<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropSugggestedAmountMapColumnToOperatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('operators', function (Blueprint $table) {
            $table->dropColumn(['suggested_amounts_map']);
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
            $table->json('suggested_amounts_map');
        });
    }
}
