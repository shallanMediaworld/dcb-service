<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer_care extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'customer_cares';
    protected $fillable = [
        'username',
        'password',
        'gateway_id'
    ];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    public function get_gateway()
    {
        return $this->hasOne(Gateway::class, 'id', 'gateway_id');
    }
}
