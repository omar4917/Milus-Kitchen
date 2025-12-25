<!doctype html>
<html lang="en">
<head>
    <title>@yield('title', 'Meal Restaurant') | Fine Dining</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Meal Restaurant - Where food speaks with your palate" />

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body, h1, h2, h3, h4, h5, h6, p, a, span, div { font-family: 'Inter', 'Poppins', sans-serif !important; }
        .heading { font-family: 'Poppins', sans-serif !important; font-weight: 600 !important; }
    </style>

    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('css/aos.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap-datepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('css/jquery.timepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('fonts/ionicons/css/ionicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('fonts/fontawesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('fonts/flaticon/font/flaticon.css') }}">
    <!-- Theme Style -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
    @stack('styles')
</head>
<body class="bg-light" data-spy="scroll" data-target="#ftco-navbar-spy" data-offset="0">

<div class="site-wrap">
    
    <style>
        .site-menu {
            width: 300px;
            position: fixed;
            right: 0;
            z-index: 2000;
            padding-top: 50px;
            padding-bottom: 50px;
            height: 100vh;
            overflow-y: auto;
            background: #fff;
            box-shadow: -10px 0 30px -10px rgba(0,0,0,0.1);
            transition: 0.3s all ease;
            transform: translateX(100%);
        }
        .site-menu.active { transform: translateX(0); }
        .site-menu .site-menu-header {
            padding: 0 40px 30px 40px;
            border-bottom: 1px solid #f2f2f2;
            margin-bottom: 30px;
            text-align: center;
        }
        .site-menu .brand-logo {
            font-size: 30px;
            font-weight: 900;
            color: #000;
            text-decoration: none;
            letter-spacing: -1px;
            font-family: 'Poppins', sans-serif;
        }
        .site-menu .brand-logo .dot { color: #ff7a5c; }
        
        .site-menu ul { padding: 0 40px; margin: 0; }
        .site-menu ul li { display: block; margin-bottom: 15px; }
        .site-menu ul li a {
            display: flex;
            align-items: center;
            font-size: 16px;
            color: #555;
            text-decoration: none;
            transition: 0.3s all ease;
            padding: 10px 0;
            font-weight: 500;
        }
        .site-menu ul li a .icon {
            font-size: 20px;
            margin-right: 15px;
            color: #ccc;
            transition: 0.3s all ease;
            width: 25px;
            text-align: center;
        }
        .site-menu ul li a:hover, .site-menu ul li.active a { color: #ff7a5c; }
        .site-menu ul li a:hover .icon, .site-menu ul li.active a .icon { color: #ff7a5c; }
        
        .site-menu .divider { height: 1px; background: #eee; margin: 20px 0; }
        
        .site-menu .menu-social { margin-top: 30px; padding-top: 30px; border-top: 1px solid #f2f2f2; display: flex; justify-content: center; gap: 15px; }
        .site-menu .menu-social a {
            width: 40px; height: 40px; border-radius: 50%; background: #f8f9fa; color: #333;
            display: flex; align-items: center; justify-content: center; text-decoration: none; transition: 0.3s;
        }
        .site-menu .menu-social a:hover { background: #ff7a5c; color: white; }
    </style>

    <nav class="site-menu" id="ftco-navbar-spy">
        <div class="site-menu-inner" id="ftco-navbar">
            <div class="site-menu-header">
                <a href="{{ route('home') }}" class="brand-logo">Meal<span class="dot">.</span></a>
            </div>
            <ul class="list-unstyled">
                <li class="{{ request()->routeIs('home') ? 'active' : '' }}">
                    <a href="{{ route('home') }}"><span class="icon ion-android-home"></span>Home</a>
                </li>
                <li class="{{ request()->routeIs('about') ? 'active' : '' }}">
                    <a href="{{ route('about') }}"><span class="icon ion-ios-information-outline"></span>About Us</a>
                </li>
                <li class="{{ request()->routeIs('menu') ? 'active' : '' }}">
                    <a href="{{ route('menu') }}"><span class="icon ion-android-restaurant"></span>Our Menu</a>
                </li>
                <li class="{{ request()->routeIs('cart') ? 'active' : '' }}">
                    <a href="{{ route('cart') }}">
                        <span class="icon ion-android-cart"></span>Cart 
                        <span class="badge badge-primary ml-auto" style="background:#ff7a5c;">{{ app(\App\Services\CartService::class)->getCount() }}</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs('contact') ? 'active' : '' }}">
                    <a href="{{ route('contact') }}"><span class="icon ion-android-mail"></span>Contact</a>
                </li>
                
                <li class="divider"></li>
                
                @auth
                    @if(auth()->user()->isAdmin() || auth()->user()->isStaff())
                        <li><a href="{{ route('admin.dashboard') }}"><span class="icon ion-android-options"></span>Admin Panel</a></li>
                    @else
                        <li><a href="{{ route('user.dashboard') }}"><span class="icon ion-android-person"></span>My Account</a></li>
                    @endif
                    <li>
                        <form action="{{ route('logout') }}" method="POST" class="d-flex w-100">
                            @csrf
                            <button type="submit" style="background: none; border: none; padding: 0; display: flex; align-items: center; color: #555; width: 100%; cursor: pointer; font-weight: 500;">
                                <span class="icon ion-log-out" style="font-size: 20px; margin-right: 15px; color: #ccc; width: 25px; text-align: center;"></span>
                                Logout
                            </button>
                        </form>
                    </li>
                @else
                    <li><a href="{{ route('login') }}"><span class="icon ion-log-in"></span>Login</a></li>
                    <li><a href="{{ route('register') }}"><span class="icon ion-person-add"></span>Register</a></li>
                @endauth
            </ul>

            <div class="menu-social">
                <a href="#"><span class="fa fa-facebook"></span></a>
                <a href="#"><span class="fa fa-twitter"></span></a>
                <a href="#"><span class="fa fa-instagram"></span></a>
            </div>
        </div>
    </nav>

    <header class="site-header">
        <div class="row align-items-center">
            <div class="col-5 col-md-3"></div>
            <div class="col-2 col-md-6 text-center site-logo-wrap">
                <a href="{{ route('home') }}" class="site-logo">M</a>
            </div>
            <div class="col-5 col-md-3 text-right menu-burger-wrap">
                <a href="#" class="site-nav-toggle js-site-nav-toggle"><i></i></a>
            </div>
        </div>
    </header>

    <!-- Toast Notifications -->
    @if(session('success') || session('cart_added'))
        <div class="toast-notification toast-success" id="toastNotification">
            <span class="toast-icon">✓</span>
            <span class="toast-message">{{ session('success') ?: session('cart_added') . ' added to cart' }}</span>
            <a href="{{ route('cart') }}" class="toast-link">View Cart →</a>
            <button class="toast-close" onclick="this.parentElement.remove()">×</button>
        </div>
    @endif
    @if(session('error'))
        <div class="toast-notification toast-error" id="toastNotification">
            <span class="toast-icon">!</span>
            <span class="toast-message">{{ session('error') }}</span>
            <button class="toast-close" onclick="this.parentElement.remove()">×</button>
        </div>
    @endif
    
    <style>
        .toast-notification {
            position: fixed;
            bottom: 30px;
            right: 30px;
            padding: 15px 20px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 12px;
            z-index: 10000;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            animation: slideInRight 0.4s ease;
            max-width: 400px;
            font-family: 'Inter', sans-serif;
        }
        .toast-success {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
        }
        .toast-error {
            background: linear-gradient(135deg, #dc3545 0%, #ff6b6b 100%);
            color: white;
        }
        .toast-icon {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: rgba(255,255,255,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 14px;
            flex-shrink: 0;
        }
        .toast-message { flex: 1; font-size: 14px; font-weight: 500; }
        .toast-link { color: white; text-decoration: underline; font-weight: 600; white-space: nowrap; }
        .toast-link:hover { color: #fff; }
        .toast-close {
            background: rgba(255,255,255,0.2);
            border: none;
            color: white;
            font-size: 18px;
            cursor: pointer;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            line-height: 1;
            flex-shrink: 0;
        }
        .toast-close:hover { background: rgba(255,255,255,0.3); }
        @keyframes slideInRight {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
    </style>

    <div class="main-wrap">
        @yield('content')
    </div>

    <div class="section-newsletter" style="padding: 60px 0; background: #ff7a5c; color: white;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 mb-4 mb-md-0">
                    <h2 class="heading mb-2" style="color: white; font-weight: bold;">Subscribe to our Newsletter</h2>
                    <p class="mb-0" style="color: rgba(255,255,255,0.9);">Get the latest updates, special offers, and culinary tips.</p>
                </div>
                <div class="col-md-6">
                    <form action="#" class="newsletter-form" onsubmit="event.preventDefault(); alert('Subscribed successfully! (Demo)');">
                        <div class="d-flex position-relative">
                            <input type="email" class="form-control" placeholder="Enter your email" style="height: 50px; border-radius: 30px; border: none; padding-right: 120px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                            <button type="submit" class="btn" style="position: absolute; right: 5px; top: 5px; height: 40px; border-radius: 25px; background: #333; color: white; border: none; padding: 0 25px; font-weight: 600;">Subscribe</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <footer class="ftco-footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-5">
                    <div class="footer-widget">
                        <h3 class="mb-4">About Meal</h3>
                        <p>Experience culinary excellence at Meal Restaurant. We serve delicious food made with the finest locally-sourced ingredients in Toronto.</p>
                        <p><a href="{{ route('menu') }}" class="btn btn-primary btn-outline-primary">View Menu</a></p>
                    </div>
                </div>
                <div class="col-md-4 mb-5">
                    <div class="footer-widget">
                        <h3 class="mb-4">Hours of Operation</h3>
                        <p><strong>Lunch:</strong> 11:30 AM &mdash; 2:30 PM</p>
                        <p><strong>Dinner:</strong> 5:00 PM &mdash; 10:00 PM</p>
                        <p><strong>Weekend Brunch:</strong> 10:00 AM &mdash; 3:00 PM</p>
                    </div>
                </div>
                <div class="col-md-4 mb-5">
                    <div class="footer-widget">
                        <h3 class="mb-4">Contact Us</h3>
                        <p>📍 123 Queen Street West<br>Toronto, ON M5H 2M9</p>
                        <p>📞 (416) 555-MEAL</p>
                        <p>✉️ info@meal-restaurant.ca</p>
                        <ul class="list-unstyled social" style="margin-top: 15px;">
                            <li><a href="#"><span class="fa fa-facebook"></span></a></li>
                            <li><a href="#"><span class="fa fa-twitter"></span></a></li>
                            <li><a href="#"><span class="fa fa-instagram"></span></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row pt-5">
                <div class="col-md-12 text-center">
                    <p>&copy; {{ date('Y') }} Meal Restaurant, Toronto. All rights reserved. 🍁</p>
                </div>
            </div>
        </div>
    </footer>

</div>

<!-- loader -->
<div id="loader" class="show fullscreen"><svg class="circular" width="48px" height="48px"><circle class="path-bg" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke="#eeeeee"/><circle class="path" cx="24" cy="24" r="22" fill="none" stroke-width="4" stroke-miterlimit="10" stroke="#ff7a5c"/></svg></div>

<!-- Floating Cart Button -->
<button type="button" class="floating-cart-btn" id="openCartSidebar">
    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
    <span class="cart-badge" id="cartBadgeCount">{{ app(\App\Services\CartService::class)->getCount() }}</span>
    <span class="cart-label">CART</span>
</button>

<!-- Cart Sidebar Overlay -->
<div class="cart-sidebar-overlay" id="cartSidebarOverlay"></div>

<!-- Cart Sidebar -->
<div class="cart-sidebar" id="cartSidebar">
    <div class="cart-sidebar-header">
        <h3><span class="icon ion-android-cart"></span> Your Cart</h3>
        <button class="cart-sidebar-close" id="closeCartSidebar">&times;</button>
    </div>
    
    <div class="cart-sidebar-content">
        @php $cart = app(\App\Services\CartService::class)->getCartDetails(); @endphp
        
        @if(count($cart['items']) > 0)
            <div class="cart-sidebar-items">
                @foreach($cart['items'] as $item)
                    <div class="cart-sidebar-item">
                        <div class="item-image">
                            @php $itemImage = $item['image'] ?? $item['photo_path'] ?? null; @endphp
                            @if($itemImage)
                                <img src="{{ asset('storage/' . $itemImage) }}" alt="{{ $item['name'] }}">
                            @else
                                <img src="{{ asset('images/img_1.jpg') }}" alt="{{ $item['name'] }}">
                            @endif
                        </div>
                        <div class="item-details">
                            <h4>{{ $item['name'] }}</h4>
                            <p class="item-price">${{ number_format($item['price'], 0) }} × {{ $item['quantity'] }}</p>
                        </div>
                        <div class="item-total">${{ number_format($item['price'] * $item['quantity'], 0) }}</div>
                    </div>
                @endforeach
            </div>
            
            <div class="cart-sidebar-summary">
                <div class="summary-row">
                    <span>Subtotal ({{ $cart['count'] }} items)</span>
                    <strong>${{ number_format($cart['subtotal'], 0) }}</strong>
                </div>
                <div class="summary-row delivery">
                    <span>Delivery Fee</span>
                    <span class="text-muted">Calculated at checkout</span>
                </div>
            </div>
            
            <div class="cart-sidebar-actions">
                <a href="{{ route('cart') }}" class="btn-sidebar btn-view-full-cart">View Full Cart</a>
                <a href="{{ route('checkout') }}" class="btn-sidebar btn-sidebar-checkout">Proceed to Checkout</a>
            </div>
        @else
            <div class="cart-sidebar-empty">
                <div class="empty-icon">🛒</div>
                <h4>Your cart is empty</h4>
                <p>Add some delicious items to get started!</p>
                <a href="{{ route('menu') }}" class="btn-sidebar btn-browse-menu">Browse Menu</a>
            </div>
        @endif
    </div>
</div>

<style>
.floating-cart-btn {
    position: fixed;
    bottom: 30px;
    right: 30px;
    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
    color: white;
    padding: 15px 20px;
    border-radius: 12px;
    cursor: pointer;
    z-index: 1000;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 5px;
    box-shadow: 0 8px 30px rgba(0,0,0,0.3);
    transition: all 0.3s ease;
    text-decoration: none;
    border: none;
}
.floating-cart-btn:hover { transform: translateY(-3px); box-shadow: 0 12px 40px rgba(0,0,0,0.4); color: white; text-decoration: none; }
.cart-badge {
    position: absolute;
    top: -8px;
    right: -8px;
    background: #ff5733;
    color: white;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 12px;
    font-weight: bold;
}
.cart-label { font-size: 11px; font-weight: 600; letter-spacing: 1px; }

/* Centered Modal Popup */
.cart-modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.5);
    z-index: 10000;
    display: flex;
    align-items: center;
    justify-content: center;
    animation: fadeIn 0.3s ease;
}
.cart-modal {
    background: white;
    border-radius: 16px;
    padding: 25px 30px;
    max-width: 480px;
    width: 90%;
    position: relative;
    animation: slideUp 0.3s ease;
    box-shadow: 0 20px 60px rgba(0,0,0,0.3);
}
.cart-modal-close {
    position: absolute;
    top: 15px;
    right: 15px;
    background: #f0f0f0;
    border: none;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    font-size: 18px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
}
.cart-modal-close:hover { background: #e0e0e0; }
.cart-modal-content {
    display: flex;
    align-items: flex-start;
    gap: 15px;
    margin-bottom: 20px;
}
.cart-modal-icon {
    width: 40px;
    height: 40px;
    background: #28a745;
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    flex-shrink: 0;
}
.cart-modal-text { flex: 1; }
.cart-modal-text p { margin: 0; font-size: 16px; color: #333; }
.cart-modal-text .item-name { color: #ff7a5c; font-weight: 600; }
.cart-modal-info {
    display: flex;
    gap: 20px;
    margin-top: 10px;
    padding: 10px 15px;
    background: #f8f9fa;
    border-radius: 8px;
    font-size: 14px;
}
.cart-modal-info span { color: #666; }
.cart-modal-info strong { color: #333; }
.cart-modal-actions {
    display: flex;
    gap: 12px;
}
.btn-modal {
    flex: 1;
    padding: 12px 20px;
    border-radius: 8px;
    text-align: center;
    text-decoration: none;
    font-weight: 600;
    font-size: 14px;
    transition: all 0.2s ease;
    border: none;
    cursor: pointer;
}
.btn-view-cart { background: #4466ff; color: white; }
.btn-view-cart:hover { background: #3355ee; color: white; }
.btn-checkout { background: white; color: #333; border: 2px solid #ddd; }
.btn-checkout:hover { border-color: #ff7a5c; color: #ff7a5c; }
@keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
@keyframes slideUp { from { transform: translateY(20px); opacity: 0; } to { transform: translateY(0); opacity: 1; } }

/* Cart Sidebar Styles */
.cart-sidebar-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.5);
    z-index: 9998;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
}
.cart-sidebar-overlay.active {
    opacity: 1;
    visibility: visible;
}
.cart-sidebar {
    position: fixed;
    top: 0;
    right: 0;
    width: 420px;
    max-width: 100%;
    height: 100vh;
    background: white;
    z-index: 9999;
    transform: translateX(100%);
    transition: transform 0.3s ease;
    display: flex;
    flex-direction: column;
    box-shadow: -10px 0 40px rgba(0,0,0,0.15);
}
.cart-sidebar.active {
    transform: translateX(0);
}
.cart-sidebar-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 20px 25px;
    border-bottom: 1px solid #eee;
    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
    color: white;
}
.cart-sidebar-header h3 {
    margin: 0;
    font-size: 20px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 10px;
}
.cart-sidebar-header .icon { font-size: 22px; }
.cart-sidebar-close {
    background: rgba(255,255,255,0.15);
    border: none;
    color: white;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    font-size: 24px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
}
.cart-sidebar-close:hover { background: rgba(255,255,255,0.25); }
.cart-sidebar-content {
    flex: 1;
    overflow-y: auto;
    padding: 20px;
    display: flex;
    flex-direction: column;
}
.cart-sidebar-items {
    flex: 1;
}
.cart-sidebar-item {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 15px;
    background: #f8f9fa;
    border-radius: 12px;
    margin-bottom: 12px;
    transition: all 0.2s ease;
}
.cart-sidebar-item:hover { background: #f0f0f0; }
.cart-sidebar-item .item-image {
    width: 60px;
    height: 60px;
    border-radius: 10px;
    overflow: hidden;
    flex-shrink: 0;
}
.cart-sidebar-item .item-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.cart-sidebar-item .item-image .no-image {
    width: 100%;
    height: 100%;
    background: #e0e0e0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
}
.cart-sidebar-item .item-details {
    flex: 1;
    min-width: 0;
}
.cart-sidebar-item .item-details h4 {
    margin: 0 0 5px 0;
    font-size: 15px;
    font-weight: 600;
    color: #333;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.cart-sidebar-item .item-price {
    margin: 0;
    font-size: 13px;
    color: #888;
}
.cart-sidebar-item .item-total {
    font-size: 16px;
    font-weight: 700;
    color: #ff7a5c;
    white-space: nowrap;
}
.cart-sidebar-summary {
    padding: 20px 0;
    border-top: 1px solid #eee;
    margin-top: auto;
}
.cart-sidebar-summary .summary-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
}
.cart-sidebar-summary .summary-row span { color: #666; font-size: 14px; }
.cart-sidebar-summary .summary-row strong { color: #ff7a5c; font-size: 18px; }
.cart-sidebar-summary .delivery span { font-size: 13px; }
.cart-sidebar-actions {
    display: flex;
    flex-direction: column;
    gap: 10px;
}
.btn-sidebar {
    display: block;
    padding: 14px 20px;
    border-radius: 10px;
    text-align: center;
    text-decoration: none;
    font-weight: 600;
    font-size: 15px;
    transition: all 0.2s ease;
    border: none;
    cursor: pointer;
}
.btn-view-full-cart {
    background: white;
    color: #333;
    border: 2px solid #ddd;
}
.btn-view-full-cart:hover { border-color: #ff7a5c; color: #ff7a5c; text-decoration: none; }
.btn-sidebar-checkout {
    background: linear-gradient(135deg, #ff7a5c 0%, #ff6b4a 100%);
    color: white;
}
.btn-sidebar-checkout:hover { background: linear-gradient(135deg, #ff6b4a 0%, #e55a3c 100%); color: white; text-decoration: none; }
.btn-browse-menu {
    background: linear-gradient(135deg, #ff7a5c 0%, #ff6b4a 100%);
    color: white;
}
.btn-browse-menu:hover { background: linear-gradient(135deg, #ff6b4a 0%, #e55a3c 100%); color: white; text-decoration: none; }
.cart-sidebar-empty {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    text-align: center;
    padding: 40px 20px;
}
.cart-sidebar-empty .empty-icon { font-size: 64px; margin-bottom: 20px; opacity: 0.5; }
.cart-sidebar-empty h4 { margin: 0 0 10px 0; color: #333; font-weight: 600; }
.cart-sidebar-empty p { margin: 0 0 25px 0; color: #888; font-size: 14px; }
@media (max-width: 480px) {
    .cart-sidebar { width: 100%; }
}
</style>

<script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
<script src="{{ asset('js/jquery-migrate-3.0.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('js/jquery.waypoints.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('js/jquery.timepicker.min.js') }}"></script>
<script src="{{ asset('js/jquery.stellar.min.js') }}"></script>
<script src="{{ asset('js/jquery.easing.1.3.js') }}"></script>
<script src="{{ asset('js/aos.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>

<!-- AJAX Add to Cart -->
<script>
$(document).ready(function() {
    // Cart Sidebar Controls
    $('#openCartSidebar').on('click', function() {
        $('#cartSidebar').addClass('active');
        $('#cartSidebarOverlay').addClass('active');
        $('body').css('overflow', 'hidden');
    });
    
    $('#closeCartSidebar, #cartSidebarOverlay').on('click', function() {
        $('#cartSidebar').removeClass('active');
        $('#cartSidebarOverlay').removeClass('active');
        $('body').css('overflow', '');
    });
    
    // Close sidebar on Escape key
    $(document).on('keydown', function(e) {
        if (e.key === 'Escape' && $('#cartSidebar').hasClass('active')) {
            $('#cartSidebar').removeClass('active');
            $('#cartSidebarOverlay').removeClass('active');
            $('body').css('overflow', '');
        }
    });

    // Handle all add-to-cart forms via AJAX
    $(document).on('submit', 'form[action*="cart/add"]', function(e) {
        e.preventDefault();
        var form = $(this);
        var btn = form.find('button[type="submit"]');
        var originalText = btn.html();
        
        btn.html('Adding...').prop('disabled', true);
        
        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: form.serialize(),
            headers: { 'X-Requested-With': 'XMLHttpRequest' },
            success: function(response) {
                // Update cart badge
                if (response.cart && response.cart.count !== undefined) {
                    $('#cartBadgeCount').text(response.cart.count);
                }
                
                btn.html('✓');
                setTimeout(function() { btn.html(originalText).prop('disabled', false); }, 1000);
            },
            error: function(xhr) {
                btn.html(originalText).prop('disabled', false);
                alert('Error adding to cart');
            }
        });
    });
    
    function showCartModal(itemName, cart) {
        // Remove existing modal
        $('.cart-modal-overlay').remove();
        
        var modal = $('<div class="cart-modal-overlay" onclick="if(event.target===this)$(this).remove()">' +
            '<div class="cart-modal">' +
                '<button class="cart-modal-close" onclick="$(this).closest(\'.cart-modal-overlay\').remove()">×</button>' +
                '<div class="cart-modal-content">' +
                    '<div class="cart-modal-icon">✓</div>' +
                    '<div class="cart-modal-text">' +
                        '<p>You have added <span class="item-name">' + itemName + '</span> to your shopping cart!</p>' +
                        '<div class="cart-modal-info">' +
                            '<div><span>Cart quantity:</span> <strong>' + cart.count + '</strong></div>' +
                            '<div><span>Cart Total:</span> <strong>$' + Math.round(cart.subtotal) + '</strong></div>' +
                        '</div>' +
                    '</div>' +
                '</div>' +
                '<div class="cart-modal-actions">' +
                    '<a href="{{ route("cart") }}" class="btn-modal btn-view-cart">View Cart</a>' +
                    '<a href="{{ route("checkout") }}" class="btn-modal btn-checkout">Confirm Order</a>' +
                '</div>' +
            '</div>' +
        '</div>');
        
        $('body').append(modal);
    }
    
    // Auto-hide server-rendered toast notification
    var existingToast = document.getElementById('toastNotification');
    if (existingToast) {
        setTimeout(function() {
            existingToast.style.opacity = '0';
            existingToast.style.transform = 'translateX(100%)';
            setTimeout(function() { existingToast.remove(); }, 300);
        }, 4000);
    }
});
</script>

@stack('scripts')
@include('public.partials.item_modal')
</body>
</html>

