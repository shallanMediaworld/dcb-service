<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User_wallet_log extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'user_wallet_logs';
    protected $fillable = [
        'user_wallet_id',
        'sale_id',
        'wallet_id',
        'gold_after_transaction',
        'gold_before_transaction',
        'silver_after_transaction',
        'silver_before_transaction',
        'status',
        'voucher_id',

    ];

    public function get_user_wallet()
    {
        return $this->hasOne(User_wallet::class, 'id', 'user_wallet_id');
    }

    public function get_sale()
    {
        return $this->hasMany(Sale::class, 'id', 'sale_id');
    }

    public function get_sale_data()
    {
        return $this->hasOne(Sale::class, 'id', 'sale_id');
    }
}
