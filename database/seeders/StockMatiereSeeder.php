<?php

namespace Database\Seeders;

use App\Models\StockMatiere;
use Illuminate\Database\Seeder;

class StockMatiereSeeder extends Seeder
{
    public function run(): void
    {
        StockMatiere::query()->delete();

        $suppliers = [
            'Cooperative Manioc Maritime',
            'AgriTogo Bio',
            'Groupement Femmes de Tsevie',
            'Union des Producteurs de Kpalime',
            'Reseau Agro Eco Zio',
            'Plateforme Rurale Mono',
        ];

        foreach (range(0, 23) as $index) {
            $quantite = fake()->randomFloat(2, 120, 320);

            StockMatiere::query()->create([
                'date_achat' => now()->subDays(92 - ($index * 4))->toDateString(),
                'quantite_kg' => $quantite,
                'cout_total' => round($quantite * fake()->randomFloat(2, 118, 162), 2),
                'fournisseur' => $suppliers[$index % count($suppliers)],
            ]);
        }
    }
}
