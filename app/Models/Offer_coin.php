<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Offer_coin extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'offer_coins';
    protected $fillable = [
        'name_ar' ,
        'name_en',
        'description_ar',
        'description_en',
        'coins',
        'gift',
    ];
    protected $hidden = ['created_at', 'updated_at','deleted_at'];

}
