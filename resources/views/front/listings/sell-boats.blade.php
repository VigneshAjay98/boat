@extends('layouts.front-layout')

@section('content')
<div class="container step-one-file-container mt-5 mb-md-4 py-5">
	<div class="row">
	  	<!-- Page content-->
	  	<div class="col-lg-8">
		    <!-- Breadcrumb-->
		    <nav class="mb-3 pt-md-3" aria-label="Breadcrumb">
		      	<ol class="breadcrumb breadcrumb-dark">
		        	<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
		        	<li class="breadcrumb-item active" aria-current="page">Sell Your Yacht</li>
		      	</ol>
		    </nav>
		    <!-- Title-->
		    <div class="mb-4">
		      	<h1 class="h2 text-dark mb-0">Sell Your Yacht</h1>
	      	</div>

	      	<form method="post" action="" enctype="multipart/form-data" autocomplete="off">
			    <!-- Basic info-->
			    <section class="card card-dark card-body border-0 shadow-sm p-4 mb-4" id="basicInfo">
			      	<h2 class="h4 text-dark mb-4"><i class="fi-info-circle text-primary fs-5 mt-n1 me-2"></i>Basic info</h2>
			      	<div class="mb-3">
			        	<label class="form-label text-dark" for="boatYear">Yacht Year <span class="text-danger">*</span></label>
			        	<input class="form-control form-control-dark" type="number" id="boatYear" placeholder="Year" autocomplete="off" autocorrect="off" min="1900" max="{{ \Carbon\Carbon::now()->format('Y') }}" required>
			        	@if ($errors->has('boatYear'))
							<div class="error text-danger">
								{{ $errors->first('boatYear') }}
							</div>
						@endif
			      	</div>
			      	<div class="row">
			        	<div class="col-sm-6 mb-3">
			          		<label class="form-label text-dark" for="boatCondition">Yacht condition <span class="text-danger">*</span></label>
					  		<input class="form-control form-control-dark" type="text" id="boatCondition" name="boatCondition" placeholder="Yacht Condition" autocomplete="off" autocorrect="off" required>
					  		@if ($errors->has('boatCondition'))
								<div class="error text-danger">
									{{ $errors->first('boatCondition') }}
								</div>
							@endif
		        		</div>
			      	</div>
		      		<label class="form-label text-dark" for="selectBrand">Select Make<span class="text-danger">*</span></label>
		          	<select class="form-select form-select-dark select-brand" id="selectBrand" name="selectBrand">
			            <option value="" disabled>Select make</option>
			            @if(isset($brands))
				            @foreach($brands as $brand)
					            <option value="{{ $brand->uuid }}">{{ $brand->name }}</option>
				            @endforeach
			            @endif
			        </select>
			        @if ($errors->has('selectBrand'))
						<div class="error text-danger">
							{{ $errors->first('selectBrand') }}
						</div>
					@endif
			      	<div class="row">
			            <div class="col-lg-6 col-xs-6 mb-3">
			          		<label class="form-label text-dark" for="boatModel">Model<span class="text-danger">*</span></label>
			          		<select class="form-select boat-model" id="boatModel" aria-label="Boat Model" name="boatModel" autocomplete="off">
			          			<option value="" selected disabled>-- Select Model --</option>
								@if (isset($models))
									@foreach ($models as $model)
										<option class="text-capitalize" value="{{ $model->uuid }}">{{ $model->model_name }}</option>
									@endforeach
								@endif
							</select>
							@if ($errors->has('boatModel'))
							<div class="error text-danger">
								{{ $errors->first('boatModel') }}
							</div>
							@endif
				        </div>
			      	</div>
			    </section>
			    <!-- Details 1-->
			    <section class="card card-dark card-body border-0 shadow-sm p-4 mb-4" id="details1">
			      	<h2 class="h4 text-dark mb-4"><i class="fi-car text-primary fs-5 mt-n1 me-2"></i>Yacht information</h2>
			      	<div class="row pb-2">
			      	<div class="row d-flex justify-content-center">
				        <div class="col-sm-6 mb-3 d-flex">
				        	@php
				        		$typeCount = 0;
				        	@endphp
				        	@foreach($boat_types as $boat_type)
				        	@php
				        		$typeCount++;
				        	@endphp
				          	<div class="form-check form-check-dark mx-auto">
				          		<label class="form-check-label text-capitalize" for="boatType{{ $typeCount }}">{{ $boat_type->name }}</label>
			                	<input class="form-check-input" type="radio" id="boatType{{ $typeCount }}" name="boat_type" data-uuid="{{ $boat_type->uuid }}">
			                	@if ($errors->has('boat_type'))
									<div class="error text-danger">
										{{ $errors->first('boat_type') }}
									</div>
								@endif
			              	</div>
			              	@endforeach
				        </div>
				    </div>
			        <div class="col-sm-6 mb-3">
			          	<label class="form-label text-dark" for="category">Category <span class="text-danger">*</span></label>
			          	<select class="form-select form-select-dark" id="category" name="category" disabled>
			            	<option value="" selected disabled>-- Select Category --</option>
			          	</select>
			          	@if ($errors->has('category'))
							<div class="error text-danger">
								{{ $errors->first('category') }}
							</div>
						@endif
			        </div>
			        <div class="col-sm-6 mb-3">
			          	<label class="form-label text-dark" for="hullMaterial">Hull Material <span class="text-danger">*</span></label>
			          	<select class="form-select form-select-dark" id="hullMaterial" name="hullMaterial">
			            	<option value="" selected disabled>-- Select Hull Material --</option>
			            	@foreach($hull_materials as $hull_material)
			            		<option value="{{ $hull_material->uuid }}">{{ $hull_material->name }}</option>
			            	@endforeach
			          	</select>
			          	@if ($errors->has('hullMaterial'))
							<div class="error text-danger">
								{{ $errors->first('hullMaterial') }}
							</div>
						@endif
			        </div>
			        <div class="col-md-3 col-sm-6 mb-3">
			          <label class="form-label text-dark" for="length">Length <span class="text-danger">*</span></label>
			          <input class="form-control form-control-dark" type="number" id="length" name="length" placeholder="Length">
			          	@if ($errors->has('length'))
							<div class="error text-danger">
								{{ $errors->first('length') }}
							</div>
						@endif
			        </div>

			        <div class="accordion accordion-dark" id="extras">
		              	<div class="accordion-item">
		                	<h2 class="accordion-header" id="headingEngines">
		                  		<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#engineAccordian" aria-expanded="false" aria-controls="engineAccordian">Engines (optional)</button>
		                	</h2>
		                	<div class="accordion-collapse collapse" id="engineAccordian" aria-labelledby="headingEngines" data-bs-parent="#extras" style="">
			                  	<div class="accordion-body fs-sm text-dark opacity-70">
			                  		<div id="engineSection1" class="engineSection pb-2">
								      	<div class="row">
								      		<div class="col-sm-6 mb-3">
									        	<label class="form-label text-dark" for="engineType">Select Engine Type<span class="text-danger">*</span></label>
									          	<select class="form-select form-select-dark select-engine" id="engineType" name="engineType">
										            <option value="" selected disabled>-- Select Engine Type --</option>
												    <option value="electric">Electric</option>
												    <option value="inboard">Inboard</option>
												    <option value="outboard">Outboard</option>
												    <option value="other">Other</option>
										        </select>
											</div>
											<div class="col-lg-6 col-xs-6 mb-3">
									        	<label class="form-label text-dark" for="fuelType">Select Fuel Type<span class="text-danger">*</span></label>
									          	<select class="form-select form-select-dark select-fuel" id="fuelType" name="fuelType">
										            <option value="" selected disabled>-- Select Fuel Type --</option>
												    <option value="diesel">Diesel</option>
												    <option value="electric">Electric</option>
												    <option value="gasoline">Gasoline</option>
												    <option value="lpg">LPG</option>
												    <option value="other">Other</option>
										        </select>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-6 col-xs-6 mb-3">
								          		<label class="form-label text-dark" for="engineMake">Engine Make</label>
							                	<input class="form-control form-control-dark" type="text" id="engineMake" name="engineMake" placeholder="Engine Make" autocomplete="off" autocorrect="off">
							              	</div>
							            </div>
							            <div class="row">
							              	<div class="col-lg-6 col-xs-6 mb-3">
								          		<label class="form-label text-dark" for="engineModel">Engine Model</label>
							                	<input class="form-control form-control-dark" type="text" id="engineModel" name="engineModel" placeholder="Engine Model" autocomplete="off" autocorrect="off">
							              	</div>
							            </div>
							            <div class="row">
							              	<div class="col-md-3 col-sm-6 mb-3">
								          		<label class="form-label text-dark" for="horsePower">Horse power</label>
							                	<input class="form-control form-control-dark" type="number" id="horsePower" name="horsePower" placeholder="Horse power">
							              	</div>
							            </div>
							            <div class="row">
							              	<div class="col-md-3 col-sm-6 mb-3">
								          		<label class="form-label text-dark" for="engineHours">Engine Hours</label>
							                	<input class="form-control form-control-dark" type="number" id="engineHours" name="engineHours" placeholder="Engine Hours">
							              	</div>
							            </div>
									</div>
									<div>
										<a class="btn btn-primary btn-sm ms-2 order-lg-3" href="javascript:void(0)" id="addEngine"><i class="fi-plus me-2"></i>Add Engine</a>
								        <input type="button" id="delEngine" value="Remove Engine" />
								    </div>
			                  	</div>
		                	</div>
		             	</div>
		              	<div class="accordion-item">
		                	<h2 class="accordion-header" id="otherInformations">
		                  		<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#otherInfo" aria-expanded="false" aria-controls="otherInfo">Other Information (optional)</button>
		                	</h2>
		                	<div class="accordion-collapse collapse" id="otherInfo" aria-labelledby="otherInformations" data-bs-parent="#extras" style="">
		                  		<div class="accordion-body fs-sm text-dark opacity-70">
		                    		<div class="row">
		                    			<div class="col-lg-6 col-xs-6 mb-3">
							          		<label class="form-label text-dark" for="engineMake">12 Digit HIN</label>
						                	<input class="form-control form-control-dark" type="text" id="12DigitHin" name="12DigitHin" placeholder="12 Digit HIN" autocomplete="off" autocorrect="off">
						              	</div>
						              	<div class="row">
							              	<div class="col-md-3 col-sm-6 mb-3">
								          		<label class="form-label text-dark" for="bridgeClearance">Bridge Clearance (feet)</label>
							                	<input class="form-control form-control-dark" type="number" id="bridgeClearance" name="bridgeClearance" placeholder="Bridge Clearance">
							              	</div>
							            </div>
		                      			<div class="row">
					                        <div class="col-lg-6 col-xs-6 mb-3">
								          		<label class="form-label text-dark" for="designer">Designer</label>
							                	<input class="form-control form-control-dark" type="text" id="designer" name="designer" placeholder="Designer" autocomplete="off" autocorrect="off">
							              	</div>
		                      			</div>
		                      			<div class="row">
							              	<div class="col-lg-6 col-xs-6 mb-3">
								          		<label class="form-label text-dark" for="fuelCapacity">Fuel Capacity</label>
							                	<input class="form-control form-control-dark" type="number" id="fuelCapacity" name="fuelCapacity" placeholder="Fuel Capacity">
							              	</div>
							            </div>
							            <div class="row">
							              	<div class="col-lg-6 col-xs-6 mb-3">
								          		<label class="form-label text-dark" for="holding">Holding</label>
							                	<input class="form-control form-control-dark" type="number" id="holding" name="holding" placeholder="Holding">
							              	</div>
							            </div>
							            <div class="row">
							              	<div class="col-lg-6 col-xs-6 mb-3">
								          		<label class="form-label text-dark" for="freshWater">Fresh Water</label>
							                	<input class="form-control form-control-dark" type="number" id="freshWater" name="freshWater" placeholder="Fresh Water">
							              	</div>
							            </div>
							            <div class="row">
							              	<div class="col-lg-6 col-xs-6 mb-3">
								          		<label class="form-label text-dark" for="boatName">Yacht Name</label>
							                	<input class="form-control form-control-dark" type="text" id="boatName" name="boatName" placeholder="Yacht Name">
							              	</div>
							            </div>
							            <div class="row">
							              	<div class="col-lg-6 col-xs-6 mb-3">
								          		<label class="form-label text-dark" for="cruisingSpeed">Cruising Speed (knots)</label>
							                	<input class="form-control form-control-dark" type="number" id="cruisingSpeed" name="cruisingSpeed" placeholder="Fresh Water">
							              	</div>
							            </div>
							            <div class="row">
							              	<div class="col-lg-6 col-xs-6 mb-3">
								          		<label class="form-label text-dark" for="loa">LOA</label>
							                	<input class="form-control form-control-dark" type="number" id="loa" name="loa" placeholder="LOA">
							              	</div>
							            </div>
							            <div class="row">
							              	<div class="col-lg-6 col-xs-6 mb-3">
								          		<label class="form-label text-dark" for="maxSpeed">Max Speed (knots)</label>
							                	<input class="form-control form-control-dark" type="number" id="maxSpeed" name="maxSpeed" placeholder="Max Speed">
							              	</div>
							            </div>
							            <div class="row">
							              	<div class="col-lg-6 col-xs-6 mb-3">
								          		<label class="form-label text-dark" for="beamFeet">Beam (feet)</label>
							                	<input class="form-control form-control-dark" type="number" id="beamFeet" name="beamFeet" placeholder="Beam">
							              	</div>
							            </div>
							            <div class="row">
							              	<div class="col-lg-6 col-xs-6 mb-3">
								          		<textarea class="accomodation" name="accomodation" id="accomodation"></textarea>
							              	</div>
							            </div>
							            <div class="row">
							              	<div class="col-lg-6 col-xs-6 mb-3">
								          		<textarea class="mechanicalEquipment" name="mechanicalEquipment" id="mechanicalEquipment"></textarea>
							              	</div>
							            </div>
							            <div class="row">
							              	<div class="col-lg-6 col-xs-6 mb-3">
								          		<textarea class="galleryEquipment" name="galleryEquipment" id="galleryEquipment"></textarea>
							              	</div>
							            </div>
							            <div class="row">
							              	<div class="col-lg-6 col-xs-6 mb-3">
								          		<textarea class="duckHullEquipment" name="duckHullEquipment" id="duckHullEquipment"></textarea>
							              	</div>
							            </div>
							            <div class="row">
							              	<div class="col-lg-6 col-xs-6 mb-3">
								          		<textarea class="navigationSystems" name="navigationSystems" id="navigationSystems"></textarea>
							              	</div>
							            </div>
							            <div class="row">
							              	<div class="col-lg-6 col-xs-6 mb-3">
								          		<textarea class="additionalEquipment" name="additionalEquipment" id="additionalEquipment"></textarea>
							              	</div>
							            </div>

		                    		</div>
		                  		</div>
		                	</div>
		              	</div>
		            </div>
				    </div>
				</section>

				<!-- Details 2-->
			    <section class="card card-dark card-body shadow-sm p-4 mb-4" id="details2">
			      	<h2 class="h4 text-dark mb-4"><i class="fi-image text-primary fs-5 mt-n1 me-2"></i>Let's connect you with the buyer.</h2>
			      	<div class="alert alert-warning bg-faded-warning border-warning mb-4" role="alert">
				        <div class="d-flex"><i class="fi-alert-circle me-2 me-sm-3"></i>
				          	<p class="fs-sm mb-1">The maximum photo size is 8 MB. Formats: jpeg, jpg, png. Put the main picture first.<br>The maximum video size is 10 MB. Formats: mp4, mov.</p>
				        </div>
			      	</div>
			      	<input class="file-uploader file-uploader-grid bg-faded-dark border-dark" type="file" name="boatImages" multiple data-max-file-size="10MB" accept="image/png, image/jpeg, video/mp4, video/mov" data-label-idle="&lt;div class=&quot;btn btn-primary mb-3&quot;&gt;&lt;i class=&quot;fi-cloud-upload me-1&quot;&gt;&lt;/i&gt;Upload photos / video&lt;/div&gt;&lt;div class=&quot;text-dark opacity-70&quot;&gt;or drag them in&lt;/div&gt;">
			        <div class="row">
			          	<div class="col-lg-6 col-xs-6 mb-3">
			          		<label class="form-label text-dark" for="price">Price</label>
			            	<input class="form-control form-control-dark" type="number" id="price" name="price" placeholder="Price">
			          	</div>
			        </div>
			        <div class="row">
			          	<div class="col-lg-6 col-xs-6 mb-3">
			          		<label class="form-label text-dark" for="BoatCity">City/Town</label>
			            	<input class="form-control form-control-dark" type="text" id="BoatCity" name="BoatCity" placeholder="City/Town">
			          	</div>
			        </div>
			        <div class="row">
			          	<div class="col-lg-6 col-xs-6 mb-3">
			          		<label class="form-label text-dark" for="boatCountry">Yacht Country</label>
			            	<input class="form-control form-control-dark" type="text" id="boatCountry" name="boatCountry" placeholder="Yacht Country">
			          	</div>
			        </div>
			        <div class="row">
			          	<div class="col-lg-6 col-xs-6 mb-3">
			          		<label class="form-label text-dark" for="boatState">State/Province</label>
			            	<input class="form-control form-control-dark" type="text" id="boatState" name="boatState" placeholder="State/Province">
			          	</div>
			        </div>
			        <div class="row">
			          	<div class="col-lg-6 col-xs-6 mb-3">
			          		<label class="form-label text-dark" for="zipCode">Zip Code</label>
			            	<input class="form-control form-control-dark" type="text" id="zipCode" name="zipCode" placeholder="Zip Code">
			          	</div>
			        </div>
			        <div class="row">
			          	<div class="col-lg-6 col-xs-6 mb-3">
			          		<textarea class="boatDescription" name="boatDescription" id="boatDescription"></textarea>
			          	</div>
			        </div>
			        <div class="row">
			          	<div class="col-lg-6 col-xs-6 mb-3">
			          		<label class="form-label text-dark" for="youtubeVideo">Youtube Video</label>
			            	<input class="form-control form-control-dark" type="text" id="youtubeVideo" name="youtubeVideo" placeholder="Youtube Video">
			          	</div>
			        </div>
			    </section>

			    <!-- Contact Info-->
			    <section class="card card-dark card-body shadow-sm p-4 mb-4" id="contactInfo">
			      	<h2 class="h4 text-dark mb-4"><i class="fi-image text-primary fs-5 mt-n1 me-2"></i>Let's post your listing.</h2>
			      	<div class="row">
			          	<div class="col-lg-6 col-xs-6 mb-3">
			          		<label class="form-label text-dark" for="userFirstName">First Name</label>
			            	<input class="form-control form-control-dark" type="text" id="userFirstName" name="userFirstName" placeholder="First Name">
			          	</div>
			        </div>
			        <div class="row">
			          	<div class="col-lg-6 col-xs-6 mb-3">
			          		<label class="form-label text-dark" for="userLastName">User Last Name</label>
			            	<input class="form-control form-control-dark" type="text" id="userLastName" name="userLastName" placeholder="User Last Name">
			          	</div>
			        </div>
			        <div class="row">
			          	<div class="col-lg-6 col-xs-6 mb-3">
			          		<label class="form-label text-dark" for="userContactNumber">Contact Number</label>
			            	<input class="form-control form-control-dark" type="number" id="userContactNumber" name="userContactNumber" placeholder="Contact Number">
			          	</div>
			        </div>
			        <div class="row">
			          	<div class="col-lg-6 col-xs-6 mb-3">
			          		<label class="form-label text-dark" for="userAddress">Address</label>
			            	<input class="form-control form-control-dark" type="text" id="userAddress" name="userAddress" placeholder="Address">
			          	</div>
			        </div>
			        <div class="row">
			          	<div class="col-lg-6 col-xs-6 mb-3">
			          		<label class="form-label text-dark" for="userCity">City/Town</label>
			            	<input class="form-control form-control-dark" type="text" id="userCity" name="userCity" placeholder="City/Town">
			          	</div>
			        </div>
			        <div class="row">
			          	<div class="col-lg-6 col-xs-6 mb-3">
			          		<label class="form-label text-dark" for="userCountry">Country</label>
			            	<input class="form-control form-control-dark" type="text" id="userCountry" name="userCountry" placeholder="Country">
			          	</div>
			        </div>
			        <div class="row">
			          	<div class="col-lg-6 col-xs-6 mb-3">
			          		<label class="form-label text-dark" for="userState">State/Province</label>
			            	<input class="form-control form-control-dark" type="text" id="userState" name="userState" placeholder="State/Province">
			          	</div>
			        </div>
			        <div class="row">
			          	<div class="col-lg-6 col-xs-6 mb-3">
			          		<label class="form-label text-dark" for="userZipCode">Zip Code</label>
			            	<input class="form-control form-control-dark" type="text" id="userZipCode" name="userZipCode" placeholder="Zip Code">
			          	</div>
			        </div>
			        <div class="row">
			          	<div class="col-lg-6 col-xs-6 mb-3">
			          		<label class="form-label text-dark" for="userEmail">Your Email</label>
			            	<input class="form-control form-control-dark" type="text" id="userEmail" name="userEmail" placeholder="Your Email">
			          	</div>
			        </div>
			        <div class="row">
			          	<div class="col-lg-6 col-xs-6 mb-3">
			          		<label class="form-label text-dark" for="confirmEmail">Repeat Your Email</label>
			            	<input class="form-control form-control-dark" type="text" id="confirmEmail" name="confirmEmail" placeholder="Repeat Your Email">
			          	</div>
			        </div>
			    </section>

			    <div class="d-sm-flex justify-content-between pt-2"><a class="btn btn-outline-dark btn-lg d-block ps-3 mb-3 mb-sm-2" href="#preview-modal" data-bs-toggle="modal"><i class="fi-eye-on me-2"></i>Preview</a><button class="btn btn-primary btn-lg d-block mb-2" type="submit">Save and continue</button></div>
			</form>

		</div>
	  	<!-- Progress of completion-->
	  	<aside class="col-lg-3 offset-lg-1 d-none d-lg-block">
		    <div class="sticky-top pt-5">
		      	<h6 class="text-dark pt-5 mt-3 mb-2"></h6>
		      	<div class="progress progress-dark mb-4" style="height: .25rem;">
		        	<div class="progress-bar bg-success" role="progressbar" style="width: 80%" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
		      	</div>
		      	<ul class="list-unstyled">
		        	<li class="d-flex align-items-center"><i class="fi-check text-primary me-2"></i><a class="nav-link-dark ps-1" href="#basicInfo" data-scroll data-scroll-offset="20">Basic info</a></li>
		        	<li class="d-flex align-items-center"><i class="fi-check text-primary me-2"></i><a class="nav-link-dark ps-1" href="#details1" data-scroll data-scroll-offset="20">Boat information</a></li>
		        	<li class="d-flex align-items-center"><i class="fi-check text-primary me-2"></i><a class="nav-link-dark ps-1" href="#details2" data-scroll data-scroll-offset="20">Details 2</a></li>
		        	<li class="d-flex align-items-center"><i class="fi-check text-dark opacity-60 me-2"></i><a class="nav-link-dark ps-1" href="#contactInfo" data-scroll data-scroll-offset="20">Contact Info</a></li>
		      	</ul>
		    </div>
	  	</aside>
	</div>
</div>
@endsection
