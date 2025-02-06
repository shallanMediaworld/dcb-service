<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Wallet extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'wallet';
    protected $fillable = [
        'factor',
        'gold',
        'silver',
        'status',
        'silver_for_registration',
        'silver_for_mor_info',
        'silver_for_newsletter',
    ];

    public function getActiveWallet() {
        return $this->Where("status", 1)->first();
    }
}
