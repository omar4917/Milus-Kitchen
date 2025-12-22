@extends('layouts.app')

@section('title', 'My Dashboard')

@section('content')
<div class="section bg-light">
    <div class="container">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 mb-4">
                <div style="background: white; border-radius: 15px; padding: 25px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
                    <div class="text-center mb-4">
                        <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #ff7a5c 0%, #ff5733 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; font-size: 2rem; color: white;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <h5>{{ $user->name }}</h5>
                        <small class="text-muted">{{ $user->email }}</small>
                    </div>
                    <hr>
                    <nav class="nav flex-column">
                        <a href="{{ route('user.dashboard') }}" class="nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}" style="color: #333; padding: 10px 0;">
                            📊 Dashboard
                        </a>
                        <a href="{{ route('user.orders') }}" class="nav-link {{ request()->routeIs('user.orders*') ? 'active' : '' }}" style="color: #333; padding: 10px 0;">
                            📦 My Orders
                        </a>
                        <a href="{{ route('user.profile') }}" class="nav-link {{ request()->routeIs('user.profile') ? 'active' : '' }}" style="color: #333; padding: 10px 0;">
                            👤 Profile
                        </a>
                        <hr>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-link nav-link" style="color: #dc3545; padding: 10px 0;">
                                🚪 Logout
                            </button>
                        </form>
                    </nav>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div style="background: white; border-radius: 15px; padding: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
                    <h3 class="mb-4">Welcome back, {{ $user->name }}! 👋</h3>
                    
                    <div class="row mb-4">
                        <div class="col-md-4 mb-3">
                            <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 10px; padding: 20px; color: white;">
                                <h5>Total Orders</h5>
                                <h2>{{ $recentOrders->count() }}</h2>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border-radius: 10px; padding: 20px; color: white;">
                                <h5>Pending</h5>
                                <h2>{{ $recentOrders->where('status', 'pending')->count() }}</h2>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); border-radius: 10px; padding: 20px; color: white;">
                                <h5>Delivered</h5>
                                <h2>{{ $recentOrders->where('status', 'delivered')->count() }}</h2>
                            </div>
                        </div>
                    </div>

                    <h4 class="mb-3">Recent Orders</h4>
                    @if($recentOrders->count() > 0)
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Order #</th>
                                        <th>Date</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentOrders as $order)
                                    <tr>
                                        <td><strong>{{ $order->order_number }}</strong></td>
                                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                                        <td>${{ number_format($order->total, 2) }}</td>
                                        <td>
                                            @php
                                                $statusColors = [
                                                    'pending' => 'warning',
                                                    'confirmed' => 'info',
                                                    'preparing' => 'primary',
                                                    'out_for_delivery' => 'secondary',
                                                    'delivered' => 'success',
                                                    'cancelled' => 'danger',
                                                ];
                                            @endphp
                                            <span class="badge badge-{{ $statusColors[$order->status] ?? 'secondary' }}">
                                                {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('user.orders.show', $order) }}" class="btn btn-sm btn-outline-primary">View</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <a href="{{ route('user.orders') }}" class="btn btn-primary">View All Orders</a>
                    @else
                        <div class="text-center py-5">
                            <p class="text-muted">No orders yet. <a href="{{ route('menu') }}">Browse our menu</a> to get started!</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
