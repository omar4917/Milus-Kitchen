@extends('layouts.app')

@section('title', 'Your Cart')

@section('content')
<style>
    .cart-section {
        padding: 60px 0;
        padding-top: 120px;
        background: linear-gradient(135deg, #fafafa 0%, #f5f5f5 100%);
        min-height: 70vh;
    }
    .cart-header {
        text-align: center;
        margin-bottom: 40px;
    }
    .cart-header h1 {
        font-size: 2.5rem;
        font-weight: 700;
        color: #1a1a2e;
        margin-bottom: 10px;
    }
    .cart-header p {
        color: #666;
        font-size: 1.1rem;
    }
    .cart-wrapper {
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: 30px;
    }
    @media (max-width: 992px) {
        .cart-wrapper { grid-template-columns: 1fr; }
    }
    
    /* Cart Items */
    .cart-items-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        overflow: hidden;
    }
    .cart-items-header {
        padding: 20px 25px;
        border-bottom: 1px solid #eee;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .cart-items-header h3 {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 600;
        color: #333;
    }
    .item-count {
        background: #ff7a5c;
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 600;
    }
    .cart-item {
        display: grid;
        grid-template-columns: 80px 1fr auto auto auto;
        gap: 20px;
        align-items: center;
        padding: 20px 25px;
        border-bottom: 1px solid #f0f0f0;
        transition: background 0.2s;
    }
    .cart-item:hover { background: #fafafa; }
    .cart-item:last-child { border-bottom: none; }
    .cart-item-image {
        width: 80px;
        height: 80px;
        border-radius: 12px;
        overflow: hidden;
        background: #f8f8f8;
    }
    .cart-item-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .item-placeholder {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 32px;
        background: linear-gradient(135deg, #fff5f3 0%, #ffe8e3 100%);
    }
    .cart-item-details h4 {
        margin: 0 0 5px 0;
        font-size: 1rem;
        font-weight: 600;
        color: #1a1a2e;
    }
    .cart-item-details .unit-price {
        color: #888;
        font-size: 14px;
    }
    
    /* Quantity Controls */
    .quantity-controls {
        display: flex;
        align-items: center;
        gap: 0;
        background: #f5f5f5;
        border-radius: 10px;
        overflow: hidden;
    }
    .qty-btn {
        width: 36px;
        height: 36px;
        border: none;
        background: transparent;
        font-size: 18px;
        cursor: pointer;
        color: #333;
        transition: all 0.2s;
    }
    .qty-btn:hover { background: #e8e8e8; }
    .qty-input {
        width: 45px;
        text-align: center;
        border: none;
        background: transparent;
        font-size: 15px;
        font-weight: 600;
        -moz-appearance: textfield;
    }
    .qty-input::-webkit-outer-spin-button,
    .qty-input::-webkit-inner-spin-button { -webkit-appearance: none; }
    
    .item-total {
        font-size: 1.1rem;
        font-weight: 700;
        color: #1a1a2e;
        min-width: 80px;
        text-align: right;
    }
    .remove-btn {
        width: 36px;
        height: 36px;
        border: none;
        background: #fee;
        color: #e74c3c;
        border-radius: 8px;
        cursor: pointer;
        font-size: 14px;
        transition: all 0.2s;
    }
    .remove-btn:hover { background: #e74c3c; color: white; }
    
    /* Summary Card */
    .summary-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        padding: 25px;
        position: sticky;
        top: 100px;
    }
    .summary-card h3 {
        font-size: 1.2rem;
        font-weight: 700;
        color: #1a1a2e;
        margin: 0 0 20px 0;
        padding-bottom: 15px;
        border-bottom: 2px solid #f0f0f0;
    }
    .summary-row {
        display: flex;
        justify-content: space-between;
        padding: 12px 0;
        font-size: 15px;
    }
    .summary-row span:first-child { color: #666; }
    .summary-row span:last-child { color: #333; font-weight: 500; }
    .summary-divider {
        height: 1px;
        background: #eee;
        margin: 10px 0;
    }
    .summary-total {
        font-size: 1.2rem !important;
        font-weight: 700 !important;
        padding-top: 15px !important;
    }
    .summary-total span { color: #1a1a2e !important; }
    .summary-total span:last-child { color: #ff7a5c !important; font-size: 1.4rem; }
    
    .checkout-btn {
        display: block;
        width: 100%;
        padding: 16px;
        background: linear-gradient(135deg, #ff7a5c 0%, #ff5733 100%);
        color: white;
        text-align: center;
        border: none;
        border-radius: 12px;
        font-size: 16px;
        font-weight: 600;
        text-decoration: none;
        margin-top: 20px;
        transition: all 0.3s;
        text-transform: uppercase;
        letter-spacing: 1px;
    }
    .checkout-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(255,87,51,0.35);
        color: white;
    }
    .continue-btn {
        display: block;
        width: 100%;
        padding: 14px;
        background: transparent;
        color: #ff7a5c;
        text-align: center;
        border: none;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        margin-top: 10px;
        transition: all 0.2s;
    }
    .continue-btn:hover { color: #ff5733; }
    
    /* Coupon Section */
    .coupon-section {
        margin: 20px 0;
        padding: 15px 0;
        border-top: 1px solid #f0f0f0;
    }
    .coupon-section h4 {
        font-size: 0.9rem;
        font-weight: 600;
        color: #555;
        margin-bottom: 12px;
    }
    .coupon-input-group {
        display: flex;
        gap: 10px;
    }
    .coupon-input {
        flex: 1;
        padding: 10px 15px;
        border: 1.5px solid #eee;
        border-radius: 10px;
        font-size: 14px;
        transition: all 0.2s;
        text-transform: uppercase;
    }
    .coupon-input:focus {
        outline: none;
        border-color: #ff7a5c;
        background: #fff;
    }
    .apply-coupon-btn {
        padding: 10px 20px;
        background: #1a1a2e;
        color: white;
        border: none;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s;
    }
    .apply-coupon-btn:hover {
        background: #2a2a4a;
        transform: translateY(-1px);
    }
    .applied-coupon {
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #fdf4f2;
        padding: 10px 15px;
        border-radius: 10px;
        border: 1px dashed #ff7a5c;
        margin-top: 10px;
    }
    .coupon-info {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #ff7a5c;
        font-weight: 600;
        font-size: 14px;
    }
    .remove-coupon {
        color: #999;
        cursor: pointer;
        font-size: 18px;
        border: none;
        background: none;
        padding: 0;
        line-height: 1;
    }
    .remove-coupon:hover { color: #e74c3c; }
    
    .discount-row {
        color: #10b981;
        font-weight: 600;
    }
    
    /* Empty Cart */
    .empty-cart {
        text-align: center;
        padding: 80px 20px;
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    }
    .empty-cart-icon {
        font-size: 80px;
        margin-bottom: 20px;
    }
    .empty-cart h2 {
        font-size: 1.8rem;
        color: #1a1a2e;
        margin-bottom: 10px;
    }
    .empty-cart p {
        color: #888;
        margin-bottom: 30px;
    }
    .browse-btn {
        display: inline-block;
        padding: 14px 40px;
        background: linear-gradient(135deg, #ff7a5c 0%, #ff5733 100%);
        color: white;
        border-radius: 10px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.3s;
    }
    .browse-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(255,87,51,0.35);
        color: white;
    }
    
    @media (max-width: 768px) {
        .cart-item {
            grid-template-columns: 60px 1fr;
            gap: 15px;
        }
        .cart-item-image { width: 60px; height: 60px; }
        .quantity-controls, .item-total, .remove-btn { grid-column: 2; }
    }
</style>

<section class="cart-section">
    <div class="container">
        <div class="cart-header">
            <h1>Your Cart</h1>
            @if(!empty($cart['items']))
                <p>Review your items before checkout</p>
            @endif
        </div>

        @if(!empty($cart['items']))
            <div class="cart-wrapper">
                <div class="cart-items-card">
                    <div class="cart-items-header">
                        <h3>Cart Items</h3>
                        <span class="item-count">{{ $cart['count'] }} {{ $cart['count'] == 1 ? 'item' : 'items' }}</span>
                    </div>
                    
                    @foreach($cart['items'] as $itemId => $item)
                    <div class="cart-item" data-item-id="{{ $itemId }}">
                        <div class="cart-item-image">
                            @php $itemImage = $item['image'] ?? $item['photo_path'] ?? null; @endphp
                            @if($itemImage)
                                <img src="{{ asset('storage/' . $itemImage) }}" alt="{{ $item['name'] }}">
                            @else
                                <img src="{{ asset('images/img_1.jpg') }}" alt="{{ $item['name'] }}">
                            @endif
                        </div>
                        <div class="cart-item-details">
                            <h4>{{ $item['name'] }}</h4>
                            <span class="unit-price">${{ number_format($item['price'], 0) }} each</span>
                        </div>
                        <form action="{{ route('cart.update') }}" method="POST" class="quantity-form">
                            @csrf
                            <input type="hidden" name="menu_item_id" value="{{ $itemId }}">
                            <div class="quantity-controls">
                                <button type="button" class="qty-btn qty-minus">−</button>
                                <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" max="10" class="qty-input">
                                <button type="button" class="qty-btn qty-plus">+</button>
                            </div>
                        </form>
                        <div class="item-total">${{ number_format($item['price'] * $item['quantity'], 0) }}</div>
                        <form action="{{ route('cart.remove') }}" method="POST">
                            @csrf
                            <input type="hidden" name="menu_item_id" value="{{ $itemId }}">
                            <button type="submit" class="remove-btn">✕</button>
                        </form>
                    </div>
                    @endforeach
                </div>

                <div class="summary-card">
                    <h3>Order Summary</h3>
                    <div class="summary-row">
                        <span>Subtotal ({{ $cart['count'] }} items)</span>
                        <span id="summary-subtotal">${{ number_format($cart['subtotal'], 0) }}</span>
                    </div>

                    <div id="coupon-display-area">
                    @if($appliedCoupon)
                        <div class="summary-row discount-row">
                            <span>
                                Discount 
                                @if($appliedCoupon['type'] === 'percentage')
                                    <small id="coupon-calc-detail">({{ (int)$appliedCoupon['value'] }}%)</small>
                                @endif
                                <small class="text-muted ml-1">({{ $appliedCoupon['code'] }})</small>
                            </span>
                            <span id="summary-discount">-${{ number_format($appliedCoupon['discount'], 0) }}</span>
                        </div>
                    @endif
                    </div>

                    <div class="summary-row">
                        <span>Delivery Fee</span>
                        <span style="color: #888;">Calculated at checkout</span>
                    </div>

                    <!-- Coupon Input Section -->
                    <div class="coupon-section">
                        @if(!$appliedCoupon)
                            <div id="coupon-input-wrapper">
                                <h4>Have a coupon?</h4>
                                <div class="coupon-input-group">
                                    <input type="text" id="coupon-code" class="coupon-input" placeholder="ENTER CODE">
                                    <button type="button" id="apply-coupon" class="apply-coupon-btn">Apply</button>
                                </div>
                            </div>
                        @else
                            <div class="applied-coupon" id="applied-coupon-wrapper">
                                <div class="coupon-info">
                                    <span class="icon ion-pricetag"></span>
                                    <span>{{ $appliedCoupon['code'] }} applied!</span>
                                </div>
                                <button type="button" id="remove-coupon" class="remove-coupon">×</button>
                            </div>
                        @endif
                    </div>

                    <div class="summary-divider"></div>
                    <div class="summary-row summary-total">
                        <span>Total</span>
                        <span id="summary-total">${{ number_format($cart['total'], 0) }}</span>
                    </div>
                    <a href="{{ route('checkout') }}" class="checkout-btn">Proceed to Checkout</a>
                    <a href="{{ route('menu') }}" class="continue-btn">← Continue Ordering</a>
                </div>
            </div>
        @else
            <div class="empty-cart">
                <div class="empty-cart-icon">🛒</div>
                <h2>Your cart is empty</h2>
                <p>Looks like you haven't added any delicious items yet!</p>
                <a href="{{ route('menu') }}" class="browse-btn">Browse Our Menu</a>
            </div>
        @endif
    </div>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.qty-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('.quantity-form');
            const input = form.querySelector('.qty-input');
            const cartItem = this.closest('.cart-item');
            let value = parseInt(input.value);
            let newValue = value;

            if (this.classList.contains('qty-minus') && value > 1) {
                newValue = value - 1;
            } else if (this.classList.contains('qty-plus') && value < 10) {
                newValue = value + 1;
            }
            
            if (newValue === value) return;
            
            input.value = newValue;
            
            // Get item price and update total display
            const unitPrice = parseFloat(cartItem.querySelector('.unit-price').textContent.replace('$', '').replace(' each', '').replace(',', ''));
            const itemTotalEl = cartItem.querySelector('.item-total');
            const newItemTotal = unitPrice * newValue;
            itemTotalEl.textContent = '$' + newItemTotal.toLocaleString('en-US', {maximumFractionDigits: 0});
            
            // AJAX update
            const formData = new FormData(form);
            
            fetch(form.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update summary
                    document.querySelector('.item-count').textContent = data.count + (data.count == 1 ? ' item' : ' items');
                    document.getElementById('summary-subtotal').textContent = '$' + data.subtotal.toLocaleString('en-US', {maximumFractionDigits: 0});
                    
                    // Update discount if exists
                    const discountRow = document.querySelector('.discount-row');
                    const appliedCoupon = data.cart.coupon || null; // I should add this to controller response
                    
                    if (data.cart.discount > 0) {
                        const discountFormatted = data.cart.discount.toLocaleString('en-US', {maximumFractionDigits: 0});
                        if (!discountRow) {
                            const couponArea = document.getElementById('coupon-display-area');
                            let detailHtml = '';
                            if (appliedCoupon && appliedCoupon.type === 'percentage') {
                                detailHtml = `<small id="coupon-calc-detail">(${Math.round(appliedCoupon.value)}%)</small>`;
                            }
                            const codeHtml = appliedCoupon ? `<small class="text-muted ml-1">(${appliedCoupon.code})</small>` : '';
                            
                            couponArea.innerHTML = `
                                <div class="summary-row discount-row">
                                    <span>Discount ${detailHtml} ${codeHtml}</span>
                                    <span id="summary-discount">-$${discountFormatted}</span>
                                </div>
                            `;
                        } else {
                            document.getElementById('summary-discount').textContent = '-$' + discountFormatted;
                        }
                    }

                    document.getElementById('summary-total').textContent = '$' + data.cart.total.toLocaleString('en-US', {maximumFractionDigits: 0});
                    
                    // Update header cart badge
                    const badges = document.querySelectorAll('.badge');
                    badges.forEach(b => b.textContent = data.count);
                }
            })
            .catch(err => console.error('Error:', err));
        });
    });

    // Coupon Application
    const applyBtn = document.getElementById('apply-coupon');
    if (applyBtn) {
        applyBtn.addEventListener('click', function() {
            const code = document.getElementById('coupon-code').value;
            if (!code) return;

            this.textContent = '...';
            this.disabled = true;

            fetch('{{ route("cart.coupon.apply") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ coupon_code: code })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload(); // Simple reload for now to show applied state properly
                } else {
                    alert(data.message || 'Invalid coupon code');
                    this.textContent = 'Apply';
                    this.disabled = false;
                }
            })
            .catch(err => {
                console.error('Error:', err);
                this.textContent = 'Apply';
                this.disabled = false;
            });
        });
    }

    // Coupon Removal
    const removeBtn = document.getElementById('remove-coupon');
    if (removeBtn) {
        removeBtn.addEventListener('click', function() {
            fetch('{{ route("cart.coupon.remove") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                location.reload();
            })
            .catch(err => console.error('Error:', err));
        });
    }
});
</script>
@endpush
