<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $table = 'indonesia_provinces';
    public $timestamps = false;

    protected $fillable = ['code', 'name'];

    // relasi ke kab/kota (cities)
    public function regencies()
    {
        // indonesia_cities.province_code -> indonesia_provinces.code
        return $this->hasMany(Regency::class, 'province_code', 'code');
    }
}
