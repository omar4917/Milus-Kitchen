@extends('layouts.admin')

@section('page_title', 'Menu Items')

@section('content')
<div class="page-actions">
    <a href="{{ route('admin.items.create') }}" class="btn btn-primary">+ Add Item</a>
</div>

<!-- Filters -->
<div class="filters-bar">
    <form action="{{ route('admin.items.index') }}" method="GET" class="filters-form">
        <select name="category" onchange="this.form.submit()">
            <option value="">All Categories</option>
            @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                {{ $cat->name }}
            </option>
            @endforeach
        </select>
        <select name="status" onchange="this.form.submit()">
            <option value="">All Status</option>
            <option value="available" {{ request('status') === 'available' ? 'selected' : '' }}>Available</option>
            <option value="unavailable" {{ request('status') === 'unavailable' ? 'selected' : '' }}>Sold Out</option>
        </select>
    </form>
</div>

<div class="card">
    <div class="card-body">
        @if($items->count() > 0)
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Photo</th>
                        <th>Name</th>
                        <th>Country</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Discount</th>
                        <th>Savings %</th>
                        <th>Special</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                    <tr>
                        <td>
                            @if($item->photo_url)
                                <img src="{{ $item->photo_url }}" alt="{{ $item->name }}" class="table-thumb">
                            @else
                                <div class="table-thumb-placeholder">
                                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM12 20C7.59 20 4 16.41 4 12C4 7.59 7.59 4 12 4C16.41 4 20 7.59 20 12C20 16.41 16.41 20 12 20Z" fill="currentColor"/>
                                        <path d="M11 7H8V14C8 14.55 8.45 15 9 15H11V17H13V7H11V15H11V7Z" fill="currentColor"/>
                                        <path d="M16 7H14V17H16V13C17.1 13 18 12.1 18 11V7H16V11H16V7Z" fill="currentColor"/>
                                    </svg>
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="item-name-cell">
                                <span class="item-name-text">{{ $item->name }}</span>
                            </div>
                        </td>
                        <td>{{ $item->country ?? '-' }}</td>
                        <td>{{ $item->category->name }}</td>
                        <td>${{ number_format($item->price, 0) }}</td>
                        <td>
                            @if($item->discount_price)
                                <span class="text-danger font-weight-bold">${{ number_format($item->discount_price, 0) }}</span>
                                <br><small class="text-muted"><del>${{ number_format($item->price, 0) }}</del></small>
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if($item->discount_percentage > 0)
                                <span class="badge badge-success" style="background: #ecfdf5; color: #059669; border: 1px solid #d1fae5; padding: 4px 10px; border-radius: 12px; font-size: 11px;">
                                    {{ $item->discount_percentage }}% Off
                                </span>
                            @else
                                <span class="text-muted" style="font-size: 12px;">-</span>
                            @endif
                        </td>
                        <td>
                            <span class="status-badge {{ $item->is_special ? 'status-special' : 'status-regular' }}">
                                {{ $item->is_special ? 'Yes' : 'No' }}
                            </span>
                        </td>
                        <td>
                            <form action="{{ route('admin.items.toggle', $item) }}" method="POST" style="display:inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="status-badge {{ $item->is_available ? 'status-active' : 'status-inactive' }}">
                                    {{ $item->is_available ? 'Available' : 'Sold Out' }}
                                </button>
                            </form>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.items.edit', $item) }}" class="btn btn-sm">Edit</a>
                                <form action="{{ route('admin.items.destroy', $item) }}" method="POST" 
                                      onsubmit="return confirm('Delete this item?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="pagination-wrap">
            {{ $items->withQueryString()->links() }}
        </div>
        @else
        <div class="empty-state-sm">
            <p>No menu items yet. <a href="{{ route('admin.items.create') }}">Create one</a></p>
        </div>
        @endif
    </div>
</div>
@endsection
