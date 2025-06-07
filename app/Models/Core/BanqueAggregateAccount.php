<?php

namespace App\Models\Core;

use App\Enum\Core\BankAccountType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BanqueAggregateAccount extends Model
{
    protected $guarded = [];
    public function banqueAggregate(): BelongsTo
    {
        return $this->belongsTo(BanqueAggregate::class);
    }

    public function mouvements()
    {
        return $this->hasMany(BanqueAggregateMouvement::class);
    }

    protected function casts(): array
    {
        return [
            'account_type' => BankAccountType::class,
        ];
    }
}
