<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_cart extends Model
{
    use HasFactory;

    protected $table = 'user_cart';
    
    protected $casts = [
        'group_id' => 'integer',
    ];

    protected $fillable = [
        'user_id',
        'item_id',
        'quantity',
        'total_price',
        'country_id',
        'group_id',
        'is_avalible',
        'reason_unavailable',
        'payment_channel_id'
        
    ];
    public function get_items_cart() {
        return $this->hasMany(Item::class, 'id', 'item_id');
    }

    public function items() {
        return $this->hasOne(Item::class, 'id', 'item_id');
    }
    public static function getTableNameCart() {
        return with(new static)->getTable();
    }
}
