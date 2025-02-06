<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Currency extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'currencies';
    protected $fillable = [
        'currency',
        'code',
        'symbol',
        'factor'
    ];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

}

