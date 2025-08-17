<?php

namespace App\Models\Module\Core;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    /** @use HasFactory<\Database\Factories\Module\Core\ModuleFactory> */
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'is_activable' => 'boolean',
        'active' => 'boolean',
    ];
}
