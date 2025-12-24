<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatusLog;
use App\Models\Setting;
use App\Mail\OrderConfirmation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class OrderService
{
    protected CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function createOrder(array $data): Order
    {
        return DB::transaction(function () use ($data) {
            $cartDetails = $this->cartService->getCartDetails();
            $subtotal = $cartDetails['subtotal'];
            
            // Calculate delivery fee (only for delivery orders)
            $deliveryFee = 0;
            if ($data['delivery_type'] === 'delivery') {
                $deliveryFee = (float) Setting::get('delivery_fee', 50);
            }
            
            $total = $subtotal + $deliveryFee;

            // Create order
            $order = Order::create([
                'customer_name' => $data['customer_name'],
                'customer_phone' => $data['customer_phone'],
                'customer_email' => $data['customer_email'] ?? null,
                'delivery_type' => $data['delivery_type'],
                'delivery_address' => $data['delivery_address'] ?? null,
                'preferred_date' => $data['preferred_date'],
                'time_slot' => $data['time_slot'],
                'notes' => $data['notes'] ?? null,
                'payment_method' => $data['payment_method'],
                'transaction_id' => $data['transaction_id'] ?? null,
                'status' => Order::STATUS_NEW,
                'subtotal' => $subtotal,
                'delivery_fee' => $deliveryFee,
                'total' => $total,
            ]);

            // Create order items
            foreach ($cartDetails['items'] as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_item_id' => $item['id'],
                    'item_name' => $item['name'],
                    'unit_price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'line_total' => $item['price'] * $item['quantity'],
                ]);
            }

            // Log initial status
            OrderStatusLog::create([
                'order_id' => $order->id,
                'old_status' => null,
                'new_status' => Order::STATUS_NEW,
                'notes' => 'Order placed by customer',
            ]);

            // Clear cart
            $this->cartService->clear();

            // Send confirmation email
            $this->sendConfirmationEmail($order);

            return $order;
        });
    }

    public function updateStatus(Order $order, string $newStatus, ?int $userId = null, ?string $notes = null): bool
    {
        if (!$order->canTransitionTo($newStatus)) {
            return false;
        }

        $oldStatus = $order->status;
        
        $order->update(['status' => $newStatus]);

        OrderStatusLog::create([
            'order_id' => $order->id,
            'user_id' => $userId,
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
            'notes' => $notes,
        ]);

        return true;
    }

    protected function sendConfirmationEmail(Order $order): void
    {
        if ($order->customer_email) {
            try {
                Mail::to($order->customer_email)->queue(new OrderConfirmation($order));
            } catch (\Exception $e) {
                // Log error but don't fail the order
                \Log::error('Failed to send order confirmation email: ' . $e->getMessage());
            }
        }
    }

    public function getTodayStats(): array
    {
        $today = today();
        
        $ordersQuery = Order::whereDate('created_at', $today);
        
        return [
            'total_orders' => $ordersQuery->count(),
            'total_revenue' => $ordersQuery->where('status', '!=', Order::STATUS_CANCELLED)->sum('total'),
            'pending_orders' => Order::whereIn('status', [Order::STATUS_NEW, Order::STATUS_CONFIRMED, Order::STATUS_COOKING])->count(), // Global pending, not just today
            'completed_orders' => Order::whereDate('created_at', $today)
                ->where('status', Order::STATUS_COMPLETED)
                ->count(),
        ];
    }

    public function getWeeklyStats(): array
    {
        $dates = collect();
        $revenues = collect();
        $orders = collect();

        for ($i = 6; $i >= 0; $i--) {
            $date = today()->subDays($i);
            $formattedDate = $date->format('M d');
            
            $dayOrders = Order::whereDate('created_at', $date)
                ->where('status', '!=', Order::STATUS_CANCELLED);
                
            $dates->push($formattedDate);
            $revenues->push($dayOrders->sum('total'));
            $orders->push($dayOrders->count());
        }

        return [
            'labels' => $dates,
            'revenues' => $revenues,
            'orders' => $orders,
        ];
    }
}
