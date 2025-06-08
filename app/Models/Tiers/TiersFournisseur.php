<?php

namespace App\Models\Tiers;

use App\Models\Core\PlanComptable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TiersFournisseur extends Model
{
    public $timestamps = false;
    protected $guarded = [];

    public function tiers(): BelongsTo
    {
        return $this->belongsTo(Tiers::class);
    }

    public function codeComptabiliteGen(): BelongsTo
    {
        return $this->belongsTo(PlanComptable::class, 'code_comptabilite_gen');
    } 
}
