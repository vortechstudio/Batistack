<?php
return [
    [
        'name' => "Accueil",
        'slug' => 'core',
        'icon' => 'fa-home',
        'url' => '/core/dashboard',
        'submenus' => [
            [
                'title' => 'Tableau de bord',
                'slug' => 'core.dashboard',
                'url' => '/core/dashboard',
            ],
            [
                'title' => 'Configuration de la Société',
                'slug' => 'core.settings.company',
                'url' => '/core/settings/company',
            ],
            [
                'title' => 'Banque',
                'slug' => 'core.settings.banque',
                'url' => '/core/settings/banque',
            ],
        ]
    ],
    [
        'name' => "Tiers",
        'slug' => 'tiers',
        'icon' => 'fa-users',
        'url' => '/tiers/dashboard',
        'submenus' => [
            [
                'title' => 'Tableau de bord',
                'slug' => 'tiers.dashboard',
                'url' => '/tiers/dashboard',
            ],
            [
                'title' => 'Fournisseurs',
                'slug' => 'tiers.fournisseur.index',
                'url' => '/tiers/fournisseur',
            ],
            [
                'title' => 'Clients',
                'slug' => 'tiers.client.index',
                'url' => '/tiers/client',
            ],
        ]
    ]
];
