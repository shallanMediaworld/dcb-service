<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item_history extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'item_histories';
    protected $fillable = [
        'item_id',
        'source_id',
        'price',
        'sku'
    ];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    public function getItems()
    {
        return $this->hasOne(Item::class, 'id', 'item_id');
    }

    public function getSource()
    {
        return $this->hasOne(Source::class, 'id', 'source_id');

    }


}
