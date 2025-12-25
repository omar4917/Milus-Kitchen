@extends('layouts.app')

@section('title', 'Order #' . $order->order_number)

@push('styles')
<style>
    :root {
        --grad-purple: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
        --grad-rose: linear-gradient(135deg, #fb7185 0%, #e11d48 100%);
        --grad-sky: linear-gradient(135deg, #38bdf8 0%, #0ea5e9 100%);
        --glass-bg: rgba(255, 255, 255, 0.7);
        --glass-border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .order-detail-section {
        padding: 80px 0;
        background: #f8fafc;
        min-height: 80vh;
    }

    .glass-card {
        background: var(--glass-bg);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border: var(--glass-border);
        border-radius: 24px;
        box-shadow: 0 10px 40px -10px rgba(0,0,0,0.05);
        padding: 40px;
    }

    /* Tracking Timeline */
    .tracking-wrapper {
        padding: 40px 0;
        margin-bottom: 40px;
        position: relative;
    }

    .tracking-line {
        position: absolute;
        top: 60px;
        left: 5%;
        right: 5%;
        height: 4px;
        background: #e2e8f0;
        z-index: 1;
        border-radius: 10px;
    }

    .tracking-line-progress {
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        background: var(--grad-purple);
        transition: width 1s cubic-bezier(0.4, 0, 0.2, 1);
        border-radius: 10px;
        box-shadow: 0 0 15px rgba(99, 102, 241, 0.3);
    }

    .tracking-step {
        position: relative;
        z-index: 2;
        text-align: center;
        flex: 1;
    }

    .step-icon {
        width: 45px;
        height: 45px;
        background: white;
        border: 4px solid #e2e8f0;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 15px;
        font-weight: 800;
        color: #94a3b8;
        transition: all 0.4s ease;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);
    }

    .tracking-step.active .step-icon {
        background: var(--grad-purple);
        border-color: white;
        color: white;
        transform: scale(1.2);
        box-shadow: 0 10px 20px rgba(99, 102, 241, 0.3);
    }

    .step-label {
        font-size: 0.85rem;
        font-weight: 700;
        color: #64748b;
        transition: color 0.3s ease;
    }

    .tracking-step.active .step-label {
        color: #1e293b;
    }

    /* Info Blocks */
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 30px;
        margin-bottom: 40px;
    }

    .info-block {
        background: #f1f5f9;
        padding: 25px;
        border-radius: 20px;
        border: 1px solid rgba(255,255,255,0.5);
    }

    .info-block h5 {
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* Items Table */
    .items-table th {
        background: transparent;
        border: none;
        color: #64748b;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .items-table td {
        background: transparent;
        border-bottom: 1px solid #e2e8f0;
        padding: 20px 10px;
        vertical-align: middle;
    }
</style>
@endpush

@section('content')
<div class="order-detail-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-11">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <a href="{{ route('user.orders') }}" class="btn btn-light shadow-sm" style="border-radius: 12px; font-weight: 700; padding: 10px 20px;">
                        ← Back to Orders
                    </a>
                    <form action="{{ route('user.orders.reorder', $order) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-primary shadow-lg" style="border-radius: 12px; font-weight: 700; padding: 10px 25px; box-shadow: 0 8px 20px rgba(255, 122, 92, 0.25);">
                            Reorder This Plan
                        </button>
                    </form>
                </div>
                
                <div class="glass-card">
                    <div class="d-flex justify-content-between align-items-start mb-5 pb-4 border-bottom">
                        <div>
                            <h2 class="mb-1" style="font-weight: 800; color: #1e293b;">Order #{{ $order->order_number }}</h2>
                            <p class="text-muted mb-0">Placed on {{ $order->created_at->format('F d, Y \a\t h:i A') }}</p>
                        </div>
                        @php
                            $statusMap = [
                                'pending' => ['bg' => '#fef3c7', 'color' => '#d97706', 'icon' => '⏳'],
                                'confirmed' => ['bg' => '#e0f2fe', 'color' => '#0369a1', 'icon' => '✅'],
                                'preparing' => ['bg' => '#e0e7ff', 'color' => '#4338ca', 'icon' => '🍳'],
                                'out_for_delivery' => ['bg' => '#f1f5f9', 'color' => '#475569', 'icon' => '🚚'],
                                'delivered' => ['bg' => '#d1fae5', 'color' => '#059669', 'icon' => '🎁'],
                                'cancelled' => ['bg' => '#fee2e2', 'color' => '#dc2626', 'icon' => '❌'],
                            ];
                            $currStatus = $statusMap[$order->status] ?? $statusMap['pending'];
                        @endphp
                        <span style="background: {{ $currStatus['bg'] }}; color: {{ $currStatus['color'] }}; padding: 10px 25px; border-radius: 50px; font-weight: 800; font-size: 0.9rem; letter-spacing: 0.5px;">
                            {{ $currStatus['icon'] }} {{ strtoupper(str_replace('_', ' ', $order->status)) }}
                        </span>
                    </div>

                    <!-- Tracking Timeline -->
                    @if($order->status !== 'cancelled')
                        <div class="tracking-wrapper">
                            <h5 class="mb-5" style="font-weight: 800; color: #1e293b;">Order Journey</h5>
                            @php
                                $steps = ['pending', 'confirmed', 'preparing', 'out_for_delivery', 'delivered'];
                                $currentIndex = array_search($order->status, $steps);
                                $labels = ['Placed', 'Confirmed', 'Preparing', 'On the Way', 'Delivered'];
                                $icons = ['🛒', '📋', '👨‍🍳', '🚴', '🏠'];
                            @endphp
                            <div class="d-flex justify-content-between position-relative">
                                <div class="tracking-line">
                                    <div class="tracking-line-progress" style="width: {{ ($currentIndex / (count($steps)-1)) * 100 }}%"></div>
                                </div>
                                
                                @foreach($steps as $i => $step)
                                    <div class="tracking-step {{ $i <= $currentIndex ? 'active' : '' }}">
                                        <div class="step-icon">
                                            @if($i < $currentIndex)
                                                ✓
                                            @else
                                                {{ $icons[$i] }}
                                            @endif
                                        </div>
                                        <div class="step-label">{{ $labels[$i] }}</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <div class="info-grid">
                        <div class="info-block">
                            <h5><span>📍</span> Delivery Details</h5>
                            <p class="mb-1" style="font-weight: 700; color: #1e293b;">{{ $order->customer_name }}</p>
                            <p class="text-muted small mb-3">{{ $order->customer_phone }} | {{ $order->customer_email }}</p>
                            <div style="background: white; padding: 12px; border-radius: 12px; font-size: 0.9rem;">
                                {{ $order->delivery_address }}
                            </div>
                            <p class="mt-3 mb-0 small text-uppercase" style="letter-spacing: 1px; font-weight: 700; color: #ff7a5c;">
                                Type: {{ $order->delivery_type }}
                            </p>
                        </div>
                        
                        <div class="info-block">
                            <h5><span>💳</span> Payment & Notes</h5>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">Method:</span>
                                <span style="font-weight: 700; color: #1e293b;">{{ strtoupper($order->payment_method) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span class="text-muted">Status:</span>
                                <span style="font-weight: 700; color: #10b981;">PAID</span>
                            </div>
                            @if($order->notes)
                                <div style="background: #e2e8f0; padding: 12px; border-radius: 12px; font-size: 0.9rem;">
                                    <strong>Notes:</strong> {{ $order->notes }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <h4 class="mb-4" style="font-weight: 800; color: #1e293b;">Items Summary</h4>
                    <div class="table-responsive">
                        <table class="table items-table">
                            <thead>
                                <tr>
                                    <th>Item Details</th>
                                    <th class="text-center">Price</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td>
                                        <div style="font-weight: 700; color: #1e293b;">{{ $item->item_name }}</div>
                                    </td>
                                    <td class="text-center">${{ number_format($item->unit_price, 2) }}</td>
                                    <td class="text-center"><span style="background: #e2e8f0; padding: 4px 12px; border-radius: 8px; font-weight: 700;">{{ $item->quantity }}</span></td>
                                    <td class="text-right" style="font-weight: 700; color: #1e293b;">${{ number_format($item->line_total, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="row justify-content-end mt-4">
                        <div class="col-md-4">
                            <div style="background: #f8fafc; padding: 25px; border-radius: 20px;">
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Subtotal</span>
                                    <span style="font-weight: 700;">${{ number_format($order->subtotal, 2) }}</span>
                                </div>
                                @if($order->discount_amount > 0)
                                <div class="d-flex justify-content-between mb-2 text-success">
                                    <span>Discount ({{ $order->coupon_code }})</span>
                                    <span style="font-weight: 700;">-${{ number_format($order->discount_amount, 2) }}</span>
                                </div>
                                @endif
                                <div class="d-flex justify-content-between mb-3 pb-3 border-bottom">
                                    <span class="text-muted">Delivery Fee</span>
                                    <span style="font-weight: 700;">${{ number_format($order->delivery_fee, 2) }}</span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <h5 class="mb-0" style="font-weight: 800; color: #ff7a5c;">Grand Total</h5>
                                    <h5 class="mb-0" style="font-weight: 800; color: #ff7a5c;">${{ number_format($order->total, 2) }}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
