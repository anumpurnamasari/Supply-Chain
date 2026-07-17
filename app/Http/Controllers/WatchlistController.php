<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Watchlist;

class WatchlistController extends Controller
{
    // Menampilkan halaman watchlist
    public function index()
    {
        $watchlists = Watchlist::with('country')->latest()->get();

        return view('pages.watchlist', compact('watchlists'));
    }

    // Menambahkan negara ke watchlist
    public function store(Country $country)
    {
        $exists = Watchlist::where('country_id', $country->id)->exists();

        if (!$exists) {
            Watchlist::create([
                'country_id' => $country->id
            ]);
        }

        return back()->with('success', 'Country added to watchlist.');
    }

    // Menghapus negara dari watchlist
    public function destroy(Country $country)
    {
        Watchlist::where('country_id', $country->id)->delete();

        return back()->with('success', 'Country removed from watchlist.');
    }
}
