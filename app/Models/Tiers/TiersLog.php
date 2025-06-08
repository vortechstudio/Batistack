<?php

namespace App\Models\Tiers;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TiersLog extends Model
{
    protected $guarded = [];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tiers(): BelongsTo
    {
        return $this->belongsTo(Tiers::class);
    }
}
