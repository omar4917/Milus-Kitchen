@extends('layouts.admin')

@section('page_title', 'User Profile: ' . $user->name)

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <a href="{{ route('admin.users.index') }}" class="btn btn-outline" style="border-radius: 10px; font-weight: 600; font-size: 14px; padding: 10px 20px;">
        <span class="icon ion-android-arrow-back" style="margin-right: 8px;"></span> Back to Users
    </a>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary" style="border-radius: 10px; font-weight: 600; font-size: 14px; padding: 10px 25px; background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); border: none; box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);">
            <span class="icon ion-edit" style="margin-right: 8px;"></span> Edit Profile
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-4">
        <div class="card" style="border-radius: 24px; box-shadow: 0 10px 40px rgba(0,0,0,0.04); border: 1px solid rgba(0,0,0,0.02); overflow: hidden; background: white;">
            <div class="card-body p-0">
                <div class="profile-header text-center" style="padding: 40px 30px; background: linear-gradient(to bottom, #f8fafc 0%, white 100%); position: relative;">
                    <div class="avatar-wrapper mb-3" style="position: relative; display: inline-block;">
                        <div class="user-avatar-large" style="width: 110px; height: 110px; background: #3b82f6; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: white; font-weight: 800; font-size: 42px; box-shadow: 0 10px 25px rgba(59, 130, 246, 0.2); border: 4px solid white;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div style="position: absolute; bottom: 5px; right: 5px; width: 24px; height: 24px; background: #22c55e; border-radius: 50%; border: 3px solid white;"></div>
                    </div>
                    <h3 style="font-weight: 800; color: #1e293b; margin-bottom: 5px; font-size: 1.5rem;">{{ $user->name }}</h3>
                    <p style="color: #64748b; font-size: 14px; margin-bottom: 20px;">Member since {{ $user->created_at->format('M d, Y') }}</p>
                    
                    <span class="status-badge {{ $user->isStaff() ? 'status-cooking' : 'status-regular' }}" style="padding: 6px 18px; border-radius: 30px; font-size: 12px; font-weight: 700; letter-spacing: 0.5px; text-transform: uppercase;">
                        {{ $user->role === 'staff' ? '👨‍🍳 Staff Member' : '👤 Customer' }}
                    </span>
                </div>
                
                <div style="padding: 0 30px 30px;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px; margin-bottom: 30px;">
                        <div style="background: #f8fafc; padding: 20px; border-radius: 18px; text-align: center; border: 1px solid #f1f5f9;">
                            <div style="font-size: 12px; color: #64748b; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Orders</div>
                            <div style="font-size: 24px; font-weight: 800; color: #0f172a;">{{ $orderCount }}</div>
                        </div>
                        <div style="background: #f8fafc; padding: 20px; border-radius: 18px; text-align: center; border: 1px solid #f1f5f9;">
                            <div style="font-size: 12px; color: #64748b; font-weight: 600; text-transform: uppercase; margin-bottom: 5px;">Total Spent</div>
                            <div style="font-size: 24px; font-weight: 800; color: #059669;">${{ number_format($totalSpent, 0) }}</div>
                        </div>
                    </div>
                    
                    <div class="info-group mb-4">
                        <label style="display: block; font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px;">Contact Information</label>
                        <div style="display: flex; align-items: center; margin-bottom: 15px;">
                            <div style="width: 36px; height: 36px; background: #f1f5f9; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-right: 12px; color: #64748b;">
                                <span class="icon ion-email" style="font-size: 18px;"></span>
                            </div>
                            <div>
                                <div style="font-size: 14px; font-weight: 600; color: #334155;">{{ $user->email }}</div>
                                <div style="font-size: 12px; color: #94a3b8;">Email Address</div>
                            </div>
                        </div>
                        <div style="display: flex; align-items: center; margin-bottom: 15px;">
                            <div style="width: 36px; height: 36px; background: #f1f5f9; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-right: 12px; color: #64748b;">
                                <span class="icon ion-android-call" style="font-size: 18px;"></span>
                            </div>
                            <div>
                                <div style="font-size: 14px; font-weight: 600; color: #334155;">{{ $user->phone ?: 'Not provided' }}</div>
                                <div style="font-size: 12px; color: #94a3b8;">Phone Number</div>
                            </div>
                        </div>
                    </div>

                    <div class="info-group">
                        <label style="display: block; font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px;">Delivery Details</label>
                        <div style="display: flex; background: #f8fafc; padding: 15px; border-radius: 15px; border: 1px solid #f1f5f9;">
                            <div style="width: 32px; height: 32px; background: white; border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-right: 12px; color: #64748b; flex-shrink: 0;">
                                <span class="icon ion-ios-location" style="font-size: 16px;"></span>
                            </div>
                            <div style="font-size: 13px; color: #475569; font-weight: 500; line-height: 1.5;">
                                {{ $user->address ?: 'No delivery address saved yet.' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-8">
        <div class="card card-table" style="border-radius: 24px; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.04); min-height: 100%;">
            <div class="card-header d-flex align-items-center justify-content-between" style="padding: 25px 30px; background: white; border-bottom: 1px solid #f1f5f9;">
                <h4 class="card-title" style="margin: 0; font-weight: 800; color: #1e293b; font-size: 1.1rem;">Transaction History</h4>
                <span class="badge" style="background: #eff6ff; color: #3b82f6; padding: 6px 12px; border-radius: 8px; font-weight: 700; font-size: 12px;">{{ $user->orders->count() }} Orders</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table" style="margin: 0;">
                        <thead>
                            <tr style="background: #f8fafc;">
                                <th style="padding: 15px 30px; border: none; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #94a3b8;">Order Details</th>
                                <th style="padding: 15px 30px; border: none; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #94a3b8;">Status</th>
                                <th style="padding: 15px 30px; border: none; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #94a3b8;">Amount</th>
                                <th style="padding: 15px 30px; border: none; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #94a3b8; text-align: right;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($user->orders as $order)
                            <tr style="transition: all 0.2s;">
                                <td style="padding: 20px 30px; border-bottom: 1px solid #f8fafc;">
                                    <div style="font-weight: 700; color: #3b82f6; font-size: 14px; margin-bottom: 4px;">#{{ $order->order_number }}</div>
                                    <div style="font-size: 12px; color: #94a3b8;">{{ $order->created_at->format('M d, Y • h:i A') }}</div>
                                </td>
                                <td style="padding: 20px 30px; border-bottom: 1px solid #f8fafc;">
                                    <span class="status-badge status-{{ $order->status }}" style="font-size: 11px; padding: 4px 12px; border-radius: 20px;">
                                        {{ $order->status_label }}
                                    </span>
                                </td>
                                <td style="padding: 20px 30px; border-bottom: 1px solid #f8fafc;">
                                    <div style="font-weight: 800; color: #1e293b; font-size: 15px;">${{ number_format($order->total, 2) }}</div>
                                </td>
                                <td style="padding: 20px 30px; border-bottom: 1px solid #f8fafc; text-align: right;">
                                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-light" style="border-radius: 8px; background: #f1f5f9; border: none; color: #475569; font-weight: 600; padding: 6px 15px;">Details</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <div class="mb-3" style="font-size: 40px; opacity: 0.3;">📦</div>
                                    <h5 style="color: #64748b; font-weight: 600;">No order history found</h5>
                                    <p style="color: #94a3b8; font-size: 14px;">This customer hasn't placed any orders yet.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
