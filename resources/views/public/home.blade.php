@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="cover_1 overlay bg-slant-white bg-light" id="section-home">
    <div class="img_bg" style="background-image: url({{ asset('images/collage_main.jpg') }}); position: relative;" data-stellar-background-ratio="0.5">
        <!-- Dark overlay for better text readability -->
        <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(135deg, rgba(0,0,0,0.6) 0%, rgba(0,0,0,0.3) 100%);"></div>
        <div class="container" style="position: relative; z-index: 2;">
            <div class="row align-items-center justify-content-center text-center" style="min-height: 65vh;">
                <div class="col-md-10" data-aos="fade-up">
                    <h1 class="heading mb-4" style="color: white; font-size: 3.5rem; font-weight: 700; text-shadow: 2px 2px 10px rgba(0,0,0,0.3); line-height: 1.2;">Where Food Speaks <br><span style="color: #ff7a5c;">With Your Palate</span></h1>
                    <p class="sub-heading mb-5" style="color: rgba(255,255,255,0.9); font-size: 1.25rem; max-width: 600px; margin: 0 auto;">Experience culinary excellence with our exquisite menu crafted by master chefs using the finest ingredients</p>
                    <div style="display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
                        <a href="{{ route('menu') }}" class="btn px-5 py-3" style="background: linear-gradient(135deg, #ff7a5c 0%, #ff5733 100%); color: white; border-radius: 30px; font-weight: 600; font-size: 16px; box-shadow: 0 8px 25px rgba(255,122,92,0.4); transition: all 0.3s;">Order Now</a>
                        <a href="{{ route('about') }}" class="btn btn-outline-white px-5 py-3" style="border-radius: 30px; font-weight: 600; font-size: 16px;">About Us</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Find your best food Section -->
<div class="section" data-aos="fade-up">
    <div class="container">
        <div class="row section-heading justify-content-center mb-5">
            <div class="col-md-8 text-center">
                <h2 class="heading mb-3">Find your best food</h2>
                <p class="sub-heading mb-5">Discover our signature dishes crafted with passion</p>
            </div>
        </div>
        <div class="row">
            @php
                $featuredItems = \App\Models\MenuItem::with('category')->where('is_available', true)->take(4)->get();
            @endphp
            
            @foreach($featuredItems as $index => $item)
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
            <div class="col-lg-6 mb-4" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                <div class="premium-card-horizontal" onclick='openItemModal({{ $itemJson }})'>
                    <!-- Image Side -->
                    <div class="card-img-wrap">
                        @if($item->image)
                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" class="card-img" style="transition: transform 0.5s ease;">
                        @else
                        <img src="{{ asset('images/img_' . ($index + 1) . '.jpg') }}" alt="{{ $item->name }}" class="card-img" style="transition: transform 0.5s ease;">
                        @endif
                        
                        @if($item->discount_percentage > 0)
                        <div style="position: absolute; top: 15px; left: 15px; background: #ea005e; color: white; padding: 4px 10px; border-radius: 20px; font-size: 11px; font-weight: 700; box-shadow: 0 4px 10px rgba(234, 0, 94, 0.3);">
                            {{ $item->discount_percentage }}% OFF
                        </div>
                        @endif
                    </div>
                    
                    <!-- Content Side -->
                    <div class="card-content">
                        @if($item->country)
                        <div class="country-badge">{{ $item->country }}</div>
                        @endif
                        <span class="category-label">{{ $item->category ? $item->category->name : 'Signature' }}</span>
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
                            <button class="btn-order">Order</button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        </div>
    </div>
</div>

<!-- Holiday Special Section -->
@php
    $specialItems = \App\Models\MenuItem::with('category')
        ->where('is_available', true)
        ->where('is_special', true)
        ->take(6)
        ->get();
@endphp

@if($specialItems->isNotEmpty())
<div style="background: linear-gradient(135deg, #fff5f0 0%, #ffe8e0 100%); padding: 80px 0;" data-aos="fade-up">
    <div class="container">
        <div class="row section-heading justify-content-center mb-5">
            <div class="col-md-8 text-center">
                <span style="display: inline-block; background: #ff5733; color: white; padding: 6px 20px; border-radius: 20px; font-size: 12px; font-weight: 700; letter-spacing: 1px; margin-bottom: 15px;">🎄 SEASONAL OFFERS</span>
                <h2 class="heading mb-3" style="color: #333; font-weight: 700;">Holiday Specials</h2>
                <p class="sub-heading" style="color: #666;">Limited time festive offers on our most popular signature dishes</p>
            </div>
        </div>
        <div class="row">
            @foreach($specialItems as $index => $special)
            @php
                $itemJson = json_encode([
                    'id' => $special->id,
                    'name' => $special->name,
                    'country' => $special->country,
                    'description' => $special->description,
                    'price' => $special->price,
                    'discount_price' => $special->discount_price,
                    'photo_path' => $special->photo_path,
                    'discount_percentage' => $special->discount_percentage
                ]);
            @endphp
            <div class="col-lg-6 mb-4" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                <div class="premium-card-horizontal" onclick='openItemModal({{ $itemJson }})'>
                    <!-- Image Side -->
                    <div class="card-img-wrap">
                        @if($special->photo_url)
                        <img src="{{ $special->photo_url }}" alt="{{ $special->name }}" class="card-img">
                        @else
                        <img src="{{ asset('images/img_' . ($index + 1) . '.jpg') }}" alt="{{ $special->name }}" class="card-img">
                        @endif
                        
                        <div style="position: absolute; top: 15px; left: 15px; z-index: 2; display: flex; flex-direction: column; gap: 8px;">
                            <span style="background: linear-gradient(135deg, #ff5733 0%, #ff7a5c 100%); color: white; padding: 4px 12px; border-radius: 25px; font-size: 10px; font-weight: 700; box-shadow: 0 4px 15px rgba(255,87,51,0.3);">🔥 SPECIAL</span>
                            @if($special->discount_percentage > 0)
                            <div style="background: #ea005e; color: white; padding: 4px 10px; border-radius: 20px; font-size: 10px; font-weight: 700; display: flex; align-items: center; box-shadow: 0 4px 10px rgba(234, 0, 94, 0.3); width: fit-content;">
                                {{ $special->discount_percentage }}% OFF
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Content Side -->
                    <div class="card-content" style="background: #fffdfb;">
                        @if($special->country)
                        <div class="country-badge">{{ $special->country }}</div>
                        @else
                        <div class="country-badge">Featured</div>
                        @endif
                        <span class="category-label">{{ $special->category ? $special->category->name : 'Holiday Gift' }}</span>
                        <h3 class="mb-2">{{ $special->name }}</h3>
                        <p class="description">{{ Str::limit($special->description, 80) }}</p>
                        
                        <div class="card-footer-actions">
                            <div class="price-wrap">
                                @if($special->discount_price)
                                    <div style="display: flex; align-items: baseline;">
                                        <span class="price">${{ number_format($special->discount_price, 2) }}</span>
                                        <span class="old-price">${{ number_format($special->price, 2) }}</span>
                                    </div>
                                @else
                                    <span class="price">${{ number_format($special->price, 2) }}</span>
                                @endif
                            </div>
                            <button class="btn-order">Order</button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

<!-- Menu Explorer Section (Tabbed Menu) -->
<div class="section bg-light" id="section-menu" data-aos="fade-up">
    <div class="container">
        <div class="row section-heading justify-content-center mb-5">
            <div class="col-md-8 text-center">
                <h2 class="heading mb-3">Menu</h2>
                <p class="sub-heading mb-5">Explore our delicious offerings</p>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12">
                @php
                    $categories = \App\Models\Category::with(['menuItems' => function($q) { $q->where('is_available', true)->take(4); }])->take(3)->get();
                @endphp
                
                <ul class="nav site-tab-nav justify-content-center mb-4" id="pills-tab" role="tablist">
                    @foreach($categories as $index => $category)
                    <li class="nav-item">
                        <a class="nav-link {{ $index == 0 ? 'active' : '' }}" id="pills-{{ $category->id }}-tab" data-toggle="pill" href="#pills-{{ $category->id }}" role="tab">{{ $category->name }}</a>
                    </li>
                    @endforeach
                </ul>
                
                <div class="tab-content" id="pills-tabContent">
                    @foreach($categories as $index => $category)
                    <div class="tab-pane fade {{ $index == 0 ? 'show active' : '' }}" id="pills-{{ $category->id }}" role="tabpanel">
                        <div class="row">
                            @foreach($category->menuItems as $itemIndex => $item)
                            <div class="col-lg-6 mb-4">
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
                                <div class="premium-card-horizontal" onclick='openItemModal({{ $itemJson }})' style="height: 220px;">
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
                                    <div class="card-content" style="padding: 20px 25px;">
                                        @if($item->country)
                                        <div class="country-badge" style="top: 20px; right: 25px;">{{ $item->country }}</div>
                                        @endif
                                        <span class="category-label" style="margin-bottom: 5px;">{{ $category->name }}</span>
                                        <h3 style="font-size: 1.25rem; margin-bottom: 8px;">{{ $item->name }}</h3>
                                        <p class="description" style="margin-bottom: 12px; font-size: 0.8rem;">{{ Str::limit($item->description, 70) }}</p>
                                        <div class="card-footer-actions">
                                            <span class="price" style="font-size: 1.3rem;">${{ number_format($item->price, 2) }}</span>
                                            <button type="button" class="btn-order" style="padding: 8px 20px; font-size: 13px;">Order</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <div class="text-center mt-5">
                    <a href="{{ route('menu') }}" class="btn-outline-custom">View Full Menu</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- The Restaurant Section -->
<div class="section pb-3 bg-white" id="section-about" data-aos="fade-up">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-md-12 col-lg-8 section-heading text-center">
                <h2 class="heading mb-5">The Restaurant</h2>
                <p>Welcome to Meal Restaurant, where culinary excellence meets warm hospitality. Our chefs craft each dish with passion and the finest ingredients, creating memorable dining experiences.</p>
                <p>Experience the perfect blend of traditional recipes and modern culinary techniques in a sophisticated atmosphere.</p>
                <p><a href="{{ route('about') }}" class="btn btn-primary">Learn More About Us</a></p>
            </div>
        </div>
    </div>
</div>

<div class="section bg-white pt-2 pb-2 text-center" data-aos="fade">
    <p><img src="{{ asset('images/bg_hero.png') }}" alt="Meal Restaurant" class="img-fluid" style="max-height: 400px; width: 100%; object-fit: cover;"></p>
</div>

<!-- What Our Customers Say Section -->
<div style="background: #f8f9fa; padding: 80px 0;" data-aos="fade-up">
    <div class="container">
        <div class="row section-heading justify-content-center mb-5">
            <div class="col-md-8 text-center">
                <h2 class="heading mb-3" style="color: #333; font-weight: 700;">What Our Customers Say</h2>
                <p class="sub-heading" style="color: #666;">Real reviews from our valued customers</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="0">
                <div style="background: white; border-radius: 20px; padding: 30px; height: 100%; box-shadow: 0 5px 25px rgba(0,0,0,0.08);">
                    <div style="color: #ffc107; font-size: 18px; margin-bottom: 15px;">★★★★★</div>
                    <p style="color: #555; font-size: 15px; line-height: 1.7; margin-bottom: 20px; font-style: italic;">"The Mutton Biryani was absolutely phenomenal! The flavors were authentic and the portion size was generous. Will definitely order again!"</p>
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="width: 50px; height: 50px; border-radius: 50%; background: linear-gradient(135deg, #ff7a5c 0%, #ff5733 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 18px;">S</div>
                        <div>
                            <h5 style="margin: 0; font-weight: 600; color: #333;">Sarah M.</h5>
                            <p style="margin: 0; font-size: 13px; color: #888;">Verified Customer</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div style="background: white; border-radius: 20px; padding: 30px; height: 100%; box-shadow: 0 5px 25px rgba(0,0,0,0.08);">
                    <div style="color: #ffc107; font-size: 18px; margin-bottom: 15px;">★★★★★</div>
                    <p style="color: #555; font-size: 15px; line-height: 1.7; margin-bottom: 20px; font-style: italic;">"Fast delivery and the food was still hot when it arrived. The presentation was beautiful and tasted even better. Highly recommend!"</p>
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="width: 50px; height: 50px; border-radius: 50%; background: linear-gradient(135deg, #4466ff 0%, #3355ee 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 18px;">J</div>
                        <div>
                            <h5 style="margin: 0; font-weight: 600; color: #333;">John D.</h5>
                            <p style="margin: 0; font-size: 13px; color: #888;">Verified Customer</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div style="background: white; border-radius: 20px; padding: 30px; height: 100%; box-shadow: 0 5px 25px rgba(0,0,0,0.08);">
                    <div style="color: #ffc107; font-size: 18px; margin-bottom: 15px;">★★★★★</div>
                    <p style="color: #555; font-size: 15px; line-height: 1.7; margin-bottom: 20px; font-style: italic;">"Best restaurant in town! The quality is consistent every time. My family loves ordering from Meal for our weekend dinners."</p>
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <div style="width: 50px; height: 50px; border-radius: 50%; background: linear-gradient(135deg, #20c997 0%, #28a745 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 18px;">A</div>
                        <div>
                            <h5 style="margin: 0; font-weight: 600; color: #333;">Aisha K.</h5>
                            <p style="margin: 0; font-size: 13px; color: #888;">Verified Customer</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- How It Works Section -->
<div class="section bg-light" data-aos="fade-up" style="padding: 80px 0;">
    <div class="container">
        <div class="row section-heading justify-content-center mb-5">
            <div class="col-md-8 text-center">
                <h2 class="heading mb-3" style="color: #333; font-weight: 600;">How It Works</h2>
                <p class="sub-heading" style="color: #666;">Getting your favorite home-made food is simple and quick.</p>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-4 col-sm-6 mb-4" data-aos="fade-up" data-aos-delay="0">
                <div style="background: #fffbf5; border-radius: 20px; padding: 50px 30px 40px; text-align: center; height: 100%; position: relative; box-shadow: 0 5px 25px rgba(0,0,0,0.05); transition: all 0.3s ease;">
                    <div style="position: absolute; top: -18px; left: 50%; transform: translateX(-50%); background: linear-gradient(135deg, #ff7a5c 0%, #ff5733 100%); color: white; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 14px; box-shadow: 0 4px 15px rgba(255,122,92,0.4);">1</div>
                    <div style="width: 70px; height: 70px; margin: 0 auto 20px; background: linear-gradient(135deg, #fff5f0 0%, #ffe8e0 100%); border-radius: 15px; display: flex; align-items: center; justify-content: center;">
                        <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="#ff7a5c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3h18v18H3z"/><path d="M7 7h10M7 12h10M7 17h6"/></svg>
                    </div>
                    <h4 style="font-weight: 600; margin-bottom: 12px; color: #333;">Browse Menu</h4>
                    <p style="color: #777; font-size: 0.95rem; line-height: 1.6;">Explore our delicious selection of authentic home-made dishes</p>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div style="background: linear-gradient(135deg, #fff8f0 0%, #fff2e6 100%); border: 2px solid #ff7a5c; border-radius: 20px; padding: 50px 30px 40px; text-align: center; height: 100%; position: relative; box-shadow: 0 8px 30px rgba(255,122,92,0.15); transition: all 0.3s ease;">
                    <div style="position: absolute; top: -18px; left: 50%; transform: translateX(-50%); background: linear-gradient(135deg, #ff7a5c 0%, #ff5733 100%); color: white; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 14px; box-shadow: 0 4px 15px rgba(255,122,92,0.4);">2</div>
                    <div style="width: 70px; height: 70px; margin: 0 auto 20px; background: linear-gradient(135deg, #ff7a5c 0%, #ff5733 100%); border-radius: 15px; display: flex; align-items: center; justify-content: center;">
                        <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                    </div>
                    <h4 style="font-weight: 600; margin-bottom: 12px; color: #333;">Add to Cart</h4>
                    <p style="color: #777; font-size: 0.95rem; line-height: 1.6;">Select your favorites and customize your perfect order</p>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div style="background: #fffbf5; border-radius: 20px; padding: 50px 30px 40px; text-align: center; height: 100%; position: relative; box-shadow: 0 5px 25px rgba(0,0,0,0.05); transition: all 0.3s ease;">
                    <div style="position: absolute; top: -18px; left: 50%; transform: translateX(-50%); background: linear-gradient(135deg, #ff7a5c 0%, #ff5733 100%); color: white; width: 36px; height: 36px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 14px; box-shadow: 0 4px 15px rgba(255,122,92,0.4);">3</div>
                    <div style="width: 70px; height: 70px; margin: 0 auto 20px; background: linear-gradient(135deg, #fff5f0 0%, #ffe8e0 100%); border-radius: 15px; display: flex; align-items: center; justify-content: center;">
                        <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="#ff7a5c" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="M9 12l2 2 4-4"/></svg>
                    </div>
                    <h4 style="font-weight: 600; margin-bottom: 12px; color: #333;">Enjoy!</h4>
                    <p style="color: #777; font-size: 0.95rem; line-height: 1.6;">We'll deliver fresh to your door or you can pick up</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Extra Info: Meet The Chefs -->
<div class="section bg-white" data-aos="fade-up">
    <div class="container">
        <div class="row mb-5">
            <div class="col-md-12 section-heading text-center">
                <h2 class="heading mb-5">Meet The Chefs</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 pr-md-5 text-center mb-5">
                <div class="ftco-38">
                    <div class="ftco-38-img">
                        <div class="ftco-38-header">
                            <img src="{{ asset('images/chef_1.jpg') }}" alt="Chef">
                            <h3 class="ftco-38-heading">Daniel Graham</h3>
                            <p class="ftco-38-subheading">Master Chef</p>
                        </div>
                        <div class="ftco-38-body">
                            <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 pl-md-5 text-center mb-5">
                <div class="ftco-38">
                    <div class="ftco-38-img">
                        <div class="ftco-38-header">
                            <img src="{{ asset('images/chef_2.jpg') }}" alt="Chef">
                            <h3 class="ftco-38-heading">Nick Browning</h3>
                            <p class="ftco-38-subheading">Master Chef</p>
                        </div>
                        <div class="ftco-38-body">
                            <p>Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean. It is a paradisematic country.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Extra Info: Services Section -->
<div class="section bg-white services-section" data-aos="fade-up">
    <div class="container">
        <div class="row section-heading justify-content-center mb-5">
            <div class="col-md-8 text-center">
                <h2 class="heading mb-3">Other Services</h2>
                <p class="sub-heading mb-5">What makes us special</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-lg-4 mb-5" data-aos="fade-up">
                <div class="media feature-icon d-block text-center">
                    <div class="icon">
                        <span class="flaticon-soup"></span>
                    </div>
                    <div class="media-body">
                        <h3>Quality Cuisine</h3>
                        <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 mb-5" data-aos="fade-up" data-aos-delay="100">
                <div class="media feature-icon d-block text-center">
                    <div class="icon">
                        <span class="flaticon-vegetables"></span>
                    </div>
                    <div class="media-body">
                        <h3>Fresh Food</h3>
                        <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 mb-5" data-aos="fade-up" data-aos-delay="200">
                <div class="media feature-icon d-block text-center">
                    <div class="icon">
                        <span class="flaticon-pancake"></span>
                    </div>
                    <div class="media-body">
                        <h3>Bread & Pancake</h3>
                        <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Stats Section -->
<div style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%); padding: 60px 0;" data-aos="fade-up">
    <div class="container">
        <div class="row text-center justify-content-center">
            <div class="col-6 col-md-3 mb-4 mb-md-0">
                <h2 style="font-size: 3rem; font-weight: 700; color: #ff7a5c; margin-bottom: 5px;">500+</h2>
                <p style="font-size: 14px; color: rgba(255,255,255,0.7); margin: 0;">Happy Customers</p>
            </div>
            <div class="col-6 col-md-3 mb-4 mb-md-0">
                <h2 style="font-size: 3rem; font-weight: 700; color: #ff7a5c; margin-bottom: 5px;">50+</h2>
                <p style="font-size: 14px; color: rgba(255,255,255,0.7); margin: 0;">Menu Items</p>
            </div>
            <div class="col-6 col-md-3">
                <h2 style="font-size: 3rem; font-weight: 700; color: #ff7a5c; margin-bottom: 5px;">4.9⭐</h2>
                <p style="font-size: 14px; color: rgba(255,255,255,0.7); margin: 0;">Customer Rating</p>
            </div>
            <div class="col-6 col-md-3">
                <h2 style="font-size: 3rem; font-weight: 700; color: #ff7a5c; margin-bottom: 5px;">30min</h2>
                <p style="font-size: 14px; color: rgba(255,255,255,0.7); margin: 0;">Avg Delivery Time</p>
            </div>
        </div>
    </div>
</div>

<!-- Contact Section -->
<div class="section" data-aos="fade-up" id="section-contact">
    <div class="container">
        <div class="row section-heading justify-content-center mb-5">
            <div class="col-md-8 text-center">
                <h2 class="heading mb-3">Get In Touch</h2>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-10 p-5 form-wrap">
                <form action="{{ route('contact.submit') }}" method="POST">
                    @csrf
                    <div class="row mb-4">
                        <div class="form-group col-md-4">
                            <label for="contact_name" class="label">Name</label>
                            <div class="form-field-icon-wrap">
                                <span class="icon ion-android-person"></span>
                                <input type="text" name="name" class="form-control" id="contact_name" required>
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="contact_email" class="label">Email</label>
                            <div class="form-field-icon-wrap">
                                <span class="icon ion-email"></span>
                                <input type="email" name="email" class="form-control" id="contact_email" required>
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="contact_phone" class="label">Phone</label>
                            <div class="form-field-icon-wrap">
                                <span class="icon ion-android-call"></span>
                                <input type="text" name="phone" class="form-control" id="contact_phone">
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="contact_message" class="label">Message</label>
                            <textarea name="message" id="contact_message" cols="30" rows="10" class="form-control" required></textarea>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-4">
                            <input type="submit" class="btn btn-primary btn-outline-primary btn-block" value="Send Message">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
