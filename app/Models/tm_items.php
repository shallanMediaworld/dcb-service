<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class tm_items extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tm_items';
    protected $fillable = [
        'item_id',
        'code',
        'status'
    ];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
}
