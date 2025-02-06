<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zaincash extends Model
{
    use HasFactory;
    protected $table = 'zaincashes';
    public $timestamps = true;
    protected $fillable = [
        'transaction_id',
        'source',
        'type',
        'amount',
        'to',
        'serviceType',
        'lang',
        'orderId',
        'currencyConversion',
        'referenceNumber',
        'redirectUrl',
        'credit',
        'status',
        'reversed',
        'driver',
        'createdAt',
        'updatedAt',
    ];
}
