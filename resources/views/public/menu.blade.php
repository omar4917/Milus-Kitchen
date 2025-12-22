@extends('layouts.app')

@section('title', 'Our Menu')

@section('content')
<div class="cover_1 overlay bg-slant-white bg-light">
    <div class="img_bg" style="background-image: url({{ asset('images/slider-1.jpg') }}); min-height: 300px;" data-stellar-background-ratio="0.5">
        <div class="container">
            <div class="row align-items-center justify-content-center text-center" style="padding-top: 100px;">
                <div class="col-md-10" data-aos="fade-up">
                    <h2 class="heading mb-3">Our Menu</h2>
                    <p class="sub-heading">Discover our delicious offerings</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="section bg-light" data-aos="fade-up">
    <div class="container">
        <div class="row section-heading justify-content-center mb-5">
            <div class="col-md-8 text-center">
                <h2 class="heading mb-3">Full Menu</h2>
            </div>
        </div>
        
        <!-- Category Filter -->
        <div class="row justify-content-center mb-4">
            <div class="col-md-8 text-center">
                <a href="{{ route('menu') }}" class="btn {{ !request('category') ? 'btn-primary' : 'btn-outline-primary' }} m-1">All</a>
                @foreach(\App\Models\Category::all() as $category)
                    <a href="{{ route('menu', ['category' => $category->id]) }}" 
                       class="btn {{ request('category') == $category->id ? 'btn-primary' : 'btn-outline-primary' }} m-1">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-10">
                @php
                    $query = \App\Models\MenuItem::with('category')->where('is_available', true);
                    if(request('category')) {
                        $query->where('category_id', request('category'));
                    }
                    $menuItems = $query->get();
                @endphp
                
                @forelse($menuItems as $item)
                <div class="d-block d-md-flex menu-food-item" style="background: white; margin-bottom: 15px; padding: 20px; border-radius: 10px;">
                    <div class="text order-1 mb-3">
                        @if($item->image)
                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" style="width: 80px; height: 80px; object-fit: cover; border-radius: 5px;">
                        @else
                        <img src="{{ asset('images/img_1.jpg') }}" alt="{{ $item->name }}">
                        @endif
                        <h3><a href="#">{{ $item->name }}</a></h3>
                        <p>{{ $item->description }}</p>
                        @if($item->category)
                        <span class="badge badge-secondary">{{ $item->category->name }}</span>
                        @endif
                    </div>
                    <div class="price order-2">
                        <strong style="font-size: 20px;">${{ number_format($item->price, 2) }}</strong>
                        <form action="{{ route('cart.add') }}" method="POST" class="ajax-add-cart" style="margin-top: 15px;">
                            @csrf
                            <input type="hidden" name="menu_item_id" value="{{ $item->id }}">
                            <button type="submit" class="btn btn-primary">Add to Cart</button>
                        </form>
                    </div>
                </div>
                @empty
                <div class="text-center">
                    <p>No menu items available at the moment.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
