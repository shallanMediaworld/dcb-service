<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item_slider_country extends Model
{
    use HasFactory;
    protected $table = 'item_slider_countries';
    protected $fillable = [
        'slider_id',
        'country_id',
    ];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    public function get_country()
    {
        return $this->hasOne(Country::class, 'id', 'country_id');

    }
}

