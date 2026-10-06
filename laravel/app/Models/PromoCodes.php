<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PromoCodes extends Model
{
    protected $fillable = [
        'code',
        'discount_percent',
        'free_minutes',
        'expires_at',
        'category_id',
    ];

    public function category()
    {
        return $this->belongsTo(Categories::class);
    }
}
