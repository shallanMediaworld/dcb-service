<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class partnerhistory extends Model
{

    use HasFactory, SoftDeletes;
    protected $table = 'partnerhistories';
    protected $fillable = [
        'user_id',
        'voucher',
        'price'
    ];
}
