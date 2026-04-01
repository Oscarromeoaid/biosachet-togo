<?php

namespace Database\Seeders;

use App\Models\Produit;
use Illuminate\Database\Seeder;

class ProduitSeeder extends Seeder
{
    public function run(): void
    {
        $produits = [
            [
                'nom' => 'PETIT SACHET TRANSPARENT',
                'slug' => 'petit-transparent',
                'usage_ideal' => 'sucre, arachides, epices, fruits secs',
                'description' => 'Transparent et legerement rigide',
                'format' => 'Small',
                'prix_unitaire' => 20,
                'cout_revient' => 5,
                'stock_disponible' => 4800,
                'recette' => [
                    'Amidon' => '3 cuilleres',
                    'Eau' => '1 tasse',
                    'Glycerine' => '1/2 cuillere (moins pour rigidite)',
                    'Vinaigre' => '1 cuillere',
                ],
                'notes_production' => 'Etaler tres finement. Ne pas trop chauffer (risque d opacite). Ajouter 1 cuillere d eau si trop epais.',
                'sechage_heures_min' => 6,
                'sechage_heures_max' => 8,
                'proprietes' => ['Transparent', 'Semi-rigide'],
            ],
            [
                'nom' => 'SACHET MOYEN SOUPLE',
                'slug' => 'moyen-souple',
                'usage_ideal' => 'pain, beignets, fruits',
                'description' => 'Souple, legerement elastique et resistant',
                'format' => 'Medium',
                'prix_unitaire' => 30,
                'cout_revient' => 7,
                'stock_disponible' => 4200,
                'recette' => [
                    'Amidon' => '3 cuilleres',
                    'Eau' => '1 tasse + 1/4',
                    'Glycerine' => '1 cuillere (plus pour souplesse)',
                    'Vinaigre' => '1 cuillere',
                ],
                'notes_production' => 'Etaler plus epais que le modele 1.',
                'sechage_heures_min' => 10,
                'sechage_heures_max' => 12,
                'proprietes' => ['Souple', 'Resistant'],
            ],
            [
                'nom' => 'GRAND SACHET EPAIS ET SOLIDE',
                'slug' => 'grand-solide',
                'usage_ideal' => 'shopping bag, transport de courses (2 a 4 kg)',
                'description' => 'Epais, resistant, maniable - type sac de courses',
                'format' => 'Large',
                'prix_unitaire' => 50,
                'cout_revient' => 12,
                'stock_disponible' => 2600,
                'recette' => [
                    'Amidon' => '4 cuilleres',
                    'Eau' => '1 tasse',
                    'Glycerine' => '1 cuillere + 1/2',
                    'Vinaigre' => '1 cuillere',
                ],
                'notes_production' => 'Etaler en 2 couches superposees (double epaisseur). Renforcer les poignees avec 2 bandes de bioplastique collees. Option: ajouter 1 cuillere de poudre de charbon fine pour solidite.',
                'sechage_heures_min' => 12,
                'sechage_heures_max' => 18,
                'proprietes' => ['Resistant', 'Tres solide', 'Aspect professionnel'],
            ],
            [
                'nom' => 'FILM PLASTIQUE BIODEGRADABLE',
                'slug' => 'film-biodegradable',
                'usage_ideal' => 'emballage alimentaire, remplacement cellophane, sachets personnalises',
                'description' => 'Ultra fin, transparent, decoupable et scellable',
                'format' => 'Roll/Sheet',
                'prix_unitaire' => 25,
                'cout_revient' => 6,
                'stock_disponible' => 3600,
                'recette' => [
                    'Amidon' => '2 cuilleres',
                    'Eau' => '1 tasse + 1/2',
                    'Glycerine' => '1/2 cuillere',
                    'Vinaigre' => '1 cuillere',
                ],
                'notes_production' => 'Etaler tres finement sur une surface lisse.',
                'sechage_heures_min' => 6,
                'sechage_heures_max' => 10,
                'proprietes' => ['Ultra-fin', 'Transparent', 'Souple'],
            ],
        ];

        Produit::query()
            ->whereNotIn('slug', collect($produits)->pluck('slug')->all())
            ->delete();

        foreach ($produits as $produit) {
            Produit::query()->updateOrCreate(
                ['slug' => $produit['slug']],
                $produit
            );
        }
    }
}
