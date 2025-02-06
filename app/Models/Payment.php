<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $table = 'payments';
    protected $fillable = [
        'source_id',
        'payment_amount',
        'previous_balance',
	'status',
	'note',
	  'current_balance',
      'transaction_bank_number',
    ];
    protected $hidden = ['created_at', 'updated_at'];

    public function get_source_payment()
    {
        return $this->hasOne(Source::class, 'id', 'source_id');
    }
}
