@extends('layouts.app')

@section('title', 'My Dashboard')

@push('styles')
<style>
    :root {
        --grad-purple: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
        --grad-rose: linear-gradient(135deg, #fb7185 0%, #e11d48 100%);
        --grad-sky: linear-gradient(135deg, #38bdf8 0%, #0ea5e9 100%);
        --glass-bg: rgba(255, 255, 255, 0.7);
        --glass-border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .user-panel-section {
        padding: 80px 0;
        background: #f8fafc;
        min-height: 80vh;
    }

    /* Glassmorphic Cards */
    .glass-card {
        background: var(--glass-bg);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border: var(--glass-border);
        border-radius: 24px;
        box-shadow: 0 10px 40px -10px rgba(0,0,0,0.05);
        padding: 30px;
        transition: transform 0.3s ease;
    }

    /* Sidebar Styles */
    .user-sidebar {
        position: sticky;
        top: 100px;
    }

    .user-avatar {
        width: 100px;
        height: 100px;
        background: var(--grad-purple);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 2.5rem;
        color: white;
        font-weight: 700;
        box-shadow: 0 10px 25px rgba(99, 102, 241, 0.4);
        border: 4px solid white;
    }

    .nav-user-panel .nav-link {
        color: #475569 !important;
        padding: 15px 20px;
        border-radius: 12px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 8px;
        transition: all 0.3s ease;
    }

    .nav-user-panel .nav-link:hover {
        background: rgba(255, 122, 92, 0.05);
        color: #ff7a5c !important;
        padding-left: 25px;
    }

    .nav-user-panel .nav-link.active {
        background: #ff7a5c;
        color: white !important;
        box-shadow: 0 8px 20px rgba(255, 122, 92, 0.25);
    }

    /* Stats Cards */
    .stat-vibrant {
        padding: 25px;
        border-radius: 20px;
        color: white;
        position: relative;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border: none;
    }

    .stat-vibrant:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    }

    .stat-vibrant::after {
        content: '';
        position: absolute;
        top: -20px;
        right: -20px;
        width: 80px;
        height: 80px;
        background: rgba(255,255,255,0.15);
        border-radius: 50%;
    }

    .stat-vibrant h5 {
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 10px;
        opacity: 0.9;
        font-weight: 700;
    }

    .stat-vibrant h2 {
        font-size: 2.5rem;
        font-weight: 800;
        margin: 0;
    }

    /* Table Styles */
    .custom-table {
        margin-top: 20px;
    }

    .custom-table thead th {
        background: #f1f5f9;
        border: none;
        padding: 15px 20px;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #64748b;
        border-radius: 10px;
    }

    .custom-table tbody td {
        padding: 20px;
        vertical-align: middle;
        border-bottom: 1px solid #f1f5f9;
    }

    .status-badge {
        padding: 6px 14px;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
    }

    .badge-pending { background: #fef3c7; color: #d97706; }
    .badge-delivered { background: #d1fae5; color: #059669; }
    .badge-cancelled { background: #fee2e2; color: #dc2626; }
</style>
@endpush

@section('content')
<div class="user-panel-section">
    <div class="container">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 mb-4">
                <div class="glass-card user-sidebar">
                    <div class="text-center mb-4">
                        <div class="user-avatar">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <h5 class="mb-1" style="font-weight: 800;">{{ $user->name }}</h5>
                        <p class="text-muted small mb-0">{{ $user->email }}</p>
                    </div>
                    
                    <nav class="nav flex-column nav-user-panel">
                        <a href="{{ route('user.dashboard') }}" class="nav-link {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
                            <span>📊</span> Dashboard
                        </a>
                        <a href="{{ route('user.orders') }}" class="nav-link {{ request()->routeIs('user.orders*') ? 'active' : '' }}">
                            <span>📦</span> My Orders
                        </a>
                        <a href="{{ route('user.profile') }}" class="nav-link {{ request()->routeIs('user.profile') ? 'active' : '' }}">
                            <span>👤</span> Profile
                        </a>
                        <div class="mt-4 pt-4 border-top">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="nav-link border-0 bg-transparent w-100 text-left" style="color: #ef4444 !important;">
                                    <span>🚪</span> Logout
                                </button>
                            </form>
                        </div>
                    </nav>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9">
                @if(session('success'))
                    <div class="alert alert-success border-0 shadow-sm mb-4" style="border-radius: 15px;">{{ session('success') }}</div>
                @endif

                <div class="glass-card">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h3 class="mb-0" style="font-weight: 800;">Welcome back, {{ $user->name }}! 👋</h3>
                    </div>
                    
                    <div class="row mb-5">
                        <div class="col-md-4 mb-3">
                            <div class="stat-vibrant" style="background: var(--grad-purple);">
                                <h5>Total Orders</h5>
                                <h2>{{ $recentOrders->count() }}</h2>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="stat-vibrant" style="background: var(--grad-rose);">
                                <h5>Pending</h5>
                                <h2>{{ $recentOrders->where('status', 'pending')->count() }}</h2>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="stat-vibrant" style="background: var(--grad-sky);">
                                <h5>Delivered</h5>
                                <h2>{{ $recentOrders->where('status', 'delivered')->count() }}</h2>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h4 style="font-weight: 800; color: #1e293b;">Recent Orders</h4>
                        @if($recentOrders->count() > 0)
                            <a href="{{ route('user.orders') }}" class="btn btn-sm" style="color: #ff7a5c; font-weight: 700;">View All →</a>
                        @endif
                    </div>

                    @if($recentOrders->count() > 0)
                        <div class="table-responsive">
                            <table class="table custom-table">
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
                                        <td><span style="font-weight: 800; color: #1e293b;">#{{ $order->order_number }}</span></td>
                                        <td><span class="text-muted">{{ $order->created_at->format('M d, Y') }}</span></td>
                                        <td><span style="font-weight: 700; color: #ff7a5c;">${{ number_format($order->total, 2) }}</span></td>
                                        <td>
                                            @php
                                                $statusClass = [
                                                    'pending' => 'pending',
                                                    'delivered' => 'delivered',
                                                    'cancelled' => 'cancelled',
                                                ][$order->status] ?? 'pending';
                                            @endphp
                                            <span class="status-badge badge-{{ $statusClass }}">
                                                {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                            </span>
                                        </td>
                                        <td class="text-right">
                                            <a href="{{ route('user.orders.show', $order) }}" class="btn btn-sm btn-light shadow-sm" style="border-radius: 10px; font-weight: 700;">Details</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5 border rounded-lg" style="border: 2px dashed #e2e8f0 !important; border-radius: 20px;">
                            <div class="mb-3" style="font-size: 3rem;">🛍️</div>
                            <h5 style="font-weight: 700; color: #64748b;">No orders yet!</h5>
                            <p class="text-muted">Start your food journey with us.</p>
                            <a href="{{ route('menu') }}" class="btn px-4 py-2" style="background: #ff7a5c; color: white; border-radius: 50px; font-weight: 700; box-shadow: 0 5px 15px rgba(255,122,92,0.3);">Browse Menu</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
