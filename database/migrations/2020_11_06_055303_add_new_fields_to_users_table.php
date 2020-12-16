<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('image')->nullable()->after('email_verified_at')->default('/assets/images/default.png');
            $table->string('phone')->nullable()->after('email');
            $table->string('address_line_1')->nullable()->after('password');
            $table->string('address_line_2')->nullable()->after('address_line_1');
            $table->string('city')->nullable()->after('address_line_2');
            $table->string('state')->nullable()->after('city');
            $table->string('postal_code')->nullable()->after('state');
            $table->string('country')->nullable()->after('postal_code');
            $table->string('stripe_id')->nullable()->after('country');
            $table->unsignedBigInteger('stripe_payment_method_id')->nullable();
            $table->foreign('stripe_payment_method_id')->references('id')->on('stripe_payment_methods');
            $table->json('stripe_response')->nullable()->after('stripe_id');
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
            $table->dropColumn(['image', 'phone', 'address_line_1', 'address_line_2', 'city', 'state', 'postal_code', 'country', 'stripe_id', 'stripe_response']);
        });
    }
}
