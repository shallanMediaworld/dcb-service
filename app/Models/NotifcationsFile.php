<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotifcationsFile extends Model
{
    use HasFactory;

    protected $table = 'notifcations_files';
    protected $fillable = [
        'title' , 'body' , 'imageUrl' , 'user_id'
    ];

    protected $hidden = ['created_at', 'updated_at'];

}
