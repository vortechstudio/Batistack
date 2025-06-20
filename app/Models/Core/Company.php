<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    public $timestamps = false;
    protected $guarded = [];

    public function info()
    {
        return $this->hasOne(CompanyInfo::class);
    }
}
