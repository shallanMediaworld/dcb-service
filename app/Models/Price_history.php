<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price_history extends Model
{
    use HasFactory;

    protected $table = 'price_histories';
    protected $fillable = [
        'item_id',
        'old_price',
        'new_price',
        'source_id'
    ];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
}
