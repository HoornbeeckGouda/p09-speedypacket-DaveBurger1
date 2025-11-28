<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Sender (verzender)
            $table->string('recipient_name');
            $table->string('recipient_email')->nullable();
            $table->string('recipient_phone')->nullable();
            $table->text('recipient_address');
            $table->text('description')->nullable();
            $table->decimal('weight', 8, 2)->nullable(); // in kg
            $table->enum('status', ['pending', 'in_transit', 'delivered'])->default('pending');
            $table->string('tracking_number')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
