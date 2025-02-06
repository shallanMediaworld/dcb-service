<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item_country extends Model
{
    use HasFactory;

    protected $table = 'item_countries';
    protected $fillable = [
        'item_id',
        'country_id',
        'status'
    ];
    protected $hidden = ['pivot'];
    public function get_items()
    {
        return $this->hasOne(Item::class, 'id', 'item_id');
    }

    public function get_country()
    {
        return $this->hasOne(Country::class, 'id', 'country_id');

    }
}
