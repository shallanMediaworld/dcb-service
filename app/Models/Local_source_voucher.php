<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Local_source_voucher extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'local_source_vouchers';
    protected $fillable = [
        'source_id',
        'item_id',
        'voucher',
        'serial_number',
    ];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function get_source()
    {
        return $this->hasOne(Source::class, 'id' , 'source_id');
    }

    public function get_item()
    {
        return $this->hasOne(Item::class, 'id' , 'item_id');
    }


}
