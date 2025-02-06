<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reward_item extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'reward_items';
    protected $fillable = [
        'reward_id',
        'item_id'
    ];


    public function get_item()
    {
        return $this->hasOne(Item::class, 'id', 'item_id');
    }

    public function get_reward()
    {
        return $this->hasOne(Reward::class, 'id', 'reward_id');
    }
}
