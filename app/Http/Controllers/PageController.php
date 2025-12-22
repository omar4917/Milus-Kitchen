<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about()
    {
        return view('public.about');
    }

    public function contact()
    {
        $contact = [
            'phone' => Setting::get('contact_phone', '+880 1XXX-XXXXXX'),
            'email' => Setting::get('contact_email', 'restaurant@example.com'),
            'address' => Setting::get('pickup_address', 'House #, Road #, Area, City'),
            'hours' => Setting::get('operating_hours', 'Daily: 10:00 AM - 9:00 PM'),
        ];

        return view('public.contact', compact('contact'));
    }

    public function submitContact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        // Here you could send an email, save to database, etc.
        // For now, just redirect with success message
        
        return back()->with('success', 'Thank you for your message! We will get back to you soon.');
    }
}
