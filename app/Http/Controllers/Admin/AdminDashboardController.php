<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Port;
use App\Models\Article;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard',[
            'users'=>User::count(),
            'ports'=>Port::count(),
            'articles'=>Article::count(),
        ]);
    }
}
