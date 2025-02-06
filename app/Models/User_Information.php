<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User_Information extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'user_informations';
    protected $hidden = ['created_at', 'updated_at','deleted_at'];
    protected $fillable = [
        'user_id',
        'sale_id',
        'ip_address',
        'data',
    ];
    protected $casts = [
        'data' => 'array'
    ];

    public function get_user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function get_sale()
    {
        return $this->hasMany(Sale::class, 'id', 'sale_id');
    }
}
