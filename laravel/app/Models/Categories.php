<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $fillable = [
        'name',
        'rent_conditions',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
