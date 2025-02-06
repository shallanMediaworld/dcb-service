<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gateway extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'gateways';
    protected $fillable = [
        'ar_name',
        'en_name',
        'country_id',
        'avatar',
        'status',
        'alias_name'
    ];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public static function getTableName() {
        return with(new static)->getTable();
    }

    public function get_country(){
        return $this->hasOne(Country::class , 'id' , 'country_id');
    }

    public function get_item_gateway()
    {
        return $this->hasOne(Item_gateway::class, 'gateway_id', 'id');
    }
}
