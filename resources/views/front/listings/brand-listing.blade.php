@extends('layouts.front-layout')
@section('content')
	<!-- Breadcrumb-->
    <div class="container mt-5 py-5">
        <!-- Breadcrumb-->
        <nav class="mb-3 pt-md-3" aria-label="Breadcrumb">
            <ol class="breadcrumb breadcrumb-dark">
                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Brands</li>
            </ol>
        </nav>

        <div class="d-sm-flex align-items-end align-items-md-center	justify-content-between	position-relative mb-4"	style="z-index:	1025;">
            <div class="me-3">
                <h1	class="h2 text-dark"> Browse All Brands</h1>
            </div>
        </div>
        <div class="container border border-0 bg-light mb-5">
            @foreach ($characterListing as $character)
                <a href="javascript:0;" class="p-2 btn btn-link character-link" data-character="{{ $character }}">{{ $character }}</a>
            @endforeach
        </div>

        <div class="card card-dark border border-0  card-body px-4 mb-2">
            @foreach ($brandsCorrespondToCharacters as $key => $characterBrand)
                <hr/>
                <div class="me-3 mt-3 mb-3" id="{{ $characterBrand['character'] }}">
                    <h1	class="h4 text-dark	mb-md-0"> {{ $characterBrand['character'] }}</h1>
                </div>
                <div class="row">
                    @foreach ($characterBrand['list'] as $brand)
                        <div class="col-md-3 col-sm-6">
                            <a href="{{ url('explore/brand/'.$brand['slug'])}}" class="p-2 text-dark badge text-wrap  lh-sm">{{ $brand['name'] }}</a>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>

    </div>
@endsection
