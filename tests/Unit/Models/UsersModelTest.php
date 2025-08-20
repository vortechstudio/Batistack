<?php

use App\Models\User;

test('Verifie que les initials sont bien rendue', function() {
    // Cas 1: Nom complet (prénom et nom)
    $user = User::factory()->create(['name' => 'John Doe']);
    expect($user->initials())->toBe('JD');

    // Cas 2: Un seul mot dans le nom
    $user = User::factory()->create(['name' => 'John']);
    expect($user->initials())->toBe('J');

    // Cas 3: Plus de deux mots dans le nom
    $user = User::factory()->create(['name' => 'John Van Doe']);
    expect($user->initials())->toBe('JV');

    // Cas 4: Nom vide
    $user = User::factory()->create(['name' => '']);
    expect($user->initials())->toBe('');

    // Cas 5: Nom avec espaces multiples
    $user = User::factory()->create(['name' => '  Jane   Doe  ']);
    expect($user->initials())->toBe('JD');

    // Cas 6: Nom avec caractères spéciaux (non testé par la fonction initials, mais pour la robustesse)
    $user = User::factory()->create(['name' => 'Jean-Luc Picard']);
    expect($user->initials())->toBe('JP');
});
