<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Social_media extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'social_medias';
    protected $fillable = [
        'instagram',
        'facebook',
    ];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
}
