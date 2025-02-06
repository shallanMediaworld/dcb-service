<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Whitelist extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'whitelists';
    protected $fillable = [
        'user_id' ,
        'ip'
    ];

    public function get_user()
    {
        return $this->hasOne(User::class , 'id' , 'user_id');
    }
}
