<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;

class BanqueAggregate extends Model
{
    protected $guarded = [];

    public function accounts(): \Illuminate\Database\Eloquent\Relations\HasMany|BanqueAggregate
    {
        return $this->hasMany(BanqueAggregateAccount::class);
    }

    protected function casts(): array
    {
        return [
            'last_refreshed_at' => 'timestamp'
        ];
    }
}
