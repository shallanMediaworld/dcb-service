<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class cart_items extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'cart_items';
    protected $fillable = [
        'item_id',
        'cart_id',
        'status',
        'response',
        'payment_percentage'
    ];
    public static function getTableName()
    {
        return with(new static)->getTable();
    }

    public function get_item()
    {
        return $this->hasOne(Item::class, 'id', 'item_id');
    }
    public function get_sale()
    {
        return $this->hasOne(Sale::class, 'cart_item_id', 'id');
    }

    const REQUESTED = "requested";
    const IN_PROGRESS = "in_progress";
    const SUCCESS = "success";
    const FAILED = "failed";
    public function item() {
        return $this->belongsTo(Item::class, 'item_id', 'id');
    }
    public function cart() {
        return $this->belongsTo(cart::class, 'cart_id', 'id');
    }
    public function sale() {
        return $this->hasOne(Sale::class, 'cart_item_id', 'id');
    }
    public static function getStatus() : array {
        return [
            self::IN_PROGRESS,
            self::SUCCESS,
            self::FAILED
        ];
    }
    public function getStatusArAttribute() : string {
        $status_ar = "";
        switch( $this->status ) {
            case self::IN_PROGRESS :
                $status_ar = "قيد التقدم";
                break;
            case self::SUCCESS :
                $status_ar = "نجاح";
                break;
            case self::FAILED :
                $status_ar = "فشل";
                break;
            default :
                $status_ar = "";
                break;
        }

        return $status_ar;
    }
}
