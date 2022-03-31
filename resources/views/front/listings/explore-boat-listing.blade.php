@extends('layouts.front-layout')
@section('content')
    <div class="container mt-5 mb-md-4 py-5">
        <div class="row py-md-1">
            <div class="col-lg-3 pe-xl-4">
                @include('front.listings.listing-filter-sidebar')
            </div>

            <div class="col-lg-9">
                <nav class="mb-3 pt-md-2 pt-lg-4" aria-label="Breadcrumb">
                    <ol class="breadcrumb breadcrumb-dark">
                        <li class="breadcrumb-item"><a href="{{ url('') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Yacht Listings</li>
                    </ol>
                </nav>

                <div class="d-flex align-items-center justify-content-between pb-4 mb-2">
                    <h1 class="text-dark me-3 mb-0">Yacht Listings</h1>
                    <div class="text-dark"><i class="fi-car fs-lg me-2"></i><span class="align-middle">{{ $boats->total() ?? 0}} Yacht</span></div>
                </div>

                <div class="d-sm-flex align-items-center justify-content-between pb-4 mb-2">
                    <div class="d-flex align-items-center me-sm-4">
                        <label class="fs-sm text-dark me-2 pe-1 text-nowrap" for="sorting1"><i class="fi-arrows-sort mt-n1 me-2"></i>Sort by:</label>
                        <select class="form-select form-select-dark form-select-sm me-sm-4" id="sorting1">
                            <option>Newest</option>
                            <option>Popular</option>
                            <option>Price: Low - High</option>
                            <option>Price: Hight - Low</option>
                        </select>
                    </div>
                    @php
                        $currentUrl =  Request::fullUrl();
                        $cutString = url('/').'/explore/yachts';
                        $newPath = url('/').'/explore/yachts/grid';
                        $appendString = substr($currentUrl, strpos($currentUrl, $cutString) + strlen($cutString));
                        $newPath = $newPath . $appendString;
                    @endphp
                    <div class="d-none d-sm-flex">
                        <a class="nav-link nav-link-dark px-2 active" href="car-finder-catalog-list.html" data-bs-toggle="tooltip" title="List view"><i class="fi-list"></i></a>
                        <a class="nav-link nav-link-dark px-2" href="{{  $newPath }}" data-bs-toggle="tooltip" title="Grid view"><i class="fi-grid"></i></a>
                    </div>
                </div>
                @if(isset($boats) && count($boats) > 0)
                    @foreach($boats as $boat)
                        <div class="card card-dark card-hover card-horizontal mb-4">
                            <div class="tns-carousel-wrapper card-img-top card-img-hover ">
                                <a class="img-overlay" href="{{ url('explore/yacht/'.$boat->slug) }}"></a>
                                <div class="position-absolute start-0 top-0 pt-3 ps-3"><span class="d-table badge bg-info">{{ $boat->boat_condition ?? '' }}</span></div>
                                @auth
                                    <div class="yacht-list-options" style="">
                                        @if (!empty($boat->favorite) && isset($boat->favorite))
                                            <form action="{{ url('remove-favorite-yacht') }}"  method="POST">
                                                <div class="content-overlay end-0 top-0 pt-3 pe-3">
                                                    @csrf
                                                    <input type="hidden" name="boat_slug" value={{ $boat->slug }}>
                                                    <button class="btn btn-icon btn-light btn-xs text-primary rounded-circle favorite-boat-button" type="submit" data-bs-toggle="tooltip" data-bs-placement="left" title="Remove yacht from favorites"><i class="fi-heart-filled"></i></button>
                                                </div>
                                            </form>
                                        @else
                                            <form action="{{ url('block-yacht') }}"  method="POST">
                                                <div class="content-overlay end-0 top-0 pt-3 pe-3">
                                                    @csrf
                                                    <input type="hidden" name="boat_slug" value={{ $boat->slug }}>
                                                    <button class="btn btn-icon btn-light btn-xs text-primary rounded-circle block-boat" data-slug="{{ $boat->slug }}" type="submit" data-bs-toggle="tooltip" data-bs-placement="left" title="Block this yacht"><i class="fi-eye-off"></i></button>
                                                </div>
                                            </form>
                                            <form action="{{ url('favorite-yacht') }}"  method="POST">
                                                <div class="content-overlay end-30 top-0 pt-3 pe-3">
                                                    @csrf
                                                    <input type="hidden" name="boat_slug" value={{ $boat->slug }}>
                                                    <button class="btn btn-icon btn-light btn-xs text-primary rounded-circle favorite-boat-button yacht-list-favorite" type="submit" data-bs-toggle="tooltip" data-bs-placement="left" title="Add to favorites"><i class="fi-heart"></i></button>
                                                </div>
                                            </form>
                                        @endif
                                    </div>
                                @endauth
                                <div class="tns-carousel-inner position-absolute top-0 h-100">
                                    @if (isset($boat->images) && count($boat->images) > 0)
                                        @foreach ($boat->images as $image)
                                            @php
                                                $mainImagePath = '';
                                                $mainImagePath = (isset($image->image_name) && File::exists($image->image_name)) ? $image->image_name : '/front/img/avatars/default-yacht-profile.jpg';
                                            @endphp
                                            <div class="bg-size-cover bg-position-center w-100 h-100" style="background-image: url({{ asset($mainImagePath) }})"></div>
                                        @endforeach
                                    @else
                                        <div class="bg-size-cover bg-position-center w-100 h-100" style="background-image: url({{ asset('/front/img/avatars/default-yacht-profile.jpg') }})"></div>
                                    @endif
                                </div>
                            </div>

                            <div class="card-body">
                                @php
                                    $boatAllDetails = ((isset($boat->year))? ($boat->year.'/ '): '' ).((!empty($boat->brand) && isset($boat->brand) && isset($boat->brand->name))? ($boat->brand->name):'').((isset($boat->model))? ('/ '.$boat->model):'')
                                @endphp
                                <div class="fs-sm text-dark pb-1 text-capitalize">{{ $boatAllDetails ?? '' }} </div>
                                <h3 class="h6 mb-1"><a class="nav-link-dark" href="{{ url('explore/yacht/'.$boat->slug) }}">{{ $boat->boat_name }}</a></h3>
                                @if (isset($boat->price) && $boat->price >  0)
                                    <div class="text-primary fw-bold mb-1">{!! $boat->currency_symbol !!}{{ number_format($boat->price, 2, '.', ',') ?? '00.00' }}</div>
                                @else
                                    <div class="text-primary fw-bold mb-1">Price on Request</div>
                                @endif
                                @if (isset($boat->country))
                                    <div class="fs-sm text-dark opacity-70"><i class="fi-map-pin me-1"></i>{{ $boat->country }}</div>
                                @endif
                                @if (isset($boat->boatInfo) || !empty($boat->boatInfo) || isset($boat->engine) || !empty($boat->engine))
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
                                @endif
                            </div>
                        </div>
                    @endforeach

                    <!-- Sorting + Pagination-->
                    <div class="d-flex align-items-end justify-content-end py-2">
                        <div aria-label="Pagination">
                            <div class="pagination pagination-dark mb-0">
                                {{ $boats->links() }}
                            </div>
                        </div>
                    </div>
                @else
                    <p>No boats found.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
