<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Village extends Model
{
    protected $table = 'indonesia_villages';
    public $timestamps = false;

    protected $fillable = ['code', 'district_code', 'name'];
}
