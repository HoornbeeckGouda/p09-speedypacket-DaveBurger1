<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE packages MODIFY COLUMN status ENUM('pending', 'in_transit', 'delivered', 'in_warehouse', 'billed', 'paid') DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE packages MODIFY COLUMN status ENUM('pending', 'in_transit', 'delivered', 'in_warehouse', 'billed') DEFAULT 'pending'");
    }
};
