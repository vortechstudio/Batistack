<?php

namespace App\Enum\Tiers;

enum Type: string
{
    case ADMINISTRATION = "administration";
    case AUTRE = "autre";
    case GRAND_COMPTE = "grand_compte";
    case PME_PMI = "pme_pmi";
    case PARTICULIER = "particulier";
    case TPE = "tpe";

    public function label(): string
    {
        return match ($this) {
            self::ADMINISTRATION => "Administration",
            self::AUTRE => "Autre",
            self::GRAND_COMPTE => "Grand Compte",
            self::PME_PMI => "PME PMI",
            self::PARTICULIER => "Particulier",
            self::TPE => "Tpe",
        };
    }

    public static function array(): array
    {
        return [
            "administration" => "Administration",
            "autre" => "Autre",
            "grand_compte" => "Grand Compte",
            "pme_pmi" => "PME PMI",
            "particulier" => "Particulier",
            "tpe" => "Tpe",
        ];
    }
}
