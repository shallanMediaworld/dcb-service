<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class B2b_transaction_history extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'b2b_transaction_histories';
    protected $fillable = [
        'user_id',
        'transaction_value',
        'old_balance',
	'transaction_bank_id',
	'updated_status',
	 'description'
    ];

    public function get_user()
    {
        return $this->hasOne(User::class , 'id' , 'user_id');
    }


}
