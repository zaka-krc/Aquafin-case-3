<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('unit')->default('stuk'); // stuk, meter, kg, etc.
            $table->decimal('price', 10, 2)->nullable();
            $table->string('supplier')->nullable();
            $table->string('article_number')->nullable();
            $table->integer('minimum_stock')->default(0);
            $table->boolean('is_available')->default(true);
            $table->timestamps();
            
            // Indexes voor betere performance
            $table->index('category_id');
            $table->index('is_available');
            $table->index('name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('materials');
    }
};