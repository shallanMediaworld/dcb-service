<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class BaseModel extends Eloquent
{
    use HasFactory;
    protected $connection = 'mongodb';
}
