<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentPrices extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'paymentPrices';
    protected $fillable = [
        'item_id',
        'payment_channel_id',
        'cost_price',
        'percentage',
        'percentage_name',
        'percentage_type',
        'order_id',
        'country_id'
    ];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function get_item()
    {
        return $this->hasOne(Item::class, 'id', 'item_id');
    }

    public function get_payment_channels()
    {
        return $this->hasOne(Payment_channel::class, 'id', 'payment_channel_id');
    }

    public function get_items323()
    {
        return $this->belongsTo(Item::class, 'item_id', 'id');
    }

}
