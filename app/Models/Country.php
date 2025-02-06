<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'countries';
    protected $fillable = [
        'ar_name',
        'en_name',
        'num_code',
        'factor',
        'ar_symbol',
        'en_symbol',
        'view_type',
        'enable_type',
        'iso',
        'flag'
    ];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at','pivot'];

    public static function getTableName() {
        return with(new static)->getTable();
    }

    public function get_gateway(){
        return $this->hasMany(Gateway::class, 'country_id', 'id');

    }

    public function get_gateway_country(){
        return $this->hasOne(Gateway::class, 'country_id', 'id');
    }
}
