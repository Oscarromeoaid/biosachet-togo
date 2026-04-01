<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('commandes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->cascadeOnDelete();
            $table->decimal('total', 12, 2)->default(0);
            $table->string('statut')->default('en_attente');
            $table->string('paiement')->default('en_attente');
            $table->string('methode_paiement')->default('cash');
            $table->date('date_livraison')->nullable();
            $table->timestamp('stock_decremente_le')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('commandes');
    }
};
