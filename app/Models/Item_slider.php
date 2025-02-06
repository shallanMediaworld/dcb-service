<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item_slider extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'item_sliders';
    protected $fillable = [
        'id',
        'item_id',
        'avatar',
        'avatar_mob',
        'category_id',
        'type',
	'external_link',
    'category_id_sub',
    'avatar_ar',
        'avatar_mob_ar',
    ];
    protected $casts = [
        'category_id'=> 'int'
        ];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    public function get_item(){
        return $this->hasOne(Item::class,'id','item_id');
    }
    public function get_category(){
        return $this->hasOne(Category::class,'id','category_id');
    }
    public function get_slider_country()
    {
        return $this->belongsToMany('App\Models\Country', 'item_slider_countries', 'slider_id','country_id', 'id', 'id');
    }
}

