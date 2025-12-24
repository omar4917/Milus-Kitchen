<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\MenuItem;

class MenuController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $categories = Category::active()
            ->ordered()
            ->with(['activeMenuItems' => function ($query) {
                $query->ordered();
            }])
            ->get();

        $query = MenuItem::with('category')->where('is_available', true);

        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        $menuItems = $query->get();

        if ($request->ajax()) {
            return view('public.partials.menu_items', compact('menuItems'))->render();
        }

        return view('public.menu', compact('categories', 'menuItems'));
    }

    public function category(string $slug)
    {
        $category = Category::where('slug', $slug)
            ->active()
            ->firstOrFail();

        $items = $category->activeMenuItems()
            ->ordered()
            ->get();

        $categories = Category::active()
            ->ordered()
            ->get();

        return view('public.category', compact('category', 'items', 'categories'));
    }

    public function show(MenuItem $item)
    {
        if (!$item->is_available) {
            abort(404);
        }

        $relatedItems = MenuItem::where('category_id', $item->category_id)
            ->where('id', '!=', $item->id)
            ->available()
            ->take(4)
            ->get();

        return view('public.item', compact('item', 'relatedItems'));
    }
}
