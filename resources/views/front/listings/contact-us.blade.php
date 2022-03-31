@extends('layouts.front-layout')
@section('content')
<!-- Page content-->
    <!-- Page content-->
    <section class="container my-5 pt-5 pb-lg-5">
        <!-- Breadcrumb-->
        <nav class="mb-4 pt-md-3" aria-label="Breadcrumb">
            <ol class="breadcrumb breadcrumb-dark">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Contact us</li>
            </ol>
        </nav>
        <div class="row gy-4">
            <div class="col-lg-4 col-md-6">
                <div class="mb-md-5 mb-4 pb-md-4">
                    <h1 class="mb-md-4 text-dark">Contact us</h1>
                    <p class="mb-0 fs-lg text-dark opacity-70">Fill out the form and out team will try to get back to you within 24 hours.</p>
                </div>
                <div class="d-flex align-items-start mb-4 pb-md-3"><img class="me-3 flex-shrink-0" src="{{ asset('front/img/car-finder/icons/envelope.svg') }}" width="32" alt="Envelope icon">
                    <div>
                        <h3 class="h6 mb-2 pb-1 text-dark">General communication</h3>
                        <p class="mb-0 text-dark"><span class="opacity-70">For general queries, including partnership opportunities, please email</span><a class="ms-1 text-nowrap" href="mailto:example@email.com">example@email.com</a></p>
                    </div>
                </div>
                <div class="d-flex align-items-start mb-4 pb-md-3"><img class="me-3 flex-shrink-0" src="{{ asset('front/img/car-finder/icons/chat.svg') }}" width="32" alt="Chat icon">
                    <div>
                        <h3 class="h6 mb-2 pb-1 text-dark">General communication</h3>
                        <p class="mb-0 text-dark"><span class="opacity-70">We’re here to help! If you have technical issues</span><a class="ms-1 text-nowrap" href="car-finder-help-center.html">contact support</a></p>
                    </div>
                </div>
                <div class="d-flex align-items-start mb-4 pb-md-3"><img class="me-3 flex-shrink-0" src="{{ asset('front/img/car-finder/icons/map-pin.svg') }}" width="32" alt="Map pin icon">
                    <div>
                        <h3 class="h6 mb-2 pb-1 text-dark">Our headquarters</h3>
                        <p class="mb-0 text-dark"><span class="opacity-70">8502 Preston Rd. Inglewood, Maine 98380</span><a class="ms-1 text-nowrap" href="#map-location" data-scroll>get directions</a></p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 offset-lg-2">
                <!-- Contact form-->
                <form class="needs-validation" novalidate>
                    <div class="mb-4">
                        <label class="form-label text-dark" for="c-name">Full Name</label>
                        <input class="form-control form-control-lg form-control-dark" id="c-name" type="text" required>
                        <div class="invalid-feedback">Please, enter your name</div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label text-dark" for="c-email">Your Email</label>
                        <input class="form-control form-control-lg form-control-dark" id="c-email" type="email" required>
                        <div class="invalid-feedback">Please, enter your email</div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label text-dark" for="c-subject">Subject</label>
                        <select class="form-select form-select-lg form-select-dark" id="c-subject" required>
                            <option value="" selected disabled>Choose subject</option>
                            <option value="Subject 1">Subject 1</option>
                            <option value="Subject 2">Subject 2</option>
                            <option value="Subject 3">Subject 3</option>
                        </select>
                        <div class="invalid-feedback">Please, choose subject</div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label text-dark" for="c-message">Message</label>
                        <textarea class="form-control form-control-lg form-control-dark" id="c-message" rows="4" placeholder="Leave your message" required></textarea>
                        <div class="invalid-feedback">Please, leave your message</div>
                    </div>
                    <div class="pt-2">
                        <button class="btn btn-lg btn-primary w-sm-auto w-100" type="submit">Submit form</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <!-- Map location-->
    <section class="container mb-5 pb-lg-5" id="map-location">
        <div class="interactive-map rounded-3" data-map-options="{&quot;mapLayer&quot;: &quot;https://api.maptiler.com/maps/pastel/{z}/{x}/{y}.png?key=5vRQzd34MMsINEyeKPIs&quot;, &quot;coordinates&quot;: [51.5074, -0.1278], &quot;zoom&quot;: 10, &quot;markers&quot;: [{&quot;coordinates&quot;: [51.5074, -0.1278], &quot;popup&quot;: &quot;&lt;div class='p-3'&gt;&lt;h6&gt;Hi, I'm in London&lt;/h6&gt;&lt;p class='fs-sm pt-1 mt-n3 mb-0'&gt;Lorem ipsum dolor sit amet elit.&lt;/p&gt;&lt;/div&gt;&quot;}]}" style="height: 500px;"></div>
    </section>
@endsection
