@forelse($menuItems as $item)
<div class="col-md-6 col-lg-4 mb-4" data-aos="fade-up">
    <div class="menu-item-card h-100" 
         onclick='openItemModal(@json($item))'
         style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.05); display: flex; flex-direction: column; transition: transform 0.3s ease; cursor: pointer;">
        
        <div class="item-image" style="height: 250px; overflow: hidden; position: relative;">
            @if($item->photo_path)
            <img src="{{ asset('storage/' . $item->photo_path) }}" alt="{{ $item->name }}" style="width: 100%; height: 100%; object-fit: cover;">
            @else
            <img src="{{ asset('images/img_1.jpg') }}" alt="{{ $item->name }}" style="width: 100%; height: 100%; object-fit: cover;">
            @endif
            
            @if($item->discount_price && $item->discount_price < $item->price)
                <!-- Discount Badge -->
                <div style="position: absolute; top: 15px; left: 15px; background: #ea005e; color: white; padding: 5px 12px; border-radius: 20px; font-size: 13px; font-weight: 700; display: flex; align-items: center; box-shadow: 0 4px 10px rgba(234, 0, 94, 0.3);">
                    <span class="icon ion-pricetag" style="margin-right: 5px; font-size: 14px;"></span> 
                    {{ round((($item->price - $item->discount_price) / $item->price) * 100) }}% off
                </div>
            @elseif($item->category)
                <span class="badge badge-primary" style="position: absolute; top: 15px; left: 15px; padding: 5px 10px; border-radius: 5px;">{{ $item->category->name }}</span>
            @endif

            @if($item->is_special)
            <span class="badge badge-danger" style="position: absolute; top: 15px; right: 15px; padding: 5px 10px; border-radius: 5px;">Special</span>
            @endif
        </div>
        
        <div class="item-body d-flex flex-column" style="padding: 25px; flex: 1;">
            <h3 style="font-size: 1.25rem; margin-bottom: 5px; font-weight: 700; color: #333;">{{ $item->name }}</h3>
            <p style="color: #666; font-size: 0.9rem; margin-bottom: 15px; flex-grow: 1;">{{ \Illuminate\Support\Str::limit($item->description, 100) }}</p>
            
            <div class="d-flex justify-content-between align-items-center mt-auto">
                <div class="price-wrap">
                    @if($item->discount_price && $item->discount_price < $item->price)
                        <div class="d-flex flex-column">
                            <span style="color: #999; text-decoration: line-through; font-size: 0.85rem; font-weight: 500;">
                                <span style="font-size: 0.9em">$</span>{{ number_format($item->price, 0) }}
                            </span>
                            <div style="color: #ea005e; font-size: 1.3rem; font-weight: 800; line-height: 1;">
                                <sup style="font-size: 0.6em; top: -0.2em; font-weight: 600;">$</sup>{{ number_format($item->discount_price, 0) }}
                            </div>
                        </div>
                    @else
                        <div style="color: #333; font-size: 1.3rem; font-weight: 800; line-height: 1;">
                            <sup style="font-size: 0.6em; top: -0.2em; font-weight: 600;">$</sup>{{ number_format($item->price, 0) }}
                        </div>
                    @endif
                </div>
                <!-- Fake button just for visual cue -->
                <button class="btn btn-sm px-3" style="background: #f5f5f5; color: #333; border-radius: 20px; font-weight: 600;" onclick="event.stopPropagation(); openItemModal(@json($item))">
                    <span class="icon ion-plus-round"></span>
                </button>
            </div>
        </div>
    </div>
</div>
@empty
<div class="col-12 text-center py-5">
    <p class="text-muted">No menu items available at the moment.</p>
</div>
@endforelse
