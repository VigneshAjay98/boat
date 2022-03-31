@extends('layouts.front-layout')

@section('content')
<div class="clearfix">&nbsp;</div>
<div class="container mt-5 mb-md-4 py-5 payment-success-container">
	<div class="row d-flex justify-content-center">
		<div class="col-lg-6 col-xl-6">
  			<div class="">
  				<div style="border-radius:200px; height:200px; width:200px; background: #F8FAF5; margin:0 auto;">
					<i class="checkmark">✓</i>
  				</div>
				<h1>Payment Success</h1> 
				<p>Thank you for creating your listing!</p><br/>
				<p>Our team will be reviewing the listing shortly and placing it live.  Should we encounter any issues with your listing, we will contact you by the email for your login.</p>
				<a href="{{ route('my-yachts') }}">View My Listings </a>
  			</div>
		</div>
	</div>
</div>
@endsection