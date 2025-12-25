<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderService;

class DashboardController extends Controller
{
    protected OrderService $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index()
    {
        $stats = $this->orderService->getTodayStats();
        $weeklyStats = $this->orderService->getWeeklyStats();
        
        $recentOrders = Order::with('items')
            ->latest()
            ->take(10)
            ->get();

        $lowStockItems = \App\Models\MenuItem::where('stock_quantity', '<', 10)
            ->ordered()
            ->get();

        $topItems = $this->orderService->getTopSellingItems(5);

        return view('admin.dashboard', compact('stats', 'recentOrders', 'weeklyStats', 'lowStockItems', 'topItems'));
    }
}
