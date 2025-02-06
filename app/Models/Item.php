<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Payment\ItemPercentage;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Item extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'items';
    protected $fillable = [
        'ar_name',
        'en_name',
        'sku',
        'ar_description',
        'en_description',
        'cost_price',
        'type',
        'reference_id',
        'sub_category_id',
        'source_id',
        'extras',
		'avatar',
		'old_price'

    ];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at', 'pivot'];

    public static function getTableName()
    {
        return with(new static)->getTable();
    }
    
    public function get_sub_category()
    {
        return $this->hasOne(SubCategory::class, 'id', 'sub_category_id');
    }

    public function get_source()
    {
        return $this->hasOne(Source::class, 'id', 'source_id');
    }

    public function item_country()
    {
        return $this->belongsToMany('App\Models\Country', 'item_countries', 'item_id', 'country_id', 'id', 'id');
    }

    public function get_item_history()
    {
        return $this->hasMany(Item_history::class, 'reference_id', 'reference_id');
    }

    public function get_item_price()
    {
        return $this->hasMany(Item_price::class, 'item_id', 'id');
    }


    public function get_section_items()
    {
        return $this->belongsToMany('App\Models\Home_section', 'home_section_items', 'item_id', 'section_id', 'id', 'id');
    }

    public function get_enabled_item()
    {
        return $this->hasOne('App\Models\Item_country', 'item_id', 'id');
    }

    public function get_price()
    {
        return $this->hasOne(Item_price::class, 'item_id', 'id');
    }

    public function get_item_payment_prices()
    {
        return $this->hasOne('App\Models\PaymentPrices', 'item_id', 'id');
    }


 public function item_card_country()
    {
        return $this->belongsToMany('App\Models\Card_country', 'item_card_countries', 'item_id', 'card_country_id', 'id', 'id');
    }


    public function b2bCartItems() {
        return $this->hasMany(cart_items::class, 'item_id', 'id');
    }

    public function b2bBillOfQuantity() {
        return $this->hasMany(B2BBillOfQuantity::class, 'item_id', 'id');
    }

    public function cardCountry(): BelongsToMany
    {
        return $this->belongsToMany(Card_country::class, 'item_card_countries', 'item_id', 'card_country_id');
    }
}
