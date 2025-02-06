<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Oodi_item extends Model
{
    use HasFactory;

    protected $table = 'oodi_items';
    protected $fillable = [
        'package_id',
        'item_id',
        'price'
    ];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    public function get_items()
    {
        return $this->hasOne(Item::class, 'id', 'item_id');
    }

    public function get_package()
    {
        return $this->hasOne(Oodi_package::class, 'id', 'package_id');
    }
}
