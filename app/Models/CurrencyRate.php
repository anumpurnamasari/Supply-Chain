<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CurrencyRate extends Model
{
    protected $fillable = [

        'country_id',

        'currency',

        'exchange_rate',

        'currency_risk'

    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }
}
