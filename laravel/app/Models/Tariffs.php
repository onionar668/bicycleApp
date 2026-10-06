<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tariffs extends Model
{
    protected $fillable = [
        'name',
        'type',
        'base_price',
        'min_price',
        'max_price',
        'category_id',
        'deleted_at',
    ];

    public function category()
    {
        return $this->belongsTo(Categories::class);
    }
}
