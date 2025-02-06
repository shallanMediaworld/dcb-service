<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gateway_percentage extends Model
{
    use HasFactory;
    protected $table = 'gateway_percentages';
    protected $fillable = [
        'name',
        'gateway_id',
        'percentage'
    ];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
}
