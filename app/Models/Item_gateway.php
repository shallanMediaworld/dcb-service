<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item_gateway extends Model
{
    use HasFactory;

    protected $table = 'item_gateways';
    protected $fillable = [
        'item_id',
        'gateway_id'
    ];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    public function get_items()
    {
        return $this->hasOne(Item::class, 'id', 'item_id');
    }


    public function get_gateways()
    {
        return $this->hasOne(Gateway::class, 'id', 'gateway_id');
    }
}
