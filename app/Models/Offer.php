<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Offer extends Model
{
    use HasFactory;

    protected $table = 'offers';
    protected $fillable = [
        'item_id',
        'country_id',
        'percenatge'
    ];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    public function get_country(){
        return $this->hasOne(Country::class,'id','country_id');
    }

    public function get_item(){
        return$this->hasOne(Item::class,'id','item_id');
    }
}
