<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Card_country extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'card_countries';
    protected $fillable = [
        'ar_name',
        'en_name',
        'avatar',
        'status',
    ];
    protected $hidden = ['status','created_at', 'updated_at', 'deleted_at'];

    public function get_country() {
        return $this->hasMany(Item_card_country::class, 'card_country_id', 'id');
    }

    public function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class, 'item_card_countries', 'card_country_id', 'item_id');
    }
}

