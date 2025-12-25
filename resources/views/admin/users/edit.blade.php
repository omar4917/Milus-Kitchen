@extends('layouts.admin')

@section('page_title', 'Edit User: ' . $user->name)

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.users.show', $user) }}" class="btn btn-outline" style="border-radius: 10px; font-weight: 600; font-size: 14px; padding: 10px 20px;">
        <span class="icon ion-android-arrow-back" style="margin-right: 8px;"></span> Back to Details
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card" style="border-radius: 24px; box-shadow: 0 10px 40px rgba(0,0,0,0.04); border: 1px solid rgba(0,0,0,0.02); overflow: hidden; background: white;">
            <div class="card-header" style="background: white; border-bottom: 1px solid #f1f5f9; padding: 25px 30px;">
                <h4 style="margin: 0; font-weight: 800; color: #1e293b; font-size: 1.1rem;">Update User Information</h4>
            </div>
            <div class="card-body p-4 p-md-5">
                <form action="{{ route('admin.users.update', $user) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="form-group">
                                <label for="name" style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px; display: block;">Full Name</label>
                                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required style="border-radius: 12px; border: 1px solid #e2e8f0; padding: 12px 15px; font-size: 14px; transition: all 0.2s;">
                                @error('name') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="form-group">
                                <label for="email" style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px; display: block;">Email Address</label>
                                <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required style="border-radius: 12px; border: 1px solid #e2e8f0; padding: 12px 15px; font-size: 14px; transition: all 0.2s;">
                                @error('email') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="form-group">
                                <label for="role" style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px; display: block;">User Role</label>
                                <select name="role" id="role" class="form-control" required style="border-radius: 12px; border: 1px solid #e2e8f0; padding: 12px 15px; font-size: 14px; height: auto; transition: all 0.2s;">
                                    <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>Customer (Regular User)</option>
                                    <option value="staff" {{ old('role', $user->role) === 'staff' ? 'selected' : '' }}>Staff (Kitchen/Admin Assistant)</option>
                                </select>
                                @error('role') <span class="text-danger small">{{ $message }}</span> @enderror
                                <small class="text-muted mt-2 d-block">Staff role grants access to order management.</small>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="form-group">
                                <label for="phone" style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px; display: block;">Phone Number</label>
                                <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $user->phone) }}" style="border-radius: 12px; border: 1px solid #e2e8f0; padding: 12px 15px; font-size: 14px; transition: all 0.2s;">
                                @error('phone') <span class="text-danger small">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-5">
                        <label for="address" style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px; display: block;">Default Delivery Address</label>
                        <textarea name="address" id="address" class="form-control" rows="3" style="border-radius: 12px; border: 1px solid #e2e8f0; padding: 12px 15px; font-size: 14px; resize: none; transition: all 0.2s;">{{ old('address', $user->address) }}</textarea>
                        @error('address') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-3 pt-3" style="border-top: 1px solid #f1f5f9;">
                        <a href="{{ route('admin.users.show', $user) }}" class="btn btn-light" style="border-radius: 12px; font-weight: 600; padding: 12px 30px; background: #f1f5f9; border: none; color: #475569;">Cancel</a>
                        <button type="submit" class="btn btn-primary" style="border-radius: 12px; font-weight: 700; padding: 12px 40px; background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); border: none; box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        background: white;
    }
</style>
@endsection
