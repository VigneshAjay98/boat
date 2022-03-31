@extends('layouts.front-layout')

@section('content')
<div class="container step-three-file-container	mt-5 mb-md-4 py-5">
	<!-- Breadcrumb-->
	<nav class="mb-3 pt-md-3" aria-label="Breadcrumb">
		<ol	class="breadcrumb breadcrumb-dark">
			<li	class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
			<li	class="breadcrumb-item"><a href="{{	url('/explore/yachts') }}">Yachts</a></li>
			<li	class="breadcrumb-item active" aria-current="page">{{ $boat->boat_name ?? '' }}</li>
		</ol>
	</nav>
	@if(isset($boat) && !empty($boat))
		<!-- Title + Sharing-->
		<div class="d-sm-flex align-items-end align-items-md-center	justify-content-between	position-relative mb-4"	style="z-index:	1025;">
			<div class="me-3">
				<h1	class="h2 text-dark	mb-md-0"> {{ $boat->boat_name ?? '' }}</h1>
				<div class="d-md-none">
					<div class="d-flex align-items-center mb-3">
						@if (isset($boat->price) && $boat->price != 0)
							<div class="h3 mb-0	text-dark">${{ number_format($boat->price, 2, '.', ',') ?? 'Price on Request' }}</div>
						@else
							<div class="text-primary fw-bold mb-1">Price on Request</div>
						@endif
						@if (isset($boat->boat_condition))
							<div class="text-nowrap	ps-3"><span	class="badge bg-info fs-base me-2">{{ $boat->boat_condition	?? '' }}</span></div>
						@endif
					</div>
					<div class="d-flex flex-wrap align-items-center	text-dark mb-2">
                        @if (isset($boat->length))
						    <div class="text-nowrap	border-end border-light	pe-3 me-3"><i class="fi-dashboard fs-lg	opacity-70 me-2"></i><span class="align-middle">{{ $boat->length.' ft' ?? '' }}</span></div>
						@endif
                        @if (isset($boat->state) && isset($boat->zip_code))
                            <div class="text-nowrap"><i	class="fi-map-pin fs-lg	opacity-70 me-2"></i><span class="align-middle">{{ $boat->state ?? ''}}, {{ $boat->zip_code ?? ''}}</span></div>
                        @endif
                    </div>
				</div>
			</div>
			<!-- <div class="text-nowrap	pt-3 pt-sm-0">
				<button	class="btn btn-icon	btn-translucent-light btn-xs rounded-circle	mb-sm-2" type="button" data-bs-toggle="tooltip"	title="Add to Wishlist"><i class="fi-heart"></i></button>
				<div class="dropdown d-inline-block" data-bs-toggle="tooltip" title="Share">
					<button	class="btn btn-icon	btn-translucent-light btn-xs rounded-circle	ms-2 mb-sm-2" type="button"	data-bs-toggle="dropdown"><i class="fi-share"></i></button>
					<div class="dropdown-menu dropdown-menu-dark dropdown-menu-end my-1">
						<button	class="dropdown-item" type="button"><i class="fi-facebook fs-base opacity-75 me-2"></i>Facebook</button>
						<button	class="dropdown-item" type="button"><i class="fi-twitter fs-base opacity-75	me-2"></i>Twitter</button>
						<button	class="dropdown-item" type="button"><i class="fi-instagram fs-base opacity-75 me-2"></i>Instagram</button>
					</div>
				</div>
			</div> -->
		</div>
		<div class="row">
			<div class="col-md-7">
				<!-- Gallery-->

				{{-- @if (isset($boat->images) && !empty($boat->images)) --}}
					<div class="tns-carousel-wrapper">
						<div class="tns-slides-count text-dark"><i class="fi-image fs-lg me-2"></i>
							<div class="ps-1"><span	class="tns-current-slide fs-5 fw-bold"></span><span	class="fs-5	fw-bold">/</span><span class="tns-total-slides fs-5	fw-bold"></span></div>
						</div>
						<div class="tns-carousel-inner"	data-carousel-options="{&quot;navAsThumbnails&quot;: true, &quot;navContainer&quot;: &quot;#thumbnails&quot;, &quot;gutter&quot;: 12, &quot;responsive&quot;: {&quot;0&quot;:{&quot;controls&quot;:	false},&quot;500&quot;:{&quot;controls&quot;: true}}}">
							@if (isset($boat->images) && count($boat->images) > 0)
								@foreach ( $boat['images'] as $image )
									@php
										$mainImagePath = '';
										$mainImagePath = (isset($image->image_name) && File::exists($image->image_name)) ? $image->image_name : '/front/img/avatars/default-yacht-profile.jpg';
									@endphp
									<div><img class="rounded-3"	src="{{	asset($mainImagePath) }}" alt="Image"></div>
								@endforeach
							@else
								<div><img class="rounded-3"	src="{{	asset('/front/img/avatars/default-yacht-profile.jpg') }}" alt="Image"></div>
							@endif

						</div>
					</div>

					<ul	class="tns-thumbnails" id="thumbnails">
						@if (isset($boat->images) && count($boat->images) > 0)
							@foreach ( $boat['images'] as $image )
							@php
								$mainImagePath = '';
								$mainImagePath = (isset($image->image_name) && File::exists($image->image_name)) ? $image->image_name : '/front/img/avatars/default-yacht-profile.jpg';
							@endphp
								<li	class="tns-thumbnail"><img src="{{ asset($mainImagePath) }}" alt="Thumbnail"></li>
							@endforeach
						@else
							<li	class="tns-thumbnail"><img src="{{ asset('/front/img/avatars/default-yacht-profile.jpg') }}" alt="Thumbnail"></li>
						@endif
						@if (isset($boat->videos) && (count($boat->videos) > 0) )
							@foreach ( $boat->videos as $video )
								<li class="tns-thumbnail"><a class="border d-flex flex-column align-items-center justify-content-center w-100 h-100 bg-faded-light rounded text-dark text-decoration-none" data-iframe="true" data-src="{{ asset($video->video_name) }}" data-bs-toggle="lightbox"><i class="fi-play-circle fs-5"></i><span class="opacity-70 mt-1">Play video</span></a></li>
							@endforeach
						@endif
					</ul>
				{{-- @endif --}}
				<!-- Specs-->
				<div class="py-3 mb-3">
				<h2	class="h4 text-dark	mb-4">Specifications</h2>
				<div class="row	text-dark">
					<div class="col-sm-6 col-md-12 col-lg-6">
						<ul	class="list-unstyled">
							@if (isset($boat->brand) && !empty($boat->brand))
								<li	class="mb-2"><strong>Make:</strong><span class="opacity-70 ms-1 text-capitalize">{{	$boat->brand->name ?? '' }}</span></li>
							@endif
							@if (isset($boat->model))
								<li	class="mb-2"><strong>Model:</strong><span class="opacity-70	ms-1 text-capitalize">{{ $boat->model ?? '' }}</span></li>
							@endif
							@if (isset($boat->year))
								<li	class="mb-2"><strong>Year:</strong><span class="opacity-70 ms-1 text-capitalize">{{	$boat->year ?? '' }}</span></li>
							@endif
							@if (isset($boat->boat_condition))
								<li	class="mb-2"><strong>Condition:</strong><span class="opacity-70	ms-1 text-capitalize">{{ $boat->boat_condition	?? '' }}</span></li>
							@endif
							@if (isset($boat->price) && $boat->price != 0 )
								<li	class="mb-2"><strong>Price:</strong><span class="opacity-70	ms-1">${{ number_format($boat->price, 2, '.', ',') ?? '00.00' }}</span></li>
							@else
								<li	class="mb-2"><strong>Price:</strong><span class="opacity-70	ms-1">Price on Request</span></li>
							@endif
							@if (isset($boat->boat_type))
								<li	class="mb-2"><strong>Type:</strong><span class="opacity-70 ms-1 text-capitalize">{{	$boat->boat_type ?? '' }}</span></li>
							@endif
						</ul>
					</div>
					<div class="col-sm-6 col-md-12 col-lg-6">
						<ul	class="list-unstyled">
							@if (isset($boat->category) && !empty($boat->category) && isset($boat->category->name))
								<li	class="mb-2"><strong>Class:</strong><span class="opacity-70	ms-1 text-capitalize">{{ $boat->category->name	?? '' }}</span></li>
							@endif
							@if (isset($boat->length))
								<li	class="mb-2"><strong>Length:</strong><span class="opacity-70 ms-1">{{ $boat->length.' ft' ?? '' }} </span></li>
							@endif
							@if (isset($boat->engine) && !empty($boat->engine) && isset($boat->engine->fuel_type))
								<li	class="mb-2"><strong>Fuel Type:</strong><span class="opacity-70	ms-1 text-capitalize">{{ $boat->engine->fuel_type ?? '' }}</span></li>
							@endif
							@if (isset($boat->hull_material))
								<li	class="mb-2"><strong>Hull Material:</strong><span class="opacity-70	ms-1 text-capitalize">{{ $boat->hull_material ?? '' }}</span></li>
							@endif
							@if ( isset($boat->state) || isset($boat->country) || isset($boat->zip_code))
								@php
									$loacation = ((isset($boat->state) ? $boat->state.', ': '').(isset($boat->country) ? $boat->country.', ': '').(isset($boat->zip_code) ? $boat->zip_code: ''))
								@endphp
								<li	class="mb-2"><strong>Location:</strong><span class="opacity-70 ms-1 text-capitalize">{{	$loacation ?? '' }}</span></li>
							@endif
						</ul>
					</div>
				</div>
				</div>

				<!-- Features-->
				<h2	class="h4 text-dark	pt-3 mb-4">Features</h2>
				<div class="accordion accordion-dark" id="features">
					<div class="accordion-item">
						<h2	class="accordion-header" id="headingBoatInformation">
						<button	class="accordion-button	collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#boatInformation" aria-expanded="false" aria-controls="boatInformation">Yacht Information</button>
						</h2>
						<div class="accordion-collapse collapse show" id="boatInformation" aria-labelledby="headingBoatInformation" data-bs-parent="#features">
							<div class="accordion-body fs-sm text-dark opacity-70">
								@if (isset($boat->boatInfo) && !empty($boat->boatInfo))
									<ul	class="list-unstyled">
										@if (isset($boat->boatInfo['12_digit_HIN']))
											<li	class="mb-2">
												<div class="row">
													<div class="col-md-4">
														<strong>12 Digit HIN:</strong>
													</div>
													<div class="col-md-8">
														<span class="opacity-70	ms-1">{{ $boat->boatInfo['12_digit_HIN'] ?? '' }}</span>
													</div>
												</div>
											</li>
										@endif
										@if (isset($boat->boatInfo->draft))
											<li	class="mb-2">
												<div class="row">
													<div class="col-md-4">
														<strong>Draft (feet):</strong>
													</div>
													<div class="col-md-8">
														<span class="opacity-70	ms-1">{{ $boat->boatInfo->draft ?? '' }}</span>
													</div>
												</div>
											</li>
										@endif
										@if (isset($boat->boatInfo->bridge_clearance))
											<li	class="mb-2">
												<div class="row">
													<div class="col-md-4">
														<strong>Bridge Clearance (feet):</strong>
													</div>
													<div class="col-md-8">
														<span class="opacity-70	ms-1">{{ $boat->boatInfo->bridge_clearance ?? '' }}</span>
													</div>
												</div>
											</li>
										@endif
										@if (isset($boat->boatInfo->designer))
											<li	class="mb-2">
												<div class="row">
													<div class="col-md-4">
														<strong>Designer:</strong>
													</div>
													<div class="col-md-8">
														<span class="opacity-70	ms-1 text-capitalize">{{ $boat->boatInfo->designer ?? '' }}</span>
													</div>
												</div>
											</li>
										@endif
										@if (isset($boat->boatInfo->head))
											<li	class="mb-2">
												<div class="row">
													<div class="col-md-4">
														<strong>Head:</strong>
													</div>
													<div class="col-md-8">
														<span class="opacity-70	ms-1 text-capitalize">{{ $boat->boatInfo->head ?? '' }}</span>
													</div>
												</div>
											</li>
										@endif
										@if (isset($boat->boatInfo->electrical_system))
											<li	class="mb-2">
												<div class="row">
													<div class="col-md-4">
														<strong>Electrical System:</strong>
													</div>
													<div class="col-md-8">
														<span class="opacity-70	ms-1">{{ $boat->boatInfo->electrical_system ?? '' }}</span>
													</div>
												</div>
											</li>
										@endif
										@if (isset($boat->boatInfo->fuel_capacity))
											<li	class="mb-2">
												<div class="row">
													<div class="col-md-4">
														<strong>Fuel Capacity:</strong>
													</div>
													<div class="col-md-8">
														<span class="opacity-70	ms-1">{{ $boat->boatInfo->fuel_capacity	?? '' }} gal</span>
													</div>
												</div>
											</li>
										@endif
										@if (isset($boat->boatInfo->holding))
											<li	class="mb-2">
												<div class="row">
													<div class="col-md-4">
														<strong>Holding:</strong>
													</div>
													<div class="col-md-8">
														<span class="opacity-70	ms-1">{{ $boat->boatInfo->holding ?? '' }} gal</span>
													</div>
												</div>
											</li>
										@endif
										@if (isset($boat->boatInfo->fresh_water))
										<li	class="mb-2">
											<div class="row">
												<div class="col-md-4">
													<strong>Fresh Water:</strong>
												</div>
												<div class="col-md-8">
													<span class="opacity-70	ms-1">{{ $boat->boatInfo->fresh_water ?? '' }} gal</span>
												</div>
											</div>
										</li>
										@endif
										@if (isset($boat->boatInfo->cruising_speed))
											<li	class="mb-2">
												<div class="row">
													<div class="col-md-4">
														<strong>Cruising Speed:</strong>
													</div>
													<div class="col-md-8">
														<span class="opacity-70	ms-1">{{ $boat->boatInfo->cruising_speed ?? '' }} knots</span>
													</div>
												</div>
											</li>
										@endif
										@if (isset($boat->boatInfo->LOA))
											<li	class="mb-2">
												<div class="row">
													<div class="col-md-4">
														<strong>LOA:</strong>
													</div>
													<div class="col-md-8">
														<span class="opacity-70	ms-1">{{ $boat->boatInfo->LOA ?? '' }} ft</span>
													</div>
												</div>
											</li>
										@endif
										@if (isset($boat->boatInfo->max_speed))
											<li	class="mb-2">
												<div class="row">
													<div class="col-md-4">
														<strong>Max	Speed:</strong>
													</div>
													<div class="col-md-8">
														<span class="opacity-70	ms-1">{{ $boat->boatInfo->max_speed	?? '' }} knots</span>
													</div>
												</div>
											</li>
										@endif
										@if (isset($boat->boatInfo->beam_feet))
											<li	class="mb-2">
												<div class="row">
													<div class="col-md-4">
														<strong>Beam:</strong>
													</div>
													<div class="col-md-8">
														<span class="opacity-70	ms-1">{{ $boat->boatInfo->beam_feet	?? '' }} ft</span>
													</div>
												</div>
											</li>
										@endif
										@if (isset($boat->boatInfo->anchor_type))
											<li	class="mb-2">
												<div class="row">
													<div class="col-md-4">
														<strong>Anchor Type:</strong>
													</div>
													<div class="col-md-8">
														<span class="opacity-70	ms-1">{{ $boat->boatInfo->anchor_type	?? '' }}</span>
													</div>
												</div>
											</li>
										@endif
									</ul>
								@else
									<p>No yacht information found.</p>
								@endif
							</div>
						</div>
					</div>
                    @if (isset($boat->engines) && !empty($boat->engines) && count($boat->engines) > 0)
                        <div class="accordion-item">
                            <h2	class="accordion-header" id="headingEngine">
                            <button	class="accordion-button	collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#boatEngine"	aria-expanded="false" aria-controls="boatEngine">Boat Engine</button>
                            </h2>
                            <div class="accordion-collapse collapse" id="boatEngine" aria-labelledby="headingEngine" data-bs-parent="#features">
                                <div class="accordion-body fs-sm text-dark opacity-70">
                                    @foreach ($boat->engines as $key => $engine)
                                    <h5>Engine {{ $key+1 }}</h5>
                                        <ul	class="list-unstyled">
                                            @if (isset($engine->engine_type))
                                                <li	class="mb-2">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <strong>Engine Type:</strong>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <span class="opacity-70	ms-1 text-capitalize">{{ $engine->engine_type	?? '' }}</span>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endif
                                            @if (isset($engine->fuel_type))
                                                <li	class="mb-2">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <strong>Fuel Type:</strong>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <span class="opacity-70	ms-1 text-capitalize">{{ $engine->fuel_type ?? '' }}</span>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endif
                                            @if (isset($engine->make))
                                                <li	class="mb-2">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <strong>Engine Make:</strong>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <span class="opacity-70	ms-1 text-capitalize">{{ $engine->make ?? '' }}</span>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endif
                                            @if (isset($engine->model))
                                                <li	class="mb-2">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <strong>Engine Model:</strong>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <span class="opacity-70	ms-1 text-capitalize">{{ $engine->model ?? '' }}</span>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endif
                                            @if (isset($engine->horse_power))
                                                <li	class="mb-2">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <strong>Horse Power:</strong>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <span class="opacity-70	ms-1">{{ $engine->horse_power	?? '' }} hp</span>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endif
                                            @if (isset($engine->engine_hours))
                                                <li	class="mb-2">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <strong>Engine Hours:</strong>
                                                        </div>
                                                        <div class="col-md-8">
                                                            <span class="opacity-70	ms-1">{{ $engine->engine_hours ?? '' }} hour</span>
                                                        </div>
                                                    </div>
                                                </li>
                                            @endif
                                        </ul>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
					@if (isset($boat->boatInfo) && !empty($boat->boatInfo) && isset($boat->boatInfo->generator_fuel_type) && isset($boat->boatInfo->generator_size) && isset($boat->boatInfo->generator_hours))
						<div class="accordion-item">
							<h2	class="accordion-header" id="headingEngine">
								<button	class="accordion-button	collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#generatorInformation"	aria-expanded="false" aria-controls="generatorInformation">Generator</button>
							</h2>
							<div class="accordion-collapse collapse" id="generatorInformation" aria-labelledby="headingEngine" data-bs-parent="#features">
								<div class="accordion-body fs-sm text-dark opacity-70">
									<ul	class="list-unstyled">
										@if (isset($boat->boatInfo->generator_fuel_type))
											<li	class="mb-2">
												<div class="row">
													<div class="col-md-4">
														<strong>Fuel Type:</strong>
													</div>
													<div class="col-md-8">
														<span class="opacity-70	ms-1 text-capitalize">{{ $boat->boatInfo->generator_fuel_type	?? '' }}</span>
													</div>
												</div>
											</li>
										@endif
										@if (isset($boat->boatInfo->generator_size))
											<li	class="mb-2">
												<div class="row">
													<div class="col-md-4">
														<strong>Generator Size:</strong>
													</div>
													<div class="col-md-8">
														<span class="opacity-70	ms-1">{{ $boat->boatInfo->generator_size ?? '' }} kW</span>
													</div>
												</div>
											</li>
										@endif
										@if (isset($boat->boatInfo->generator_hours))
											<li	class="mb-2">
												<div class="row">
													<div class="col-md-4">
														<strong>Hours:</strong>
													</div>
													<div class="col-md-8">
														<span class="opacity-70	ms-1">{{ $boat->boatInfo->generator_hours	?? '' }} hour</span>
													</div>
												</div>
											</li>
										@endif
									</ul>
								</div>
							</div>
						</div>
					@endif
				</div>

				<!-- General Description -->
				@if (isset($boat->general_description))
					<div class="pb-4 mb-3">
						<h2 class="h4 text-dark pt-4 mt-3">General Description</h2>
						<p class="text-dark opacity-70 mb-1"> {!! $boat->general_description !!}</p>
					</div>
				@endif
				@if (isset($boat->boatInfo) && !empty($boat->boatInfo))
					<!-- Mechanical Equipment -->
					@if (isset($boat->boatInfo->mechanical_equipment))
						<div class="pb-4 mb-3">
							<h2	class="h4 text-dark	pt-4 mt-3">Mechanical Equipment</h2>
							<p class="text-dark	opacity-70 mb-1"> {!! $boat->boatInfo->mechanical_equipment !!}</p>
						</div>
					@endif

					<!-- Deck and Hull Equipment -->
					@if (isset($boat->boatInfo->deck_hull_equipment))
						<div class="pb-4 mb-3">
							<h2	class="h4 text-dark	pt-4 mt-3">Deck and Hull Equipment</h2>
							<p class="text-dark	opacity-70 mb-1"> {!! $boat->boatInfo->deck_hull_equipment !!}</p>
						</div>
					@endif

					<!-- Navigation Systems -->
					@if (isset($boat->boatInfo->navigation_systems))
						<div class="pb-4 mb-3">
							<h2	class="h4 text-dark	pt-4 mt-3">Navigation Systems</h2>
							<p class="text-dark	opacity-70 mb-1"> {!! $boat->boatInfo->navigation_systems !!}</p>
						</div>
					@endif

					<!-- Additional Equipment -->
					@if (isset($boat->boatInfo->additional_equipment))
						<div class="pb-4 mb-3">
							<h2	class="h4 text-dark	pt-4 mt-3">Additional Equipment</h2>
							{!! $boat->boatInfo->additional_equipment !!}
						</div>
					@endif

					@if (isset($boat->otherInformation->galley_description))
						<div class="pb-4 mb-3">
							<h2 class="h4 text-dark pt-4 mt-3">Galley Equipment</h2>
							<p class="text-dark opacity-70 mb-1"> {!! $boat->otherInformation->galley_description !!}</p>
						</div>
					@endif

					@if (isset($boat->boatInfo) && !empty($boat->boatInfo) && isset($boat->otherInformation->cabin_description) && isset($boat->otherInformation->cabin_berths))
						<div class="pb-4 mb-3">
							<h2 class="h4 text-dark pt-4 mt-3">Cabin Description</h2>
                            @if(isset($boat->boatInfo) && !empty($boat->boatInfo) && isset($boat->boatInfo->cabin_berths))
							    <div class="mb-2">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <strong>Cabin berths :</strong>
                                        </div>
                                        <div class="col-md-9">
                                            <span class="opacity-70	ms-1">{{ $boat->boatInfo->cabin_berths	?? '' }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if(isset($boat->boatInfo) && !empty($boat->boatInfo) && isset($boat->otherInformation->cabin_description))
						    	<p class="text-dark opacity-70 mb-1"> {!! $boat->otherInformation->cabin_description !!}</p>
                            @endif
                        </div>
					@endif
				@endif
			</div>
			<!-- Sidebar-->
			<div class="col-md-5 pt-5	pt-md-0" style="margin-top:	-6rem;">
				<div class="sticky-top pt-5">
					<div class="d-none d-md-block	pt-5">
						@if (isset($boat->boat_condition))
							<div class="d-flex mb-4"><span class="badge	bg-info	fs-base	me-2">{{ $boat->boat_condition ?? '' }}</span></div>
						@endif
						@if (isset($boat->price) && $boat->price != 0)
							<div class="h3 text-dark">{!! $boat->currency_symbol !!}{{ number_format($boat->price, 2, '.',',') ?? 00.00 }}</div>
						@else
							<div class="h3 text-dark">Price on Request</div>

						@endif
						<div class="d-flex align-items-center text-dark	pb-4 mb-2">
							@if (isset($boat->length))
								<div class="text-nowrap border-end border-light pe-3 me-3"><i class="fi-dashboard	fs-lg opacity-70 me-2"></i><span class="align-middle">{{ $boat->length.' ft' ?? '' }}</span></div>
							@endif
							@if (isset($boat->state))
								<div class="text-nowrap"><i class="fi-map-pin	fs-lg opacity-70 me-2"></i><span class="align-middle">{{ $boat->state ?? '' }} {{ $boat->zip_code ?? '' }}</span></div>
							@endif
						</div>
					</div>
					@if (isset($boat->user) && !empty($boat->user))
						<div class="card card-dark card-body mb-1">
							<div class="text-dark mb-2">Yacht Seller</div>
                            @php
                                $shortName = $boat->user->short_full_name;
                            @endphp
							<a	class="d-flex align-items-center text-decoration-none mb-3"	href="javascript:0;"><img class="rounded-circle" width="48" src="{{ url(isset($boat->user->image)	? $boat->user->image :	'')	}}"	width="48" alt="{{ $shortName }}"	onerror="this.onerror=null;this.src='{{	url('front/img/avatars/default-avatar.png')	}}'">
								<div class="ps-2">
									<h5	class="text-dark mb-0">{{ $boat->user->full_name ?? '' }}</h5>
								</div>
							</a>
							<div class="pt-2">
								@if (isset($boat->user->contact_number))
									<button class="btn btn-outline-dark btn-lg px-2 mb-3"	type="button"><i class="fi-phone me-2"></i>{{ Str::substr($boat->user->contact_number, 0, 5) }} ***	**** – reveal</button><br>
								@endif
								<a class="btn btn-primary btn-lg" href="#sendMail"	data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sendMail"><i class="fi-chat-left me-2"></i>Send	message</a>
								<div class="collapse"	id="sendMail">
                                    {{-- method="POST" action="{{ route('email-to-yacht-seller') }}" --}}
									<form class="needs-validation pt-4 send-mail-to-boat-seller" novalidate data-submit="sendMailToSellerBtn1">
                                        @csrf
                                        <input type="hidden" class="seller-email" name="email" value="{{ $boat->user->email }}">
                                        <div class="mb-3">
                                            <textarea class="form-control form-control-dark message-to-seller" name="message" rows="5" placeholder="Write your message"	required></textarea>
                                            <div class="invalid-feedback">Please enter your message.</div>
                                        </div>
                                        <button class="btn btn-outline-primary send-mail-to-seller-btn" id="sendMailToSellerBtn1" type="submit">Submit</button>
									</form>
								</div>
							</div>
						</div>
					@endif
				</div>
			</div>
		</div>
		<!-- Related posts (Carousel)-->
		{{-- <h2	class="h3 text-dark	pt-5 pb-3 mt-md-4">You may be interested in</h2>
		<div class="tns-carousel-wrapper tns-controls-outside-xxl tns-nav-outside tns-carousel-light">
			<div class="tns-carousel-inner" data-carousel-options="{&quot;items&quot;: 3, &quot;responsive&quot;:	{&quot;0&quot;:{&quot;items&quot;:1, &quot;gutter&quot;: 16},&quot;500&quot;:{&quot;items&quot;:2, &quot;gutter&quot;: 18},&quot;900&quot;:{&quot;items&quot;:3, &quot;gutter&quot;: 20}, &quot;1100&quot;:{&quot;gutter&quot;:	24}}}">
				@if (isset($boatSuggestions) || !empty($boatSuggestions))
					@foreach ($boatSuggestions as $boatSuggestion)
						<div>
							<div class="card card-dark card-hover h-100">
								@if (isset($boatSuggestion->images) && !empty($boatSuggestion->images))
									<div class="card-img-top card-img-hover"><a	class="img-overlay"	href="#"></a>
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
										<h3 class="h6	mb-1"><a class="nav-link-dark text-capitalize" href="#">{{ $boatSuggestion->boat_name ?? ''}}</a></h3>
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
		</div> --}}
	@endif
</div>
@endsection
