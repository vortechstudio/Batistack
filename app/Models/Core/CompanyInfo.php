<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;

class CompanyInfo extends Model
{
    public $timestamps = false;
    protected $guarded = [];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    protected function casts(): array
    {
        return [
            'tva' => 'boolean',
        ];
    }
}
