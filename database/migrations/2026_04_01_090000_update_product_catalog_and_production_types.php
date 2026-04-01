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
        Schema::table('produits', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('id');
            $table->json('recette')->nullable()->after('stock_disponible');
            $table->text('notes_production')->nullable()->after('recette');
            $table->unsignedInteger('sechage_heures_min')->nullable()->after('notes_production');
            $table->unsignedInteger('sechage_heures_max')->nullable()->after('sechage_heures_min');
            $table->json('proprietes')->nullable()->after('sechage_heures_max');
            $table->string('usage_ideal')->nullable()->after('proprietes');
        });

        $usedSlugs = [];
        $produits = DB::table('produits')->select('id', 'nom')->orderBy('id')->get();

        foreach ($produits as $produit) {
            $baseSlug = Str::slug($produit->nom) ?: 'produit-'.$produit->id;
            $slug = $baseSlug;

            while (in_array($slug, $usedSlugs, true)) {
                $slug = $baseSlug.'-'.$produit->id;
            }

            $usedSlugs[] = $slug;

            DB::table('produits')
                ->where('id', $produit->id)
                ->update(['slug' => $slug]);
        }

        Schema::table('produits', function (Blueprint $table) {
            $table->unique('slug');
        });

        Schema::table('productions', function (Blueprint $table) {
            $table->unsignedInteger('sachets_petit_transparent')->default(0)->after('kg_manioc_utilise');
            $table->unsignedInteger('sachets_moyen_souple')->default(0)->after('sachets_petit_transparent');
            $table->unsignedInteger('sachets_grand_solide')->default(0)->after('sachets_moyen_souple');
            $table->decimal('film_biodegradable_m2', 8, 2)->default(0)->after('sachets_grand_solide');
        });

        DB::table('productions')->update([
            'sachets_petit_transparent' => DB::raw('sachets_500g'),
            'sachets_moyen_souple' => DB::raw('sachets_1kg'),
            'sachets_grand_solide' => DB::raw('sachets_2kg'),
            'film_biodegradable_m2' => 0,
        ]);
    }

    public function down(): void
    {
        Schema::table('produits', function (Blueprint $table) {
            $table->dropUnique(['slug']);
            $table->dropColumn([
                'slug',
                'recette',
                'notes_production',
                'sechage_heures_min',
                'sechage_heures_max',
                'proprietes',
                'usage_ideal',
            ]);
        });

        Schema::table('productions', function (Blueprint $table) {
            $table->dropColumn([
                'sachets_petit_transparent',
                'sachets_moyen_souple',
                'sachets_grand_solide',
                'film_biodegradable_m2',
            ]);
        });
    }
};
