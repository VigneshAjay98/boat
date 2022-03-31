@extends('layouts.front-layout')

@section('content')

<section class="bg-top-center bg-repeat-0 pt-5 " style="background-image: url(''); background-size: 1920px 630px;">
	<div class="container pt-5">
		<div class="row pt-xs-5 pt-lg-4 pt-xl-5">
			<div class="col-lg-4 col-md-5 pt-3  pt-md-4 pt-lg-5">
				<h1 class="display-4 text-dark pb-2 mb-4 me-md-n5">Easy way to find the right Yacht</h1>
				<p class="fs-lg text-dark opacity-70">Yacht Findr is a leading digital marketplace for the yacht industry that connects car shoppers with sellers. </p>
			</div>
			<div class="col-lg-8 col-md-7 pt-md-5"><img class="d-block mt-4 ms-auto" src="front/img/avatars/default-yacht-profile.jpg" width="800" alt="Car"></div>
		</div>
	</div>
	<div class="container mt-4 mt-sm-3 mt-lg-n3 pb-5 mb-md-4">
		<!-- Tabs-->
		<ul class="nav nav-tabs nav-tabs-dark mb-4">
			<li class="nav-item"><a class="nav-link active" href="#">New</a></li>
			<li class="nav-item"><a class="nav-link" href="#">Used</a></li>
		</ul>
		<!-- Form group-->
		<form action=""  class="form-group form-group-dark d-block">
            @csrf
			<div class="row g-0 ms-lg-n2">
				<div class="col-lg-2">
					<div class="input-group border-end-lg border-dark"><span class="input-group-text text-muted ps-2 ps-sm-3"><i class="fi-search"></i></span>
						<input class="form-control" type="text" name="keywords" placeholder="Keywords...">
					</div>
				</div>
				<hr class="hr-dark d-lg-none my-2">
				<div class="col-lg-2 col-md-3 col-sm-6">
					<div class="dropdown border-end-sm border-dark" data-bs-toggle="select" >
						<button class="btn btn-link dropdown-toggle ps-2 ps-sm-3 " type="button" data-bs-toggle="dropdown"><i class="fi-list me-2"></i><span class="dropdown-toggle-label">Make</span></button>
						<input type="hidden" name="make" >
						<ul class="dropdown-menu dropdown-menu-dark make-dropdown" data-bs-spy="scroll">
							@foreach($brands as $key => $brand)
								<li><a class="dropdown-item" href="javascript:;"><span class="dropdown-item-label">{{ $brand }}</span></a></li>
							@endforeach
						</ul>
					</div>
				</div>
				<hr class="hr-dark d-sm-none my-2">
				<div class="col-lg-2 col-md-3 col-sm-6">
					<div class="dropdown border-end-md border-dark" data-bs-toggle="select" >
						<button class="btn btn-link dropdown-toggle ps-2 ps-sm-3" type="button" data-bs-toggle="dropdown"><i class="fi-list me-2"></i><span class="dropdown-toggle-label modal-label">Model</span></button>
						<input type="hidden" class="model-input" name="model">
						<ul class="dropdown-menu dropdown-menu-dark container-fluid overflow-auto max-height-dropdown model-dropdown" id="modelDropdown">
							@foreach($models as $key => $model)
								<li><a class="dropdown-item" href="javascript:;"><span class="dropdown-item-label">{{ $model }}</span></a></li>
							@endforeach
						</ul>
					</div>
				</div>
				<hr class="hr-dark d-md-none my-2">
				<div class="col-lg-2 col-md-3 col-sm-6">
					<div class="dropdown border-end-sm border-dark" data-bs-toggle="select">
						<button class="btn btn-link dropdown-toggle ps-2 ps-sm-3" type="button" data-bs-toggle="dropdown"><i class="fi-car fs-lg me-2"></i><span class="dropdown-toggle-label">Boat type</span></button>
						<input type="hidden" name="type">
						<ul class="dropdown-menu dropdown-menu-dark">
							@foreach($bodyTypes as $key => $bodyType)
								<li><a class="dropdown-item" href="javascript:;"><span class="dropdown-item-label">{{ $bodyType }}</span></a></li>
							@endforeach
						</ul>
					</div>
				</div>
				<hr class="hr-dark d-sm-none my-2">
                <div class="col-lg-2">
					<div class="input-group border-end-lg border-dark"><span class="input-group-text text-muted ps-2 ps-sm-3"><i class="fi-map-pin"></i></span>
						<input class="form-control" type="text" name="location" placeholder="Locations...">
					</div>
				</div>
				<hr class="hr-dark d-lg-none my-2">
				<div class="col-lg-2">
					<button class="btn btn-primary w-100" type="submit">Search</button>
				</div>
			</div>
		</form>
	</div>
</section>
@endsection
