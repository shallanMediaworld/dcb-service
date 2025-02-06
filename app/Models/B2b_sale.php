<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class B2b_sale extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'b2b_sales';
    protected $fillable = [
        'user_id',
        'voucher',
        'balance_before_transaction',
        'item_id',
	'order_id',
	'total'
    ];

    public function get_item()
    {
        return $this->hasOne(Item::class, 'id', 'item_id');
    }
     public function users()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
