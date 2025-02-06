<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faq extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'faqs';
    protected $fillable = [
        'language',
        'question',
        'answer',
        'filename',
        'status'
    ];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    public function get_faq_country()
    {
            return $this->belongsToMany('App\Models\Country', 'faq_countries', 'faq_id','country_id', 'id', 'id');
    }

    public function get_section_items()
    {
        return $this->belongsToMany('App\Models\Home_section', 'home_section_items', 'item_id', 'section_id', 'id', 'id');
    }
}
