@extends('layouts.front-layout')

@section('content')

	<!-- Breadcrumb-->
    <div class="container mt-5 pt-5">
        <!-- Breadcrumb-->
        <nav class="mb-3 pt-md-3" aria-label="Breadcrumb">
            <ol class="breadcrumb breadcrumb-dark">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">About</li>
            </ol>
        </nav>
    </div>
	  <!-- Page header-->
    <section class="container mb-5 pb-lg-5">
        <div class="row align-items-center justify-content-lg-start justify-content-center flex-lg-nowrap gy-4">
            <div class="col-lg-9"><img class="rounded-3" src="{{ asset('/front/img/about/hero-img.jpg') }} " alt="Hero image"></div>
            <div class="col-lg-4 ms-lg-n5 col-sm-9 text-lg-start text-center">
                <div class="ms-lg-n5 pe-xl-5">
                    <h1 class="mb-lg-4 text-dark">About us</h1>
                    <p class="mb-4 pb-lg-3 fs-lg text-dark opacity-70">We believe that car buying and selling should be straight-forward and enjoyable, not time-consuming, complicated or stressful.</p><a class="btn btn-lg btn-primary w-sm-auto w-100" href="{{ url('explore/yachts') }}"><i class="fi-search me-2"></i>Search Yacht</a>
                </div>
            </div>
        </div>
    </section>
	  <!-- Features-->

	  <!-- Story steps-->
    <section class="container mb-5 pb-lg-5 pb-3 pb-sm-4">
    <h2 class="mb-4 pb-2 text-dark text-center">Our story</h2>
        <div class="mx-auto" style="max-width: 864px;">
            <div class="steps steps-dark steps-vertical">
                <div class="step">
                    <div class="step-progress"><span class="step-progress-end"></span><span class="step-number text-light bg-primary shadow-hover">1</span></div>
                    <div class="step-label">
                        <h3 class="h5 mb-2 pb-1 text-dark">1999</h3>
                        <p class="mb-0">
                            boats.com, founded in 1999, is the largest global search engine in the leisure marine market with more than 120,000 boats from 146 countries. Its powerful URL helps position boats.com as the go-to resource for everything boats - boating news, DIY tutorials, blog posts, videos, reviews and boat listings. For OEMs and their dealer networks, boats.com offers effective marketing tools to promote and sell new and used boats for sale across the globe. boats.com was originally launched as a private, venture capital-funded start-up in San Francisco, CA to leverage the dot com boom in the boating niche.
                        </p>
                    </div>
                </div>
                <div class="step">
                    <div class="step-progress"><span class="step-progress-end"></span><span class="step-number text-light bg-primary shadow-hover">2</span></div>
                    <div class="step-label">
                        <h3 class="h5 mb-2 pb-1 text-dark">2000</h3>
                        <p class="mb-0">
                            In January 2000, boats.com acquired YachtWorld, marking the first Internet content deal within the boating industry. Just a few months later, boats.com expanded its offerings to the European market. Ian Atkins opened the first European office in Fareham, England to launch boats.com to the European markets and provide dedicated sites for the UK, Germany, France, Spain, Italy, Netherlands, and Australia.
                        </p>
                    </div>
                </div>
                <div class="step">
                    <div class="step-progress"><span class="step-progress-end"></span><span class="step-number text-light bg-primary shadow-hover">3</span></div>
                    <div class="step-label">
                        <h3 class="h5 mb-2 pb-1 text-dark">2004</h3>
                        <p class="mb-0">
                            boats.com was acquired in 2004, and for the next six years focused on building content, including editorial, videos, reviews and global boat listings - positioning it as the site for "everything boats."
                        </p>
                    </div>
                </div>

                <div class="step">
                    <div class="step-progress"><span class="step-progress-end"></span><span class="step-number text-light bg-primary shadow-hover">4</span></div>
                    <div class="step-label">
                        <h3 class="h5 mb-2 pb-1 text-dark">2004</h3>
                        <p class="mb-0">
                            boats.com was acquired in 2004, and for the next six years focused on building content, including editorial, videos, reviews and global boat listings - positioning it as the site for "everything boats."
                        </p>
                    </div>
                </div>
                <div class="step">
                    <div class="step-progress"><span class="step-progress-end"></span><span class="step-number text-light bg-primary shadow-hover">5</span></div>
                    <div class="step-label">
                        <h3 class="h5 mb-2 pb-1 text-dark">2010</h3>
                        <p class="mb-0">
                            In 2010, boats.com, YachtWorld and Boat Trader joined forces as the three leading marine websites to form Boats Group (then operated as Dominion Marine Media).
                        </p>
                    </div>
                </div>
                <div class="step">
                    <div class="step-progress"><span class="step-progress-end"></span><span class="step-number text-light bg-primary shadow-hover">6</span></div>
                    <div class="step-label">
                        <h3 class="h5 mb-2 pb-1 text-dark">2016</h3>
                        <p class="mb-0">
                            In July 2016, Boats Group was acquired by Apax Partners and then by Permira Funds in February 2021.
                        </p>
                    </div>
                </div>
                <div class="step">
                    <div class="step-progress"><span class="step-progress-end"></span><span class="step-number text-light bg-primary shadow-hover">7</span></div>
                    <div class="step-label">
                        <h3 class="h5 mb-2 pb-1 text-dark">2021</h3>
                        <p class="mb-0">
                            then by Permira Funds in February 2021.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>
	  <!-- Personalized search-->
	  <section class="container mb-5 pb-lg-5 pb-2 pb-sm-3">
		<div class="row gy-4 align-items-lg-center">
		  <div class="col-md-6"><img class="rounded-3" src="{{ asset('/front/img/about/01.jpg') }}" alt="Personalized search"></div>
		  <div class="col-lg-5 offset-lg-1 col-md-6 text-md-start text-center">
			<!-- <h2 class="mb-md-4 text-dark">Personalized search</h2> -->
			<p class="mb-4 pb-md-3 text-dark opacity-70">
			  Boats Group's brands - Boat Trader, YachtWorld, boats.com, iNautia, Cosas De Barcos, Botentekoop, Annonces du Bateau, Boats and Outboards, and Boatshop24 - are the world's leading online boating marketplaces, connecting the largest global audience of boat buyers with top sellers and manufacturers. For nearly three decades, Boats Group has helped its industry partners sell more boats faster and provided unmatched support with a comprehensive suite of online business solutions, including proprietary web-based contract management tools, and premier digital marketing strategies and services. Owned by the Permira Funds, Boats Group is based in Miami, Florida, United States with co-headquarters in Fareham, England, and additional offices in Padova, Italy and Barcelona, Spain.

			  To find out more about boats.com, please meet the team and visit our News Room.

			  Member of the press? For all media inquiries, please contact the Boats Group Media Relations team at press@boats.com. Your request will be returned promptly.
			</p>
			  <a class="btn btn-primary w-sm-auto w-100" href="{{ route('select-plan') }}"><i class="fi-search me-2"></i>Sell Your Yacht</a>
		  </div>
		</div>
	  </section>
@endsection
