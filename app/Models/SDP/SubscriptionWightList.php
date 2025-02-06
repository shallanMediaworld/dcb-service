<?php

namespace App\Models\SDP;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class SubscriptionWightList extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'sdp_subscription_wight_lists';

}
