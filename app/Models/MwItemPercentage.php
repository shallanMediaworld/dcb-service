<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MwItemPercentage extends Model
{
    use HasFactory;

    protected $table = 'mw_item_percentages';
    protected $fillable = [
        'item_id',
        'country_id',
        'percentage',
    ];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
}
