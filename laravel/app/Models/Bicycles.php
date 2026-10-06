<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bicycles extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'percentage_of_wear',
        'location_x',
        'location_y',
        'status',
        'path_to_image',
        'category_id',
    ];

    public function category()
    {
        return $this->belongsTo(Categories::class);
    }

    public function booking()
    {
        return $this->hasMany(Booking::class, 'bicycle_id');
    }

    public function tariff()
    {
        return $this->hasManyThrough(Tariffs::class, Categories::class, 'id', 'category_id', 'category_id', 'id')->whereNull('tariffs.deleted_at');
    }
}
