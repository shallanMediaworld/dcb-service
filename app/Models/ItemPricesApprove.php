<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemPricesApprove extends Model
{
    use HasFactory;
    protected $table = 'item_prices_approves';
    protected $fillable = [
        'new_source_id',
        'item_id',
        'new_price',
        'status',
        'sku',
        'note',
    ];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    public function get_source(){
        return $this->hasOne(Source::class , 'id' , 'new_source_id');
    }
    public function get_items(){
        return $this->hasOne(Item::class , 'id' , 'item_id');
    }

}