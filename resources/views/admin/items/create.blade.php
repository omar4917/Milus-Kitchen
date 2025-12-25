@extends('layouts.admin')

@section('page_title', 'Add Menu Item')

@section('content')
<div class="card card-form">
    <div class="card-body">
        <form action="{{ route('admin.items.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group">
                <label for="category_id">Category *</label>
                <select id="category_id" name="category_id" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                    @endforeach
                </select>
                @error('category_id')<span class="error-text">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label for="name">Item Name *</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                @error('name')<span class="error-text">{{ $message }}</span>@enderror
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="3">{{ old('description') }}</textarea>
            </div>

            <div class="form-group">
                <label for="price">Price ($) *</label>
                <input type="number" id="price" name="price" value="{{ old('price') }}" min="0" step="1" required>
                @error('price')<span class="error-text">{{ $message }}</span>@enderror
            </div>

            <div class="form-row" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div class="form-group">
                    <label for="discount_price">Discount/Special Price ($)</label>
                    <input type="number" id="discount_price" name="discount_price" value="{{ old('discount_price') }}" min="0" step="1">
                    <small>Optional. Fixed discount price.</small>
                </div>
                <div class="form-group">
                    <label for="discount_percentage">Discount Percentage (%)</label>
                    <input type="number" id="discount_percentage" min="0" max="100" step="1">
                    <small>Percentage based discount.</small>
                </div>
            </div>

            <div class="form-group checkbox-group">
                <label>
                    <input type="checkbox" name="is_special" value="1" {{ old('is_special') ? 'checked' : '' }}>
                    Feature as Special Item (e.g. Holiday/Today's Special)
                </label>
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
                    <input type="checkbox" name="is_available" value="1" {{ old('is_available', true) ? 'checked' : '' }}>
                    Available (in stock)
                </label>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Create Item</button>
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
