<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item_card_country extends Model
{
    use HasFactory;
    protected $table = 'item_card_countries';
    protected $fillable = [
        'item_id',
        'card_country_id',
    ];

    protected $hidden = ['created_at'];

    public function get_item_card()
    {
        return $this->hasOne(Item::class, 'id', 'item_id');

    }

}

