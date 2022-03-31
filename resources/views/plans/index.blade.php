@extends('layouts.app')

@section('content')
<div class="container">
    <div class="text-center row">
        <h2>{{ __('Sell your yacht fast today on yachtfindr.com') }}</h2>
        <!-- <img src="{{ url('storage/images/logo.png') }}"> -->
    </div>
    <div class="row">
        @if(isset($plans))
            @foreach($plans as $plan)
            <div class="col-lg-4 col-md-4 col-xs-12 card mx-1 my-1 plan">
              <!-- <h5 class="card-header text-center">BEST DEAL</h5> -->
              <div class="card-body">
                <h5 class="card-title">{{ $plan->name }}</h5>
                <p class="card-text">${{ $plan->price }}</p>
                <a href="#" class="btn btn-primary">Go somewhere</a>
              </div>
            </div>
            @endforeach
        @endif
        <!-- <div class="col-lg-4 col-md-4 col-xs-12 card mx-1 my-1 plan">
          <h5 class="card-header">Featured</h5>
          <div class="card-body">
            <h5 class="card-title">Special title treatment</h5>
            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
            <a href="#" class="btn btn-primary">Go somewhere</a>
          </div>
        </div>
        <div class="col-lg-4 col-md-4 col-xs-12 card mx-1 my-1 plan">
          <h5 class="card-header">Featured</h5>
          <div class="card-body">
            <h5 class="card-title">Special title treatment</h5>
            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
            <a href="#" class="btn btn-primary">Go somewhere</a>
          </div>
        </div> -->
    </div>
</div>
@endsection
