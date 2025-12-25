@extends('layouts.admin')

@section('page_title', 'Edit Menu Item')

@section('content')
<div class="card card-form">
    <div class="card-body">
        <form action="{{ route('admin.items.update', $item) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label for="category_id">Category *</label>
                <select id="category_id" name="category_id" required>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $item->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="name">Item Name *</label>
                <input type="text" id="name" name="name" value="{{ old('name', $item->name) }}" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="3">{{ old('description', $item->description) }}</textarea>
            </div>

            <div class="form-group">
                <label for="price">Price ($) *</label>
                <input type="number" id="price" name="price" value="{{ old('price', $item->price) }}" min="0" step="1" required>
            </div>

            <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label for="discount_price">Discount/Special Price ($)</label>
                    <input type="number" id="discount_price" name="discount_price" value="{{ old('discount_price', $item->discount_price) }}" min="0" step="1">
                </div>
                <div class="form-group">
                    <label for="discount_percentage">Discount Percentage (%)</label>
                    <input type="number" id="discount_percentage" value="{{ $item->discount_percentage }}" min="0" max="100" step="1">
                </div>
            </div>

            <div class="form-group checkbox-group">
                <label>
                    <input type="checkbox" name="is_special" value="1" {{ old('is_special', $item->is_special) ? 'checked' : '' }}>
                    Feature as Special Item
                </label>
            </div>

            <div class="form-group">
                <label for="photo">Photo</label>
                @if($item->photo_path)
                <div class="current-photo">
                    <img src="{{ asset('storage/' . $item->photo_path) }}" alt="Current photo">
                    <span>Current photo</span>
                </div>
                @endif
                <input type="file" id="photo" name="photo" accept="image/jpeg,image/png,image/jpg,image/webp">
                <small>Leave empty to keep current photo. Max 2MB.</small>
            </div>

            <div class="form-group">
                <label for="sort_order">Sort Order</label>
                <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $item->sort_order) }}" min="0">
            </div>

            <div class="form-group checkbox-group">
                <label>
                    <input type="checkbox" name="is_available" value="1" {{ old('is_available', $item->is_available) ? 'checked' : '' }}>
                    Available (in stock)
                </label>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Update Item</button>
                <a href="{{ route('admin.items.index') }}" class="btn btn-outline">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const priceInput = document.getElementById('price');
    const discountPriceInput = document.getElementById('discount_price');
    const discountPercentageInput = document.getElementById('discount_percentage');

    function updateFromPercentage() {
        const price = parseFloat(priceInput.value) || 0;
        const percentage = parseFloat(discountPercentageInput.value) || 0;
        
        if (price > 0 && percentage > 0) {
            const discount = price * (percentage / 100);
            discountPriceInput.value = Math.round(price - discount);
        } else if (percentage === 0) {
            discountPriceInput.value = '';
        }
    }

    function updateFromPrice() {
        const price = parseFloat(priceInput.value) || 0;
        const discountPrice = parseFloat(discountPriceInput.value) || 0;
        
        if (price > 0 && discountPrice > 0 && discountPrice < price) {
            const savings = price - discountPrice;
            discountPercentageInput.value = Math.round((savings / price) * 100);
        } else {
            discountPercentageInput.value = '';
        }
    }

    discountPercentageInput.addEventListener('input', updateFromPercentage);
    discountPriceInput.addEventListener('input', updateFromPrice);
    priceInput.addEventListener('input', function() {
        if (discountPercentageInput.value) updateFromPercentage();
        else if (discountPriceInput.value) updateFromPrice();
    });
});
</script>
@endpush
