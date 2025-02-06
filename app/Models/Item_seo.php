<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item_seo extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'item_seos';
    protected $fillable = [
        'ar_meta_title',
        'en_meta_title',
        'ar_meta_description',
        'en_meta_description',
        'ar_meta_keyword',
        'en_meta_keyword',
        'item_id'
    ];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    public function get_item(){
        return $this->hasOne(Item::class,'id','item_id');
    }
}
