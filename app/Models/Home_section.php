<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Home_section extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'home_sections';
    protected $fillable = [
        'ar_name',
        'en_name',
        'country_id',
        'status'
    ];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at','pivot'];
    public function get_country()
    {
        return $this->hasOne(Country::class, 'id', 'country_id');
    }

    public function get_section_items()
    {
        return $this->belongsToMany('App\Models\Item', 'home_section_items', 'section_id', 'item_id', 'id', 'id');
    }
}
