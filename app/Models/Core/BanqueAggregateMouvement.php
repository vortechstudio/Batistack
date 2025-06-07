<?php

namespace App\Models\Core;

use App\Enum\Core\BankOperationType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BanqueAggregateMouvement extends Model
{
    protected $guarded = [];
    public function banqueAggregateAccount(): BelongsTo
    {
        return $this->belongsTo(BanqueAggregateAccount::class);
    }

    protected function casts(): array
    {
        return [
            'future' => 'boolean',
            'operation_type' => BankOperationType::class,
        ];
    }
}
