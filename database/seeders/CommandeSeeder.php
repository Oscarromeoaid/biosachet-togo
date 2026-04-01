<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Commande;
use App\Models\Produit;
use App\Services\CommandeService;
use Carbon\CarbonImmutable;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CommandeSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('commande_paiements')->delete();
        DB::table('commande_produit')->delete();
        DB::table('stock_mouvements')->delete();
        Commande::query()->delete();

        $clients = Client::query()->get();
        $produits = Produit::query()->publicCatalog()->get();
        $service = app(CommandeService::class);

        foreach (range(1, 72) as $index) {
            $createdAt = CarbonImmutable::now()->subDays(fake()->numberBetween(0, 89));
            $lines = [];

            foreach ($produits->random(fake()->numberBetween(1, 4)) as $produit) {
                $lines[] = [
                    'produit_id' => $produit->id,
                    'quantite' => fake()->numberBetween(8, 34),
                    'prix_unitaire' => $produit->prix_unitaire,
                ];
            }

            $statut = fake()->randomElement(['en_attente', 'en_attente', 'confirmee', 'livree', 'livree', 'livree', 'annulee']);
            $paiement = match ($statut) {
                'livree' => fake()->randomElement(['paye', 'paye', 'partiel']),
                'annulee' => 'en_attente',
                default => fake()->randomElement(['en_attente', 'partiel']),
            };

            $commande = $service->store([
                'client_id' => $clients->random()->id,
                'statut' => $statut,
                'paiement' => $paiement,
                'methode_paiement' => fake()->randomElement(['cash', 'flooz', 't_money']),
                'date_livraison' => $createdAt->addDays(fake()->numberBetween(1, 7))->toDateString(),
                'produits' => $lines,
            ]);

            $commande->timestamps = false;
            $commande->forceFill([
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ])->save();
        }
    }
}
