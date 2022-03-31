@extends('layouts.front-layout')
@section('content')
	<!-- Breadcrumb-->
    <div class="container mt-5 py-5">
        <!-- Breadcrumb-->
        <nav class="mb-3 pt-md-3" aria-label="Breadcrumb">
            <ol class="breadcrumb breadcrumb-dark">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ url('explore/brands') }}">Brands</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $brand->name ?? $brand->slug ?? '' }}</li>
            </ol>
        </nav>
    </div>

    <div class="container ">
        <div class="d-sm-flex align-items-end align-items-md-center	justify-content-between	position-relative mb-4"	style="z-index:	1025;">
            <div class="">
                <h1	class="h2 text-dark	mb-md-0"> About {{ $brand->name }}</h1>
            </div>
        </div>
        <p class="text-dark opacity-70 mb-5">
            {{ $brand->description }}
        </p>
        @if(count($boatSuggestions) > 0)
        <!-- Related posts (Carousel)-->
            <h2	class="h3 text-dark	pt-5 pb-3 mt-md-4">You may be interested in</h2>
            <div class="tns-carousel-wrapper tns-controls-outside-xxl tns-nav-outside tns-carousel-light">
                <div class="tns-carousel-inner" data-carousel-options="{&quot;items&quot;: 3, &quot;responsive&quot;:	{&quot;0&quot;:{&quot;items&quot;:1, &quot;gutter&quot;: 16},&quot;500&quot;:{&quot;items&quot;:2, &quot;gutter&quot;: 18},&quot;900&quot;:{&quot;items&quot;:3, &quot;gutter&quot;: 20}, &quot;1100&quot;:{&quot;gutter&quot;:	24}}}">
                    @if (isset($boatSuggestions) || !empty($boatSuggestions))
                        @foreach ($boatSuggestions as $boatSuggestion)
                            <div>
                                <div class="card card-dark card-hover h-100">
                                    @if (isset($boatSuggestion->images) && !empty($boatSuggestion->images))
                                        <div class="card-img-top card-img-hover"><a	class="img-overlay"	href="{{ url('explore/yacht/'.$boatSuggestion->slug) }}"></a>
                                            <div class="position-absolute start-0 top-0 pt-3 ps-3"><span class="d-table badge text-capitalize	bg-info">{{ $boatSuggestion->boat_condition ?? ''}}</span></div>
                                            @php
                                                $imagePath = (isset($boatSuggestion->images[0]) && isset($boatSuggestion->images[0]['image_name']) && File::exists($boatSuggestion->images[0]['image_name']) ) ? asset($boatSuggestion->images[0]['image_name']) : asset('/front/img/avatars/default-yacht-profile.jpg');
                                            @endphp
                                            <img src="{{ $imagePath }}" alt="Image">
                                        </div>
                                    @endif
                                    <div class="card-body">
                                        @if (isset($boatSuggestion->year))
                                            <div class="d-flex align-items-center	justify-content-between	pb-1">
                                                <span	class="fs-sm text-dark me-3">{{ $boatSuggestion->year ?? ''}}</span>
                                            </div>
                                        @endif
                                        @if (isset($boatSuggestion->boat_name))
                                            <h3 class="h6	mb-1"><a class="nav-link-dark text-capitalize" href="{{ url('explore/yacht/'.$boatSuggestion->slug) }}">{{ $boatSuggestion->boat_name ?? ''}}</a></h3>
                                            @endif
                                        @if (isset($boatSuggestion->price))
                                            <div class="text-primary fw-bold mb-1">${{ number_format($boatSuggestion->price, 2, '.',',') ?? ''}}</div>
                                        @endif
                                        @if (isset($boatSuggestion->city))
                                            <div class="fs-sm	text-dark opacity-70 text-capitalize"><i class="fi-map-pin me-1"></i>{{ $boatSuggestion->city ?? ''}}</div>
                                        @endif
                                    </div>

                                    <div class="card-footer	border-0 pt-0">
                                        <div class="border-top border-dark mt-3 pt-3">
                                            <div class="row g-2">
                                                @if (isset($boatSuggestion->boatInfo) && !empty($boatSuggestion->boatInfo) && isset($boatSuggestion->boatInfo->fuel_capacity))
                                                    <div class="col me-sm-1">
                                                        <div class="bg-dark rounded text-center w-100 h-100 p-2"><i class="fi-dashboard d-block h4 text-white mb-0 mx-center"></i><span class="fs-xs text-white">{{ $boatSuggestion->boatInfo->fuel_capacity }} gal</span></div>
                                                    </div>
                                                @endif
                                                @if (isset($boatSuggestion->engine) && !empty($boatSuggestion->engine) && isset($boatSuggestion->engine->engine_type))
                                                    <div class="col me-sm-1">
                                                        <div class="bg-dark rounded text-center w-100 h-100 p-2"><i class="fi-gearbox d-block h4 text-white mb-0 mx-center"></i><span class="fs-xs text-white">{{ $boatSuggestion->engine->engine_type }}</span></div>
                                                    </div>
                                                @endif
                                                @if (isset($boatSuggestion->engine) && !empty($boatSuggestion->engine) && isset($boatSuggestion->engine->fuel_type))
                                                    <div class="col">
                                                        <div class="bg-dark rounded text-center w-100 h-100 p-2"><i class="fi-petrol d-block h4 text-white mb-0 mx-center"></i><span class="fs-xs text-white">{{ $boatSuggestion->engine->fuel_type }}</span></div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
            <h3 class="h6 mb-3"><a class="nav-link-dark text-capitalize" href="{{ url('explore/yachts/?brand='.$brand->name) }}">View more >></a></h3>
        @endif
    </div>
@endsection
