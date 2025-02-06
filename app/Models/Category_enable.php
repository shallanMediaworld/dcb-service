<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category_enable extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'category_enables';
    protected $fillable = [
        'category_id',
        'country_id',
        'status'
    ];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    public function get_category(){
        return $this->hasOne(Category::class,'id','category_id');
    }
    public function get_country()
    {
        return $this->hasOne(Country::class, 'id', 'country_id');

    }
}
