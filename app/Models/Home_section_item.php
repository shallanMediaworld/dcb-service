<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Home_section_item extends Model
{
    use HasFactory;

    protected $table = 'home_section_items';
    protected $fillable = [
        'item_id',
        'section_id'
    ];
    protected $hidden = ['created_at', 'updated_at', 'deleted_at','pivot'];
    public function check_item_country()
    {
        return $this->hasMany(Item_country::class, 'item_id', 'item_id');
    }

}
