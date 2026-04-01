<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('productions', function (Blueprint $table) {
            $table->id();
            $table->date('date')->unique();
            $table->decimal('kg_manioc_utilise', 8, 2);
            $table->unsignedInteger('sachets_500g')->default(0);
            $table->unsignedInteger('sachets_1kg')->default(0);
            $table->unsignedInteger('sachets_2kg')->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('productions');
    }
};
