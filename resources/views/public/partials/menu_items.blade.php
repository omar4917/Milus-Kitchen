@forelse($menuItems as $index => $item)
@php
    $itemJson = json_encode([
        'id' => $item->id,
        'name' => $item->name,
        'country' => $item->country,
        'description' => $item->description,
        'price' => $item->price,
        'discount_price' => $item->discount_price,
        'photo_path' => $item->photo_path,
        'discount_percentage' => $item->discount_percentage
    ]);
@endphp
<div class="col-lg-6 mb-4" data-aos="fade-up" data-aos-delay="{{ ($index % 2) * 100 }}">
    <div class="premium-card-horizontal" onclick='openItemModal({{ $itemJson }})'>
        <div class="card-img-wrap">
            @if($item->image)
            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="card-img">
            @else
            <img src="{{ asset('images/img_1.jpg') }}" alt="{{ $item->name }}" class="card-img">
            @endif
            
            @if($item->discount_percentage > 0)
            <div style="position: absolute; top: 15px; left: 15px; background: #ea005e; color: white; padding: 4px 10px; border-radius: 20px; font-size: 10px; font-weight: 700; box-shadow: 0 4px 10px rgba(234, 0, 94, 0.3);">
                {{ $item->discount_percentage }}% OFF
            </div>
            @endif
        </div>
        
        <div class="card-content">
            @if($item->country)
            <div class="country-badge">{{ $item->country }}</div>
            @endif
            @if($item->category)
            <span class="category-label">{{ $item->category->name }}</span>
            @endif
            <h3 class="mb-2">{{ $item->name }}</h3>
            <p class="description">{{ Str::limit($item->description, 85) }}</p>
            
            <div class="card-footer-actions">
                <div class="price-wrap">
                    @if($item->discount_price && $item->discount_price < $item->price)
                        <div style="display: flex; align-items: baseline;">
                            <span class="price">${{ number_format($item->discount_price, 2) }}</span>
                            <span class="old-price">${{ number_format($item->price, 2) }}</span>
                        </div>
                    @else
                        <span class="price">${{ number_format($item->price, 2) }}</span>
                    @endif
                </div>
                <button type="button" class="btn-order">Order</button>
            </div>
        </div>
    </div>
</div>
@empty
<div class="col-12 text-center py-5">
    <p class="text-muted">No menu items available at the moment.</p>
</div>
@endforelse
