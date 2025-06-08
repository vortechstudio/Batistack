<?php

namespace App\Models\Tiers;

use App\Enum\Tiers\Nature;
use App\Enum\Tiers\Type;
use Illuminate\Database\Eloquent\Model;

class Tiers extends Model
{
    public $timestamps = false;
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'tva' => 'boolean',
            'nature' => Nature::class,
            'type' => Type::class,
        ];
    }
}
