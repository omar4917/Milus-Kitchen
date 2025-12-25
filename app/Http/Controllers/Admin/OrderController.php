<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index(Request $request)
    {
        $query = Order::with('items')->latest();

        // Date filter
        if ($request->filled('date')) {
            if ($request->date === 'today') {
                $query->whereDate('created_at', today());
            } elseif ($request->date === 'yesterday') {
                $query->whereDate('created_at', today()->subDay());
            } elseif ($request->date === 'week') {
                $query->where('created_at', '>=', now()->subWeek());
            }
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->paginate(20);
        $statuses = Order::STATUSES;

        return view('admin.orders.index', compact('orders', 'statuses'));
    }

    public function show(Order $order)
    {
        $order->load(['items', 'statusLogs.user']);
        $statuses = Order::STATUSES;
        
        return view('admin.orders.show', compact('order', 'statuses'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:' . implode(',', array_keys(Order::STATUSES)),
            'notes' => 'nullable|string|max:500',
        ]);

        $success = $this->orderService->updateStatus(
            $order,
            $validated['status'],
            auth()->id(),
            $validated['notes'] ?? null
        );

        if (!$success) {
            return redirect()->back()
                ->with('error', 'Invalid status transition.');
        }

        return redirect()->back()
            ->with('success', 'Order status updated successfully.');
    }

    public function checkNew()
    {
        $count = Order::where('status', Order::STATUS_NEW)->count();
        return response()->json(['count' => $count]);
    }
}
