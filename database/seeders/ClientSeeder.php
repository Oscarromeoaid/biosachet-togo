<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ClientSeeder extends Seeder
{
    public function run(): void
    {
        $clients = [
            ['nom' => 'Marche Adidogome', 'telephone' => '93001122', 'email' => 'adidogome@client.tg', 'type' => 'commerce', 'ville' => 'Lome'],
            ['nom' => 'Restaurant Saveurs du Golfe', 'telephone' => '93002233', 'email' => 'saveurs@client.tg', 'type' => 'restaurant', 'ville' => 'Lome'],
            ['nom' => 'Pharmacie Esperance', 'telephone' => '93003344', 'email' => 'pharmacie@client.tg', 'type' => 'pharmacie', 'ville' => 'Lome'],
            ['nom' => 'ONG Terre Propre Togo', 'telephone' => '93004455', 'email' => 'ong@client.tg', 'type' => 'ong', 'ville' => 'Tsevie'],
            ['nom' => 'Grossiste Maritime', 'telephone' => '93005566', 'email' => 'grossiste@client.tg', 'type' => 'grossiste', 'ville' => 'Lome'],
            ['nom' => 'Boutique Agri Plus', 'telephone' => '93006677', 'email' => null, 'type' => 'commerce', 'ville' => 'Atakpame'],
            ['nom' => 'Restaurant Akoume House', 'telephone' => '93007788', 'email' => null, 'type' => 'restaurant', 'ville' => 'Kara'],
            ['nom' => 'Export West Green', 'telephone' => '93008899', 'email' => 'export@client.tg', 'type' => 'export', 'ville' => 'Lome'],
            ['nom' => 'Pharmacie Centrale Kara', 'telephone' => '93009911', 'email' => null, 'type' => 'pharmacie', 'ville' => 'Kara'],
            ['nom' => 'Cooperative Femmes Solidaires', 'telephone' => '93001234', 'email' => 'cooperative@client.tg', 'type' => 'ong', 'ville' => 'Sokode'],
            ['nom' => 'Superette Wuiti Nord', 'telephone' => '93004567', 'email' => 'wuiti@client.tg', 'type' => 'commerce', 'ville' => 'Lome'],
            ['nom' => 'Restaurant Horizon Plage', 'telephone' => '93007890', 'email' => null, 'type' => 'restaurant', 'ville' => 'Lome'],
            ['nom' => 'ONG Jeunesse Verte', 'telephone' => '93002345', 'email' => 'jeunesse.verte@client.tg', 'type' => 'ong', 'ville' => 'Kpalime'],
            ['nom' => 'Pharmacie Nouvelle Vie', 'telephone' => '93006789', 'email' => null, 'type' => 'pharmacie', 'ville' => 'Atakpame'],
            ['nom' => 'Grossiste Union Maritime', 'telephone' => '93003456', 'email' => null, 'type' => 'grossiste', 'ville' => 'Lome'],
            ['nom' => 'Export Savane Trade', 'telephone' => '93005678', 'email' => 'savane.trade@client.tg', 'type' => 'export', 'ville' => 'Kara'],
            ['nom' => 'Boutique Campus Sud', 'telephone' => '93008901', 'email' => null, 'type' => 'commerce', 'ville' => 'Lome'],
            ['nom' => 'Restaurant Jardin Bio', 'telephone' => '93009123', 'email' => 'jardin.bio@client.tg', 'type' => 'restaurant', 'ville' => 'Tsevie'],
            ['nom' => 'ONG Clean Coast Togo', 'telephone' => '93001456', 'email' => null, 'type' => 'ong', 'ville' => 'Aneho'],
            ['nom' => 'Pharmacie La Grace', 'telephone' => '93002567', 'email' => 'lagrace@client.tg', 'type' => 'pharmacie', 'ville' => 'Sokode'],
            ['nom' => 'Grossiste Kegue Distribution', 'telephone' => '93003678', 'email' => null, 'type' => 'grossiste', 'ville' => 'Lome'],
            ['nom' => 'Cooperative Agri Femina', 'telephone' => '93004789', 'email' => null, 'type' => 'ong', 'ville' => 'Tsevie'],
            ['nom' => 'Boutique Zongo Market', 'telephone' => '93005890', 'email' => null, 'type' => 'commerce', 'ville' => 'Kara'],
            ['nom' => 'Restaurant Saveurs du Nord', 'telephone' => '93006901', 'email' => null, 'type' => 'restaurant', 'ville' => 'Kara'],
            ['nom' => 'Export Green Route', 'telephone' => '93007123', 'email' => 'green.route@client.tg', 'type' => 'export', 'ville' => 'Lome'],
            ['nom' => 'Pharmacie Avicenne', 'telephone' => '93008234', 'email' => null, 'type' => 'pharmacie', 'ville' => 'Lome'],
            ['nom' => 'Marche Hedzranawoe', 'telephone' => '93009345', 'email' => null, 'type' => 'commerce', 'ville' => 'Lome'],
            ['nom' => 'Groupement Eco Kara', 'telephone' => '93010456', 'email' => 'eco.kara@client.tg', 'type' => 'ong', 'ville' => 'Kara'],
        ];

        foreach ($clients as $index => $data) {
            $userId = null;

            if ($index < 12 && $data['email']) {
                $user = User::query()->updateOrCreate(
                    ['email' => $data['email']],
                    [
                        'name' => $data['nom'],
                        'telephone' => $data['telephone'],
                        'role' => User::ROLE_CLIENT,
                        'email_verified_at' => now(),
                        'password' => Hash::make('password'),
                    ]
                );

                $userId = $user->id;
            }

            Client::query()->updateOrCreate(
                ['nom' => $data['nom']],
                $data + ['user_id' => $userId]
            );
        }
    }
}
