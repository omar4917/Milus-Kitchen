@extends('layouts.app')

@section('title', 'Order #' . $order->order_number)

@section('content')
<div class="section bg-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <a href="{{ route('user.orders') }}" class="btn btn-link mb-3">← Back to Orders</a>
                
                <div style="background: white; border-radius: 15px; padding: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3>Order #{{ $order->order_number }}</h3>
                        @php
                            $statusColors = [
                                'pending' => '#ffc107',
                                'confirmed' => '#17a2b8',
                                'preparing' => '#007bff',
                                'out_for_delivery' => '#6c757d',
                                'delivered' => '#28a745',
                                'cancelled' => '#dc3545',
                            ];
                        @endphp
                        <span style="background: {{ $statusColors[$order->status] ?? '#6c757d' }}; color: white; padding: 8px 20px; border-radius: 25px; font-weight: bold;">
                            {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                        </span>
                    </div>

                    <!-- Order Tracking -->
                    <div class="mb-5">
                        <h5 class="mb-4">Order Tracking</h5>
                        @php
                            $steps = ['pending', 'confirmed', 'preparing', 'out_for_delivery', 'delivered'];
                            $currentIndex = array_search($order->status, $steps);
                            if ($order->status === 'cancelled') $currentIndex = -1;
                        @endphp
                        <div class="d-flex justify-content-between" style="position: relative;">
                            <div style="position: absolute; top: 15px; left: 10%; right: 10%; height: 4px; background: #eee; z-index: 0;"></div>
                            <div style="position: absolute; top: 15px; left: 10%; height: 4px; background: #28a745; z-index: 1; width: {{ max(0, min(100, ($currentIndex / 4) * 80)) }}%;"></div>
                            
                            @foreach(['Pending', 'Confirmed', 'Preparing', 'Out for Delivery', 'Delivered'] as $i => $step)
                            <div class="text-center" style="z-index: 2; flex: 1;">
                                <div style="width: 35px; height: 35px; border-radius: 50%; margin: 0 auto 10px; display: flex; align-items: center; justify-content: center; font-size: 0.9rem;
                                    @if($i <= $currentIndex) background: #28a745; color: white; @else background: #eee; color: #999; @endif">
                                    @if($i < $currentIndex) ✓ @else {{ $i + 1 }} @endif
                                </div>
                                <small style="font-size: 0.75rem;">{{ $step }}</small>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <h5>Delivery Details</h5>
                            <p><strong>{{ $order->customer_name }}</strong></p>
                            <p>{{ $order->customer_phone }}</p>
                            <p>{{ $order->customer_email }}</p>
                            <p>{{ $order->delivery_address }}</p>
                            <p><strong>Type:</strong> {{ ucfirst($order->delivery_type) }}</p>
                        </div>
                        <div class="col-md-6 mb-4">
                            <h5>Payment Info</h5>
                            <p><strong>Method:</strong> {{ strtoupper($order->payment_method ?? 'COD') }}</p>
                            <p><strong>Status:</strong> {{ ucfirst($order->payment_status ?? 'Pending') }}</p>
                            @if($order->notes)
                            <p><strong>Notes:</strong> {{ $order->notes }}</p>
                            @endif
                        </div>
                    </div>

                    <h5 class="mb-3">Order Items</h5>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th class="text-right">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td>{{ $item->name }}</td>
                                    <td>${{ number_format($item->price, 2) }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td class="text-right">${{ number_format($item->price * $item->quantity, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-right"><strong>Subtotal</strong></td>
                                    <td class="text-right">${{ number_format($order->subtotal, 2) }}</td>
                                </tr>
                                @if($order->discount_amount > 0)
                                <tr class="text-success">
                                    <td colspan="3" class="text-right">Discount</td>
                                    <td class="text-right">-${{ number_format($order->discount_amount, 2) }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <td colspan="3" class="text-right">Delivery Fee</td>
                                    <td class="text-right">${{ number_format($order->delivery_fee, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-right"><strong>Total</strong></td>
                                    <td class="text-right"><strong>${{ number_format($order->total, 2) }}</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <p class="text-muted text-center mt-4">
                        Order placed on {{ $order->created_at->format('F d, Y \a\t h:i A') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
