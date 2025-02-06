<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Base_category extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'base_categories';
    protected $fillable = [
        'ar_name',
        'en_name',
        'avatar',
        'light_avatar',
        'status',
    ];
    protected $hidden = ['status','created_at', 'updated_at', 'deleted_at'];

    public function get_brand_country()
    {
        return $this->belongsToMany('App\Models\Country', 'base_categories_countries', 'base_category_id','country_id', 'id', 'id');
    }
    public function get_brand_category()
    {
        return $this->belongsToMany('App\Models\Category', 'base_categories_brands', 'base_category_id','category_id', 'id', 'id');
    }
    public function get_sub_category()
    {
        return $this->belongsToMany('App\Models\SubCategory', 'base_categories_brands', 'base_category_id','category_id', 'id', 'id');
    }
}
