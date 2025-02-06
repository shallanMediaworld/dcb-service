<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item_price extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'item_prices';
    protected $fillable = [
        'item_id',
        'country_id',
        'price',
        'gateway_id'
    ];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
}
