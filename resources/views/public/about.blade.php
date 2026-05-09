@extends('layouts.app')

@section('title', 'About Us')

@section('content')
<div class="cover_1 overlay bg-slant-white bg-light">
    <div class="img_bg" style="background-image: url({{ asset('images/slider-1.jpg') }}); min-height: 300px;" data-stellar-background-ratio="0.5">
        <div class="container">
            <div class="row align-items-center justify-content-center text-center" style="padding-top: 100px;">
                <div class="col-md-10" data-aos="fade-up">
                    <h2 class="heading mb-3">About Us</h2>
                    <p class="sub-heading">Learn more about our story</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="section pb-3 bg-white" data-aos="fade-up">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-md-12 col-lg-8 section-heading">
                <h2 class="heading mb-5">The Restaurant</h2>
                <p>Welcome to Lilus Kitchen, where culinary excellence meets warm hospitality. For over three decades, we have been serving our community with the finest dishes prepared by our talented chefs.</p>
                <p>Our restaurant was founded with a simple mission: to provide exceptional food in a welcoming environment. We source only the freshest ingredients and combine traditional recipes with modern culinary techniques.</p>
                <p>Every dish that leaves our kitchen is crafted with passion and attention to detail. We believe that great food brings people together, and we're honored to be a part of your special moments.</p>
            </div>
        </div>
    </div>
</div>

<div class="section bg-white pt-2 pb-2 text-center" data-aos="fade">
    <p><img src="{{ asset('images/bg_hero.png') }}" alt="Lilus Kitchen" class="img-fluid"></p>
</div>

<div class="section bg-white" data-aos="fade-up">
    <div class="container">
        <div class="row mb-5">
            <div class="col-md-12 section-heading text-center">
                <h2 class="heading mb-5">Why Choose Us</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 text-center mb-5">
                <div style="font-size: 48px;">🍽️</div>
                <h3>Quality Ingredients</h3>
                <p>We use only the freshest, locally-sourced ingredients in all our dishes.</p>
            </div>
            <div class="col-md-4 text-center mb-5">
                <div style="font-size: 48px;">👨‍🍳</div>
                <h3>Expert Chefs</h3>
                <p>Our team of experienced chefs brings creativity and passion to every plate.</p>
            </div>
            <div class="col-md-4 text-center mb-5">
                <div style="font-size: 48px;">❤️</div>
                <h3>Made with Love</h3>
                <p>Every dish is prepared with care and attention to detail.</p>
            </div>
        </div>
    </div>
</div>
@endsection
