<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('message_contacts', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('telephone', 8)->nullable();
            $table->string('email')->nullable();
            $table->text('message');
            $table->timestamp('traite_le')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('message_contacts');
    }
};
