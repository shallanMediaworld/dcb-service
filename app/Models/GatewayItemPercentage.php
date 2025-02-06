<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GatewayItemPercentage extends Model
{
    use HasFactory;

    protected $table = 'gateway_item_percentages';
    protected $fillable = [
        'gateway_id',
        'item_id',
        'percentage'
    ];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    public function get_items()
    {
        return $this->hasOne(Item::class, 'id', 'item_id');
    }

    public function get_gateway()
    {
        return $this->hasOne(Gateway::class, 'id', 'gateway_id');

    }
}
