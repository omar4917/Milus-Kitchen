@extends('layouts.app')

@section('title', 'My Profile')

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
                    </div>
                    <hr>
                    <nav class="nav flex-column">
                        <a href="{{ route('user.dashboard') }}" class="nav-link" style="color: #333; padding: 10px 0;">📊 Dashboard</a>
                        <a href="{{ route('user.orders') }}" class="nav-link" style="color: #333; padding: 10px 0;">📦 My Orders</a>
                        <a href="{{ route('user.profile') }}" class="nav-link active" style="color: #ff7a5c; padding: 10px 0; font-weight: bold;">👤 Profile</a>
                    </nav>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div style="background: white; border-radius: 15px; padding: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
                    <h3 class="mb-4">Profile Settings</h3>
                    
                    <form action="{{ route('user.profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>Full Name</label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>Email</label>
                                    <input type="email" class="form-control" value="{{ $user->email }}" disabled>
                                    <small class="text-muted">Email cannot be changed</small>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label>Phone Number</label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $user->phone) }}">
                            @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <hr class="my-4">
                        <h5>Change Password</h5>
                        <p class="text-muted">Leave blank to keep current password</p>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>New Password</label>
                                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                                    @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>Confirm New Password</label>
                                    <input type="password" name="password_confirmation" class="form-control">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
