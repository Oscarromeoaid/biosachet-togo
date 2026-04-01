<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('commandes', function (Blueprint $table) {
            $table->string('reference')->nullable()->unique()->after('id');
            $table->uuid('suivi_token')->nullable()->unique()->after('reference');
        });

        DB::table('commandes')->orderBy('id')->get()->each(function ($commande): void {
            DB::table('commandes')
                ->where('id', $commande->id)
                ->update([
                    'reference' => 'BST-'.now()->format('Ymd').'-'.str_pad((string) $commande->id, 5, '0', STR_PAD_LEFT),
                    'suivi_token' => (string) Str::uuid(),
                ]);
        });
    }

    public function down(): void
    {
        Schema::table('commandes', function (Blueprint $table) {
            $table->dropUnique(['reference']);
            $table->dropUnique(['suivi_token']);
            $table->dropColumn(['reference', 'suivi_token']);
        });
    }
};
