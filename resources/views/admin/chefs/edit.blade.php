@extends('layouts.admin')

@section('page_title', 'Edit Chef')

@section('content')
<div class="card card-form">
    <div class="card-body">
        <form action="{{ route('admin.chefs.update', $chef) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="name">Chef Name *</label>
                <input type="text" id="name" name="name" value="{{ old('name', $chef->name) }}" required>
                @error('name')<span class="error-text">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label for="title">Title / Role *</label>
                <input type="text" id="title" name="title" value="{{ old('title', $chef->title) }}" required>
                @error('title')<span class="error-text">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label for="bio">Bio</label>
                <textarea id="bio" name="bio" rows="4">{{ old('bio', $chef->bio) }}</textarea>
            </div>

            <div class="form-group">
                <label for="photo">Photo</label>
                @if($chef->photo_path)
                <div class="current-photo">
                    <img src="{{ asset('storage/' . $chef->photo_path) }}" alt="Current photo">
                    <span>Current photo</span>
                </div>
                @endif
                <input type="file" id="photo" name="photo" accept="image/jpeg,image/png,image/jpg,image/webp">
                <small>Leave empty to keep current photo. Max 2MB.</small>
            </div>

            <div class="form-group">
                <label for="sort_order">Sort Order</label>
                <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $chef->sort_order) }}" min="0">
            </div>

            <div class="form-group checkbox-group">
                <label>
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $chef->is_active) ? 'checked' : '' }}>
                    Active (visible on homepage)
                </label>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Update Chef</button>
                <a href="{{ route('admin.chefs.index') }}" class="btn btn-outline">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
