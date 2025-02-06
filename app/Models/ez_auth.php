<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ez_auth extends Model
{
    use HasFactory;
    public $table = 'ez_auths';
    public $fillable = [
        'token',
        'expire_at'
    ];
}
