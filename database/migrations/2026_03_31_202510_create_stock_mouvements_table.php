<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_mouvements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produit_id')->constrained('produits')->cascadeOnDelete();
            $table->foreignId('commande_id')->nullable()->constrained('commandes')->nullOnDelete();
            $table->string('type');
            $table->unsignedInteger('quantite');
            $table->unsignedInteger('stock_avant');
            $table->unsignedInteger('stock_apres');
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_mouvements');
    }
};
