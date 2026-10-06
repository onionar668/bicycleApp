<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'rice_per_min',
        'full_price',
        'rating',
        'userRating',
        'percentage_of_wear',
        'started_at',
        'ended_at',
        'bicycle_id',
        'tariff_id',
        'user_id',
        'promo_code_id',
        'photos'
    ];

    public function bicycle()
    {
        return $this->belongsTo(Bicycles::class);
    }
    public function tariff()
    {
        return $this->belongsTo(Tariffs::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function promoCode()
    {
        return $this->belongsTo(PromoCodes::class);
    }
}
