@extends('layouts.app')

@section('title', $category->name . ' - Menu')

@section('content')
<section class="category-page">
    <div class="container">
        <nav class="breadcrumb">
            <a href="{{ route('menu') }}">Menu</a>
            <span>/</span>
            <span>{{ $category->name }}</span>
        </nav>

        <div class="page-header">
            <h1>{{ $category->name }}</h1>
            @if($category->description)
            <p>{{ $category->description }}</p>
            @endif
        </div>

        <!-- Category Navigation -->
        <div class="category-nav">
            @foreach($categories as $cat)
            <a href="{{ route('menu.category', $cat->slug) }}" 
               class="category-nav-item {{ $cat->id === $category->id ? 'active' : '' }}">
                {{ $cat->name }}
            </a>
            @endforeach
        </div>

        @if($items->count() > 0)
        <div class="items-grid">
            @foreach($items as $item)
            <div class="item-card">
                <div class="item-image">
                    @if($item->photo_path)
                        <img src="{{ asset('storage/' . $item->photo_path) }}" alt="{{ $item->name }}" loading="lazy">
                    @else
                        <div class="item-placeholder">🍽️</div>
                    @endif
                </div>
                <div class="item-content">
                    <h3 class="item-name">{{ $item->name }}</h3>
                    @if($item->description)
                    <p class="item-description">{{ Str::limit($item->description, 100) }}</p>
                    @endif
                    <div class="item-footer">
                        <span class="item-price">${{ number_format($item->price, 0) }}</span>
                        <form action="{{ route('cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="menu_item_id" value="{{ $item->id }}">
                            <button type="submit" class="btn btn-primary btn-sm">Add to Cart</button>
                        </form>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <div class="empty-state">
            <div class="empty-icon">🍽️</div>
            <h2>No items available</h2>
            <p>Check back soon for delicious additions!</p>
            <a href="{{ route('menu') }}" class="btn btn-primary">Back to Menu</a>
        </div>
        @endif
    </div>
</section>
@endsection
