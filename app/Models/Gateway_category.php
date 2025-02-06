<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gateway_category extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'gateway_categories';
    protected $fillable = [
        'category_id',
        'gateway_id'
    ];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
}
