<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Oodi_sale extends Model
{
    use HasFactory;

    protected $table = 'oodi_sales';
    protected $fillable = [
        'cost_price',
        'type',
        'status',
        'item_id',
        'sale_price',
        'gateway_id',
        'voucher_num',
        'phone'
    ];
    public function get_item(){
        return $this->hasMany(Item::class, 'id', 'item_id');
    }
    public function get_gateway()
    {
        return $this->hasOne(Gateway::class, 'id', 'gateway_id');
    }
}
