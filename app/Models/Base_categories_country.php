<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Base_categories_country extends Model
{
    use HasFactory;
    protected $table = 'base_categories_countries';
    protected $fillable = [
        'base_category_id',
        'country_id',
    ];

    protected $hidden = ['created_at'];

    public function get_country()
    {
        return $this->hasOne(Country::class, 'id', 'country_id');

    }

}
