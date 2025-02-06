<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Partner_history extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'partner_histories';
    protected $fillable = [
        'user_id',
        'voucher',
        'price'
    ];
}
