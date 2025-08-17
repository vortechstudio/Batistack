<?php

namespace App\Models\Module\Core;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    /** @use HasFactory<\Database\Factories\Module\Core\SettingFactory> */
    use HasFactory;
    protected $guarded = [];

    protected $casts = [
        'expired_at' => 'date',
    ];
}
