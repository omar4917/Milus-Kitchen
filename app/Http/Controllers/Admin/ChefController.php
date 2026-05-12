<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Chef;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ChefController extends Controller
{
    public function index()
    {
        $chefs = Chef::orderBy('sort_order')->get();
        return view('admin.chefs.index', compact('chefs'));
    }

    public function create()
    {
        return view('admin.chefs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        if ($request->hasFile('photo')) {
            $validated['photo_path'] = $request->file('photo')->store('chefs', 'public');
        }

        unset($validated['photo']);
        Chef::create($validated);

        return redirect()->route('admin.chefs.index')
            ->with('success', 'Chef added successfully.');
    }

    public function edit(Chef $chef)
    {
        return view('admin.chefs.edit', compact('chef'));
    }

    public function update(Request $request, Chef $chef)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'bio' => 'nullable|string|max:1000',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('photo')) {
            if ($chef->photo_path) {
                Storage::disk('public')->delete($chef->photo_path);
            }
            $validated['photo_path'] = $request->file('photo')->store('chefs', 'public');
        }

        unset($validated['photo']);
        $chef->update($validated);

        return redirect()->route('admin.chefs.index')
            ->with('success', 'Chef updated successfully.');
    }

    public function destroy(Chef $chef)
    {
        if ($chef->photo_path) {
            Storage::disk('public')->delete($chef->photo_path);
        }

        $chef->delete();

        return redirect()->route('admin.chefs.index')
            ->with('success', 'Chef deleted successfully.');
    }
}
