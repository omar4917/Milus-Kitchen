@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="cover_1 overlay bg-slant-white bg-light" id="section-home">
    <div class="img_bg" style="background-image: url({{ asset('images/slider-1.jpg') }});" data-stellar-background-ratio="0.5">
        <div class="container">
            <div class="row align-items-center justify-content-center text-center">
                <div class="col-md-10" data-aos="fade-up">
                    <h2 class="heading mb-5">Welcome to Lilus Kitchen, where food speaks with your palate</h2>
                    <p class="sub-heading mb-5">Experience the finest dining with our exquisite menu</p>
                    <p><a href="{{ route('menu') }}" class="btn btn-outline-white px-5 py-3">View Our Menu</a></p>
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
            
            <div class="ftco-46">
                <!-- First Row: Image | Text | Image -->
                <div class="ftco-46-row d-flex flex-column flex-lg-row">
                    <div class="ftco-46-image" style="background-image: url({{ isset($featuredItems[0]) && $featuredItems[0]->image ? asset('storage/' . $featuredItems[0]->image) : asset('images/img_1.jpg') }});"></div>
                    <div class="ftco-46-text ftco-46-arrow-left">
                        @if(isset($featuredItems[0]))
                        <h4 class="ftco-46-subheading">{{ $featuredItems[0]->category ? $featuredItems[0]->category->name : 'Food' }}</h4>
                        <h3 class="ftco-46-heading">{{ $featuredItems[0]->name }}</h3>
                        <p class="mb-5">{{ Str::limit($featuredItems[0]->description, 120) }}</p>
                        <p><strong style="color: #ff7a5c; font-size: 1.2rem;">${{ number_format($featuredItems[0]->price, 2) }}</strong></p>
                        <form action="{{ route('cart.add') }}" method="POST" class="ajax-add-cart">
                            @csrf
                            <input type="hidden" name="menu_item_id" value="{{ $featuredItems[0]->id }}">
                            <button type="submit" class="btn-link" style="border: none; background: none; cursor: pointer; text-transform: uppercase; letter-spacing: 2px;">Add to Cart <span class="ion-android-arrow-forward"></span></button>
                        </form>
                        @else
                        <h4 class="ftco-46-subheading">Vegies</h4>
                        <h3 class="ftco-46-heading">Beef Empanadas</h3>
                        <p class="mb-5">Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean.</p>
                        <p><a href="{{ route('menu') }}" class="btn-link">Learn More <span class="ion-android-arrow-forward"></span></a></p>
                        @endif
                    </div>
                    <div class="ftco-46-image" style="background-image: url({{ isset($featuredItems[1]) && $featuredItems[1]->image ? asset('storage/' . $featuredItems[1]->image) : asset('images/img_2.jpg') }});"></div>
                </div>

                <!-- Second Row: Text | Image | Text -->
                <div class="ftco-46-row d-flex flex-column flex-lg-row">
                    <div class="ftco-46-text ftco-46-arrow-right">
                        @if(isset($featuredItems[2]))
                        <h4 class="ftco-46-subheading">{{ $featuredItems[2]->category ? $featuredItems[2]->category->name : 'Food' }}</h4>
                        <h3 class="ftco-46-heading">{{ $featuredItems[2]->name }}</h3>
                        <p class="mb-5">{{ Str::limit($featuredItems[2]->description, 100) }}</p>
                        <p><strong style="color: #ff7a5c; font-size: 1.2rem;">${{ number_format($featuredItems[2]->price, 2) }}</strong></p>
                        <form action="{{ route('cart.add') }}" method="POST" class="ajax-add-cart">
                            @csrf
                            <input type="hidden" name="menu_item_id" value="{{ $featuredItems[2]->id }}">
                            <button type="submit" class="btn-link" style="border: none; background: none; cursor: pointer; text-transform: uppercase; letter-spacing: 2px;">Add to Cart <span class="ion-android-arrow-forward"></span></button>
                        </form>
                        @else
                        <h4 class="ftco-46-subheading">Food</h4>
                        <h3 class="ftco-46-heading">Buttermilk Chicken Jibaritos</h3>
                        <p class="mb-5">A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
                        <p><a href="{{ route('menu') }}" class="btn-link">Learn More <span class="ion-android-arrow-forward"></span></a></p>
                        @endif
                    </div>
                    <div class="ftco-46-image" style="background-image: url({{ isset($featuredItems[3]) && $featuredItems[3]->image ? asset('storage/' . $featuredItems[3]->image) : asset('images/img_3.jpg') }});"></div>
                    <div class="ftco-46-text ftco-46-arrow-up">
                        @if(isset($featuredItems[3]))
                        <h4 class="ftco-46-subheading">{{ $featuredItems[3]->category ? $featuredItems[3]->category->name : 'Food' }}</h4>
                        <h3 class="ftco-46-heading">{{ $featuredItems[3]->name }}</h3>
                        <p class="mb-5">{{ Str::limit($featuredItems[3]->description, 100) }}</p>
                        <p><strong style="color: #ff7a5c; font-size: 1.2rem;">${{ number_format($featuredItems[3]->price, 2) }}</strong></p>
                        <form action="{{ route('cart.add') }}" method="POST" class="ajax-add-cart">
                            @csrf
                            <input type="hidden" name="menu_item_id" value="{{ $featuredItems[3]->id }}">
                            <button type="submit" class="btn-link" style="border: none; background: none; cursor: pointer; text-transform: uppercase; letter-spacing: 2px;">Add to Cart <span class="ion-android-arrow-forward"></span></button>
                        </form>
                        @elseif(isset($featuredItems[1]))
                        <h4 class="ftco-46-subheading">{{ $featuredItems[1]->category ? $featuredItems[1]->category->name : 'Food' }}</h4>
                        <h3 class="ftco-46-heading">{{ $featuredItems[1]->name }}</h3>
                        <p class="mb-5">{{ Str::limit($featuredItems[1]->description, 100) }}</p>
                        <p><strong style="color: #ff7a5c; font-size: 1.2rem;">${{ number_format($featuredItems[1]->price, 2) }}</strong></p>
                        <form action="{{ route('cart.add') }}" method="POST" class="ajax-add-cart">
                            @csrf
                            <input type="hidden" name="menu_item_id" value="{{ $featuredItems[1]->id }}">
                            <button type="submit" class="btn-link" style="border: none; background: none; cursor: pointer; text-transform: uppercase; letter-spacing: 2px;">Add to Cart <span class="ion-android-arrow-forward"></span></button>
                        </form>
                        @else
                        <h4 class="ftco-46-subheading">Food</h4>
                        <h3 class="ftco-46-heading">Chicken Chimichurri Croquettes</h3>
                        <p class="mb-5">Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life.</p>
                        <p><a href="{{ route('menu') }}" class="btn-link">Learn More <span class="ion-android-arrow-forward"></span></a></p>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="section pb-3 bg-white" id="section-about" data-aos="fade-up">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-md-12 col-lg-8 section-heading">
                <h2 class="heading mb-5">The Restaurant</h2>
                <p>Welcome to Lilus Kitchen, where culinary excellence meets warm hospitality. Our chefs craft each dish with passion and the finest ingredients, creating memorable dining experiences.</p>
                <p>Experience the perfect blend of traditional recipes and modern culinary techniques in a sophisticated atmosphere.</p>
                <p><a href="{{ route('about') }}" class="btn btn-primary">Learn More About Us</a></p>
            </div>
        </div>
    </div>
</div>

<div class="section bg-white pt-2 pb-2 text-center" data-aos="fade">
    <p><img src="{{ asset('images/bg_hero.png') }}" alt="Lilus Kitchen" class="img-fluid"></p>
</div>

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
                            @foreach($category->menuItems as $item)
                            <div class="col-md-6 col-lg-3 mb-3">
                                <div class="menu-item-card h-100" style="background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 3px 12px rgba(0,0,0,0.06); transition: transform 0.3s ease;">
                                    <div style="height: 140px; overflow: hidden;">
                                        @if($item->image)
                                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                        @else
                                        <img src="{{ asset('images/img_1.jpg') }}" alt="{{ $item->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                                        @endif
                                    </div>
                                    <div style="padding: 15px;">
                                        <h5 style="font-weight: 700; margin-bottom: 5px; color: #333; font-size: 0.95rem;">{{ $item->name }}</h5>
                                        <p style="color: #777; font-size: 0.8rem; margin-bottom: 10px; min-height: 32px; line-height: 1.4;">{{ Str::limit($item->description, 50) }}</p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span style="color: #ff7a5c; font-size: 1.05rem; font-weight: 700;">${{ number_format($item->price, 2) }}</span>
                                            <form action="{{ route('cart.add') }}" method="POST" class="ajax-add-cart">
                                                @csrf
                                                <input type="hidden" name="menu_item_id" value="{{ $item->id }}">
                                                <button type="submit" class="btn btn-sm btn-primary" style="border-radius: 50%; width: 30px; height: 30px; padding: 0; display: flex; align-items: center; justify-content: center; line-height: 1; font-size: 14px;">+</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <div class="text-center mt-4">
                    <a href="{{ route('menu') }}" class="btn btn-primary btn-outline-primary">View Full Menu</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="section bg-white" data-aos="fade-up">
    <div class="container">
        <div class="row mb-5">
            <div class="col-md-12 section-heading text-center">
                <h2 class="heading mb-5">Meet The Chefs</h2>
            </div>
        </div>
        @php
            $chefs = \App\Models\Chef::where('is_active', true)->orderBy('sort_order')->get();
        @endphp
        <div class="row">
            @forelse($chefs as $chef)
            <div class="col-md-6 {{ $loop->first ? 'pr-md-5' : 'pl-md-5' }} text-center mb-5">
                <div class="ftco-38">
                    <div class="ftco-38-img">
                        <div class="ftco-38-header">
                            @if($chef->photo_path)
                            <img src="{{ asset('storage/' . $chef->photo_path) }}" alt="{{ $chef->name }}">
                            @else
                            <img src="{{ asset('images/chef_1.jpg') }}" alt="{{ $chef->name }}">
                            @endif
                            <h3 class="ftco-38-heading">{{ $chef->name }}</h3>
                            <p class="ftco-38-subheading">{{ $chef->title }}</p>
                        </div>
                        <div class="ftco-38-body">
                            <p>{{ $chef->bio }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-md-6 pr-md-5 text-center mb-5">
                <div class="ftco-38">
                    <div class="ftco-38-img">
                        <div class="ftco-38-header">
                            <img src="{{ asset('images/chef_1.jpg') }}" alt="Chef">
                            <h3 class="ftco-38-heading">Our Chef</h3>
                            <p class="ftco-38-subheading">Master Chef</p>
                        </div>
                        <div class="ftco-38-body">
                            <p>Our talented chefs craft each dish with passion and the finest ingredients.</p>
                        </div>
                    </div>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</div>

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
            <div class="col-md-6 col-lg-4 mb-5" data-aos="fade-up" data-aos-delay="300">
                <div class="media feature-icon d-block text-center">
                    <div class="icon">
                        <span class="flaticon-tray"></span>
                    </div>
                    <div class="media-body">
                        <h3>Reserve Now</h3>
                        <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 mb-5" data-aos="fade-up" data-aos-delay="400">
                <div class="media feature-icon d-block text-center">
                    <div class="icon">
                        <span class="flaticon-salad"></span>
                    </div>
                    <div class="media-body">
                        <h3>Fresh Vegies Salad</h3>
                        <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-4 mb-5" data-aos="fade-up" data-aos-delay="500">
                <div class="media feature-icon d-block text-center">
                    <div class="icon">
                        <span class="flaticon-chicken"></span>
                    </div>
                    <div class="media-body">
                        <h3>Whole Chicken</h3>
                        <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



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
