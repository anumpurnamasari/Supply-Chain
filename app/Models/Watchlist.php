<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Watchlist extends Model
{
    protected $fillable = [
        'country_id',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
