<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;


class EconomicData extends Model
{


    protected $fillable=[


        'country_id',

        'gdp',

        'inflation',

        'economic_risk'


    ];


}
