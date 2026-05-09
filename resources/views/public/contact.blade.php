@extends('layouts.app')

@section('title', 'Contact Us')

@section('content')
<div class="cover_1 overlay bg-slant-white bg-light">
    <div class="img_bg" style="background-image: url({{ asset('images/slider-1.jpg') }}); min-height: 300px;" data-stellar-background-ratio="0.5">
        <div class="container">
            <div class="row align-items-center justify-content-center text-center" style="padding-top: 100px;">
                <div class="col-md-10" data-aos="fade-up">
                    <h2 class="heading mb-3">Contact Us</h2>
                    <p class="sub-heading">Get in touch with us</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="section" data-aos="fade-up">
    <div class="container">
        <div class="row">
            <div class="col-md-6 mb-5">
                <h3 class="mb-4">Get In Touch</h3>
                <div class="mb-4">
                    <h5>Address</h5>
                    <p>240, Kings Street, New York City USA</p>
                </div>
                <div class="mb-4">
                    <h5>Opening Hours</h5>
                    <p>Lunch: 12:00pm — 1:30pm</p>
                    <p>Dinner: 6:00pm — 9:00pm</p>
                </div>
                <div class="mb-4">
                    <h5>Contact</h5>
                    <p>Phone: +880 367 251 167</p>
                    <p>Email: info@liluskitchen.com</p>
                </div>
                <div>
                    <h5>Follow Us</h5>
                    <ul class="list-unstyled social" style="display: flex; gap: 15px;">
                        <li><a href="#"><span class="fa fa-facebook" style="font-size: 24px;"></span></a></li>
                        <li><a href="#"><span class="fa fa-twitter" style="font-size: 24px;"></span></a></li>
                        <li><a href="#"><span class="fa fa-instagram" style="font-size: 24px;"></span></a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6">
                <div class="p-5 form-wrap" style="background: white; border-radius: 10px;">
                    <h3 class="mb-4">Send us a Message</h3>
                    <form action="{{ route('contact.submit') }}" method="POST">
                        @csrf
                        <div class="row mb-4">
                            <div class="form-group col-md-12 mb-3">
                                <label for="name" class="label">Name</label>
                                <input type="text" name="name" class="form-control" id="name" required>
                            </div>
                            <div class="form-group col-md-12 mb-3">
                                <label for="email" class="label">Email</label>
                                <input type="email" name="email" class="form-control" id="email" required>
                            </div>
                            <div class="form-group col-md-12 mb-3">
                                <label for="phone" class="label">Phone</label>
                                <input type="text" name="phone" class="form-control" id="phone">
                            </div>
                            <div class="form-group col-md-12 mb-3">
                                <label for="subject" class="label">Subject</label>
                                <input type="text" name="subject" class="form-control" id="subject" required>
                            </div>
                            <div class="form-group col-md-12 mb-3">
                                <label for="message" class="label">Message</label>
                                <textarea name="message" id="message" cols="30" rows="5" class="form-control" required></textarea>
                            </div>
                        </div>
                        <input type="submit" class="btn btn-primary btn-outline-primary btn-block" value="Send Message">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
