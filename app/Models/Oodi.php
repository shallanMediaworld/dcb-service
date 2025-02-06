<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Oodi extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'oodis';
    protected $fillable = [
        'username',
        'password'
    ];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    const GATEWAY_ID = 3;
}
