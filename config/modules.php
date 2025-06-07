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
];
