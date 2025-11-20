<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seller extends Model
{
    use HasFactory;

    protected $table = 'sellers';

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

    // relasi ke User (login)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
