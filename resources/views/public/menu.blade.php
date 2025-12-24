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
                <a href="{{ route('menu') }}" class="btn {{ !request('category') ? 'btn-primary' : 'btn-outline-primary' }} m-1 category-filter-btn">All</a>
                @foreach(\App\Models\Category::all() as $category)
                    <a href="{{ route('menu', ['category' => $category->id]) }}" 
                       class="btn {{ request('category') == $category->id ? 'btn-primary' : 'btn-outline-primary' }} m-1 category-filter-btn">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="row" id="menu-grid">
                    @include('public.partials.menu_items')
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    #menu-grid {
        transition: opacity 0.08s ease-out, transform 0.08s ease-out;
    }
    #menu-grid.loading {
        opacity: 0.3;
        transform: scale(0.98);
    }
    #menu-grid.fade-in {
        animation: fadeInUp 0.4s ease-out;
    }
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    .category-filter-btn {
        transition: all 0.2s ease;
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        $('.category-filter-btn').on('click', function(e) {
            e.preventDefault();
            
            $('.category-filter-btn').removeClass('btn-primary').addClass('btn-outline-primary');
            $(this).removeClass('btn-outline-primary').addClass('btn-primary');
            
            var url = $(this).attr('href');
            
            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {
                    $('#menu-grid').html(response);
                    if(typeof AOS !== 'undefined') AOS.refresh();
                }
            });
        });
    });
</script>
@endpush




