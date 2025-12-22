@extends('layouts.app')

@section('title', 'Order Confirmed')

@section('content')
<style>
    .confirmation-section {
        padding: 80px 0;
        background: linear-gradient(135deg, #fff5f2 0%, #fff 100%);
        min-height: 80vh;
        padding-top: 120px; /* Space for fixed header if needed */
    }
    .confirmation-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.05);
        padding: 40px;
        max-width: 800px;
        margin: 0 auto;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    .confirmation-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 6px;
        background: linear-gradient(90deg, #ff7a5c, #ff5733);
    }
    .success-icon-wrapper {
        width: 80px;
        height: 80px;
        background: #e8f5e9;
        color: #4caf50;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 40px;
        margin: 0 auto 20px;
        box-shadow: 0 10px 20px rgba(76, 175, 80, 0.2);
        animation: popIn 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }
    .order-title {
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        color: #1a1a2e;
        margin-bottom: 10px;
        font-size: 32px;
    }
    .order-number {
        font-size: 16px;
        color: #666;
        background: #f8f9fa;
        display: inline-block;
        padding: 5px 15px;
        border-radius: 50px;
        margin-bottom: 30px;
        font-weight: 500;
        letter-spacing: 0.5px;
    }
    .confirmation-message {
        font-size: 16px;
        color: #444;
        margin-bottom: 40px;
        line-height: 1.6;
    }
    
    .details-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
        text-align: left;
        margin-bottom: 40px;
    }
    @media (max-width: 768px) {
        .details-grid { grid-template-columns: 1fr; gap: 20px; }
    }
    
    .details-box {
        background: #fdfdfd;
        border: 1px solid #eee;
        border-radius: 12px;
        padding: 25px;
    }
    .details-title {
        font-weight: 600;
        color: #1a1a2e;
        border-bottom: 2px solid #ff7a5c;
        padding-bottom: 10px;
        margin-bottom: 15px;
        display: inline-block;
    }
    .info-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 12px;
        font-size: 14px;
        border-bottom: 1px dashed #eee;
        padding-bottom: 8px;
    }
    .info-row:last-child { border-bottom: none; margin-bottom: 0; }
    .info-label { color: #666; }
    .info-value { font-weight: 600; color: #333; }
    
    .item-list {
        margin-bottom: 20px;
    }
    .item-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid #f0f0f0;
    }
    .item-info { display: flex; align-items: center; gap: 10px; }
    .item-qty { 
        background: #ff7a5c; 
        color: white; 
        width: 24px; 
        height: 24px; 
        border-radius: 50%; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        font-size: 12px; 
        font-weight: bold;
    }
    .total-section {
        background: #1a1a2e;
        color: white;
        padding: 20px;
        border-radius: 12px;
        margin-top: 20px;
    }
    .total-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
        font-size: 14px;
        opacity: 0.8;
    }
    .final-total {
        font-size: 20px;
        font-weight: 700;
        border-top: 1px solid rgba(255,255,255,0.2);
        margin-top: 10px;
        padding-top: 10px;
        opacity: 1;
        color: #ff7a5c;
    }
    
    .action-buttons {
        margin-top: 40px;
        display: flex;
        justify-content: center;
        gap: 20px;
    }
    .btn-home {
        padding: 12px 30px;
        border-radius: 50px;
        font-weight: 600;
        background: #f0f0f0;
        color: #333;
        transition: all 0.3s;
    }
    .btn-home:hover { background: #e0e0e0; color: #000; text-decoration: none; }
    
    .btn-order-more {
        padding: 12px 30px;
        border-radius: 50px;
        font-weight: 600;
        background: linear-gradient(135deg, #ff7a5c 0%, #ff5733 100%);
        color: white;
        box-shadow: 0 5px 15px rgba(255, 87, 51, 0.3);
        transition: all 0.3s;
    }
    .btn-order-more:hover { 
        transform: translateY(-2px); 
        box-shadow: 0 8px 20px rgba(255, 87, 51, 0.4); 
        color: white; 
        text-decoration: none;
    }
    
    @keyframes popIn {
        0% { transform: scale(0); opacity: 0; }
        100% { transform: scale(1); opacity: 1; }
    }
</style>

<section class="confirmation-section">
    <div class="container">
        <div class="confirmation-card">
            <div class="success-icon-wrapper">
                <i class="fa fa-check"></i>
            </div>
            
            <h1 class="order-title">Order Confirmed!</h1>
            <span class="order-number">Order #{{ $order->order_number }}</span>
            
            <div class="confirmation-message">
                <p>Thank you, <strong>{{ $order->customer_name }}</strong>! Your order has been placed successfully.</p>
                <p style="font-size: 14px; color: #888;">We've sent a confirmation email to {{ $order->customer_email ?? 'your email' }}</p>
            </div>

            <div class="details-grid">
                <!-- Delivery/Pickup Info -->
                <div class="details-box">
                    <h4 class="details-title">Delivery Details</h4>
                    <div class="info-row">
                        <span class="info-label">Type:</span>
                        <span class="info-value" style="text-transform: capitalize;">{{ $order->isDelivery() ? 'Home Delivery' : 'Store Pickup' }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Date:</span>
                        <span class="info-value">{{ $order->preferred_date->format('M d, Y') }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Time:</span>
                        <span class="info-value">{{ $order->time_slot }}</span>
                    </div>
                    @if($order->isDelivery())
                    <div class="info-row" style="flex-direction: column; align-items: flex-start; gap: 5px;">
                        <span class="info-label">Address:</span>
                        <span class="info-value" style="text-align: left; line-height: 1.4;">{{ $order->delivery_address }}</span>
                    </div>
                    @endif
                    <div class="info-row">
                        <span class="info-label">Phone:</span>
                        <span class="info-value">{{ $order->customer_phone }}</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Payment:</span>
                        <span class="info-value" style="text-transform: capitalize;">{{ $order->payment_method_label }}</span>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="details-box">
                    <h4 class="details-title">Order Summary</h4>
                    <div class="item-list">
                        @foreach($order->items as $item)
                        <div class="item-row">
                            <div class="item-info">
                                <span class="item-qty">{{ $item->quantity }}</span>
                                <span class="item-name">{{ $item->item_name }}</span>
                            </div>
                            <span class="item-price">${{ number_format($item->line_total, 0) }}</span>
                        </div>
                        @endforeach
                    </div>
                    
                    <div class="total-section">
                        <div class="total-row">
                            <span>Subtotal</span>
                            <span>${{ number_format($order->subtotal, 0) }}</span>
                        </div>
                        <div class="total-row">
                            <span>Delivery Fee</span>
                            <span>{{ $order->delivery_fee > 0 ? '$'.number_format($order->delivery_fee, 0) : 'Free' }}</span>
                        </div>
                        <div class="total-row final-total">
                            <span>Total</span>
                            <span>${{ number_format($order->total, 0) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="action-buttons">
                <a href="{{ route('home') }}" class="btn-home">Go Home</a>
                <a href="{{ route('menu') }}" class="btn-order-more">Order More Food</a>
            </div>
            
            <div style="margin-top: 30px; font-size: 13px; color: #999;">
                Need help? Call us at <strong>+880 1XXX-XXXXXX</strong>
            </div>
        </div>
    </div>
</section>
@endsection
