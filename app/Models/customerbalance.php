<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class customerbalance extends Model
{
    use HasFactory;
    use HasFactory, SoftDeletes;

    protected $table = 'customerbalances';
    protected $fillable = [
        'user_id',
        'balance'
    ];
}
