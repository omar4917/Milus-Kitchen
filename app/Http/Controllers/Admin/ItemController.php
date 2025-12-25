<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $query = MenuItem::with('category')->ordered();

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('status')) {
            $query->where('is_available', $request->status === 'available');
        }

        $items = $query->paginate(20);
        $categories = Category::ordered()->get();

        return view('admin.items.index', compact('items', 'categories'));
    }

    public function create()
    {
        $categories = Category::active()->ordered()->get();
        return view('admin.items.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'country' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'sort_order' => 'nullable|integer|min:0',
            'is_available' => 'boolean',
            'is_special' => 'boolean',
        ]);

        $validated['is_available'] = $request->boolean('is_available', true);
        $validated['is_special'] = $request->boolean('is_special');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        if ($request->hasFile('photo')) {
            $validated['photo_path'] = $request->file('photo')->store('menu-items', 'public');
        }

        unset($validated['photo']);
        MenuItem::create($validated);

        return redirect()->route('admin.items.index')
            ->with('success', 'Menu item created successfully.');
    }

    public function edit(MenuItem $item)
    {
        $categories = Category::active()->ordered()->get();
        return view('admin.items.edit', compact('item', 'categories'));
    }

    public function update(Request $request, MenuItem $item)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'country' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0|lt:price',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'sort_order' => 'nullable|integer|min:0',
            'is_available' => 'boolean',
            'is_special' => 'boolean',
        ]);

        $validated['is_available'] = $request->boolean('is_available', true);
        $validated['is_special'] = $request->boolean('is_special');

        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($item->photo_path) {
                Storage::disk('public')->delete($item->photo_path);
            }
            $validated['photo_path'] = $request->file('photo')->store('menu-items', 'public');
        }

        unset($validated['photo']);
        $item->update($validated);

        return redirect()->route('admin.items.index')
            ->with('success', 'Menu item updated successfully.');
    }

    public function destroy(MenuItem $item)
    {
        if ($item->photo_path) {
            Storage::disk('public')->delete($item->photo_path);
        }

        $item->delete();

        return redirect()->route('admin.items.index')
            ->with('success', 'Menu item deleted successfully.');
    }

    public function toggleAvailability(MenuItem $item)
    {
        $item->update(['is_available' => !$item->is_available]);

        return redirect()->back()
            ->with('success', 'Item availability updated.');
    }
}
