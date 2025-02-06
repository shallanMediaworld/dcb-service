<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Privacy_policy extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'privacy_polices';
    protected $fillable = [
        'title',
        'language',
        'description',
    ];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
}

