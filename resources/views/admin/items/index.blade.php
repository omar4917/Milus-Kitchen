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
                        <th>Category</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                    <tr>
                        <td>
                            @if($item->photo_path)
                            <img src="{{ asset('storage/' . $item->photo_path) }}" alt="{{ $item->name }}" class="table-thumb">
                            @else
                            <span class="table-thumb-placeholder">🍽️</span>
                            @endif
                        </td>
                        <td><strong>{{ $item->name }}</strong></td>
                        <td>{{ $item->category->name }}</td>
                        <td>${{ number_format($item->price, 0) }}</td>
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
