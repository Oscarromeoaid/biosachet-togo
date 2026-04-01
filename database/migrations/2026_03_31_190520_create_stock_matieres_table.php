<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_matieres', function (Blueprint $table) {
            $table->id();
            $table->date('date_achat');
            $table->decimal('quantite_kg', 10, 2);
            $table->decimal('cout_total', 12, 2);
            $table->string('fournisseur');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_matieres');
    }
};
