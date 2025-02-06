<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item_enable extends Model
{
    use HasFactory;

    protected $table = 'item_enables';
    protected $fillable = [
        'item_id',
        'gateway_id'
    ];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
}
