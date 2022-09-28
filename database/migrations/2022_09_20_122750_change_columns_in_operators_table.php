<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnsInOperatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('operators', function (Blueprint $table) {
            DB::statement("ALTER TABLE `operators` CHANGE `logo_urls` `logo_urls` LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL;");
            DB::statement("ALTER TABLE `operators` CHANGE `local_fixed_amounts_descriptions` `local_fixed_amounts_descriptions` LONGTEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL;");
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
            //
        });
    }
}
