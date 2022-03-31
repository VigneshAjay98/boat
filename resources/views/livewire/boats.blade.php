<div class="container mt-5 mb-md-4 py-5">
    <div class="row py-md-1">
        <div class="col-lg-3 pe-xl-4">
            @include('livewire.side-bar')
        </div>
        <div class="col-lg-9">
            <nav class="mb-3 pt-md-2 pt-lg-4" aria-label="Breadcrumb">
                <ol class="breadcrumb breadcrumb-dark">
                    <li class="breadcrumb-item"><a href="{{ url('') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Yacht Listings</li>
                </ol>
            </nav>

            <div class="livewire-loading d-none">Loading&#8230;</div>

            <div class="d-flex align-items-center justify-content-between pb-4 mb-2">
                <h1 class="text-dark me-3 mb-0">Yacht Listings</h1>
                <div class="text-dark"><span class="align-middle">{{ (count($boats) > 0) ? "Viewing ".$boats->count()." of ".$boats->total()." Yachts" : "0 Yachts"}} </span></div>
            </div>
            @if(count($boats) > 0)
                <div class="d-sm-flex align-items-center justify-content-between pb-4 mb-2">
                    <div class="d-flex align-items-center me-sm-4">
                        <label class="fs-sm text-dark me-2 pe-1 text-nowrap" for="sorting1"><i class="fi-arrows-sort mt-n1 me-2"></i>Sort by:</label>
                        <select wire:model="sort" class="form-select form-select-dark form-select-sm me-sm-4" id="sorting1">
                            <option value="boats.created_at-desc">Newest First</option>
                            <option value="boats.created_at-asc">Oldest First</option>
                            <option value="boats.created_at-asc">Distance: Closest</option>
                            <option value="boats.created_at-asc">Distance: Farthest</option>
                            <option value="boats.year-desc">Year: Newest</option>
                            <option value="boats.year-asc">Year: Oldest</option>
                            <option value="boats.length-desc">Length: Longest to Shortest</option>
                            <option value="boats.length-asc">Length: Shortest to Longest</option>
                            <option value="boats.price-asc">Price: Low - High</option>
                            <option value="boats.price-desc">Price: High - Low</option>
                        </select>
                    </div>
                    {{-- <div class="d-none d-sm-flex">
                        <a class="nav-link nav-link-dark px-2 active catalog-livewires-view" href="javascript:0;" data-bs-toggle="tooltip" title="List view"><i class="fi-list"></i></a>
                        <a class="nav-link nav-link-dark px-2 grid-livewires-view" href="javascript:0;" data-bs-toggle="tooltip" title="Grid view"><i class="fi-grid"></i></a>
                    </div> --}}
                </div>

                <!-- Pagination -->
                <div class="d-flex align-items-end justify-content-center py-2">
                    <div aria-label="Pagination">
                        <div class="pagination pagination-dark mb-0">
                            {{ $boats->links() }}
                        </div>
                    </div>
                </div>

                <div  class="catalog-livewires-card">
                    @foreach($boats as $boat)
                        <div class="card card-dark card-hover card-horizontal mb-4">

                                <div class="tns-carousel-wrapper card-img-top card-img-hover">
                                    <a class="img-overlay" href="{{ url('explore/yacht/'.$boat->slug) }}"></a>
                                    <div class="position-absolute start-0 top-0 pt-3 ps-3"><span class="d-table badge bg-info">{{ $boat->boat_condition ?? '' }}</span></div>

                                    <div class="yacht-list-options" style="">
                                        <div class="content-overlay end-0 top-0 pt-3 pe-3">
                                            <button class="btn btn-icon btn-light btn-xs text-primary rounded-circle block-boat" data-bs-toggle="tooltip" data-bs-placement="left" title="Exclude this yacht" wire:click="addToExclusion({{ $boat->id }})"><i class="fas fa-ban fs-sm"></i></button>
                                        </div>
                                        <div class="content-overlay end-30 top-0 pt-3 pe-3">
                                            <button class="btn btn-icon btn-light btn-xs text-primary rounded-circle favorite-boat-button yacht-list-favorite" data-bs-toggle="tooltip" data-bs-placement="left" title="Add to favorites" wire:click="addToFavorites({{ $boat->id }})"><i class="fi-heart"></i></button>
                                        </div>
                                    </div>

                                    <div class="tns-carousel-inner position-absolute top-0 h-100 livewire-carousel">
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
                                    $boatAllDetails = ((isset($boat->year))? ($boat->year.'/ '): '' ).((!empty($boat->brand) && isset($boat->brand) && isset($boat->brand->name))? ($boat->brand->name):'').((isset($boat->model))? ('/ '.$boat->model):'');

                                    $boatLocation = ( (isset(Auth()->user()->city)) ? (Auth()->user()->city) : '' ).( (isset($boat->state)) ? ", ".($boat->state) : '' );
                                @endphp
                                <a class="nav-link-dark text-decoration-none" href="{{ url('explore/yacht/'.$boat->slug) }}">
                                    <div class="fs-sm text-dark pb-1 text-capitalize">{{ $boat->id }} {{ $boatAllDetails ?? '' }} </div>
                                </a>
                                <a class="nav-link-dark text-decoration-none" href="{{ url('explore/yacht/'.$boat->slug) }}">
                                    <h3 class="h6 mb-1">{{ $boat->boat_name }}</h3>
                                </a>
                                <a class="nav-link-dark text-decoration-none" href="{{ url('explore/yacht/'.$boat->slug) }}">
                                    <div class="fs-sm text-dark pb-1">Length:&nbsp;<span class="fs-sm text-dark opacity-70">{{ $boat->length.' ft' ?? '-'}}</span></div>
                                </a>
                                @if (isset($boat->price) && $boat->price != 0)
                                    <a class="nav-link-dark text-decoration-none" href="{{ url('explore/yacht/'.$boat->slug) }}">
                                        <div class="text-primary fw-bold mb-1">{!! $boat->currency_symbol !!}{{ number_format($boat->price, 2, '.', ',') ?? '00.00' }}</div>
                                    </a>
                                @else
                                    <a class="nav-link-dark text-decoration-none" href="{{ url('explore/yacht/'.$boat->slug) }}">
                                        <div class="text-primary fw-bold mb-1">Price on Request</div>
                                    </a>
                                @endif
                                @if (isset($boat->country) && ($boat->country != 'United States'))
                                    <a class="nav-link-dark text-decoration-none" href="{{ url('explore/yacht/'.$boat->slug) }}">
                                        <div class="fs-sm text-dark opacity-70"><i class="fi-map-pin me-1"></i>{{ $boat->country }}</div>
                                        <div class="fs-sm text-dark opacity-70">
                                            {!! $boatLocation !!}
                                        </div>
                                    </a>
                                @else
                                    <a class="nav-link-dark text-decoration-none" href="{{ url('explore/yacht/'.$boat->slug) }}">
                                        <div class="fs-sm text-dark opacity-70"><i class="fi-map-pin me-1"></i>{!! $boatLocation !!}</div>
                                    </a>
                                @endif
                                <a class="nav-link-dark text-decoration-none" href="{{ url('explore/yacht/'.$boat->slug) }}">
                                    <div class="fs-sm text-dark opacity-70">Brokerage info:&nbsp;</div>
                                </a>
                                <!-- <a href="{{ url('explore/yacht/'.$boat->slug) }}" class="stretched-link"></a> -->
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- <div class="row grid-livewires-card d-none">
                    @foreach($boats as $boat)
                        <!-- Item-->
                        <div class="col-sm-6 mb-4">
                            <div class="card card-dark card-hover h-100">
                                <div class="tns-carousel-wrapper card-img-top card-img-hover">
                                    <a class="img-overlay" href="{{ url('explore/yacht/'.$boat->slug) }}"></a>
                                    <div class="position-absolute start-0 top-0 pt-3 ps-3"><span class="d-table badge bg-info">{{ $boat->boat_condition }}</span></div>
                                    @auth
                                        <div class="content-overlay end-0 top-0 pt-3 pe-3">
                                            <form action="{{ url('block-yacht') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="boat_slug" value={{ $boat->slug }}>
                                                <button class="btn btn-icon btn-light btn-xs text-primary rounded-circle"  type="submit" data-bs-toggle="tooltip" data-bs-placement="left" title="Block this yacht"><i class="fi-eye-off"></i></button>
                                            </form>
                                        </div>
                                    @endauth
                                    <div class="tns-carousel-inner">
                                        @if (isset($boat->images) && count($boat->images) > 0)
                                            @foreach ($boat->images as $image)
                                                @php
                                                    $mainImagePath = '';
                                                    $mainImagePath = (isset($image->image_name) && File::exists($image->image_name)) ? $image->image_name : '/front/img/avatars/default-yacht-profile.jpg';
                                                @endphp
                                                <img src="{{ asset($mainImagePath) }}" alt="Image" />
                                            @endforeach
                                        @else
                                            <img src="{{ asset('/front/img/avatars/default-yacht-profile.jpg') }}" alt="Image" />
                                        @endif
                                    </div>
                                </div>
                                <div class="card-body">
                                    @if (isset($boat->year))
                                        <div class="d-flex align-items-center justify-content-between pb-1">
                                            <span class="fs-sm text-dark me-3">{{ $boat->year ?? '' }}</span>
                                        </div>
                                    @endif
                                    <h3 class="h6 mb-1"><a class="nav-link-dark" href="{{ url('explore/yacht/'.$boat->slug) }}">{{ $boat->boat_name ?? ''  }}</a></h3>
                                    @if (isset($boat->price) && $boat->price != 0)
                                        <div class="text-primary fw-bold mb-1">${{ number_format($boat->price, 2, '.',',') ?? '00.00' }}</div>
                                    @else
                                        <div class="text-primary fw-bold mb-1">Price on Request</div>
                                    @endif
                                    @if (isset($boat->country))
                                        <div class="fs-sm text-dark opacity-70"><i class="fi-map-pin me-1"></i>{{ $boat->country ?? '' }}</div>
                                    @endif
                                </div>
                                @if (isset($boat->boatInfo) || !empty($boat->boatInfo) || isset($boat->engine) || !empty($boat->engine))
                                    <div class="card-footer border-0 pt-0">
                                        <div class="border-top border-dark pt-3">
                                            <div class="row g-2">
                                                @if (isset($boat->boatInfo) && !empty($boat->boatInfo) && isset($boat->boatInfo->fuel_capacity))
                                                    <div class="col me-sm-1">
                                                        <div class="bg-dark rounded text-center w-100 h-100 p-2"><i class="fi-dashboard d-block h4 text-white mb-0 mx-center"></i><span class="fs-xs text-white">{{ $boat->boatInfo->fuel_capacity }} gal</span></div>
                                                    </div>
                                                @endif
                                                @if (isset($boat->engine) && !empty($boat->engine) && isset($boat->engine->engine_type))
                                                    <div class="col me-sm-1">
                                                        <div class="bg-dark rounded text-center w-100 h-100 p-2"><i class="fi-gearbox d-block h4 text-white mb-0 mx-center "></i><span class="fs-xs text-white text-capitalize">{{ $boat->engine->engine_type }}</span></div>
                                                    </div>
                                                @endif
                                                @if (isset($boat->engine) && !empty($boat->engine) && isset($boat->engine->fuel_type))
                                                    <div class="col">
                                                        <div class="bg-dark rounded text-center w-100 h-100 p-2"><i class="fi-petrol d-block h4 text-white mb-0 mx-center "></i><span class="fs-xs text-white text-capitalize">{{ $boat->engine->fuel_type }}</span></div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div> --}}

                <!-- Pagination -->
                <div class="d-flex align-items-end justify-content-center py-2">
                    <div aria-label="Pagination">
                        <div class="pagination pagination-dark mb-0">
                            {{ $boats->links() }}
                        </div>
                    </div>
                </div>
            @else
                <div class="d-flex align-items-center justify-content-between py-2">
                    <div class="d-flex align-items-center me-sm-4">
                        <p>No yacht found.</p>
                    </div>
                </div>
            @endif
        </div>

        <!-- Listing page Ads -->
        <!-- <div class="col-lg-3">
        </div> -->
    </div>
</div>