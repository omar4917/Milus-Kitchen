@extends('layouts.admin')

@section('page_title', 'Order Management')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.orders.index') }}" class="btn btn-outline" style="border-radius: 10px; font-weight: 600; font-size: 14px; padding: 10px 20px;">
        <span class="icon ion-android-arrow-back" style="margin-right: 8px;"></span> Back to Orders
    </a>
</div>

<div class="row">
    <!-- Left Column: Order Info & Items -->
    <div class="col-lg-8">
        <!-- Order Header Card -->
        <div class="card mb-4" style="border-radius: 20px; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.04); overflow: hidden; background: white;">
            <div class="card-header d-flex justify-content-between align-items-center" style="background: white; border-bottom: 1px solid #f1f5f9; padding: 25px 30px;">
                <div>
                    <h2 style="margin: 0; font-weight: 800; color: #1e293b; font-size: 1.4rem;">Order #{{ $order->order_number }}</h2>
                    <p style="margin: 5px 0 0; color: #94a3b8; font-size: 13px; font-weight: 500;">Placed on {{ $order->created_at->format('M d, Y • h:i A') }}</p>
                </div>
                <span class="status-badge status-{{ $order->status }}" style="padding: 8px 18px; border-radius: 30px; font-size: 12px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;">
                    {{ $order->status_label }}
                </span>
            </div>
            
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table" style="margin: 0;">
                        <thead>
                            <tr style="background: #f8fafc;">
                                <th style="padding: 15px 30px; border: none; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #94a3b8;">Menu Item</th>
                                <th style="padding: 15px 30px; border: none; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #94a3b8;">Price</th>
                                <th style="padding: 15px 30px; border: none; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #94a3b8; text-align: center;">Qty</th>
                                <th style="padding: 15px 30px; border: none; font-size: 11px; text-transform: uppercase; letter-spacing: 1px; color: #94a3b8; text-align: right;">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                            <tr>
                                <td style="padding: 20px 30px;">
                                    <div style="font-weight: 700; color: #1e293b;">{{ $item->item_name }}</div>
                                </td>
                                <td style="padding: 20px 30px; color: #475569;">${{ number_format($item->unit_price, 0) }}</td>
                                <td style="padding: 20px 30px; text-align: center; font-weight: 600;">{{ $item->quantity }}</td>
                                <td style="padding: 20px 30px; text-align: right; font-weight: 700; color: #1e293b;">${{ number_format($item->line_total, 0) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <!-- Order Summary -->
                <div style="padding: 30px; background: #fbfcfe; border-top: 1px solid #f1f5f9;">
                    <div style="max-width: 300px; margin-left: auto;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 10px; color: #64748b; font-size: 14px;">
                            <span>Subtotal</span>
                            <span style="font-weight: 600; color: #1e293b;">${{ number_format($order->subtotal, 0) }}</span>
                        </div>
                        @if($order->discount_amount > 0)
                        <div style="display: flex; justify-content: space-between; margin-bottom: 10px; color: #059669; font-size: 14px;">
                            <span>Discount ({{ $order->coupon_code }})</span>
                            <span style="font-weight: 600;">-${{ number_format($order->discount_amount, 0) }}</span>
                        </div>
                        @endif
                        @if($order->delivery_fee > 0)
                        <div style="display: flex; justify-content: space-between; margin-bottom: 10px; color: #64748b; font-size: 14px;">
                            <span>Delivery Fee</span>
                            <span style="font-weight: 600; color: #1e293b;">${{ number_format($order->delivery_fee, 0) }}</span>
                        </div>
                        @endif
                        <div style="display: flex; justify-content: space-between; margin-top: 15px; padding-top: 15px; border-top: 2px solid #e2e8f0;">
                            <span style="font-weight: 800; color: #1e293b; font-size: 16px;">Total</span>
                            <span style="font-weight: 900; color: #1e293b; font-size: 22px;">${{ number_format($order->total, 0) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status Timeline Card -->
        <div class="card" style="border-radius: 20px; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.04); background: white;">
            <div class="card-header" style="background: white; border-bottom: 1px solid #f1f5f9; padding: 25px 30px;">
                <h3 style="margin: 0; font-weight: 800; color: #1e293b; font-size: 1.1rem;">Order Progress Timeline</h3>
            </div>
            <div class="card-body" style="padding: 30px;">
                <div class="timeline" style="position: relative; padding-left: 30px;">
                    <div style="position: absolute; left: 7px; top: 0; bottom: 0; width: 2px; background: #e2e8f0;"></div>
                    @foreach($order->statusLogs as $index => $log)
                    <div style="position: relative; margin-bottom: 30px;">
                        <div style="position: absolute; left: -30px; top: 5px; width: 16px; height: 16px; background: {{ $index === 0 ? '#3b82f6' : '#94a3b8' }}; border: 4px solid white; border-radius: 50%; box-shadow: 0 0 0 2px {{ $index === 0 ? 'rgba(59, 130, 246, 0.2)' : 'rgba(148, 163, 184, 0.1)' }}; z-index: 1;"></div>
                        <div>
                            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 5px;">
                                <span style="font-weight: 700; color: {{ $index === 0 ? '#1e293b' : '#64748b' }}; font-size: 14px;">{{ $log->new_status_label }}</span>
                                <span style="font-size: 12px; color: #94a3b8; font-weight: 500;">{{ $log->created_at->format('M d, h:i A') }}</span>
                            </div>
                            @if($log->user)
                            <div style="font-size: 12px; color: #94a3b8; margin-bottom: 8px;">Action by <span style="color: #64748b; font-weight: 600;">{{ $log->user->name }}</span></div>
                            @endif
                            @if($log->notes)
                            <div style="background: #f8fafc; padding: 12px 15px; border-radius: 8px; border-left: 4px solid #e2e8f0; font-size: 13px; color: #475569; font-style: italic;">
                                "{{ $log->notes }}"
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column: Customer Info & Status Update -->
    <div class="col-lg-4">
        <!-- Update Status Card -->
        <div class="card mb-4" style="border-radius: 20px; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.04); background: #fff;">
            <div class="card-header" style="background: white; border-bottom: 1px solid #f1f5f9; padding: 25px 30px;">
                <h3 style="margin: 0; font-weight: 800; color: #1e293b; font-size: 1.1rem;">Manage Status</h3>
            </div>
            <div class="card-body" style="padding: 30px;">
                @if($order->status === 'completed' || $order->status === 'cancelled')
                    <div style="background: #f8fafc; border-radius: 12px; padding: 20px; text-align: center; border: 1px solid #e2e8f0;">
                        <span class="icon ion-android-done-all" style="font-size: 32px; color: #22c55e; display: block; margin-bottom: 10px;"></span>
                        <p style="color: #64748b; font-weight: 600; margin: 0; line-height: 1.5;">This order is <strong>{{ strtoupper($order->status) }}</strong> and finalized.</p>
                    </div>
                @else
                    <form action="{{ route('admin.orders.status', $order) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        
                        <div class="form-group mb-4">
                            <label for="status_select" style="font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px; display: block;">Action</label>
                            <select name="status" id="status_select" class="styled-select" required style="width: 100%; border-radius: 12px; font-weight: 700; height: 48px;">
                                <option value="" disabled selected>Move to stage...</option>
                                @foreach($statuses as $key => $label)
                                    @if($order->canTransitionTo($key))
                                    <option value="{{ $key }}">{{ $label }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-4">
                            <label for="notes" style="font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px; display: block;">Notes for Status Log</label>
                            <textarea name="notes" id="notes" class="form-control" rows="3" placeholder="Add optional details..." style="border-radius: 12px; border: 1.5px solid #e2e8f0; padding: 15px; font-size: 14px; resize: none;"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block" style="border-radius: 12px; height: 50px; font-weight: 700; background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); border: none; box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);">
                            Update Order
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <!-- Customer Card -->
        <div class="card" style="border-radius: 20px; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.04); background: white;">
            <div class="card-header" style="background: white; border-bottom: 1px solid #f1f5f9; padding: 25px 30px;">
                <h3 style="margin: 0; font-weight: 800; color: #1e293b; font-size: 1.1rem;">Customer Details</h3>
            </div>
            <div class="card-body" style="padding: 30px;">
                <div class="d-flex align-items-center mb-4">
                    <div style="width: 50px; height: 50px; background: #eff6ff; color: #3b82f6; border-radius: 15px; display: flex; align-items: center; justify-content: center; margin-right: 15px; font-size: 20px; font-weight: 800;">
                        {{ strtoupper(substr($order->customer_name, 0, 1)) }}
                    </div>
                    <div>
                        <div style="font-weight: 800; color: #1e293b; font-size: 16px;">{{ $order->customer_name }}</div>
                        <div style="font-size: 13px; color: #94a3b8; font-weight: 500;">{{ ucfirst($order->delivery_type) }} Order</div>
                    </div>
                </div>

                <div style="padding-top: 10px; border-top: 1px solid #f1f5f9;">
                    <div style="margin-top: 15px;">
                        <div style="font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 5px;">Phone Number</div>
                        <div style="font-weight: 600; color: #475569;">{{ $order->customer_phone }}</div>
                    </div>
                    @if($order->customer_email)
                    <div style="margin-top: 15px;">
                        <div style="font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 5px;">Email Address</div>
                        <div style="font-weight: 600; color: #475569;">{{ $order->customer_email }}</div>
                    </div>
                    @endif
                    @if($order->isDelivery())
                    <div style="margin-top: 15px;">
                        <div style="font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 5px;">Delivery Address</div>
                        <div style="font-weight: 500; color: #475569; font-size: 14px; line-height: 1.5;">{{ $order->delivery_address }}</div>
                    </div>
                    @endif
                    <div style="margin-top: 15px;">
                        <div style="font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 5px;">Scheduled Delivery</div>
                        <div style="font-weight: 600; color: #475569;">{{ $order->preferred_date->format('M d, Y') }} at {{ $order->time_slot }}</div>
                    </div>
                    <div style="margin-top: 15px;">
                        <div style="font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 5px;">Payment Method</div>
                        <div style="font-weight: 700; color: #3b82f6;">{{ strtoupper($order->payment_method_label) }}</div>
                    </div>
                    @if($order->notes)
                    <div style="margin-top: 20px; background: #fffcf0; padding: 15px; border-radius: 12px; border: 1px solid #fef3c7;">
                        <div style="font-size: 11px; font-weight: 700; color: #d97706; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 5px;">Customer Notes</div>
                        <div style="font-size: 13px; color: #92400e; line-height: 1.5;">{{ $order->notes }}</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
