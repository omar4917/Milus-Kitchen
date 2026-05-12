@extends('layouts.admin')

@section('page_title', 'Chefs')

@section('content')
<div class="page-actions">
    <a href="{{ route('admin.chefs.create') }}" class="btn btn-primary">+ Add Chef</a>
</div>

<div class="card">
    <div class="card-body">
        @if($chefs->count() > 0)
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Photo</th>
                        <th>Name</th>
                        <th>Title</th>
                        <th>Order</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($chefs as $chef)
                    <tr>
                        <td>
                            @if($chef->photo_path)
                            <img src="{{ asset('storage/' . $chef->photo_path) }}" alt="{{ $chef->name }}" class="table-thumb" style="border-radius: 50%;">
                            @else
                            <span class="table-thumb-placeholder">👨‍🍳</span>
                            @endif
                        </td>
                        <td><strong>{{ $chef->name }}</strong></td>
                        <td>{{ $chef->title }}</td>
                        <td>{{ $chef->sort_order }}</td>
                        <td>
                            <span class="status-badge {{ $chef->is_active ? 'status-active' : 'status-inactive' }}">
                                {{ $chef->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.chefs.edit', $chef) }}" class="btn btn-sm">Edit</a>
                                <form action="{{ route('admin.chefs.destroy', $chef) }}" method="POST" 
                                      onsubmit="return confirm('Delete this chef?')">
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
            <p>No chefs yet. <a href="{{ route('admin.chefs.create') }}">Add one</a></p>
        </div>
        @endif
    </div>
</div>
@endsection
