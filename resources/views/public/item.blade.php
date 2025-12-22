@extends('layouts.app')

@section('title', $item->name)

@section('content')
<section class="item-page">
    <div class="container">
        <nav class="breadcrumb">
            <a href="{{ route('menu') }}">Menu</a>
            <span>/</span>
            <a href="{{ route('menu.category', $item->category->slug) }}">{{ $item->category->name }}</a>
            <span>/</span>
            <span>{{ $item->name }}</span>
        </nav>

        <div class="item-detail">
            <div class="item-detail-image">
                @if($item->photo_path)
                    <img src="{{ asset('storage/' . $item->photo_path) }}" alt="{{ $item->name }}">
                @else
                    <div class="item-placeholder-lg">🍽️</div>
                @endif
            </div>
            
            <div class="item-detail-content">
                <span class="item-category-badge">{{ $item->category->name }}</span>
                <h1>{{ $item->name }}</h1>
                
                @if($item->description)
                <p class="item-description">{{ $item->description }}</p>
                @endif
                
                <div class="item-price-lg">${{ number_format($item->price, 0) }}</div>

                <form action="{{ route('cart.add') }}" method="POST" class="add-form">
                    @csrf
                    <input type="hidden" name="menu_item_id" value="{{ $item->id }}">
                    
                    <div class="quantity-selector">
                        <label>Quantity:</label>
                        <div class="qty-control">
                            <button type="button" class="qty-btn" id="qtyMinus">−</button>
                            <input type="number" name="quantity" id="qtyInput" value="1" min="1" max="10">
                            <button type="button" class="qty-btn" id="qtyPlus">+</button>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary btn-lg btn-block">Add to Cart</button>
                </form>

                <a href="{{ route('menu') }}" class="back-link">← Back to Menu</a>
            </div>
        </div>

        @if($relatedItems->count() > 0)
        <div class="related-items">
            <h2>You might also like</h2>
            <div class="items-grid items-grid-sm">
                @foreach($relatedItems as $related)
                <div class="item-card item-card-sm">
                    <div class="item-image">
                        @if($related->photo_path)
                            <img src="{{ asset('storage/' . $related->photo_path) }}" alt="{{ $related->name }}">
                        @else
                            <div class="item-placeholder">🍽️</div>
                        @endif
                    </div>
                    <div class="item-content">
                        <h3 class="item-name">{{ $related->name }}</h3>
                        <span class="item-price">${{ number_format($related->price, 0) }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const input = document.getElementById('qtyInput');
    const minus = document.getElementById('qtyMinus');
    const plus = document.getElementById('qtyPlus');

    minus.addEventListener('click', () => {
        if (input.value > 1) input.value = parseInt(input.value) - 1;
    });
    plus.addEventListener('click', () => {
        if (input.value < 10) input.value = parseInt(input.value) + 1;
    });
});
</script>
@endpush
