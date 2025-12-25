<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('user.dashboard');
        }
        return view('user.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            if (Auth::user()->role === \App\Models\User::ROLE_ADMIN) {
                return redirect()->intended(route('admin.dashboard'));
            }

            return redirect()->intended(route('user.dashboard'));
        }

        return back()->withErrors(['email' => 'Invalid credentials.'])->onlyInput('email');
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return redirect()->route('user.dashboard');
        }
        return view('user.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:4|confirmed',
            'phone' => 'nullable|string|max:20',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'] ?? null,
            'role' => 'customer',
        ]);

        Auth::login($user);

        return redirect()->route('user.dashboard')->with('success', 'Welcome! Your account has been created.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }

    public function dashboard()
    {
        $user = Auth::user();
        $recentOrders = Order::where('customer_email', $user->email)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('user.dashboard', compact('user', 'recentOrders'));
    }

    public function orders()
    {
        $user = Auth::user();
        $orders = Order::where('customer_email', $user->email)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.orders', compact('orders'));
    }

    public function orderDetail(Order $order)
    {
        $user = Auth::user();
        
        // Verify order belongs to user
        if ($order->customer_email !== $user->email) {
            abort(403);
        }

        return view('user.order-detail', compact('order'));
    }

    public function reorder(Order $order, \App\Services\CartService $cartService)
    {
        $user = Auth::user();

        // Verify order belongs to user
        if ($order->customer_email !== $user->email) {
            abort(403);
        }

        foreach ($order->items as $item) {
            $cartService->add($item->menu_item_id, $item->quantity);
        }

        return redirect()->route('cart')->with('success', 'Items from order #' . $order->order_number . ' have been added to your cart.');
    }

    public function profile()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'notification_prefs' => 'nullable|array',
            'password' => 'nullable|string|min:4|confirmed',
        ]);

        $user->name = $validated['name'];
        $user->phone = $validated['phone'];
        $user->address = $validated['address'] ?? null;
        $user->notification_prefs = $validated['notification_prefs'] ?? [];
        
        if (!empty($validated['password'])) {
            $user->password = Hash::make($validated['password']);
        }
        
        $user->save();

        return back()->with('success', 'Profile updated successfully!');
    }

    public function notifications()
    {
        $user = Auth::user();
        $notifications = $user->notifications()->paginate(15);
        
        // Mark as read
        $user->unreadNotifications->markAsRead();

        return view('user.notifications', compact('notifications'));
    }
}
