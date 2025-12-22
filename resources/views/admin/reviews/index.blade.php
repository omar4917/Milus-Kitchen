@extends('layouts.admin')

@section('title', 'Manage Reviews')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Customer Reviews</h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Customer</th>
                        <th>Rating</th>
                        <th>Comment</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reviews as $review)
                    <tr>
                        <td>{{ $review->menuItem->name ?? 'Deleted Item' }}</td>
                        <td>
                            {{ $review->reviewer_name }}<br>
                            <small class="text-muted">{{ $review->email ?? ($review->user->email ?? '-') }}</small>
                        </td>
                        <td>
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $review->rating)
                                    <span style="color: #ffc107;">★</span>
                                @else
                                    <span style="color: #ddd;">★</span>
                                @endif
                            @endfor
                        </td>
                        <td style="max-width: 300px;">{{ Str::limit($review->comment, 100) }}</td>
                        <td>{{ $review->created_at->format('M d, Y') }}</td>
                        <td>
                            @if($review->is_approved)
                                <span class="badge badge-success">Approved</span>
                            @else
                                <span class="badge badge-warning">Pending</span>
                            @endif
                        </td>
                        <td>
                            @if(!$review->is_approved)
                            <form action="{{ route('admin.reviews.approve', $review) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-success">Approve</button>
                            </form>
                            @endif
                            <form action="{{ route('admin.reviews.destroy', $review) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this review?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">No reviews yet</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $reviews->links() }}
        </div>
    </div>
</div>
@endsection
