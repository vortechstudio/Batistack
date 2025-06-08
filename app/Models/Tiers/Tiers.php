<?php

namespace App\Models\Tiers;

use App\Enum\Tiers\Nature;
use App\Enum\Tiers\Type;
use Illuminate\Database\Eloquent\Model;

class Tiers extends Model
{
    public $timestamps = false;
    protected $guarded = [];

    public function addresses(): Tiers|\Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(TiersAddress::class);
    }

    public function banques(): Tiers|\Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(TiersBanque::class);
    }

    public function client(): \Illuminate\Database\Eloquent\Relations\HasOne|Tiers
    {
        return $this->hasOne(TiersClient::class);
    }

    public function fournisseur(): \Illuminate\Database\Eloquent\Relations\HasOne|Tiers
    {
        return $this->hasOne(TiersFournisseur::class);
    }

    public function contacts(): Tiers|\Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(TiersContact::class);
    }

    protected function casts(): array
    {
        return [
            'tva' => 'boolean',
            'nature' => Nature::class,
            'type' => Type::class,
        ];
    }
}
