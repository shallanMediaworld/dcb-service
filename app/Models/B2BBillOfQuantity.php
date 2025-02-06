<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class B2BBillOfQuantity extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'b2b_bill_of_quantities';

    protected $fillable = [
        "item_id",
        "cart_id",
        "quantity",
        "fullfilled_quantity",
        "cost",
        "number_of_retry",
        "payment_percentage"
    ];

    public static function getTableName()
    {
        return with(new static)->getTable();
    }

    public function item() {
        return $this->belongsTo(Item::class, 'item_id', 'id');
    }

    public function cart() {
        return $this->belongsTo(cart::class, 'cart_id', 'id');
    }
}
