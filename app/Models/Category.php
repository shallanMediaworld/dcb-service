<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'categories';
    protected $fillable = [
        'ar_name',
        'en_name',
        'ar_description',
        'en_description',
        'position',
        'avatar',
        'light_avatar',
        'status',
        'order_id',
    ];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function categoryCountry()
    {
        return $this->belongsToMany('App\Models\Country', 'category_enables', 'category_id', 'country_id', 'id', 'id');
    }
   public function category_country()
    {
        return $this->belongsToMany('App\Models\Country', 'category_enables', 'category_id', 'country_id', 'id', 'id');
    }

    public function categoryItem()
    {
        return $this->hasMany(SubCategory::class, 'category_id', 'id');

    }

    public function get_sub_category()
    {
        return $this->hasOne(SubCategory::class, 'category_id', 'id');

    }

    public function categoryEnable() {
        return $this->hasMany(Category_enable::class, 'category_id', 'id');
    }
}
