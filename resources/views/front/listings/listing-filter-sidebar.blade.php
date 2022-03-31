<div class="offcanvas offcanvas-start offcanvas-collapse bg-light" id="filters-sidebar">
    <div class="offcanvas-header bg-transparent d-flex d-lg-none align-items-center">
        <h2 class="h5 text-dark mb-0">Filters</h2>
        <button class="btn-close btn-close-white" type="button" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-header bg-transparent d-block border-bottom border-dark pt-0 pt-lg-4 px-lg-0">
        <ul class="nav nav-tabs nav-tabs-dark mb-0">
            <li class="nav-item"><a class="nav-link" href="#">Search New</a></li>
            <li class="nav-item"><a class="nav-link active" href="#">Search Used</a></li>
        </ul>
    </div>
    <div class="offcanvas-body py-lg-4">
        <form id="filterForm" action="{{ url('/explore/yachts') }}">
            <div class="pb-2 mb-2">
                <h3 class="h6 text-dark">Location</h3>
                <select class="form-select form-select-dark mb-2">
                    <option value="" disabled selected>Select location</option>
                    <option value="Chicago">Chicago</option>
                    <option value="Dallas">Dallas</option>
                    <option value="Los Angeles">Los Angeles</option>
                    <option value="New York">New York</option>
                    <option value="San Diego">San Diego</option>
                </select>
            </div>
            <div class="pb-2 mb-2">
                <h3 class="h6 text-dark pt-1">Year</h3>
                <div class="d-flex align-items-center">
                    <select class="form-select form-select-dark w-100 filter" name="year_from">
                        <option value="" disabled selected>From</option>
                        @for($i = date('Y'); $i >= $defaultConfig['YEAR_START']; $i--)
                            <option value="{{ $i }}" {{ ($request->year_from == $i) ? 'selected' : ''  }} >{{ $i }}</option>
                        @endfor
                    </select>
                    <div class="mx-2">&mdash;</div>
                    <select class="form-select form-select-dark w-100 filter" name="year_to">
                        <option value="" disabled selected>To</option>
                        @for($i = date('Y'); $i >= $defaultConfig['YEAR_START']; $i--)
                            <option value="{{ $i }}" {{ ($request->year_to == $i) ? 'selected' : ''  }} >{{ $i }}</option>
                        @endfor
                    </select>
                </div>
            </div>

            <div class="pb-2 mb-2">
                <h3 class="h6 text-dark">Make &amp; Model</h3>
                <select class="form-select form-select-dark mb-2 model-select filter" data-model-id='#modelSelect' data-type="select" name="brand">
                    <option value="" disabled selected>Any make</option>
                    @foreach($brands as $brand)
                        <option class="get-models" value="{{ $brand->slug }}" {{ ($request->brand == $brand->slug) ? 'selected' : ''  }} >{{ $brand->name }}</option>
                    @endforeach
                </select>
                <select class="form-select form-select-dark mb-2 models-list filter livewire-model-select2" id="modelSelect" name="model">
                    <option value="" disabled selected>Any model</option>
                    @foreach($models as $model)
                        <option value="{{ $model->model_name }}" {{ ($request->model == $model->model_name) ? 'selected' : ''  }}>{{ $model->model_name }}</option>
                    @endforeach
                </select>
                <select class="form-select form-select-dark mb-2 filter" name="hull_material">
                    <option value="" disabled selected>Any Hull Material</option>
                    @foreach($hullMaterials as $hullMaterial)
                        <option value="{{ $hullMaterial->name }}" {{ ($request->hull_material == $hullMaterial->name) ? 'selected' : ''  }}>{{ $hullMaterial->name }}</option>
                    @endforeach
                </select>
                <select class="form-select form-select-dark mb-2 filter" name="category">
                    <option value="" disabled selected>Any category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ ($request->category == $category->id) ? 'selected' : ''  }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="pb-4 mb-2">
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
            </div>

            @if($defaultConfig['FUEL_TYPES'])
            <div class="pb-4 mb-2">
                <h3 class="h6 text-dark">Engine Types</h3>
                @foreach($defaultConfig['ENGINE_TYPES'] as $k => $engine)
                    <div class="form-check form-check-dark">
                        <input class="form-check-input" type="checkbox" id="{{ $engine }}">
                        <label class="form-check-label fs-sm" for="awd">{{ $engine }}</label>
                    </div>
                @endforeach
            </div>
            @endif

            @if($defaultConfig['FUEL_TYPES'])
                <div class="pb-4 mb-2">
                    <h3 class="h6 text-dark">Fuel Type</h3>
                    @foreach($defaultConfig['FUEL_TYPES'] as $k => $fuelType)
                        <div class="form-check form-check-dark">
                            <input class="form-check-input" type="checkbox" id="{{$fuelType}}">
                            <label class="form-check-label fs-sm" for="diesel">{{$fuelType}}</label>
                        </div>
                    @endforeach
                </div>
            @endif

            <div class="pb-4 mb-2">
                <h3 class="h6 text-dark pt-1">Mileage</h3>
                <div class="d-flex align-items-center">
                    <input class="form-control form-control-dark w-100" type="number" min="0" step="500" placeholder="From">
                    <div class="mx-2">&mdash;</div>
                    <input class="form-control form-control-dark w-100" type="number" min="0" step="500" placeholder="To">
                </div>
            </div>
        </form>
    </div>
</div>
