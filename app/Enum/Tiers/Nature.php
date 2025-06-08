<?php

namespace App\Enum\Tiers;

enum Nature: string
{
    case FOURNISSEUR = 'fournisseur';
    case CLIENT = 'client';
    case PROSPECT = 'prospect';

    public function label():string
    {
        return match ($this) {
            self::FOURNISSEUR => 'F',
            self::CLIENT => 'C',
            self::PROSPECT => 'P',
        };
    }

    public function color()
    {
        return match ($this) {
            self::FOURNISSEUR => 'danger',
            self::CLIENT => 'primary',
            self::PROSPECT => 'info',
        };
    }
}
