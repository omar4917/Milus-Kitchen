@extends('layouts.app')

@section('title', 'My Notifications')

@push('styles')
<style>
    :root {
        --grad-purple: linear-gradient(135deg, #6366f1 0%, #a855f7 100%);
        --glass-bg: rgba(255, 255, 255, 0.7);
        --glass-border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .notifications-section {
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

    .notification-item {
        background: white;
        padding: 20px;
        border-radius: 16px;
        margin-bottom: 12px;
        border: 1px solid #e2e8f0;
        display: flex;
        gap: 15px;
        transition: all 0.3s ease;
    }

    .notification-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        border-color: #ff7a5c;
    }

    .noti-icon {
        width: 48px;
        height: 48px;
        background: #f1f5f9;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    .noti-content {
        flex: 1;
    }

    .noti-time {
        font-size: 0.75rem;
        color: #94a3b8;
        margin-bottom: 5px;
    }

    .noti-message {
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 5px;
    }

    .noti-action {
        font-size: 0.8rem;
        font-weight: 700;
        color: #ff7a5c;
        text-decoration: none;
    }

    .noti-action:hover {
        color: #ff5733;
    }
</style>
@endpush

@section('content')
<div class="notifications-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-3 mb-4">
                <div class="glass-card user-sidebar" style="position: sticky; top: 100px;">
                    <nav class="nav flex-column nav-user-panel">
                        <a href="{{ route('user.dashboard') }}" class="nav-link">
                            <span>📊</span> Dashboard
                        </a>
                        <a href="{{ route('user.orders') }}" class="nav-link">
                            <span>📦</span> My Orders
                        </a>
                        <a href="{{ route('user.notifications') }}" class="nav-link active" style="background: #ff7a5c; color: white !important;">
                            <span>🔔</span> Notifications
                        </a>
                        <a href="{{ route('user.profile') }}" class="nav-link">
                            <span>👤</span> Profile
                        </a>
                    </nav>
                </div>
            </div>

            <div class="col-md-9">
                <div class="glass-card">
                    <h3 class="mb-4" style="font-weight: 800;">Recent Updates</h3>
                    
                    @if($notifications->count() > 0)
                        @foreach($notifications as $notification)
                            <div class="notification-item">
                                <div class="noti-icon">
                                    @if(isset($notification->data['status']))
                                        @if($notification->data['status'] == 'completed') 🎁
                                        @elseif($notification->data['status'] == 'cancelled') ❌
                                        @else 📦
                                        @endif
                                    @endif
                                </div>
                                <div class="noti-content">
                                    <div class="noti-time">{{ $notification->created_at->diffForHumans() }}</div>
                                    <div class="noti-message">{{ $notification->data['message'] ?? 'Status update for your order.' }}</div>
                                    <a href="{{ $notification->data['action_url'] ?? '#' }}" class="noti-action">View Order Details →</a>
                                </div>
                            </div>
                        @endforeach

                        <div class="mt-4">
                            {{ $notifications->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div style="font-size: 4rem; opacity: 0.2; margin-bottom: 20px;">📭</div>
                            <h5 style="font-weight: 700; color: #64748b;">No new notifications</h5>
                            <p class="text-muted">We'll notify you when your order status changes.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
