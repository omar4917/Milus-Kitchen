<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        return view('admin.settings.index');
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'specials_title' => 'required|string|max:255',
            'specials_subtitle' => 'nullable|string|max:255',
        ]);

        Setting::set('specials_title', $validated['specials_title']);
        Setting::set('specials_subtitle', $validated['specials_subtitle'] ?? '');

        return redirect()->route('admin.settings.index')
            ->with('success', 'Settings updated successfully.');
    }
}
