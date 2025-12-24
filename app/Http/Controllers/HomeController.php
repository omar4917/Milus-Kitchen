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
            ->with(['activeMenuItems' => function ($query) {
                $query->ordered()->take(6); // Limit to 6 items per category for homepage to avoid overload
            }])
            ->get();

        $reviews = \App\Models\Review::with('user')
            ->where('is_approved', true)
            ->inRandomOrder()
            ->take(3)
            ->get();

        return view('public.home', compact('featuredItems', 'categories', 'reviews'));
    }
}
