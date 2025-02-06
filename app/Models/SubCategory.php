<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'sub_categories';
    protected $fillable = [
        'ar_name',
        'en_name',
        'ar_description',
        'en_description',
        'category_id',
        'status',
        'avatar',
        'product_id',
        'mo_price_point_id',
        'ar_terms_condition',
        'en_terms_condition',
        'ar_link_content',
        'en_link_content',
        'type',
        'url_name',
        'ar_meta_title',
        'en_meta_title',
        'ar_meta_description',
        'en_meta_description',
        'ar_meta_keyword',
        'en_meta_keyword',
    ];
    protected $hidden = ['status','created_at', 'updated_at', 'deleted_at'];

    public static function getTableName() {
        return with(new static)->getTable();
    }

    public function get_category(){
        return $this->hasOne('App\Models\Category','id','category_id');

    }

    public function get_categories()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');

    }
    public function get_sub_items()
    {
        return $this->hasOne(Item::class, 'sub_category_id', 'id');
    }

    public function get_sub_items2()
    {
        return $this->hasOne(Item::class, 'sub_category_id', 'id');
    }


    public function get_items()
    {
        return $this->hasMany(Item::class, 'sub_category_id', 'id');
    }

    public function category() {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    
}
