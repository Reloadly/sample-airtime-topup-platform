<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRefundToTopupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::statement("ALTER TABLE topups CHANGE COLUMN status status ENUM('PENDING','SUCCESS','FAIL','PENDING_PAYMENT', 'REFUNDED') NOT NULL DEFAULT 'PENDING_PAYMENT'");
        \DB::statement("ALTER TABLE invoices CHANGE COLUMN status status ENUM('PENDING','PAID','FAIL','CANCELLED','PROCESSING', 'REFUNDED') NOT NULL DEFAULT 'PENDING'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement("ALTER TABLE topups CHANGE COLUMN status status ENUM('PENDING','SUCCESS','FAIL','PENDING_PAYMENT') NOT NULL DEFAULT 'PENDING_PAYMENT'");
        \DB::statement("ALTER TABLE invoices CHANGE COLUMN status status ENUM('PENDING','PAID','FAIL','CANCELLED','PROCESSING') NOT NULL DEFAULT 'PENDING'");
    }
}
