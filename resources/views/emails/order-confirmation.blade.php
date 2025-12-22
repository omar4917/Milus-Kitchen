<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Order Confirmation - {{ $order->order_number }}</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { text-align: center; padding: 20px 0; border-bottom: 2px solid #667eea; }
        .header h1 { color: #667eea; margin: 0; font-size: 24px; }
        .order-number { background: #f3f4f6; padding: 10px; text-align: center; margin: 20px 0; border-radius: 8px; }
        .order-number span { font-size: 20px; font-weight: bold; color: #667eea; }
        .section { margin: 20px 0; }
        .section h2 { font-size: 16px; color: #374151; border-bottom: 1px solid #e5e7eb; padding-bottom: 8px; }
        .info-row { display: flex; justify-content: space-between; padding: 8px 0; border-bottom: 1px solid #f3f4f6; }
        .info-label { color: #6b7280; }
        .items-table { width: 100%; border-collapse: collapse; margin: 10px 0; }
        .items-table th, .items-table td { padding: 10px; text-align: left; border-bottom: 1px solid #e5e7eb; }
        .items-table th { background: #f9fafb; font-weight: 600; }
        .total-row { font-weight: bold; background: #f3f4f6; }
        .footer { text-align: center; padding: 20px; color: #6b7280; font-size: 14px; border-top: 1px solid #e5e7eb; margin-top: 30px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>🍲 Auntie's Kitchen</h1>
        <p>Thank you for your order!</p>
    </div>

    <div class="order-number">
        <p>Order Number</p>
        <span>{{ $order->order_number }}</span>
    </div>

    <div class="section">
        <h2>Order Details</h2>
        <div class="info-row">
            <span class="info-label">Customer</span>
            <span>{{ $order->customer_name }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Phone</span>
            <span>{{ $order->customer_phone }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Type</span>
            <span>{{ ucfirst($order->delivery_type) }}</span>
        </div>
        @if($order->isDelivery())
        <div class="info-row">
            <span class="info-label">Address</span>
            <span>{{ $order->delivery_address }}</span>
        </div>
        @endif
        <div class="info-row">
            <span class="info-label">Date & Time</span>
            <span>{{ $order->preferred_date->format('M d, Y') }} at {{ $order->time_slot }}</span>
        </div>
        <div class="info-row">
            <span class="info-label">Payment</span>
            <span>{{ $order->payment_method_label }}</span>
        </div>
    </div>

    <div class="section">
        <h2>Items Ordered</h2>
        <table class="items-table">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Qty</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->item_name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>${{ number_format($item->line_total, 0) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2">Subtotal</td>
                    <td>${{ number_format($order->subtotal, 0) }}</td>
                </tr>
                @if($order->delivery_fee > 0)
                <tr>
                    <td colspan="2">Delivery Fee</td>
                    <td>${{ number_format($order->delivery_fee, 0) }}</td>
                </tr>
                @endif
                <tr class="total-row">
                    <td colspan="2">Total</td>
                    <td>${{ number_format($order->total, 0) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>

    @if($order->notes)
    <div class="section">
        <h2>Special Instructions</h2>
        <p>{{ $order->notes }}</p>
    </div>
    @endif

    <div class="footer">
        <p>Questions about your order?</p>
        <p><strong>📞 +880 1XXX-XXXXXX</strong></p>
        <p>© {{ date('Y') }} Auntie's Kitchen</p>
    </div>
</body>
</html>
