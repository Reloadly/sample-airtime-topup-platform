<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFileEntryIdToTopupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('topups', function (Blueprint $table) {
            $table->unsignedBigInteger('file_entry_id')->nullable()->default(null)->after('invoice_id');
            $table->foreign('file_entry_id')->references('id')->on('file_entries');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('topups', function (Blueprint $table) {
            $table->dropColumn('file_entry_id');
        });
    }
}
