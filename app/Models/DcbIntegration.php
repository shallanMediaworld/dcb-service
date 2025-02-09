<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class DcbIntegration extends BaseModel
{
    use HasFactory;

    protected $collection = 'dcb_integration';
    protected $fillable = ['api_key', 'channel_id'];

}
