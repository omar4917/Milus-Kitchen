@extends('layouts.admin')

@section('title', 'Manage Coupons')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Coupons</h2>
        <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary">+ Add Coupon</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Type</th>
                        <th>Value</th>
                        <th>Min Order</th>
                        <th>Usage</th>
                        <th>Expires</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($coupons as $coupon)
                    <tr>
                        <td><code style="font-size: 1.1em;">{{ $coupon->code }}</code></td>
                        <td>{{ ucfirst($coupon->type) }}</td>
                        <td>
                            @if($coupon->type === 'percentage')
                                {{ $coupon->value }}%
                            @else
                                ${{ number_format($coupon->value, 2) }}
                            @endif
                        </td>
                        <td>${{ number_format($coupon->min_order, 2) }}</td>
                        <td>{{ $coupon->used_count }} / {{ $coupon->max_uses ?? '∞' }}</td>
                        <td>{{ $coupon->expires_at ? $coupon->expires_at->format('M d, Y') : 'Never' }}</td>
                        <td>
                            @if($coupon->isValid())
                                <span class="badge badge-success">Active</span>
                            @else
                                <span class="badge badge-secondary">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.coupons.edit', $coupon) }}" class="btn btn-sm btn-info">Edit</a>
                            <form action="{{ route('admin.coupons.destroy', $coupon) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this coupon?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">No coupons found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $coupons->links() }}
        </div>
    </div>
</div>
@endsection
