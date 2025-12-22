@extends('layouts.admin')

@section('page_title', 'Order #' . $order->order_number)

@section('content')
<div class="order-detail">
    <div class="order-detail-grid">
        <!-- Order Info -->
        <div class="card">
            <div class="card-header">
                <h3>Order Information</h3>
                <span class="status-badge status-{{ $order->status }}">{{ $order->status_label }}</span>
            </div>
            <div class="card-body">
                <div class="info-grid">
                    <div class="info-item">
                        <span class="label">Order Number</span>
                        <span class="value">{{ $order->order_number }}</span>
                    </div>
                    <div class="info-item">
                        <span class="label">Date</span>
                        <span class="value">{{ $order->created_at->format('M d, Y H:i') }}</span>
                    </div>
                    <div class="info-item">
                        <span class="label">Customer</span>
                        <span class="value">{{ $order->customer_name }}</span>
                    </div>
                    <div class="info-item">
                        <span class="label">Phone</span>
                        <span class="value">{{ $order->customer_phone }}</span>
                    </div>
                    @if($order->customer_email)
                    <div class="info-item">
                        <span class="label">Email</span>
                        <span class="value">{{ $order->customer_email }}</span>
                    </div>
                    @endif
                    <div class="info-item">
                        <span class="label">Type</span>
                        <span class="value">{{ ucfirst($order->delivery_type) }}</span>
                    </div>
                    @if($order->isDelivery())
                    <div class="info-item full-width">
                        <span class="label">Delivery Address</span>
                        <span class="value">{{ $order->delivery_address }}</span>
                    </div>
                    @endif
                    <div class="info-item">
                        <span class="label">Preferred Date</span>
                        <span class="value">{{ $order->preferred_date->format('M d, Y') }}</span>
                    </div>
                    <div class="info-item">
                        <span class="label">Time Slot</span>
                        <span class="value">{{ $order->time_slot }}</span>
                    </div>
                    <div class="info-item">
                        <span class="label">Payment</span>
                        <span class="value">{{ $order->payment_method_label }}</span>
                    </div>
                    @if($order->transaction_id)
                    <div class="info-item">
                        <span class="label">Transaction ID</span>
                        <span class="value">{{ $order->transaction_id }}</span>
                    </div>
                    @endif
                    @if($order->notes)
                    <div class="info-item full-width">
                        <span class="label">Notes</span>
                        <span class="value">{{ $order->notes }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Status Update -->
        <div class="card">
            <div class="card-header">
                <h3>Update Status</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.orders.status', $order) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    
                    <div class="status-buttons">
                        @foreach($statuses as $key => $label)
                            @if($order->canTransitionTo($key))
                            <button type="submit" name="status" value="{{ $key }}" 
                                    class="status-btn status-btn-{{ $key }}">
                                {{ $label }}
                            </button>
                            @endif
                        @endforeach
                    </div>

                    @if($order->status === 'completed' || $order->status === 'cancelled')
                    <p class="text-muted">This order is {{ $order->status }}. No further updates.</p>
                    @endif
                </form>
            </div>
        </div>

        <!-- Order Items -->
        <div class="card">
            <div class="card-header">
                <h3>Order Items</h3>
            </div>
            <div class="card-body">
                <table class="table table-items">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item->item_name }}</td>
                            <td>${{ number_format($item->unit_price, 0) }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>${{ number_format($item->line_total, 0) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3">Subtotal</td>
                            <td>${{ number_format($order->subtotal, 0) }}</td>
                        </tr>
                        @if($order->delivery_fee > 0)
                        <tr>
                            <td colspan="3">Delivery Fee</td>
                            <td>${{ number_format($order->delivery_fee, 0) }}</td>
                        </tr>
                        @endif
                        <tr class="total-row">
                            <td colspan="3"><strong>Total</strong></td>
                            <td><strong>${{ number_format($order->total, 0) }}</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Status History -->
        <div class="card">
            <div class="card-header">
                <h3>Status History</h3>
            </div>
            <div class="card-body">
                <div class="status-timeline">
                    @foreach($order->statusLogs as $log)
                    <div class="timeline-item">
                        <div class="timeline-marker"></div>
                        <div class="timeline-content">
                            <span class="timeline-status">{{ $log->new_status_label }}</span>
                            <span class="timeline-time">{{ $log->created_at->format('M d, H:i') }}</span>
                            @if($log->user)
                            <span class="timeline-user">by {{ $log->user->name }}</span>
                            @endif
                            @if($log->notes)
                            <span class="timeline-notes">{{ $log->notes }}</span>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="page-actions mt-4">
        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline">← Back to Orders</a>
    </div>
</div>
@endsection
