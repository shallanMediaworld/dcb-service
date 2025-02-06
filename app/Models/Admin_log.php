<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Admin_log extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'admin_log';
    protected $fillable = [
        'name_of_table',
        'table_id',
        'user_id',
        'action',
        'value_before',
        'value_after'
    ];

    public function get_user_name(){
        return $this->hasOne(Admin::class, 'id', 'user_id');
    }

}

