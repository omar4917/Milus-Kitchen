@extends('layouts.admin')

@section('page_title', 'Add Category')

@section('content')
<div class="card card-form">
    <div class="card-body">
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf
            
            <div class="form-group">
                <label for="name">Category Name *</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                @error('name')<span class="error-text">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="3">{{ old('description') }}</textarea>
            </div>

            <div class="form-group">
                <label for="sort_order">Sort Order</label>
                <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}" min="0">
                <small>Lower numbers appear first</small>
            </div>

            <div class="form-group checkbox-group">
                <label>
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                    Active (visible on menu)
                </label>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Create Category</button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-outline">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
