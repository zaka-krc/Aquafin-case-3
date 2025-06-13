<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // "Bevestigingsmateriaal"
            $table->string('icon')->nullable(); // "🧰"
            $table->text('description')->nullable(); // "voor onderhoud en montage"
            $table->string('color')->default('#3B82F6'); // Voor UI styling
            $table->integer('sort_order')->default(0); // Voor sortering
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};