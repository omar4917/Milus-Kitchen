@extends('layouts.admin')

@section('page_title', 'Orders')

@section('content')
<!-- Filters -->
<div class="filters-bar">
    <form action="{{ route('admin.orders.index') }}" method="GET" class="filters-form">
        <select name="date" onchange="this.form.submit()">
            <option value="">All Time</option>
            <option value="today" {{ request('date') === 'today' ? 'selected' : '' }}>Today</option>
            <option value="yesterday" {{ request('date') === 'yesterday' ? 'selected' : '' }}>Yesterday</option>
            <option value="week" {{ request('date') === 'week' ? 'selected' : '' }}>This Week</option>
        </select>
        <select name="status" onchange="this.form.submit()">
            <option value="">All Status</option>
            @foreach($statuses as $key => $label)
            <option value="{{ $key }}" {{ request('status') === $key ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
    </form>
</div>

<div class="card">
    <div class="card-body">
        @if($orders->count() > 0)
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Customer</th>
                        <th>Type</th>
                        <th>Items</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td><strong>{{ $order->order_number }}</strong></td>
                        <td>
                            {{ $order->customer_name }}<br>
                            <small class="text-muted">{{ $order->customer_phone }}</small>
                        </td>
                        <td>
                            <span class="badge badge-{{ $order->delivery_type }}">
                                {{ ucfirst($order->delivery_type) }}
                            </span>
                        </td>
                        <td>{{ $order->items->count() }} items</td>
                        <td>${{ number_format($order->total, 0) }}</td>
                        <td>
                            <span class="status-badge status-{{ $order->status }}">
                                {{ $order->status_label }}
                            </span>
                        </td>
                        <td>
                            {{ $order->created_at->format('M d, H:i') }}
                        </td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-primary">View</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="pagination-wrap">
            {{ $orders->withQueryString()->links() }}
        </div>
        @else
        <div class="empty-state-sm">
            <p>No orders found.</p>
        </div>
        @endif
    </div>
</div>
@endsection
