@extends('layouts.admin')

@section('page_title', 'User Management')

@section('content')
<!-- Premium Stats Section -->
<div class="row mb-4">
    <div class="col-md-4">
        <div style="background: white; padding: 30px; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.03); border: 1px solid #f1f5f9; height: 100%; display: flex; align-items: center;">
            <div style="width: 54px; height: 54px; background: #e0f2fe; color: #0ea5e9; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 20px; font-size: 24px;">
                <span class="icon ion-android-people"></span>
            </div>
            <div>
                <div style="color: #64748b; font-size: 13px; font-weight: 600; margin-bottom: 4px;">Total Customers</div>
                <div style="color: #0f172a; font-size: 26px; font-weight: 800; line-height: 1;">{{ \App\Models\User::where('role', 'user')->count() }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div style="background: white; padding: 30px; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.03); border: 1px solid #f1f5f9; height: 100%; display: flex; align-items: center;">
            <div style="width: 54px; height: 54px; background: #dcfce7; color: #16a34a; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 20px; font-size: 24px;">
                <span class="icon ion-bag"></span>
            </div>
            <div>
                <div style="color: #64748b; font-size: 13px; font-weight: 600; margin-bottom: 4px;">Total Orders</div>
                <div style="color: #0f172a; font-size: 26px; font-weight: 800; line-height: 1;">{{ \App\Models\Order::count() }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div style="background: white; padding: 30px; border-radius: 20px; box-shadow: 0 4px 20px rgba(0,0,0,0.03); border: 1px solid #f1f5f9; height: 100%; display: flex; align-items: center;">
            <div style="width: 54px; height: 54px; background: #fef3c7; color: #d97706; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin-right: 20px; font-size: 24px;">
                <span class="icon ion-cash"></span>
            </div>
            <div>
                <div style="color: #64748b; font-size: 13px; font-weight: 600; margin-bottom: 4px;">Total Revenue</div>
                <div style="color: #0f172a; font-size: 26px; font-weight: 800; line-height: 1;">${{ number_format(\App\Models\Order::sum('total'), 0) }}</div>
            </div>
        </div>
    </div>
</div>

<!-- Main Table Container -->
<div class="card" style="border-radius: 20px; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.04); background: white; overflow: hidden;">
    <div class="card-header d-flex justify-content-between align-items-center" style="background: white; padding: 25px 30px; border-bottom: 1px solid #f1f5f9;">
        <h4 style="margin: 0; font-weight: 800; color: #1e293b; font-size: 1.1rem;">Customers & Staff</h4>
        
        <form action="{{ route('admin.users.index') }}" method="GET" style="max-width: 400px; width: 100%;">
            <div class="input-group" style="background: #f8fafc; border-radius: 10px; border: 1px solid #e2e8f0; overflow: hidden;">
                <input type="text" name="search" class="form-control" placeholder="Search users..." value="{{ request('search') }}" style="background: transparent; border: none; box-shadow: none; font-size: 14px; padding: 8px 15px;">
                <button type="submit" class="btn btn-primary" style="background: #3b82f6; border: none; border-radius: 0 10px 10px 0; padding: 0 20px;">
                    <span class="icon ion-search"></span>
                </button>
            </div>
        </form>
    </div>
    
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table" style="margin: 0;">
                <thead>
                    <tr style="background: #f8fafc;">
                        <th style="padding: 15px 30px; border: none; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #94a3b8;">User Identity</th>
                        <th style="padding: 15px 30px; border: none; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #94a3b8;">Role</th>
                        <th style="padding: 15px 30px; border: none; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #94a3b8;">Orders</th>
                        <th style="padding: 15px 30px; border: none; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #94a3b8;">Total Spent</th>
                        <th style="padding: 15px 30px; border: none; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #94a3b8; text-align: right;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr style="border-bottom: 1px solid #f8fafc; transition: all 0.2s;">
                        <td style="padding: 20px 30px;">
                            <div class="d-flex align-items-center">
                                <div style="width: 40px; height: 40px; background: #eff6ff; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 15px; color: #3b82f6; font-weight: 700; font-size: 14px;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div style="font-weight: 700; color: #1e293b; font-size: 14px;">{{ $user->name }}</div>
                                    <div style="font-size: 12px; color: #94a3b8;">{{ $user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="padding: 20px 30px;">
                            <span style="background: {{ $user->isStaff() ? '#fef3c7' : '#f1f5f9' }}; color: {{ $user->isStaff() ? '#d97706' : '#64748b' }}; padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 700;">
                                {{ strtoupper($user->role) }}
                            </span>
                        </td>
                        <td style="padding: 20px 30px;">
                            <span style="font-weight: 700; color: #1e293b;">{{ $user->orders_count }}</span>
                        </td>
                        <td style="padding: 20px 30px;">
                            <span style="font-weight: 800; color: #059669;">${{ number_format($user->orders_sum_total ?? 0, 0) }}</span>
                        </td>
                        <td style="padding: 20px 30px; text-align: right;">
                            <div class="d-flex gap-2 justify-content-end">
                                <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm" style="background: #f1f5f9; color: #475569; font-weight: 600; padding: 5px 12px; border-radius: 8px;">View</a>
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm" style="background: #eff6ff; color: #3b82f6; font-weight: 600; padding: 5px 12px; border-radius: 8px;">Edit</a>
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Delete user?')" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm" style="background: #fff1f2; color: #e11d48; font-weight: 600; padding: 5px 12px; border-radius: 8px; border: none;">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">No users found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
