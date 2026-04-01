<?php

return [
    'tagline' => "L'emballage qui nourrit la terre, pas les decharges",
    'telephone' => env('BIOSACHET_PHONE', '+228 92 31 79 78'),
    'email' => env('BIOSACHET_EMAIL', 'contact@biosachet-togo.tg'),
    'adresse' => env('BIOSACHET_ADDRESS', 'Lome, Togo'),
    'whatsapp' => env('BIOSACHET_WHATSAPP', '22892317978'),
    'admin_login_path' => env('ADMIN_LOGIN_PATH', 'espace-interne/connexion-biosachet'),
    'jobs_created' => 12,
    'partner_schools' => 4,
    'launch_capacity_per_day' => 500,
    'default_cost_per_sachet' => 5,
    'payment_methods' => [
        'cash' => 'Cash',
        'flooz' => 'Flooz',
        't_money' => 'T-Money',
    ],
];
