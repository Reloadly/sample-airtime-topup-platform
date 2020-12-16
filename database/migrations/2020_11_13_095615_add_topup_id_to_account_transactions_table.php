<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTopupIdToAccountTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('account_transactions', function (Blueprint $table) {
            $table->unsignedBigInteger('topup_id')->nullable()->default(null)->after('invoice_id');
            $table->foreign('topup_id')->references('id')->on('topups');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('account_transactions', function (Blueprint $table) {
            $table->dropColumn('topup_id');
        });
    }
}
