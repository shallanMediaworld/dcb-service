<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class cart extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'carts';

    protected $fillable = [
        'user_id',
        'status',
        'total_amount',
        'returned_amount',
        'balance_after_transaction',
        'description'
    ];

    public static function getTableName()
    {
        return with(new static)->getTable();
    }

    const PENDING = "pending";
    const IN_PROGRESS = "in_progress";
    const PARTIALLY_COMPLETED = "partially_completed";
    const COMPLETED = "completed";

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    
    public function get_cart_items()
    {
        return $this->hasMany(cart_items::class, 'cart_id' , 'id');
    }
    
    public function b2bBillOfQuantity() {
        return $this->hasMany(B2BBillOfQuantity::class, 'cart_id', 'id');
    }

    public static function getStatus() : array {
        return [
            self::PENDING,
            self::IN_PROGRESS,
            self::PARTIALLY_COMPLETED,
            self::COMPLETED
        ];
    }

    public function getStatusArAttribute() : string {

        $status_ar = "";
        switch( $this->status ) {
            case self::PENDING :
                $status_ar = "قيد الانتظار";
                break;
            case self::IN_PROGRESS :
                $status_ar = "قيد التقدم";
                break;
            case self::PARTIALLY_COMPLETED :
                $status_ar = "أنجزت جزئيا";
                break;
            case self::COMPLETED :
                $status_ar = "مكتمل";
                break;
            default :
                $status_ar = "";
                break;
        }

        return $status_ar;
    }
}
