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
        Schema::table('orders', function (Blueprint $table) {
            // Renommer total en total_amount si la colonne total existe
            if (Schema::hasColumn('orders', 'total') && !Schema::hasColumn('orders', 'total_amount')) {
                $table->renameColumn('total', 'total_amount');
            }
            
            // Ajouter les statuts manquants
            $table->enum('status', ['pending', 'processing', 'shipped', 'delivered', 'cancelled', 'paid', 'payment_failed'])->default('pending')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Renommer total_amount en total
            if (Schema::hasColumn('orders', 'total_amount')) {
                $table->renameColumn('total_amount', 'total');
            }
            
            // Remettre les statuts originaux
            $table->enum('status', ['pending', 'processing', 'shipped', 'delivered', 'cancelled'])->default('pending')->change();
        });
    }
}; 