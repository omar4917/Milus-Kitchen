@extends('layouts.app')

@section('title', 'Order Confirmed')

@section('content')
<section class="confirmation-page">
    <div class="container">
        <div class="confirmation-card">
            <div class="confirmation-header">
                <div class="success-icon">✓</div>
                <h1>Order Confirmed!</h1>
                <p class="order-number">Order #{{ $order->order_number }}</p>
            </div>

            <div class="confirmation-message">
                <p>Thank you, <strong>{{ $order->customer_name }}</strong>! Your order has been placed successfully.</p>
                @if($order->customer_email)
                <p>A confirmation email has been sent to <strong>{{ $order->customer_email }}</strong>.</p>
                @endif
            </div>

            <div class="order-details">
                <h3>Order Details</h3>
                
                <div class="detail-row">
                    <span class="label">{{ $order->isDelivery() ? 'Delivery' : 'Pickup' }}</span>
                    <span class="value">
                        {{ $order->preferred_date->format('D, M d, Y') }} at {{ $order->time_slot }}
                    </span>
                </div>

                @if($order->isDelivery())
                <div class="detail-row">
                    <span class="label">Address</span>
                    <span class="value">{{ $order->delivery_address }}</span>
                </div>
                @endif

                <div class="detail-row">
                    <span class="label">Payment</span>
                    <span class="value">{{ $order->payment_method_label }}</span>
                </div>

                @if($order->transaction_id)
                <div class="detail-row">
                    <span class="label">Transaction ID</span>
                    <span class="value">{{ $order->transaction_id }}</span>
                </div>
                @endif
            </div>

            <div class="order-items">
                <h3>Items Ordered</h3>
                @foreach($order->items as $item)
                <div class="order-item">
                    <span class="item-qty">{{ $item->quantity }}x</span>
                    <span class="item-name">{{ $item->item_name }}</span>
                    <span class="item-price">${{ number_format($item->line_total, 0) }}</span>
                </div>
                @endforeach
            </div>

            <div class="order-totals">
                <div class="total-row">
                    <span>Subtotal</span>
                    <span>${{ number_format($order->subtotal, 0) }}</span>
                </div>
                @if($order->delivery_fee > 0)
                <div class="total-row">
                    <span>Delivery Fee</span>
                    <span>${{ number_format($order->delivery_fee, 0) }}</span>
                </div>
                @endif
                <div class="total-row total-final">
                    <span>Total</span>
                    <span>${{ number_format($order->total, 0) }}</span>
                </div>
            </div>

            <div class="confirmation-footer">
                <p>Questions about your order? Contact us:</p>
                <p class="contact-info">📞 +880 1XXX-XXXXXX</p>
                <a href="{{ route('menu') }}" class="btn btn-primary">Order More</a>
            </div>
        </div>
    </div>
</section>
@endsection
