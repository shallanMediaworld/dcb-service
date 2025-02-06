<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq_country extends Model
{
    use HasFactory;
    protected $table = 'faq_countries';
    protected $fillable = [
        'faq_id',
        'country_id',
        'status'
    ];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];
    public function get_one_country()
    {
        return $this->hasOne(Country::class, 'id', 'country_id');

    }
}
