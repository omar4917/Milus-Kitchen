@extends('layouts.admin')

@section('page_title', 'Add Chef')

@section('content')
<div class="card card-form">
    <div class="card-body">
        <form action="{{ route('admin.chefs.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group">
                <label for="name">Chef Name *</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required placeholder="e.g. Sarah Johnson">
                @error('name')<span class="error-text">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label for="title">Title / Role *</label>
                <input type="text" id="title" name="title" value="{{ old('title', 'Chef') }}" required placeholder="e.g. Head Chef, Pastry Chef">
                @error('title')<span class="error-text">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label for="bio">Bio</label>
                <textarea id="bio" name="bio" rows="4" placeholder="A short description about the chef...">{{ old('bio') }}</textarea>
            </div>

            <div class="form-group">
                <label for="photo">Photo</label>
                <input type="file" id="photo" name="photo" accept="image/jpeg,image/png,image/jpg,image/webp">
                <small>Max 2MB. JPEG, PNG, or WebP</small>
                @error('photo')<span class="error-text">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label for="sort_order">Sort Order</label>
                <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}" min="0">
            </div>

            <div class="form-group checkbox-group">
                <label>
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                    Active (visible on homepage)
                </label>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Add Chef</button>
                <a href="{{ route('admin.chefs.index') }}" class="btn btn-outline">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
