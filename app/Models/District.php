<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    // tabel dari laravolt
    protected $table = 'indonesia_districts';
    public $timestamps = false;

    protected $fillable = ['code', 'city_code', 'name'];
}
