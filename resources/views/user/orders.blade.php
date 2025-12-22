@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
<div class="section bg-light">
    <div class="container">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 mb-4">
                <div style="background: white; border-radius: 15px; padding: 25px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
                    <div class="text-center mb-4">
                        <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #ff7a5c 0%, #ff5733 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; font-size: 2rem; color: white;">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <h5>{{ auth()->user()->name }}</h5>
                    </div>
                    <hr>
                    <nav class="nav flex-column">
                        <a href="{{ route('user.dashboard') }}" class="nav-link" style="color: #333; padding: 10px 0;">📊 Dashboard</a>
                        <a href="{{ route('user.orders') }}" class="nav-link active" style="color: #ff7a5c; padding: 10px 0; font-weight: bold;">📦 My Orders</a>
                        <a href="{{ route('user.profile') }}" class="nav-link" style="color: #333; padding: 10px 0;">👤 Profile</a>
                    </nav>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9">
                <div style="background: white; border-radius: 15px; padding: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
                    <h3 class="mb-4">Order History</h3>
                    
                    @if($orders->count() > 0)
                        @foreach($orders as $order)
                        <div style="border: 1px solid #eee; border-radius: 10px; padding: 20px; margin-bottom: 15px;">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h5>Order #{{ $order->order_number }}</h5>
                                    <p class="text-muted mb-2">{{ $order->created_at->format('F d, Y \a\t h:i A') }}</p>
                                    <p class="mb-0"><strong>Total:</strong> ${{ number_format($order->total, 2) }}</p>
                                </div>
                                <div class="text-right">
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
                                    <span style="background: {{ $statusColors[$order->status] ?? '#6c757d' }}; color: white; padding: 5px 15px; border-radius: 20px; font-size: 0.85rem;">
                                        {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                    </span>
                                    <br><br>
                                    <a href="{{ route('user.orders.show', $order) }}" class="btn btn-sm btn-primary">Track Order</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        
                        {{ $orders->links() }}
                    @else
                        <div class="text-center py-5">
                            <h4>No orders yet</h4>
                            <p class="text-muted">When you place an order, it will appear here.</p>
                            <a href="{{ route('menu') }}" class="btn btn-primary">Browse Menu</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
