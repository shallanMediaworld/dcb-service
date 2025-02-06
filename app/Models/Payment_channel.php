<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment_channel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'payment_channels';
    protected $fillable = [
        'gateway_id',
        'method_id',
        'country_id',
        'from',
        'to'
    ];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    const GATEWAY_TOTAL_CALC = [
        4 => 1.16,
        5 => 1.1
    ];
    public function totalPriceGateway($gateway_id, $total)
    {

        $number = (array_key_exists($gateway_id, self::GATEWAY_TOTAL_CALC)) ? self::GATEWAY_TOTAL_CALC[$gateway_id] : 1;
        return number_format($total * $number, 2, ".", "");
    }

    public function  gateway()
    {
        return $this->hasOne(Gateway::class, 'id', 'gateway_id');
    }

    public function get_gateway_payment()
    {
        return $this->hasOne(Gateway::class, 'id', 'gateway_id');
    }
    public function get_method()
    {
        return $this->hasOne(Method::class, 'id', 'method_id');
    }
    public function get_payment_country()
    {
        return $this->hasOne(Country::class, 'id', 'country_id');
    }

    public function get_payment_prices()
    {
        return $this->hasOne(PaymentPrices::class, 'payment_channel_id', 'id');
    }

    public function get_payments_prices()
    {
        return $this->hasMany(PaymentPrices::class, 'payment_channel_id', 'id');
    }

    public function itemPercentages()
    {
        return $this->hasMany(ItemPercentage::class, 'payment_channel_id', 'id');
    }

    public function getPriceUserCart($userCart, $payment_channel_id)
    {
        return getPriceItems($userCart, $payment_channel_id);
    }
}
