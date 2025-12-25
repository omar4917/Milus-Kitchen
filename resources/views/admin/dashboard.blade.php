@extends('layouts.admin')

@section('page_title', 'Dashboard')

@section('content')
<div class="dashboard">
    <!-- Stats Cards -->
    <div class="stats-grid">
        <div class="stat-card purple">
            <div class="stat-icon">📦</div>
            <div class="stat-content">
                <span class="stat-value">{{ $stats['total_orders'] }}</span>
                <span class="stat-label">Today's Orders</span>
            </div>
        </div>
        <div class="stat-card rose">
            <div class="stat-icon">💰</div>
            <div class="stat-content">
                <span class="stat-value">${{ number_format($stats['total_revenue'], 0) }}</span>
                <span class="stat-label">Today's Revenue</span>
            </div>
        </div>
        <div class="stat-card sky">
            <div class="stat-icon">⏳</div>
            <div class="stat-content">
                <span class="stat-value">{{ $stats['pending_orders'] }}</span>
                <span class="stat-label">Pending Orders</span>
            </div>
        </div>
        <div class="stat-card orange">
            <div class="stat-icon">✓</div>
            <div class="stat-content">
                <span class="stat-value">{{ $stats['completed_orders'] }}</span>
                <span class="stat-label">Completed Today</span>
            </div>
        </div>
        <div class="stat-card emerald" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
            <div class="stat-icon">📊</div>
            <div class="stat-content">
                <span class="stat-value">${{ number_format($stats['avg_order_value'], 0) }}</span>
                <span class="stat-label">Avg Order Value</span>
            </div>
        </div>
    </div>

    </div>

    <!-- Analytics Charts -->
    <div class="row" style="margin-top: 30px;">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <h2>Weekly Revenue & Orders</h2>
                </div>
                <div class="card-body">
                    <canvas id="revenueChart" style="width: 100%; height: 300px;"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h2>Top Selling Items</h2>
                </div>
                <div class="card-body">
                    <canvas id="topItemsChart" style="width: 100%; height: 300px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="quick-actions">
        <a href="{{ route('admin.items.create') }}" class="action-btn">
            <span class="action-icon">➕</span>
            Add Menu Item
        </a>
        <a href="{{ route('admin.orders.index', ['status' => 'new']) }}" class="action-btn">
            <span class="action-icon">📝</span>
            New Orders
        </a>
        <a href="{{ route('admin.categories.index') }}" class="action-btn">
            <span class="action-icon">📁</span>
            Manage Categories
        </a>
    </div>

    @if($lowStockItems->count() > 0)
    <div class="card mb-4 border-danger">
        <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
            <h2 class="mb-0 text-white" style="font-size: 1.1rem;">⚠️ Low Stock Alerts</h2>
            <span class="badge badge-light text-danger">{{ $lowStockItems->count() }} Items</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th class="pl-4">Item Name</th>
                            <th>Current Stock</th>
                            <th class="text-right pr-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lowStockItems as $item)
                        <tr>
                            <td class="pl-4"><strong>{{ $item->name }}</strong></td>
                            <td><span class="text-danger font-weight-bold">{{ $item->stock_quantity }} remaining</span></td>
                            <td class="text-right pr-4">
                                <a href="{{ route('admin.items.edit', $item) }}" class="btn btn-sm btn-outline-danger">Restock</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    <!-- Recent Orders -->
    <div class="card">
        <div class="card-header">
            <h2>Recent Orders</h2>
            <a href="{{ route('admin.orders.index') }}" class="view-all-link">View All →</a>
        </div>
        <div class="card-body">
            @if($recentOrders->count() > 0)
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Order #</th>
                            <th>Customer</th>
                            <th>Items</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Time</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentOrders as $order)
                        <tr>
                            <td><strong>{{ $order->order_number }}</strong></td>
                            <td>{{ $order->customer_name }}</td>
                            <td>{{ $order->items->count() }} items</td>
                            <td>${{ number_format($order->total, 0) }}</td>
                            <td>
                                <span class="status-badge status-{{ $order->status }}">
                                    {{ $order->status_label }}
                                </span>
                            </td>
                            <td>{{ $order->created_at->diffForHumans() }}</td>
                            <td>
                                <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm">View</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="empty-state-sm">
                <p>No orders yet today.</p>
            </div>
            @endif
        </div>
    </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('revenueChart').getContext('2d');
        const weeklyStats = @json($weeklyStats);

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: weeklyStats.labels,
                datasets: [
                    {
                        label: 'Revenue ($)',
                        data: weeklyStats.revenues,
                        borderColor: '#ff7a5c',
                        backgroundColor: 'rgba(255, 122, 92, 0.1)',
                        borderWidth: 2,
                        yAxisID: 'y',
                        tension: 0.4
                    },
                    {
                        label: 'Orders',
                        data: weeklyStats.orders,
                        borderColor: '#343a40',
                        backgroundColor: 'rgba(52, 58, 64, 0.1)',
                        borderWidth: 2,
                        yAxisID: 'y1',
                        borderDash: [5, 5],
                        tension: 0.4
                    }
                ]
            },
            options: {
                responsive: true,
                interaction: {
                    mode: 'index',
                    intersect: false,
                },
                stacked: false,
                plugins: {
                    title: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        title: { display: true, text: 'Revenue ($)' },
                        grid: { color: 'rgba(0,0,0,0.05)' }
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        title: { display: true, text: 'Orders' },
                        grid: { drawOnChartArea: false }
                    }
                }
            }
            }
        });

        // Top Items Chart
        const topItemsCtx = document.getElementById('topItemsChart').getContext('2d');
        const topItemsData = @json($topItems);
        
        new Chart(topItemsCtx, {
            type: 'doughnut',
            data: {
                labels: topItemsData.map(item => item.item_name),
                datasets: [{
                    data: topItemsData.map(item => item.total_qty),
                    backgroundColor: [
                        '#ff7a5c',
                        '#6366f1',
                        '#10b981',
                        '#f59e0b',
                        '#ec4899'
                    ],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 20,
                            font: { size: 11 }
                        }
                    }
                },
                cutout: '70%'
            }
        });
    });
</script>
@endpush
