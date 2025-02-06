<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class B2b_information extends Model
{
    use HasFactory;

    protected $table = 'b2b_informations';
    protected $fillable = [
        'user_id',
        'block',
        'balance_limit',
        'daily_limit'
    ];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
}

