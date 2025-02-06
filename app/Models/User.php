<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

//use Laravel\Sanctum\HasApiTokens;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;
 
    const B2BRULE = 2;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
        'facebook_id',
        'twitter_id',
        'user_image',
        'type',
        'b2b_balance',
        'coins',
        'description',
        'client_id',
        'client_secret',
        'gateway_id',
        'token',
        'active',
	    'code_auth',
        'expire_time',
        'merchant_id',
        'dob',
        'avatar',
        'subscription_id',
        'phone',
        'winner_password',
        'winner_change_password',
        'quantity_failed',
        'reason',
        'status',
        'fcm_id',
        'enable_notification',
        'country_id',
        'country',
        'apple_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    public static function getTableName() {
        return with(new static)->getTable();
    }

    public function get_transaction_history()
    {
        return $this->hasOne(B2b_transaction_history::class, 'user_id', 'id')->latest();
    }

    public function get_gateway()
    {
        return $this->hasOne(Gateway::class, 'id', 'gateway_id');
    }

    public function get_b2b_information()
    {
        return $this->hasOne(B2b_information::class, 'user_id', 'id');
    }
    public function merchant_parent()
    {
        return $this->belongsTo(self::class, 'merchant_id','id');
    }
    public function merchant_children()
    {
        return $this->hasMany(self::class, 'merchant_id','id');
    }

    public function userWallet() {
        return $this->hasOne(User_wallet::class, 'user_id', 'id');
    }

    public function isB2B() : bool
    {
        return $this->type == self::B2BRULE;
    }

}
