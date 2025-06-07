<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;

class PlanComptable extends Model
{
    public $timestamps = false;
    protected $guarded = [];

    public function parent()
    {
        return $this->belongsTo(PlanComptable::class, 'parent_id');
    }
}
