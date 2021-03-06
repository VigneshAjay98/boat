@extends('layouts.front-layout')

@section('content')
    <div class="container step-four-file-container mt-5 mb-md-4 py-5">
        <!-- Breadcrumb-->
        <nav class="mb-4 pt-md-3" aria-label="Breadcrumb">
            <ol class="breadcrumb breadcrumb-dark">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ url('/listing/step5') }}">Account</a></li>
                <li class="breadcrumb-item active" aria-current="page">My Yachts</li>
            </ol>
        </nav>
        <!-- Page content-->
        <div class="row">
            @include('layouts.partials.front-sidebar')
            <!-- Content-->
            <div class="col-lg-8 col-md-7 mb-5">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h1 class="h2 text-dark mb-0">My Yachts</h1><a class="nav-link-dark fw-bold" href="#"><i class="fi-trash mt-n1 me-2"></i>Delete all</a>
                </div>
                <p class="text-dark pt-1 mb-4">Here you can see your car offers and edit them easily.</p>
                <!-- Nav tabs-->
                <ul class="nav nav-tabs nav-tabs-dark border-bottom border-dark mb-4" role="tablist">
                    <li class="nav-item mb-3"><a class="nav-link active" href="#" role="tab" aria-selected="true"><i class="fi-file fs-base me-2"></i>Published</a></li>
                    <li class="nav-item mb-3"><a class="nav-link" href="#" role="tab" aria-selected="false"><i class="fi-file-clean fs-base me-2"></i>Drafts</a></li>
                    <li class="nav-item mb-3"><a class="nav-link" href="#" role="tab" aria-selected="false"><i class="fi-archive fs-base me-2"></i>Archived</a></li>
                </ul>
                <!-- Item-->
                <div class="card card-dark card-hover card-horizontal mb-4">
                    <div class="tns-carousel-wrapper card-img-top card-img-hover"><a class="img-overlay" href="{{ url('yacht-information') }}"></a>
                        <div class="position-absolute start-0 top-0 pt-3 ps-3"><span class="d-table badge bg-info">Used</span></div>
                        <div class="content-overlay end-0 top-0 pt-3 pe-3">
                        <button class="btn btn-icon btn-dark btn-xs text-primary rounded-circle" type="button" data-bs-toggle="tooltip" data-bs-placement="left" title="Add to Wishlist"><i class="fi-heart"></i></button>
                        </div>
                        <div class="tns-carousel-inner position-absolute top-0 h-100">
                        <div class="bg-size-cover bg-position-center w-100 h-100" style="background-image: url({{ asset('front/img/car-finder/catalog/14.jpg')}}"></div>
                        <div class="bg-size-cover bg-position-center w-100 h-100" style="background-image: url({{ asset('front/img/car-finder/catalog/14.jpg')}}"></div>
                        </div>
                    </div>
                    <div class="card-body position-relative">
                        <div class="dropdown position-absolute zindex-5 top-0 end-0 mt-3 me-3">
                            <button class="btn btn-icon btn-translucent-dark btn-xs rounded-circle" type="button" id="contextMenu1" data-bs-toggle="dropdown" aria-expanded="false"><i class="fi-dots-vertical"></i></button>
                            <ul class="dropdown-menu dropdown-menu-dark my-1" aria-labelledby="contextMenu1">
                                <li>
                                    <button class="dropdown-item" type="button"><i class="fi-edit me-2"></i>Edit</button>
                                </li>
                                <li>
                                    <button class="dropdown-item" type="button"><i class="fi-flame me-2"></i>Promote</button>
                                </li>
                                <li>
                                    <button class="dropdown-item" type="button"><i class="fi-power me-2"></i>Deactivate</button>
                                </li>
                                <li>
                                    <button class="dropdown-item" type="button"><i class="fi-trash me-2"></i>Delete</button>
                                </li>
                            </ul>
                        </div>
                        <div class="fs-sm text-dark pb-1">2017</div>
                        <h3 class="h6 mb-1"><a class="nav-link-dark" href="{{ url('yacht-information') }}">Toyota GT86</a></h3>
                        <div class="text-primary fw-bold mb-1">$16,000</div>
                        <div class="fs-sm text-dark opacity-70"><i class="fi-map-pin me-1"></i>Chicago</div>
                        <div class="border-top border-dark mt-3 pt-3">
                            <div class="row g-2">
                                <div class="col me-sm-1">
                                    <div class="bg-dark rounded text-center w-100 h-100 p-2"><i class="fi-dashboard d-block h4 text-white mb-0 mx-center"></i><span class="fs-xs text-white">32K mi</span></div>
                                </div>
                                <div class="col me-sm-1">
                                    <div class="bg-dark rounded text-center w-100 h-100 p-2"><i class="fi-gearbox d-block h4 text-white mb-0 mx-center"></i><span class="fs-xs text-white">Manual</span></div>
                                </div>
                                <div class="col">
                                    <div class="bg-dark rounded text-center w-100 h-100 p-2"><i class="fi-petrol d-block h4 text-white mb-0 mx-center"></i><span class="fs-xs text-white">Gasoline</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Item-->
                <div class="card card-dark card-hover card-horizontal mb-4">
                    <div class="tns-carousel-wrapper card-img-top card-img-hover"><a class="img-overlay" href="{{ url('yacht-information') }}"></a>
                        <div class="position-absolute start-0 top-0 pt-3 ps-3"><span class="d-table badge bg-info mb-1">Used</span><span class="d-table badge bg-success mb-1" data-bs-toggle="popover" data-bs-placement="bottom" data-bs-trigger="hover" data-bs-html="true" data-bs-content="&lt;div class=&quot;d-flex&quot;&gt;&lt;i class=&quot;fi-award mt-1 me-2&quot;&gt;&lt;/i&gt;&lt;div&gt;This car is checked and&lt;br&gt;certified by Finder.&lt;/div&gt;&lt;/div&gt;">Certified</span></div>
                        <div class="content-overlay end-0 top-0 pt-3 pe-3">
                            <button class="btn btn-icon btn-dark btn-xs text-primary rounded-circle" type="button" data-bs-toggle="tooltip" data-bs-placement="left" title="Add to Wishlist"><i class="fi-heart"></i></button>
                        </div>
                        <div class="tns-carousel-inner position-absolute top-0 h-100">
                            <div class="bg-size-cover bg-position-center w-100 h-100" style="background-image: url({{ asset('front/img/car-finder/catalog/15.jpg')}}"></div>
                            <div class="bg-size-cover bg-position-center w-100 h-100" style="background-image: url({{ asset('front/img/car-finder/catalog/15.jpg')}}"></div>
                        </div>
                    </div>
                    <div class="card-body position-relative">
                        <div class="dropdown position-absolute zindex-5 top-0 end-0 mt-3 me-3">
                            <button class="btn btn-icon btn-translucent-dark btn-xs rounded-circle" type="button" id="contextMenu2" data-bs-toggle="dropdown" aria-expanded="false"><i class="fi-dots-vertical"></i></button>
                            <ul class="dropdown-menu dropdown-menu-dark my-1" aria-labelledby="contextMenu2">
                                <li>
                                    <button class="dropdown-item" type="button"><i class="fi-edit me-2"></i>Edit</button>
                                </li>
                                <li>
                                    <button class="dropdown-item" type="button"><i class="fi-flame me-2"></i>Promote</button>
                                </li>
                                <li>
                                    <button class="dropdown-item" type="button"><i class="fi-power me-2"></i>Deactivate</button>
                                </li>
                                <li>
                                    <button class="dropdown-item" type="button"><i class="fi-trash me-2"></i>Delete</button>
                                </li>
                            </ul>
                        </div>
                        <div class="fs-sm text-dark pb-1">2019</div>
                        <h3 class="h6 mb-1"><a class="nav-link-dark" href="{{ url('yacht-information') }}">Volkswagen GTI S </a></h3>
                        <div class="text-primary fw-bold mb-1">$20,000</div>
                        <div class="fs-sm text-dark opacity-70"><i class="fi-map-pin me-1"></i>San Francisco</div>
                        <div class="border-top border-dark mt-3 pt-3">
                            <div class="row g-2">
                                <div class="col me-sm-1">
                                    <div class="bg-dark rounded text-center w-100 h-100 p-2"><i class="fi-dashboard d-block h4 text-white mb-0 mx-center"></i><span class="fs-xs text-white">25K mi</span></div>
                                </div>
                                <div class="col me-sm-1">
                                    <div class="bg-dark rounded text-center w-100 h-100 p-2"><i class="fi-gearbox d-block h4 text-white mb-0 mx-center"></i><span class="fs-xs text-white">Automatic</span></div>
                                </div>
                                <div class="col">
                                    <div class="bg-dark rounded text-center w-100 h-100 p-2"><i class="fi-petrol d-block h4 text-white mb-0 mx-center"></i><span class="fs-xs text-white">Hybrid</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Item-->
                <div class="card card-dark card-hover card-horizontal">
                    <div class="tns-carousel-wrapper card-img-top card-img-hover"><a class="img-overlay" href="{{ url('yacht-information') }}"></a>
                        <div class="position-absolute start-0 top-0 pt-3 ps-3"><span class="d-table badge bg-info">Used</span></div>
                        <div class="content-overlay end-0 top-0 pt-3 pe-3">
                            <button class="btn btn-icon btn-dark btn-xs text-primary rounded-circle" type="button" data-bs-toggle="tooltip" data-bs-placement="left" title="Add to Wishlist"><i class="fi-heart"></i></button>
                        </div>
                        <div class="tns-carousel-inner position-absolute top-0 h-100">
                            <div class="bg-size-cover bg-position-center w-100 h-100" style="background-image: url({{ asset('front/img/car-finder/catalog/16.jpg')}}"></div>
                            <div class="bg-size-cover bg-position-center w-100 h-100" style="background-image: url({{ asset('front/img/car-finder/catalog/16.jpg')}}"></div>
                        </div>
                    </div>
                    <div class="card-body position-relative">
                        <div class="dropdown position-absolute zindex-5 top-0 end-0 mt-3 me-3">
                            <button class="btn btn-icon btn-translucent-dark btn-xs rounded-circle" type="button" id="contextMenu3" data-bs-toggle="dropdown" aria-expanded="false"><i class="fi-dots-vertical"></i></button>
                            <ul class="dropdown-menu dropdown-menu-dark my-1" aria-labelledby="contextMenu3">
                                <li>
                                    <button class="dropdown-item" type="button"><i class="fi-edit me-2"></i>Edit</button>
                                </li>
                                <li>
                                    <button class="dropdown-item" type="button"><i class="fi-flame me-2"></i>Promote</button>
                                </li>
                                <li>
                                    <button class="dropdown-item" type="button"><i class="fi-power me-2"></i>Deactivate</button>
                                </li>
                                <li>
                                    <button class="dropdown-item" type="button"><i class="fi-trash me-2"></i>Delete</button>
                                </li>
                            </ul>
                        </div>
                        <div class="fs-sm text-dark pb-1">2017</div>
                        <h3 class="h6 mb-1"><a class="nav-link-dark" href="{{ url('yacht-information') }}">Ford Explorer XLT </a></h3>
                        <div class="text-primary fw-bold mb-1">$26,950</div>
                        <div class="fs-sm text-dark opacity-70"><i class="fi-map-pin me-1"></i>Kansas</div>
                        <div class="border-top border-dark mt-3 pt-3">
                            <div class="row g-2">
                                <div class="col me-sm-1">
                                    <div class="bg-dark rounded text-center w-100 h-100 p-2"><i class="fi-dashboard d-block h4 text-dark mb-0 mx-center"></i><span class="fs-xs text-dark">47K mi</span></div>
                                </div>
                                <div class="col me-sm-1">
                                    <div class="bg-dark rounded text-center w-100 h-100 p-2"><i class="fi-gearbox d-block h4 text-dark mb-0 mx-center"></i><span class="fs-xs text-dark">Manual</span></div>
                                </div>
                                <div class="col">
                                    <div class="bg-dark rounded text-center w-100 h-100 p-2"><i class="fi-petrol d-block h4 text-dark mb-0 mx-center"></i><span class="fs-xs text-dark">Diesel</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
