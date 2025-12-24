@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<style>
    .checkout-section {
        padding: 60px 0;
        padding-top: 120px;
        background: linear-gradient(135deg, #fafafa 0%, #f5f5f5 100%);
        min-height: 100vh;
    }
    .checkout-header {
        margin-bottom: 30px;
    }
    .checkout-header h1 {
        font-size: 2rem;
        font-weight: 700;
        color: #1a1a2e;
    }
    .checkout-header .breadcrumb {
        color: #888;
        font-size: 14px;
    }
    .checkout-header .breadcrumb a {
        color: #ff7a5c;
    }
    
    .checkout-grid {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 20px;
        margin-bottom: 30px;
    }
    @media (max-width: 992px) {
        .checkout-grid { grid-template-columns: 1fr; }
    }
    
    /* Section Cards */
    .checkout-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.06);
        overflow: hidden;
    }
    .card-header {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 18px 20px;
        border-bottom: 1px solid #f0f0f0;
    }
    .card-number {
        width: 28px;
        height: 28px;
        background: #ff7a5c;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        font-weight: 700;
    }
    .card-header h3 {
        margin: 0;
        font-size: 1rem;
        font-weight: 600;
        color: #1a1a2e;
    }
    .card-body {
        padding: 20px;
    }
    
    /* Form Elements */
    .form-group {
        margin-bottom: 16px;
    }
    .form-group:last-child {
        margin-bottom: 0;
    }
    .form-group label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #333;
        margin-bottom: 6px;
    }
    .form-group input,
    .form-group textarea,
    .form-group select {
        width: 100%;
        padding: 12px 14px;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        font-size: 14px;
        transition: all 0.2s;
        background: #fafafa;
    }
    .form-group input:focus,
    .form-group textarea:focus,
    .form-group select:focus {
        outline: none;
        border-color: #ff7a5c;
        background: white;
        box-shadow: 0 0 0 3px rgba(255,122,92,0.1);
    }
    .form-group input::placeholder,
    .form-group textarea::placeholder {
        color: #aaa;
    }
    .error-text {
        color: #e74c3c;
        font-size: 12px;
        margin-top: 4px;
        display: block;
    }
    
    /* Radio Options */
    .option-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }
    .option-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 14px;
        border: 1px solid #e8e8e8;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s;
    }
    .option-item:hover {
        border-color: #ff7a5c;
        background: #fff8f6;
    }
    .option-item input[type="radio"] {
        width: 18px;
        height: 18px;
        accent-color: #ff7a5c;
    }
    .option-item .option-text {
        flex: 1;
        font-size: 14px;
        color: #333;
    }
    .option-item .option-price {
        font-size: 13px;
        color: #888;
        font-weight: 500;
    }
    .option-item.selected {
        border-color: #ff7a5c;
        background: #fff8f6;
    }
    
    /* Payment Icons */
    .payment-icons {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        margin-top: 15px;
        padding-top: 15px;
        border-top: 1px solid #f0f0f0;
    }
    .payment-icons span {
        padding: 5px 10px;
        background: #f5f5f5;
        border-radius: 6px;
        font-size: 12px;
        color: #666;
    }
    .payment-note {
        font-size: 13px;
        color: #888;
        margin-top: 10px;
        padding: 10px;
        background: #f8f8f8;
        border-radius: 6px;
    }
    
    /* Order Summary */
    .summary-section {
        grid-column: 1 / -1;
    }
    .order-summary-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 15px rgba(0,0,0,0.06);
        padding: 25px;
    }
    .order-summary-card h3 {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1a1a2e;
        margin: 0 0 20px 0;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
    }
    .order-items {
        margin-bottom: 20px;
    }
    .order-item {
        display: flex;
        justify-content: space-between;
        padding: 10px 0;
        font-size: 14px;
    }
    .order-item .qty {
        color: #888;
        margin-right: 8px;
    }
    .summary-row {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
        font-size: 14px;
        color: #666;
    }
    .summary-total {
        font-size: 1.2rem;
        font-weight: 700;
        color: #1a1a2e;
        padding-top: 15px;
        margin-top: 10px;
        border-top: 2px solid #eee;
    }
    .summary-total span:last-child {
        color: #ff7a5c;
    }
    
    /* Buttons */
    .btn-place-order {
        display: block;
        width: 100%;
        padding: 16px;
        background: linear-gradient(135deg, #ff7a5c 0%, #ff5733 100%);
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        margin-top: 20px;
        transition: all 0.3s;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .btn-place-order:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(255,87,51,0.35);
    }
    .btn-back {
        display: block;
        text-align: center;
        padding: 12px;
        color: #ff7a5c;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        margin-top: 10px;
    }
    .btn-back:hover {
        color: #ff5733;
    }
    
    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
    }
    @media (max-width: 576px) {
        .form-row { grid-template-columns: 1fr; }
    }
</style>

<section class="checkout-section">
    <div class="container">
        <div class="checkout-header">
            <p class="breadcrumb">
                <a href="{{ route('home') }}">Home</a> / 
                <a href="{{ route('cart') }}">Cart</a> / 
                <span>Checkout</span>
            </p>
            <h1>Checkout</h1>
            @auth
            <p style="color: #28a745; font-size: 14px; margin-top: 5px;">✓ Logged in as {{ auth()->user()->name }} - Your info is pre-filled!</p>
            @else
            <p style="color: #888; font-size: 14px; margin-top: 5px;"><a href="{{ route('login') }}" style="color: #ff7a5c;">Login</a> to save your info for faster checkout</p>
            @endauth
        </div>

        <form action="{{ route('checkout.store') }}" method="POST">
            @csrf
            
            <div class="checkout-grid">
                <!-- 1. Customer Information -->
                <div class="checkout-card">
                    <div class="card-header">
                        <span class="card-number">1</span>
                        <h3>Customer Information</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label>First Name *</label>
                            <input type="text" name="customer_name" value="{{ old('customer_name', auth()->user()->name ?? '') }}" 
                                   placeholder="Your name" required>
                            @error('customer_name')<span class="error-text">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label>Phone Number *</label>
                            <input type="tel" name="customer_phone" value="{{ old('customer_phone', auth()->user()->phone ?? '') }}" 
                                   placeholder="(416) 555-0123" required>
                            @error('customer_phone')<span class="error-text">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" name="customer_email" value="{{ old('customer_email', auth()->user()->email ?? '') }}" 
                                   placeholder="email@example.com">
                            @error('customer_email')<span class="error-text">{{ $message }}</span>@enderror
                        </div>
                        <div class="form-group" id="addressGroup">
                            <label>Address *</label>
                            <textarea name="delivery_address" rows="2" 
                                      placeholder="Enter your delivery address">{{ old('delivery_address', auth()->user()->address ?? '') }}</textarea>
                            @error('delivery_address')<span class="error-text">{{ $message }}</span>@enderror
                        </div>
                        @auth
                        <div class="form-group" style="margin-top: 15px;">
                            <label style="display: flex; align-items: center; gap: 8px; cursor: pointer; font-weight: normal;">
                                <input type="checkbox" name="save_info" value="1" checked style="width: 18px; height: 18px; accent-color: #ff7a5c;">
                                Save this info for future orders
                            </label>
                        </div>
                        @endauth
                    </div>
                </div>

                <!-- 2. Payment Method -->
                <div class="checkout-card">
                    <div class="card-header">
                        <span class="card-number">2</span>
                        <h3>Payment Method</h3>
                    </div>
                    <div class="card-body">
                        <p style="font-size: 13px; color: #666; margin-bottom: 15px;">Select a payment method</p>
                        @php $userPayment = auth()->user()->preferred_payment_method ?? 'cod'; @endphp
                        <div class="option-list">
                            <label class="option-item">
                                <input type="radio" name="payment_method" value="cod" 
                                       {{ old('payment_method', $userPayment) === 'cod' ? 'checked' : '' }}>
                                <span class="option-text">💵 Cash on Delivery</span>
                            </label>
                            <label class="option-item">
                                <input type="radio" name="payment_method" value="card"
                                       {{ old('payment_method', $userPayment) === 'card' ? 'checked' : '' }}>
                                <span class="option-text">💳 Online Payment</span>
                            </label>
                            <label class="option-item">
                                <input type="radio" name="payment_method" value="interac"
                                       {{ old('payment_method', $userPayment) === 'interac' ? 'checked' : '' }}>
                                <span class="option-text">🏦 Interac e-Transfer</span>
                            </label>
                        </div>
                        <div class="payment-icons">
                            <span>💵 CASH</span>
                            <span>VISA</span>
                            <span>Mastercard</span>
                            <span>Interac</span>
                        </div>
                        <p class="payment-note" id="paymentNote">Cash payment will be collected on delivery.</p>
                    </div>
                </div>

                <!-- 3. Delivery Method -->
                <div class="checkout-card">
                    <div class="card-header">
                        <span class="card-number">3</span>
                        <h3>Delivery Method</h3>
                    </div>
                    <div class="card-body">
                        <p style="font-size: 13px; color: #666; margin-bottom: 15px;">Select a delivery method</p>
                        @php $userDelivery = auth()->user()->preferred_delivery_type ?? 'delivery'; @endphp
                        <div class="option-list">
                            <label class="option-item">
                                <input type="radio" name="delivery_type" value="delivery" 
                                       {{ old('delivery_type', $userDelivery) === 'delivery' ? 'checked' : '' }}>
                                <span class="option-text">🚗 Home Delivery</span>
                                <span class="option-price">${{ number_format($deliveryFee, 0) }}</span>
                            </label>
                            <label class="option-item">
                                <input type="radio" name="delivery_type" value="pickup"
                                       {{ old('delivery_type', $userDelivery) === 'pickup' ? 'checked' : '' }}>
                                <span class="option-text">🏠 Store Pickup</span>
                                <span class="option-price">Free</span>
                            </label>
                        </div>
                        
                        <div class="form-row" style="margin-top: 20px;">
                            <div class="form-group">
                                <label>Preferred Date *</label>
                                <input type="date" name="preferred_date" 
                                       value="{{ old('preferred_date', date('Y-m-d')) }}" 
                                       min="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="form-group">
                                <label>Time Slot *</label>
                                <select name="time_slot" required>
                                    <option value="">Select time</option>
                                    @foreach($timeSlots as $slot)
                                    <option value="{{ $slot }}" {{ old('time_slot') === $slot ? 'selected' : '' }}>
                                        {{ $slot }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group" style="margin-top: 15px;">
                            <label>Special Instructions</label>
                            <textarea name="notes" rows="2" 
                                      placeholder="e.g., Less spicy, no onions...">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="order-summary-card">
                <h3>Order Summary</h3>
                <div class="order-items">
                    @foreach($cart['items'] as $item)
                    <div class="order-item">
                        <span><span class="qty">{{ $item['quantity'] }}x</span> {{ $item['name'] }}</span>
                        <span>${{ number_format($item['price'] * $item['quantity'], 0) }}</span>
                    </div>
                    @endforeach
                </div>
                
                <!-- Coupon Code Input -->
                <div class="coupon-section" id="couponSection" style="padding: 15px 0; border-top: 1px solid #eee; border-bottom: 1px solid #eee; margin-bottom: 15px;">
                    @php $appliedCoupon = session('coupon'); @endphp
                    <div id="appliedCouponView" style="{{ $appliedCoupon ? '' : 'display:none;' }}">
                        <div style="display: flex; justify-content: space-between; align-items: center; background: #e8f5e9; padding: 12px; border-radius: 8px;">
                            <span style="color: #2e7d32; font-weight: 600;">
                                🎉 <strong id="appliedCouponCode">{{ $appliedCoupon['code'] ?? '' }}</strong> applied!
                            </span>
                            <button type="button" onclick="removeCoupon()" style="background: none; border: none; color: #c62828; cursor: pointer; font-size: 14px;">✕ Remove</button>
                        </div>
                    </div>
                    <input type="hidden" name="coupon_id" id="couponIdInput" value="{{ $appliedCoupon['id'] ?? '' }}">
                    <div id="couponInputView" style="{{ $appliedCoupon ? 'display:none;' : '' }}">
                        <div style="display: flex; gap: 10px;">
                            <input type="text" id="couponInput" placeholder="Enter coupon code" 
                                   style="flex: 1; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px;">
                            <button type="button" id="applyBtn" onclick="applyCoupon()" 
                                    style="padding: 12px 20px; background: #ff7a5c; color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
                                Apply
                            </button>
                        </div>
                        <p id="couponError" style="color: #e74c3c; font-size: 12px; margin-top: 8px; display: none;"></p>
                        <p id="couponSuccess" style="color: #2e7d32; font-size: 12px; margin-top: 8px; display: none;"></p>
                    </div>
                </div>
                
                <div class="summary-row">
                    <span>Subtotal</span>
                    <span>${{ number_format($cart['subtotal'], 0) }}</span>
                </div>
                <div class="summary-row" id="discountRow" style="color: #2e7d32; {{ $appliedCoupon ? '' : 'display:none;' }}">
                    <span>Discount (<span id="discountCode">{{ $appliedCoupon['code'] ?? '' }}</span>)</span>
                    <span id="discountAmount">-${{ number_format($appliedCoupon['discount'] ?? 0, 0) }}</span>
                </div>
                <div class="summary-row" id="deliveryFeeRow">
                    <span>Delivery Fee</span>
                    <span id="deliveryFeeAmount">${{ number_format($deliveryFee, 0) }}</span>
                </div>
                <div class="summary-row summary-total">
                    <span>Total</span>
                    @php
                        $discount = $appliedCoupon['discount'] ?? 0;
                        $total = $cart['subtotal'] - $discount + $deliveryFee;
                    @endphp
                    <span id="totalAmount">${{ number_format($total, 0) }}</span>
                </div>
                <button type="submit" class="btn-place-order">Place Order</button>
                <a href="{{ route('cart') }}" class="btn-back">← Back to Cart</a>
            </div>
        </form>
    </div>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const subtotal = {{ $cart['subtotal'] }};
    const deliveryFee = {{ $deliveryFee }};
    const discount = {{ session('coupon.discount') ?? 0 }};
    
    const deliveryOptions = document.querySelectorAll('input[name="delivery_type"]');
    const addressGroup = document.getElementById('addressGroup');
    const deliveryFeeAmount = document.getElementById('deliveryFeeAmount');
    const totalAmount = document.getElementById('totalAmount');
    
    const paymentOptions = document.querySelectorAll('input[name="payment_method"]');
    const paymentNote = document.getElementById('paymentNote');
    
    const notes = {
        cod: 'Cash payment will be collected on delivery.',
        card: 'You will be redirected to secure payment after placing order.',
        interac: 'Send e-Transfer to: payments@meal.ca with order number.'
    };

    function updateDelivery() {
        const isDelivery = document.querySelector('input[name="delivery_type"]:checked').value === 'delivery';
        addressGroup.style.display = isDelivery ? 'block' : 'none';
        addressGroup.querySelector('textarea').required = isDelivery;
        
        const currentFee = isDelivery ? deliveryFee : 0;
        const total = subtotal - discount + currentFee;
        
        deliveryFeeAmount.textContent = isDelivery ? '$' + deliveryFee : 'Free';
        totalAmount.textContent = '$' + total;
    }
    
    function updatePayment() {
        const method = document.querySelector('input[name="payment_method"]:checked').value;
        paymentNote.textContent = notes[method] || '';
    }

    deliveryOptions.forEach(opt => opt.addEventListener('change', updateDelivery));
    paymentOptions.forEach(opt => opt.addEventListener('change', updatePayment));
    
    updateDelivery();
    updatePayment();
});

function applyCoupon() {
    const code = document.getElementById('couponInput').value.trim();
    if (!code) return;
    
    const btn = document.getElementById('applyBtn');
    btn.textContent = '...';
    btn.disabled = true;
    
    fetch('{{ route("cart.coupon") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ coupon_code: code })
    })
    .then(res => res.json())
    .then(data => {
        btn.textContent = 'Apply';
        btn.disabled = false;
        
        if (data.success) {
            // Update UI
            document.getElementById('appliedCouponCode').textContent = data.code;
            document.getElementById('couponIdInput').value = data.id;
            document.getElementById('discountCode').textContent = data.code;
            document.getElementById('discountAmount').textContent = '-$' + Math.round(data.discount);
            document.getElementById('discountRow').style.display = '';
            document.getElementById('appliedCouponView').style.display = '';
            document.getElementById('couponInputView').style.display = 'none';
            
            // Update total
            updateTotalWithDiscount(data.discount);
        } else {
            document.getElementById('couponError').textContent = data.message || 'Invalid coupon';
            document.getElementById('couponError').style.display = 'block';
            setTimeout(() => { document.getElementById('couponError').style.display = 'none'; }, 3000);
        }
    })
    .catch(() => {
        btn.textContent = 'Apply';
        btn.disabled = false;
        document.getElementById('couponError').textContent = 'Error applying coupon';
        document.getElementById('couponError').style.display = 'block';
    });
}

function removeCoupon() {
    fetch('{{ route("cart.coupon.remove") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(() => {
        document.getElementById('appliedCouponView').style.display = 'none';
        document.getElementById('couponInputView').style.display = '';
        document.getElementById('discountRow').style.display = 'none';
        document.getElementById('couponIdInput').value = '';
        document.getElementById('couponInput').value = '';
        updateTotalWithDiscount(0);
    });
}

function updateTotalWithDiscount(discountValue) {
    discount = discountValue;
    const isDelivery = document.querySelector('input[name="delivery_type"]:checked').value === 'delivery';
    const currentFee = isDelivery ? deliveryFee : 0;
    const total = subtotal - discount + currentFee;
    document.getElementById('totalAmount').textContent = '$' + Math.round(total);
}
</script>
@endpush
