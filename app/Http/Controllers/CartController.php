<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        $cart = $this->cartService->getCartDetails();
        $appliedCoupon = session('coupon');
        return view('public.cart', compact('cart', 'appliedCoupon'));
    }

    public function add(Request $request)
    {
        $validated = $request->validate([
            'menu_item_id' => 'required|exists:menu_items,id',
            'quantity' => 'nullable|integer|min:1|max:10',
        ]);

        $this->cartService->add(
            $validated['menu_item_id'],
            $validated['quantity'] ?? 1
        );
        
        // Get item name for modal
        $item = \App\Models\MenuItem::find($validated['menu_item_id']);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Item added to cart',
                'item_name' => $item->name,
                'cart' => $this->cartService->getCartDetails(),
            ]);
        }

        return redirect()->back()->with('cart_added', $item->name);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'menu_item_id' => 'required|integer',
            'quantity' => 'required|integer|min:0|max:10',
        ]);

        $this->cartService->update(
            $validated['menu_item_id'],
            $validated['quantity']
        );

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'cart' => $this->cartService->getCartDetails(),
            ]);
        }

        return redirect()->back();
    }

    public function remove(Request $request)
    {
        $validated = $request->validate([
            'menu_item_id' => 'required|integer',
        ]);

        $this->cartService->remove($validated['menu_item_id']);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'cart' => $this->cartService->getCartDetails(),
            ]);
        }

        return redirect()->back()->with('success', 'Item removed from cart.');
    }

    public function clear()
    {
        $this->cartService->clear();
        session()->forget('coupon');
        return redirect()->route('menu')->with('success', 'Cart cleared.');
    }

    public function applyCoupon(Request $request)
    {
        $validated = $request->validate([
            'coupon_code' => 'required|string',
        ]);

        $coupon = Coupon::where('code', strtoupper($validated['coupon_code']))->first();

        if (!$coupon) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Coupon not found.']);
            }
            return back()->with('error', 'Coupon not found.');
        }

        $cart = $this->cartService->getCartDetails();

        if (!$coupon->isValid($cart['subtotal'])) {
            $message = 'Coupon is not valid.';
            if ($coupon->min_order > 0 && $cart['subtotal'] < $coupon->min_order) {
                $message = "Minimum order of \${$coupon->min_order} required for this coupon.";
            }
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => $message]);
            }
            return back()->with('error', $message);
        }

        $discount = $coupon->calculateDiscount($cart['subtotal']);
        
        session(['coupon' => [
            'id' => $coupon->id,
            'code' => $coupon->code,
            'type' => $coupon->type,
            'value' => $coupon->value,
            'discount' => $discount,
        ]]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'id' => $coupon->id,
                'code' => $coupon->code,
                'discount' => $discount,
            ]);
        }

        return back()->with('success', "Coupon '{$coupon->code}' applied!");
    }

    public function removeCoupon()
    {
        session()->forget('coupon');
        return back()->with('success', 'Coupon removed.');
    }
}

