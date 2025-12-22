@extends('layouts.admin')

@section('page_title', 'Categories')

@section('content')
<div class="page-actions">
    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">+ Add Category</a>
</div>

<div class="card">
    <div class="card-body">
        @if($categories->count() > 0)
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Items</th>
                        <th>Order</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                    <tr>
                        <td><strong>{{ $category->name }}</strong></td>
                        <td><code>{{ $category->slug }}</code></td>
                        <td>{{ $category->menu_items_count }}</td>
                        <td>{{ $category->sort_order }}</td>
                        <td>
                            <span class="status-badge {{ $category->is_active ? 'status-active' : 'status-inactive' }}">
                                {{ $category->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm">Edit</a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" 
                                      onsubmit="return confirm('Delete this category?')">
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
        @else
        <div class="empty-state-sm">
            <p>No categories yet. <a href="{{ route('admin.categories.create') }}">Create one</a></p>
        </div>
        @endif
    </div>
</div>
@endsection
