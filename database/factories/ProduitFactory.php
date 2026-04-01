<?php

namespace Database\Factories;

use App\Models\Produit;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProduitFactory extends Factory
{
    protected $model = Produit::class;

    public function definition(): array
    {
        $catalogue = [
            [
                'nom' => 'PETIT SACHET TRANSPARENT',
                'slug' => 'petit-transparent',
                'format' => 'Small',
                'usage_ideal' => 'sucre, arachides, epices, fruits secs',
                'description' => 'Transparent et legerement rigide',
                'prix_unitaire' => 20,
                'cout_revient' => 5,
                'recette' => [
                    'Amidon' => '3 cuilleres',
                    'Eau' => '1 tasse',
                    'Glycerine' => '1/2 cuillere',
                    'Vinaigre' => '1 cuillere',
                ],
                'notes_production' => 'Etaler tres finement. Ne pas trop chauffer. Ajouter 1 cuillere d eau si trop epais.',
                'sechage_heures_min' => 6,
                'sechage_heures_max' => 8,
                'proprietes' => ['transparent', 'semi-rigide'],
            ],
            [
                'nom' => 'SACHET MOYEN SOUPLE',
                'slug' => 'moyen-souple',
                'format' => 'Medium',
                'usage_ideal' => 'pain, beignets, fruits',
                'description' => 'Souple, legerement elastique et resistant',
                'prix_unitaire' => 30,
                'cout_revient' => 7,
                'recette' => [
                    'Amidon' => '3 cuilleres',
                    'Eau' => '1 tasse + 1/4',
                    'Glycerine' => '1 cuillere',
                    'Vinaigre' => '1 cuillere',
                ],
                'notes_production' => 'Etaler plus epais que le modele 1.',
                'sechage_heures_min' => 10,
                'sechage_heures_max' => 12,
                'proprietes' => ['souple', 'resistant'],
            ],
            [
                'nom' => 'GRAND SACHET EPAIS ET SOLIDE',
                'slug' => 'grand-solide',
                'format' => 'Large',
                'usage_ideal' => 'shopping bag, transport de courses (2 a 4 kg)',
                'description' => 'Epais, resistant, maniable - type sac de courses',
                'prix_unitaire' => 50,
                'cout_revient' => 12,
                'recette' => [
                    'Amidon' => '4 cuilleres',
                    'Eau' => '1 tasse',
                    'Glycerine' => '1 cuillere + 1/2',
                    'Vinaigre' => '1 cuillere',
                ],
                'notes_production' => 'Etaler en 2 couches superposees. Renforcer les poignees. Option: poudre de charbon fine.',
                'sechage_heures_min' => 12,
                'sechage_heures_max' => 18,
                'proprietes' => ['tres solide', 'professionnel'],
            ],
            [
                'nom' => 'FILM PLASTIQUE BIODEGRADABLE',
                'slug' => 'film-biodegradable',
                'format' => 'Roll/Sheet',
                'usage_ideal' => 'emballage alimentaire, remplacement cellophane, sachets personnalises',
                'description' => 'Ultra fin, transparent, decoupable et scellable',
                'prix_unitaire' => 25,
                'cout_revient' => 6,
                'recette' => [
                    'Amidon' => '2 cuilleres',
                    'Eau' => '1 tasse + 1/2',
                    'Glycerine' => '1/2 cuillere',
                    'Vinaigre' => '1 cuillere',
                ],
                'notes_production' => 'Etaler tres finement sur une surface lisse.',
                'sechage_heures_min' => 6,
                'sechage_heures_max' => 10,
                'proprietes' => ['ultra souple', 'ultra-fin', 'transparent'],
            ],
        ];

        $produit = fake()->randomElement($catalogue);

        return $produit + [
            'slug' => $produit['slug'].'-'.Str::lower(fake()->unique()->lexify('???')),
            'stock_disponible' => fake()->numberBetween(150, 900),
        ];
    }
}
