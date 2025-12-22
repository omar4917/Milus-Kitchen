<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'menu_item_id' => 'required|exists:menu_items,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
        ]);

        $review = new Review();
        $review->menu_item_id = $validated['menu_item_id'];
        $review->rating = $validated['rating'];
        $review->comment = $validated['comment'];

        if (Auth::check()) {
            $review->user_id = Auth::id();
        } else {
            $review->name = $validated['name'] ?? 'Anonymous';
            $review->email = $validated['email'];
        }

        $review->is_approved = false; // Requires admin approval
        $review->save();

        return back()->with('success', 'Thank you for your review! It will be visible after approval.');
    }
}
