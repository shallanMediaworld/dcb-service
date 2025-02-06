<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Voucher extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'vouchers';
    public $timestamps = true;
    protected $fillable = [
        'serial_number',
        'pin',
        'status',
        'cost_price',
        'item_id',
        'merchant_id',
        'bill_id',
        'redeem_at',
        'solled_at',
    ];

    public function items()
    {
        return $this->belongsTo('App\Models\Item', 'item_id');
    }
    public function bills()
    {
        return $this->belongsTo('App\Models\Bill', 'bill_id');
    }
    public function merchants()
    {
        return $this->belongsTo('App\Models\User', 'merchant_id');
    }
}
