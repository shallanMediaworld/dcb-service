<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Base_categories_brands extends Model
{
    use HasFactory;
    protected $table = 'base_categories_brands';
    protected $fillable = [
        'base_category_id',
        'category_id',
    ];

    protected $hidden = ['created_at'];

    public function get_brand()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');

    }
}
