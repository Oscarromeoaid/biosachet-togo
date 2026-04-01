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
        $this->syncProduitsTable();
        $this->syncProductionsTable();
    }

    public function down(): void
    {
        //
    }

    private function syncProduitsTable(): void
    {
        $columnsToAdd = [];

        if (! Schema::hasColumn('produits', 'slug')) {
            $columnsToAdd[] = fn (Blueprint $table) => $table->string('slug')->nullable()->after('id');
        }
        if (! Schema::hasColumn('produits', 'recette')) {
            $columnsToAdd[] = fn (Blueprint $table) => $table->json('recette')->nullable()->after('stock_disponible');
        }
        if (! Schema::hasColumn('produits', 'notes_production')) {
            $columnsToAdd[] = fn (Blueprint $table) => $table->text('notes_production')->nullable()->after('recette');
        }
        if (! Schema::hasColumn('produits', 'sechage_heures_min')) {
            $columnsToAdd[] = fn (Blueprint $table) => $table->unsignedInteger('sechage_heures_min')->nullable()->after('notes_production');
        }
        if (! Schema::hasColumn('produits', 'sechage_heures_max')) {
            $columnsToAdd[] = fn (Blueprint $table) => $table->unsignedInteger('sechage_heures_max')->nullable()->after('sechage_heures_min');
        }
        if (! Schema::hasColumn('produits', 'proprietes')) {
            $columnsToAdd[] = fn (Blueprint $table) => $table->json('proprietes')->nullable()->after('sechage_heures_max');
        }
        if (! Schema::hasColumn('produits', 'usage_ideal')) {
            $columnsToAdd[] = fn (Blueprint $table) => $table->string('usage_ideal')->nullable()->after('proprietes');
        }

        if ($columnsToAdd !== []) {
            Schema::table('produits', function (Blueprint $table) use ($columnsToAdd) {
                foreach ($columnsToAdd as $columnToAdd) {
                    $columnToAdd($table);
                }
            });
        }

        if (! Schema::hasColumn('produits', 'slug')) {
            return;
        }

        $usedSlugs = [];
        $produits = DB::table('produits')->select('id', 'nom', 'slug')->orderBy('id')->get();

        foreach ($produits as $produit) {
            $baseSlug = filled($produit->slug) ? $produit->slug : (Str::slug($produit->nom) ?: 'produit-'.$produit->id);
            $slug = $baseSlug;

            while (in_array($slug, $usedSlugs, true)) {
                $slug = $baseSlug.'-'.$produit->id;
            }

            $usedSlugs[] = $slug;

            DB::table('produits')
                ->where('id', $produit->id)
                ->update(['slug' => $slug]);
        }

        if (! Schema::hasIndex('produits', 'produits_slug_unique', 'unique')) {
            Schema::table('produits', function (Blueprint $table) {
                $table->unique('slug');
            });
        }
    }

    private function syncProductionsTable(): void
    {
        $columnsToAdd = [];

        if (! Schema::hasColumn('productions', 'sachets_petit_transparent')) {
            $columnsToAdd[] = fn (Blueprint $table) => $table->unsignedInteger('sachets_petit_transparent')->default(0)->after('kg_manioc_utilise');
        }
        if (! Schema::hasColumn('productions', 'sachets_moyen_souple')) {
            $columnsToAdd[] = fn (Blueprint $table) => $table->unsignedInteger('sachets_moyen_souple')->default(0)->after('sachets_petit_transparent');
        }
        if (! Schema::hasColumn('productions', 'sachets_grand_solide')) {
            $columnsToAdd[] = fn (Blueprint $table) => $table->unsignedInteger('sachets_grand_solide')->default(0)->after('sachets_moyen_souple');
        }
        if (! Schema::hasColumn('productions', 'film_biodegradable_m2')) {
            $columnsToAdd[] = fn (Blueprint $table) => $table->decimal('film_biodegradable_m2', 8, 2)->default(0)->after('sachets_grand_solide');
        }

        if ($columnsToAdd !== []) {
            Schema::table('productions', function (Blueprint $table) use ($columnsToAdd) {
                foreach ($columnsToAdd as $columnToAdd) {
                    $columnToAdd($table);
                }
            });
        }

        $oldColumns = [
            'sachets_500g' => 'sachets_petit_transparent',
            'sachets_1kg' => 'sachets_moyen_souple',
            'sachets_2kg' => 'sachets_grand_solide',
        ];

        foreach ($oldColumns as $legacyColumn => $newColumn) {
            if (Schema::hasColumn('productions', $legacyColumn) && Schema::hasColumn('productions', $newColumn)) {
                DB::table('productions')->update([
                    $newColumn => DB::raw("CASE WHEN {$newColumn} = 0 THEN {$legacyColumn} ELSE {$newColumn} END"),
                ]);
            }
        }

        $legacyColumnsPresent = collect(array_keys($oldColumns))
            ->filter(fn (string $column) => Schema::hasColumn('productions', $column))
            ->values()
            ->all();

        if ($legacyColumnsPresent !== []) {
            Schema::table('productions', function (Blueprint $table) use ($legacyColumnsPresent) {
                $table->dropColumn($legacyColumnsPresent);
            });
        }
    }
};
