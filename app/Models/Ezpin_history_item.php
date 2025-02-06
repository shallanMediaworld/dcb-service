<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ezpin_history_item extends Model
{
    use HasFactory;
    protected $table = 'ezpin_history_items';
    protected $fillable = [
        'sku',
        'upc',
        'title',
        'desc',
        'max_price',
        'min_price'
    ];
    protected $hidden = ['created_at', 'updated_at'];
}
