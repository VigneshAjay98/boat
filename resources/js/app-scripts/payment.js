$(document).ready(function(){

	if ($('.stripe-form').length) {

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		var auto_renewal = false;

		$(document).on('click', '#autoRenewal', function(e) {
			if($(this).is(":checked")) {
				auto_renewal = true;
			} else {
				auto_renewal = false;
			}
		});

		var url = base_url + '/listing/step-five';
		var errorElement = document.getElementById('card-errors');
		var stripe_key = $('.stripe-form').data('stripe-key');
		const clientSecret = $('.stripe-form').data('secret');

		const cardHolderName = document.getElementById('card_holder_name');
		const billing_email = document.getElementById('billing_email');
		const billing_phone = document.getElementById('billing_phone');
		const billing_address = document.getElementById('billing_address');
		const billing_city = document.getElementById('billing_city');
		var billing_country = '';
		var billing_state = '';

		var stripe = Stripe(stripe_key);

	    var elements = stripe.elements();

	    // Set up Stripe.js and Elements to use in checkout form
	    var style = {
	        base: {
	            color: "#32325d",
	            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
	            fontSmoothing: "antialiased",
	            fontSize: "16px",
	            "::placeholder": {
	                color: "#aab7c4"
	            }
	        },
	        invalid: {
	            color: "#fa755a",
	            iconColor: "#fa755a"
	        },
	    };

	    var cardElement = elements.create('card', {
	        style: style
	    });
	    cardElement.mount('#card-element');
	    var form = document.getElementById('stepFiveForm');

	    form.addEventListener('submit', async (event) => {
	        // We don't want to let default form submission happen here,
	        // which would refresh the page.

	        billing_country = $('#Country').find("option:selected").data('country-code');
	        billing_state = $('#State').find("option:selected").val();

            $("form[id='stepFiveForm']").validate({
		    	errorElement: "span",
		        rules: {
		            card_holder_name: {
		            	required: true
		            },
		            billing_email: {
		            	required: true
		            },
		            billing_phone: {
		            	required: true
		            },
		            billing_country: {
		            	required: true
		            },
		            billing_state: {
		            	required: true
		            },
		            billing_city: {
		            	required: true
		            },
		            billing_address: {
		            	required: true
		            },
		        },
		        errorPlacement: function(error, element) {
				  	if(element.attr("name") == "state") {
				    	error.appendTo('.state-error');
				  	} else {
				    	error.insertAfter(element);
				  	}
			    }
		    });

	        event.preventDefault();

	        const { setupIntent, error } = await stripe.confirmCardSetup(
	            clientSecret, {
	                payment_method: {
	                    card: cardElement,
	                    billing_details: { 
	                    	name: cardHolderName.value,
			                email: billing_email.value,
			            	phone: billing_phone.value,
			            	address: {
					         	city: billing_city.value,
					          	country: billing_country,
					          	line1: billing_address.value,
					          	state: billing_state
					        },
	                    }
	                }
	            }
	        );

	        if (error) {
	            errorElement.textContent = error.message;
	        } else {
	        	errorElement.textContent = '';
	        	if(setupIntent.payment_method) {
	        		$.ajax({
						url: url,
						type: "POST",
						data: {
							payment_method_id: setupIntent.payment_method,
							auto_renewal: auto_renewal,
						},
						beforeSend: function() {
		                    if ($('.pay-spinner').hasClass("d-none")) {
		                        $('.pay-spinner').removeClass("d-none");
		                    }
		                    if (!$('.plan-submit').hasClass("disabled")) {
		                        $('.plan-submit').addClass("disabled");
		                    }
		                },
						success: function (response) {
							if (response.requires_action) {
								stripe.confirmCardPayment(response.payment_intent_client_secret, {
								    payment_method: response.payment_intent_payment_method,
								}).then(function(result){
									  	if (result.error) {
									    	location.reload();
									  	} else {
									  		if(result.paymentIntent.status == 'succeeded') {
									  			$.ajax({
													url: base_url + '/confirm-payment',
													type: "POST",
													data: {
														payment_intent_id: result.paymentIntent.payment_method, 
														payment_method_id: result.paymentIntent.id,
														customer_id: response.customer_id,
														email: billing_email.value,
														order_total: response.order_total,
														auto_renewal: auto_renewal
													},
													success: function (response) {
														if (response.success) {
															window.location.href = base_url + '/payment-success';
														}
													}
												});
									  		}
									  	}
								});
							} else if (response.error) {
					            location.reload();
					        } else if (response.success) {
					        	$.ajax({
									url: base_url + '/confirm-payment',
									type: "POST",
									data: {
										payment_intent_id: response.payment_intent_id, 
										payment_method_id: response.payment_method_id,
										customer_id: response.customer_id,
										email: billing_email.value,
										order_total: response.order_total,
										auto_renewal: auto_renewal
									},
									success: function (response) {
										if (response.success) {
											window.location.href = base_url + '/payment-success';
										}
									}
								});
					        } else {
					        	location.reload();
					        }
						},
						error: function (reject) {
							location.reload();
						}
					});
	        	}

	        }

	    });
	}
	// if ($('.stripe-form').length) {

	// 	$.ajaxSetup({
	// 		headers: {
	// 			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	// 		}
	// 	});

	// 	var auto_renewal = false;

	// 	$(document).on('click', '#autoRenewal', function(e) {
	// 		if($(this).is(":checked")) {
	// 			auto_renewal = true;
	// 		} else {
	// 			auto_renewal = false;
	// 		}
	// 	});

	// 	var url = base_url + '/listing/step-five';
	// 	var errorElement = document.getElementById('card-errors');
	// 	var stripe_key = $('.stripe-form').data('stripe-key');
	// 	const clientSecret = $('.stripe-form').data('secret');

	// 	const cardHolderName = document.getElementById('card_holder_name');
	// 	// const billing_email = document.getElementById('billing_email');
	// 	// const billing_phone = document.getElementById('billing_phone');
	// 	// const billing_address = document.getElementById('billing_address');
	// 	// const billing_city = document.getElementById('billing_city');
	// 	// var billing_country = '';
	// 	// var billing_state = '';

	// 	var stripe = Stripe(stripe_key);

	//     var elements = stripe.elements();

	//     // Set up Stripe.js and Elements to use in checkout form
	//     var style = {
	//         base: {
	//             color: "#32325d",
	//             fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
	//             fontSmoothing: "antialiased",
	//             fontSize: "16px",
	//             "::placeholder": {
	//                 color: "#aab7c4"
	//             }
	//         },
	//         invalid: {
	//             color: "#fa755a",
	//             iconColor: "#fa755a"
	//         },
	//     };

	//     var cardElement = elements.create('card', {
	//         style: style
	//     });
	//     cardElement.mount('#card-element');
	//     var form = document.getElementById('stepFiveForm');

	//     form.addEventListener('submit', async (event) => {
	//         // We don't want to let default form submission happen here,
	//         // which would refresh the page.

	//         billing_country = $('#Country').find("option:selected").data('country-code');
	//         billing_state = $('#State').find("option:selected").val();

 //            $("form[id='stepFiveForm']").validate({
	// 	    	errorElement: "span",
	// 	        rules: {
	// 	            card_holder_name: {
	// 	            	required: true
	// 	            },
	// 	            billing_email: {
	// 	            	required: true
	// 	            },
	// 	            billing_phone: {
	// 	            	required: true
	// 	            },
	// 	            billing_country: {
	// 	            	required: true
	// 	            },
	// 	            billing_state: {
	// 	            	required: true
	// 	            },
	// 	            billing_city: {
	// 	            	required: true
	// 	            },
	// 	            billing_address: {
	// 	            	required: true
	// 	            },
	// 	        },
	// 	        errorPlacement: function(error, element) {
	// 			  	if(element.attr("name") == "state") {
	// 			    	error.appendTo('.state-error');
	// 			  	} else {
	// 			    	error.insertAfter(element);
	// 			  	}
	// 		    }
	// 	    });

	//         event.preventDefault();

	//         if ($('.pay-spinner').hasClass("d-none")) {
 //                $('.pay-spinner').removeClass("d-none");
 //            }
 //            if (!$('.plan-submit').hasClass("disabled")) {
 //                $('.plan-submit').addClass("disabled");
 //            }

	//         const { setupIntent, error } = await stripe.confirmCardSetup(
	//             clientSecret, {
	//                 payment_method: {
	//                     card: cardElement,
	//                     billing_details: { 
	//                     	name: cardHolderName.value,
	// 		                email: billing_email.value,
	// 		            	phone: billing_phone.value,
	// 		            	address: {
	// 				         	city: billing_city.value,
	// 				          	country: billing_country,
	// 				          	line1: billing_address.value,
	// 				          	state: billing_state
	// 				        },
	//                     }
	//                 }
	//             }
	//         );

	//         if (error) {
	//             errorElement.textContent = error.message;
	//         } else {
	//         	errorElement.textContent = '';
	//         	if(setupIntent.payment_method) {
	//         		$.ajax({
	// 					url: url,
	// 					type: "POST",
	// 					data: {
	// 						payment_method_id: setupIntent.payment_method,
	// 						auto_renewal: auto_renewal,
	// 					},
	// 					beforeSend: function() {
	// 	                    if ($('.pay-spinner').hasClass("d-none")) {
	// 	                        $('.pay-spinner').removeClass("d-none");
	// 	                    }
	// 	                    if (!$('.plan-submit').hasClass("disabled")) {
	// 	                        $('.plan-submit').addClass("disabled");
	// 	                    }
	// 	                },
	// 					success: function (response) {
	// 						if (response.requires_action) {
	// 							stripe.confirmCardPayment(response.payment_intent_client_secret, {
	// 							    payment_method: response.payment_intent_payment_method,
	// 							}).then(function(result){
	// 								  	if (result.error) {
	// 								    	location.reload();
	// 								  	} else {
	// 								  		if(result.paymentIntent.status == 'succeeded') {
	// 								  			$.ajax({
	// 												url: base_url + '/confirm-payment',
	// 												type: "POST",
	// 												data: {
	// 													payment_intent_id: result.paymentIntent.payment_method, 
	// 													payment_method_id: result.paymentIntent.id,
	// 													customer_id: response.customer_id,
	// 													email: billing_email.value,
	// 													order_total: response.order_total,
	// 													auto_renewal: auto_renewal
	// 												},
	// 												success: function (response) {
	// 													if (response.success) {
	// 														window.location.href = base_url + '/payment-success';
	// 													}
	// 												}
	// 											});
	// 								  		}
	// 								  	}
	// 							});
	// 						} else if (response.error) {
	// 				            location.reload();
	// 				        } else if (response.success) {
	// 				        	$.ajax({
	// 								url: base_url + '/confirm-payment',
	// 								type: "POST",
	// 								data: {
	// 									payment_intent_id: response.payment_intent_id, 
	// 									payment_method_id: response.payment_method_id,
	// 									customer_id: response.customer_id,
	// 									email: billing_email.value,
	// 									order_total: response.order_total,
	// 									auto_renewal: auto_renewal
	// 								},
	// 								success: function (response) {
	// 									if (response.success) {
	// 										window.location.href = base_url + '/payment-success';
	// 									}
	// 								}
	// 							});
	// 				        } else {
	// 				        	location.reload();
	// 				        }
	// 					},
	// 					error: function (reject) {
	// 						location.reload();
	// 					}
	// 				});
	//         	}

	//         }

	//     });
	// }

});
