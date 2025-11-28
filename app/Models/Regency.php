<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Regency extends Model
{
    protected $table = 'indonesia_cities';
    public $timestamps = false;

    protected $fillable = ['code', 'province_code', 'name'];

    public function province()
    {
        return $this->belongsTo(Province::class, 'province_code', 'code');
    }
}
