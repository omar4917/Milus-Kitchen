@extends('layouts.app')

@section('title', 'My Orders')

@push('styles')
<style>
    :root {
        --grad-purple: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
        --glass-bg: rgba(255, 255, 255, 0.7);
        --glass-border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .user-panel-section {
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
        padding: 30px;
    }

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

    .order-item-card {
        background: white;
        border-radius: 20px;
        padding: 25px;
        margin-bottom: 20px;
        border: 1px solid #f1f5f9;
        transition: all 0.3s ease;
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02);
    }

    .order-item-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 20px -5px rgba(0,0,0,0.05);
        border-color: #e2e8f0;
    }

    .status-pill {
        padding: 6px 16px;
        border-radius: 50px;
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-pending { background: #fef3c7; color: #d97706; }
    .status-confirmed { background: #e0f2fe; color: #0369a1; }
    .status-preparing { background: #e0e7ff; color: #4338ca; }
    .status-delivered { background: #d1fae5; color: #059669; }
    .status-cancelled { background: #fee2e2; color: #dc2626; }
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
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <h5 class="mb-1" style="font-weight: 800;">{{ auth()->user()->name }}</h5>
                        <p class="text-muted small mb-0">{{ auth()->user()->email }}</p>
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
                <div class="glass-card">
                    <h3 class="mb-4" style="font-weight: 800;">Order History</h3>
                    
                    @if($orders->count() > 0)
                        @foreach($orders as $order)
                        <div class="order-item-card">
                            <div class="row align-items-center">
                                <div class="col-md-7">
                                    <div class="d-flex align-items-center gap-3 mb-2">
                                        <h5 class="mb-0" style="font-weight: 800; color: #1e293b;">#{{ $order->order_number }}</h5>
                                        @php
                                            $statusKey = $order->status;
                                            if (!in_array($statusKey, ['pending', 'confirmed', 'preparing', 'delivered', 'cancelled'])) {
                                                $statusKey = 'pending';
                                            }
                                        @endphp
                                        <span class="status-pill status-{{ $statusKey }}">
                                            {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                        </span>
                                    </div>
                                    <p class="text-muted small mb-3">
                                        <span class="mr-3">📅 {{ $order->created_at->format('M d, Y') }}</span>
                                        <span>⏰ {{ $order->created_at->format('h:i A') }}</span>
                                    </p>
                                    <div class="d-flex align-items-center">
                                        <span class="text-muted mr-2">Total Amount:</span>
                                        <span style="font-weight: 700; color: #ff7a5c; font-size: 1.1rem;">${{ number_format($order->total, 2) }}</span>
                                    </div>
                                </div>
                                <div class="col-md-5 text-md-right mt-3 mt-md-0 d-flex gap-2 justify-content-md-end">
                                    <form action="{{ route('user.orders.reorder', $order) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-light px-4" style="border-radius: 12px; font-weight: 700; border: 1px solid #e2e8f0;">Reorder</button>
                                    </form>
                                    <a href="{{ route('user.orders.show', $order) }}" class="btn btn-primary px-4" style="border-radius: 12px; font-weight: 700; box-shadow: 0 4px 12px rgba(255,122,92,0.25);">Track Order</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        
                        <div class="mt-4 pagination-modern">
                            {{ $orders->links() }}
                        </div>
                    @else
                        <div class="text-center py-5" style="border: 2px dashed #e2e8f0; border-radius: 20px;">
                            <div class="mb-3" style="font-size: 3rem;">📦</div>
                            <h5 style="font-weight: 700; color: #64748b;">No orders found</h5>
                            <p class="text-muted">You haven't placed any orders yet.</p>
                            <a href="{{ route('menu') }}" class="btn px-4 py-2" style="background: #ff7a5c; color: white; border-radius: 50px; font-weight: 700;">Start Ordering</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
