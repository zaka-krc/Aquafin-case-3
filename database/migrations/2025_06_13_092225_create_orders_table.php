<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('order_number')->unique();
            $table->date('requested_delivery_date');
            $table->enum('status', ['pending', 'approved', 'processing', 'delivered', 'cancelled'])->default('pending');
            $table->text('notes')->nullable();
            $table->string('delivery_location')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index('user_id');
            $table->index('status');
            $table->index('requested_delivery_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};