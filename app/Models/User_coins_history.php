<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User_coins_history extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'user_coins_historeis';
    protected $fillable = [
        'user_id' ,
        'offer_coins_id'
    ];

    public function get_user_coins()
    {
        return $this->hasOne(User::class , 'id' , 'user_id');
    }

    public function get_offer_coins()
    {
        return $this->hasMany(Offer_coin::class, 'id', 'offer_coins_id');
    }
}
