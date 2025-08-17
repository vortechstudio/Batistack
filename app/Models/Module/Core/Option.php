<?php

namespace App\Models\Module\Core;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    /** @use HasFactory<\Database\Factories\Module\Core\OptionFactory> */
    use HasFactory;
    protected $guarded = [];

    protected $casts = [
        'is_enabled' => 'boolean',
        'expires_at' => 'date',
        'active' => 'boolean',
    ];
}
