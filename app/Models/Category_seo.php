<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category_seo extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'category_seos';
    protected $fillable = [
        'ar_meta_title',
        'en_meta_title',
        'ar_meta_description',
        'en_meta_description',
        'ar_meta_keyword',
        'en_meta_keyword',
        'category_id'
    ];

    public function get_categ(){
        return $this->hasOne(Category::class,'id','category_id');
    }
}
