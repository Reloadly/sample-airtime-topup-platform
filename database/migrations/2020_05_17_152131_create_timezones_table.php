<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimezonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timezones', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('abbr');
            $table->double('offset');
            $table->boolean('is_dst');
            $table->string('value');
            $table->json('utc');
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
        Schema::dropIfExists('timezones');
    }
}
