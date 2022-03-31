@php
    $uri = $_SERVER['REQUEST_URI'];
    $uri = explode('/', $uri);
@endphp
@extends('layouts.front-layout')

@section('content')

<div class="container mt-5 mb-md-4 py-5">
    <div class="row">
        <div class="col-lg-12 col-xl-12">

            <!-- Steps-->
            <div class="bg-light rounded-3 py-4 px-md-4 mb-3">
                <div class="steps pt-4 pb-1">
                    <div class="step active">
                        <div class="step-progress"><span class="step-progress-start"></span><span class="step-progress-end"></span><span class="step-number">1</span></div>
                        <div class="step-label">Basic info</div>
                    </div>
                    <div class="step active">
                        <div class="step-progress"><span class="step-progress-start"></span><span class="step-progress-end"></span><span class="step-number">2</span></div>
                        <div class="step-label">Details</div>
                    </div>
                    <div class="step active">
                        <div class="step-progress"><span class="step-progress-start"></span><span class="step-progress-end"></span><span class="step-number">3</span></div>
                        <div class="step-label">Details 2</div>
                    </div>
                    <div class="step active">
                        <div class="step-progress"><span class="step-progress-start"></span><span class="step-progress-end"></span><span class="step-number">4</span></div>
                        <div class="step-label">Photos & Location</div>
                    </div>
                    <div class="step {{ ($uri[2]=='step-five') ? 'active' : '' }}">
                        <div class="step-progress"><span class="step-progress-start"></span><span class="step-progress-end"></span><span class="step-number">5</span></div>
                        <div class="step-label">Payment</div>
                    </div>
                </div>
            </div>
            <!-- Page title-->
            <div class="text-center pb-4 mb-3">
                <h1 class="h2 mb-4">Payment</h1>
            </div>
            <div class="row d-flex justify-content-center">
                <div class="col-lg-6 col-xl-6">
                    <form method="post" action="{{ route('free-boat-subscribe') }}" id="freeBoatForm">
                        @csrf
                    </form>

                    <form method="post" action="{{ route('step-five-submit') }}" id="stepFiveForm">
                        @csrf
                        <input type="hidden" name="billing_email" value="{{ $user->email }}">
                        <input type="hidden" name="coupon_code" value="{{ $coupon->code??'' }}">


                        <div class="row">
                            <div class="col-lg-12 col-sm-12 col-md-12 mb-4">
                                <div class="card card-dark border-dark">
                                    <div class="card-body">
                                        <h2 class="h5 text-dark fw-normal text-center py-1 mb-0 text-capitalize">{{ $plan->name }}</h2>
                                            <div class="d-flex align-items-end justify-content-center mb-4">
                                                <div class="h1 text-dark mb-0 text-capitalize">${{ $plan->price }}</div>
                                            </div>
                                            <ul class="list-unstyled d-block mb-0 mx-1" style="max-width: 16rem;">
                                                <li class="d-flex"><i class="fi-clock fs-sm mt-1 me-2"></i><span class="text-dark text-capitalize">{{ $plan->duration_weeks }}&nbsp;weeks</span></li>
                                                <li class="d-flex"><i class="fi-camera-plus fs-sm mt-1 me-2"></i><span class="text-dark">
                                                @if(empty($plan->image_number))
                                                    {{ 'Unlimited Photos' }}
                                                @elseif($plan->image_number > 1)
                                                    {{ $plan->image_number.' photos'}}
                                                @else
                                                    {{ $plan->image_number.' photo'}}
                                                @endif
                                                </span></li>
                                                @if($plan->video_number !== 0)
                                                    <li class="d-flex"><i class="fi-video fs-sm mt-1 me-2"></i><span class="text-dark">
                                                    @if(empty($plan->video_number))
                                                        {{ 'Unlimited Videos' }}
                                                    @elseif($plan->video_number > 1)
                                                        {{ $plan->video_number.' videos'}}
                                                    @else
                                                        {{ $plan->video_number.' video'}}
                                                    @endif
                                                    </span></li>
                                                @endif
                                            </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @php
                            $totalCost = 0;
                            $overallCost = 0;
                            $addOnCount = 0;
                        @endphp
                        @if(isset($addons) && count($addons) > 0)
                        <h2 class="h3 text-dark pt-4 pt-md-5 mb-4">Other services</h2>
                        <div class="card card-dark card-hover card-body px-4 mb-2">
                            @foreach($addons as $addon)
                                @php
                                    $addOnCount++;
                                @endphp
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="add_on{{ $addOnCount }}" checked disabled>
                                    <label class="form-check-label d-sm-flex align-items-center justify-content-between" for="ad-option-1">
                                        <span class="d-block px-1"><span class="d-block h6 text-dark mb-2">{{ $addon->addon_name }}</span></span><span class="d-block h4 text-dark mb-0">${{ sprintf('%0.2f', $addon->addon_cost) }}</span>
                                    </label>
                                </div>
                                @php
                                    $totalCost += $addon->addon_cost;
                                @endphp
                            @endforeach
                        </div>
                        @endif
                        @php
                            $overallCost =  $totalCost + $plan->price;
                        @endphp

                        @php
                           $finalCost =  $subTotalValue = $overallCost;
                           $discountTotalprice = 0;
                        @endphp

                        @if(isset($coupon) && !empty($coupon) )
                            @if($coupon->type == 'percentage')
                                @php
                                   $discountTotalprice = $subTotalValue * ($coupon->amount/100);
                                @endphp
                            @elseif($coupon->type == 'fixed')
                                @php
                                    $discountTotalprice = $coupon->amount;
                                @endphp
                            @elseif($coupon->type == 'free')
                                @php
                                    $discountTotalprice = $overallCost;
                                @endphp
                            @endif

                            @php
                              $finalCost = $subTotalValue - $discountTotalprice;
                            @endphp

                        @endif

                        @if($finalCost > 0 )
                            <div class="card card-dark card-hover card-body px-4 mb-2 stripe-form">
                                <h5>Credit or debit card</h5>
                                <div class="row">
                                    <div class="col-lg-12 col-xs-12 mb-3">
                                        <label class="form-label text-dark" for="ZipCode">Card Holder Name<span class="text-danger">*</span></label>
                                        <input class="form-control" id="card_holder_name" name="card_holder_name" type="text" value="{{$user->full_name}}" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-xs-12 mb-3">
                                        <label class="form-label text-dark" for="ZipCode">Billing Address<span class="text-danger">*</span></label>
                                        <input class="form-control" id="billing_address" name="billing_address" type="text" value="{{$user->address}}" required>
                                    </div>
                                </div>

                                <div id="card-element" class="form-control" style='height: 2.4em; padding-top: .7em;'>
                                </div>
                                <!-- Used to display form errors. -->
                                <div id="card-errors" role="alert"></div>
                            </div>
                            <div class="stripe-errors"></div>
                            @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                {{ $error }}<br>
                                @endforeach
                            </div>
                            @endif
                        @endif
                        
                        <div class="mb-2">
                            <div class="form-check form-check-dark {{ (isset($coupon) && !empty($coupon) && ($coupon->type == 'free')) ? 'd-none' : '' }} terms-div">
                                <input class="form-check-input" type="checkbox" id="terms">
                                <label class="form-check-label d-sm-flex align-items-center justify-content-between" for="terms">
                                    <span class="d-block px-1"> I confirm that I have the right to use the photographs in this listing and the information is complete and accurate to the best of my knowledge, that I am legally authorized to sell this boat, and that I have read and agreed to the For Sale by Owner.&nbsp;<a href="https://www.boatsgroup.com/advertising-policy/" class="text-dark">Terms and Conditions.</a></span>
                                </label>
                            </div>
                            @if($finalCost > 0 )
                            <div class="form-check form-check-dark {{ (isset($coupon) && !empty($coupon) && ($coupon->type == 'free')) ? 'd-none' : '' }} auto-renew-div">
                                <input class="form-check-input" type="checkbox" id="autoRenewal" name="auto_renewal">
                                <label class="form-check-label d-sm-flex align-items-center justify-content-between" for="autoRenewal">
                                    <span class="d-block px-1"><span class="d-block h6 text-dark mb-2">Yes! I want to enable auto renew.</span></span>
                                </label>
                            </div>
                            @endif
                        </div>
                        <input type="hidden" class="real_cost" name="real_cost" value="{{ $overallCost }}">

                        <div class="text-end">
                            <input type="hidden" class="total_cost" name="total_cost" value="{{ $overallCost }}">
                             <div class="text-dark">Sub Total: $<span class="show-overallCost">{{ sprintf('%0.2f', $subTotalValue) }}</span></div>
                             <div class="text-dark">Discount: $<span class="show-overallCost">{{ sprintf('%0.2f', $discountTotalprice) }}</span></div>
                            <div class="h4 text-dark">Total: $<span class="show-overallCost">{{ sprintf('%0.2f', $finalCost) }}</span></div>
                        </div>
                        <div class="loaderx" style="display:none"></div>

                        <div class="d-flex flex-column justify-content-end flex-sm-row bg-light rounded-3">
                            <a href="{{  route('step-four') }}" class="btn btn-secondary btn-lg d-block mb-2 me-2"><i class="fi-chevron-left fs-sm me-2"></i>PREVIOUS</a>
                            <a href="{{ url('/explore/yacht/'.$boat->slug) }}" target="_blank" class="btn btn-info btn-lg d-block mb-2 me-2">PREVIEW LISTING</a>
                            @if($finalCost ==  0 )
                            <button class="btn btn-primary btn-lg d-block  mb-2 me-2 save-free-boat" name="exit" value="1" type="submit">COMPLETE</button>
                            @else
                            <button class="btn btn-primary btn-lg d-block mb-2 me-2 plan-submit" id="card-button" disabled  data-secret="{{ $intent->client_secret }}">
                                <span class="spinner-border spinner-border-sm me-2 pay-spinner" role="status" aria-hidden="true" style="display: none;"></span>COMPLETE PAYMENT
                            </button>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
<script src="https://js.stripe.com/v3/"></script>
<script>
    var stripe = Stripe('{{ env('STRIPE_KEY') }}');
    var elements = stripe.elements();
    var style = {
        base: {
            color: '#32325d',
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            fontSmoothing: 'antialiased',
            fontSize: '16px',
            '::placeholder': {
                color: '#aab7c4'
            }
        },
        invalid: {
            color: '#fa755a',
            iconColor: '#fa755a'
        }
    };
    var card = elements.create('card', {hidePostalCode: true,
        style: style});
    card.mount('#card-element');

     card.addEventListener('change', function(event) {
        var displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });
    const cardHolderName = document.getElementById('card_holder_name');
    const cardButton = document.getElementById('card-button');
    const clientSecret = cardButton.dataset.secret;
    cardButton.addEventListener('click', async (e) => {
        e.preventDefault();
        $('.plan-submit').addClass("disabled");
        $('.pay-spinner').show();
        // console.log("attempting");
        const { setupIntent, error } = await stripe.confirmCardSetup(
            clientSecret, {
                payment_method: {
                    card: card,
                    billing_details: { name: cardHolderName.value }
                }
            }
            );
        
        if (error) {
            var errorElement = document.getElementById('card-errors');
            errorElement.textContent = error.message;
            if ($('.plan-submit').hasClass("disabled")) {
                $('.plan-submit').removeClass("disabled");
            }
            $('.pay-spinner').hide();
            return false;
        } else {
           

            // return false;
            
            // alert(setupIntent.payment_method);
            // console.log(setupIntent.payment_method);
            paymentMethodHandler(setupIntent.payment_method);
        }
    });
    function paymentMethodHandler(payment_method) {
        var form = document.getElementById('stepFiveForm');
        var hiddenInput = document.createElement('input');
        hiddenInput.setAttribute('type', 'hidden');
        hiddenInput.setAttribute('name', 'payment_method');
        hiddenInput.setAttribute('value', payment_method);
        form.appendChild(hiddenInput);
        // alert("Processing now");
        form.submit();
    }
</script>
@endsection
