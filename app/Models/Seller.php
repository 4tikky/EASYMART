<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    protected $fillable = [
        'user_id',
        'storeName',
        'storeDescription',
        'picName',
        'picPhone',
        'picEmail',
        'picStreet',
        'picRT',
        'picRW',
        'picVillage',
        'picCity',
        'picProvince',
        'picKtpNumber',
        'picPhotoPath',
        'picKtpFilePath',
        'status',
    ];
}
