<div class="offcanvas offcanvas-start offcanvas-collapse bg-light" id="filters-sidebar">
    <div class="offcanvas-header bg-transparent d-flex d-lg-none align-items-center">
        <h2 class="h5 text-dark mb-0">Filters</h2>
        <button class="btn-close btn-close-white" type="button" data-bs-dismiss="offcanvas"></button>
    </div>
    <form id="filterForm" action="{{ url('/explore/yachts') }}">
        <div class="offcanvas-header bg-transparent d-block border-bottom border-dark pt-0 pt-lg-4 px-lg-0">
            {{-- <ul class="nav nav-tabs nav-tabs-dark mb-0">
                <li class="nav-item"><a class="nav-link" href="#">Search New</a></li>
                <li class="nav-item"><a class="nav-link active" href="#">Search Used</a></li>
            </ul> --}}
            <div class="pb-2 mb-2 d-flex justify-content-center">
                <button class="btn btn-dark btn-sm d-block mb-2 me-2">Save Search & Notify Me</button>
            </div>
        </div>
        <input type="hidden" wire:model="viewType" name="view_type" id="viewType">
        <div class="offcanvas-body py-lg-4">
            
            @auth
                <div>
                    <h6 class="h6 text-dark">Show Me</h6>
                    <!-- <div class="form-check form-check-dark">
                        <input class="form-check-input" type="checkbox" id="all_results" name="all_results" value="all_results" wire:model="all_results">
                        <input class="form-check-input" type="radio" name="boat_type" id="my_favorites" value="Power" checked>
                        <label class="form-check-label" for="Power">Power Boats</label>
                        <label class="form-check-label" for="all_results">All Results</label>
                    </div> -->
                    <div class="form-check form-check-dark">
                        <input class="form-check-input" type="radio" name="boat_type" id="my_favorites" value="my_favorites" wire:model="showMe">
                        <label class="form-check-label" for="my_favorites">My Favorites</label>
                    </div>
                    <div class="form-check form-check-dark">
                        <input class="form-check-input" type="radio" name="boat_type" id="my_exclusions" value="my_exclusions" wire:model="showMe">
                        <label class="form-check-label" for="my_exclusions">My Exclusions</label>
                    </div>
                </div>
                <div class="pb-2 mb-2">
                    <p class="fs-sm text-dark">"All Results does not include Exclusions"</p>
                </div>
            @endauth

            <h6 class="h6 text-dark">Type, Make & Model</h6>
            <div class="pb-2 mb-2 ">    
                <div class="pb-2 mb-2">
                    @php
                        $boatTypeConfig = config('yatchfindr.defaults.BOAT_TYPES');
                    @endphp
                    <label class="form-label d-block text-dark fw-bold mb-2 pb-1">Class</label>
                        @foreach($boatTypeConfig as $key => $boatType)
                            @php
                                $lowercase = strtolower($key);
                                $arr = explode(' ', $lowercase);
                                $modelComponent = join('_', $arr);
                            @endphp
                            <div class="form-check form-check-dark">
                                <input wire:model="{{ $modelComponent }}" class="form-check-input" type="checkbox" id="{{ $modelComponent }}" name="{{ $modelComponent }}" value="{{ $key }}">
                                <label class="form-check-label" for="{{ $modelComponent }}">{{ $boatType }}</label>
                            </div>
                        @endforeach
                </div>
                <div class="pb-2 mb-2">
                    <label class="form-label d-block text-dark fw-bold mb-2 pb-1" for="category">Category</label>
                    <select class="form-control form-select form-select-dark mb-2 multi-category" id="category" name="category">
                        <option value="" selected>Any Category</option>
                       
                    </select>
                </div>
                <div class="pb-2 mb-2">     
                    <label class="form-label d-block text-dark fw-bold mb-2 pb-1">Make</label>
                    <select wire:model="selectedBrand" class="form-select form-select-dark mb-2 make-multiple" multiple data-type="select" name="brand">
                        <option value="" selected>Any make</option>
                        @foreach($brands as $brand)
                            <option class="get-models" value="{{ $brand->id }}">{{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- <div class="boat-livewire-model"> -->
                <div class="pb-2 mb-2"> 
                    <label class="form-label d-block text-dark fw-bold mb-2 pb-1">Model</label>
                    <select  wire:model="selectedModel" class="form-control form-select form-select-dark mb-2 model-multiple" multiple id="getModel" name="model_data">
                        <option value="" selected>Any model</option>
                        @foreach($models as $model)
                            <option value="{{ $model->model_name }}">{{ $model->model_name }}</option>
                        @endforeach
                    </select>
                </div> 
                <!-- </div> -->
                <div class="pb-2 mb-2">
                    <button type="button" class="btn btn-secondary btn-sm">Apply</button>
                </div>
            </div>
            
            <div class="pb-2 mb-2">
                <h3 class="h6 text-dark">Yacht Condition</h3>
                <select wire:model="selectedBoatCondition" class="form-select form-select-dark mb-2" name="boat_condition">
                    <option value="" selected disabled>Select Condition</option>
                    <option value="New">New</option>
                    <option value="Used">Used</option>
                    <option value="Salvage Title">Salvage Title</option>
                </select>
            </div>
           <!--  @auth
                <div class="pb-2 mb-2">
                    {{-- <h3 class="h6 text-dark">Show blocked boats</h3> --}}
                    <div class="form-check form-switch">
                        <input class="form-check-input" wire:model="showBlockedBoats" type="checkbox" value="1" name="show_blocked_boats" id="showBlockedBoats">
                        <label class="form-check-label" for="showBlockedBoats">
                        Show blocked yachts
                        </label>
                    </div>
                </div>
            @endauth --> 
            <div class="pb-2 mb-2">
                <h3 class="h6 text-dark">Price ($)</h3>
                <div class="d-flex align-items-center">
                    <div class="w-50 pe-2">
                        <input class="form-control form-control-dark range-slider-value-min" placeholder="Min Price" type="text" wire:model="priceFrom" name="from_price">
                    </div>
                    <div class="text-muted">&mdash;</div>
                    <div class="w-50 ps-2">
                        <input class="form-control form-control-dark range-slider-value-max" placeholder="Max Price" type="text" wire:model="priceTo" name="to_price">
                    </div>
                </div>
            </div>

            <div class="pb-2 mb-2">
                <h3 class="h6 text-dark">Length (ft)</h3>
                <div class="d-flex align-items-center">
                    <div class="w-50 pe-2">
                        <input class="form-control form-control-dark range-slider-value-min" placeholder="Min Length" type="text" wire:model="lengthFrom" name="from_length">
                    </div>
                    <div class="text-muted">&mdash;</div>
                    <div class="w-50 ps-2">
                        <input class="form-control form-control-dark range-slider-value-max" placeholder="Max Length" type="text" wire:model="lengthTo" name="to_length">
                    </div>
                </div>
            </div>

            <div class="pb-2 mb-2">
                <h3 class="h6 text-dark pt-1">Year</h3>
                <div class="d-flex align-items-center">
                    <select wire:model="selectedFromYear" class="form-select form-select-dark w-100" name="year_from">
                        <option value="" selected>From</option>
                        @for($i = date('Y'); $i >= $defaultConfig['YEAR_START']; $i--)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                    <div class="mx-2">&mdash;</div>
                    <select wire:model="selectedToYear" class="form-select form-select-dark w-100" name="year_to">
                        <option value="" selected>To</option>
                        @for($i = date('Y'); $i >= $defaultConfig['YEAR_START']; $i--)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>
            </div>

            <!-- Location Accordion -->
            <div class="accordion" id="locationAccordian">
                <!-- Accordion item -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="locationHeading">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#locationCollapse" aria-expanded="false" aria-controls="locationCollapse">Location</button>
                    </h2>
                    <div class="accordion-collapse collapse" aria-labelledby="locationHeading" data-bs-parent="#locationAccordian" id="locationCollapse">
                        <div class="accordion-body">


                            <ul class="nav nav-tabs d-flex flex-row justify-content-center" role="tablist">
                                <li class="nav-item">
                                    <a href="#zip_tab" class="nav-link" data-bs-toggle="tab" role="tab">
                                        Zip
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#city_state_tab" class="nav-link" data-bs-toggle="tab" role="tab">
                                        City/State
                                    </a>
                                </li>
                            </ul>

                            <!-- Tabs content -->
                            <div class="tab-content">
                                <div class="tab-pane fade" id="zip_tab" role="tabpanel">
                                    <div class="pb-2 mb-2">
                                        <label class="form-label d-block text-dark fw-bold mb-2 pb-1" for="zip_filter">Zip Code</label>
                                        <input class="form-control form-control-dark " type="text" id="zip_filter" name="zip_filter" placeholder="Zip Code" autocomplete="off" autocorrect="off" value="{{ old('zip_filter') }}">
                                    </div>
                                    <div class="pb-2 mb-2">
                                        @php
                                            $milesConfig = config('yatchfindr.defaults.MILES');
                                        @endphp
                                        <label class="form-label d-block text-dark fw-bold mb-2 pb-1">Miles</label>
                                        <select wire:model="selectedMiles" class="form-select form-select-dark mb-2" name="boat_condition">
                                            <option value="" selected disabled>Select Miles</option>
                                            @foreach($milesConfig as $miles)
                                            <option value="{{ $miles }}">{{ $miles }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="city_state_tab" role="tabpanel">
                                    <div class="pb-2 mb-2">
                                        <label class="form-label d-block text-dark fw-bold mb-2 pb-1">State List</label>
                                        <select wire:model="selectedState" class="form-select form-select-dark mb-2 state-multiple" multiple>
                                            <option value="" selected>All States</option>
                                        </select>
                                    </div>
                                    <div class="pb-2 mb-2">
                                        <label class="form-label d-block text-dark fw-bold mb-2 pb-1">City List</label>
                                        <select wire:model="selectedCity" class="form-select form-select-dark mb-2 city-multiple" data-type="select" name="brand">
                                            <option value="" selected disabled>Select City</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Advanced Search Accordion -->
            <div class="accordion" id="advancedSearchAccordian">
                <!-- Accordion item -->
                <div class="accordion-item">
                    <h2 class="accordion-header" id="advancedHeading">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#advancedCollapse" aria-expanded="false" aria-controls="advancedCollapse">Advanced Search</button>
                    </h2>
                    <div class="accordion-collapse collapse" aria-labelledby="advancedHeading" data-bs-parent="#advancedSearchAccordian" id="advancedCollapse">
                        <div class="accordion-body">

                            <div class="pb-2 mb-2">
                                <label class="form-label d-block text-dark fw-bold mb-2 pb-1" for="engine_count">Engines</label>
                                <input class="form-control form-control-dark " type="number" id="engine_count" name="engine_count" placeholder="Engines" autocomplete="off" autocorrect="off" min="1" value="{{ old('engine_count') ?? 1 }}" wire:model="engineCount">
                            </div>
                            
                            <div class="pb-2 mb-2">
                                @php
                                    $engineTypes = config('yatchfindr.defaults.ENGINE_TYPES');
                                @endphp
                                <label class="form-label d-block text-dark fw-bold mb-2 pb-1">Engine Type</label>
                                <select  wire:model="selectedEngineType" class="form-control form-select form-select-dark mb-2"  id="getEngineType" name="getEngineType">
                                    <option value="" selected>All Engine Types</option>
                                    @foreach($engineTypes as $engineType)
                                        <option value="{{ $engineType }}">{{ $engineType }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="pb-2 mb-2">
                                @php
                                    $engineFuels = config('yatchfindr.defaults.FUEL_TYPES');
                                @endphp
                                <label class="form-label d-block text-dark fw-bold mb-2 pb-1">Engine Fuel</label>
                                <select  wire:model="selectedEngineFuel" class="form-control form-select form-select-dark mb-2"  id="getEngineFuel" name="getEngineFuel">
                                    <option value="" selected>All Fuel Types</option>
                                    @foreach($engineFuels as $engineFuel)
                                        <option value="{{ $engineFuel }}">{{ $engineFuel }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="pb-2 mb-2">
                                <label class="form-label d-block text-dark fw-bold mb-2 pb-1">Hull Type</label>
                                <select  wire:model="selectedEngineFuel" class="form-control form-select form-select-dark mb-2"  id="getHullType" name="getHullType">
                                    <option value="" selected>All Hull Types</option>
                                    @foreach($hullMaterials as $hullMaterial)
                                        <option value="{{ $hullMaterial->name }}">{{ $hullMaterial->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="pb-2 mb-2">
                                <label class="form-label d-block text-dark fw-bold mb-2 pb-1" for="search_beam">Beam</label>
                                <input class="form-control form-control-dark " type="number" id="search_beam" name="search_beam" placeholder="Beam" autocomplete="off" autocorrect="off" value="{{ old('search_beam') }}" wire:model="beam">
                            </div>

                            <div class="pb-2 mb-2">
                                <label class="form-label d-block text-dark fw-bold mb-2 pb-1" for="search_draft">Draft</label>
                                <input class="form-control form-control-dark " type="number" id="search_draft" name="search_draft" placeholder="Draft" autocomplete="off" autocorrect="off" value="{{ old('search_draft') }}" wire:model="draft">
                            </div>

                            <div class="pb-2 mb-2">
                                <label class="form-label d-block text-dark fw-bold mb-2 pb-1" for="search_bridge">Air Draft/Bridge Clearance</label>
                                <input class="form-control form-control-dark " type="number" id="search_bridge" name="search_bridge" placeholder="Air Draft/Bridge Clearance" autocomplete="off" autocorrect="off" value="{{ old('search_bridge') }}" wire:model="bridgeClearance">
                            </div>

                            <div class="pb-2 mb-2">
                                <label class="form-label d-block text-dark fw-bold mb-2 pb-1" for="search_LOA">Max LOA</label>
                                <input class="form-control form-control-dark " type="number" id="search_LOA" name="search_LOA" placeholder="Max LOA" autocomplete="off" autocorrect="off" value="{{ old('search_LOA') }}" wire:model="LOA">
                            </div>

                            <div class="pb-2 mb-2">
                                <div class="form-check form-check-dark">
                                    <input class="form-check-input" type="checkbox" id="has_head" name="has_head" value="has_head" wire:model="selectedHead">
                                    <label class="form-check-label" for="has_head">Has Head</label>
                                </div>
                                <div class="form-check form-check-dark">
                                    <input class="form-check-input" type="checkbox" id="has_generator" name="has_generator" value="has_generator" wire:model="selectedGenerator">
                                    <label class="form-check-label" for="has_generator">Has Generator</label>
                                </div>
                                <div class="form-check form-check-dark">
                                    <input class="form-check-input" type="checkbox" id="has_cabin" name="has_cabin" value="has_cabin" wire:model="selectedCabin">
                                    <label class="form-check-label" for="has_cabin">Has Cabin</label>
                                </div>
                                <div class="form-check form-check-dark">
                                    <input class="form-check-input" type="checkbox" id="has_galley" name="has_galley" value="has_galley" wire:model="selectedGalley">
                                    <label class="form-check-label" for="has_galley">Has Galley</label>
                                </div>
                            </div>

                            <div class="pb-2 mb-2">
                                <h6 class="h6 text-dark">For Sale by</h6>
                                <div class="form-check form-check-dark">
                                    <input class="form-check-input" type="checkbox" id="dealer_private">
                                    <label class="form-check-label" for="dealer_private">Dealers & Private Sellers</label>
                                </div>
                                <div class="form-check form-check-dark">
                                    <input class="form-check-input" type="checkbox" id="dealers">
                                    <label class="form-check-label" for="dealers">Dealers</label>
                                </div>
                                <div class="form-check form-check-dark">
                                    <input class="form-check-input" type="checkbox" id="private_sellers">
                                    <label class="form-check-label" for="private_sellers">Private Sellers</label>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>




           
            <!-- <div class="pb-4 mb-2">
                <h3 class="h6 text-dark">Price</h3>
                <div class="range-slider range-slider-dark mb-3" data-start-min="25000" data-start-max="65000" data-min="4000" data-max="100000" data-step="1000">
                    <div class="range-slider-ui"></div>
                    <div class="d-flex align-items-center">
                        <div class="w-50 pe-2">
                            <input class="form-control form-control-dark range-slider-value-min" type="text">
                        </div>
                        <div class="text-muted">&mdash;</div>
                        <div class="w-50 ps-2">
                            <input class="form-control form-control-dark range-slider-value-max" type="text">
                        </div>
                    </div>
                </div>
                <div class="form-check form-switch form-switch-dark">
                    <input class="form-check-input" type="checkbox" id="negotiated-price">
                    <label class="form-check-label fs-sm" for="negotiated-price">Negotiated price</label>
                </div>
            </div> -->

            <!-- @if($defaultConfig['FUEL_TYPES'])
            <div class="pb-4 mb-2">
                <h3 class="h6 text-dark">Engine Types</h3>
                @foreach($defaultConfig['ENGINE_TYPES'] as $k => $engine)
                    <div class="form-check form-check-dark">
                        <input class="form-check-input" type="checkbox" id="{{ $engine }}">
                        <label class="form-check-label fs-sm" for="awd">{{ $engine }}</label>
                    </div>
                @endforeach
            </div>
            @endif -->

            <!-- @if($defaultConfig['FUEL_TYPES'])
                <div class="pb-4 mb-2">
                    <h3 class="h6 text-dark">Fuel Type</h3>
                    @foreach($defaultConfig['FUEL_TYPES'] as $k => $fuelType)
                        <div class="form-check form-check-dark">
                            <input class="form-check-input" type="checkbox" id="{{$fuelType}}">
                            <label class="form-check-label fs-sm" for="diesel">{{$fuelType}}</label>
                        </div>
                    @endforeach
                </div>
            @endif -->

            <!-- <div class="pb-4 mb-2">
                <h3 class="h6 text-dark pt-1">Mileage</h3>
                <div class="d-flex align-items-center">
                    <input class="form-control form-control-dark w-100" type="number" min="0" step="500" placeholder="From">
                    <div class="mx-2">&mdash;</div>
                    <input class="form-control form-control-dark w-100" type="number" min="0" step="500" placeholder="To">
                </div>
            </div> -->
        </div>
    </form>
</div>

<style>

.select2-results__option .wrap:before{
    font-family:fontAwesome;
    color:#999;
    content:"\f096";
    width:25px;
    height:25px;
    padding-right: 10px;
    
}
.select2-results__option[aria-selected=true] .wrap:before{
    content:"\f14a";
}

/* not required css */

.select2-multiple, .select2-multiple2
{
  width: 50%
}

</style>
