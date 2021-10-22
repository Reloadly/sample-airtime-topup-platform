<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Add2FaDetailsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('2fa_mode',['ENABLED','DISABLED'])->default('DISABLED')->after('password');
            $table->string('2fa_secret')->nullable()->after('2fa_mode');
            $table->dateTime('2fa_requested_at')->nullable()->after('2fa_secret');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['2fa_mode','2fa_secret', '2fa_requested_at']);
        });
    }
}
