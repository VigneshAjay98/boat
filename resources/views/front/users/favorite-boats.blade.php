@extends('layouts.front-layout')

@section('content')
    <div class="container step-four-file-container mt-5 mb-md-4 py-5">
        <!-- Breadcrumb-->
        <nav class="mb-4 pt-md-3" aria-label="Breadcrumb">
            <ol class="breadcrumb breadcrumb-dark">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">My Favorites</li>
            </ol>
        </nav>
        <!-- Page content-->
        <div class="row">
            @include('layouts.partials.front-sidebar')
            <!-- Content-->
            <div class="col-lg-8 col-md-7 mb-5">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h1 class="h2 text-dark mb-0">My Favorites</h1>
                </div>
                <!-- Item-->
                @if(isset($boats) && count($boats) > 0)

                    @foreach($boats as $boat)
                        <div class="card card-dark card-hover card-horizontal mb-4">
                            <div class="tns-carousel-wrapper card-img-top card-img-hover"><a class="img-overlay" href="{{ url('explore/yacht/'.$boat->slug) }}"></a>
                                @if (isset($boat->boat_condition))
                                <div class="position-absolute start-0 top-0 pt-3 ps-3"><span class="d-table badge bg-info">{{ $boat->boat_condition }}</span></div>
                                @endif
                                @auth
                                    <form action="{{ url('remove-favorite-yacht') }}"  method="POST">
                                        <div class="content-overlay end-0 top-0 pt-3 pe-3">
                                            @csrf
                                            <input type="hidden" name="boat_slug" value={{ $boat->slug }}>
                                            <button class="btn btn-icon btn-light btn-xs text-primary rounded-circle favorite-boat-button" type="submit" data-bs-toggle="tooltip" data-bs-placement="left" title="Remove yacht from favorites"><i class="fi-heart-filled"></i></button>
                                        </div>
                                    </form>
                                @endauth
                                <div class="content-overlay end-0 top-0 pt-3 pe-3"></div>
                                <div class="tns-carousel-inner position-absolute top-0 h-100">
                                        @if (isset($boat->images) && count($boat->images)>0)
                                            @foreach($boat->images as $image)
                                                @php
                                                    $mainImagePath = '';
                                                    $mainImagePath = (isset($image->image_name) && File::exists($image->image_name)) ? $image->image_name : '/front/img/avatars/default-yacht-profile.jpg';
                                                @endphp
                                                <div class="bg-size-cover bg-position-center w-100 h-100" style="background-image: url({{ asset($mainImagePath)}}"></div>
                                            @endforeach
                                        @else
                                            <div class="bg-size-cover bg-position-center w-100 h-100" style="background-image: url({{ asset('/front/img/avatars/default-yacht-profile.jpg') }})"></div>
                                        @endif
                                    </div>
                                </div>

                            <div class="card-body position-relative">
                                @if (!empty($boat->publish_status))
                                    @if($boat->publish_status == 'draft')
                                        <span class="badge bg-faded-warning">Draft</span>
                                    @elseif($boat->publish_status == 'published')
                                        <span class="badge bg-faded-success">Published</span>
                                    @endif
                                @endif
                                @php
                                    $boatAllDetails = ((isset($boat->year))? ($boat->year.'/ '): '' ).((!empty($boat->brand) && isset($boat->brand) && isset($boat->brand->name))? ($boat->brand->name):'').((isset($boat->model))? ('/ '.$boat->model):'')
                                @endphp
                                <div class="fs-sm text-dark pb-1 text-capitalize">{{ $boatAllDetails ?? '' }} </div>
                                <h3 class="h6 mb-1"><a class="nav-link-dark" href="{{ url('explore/yacht/'.$boat->slug) }}">{{ $boat->boat_name }}</a></h3>
                                @if (isset($boat->price) && $boat->price != 0)
                                    <div class="text-primary fw-bold mb-1">{!! $boat->currency_symbol !!}{{ number_format($boat->price, 2, '.',',') ?? 00.00 }}</div>
                                @else
                                    <div class="text-primary fw-bold mb-1">Price on Request</div>
                                @endif
                                @if (isset($boat->country))
                                    <div class="fs-sm text-dark opacity-70"><i class="fi-map-pin me-1"></i>{{ $boat->country }}</div>
                                @endif
                                @if (isset($boat->payment_status) && $boat->payment_status == 'paid')
                                    <div class="row">
                                        <div class="col-lg-6 col-xs-12">
                                            <div class="fs-sm text-dark">Plan :&nbsp;<span class="fs-sm text-dark opacity-70 text-capitalize">{{ $boat->plan->name ?? 'NA' }}</span></div>
                                            @if(count($boat->userPlanAddons) > 0)
                                                @foreach($boat->userPlanAddons as $key => $userAddon)

                                                    @foreach($addons as $planAddon)
                                                        @if(!empty($userAddon->addon_id) && ($userAddon->addon_id == $planAddon->id) )
                                                            <div class="fs-sm text-dark"> Addon {{ ++$key }}:&nbsp;<span class="fs-sm text-dark opacity-70 text-capitalize">{{ $planAddon->addon_name }}</span></div>
                                                        @endif
                                                    @endforeach
                                                @endforeach
                                            @endif
                                            @if(!empty($boat->subscription_id) && empty($boat->subscription->ends_at))
                                                <div class="fs-sm text-dark">Auto Renew :&nbsp;<span class="fs-sm text-dark opacity-70 text-capitalize">Yes</span></div>
                                            @elseif(!empty($boat->subscription_id) && !empty($boat->subscription->ends_at))
                                                <div class="fs-sm text-dark">End Date :&nbsp;<span class="fs-sm text-dark opacity-70 text-capitalize">{{ date('M d, Y', strtotime($boat->subscription->ends_at)) }}  {{ date('h:i A', strtotime($boat->subscription->ends_at)) }}</span></div>
                                            @endif
                                        </div>
                                    </div>
                                    <!-- <div class="fs-sm text-dark">End date :&nbsp;<span class="fs-sm text-dark opacity-70 text-capitalize">Jan 12, 2022</span></div> -->
                                @endif
                                {{-- @if (isset($boat->boatInfo) || !empty($boat->boatInfo) || isset($boat->engine) || !empty($boat->engine))
                                    <div class="border-top border-dark mt-3 pt-3">
                                        <div class="row g-2">
                                            @if (isset($boat->boatInfo) && !empty($boat->boatInfo) && isset($boat->boatInfo->fuel_capacity))
                                                <div class="col me-sm-1">
                                                    <div class="bg-dark rounded text-center w-100 h-100 p-2"><i class="fi-dashboard d-block h4 text-white mb-0 mx-center"></i><span class="fs-xs text-white">{{ $boat->boatInfo->fuel_capacity }} gal</span></div>
                                                </div>
                                            @endif
                                            @if (isset($boat->engine) && !empty($boat->engine) && isset($boat->engine->engine_type))
                                                <div class="col me-sm-1">
                                                    <div class="bg-dark rounded text-center w-100 h-100 p-2"><i class="fi-gearbox d-block h4 text-white mb-0 mx-center"></i><span class="fs-xs text-white text-capitalize">{{ $boat->engine->engine_type }}</span></div>
                                                </div>
                                            @endif
                                            @if (isset($boat->engine) && !empty($boat->engine) && isset($boat->engine->fuel_type))
                                                <div class="col">
                                                    <div class="bg-dark rounded text-center w-100 h-100 p-2"><i class="fi-petrol d-block h4 text-white mb-0 mx-center"></i><span class="fs-xs text-white text-capitalize">{{ $boat->engine->fuel_type }}</span></div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif --}}
                            </div>
                        </div>

                    @endforeach

                    <div class="d-flex align-items-center justify-content-end py-2">
                        <div aria-label="Pagination">
                            <div class="pagination pagination-dark mb-0">
                                {{ $boats->links() }}
                            </div>
                        </div>
                    </div>
                @else
                    <p>
                        No yachts available.
                    </p>
                @endif
            </div>
        </div>
    </div>
@endsection
