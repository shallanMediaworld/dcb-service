<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Sale extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'sales';
    protected $cast =['charging'=>"boolean"];
//    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    protected $fillable = [
        'item_id',
        'status',
        'user_id',
        'discount',
        'gateway_id',
        'voucher',
        'msisdn',
        'email',
        'visa_checkout_id',
        'cost_price',
        'media_world_percentage',
        'operator_percentage',
        'partner_percentage_1',
        'partner_percentage_2',
        'tax_1',
        'tax_2',
        'currency_factor',
        'final_price_usd',
        'final_price_country_currency',
        'sale_price',
        'order_id',
        'source_id',
        'silver',
        'balance_before_transaction',
        'serial_number',
        'cart_item_id',
        'transaction_id',
        'charging'
    ];

    public static function getTableName() {
        return with(new static)->getTable();
    }

    public function get_item()
    {
        return $this->hasMany(Item::class, 'id', 'item_id');
    }

      public function get_items()
    {
        return $this->hasOne(Item::class, 'id', 'item_id');
    }

    public function get_gateway()
    {
        return $this->hasOne(Gateway::class, 'id', 'gateway_id');
    }
    
    public function get_user_wallet()
    {
        return $this->hasOne(User_wallet::class, 'user_id', 'user_id');
    }

    public function get_user_wallet_log()
    {
        return $this->hasOne(User_wallet_log::class, 'sale_id', 'id');
    }
    
        
    public function users()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function cart_item() {
        return $this->belongsTo(cart_items::class, 'cart_item_id', 'id');
    }


    public static function saleCount($user_id)
    {
        $result = Sale::select(
            DB::raw('COUNT(IF(status = "Success", id, null)) AS count_success'),
            DB::raw('COUNT(IF(status != "Success", id, null)) AS count_failed')
        )
        ->where('user_id', $user_id)
        ->whereDate('created_at', Carbon::now())
        ->first();

        $one = $result->count_success;
        $failed = $result->count_failed;

        return ($failed < 3 && $one < 3);
    }

    public static function saleCountIraq($phone)
    {
        $result = Sale::select(
            DB::raw('COUNT(IF(status = "Success", id, null)) AS count_success'),
        )
            ->where('msisdn', $phone)
            ->whereDate('created_at', Carbon::now())
            ->first();

        return ($result->count_success < 3);
    }




}
