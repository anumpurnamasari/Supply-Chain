<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\NewsCache;

class NewsApiController extends Controller
{
    public function index()
    {
        $news = NewsCache::with('country')
            ->latest()
            ->take(20)
            ->get();

        return response()->json([
            'success' => true,
            'total' => $news->count(),
            'data' => $news
        ]);
    }
}
