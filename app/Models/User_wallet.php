<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User_wallet extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'user_wallets';
    protected $fillable = [
        'user_id',
        'gold',
        'silver'
    ];

    public function get_user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function get_user_wallet_log()
    {
        return $this->hasMany(User_wallet_log::class , 'user_wallet_id' , 'id');
    }
}
