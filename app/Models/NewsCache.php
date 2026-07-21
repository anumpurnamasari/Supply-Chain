<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NewsCache extends Model
{
    protected $fillable = [
        'country_id',
        'title',
        'description',
        'source',
        'url',
        'image',
        'published_at',
        'category',
        'sentiment',
        'sentiment_score',
    ];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
}
