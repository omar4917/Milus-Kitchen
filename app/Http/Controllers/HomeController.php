<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\MenuItem;
use App\Models\Setting;

class HomeController extends Controller
{
    public function index()
    {
        $featuredItems = MenuItem::with('category')
            ->available()
            ->inRandomOrder()
            ->take(6)
            ->get();

        $categories = Category::active()
            ->ordered()
            ->withCount('activeMenuItems')
            ->get();

        return view('public.home', compact('featuredItems', 'categories'));
    }
}
