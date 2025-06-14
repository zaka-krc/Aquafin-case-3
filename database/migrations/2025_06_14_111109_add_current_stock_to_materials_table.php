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
        Schema::table('materials', function (Blueprint $table) {
            $table->integer('current_stock')->default(0)->after('minimum_stock');
        });
        
        // Set initial stock to be same as minimum stock (or you can set your own values)
        DB::table('materials')->update(['current_stock' => DB::raw('minimum_stock * 2')]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('materials', function (Blueprint $table) {
            $table->dropColumn('current_stock');
        });
    }
};