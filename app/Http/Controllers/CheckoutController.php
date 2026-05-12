<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Services\CartService;
use App\Services\OrderService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    protected CartService $cartService;
    protected OrderService $orderService;

    public function __construct(CartService $cartService, OrderService $orderService)
    {
        $this->cartService = $cartService;
        $this->orderService = $orderService;
    }

    public function index()
    {
        if ($this->cartService->isEmpty()) {
            return redirect()->route('menu')
                ->with('error', 'Your cart is empty.');
        }

        $cart = $this->cartService->getCartDetails();
        $deliveryFee = (float) Setting::get('delivery_fee', 50);
        $timeSlots = $this->getTimeSlots();
        $paymentInstructions = $this->getPaymentInstructions();

        return view('public.checkout', compact(
            'cart',
            'deliveryFee',
            'timeSlots',
            'paymentInstructions'
        ));
    }

    public function store(Request $request)
    {
        if ($this->cartService->isEmpty()) {
            return redirect()->route('menu')
                ->with('error', 'Your cart is empty.');
        }

        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'nullable|email|max:255',
            'delivery_type' => 'required|in:delivery,pickup',
            'delivery_address' => 'required_if:delivery_type,delivery|nullable|string',
            'preferred_date' => 'required|date|after_or_equal:today',
            'time_slot' => 'required|string',
            'notes' => 'nullable|string|max:500',
            'payment_method' => 'required|in:cod,card,interac,apple_google_pay',
            'save_info' => 'nullable|boolean',
        ]);

        try {
            // Save user preferences if logged in and checkbox is checked
            if (auth()->check() && $request->has('save_info')) {
                auth()->user()->update([
                    'phone' => $validated['customer_phone'],
                    'address' => $validated['delivery_address'] ?? null,
                    'preferred_payment_method' => $validated['payment_method'],
                    'preferred_delivery_type' => $validated['delivery_type'],
                ]);
            }
            
            $order = $this->orderService->createOrder($validated);
            return redirect()->route('order.confirmation', $order->order_number);
        } catch (\Exception $e) {
            \Log::error('Order creation failed: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to place order. Please try again.');
        }
    }

    protected function getTimeSlots(): array
    {
        return [
            '10:00 - 11:00 AM',
            '11:00 AM - 12:00 PM',
            '12:00 - 1:00 PM',
            '1:00 - 2:00 PM',
            '2:00 - 3:00 PM',
            '3:00 - 4:00 PM',
            '5:00 - 6:00 PM',
            '6:00 - 7:00 PM',
            '7:00 - 8:00 PM',
            '8:00 - 9:00 PM',
        ];
    }

    protected function getPaymentInstructions(): array
    {
        return [
            'interac' => Setting::get('etransfer_email', 'Send e-Transfer to: payments@liluskitchen.com. Include your order number as the message.'),
            'apple_google_pay' => 'Tap to pay on delivery, or pay via the secure checkout link sent to your email.',
        ];
    }
}
