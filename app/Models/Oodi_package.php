<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Oodi_package extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'oodi_packages';
    protected $fillable = [
        'ar_name',
        'en_name'
    ];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

   public function get_packages_items(){
        return $this->belongsToMany('App\Models\Item','oodi_items','package_id','item_id','id', 'id');
   }
}
