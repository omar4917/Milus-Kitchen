@extends('layouts.app')

@section('title', 'My Profile')

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

    .form-label {
        font-weight: 700;
        color: #1e293b;
        font-size: 0.9rem;
        margin-bottom: 8px;
    }

    .form-control-modern {
        background: #f1f5f9;
        border: 1px solid transparent;
        border-radius: 12px;
        padding: 12px 18px;
        font-weight: 500;
        color: #334155;
        transition: all 0.3s ease;
    }

    .form-control-modern:focus {
        background: white;
        border-color: #ff7a5c;
        box-shadow: 0 0 0 4px rgba(255, 122, 92, 0.1);
        outline: none;
    }

    .form-control-modern:disabled {
        background: #e2e8f0;
        opacity: 0.7;
        cursor: not-allowed;
    }
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
                    <h3 class="mb-4" style="font-weight: 800;">Profile Settings</h3>
                    
                    <form action="{{ route('user.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" name="name" class="form-control-modern w-100 @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label class="form-label">Email Address</label>
                                    <input type="email" class="form-control-modern w-100" value="{{ $user->email }}" disabled>
                                    <small class="text-muted mt-1 d-block" style="font-size: 0.75rem;">Email cannot be changed</small>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label class="form-label">Phone Number</label>
                                    <input type="text" name="phone" class="form-control-modern w-100 @error('phone') is-invalid @enderror" value="{{ old('phone', $user->phone) }}" placeholder="e.g. +1 234 567 890">
                                    @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label class="form-label">Delivery Address</label>
                                    <input type="text" name="address" class="form-control-modern w-100 @error('address') is-invalid @enderror" value="{{ old('address', $user->address) }}" placeholder="Your default delivery address">
                                    @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>

                        <div class="mt-5 mb-4 pt-4 border-top">
                            <h5 style="font-weight: 800; color: #1e293b;">Notification Preferences</h5>
                            <p class="text-muted small">Choose how you want to be notified about your order status changes.</p>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="glass-card p-3 mb-2" style="border-radius: 16px; background: rgba(255,255,255,0.4);">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" name="notification_prefs[email]" class="custom-control-input" id="prefEmail" value="1" {{ ($user->notification_prefs['email'] ?? true) ? 'checked' : '' }}>
                                        <label class="custom-control-label font-weight-bold" for="prefEmail">Email Notifications</label>
                                        <p class="text-muted small mb-0">Receive order confirmations and status updates via email.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="glass-card p-3 mb-2" style="border-radius: 16px; background: rgba(255,255,255,0.4);">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" name="notification_prefs[in_app]" class="custom-control-input" id="prefInApp" value="1" {{ ($user->notification_prefs['in_app'] ?? true) ? 'checked' : '' }}>
                                        <label class="custom-control-label font-weight-bold" for="prefInApp">In-App Notifications</label>
                                        <p class="text-muted small mb-0">See alerts with the bell icon in your account header.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-5 mb-4 pt-4 border-top">
                            <h5 style="font-weight: 800; color: #1e293b;">Security & Password</h5>
                            <p class="text-muted small">Update your password to keep your account secure. Leave blank to keep current password.</p>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label class="form-label">New Password</label>
                                    <input type="password" name="password" class="form-control-modern w-100 @error('password') is-invalid @enderror">
                                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-4">
                                    <label class="form-label">Confirm New Password</label>
                                    <input type="password" name="password_confirmation" class="form-control-modern w-100">
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn px-5 py-3" style="background: #ff7a5c; color: white; border-radius: 15px; font-weight: 800; box-shadow: 0 10px 20px rgba(255,122,92,0.25);">Save Profile Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
