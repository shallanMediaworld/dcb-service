<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZainTransation extends Model
{
    use HasFactory;
    protected $table = 'zain_transations';
    public $timestamps = true;
    protected $fillable = [
        'transaction_id',
    ];
}
