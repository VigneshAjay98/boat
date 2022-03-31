var FINALDISCOUNTCOST = 0;

let frontCommon = () => {

	// Ajax header declared
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

    let tostrMessage = (type, message) => {
		toastr.options = {
			closeButton: true,
			progressBar: true,
			showMethod: 'slideDown',
			// timeOut: 4000
		};
		if (type != '' && message != '') {
			if (type == 'success') {
				toastr.success(message);
			} else {
				toastr.error(message);
			}
		}
	}

	var convertFileToBase64 = (file) => {
		return new Promise((resolve, reject) => {
		  const reader = new FileReader();
		  reader.readAsDataURL(file);
		  reader.onload = () => resolve(reader.result);
		  reader.onerror = reject;
		});
	}

	// Ajax function to update model data based on selected brand
	var getModels = (url, type, modelId) => {
		$.ajax({
			url: url,
			type: "GET",
			success: function (response) {
				$(modelId).empty();
				if(type == 'dropdown'){
					$(modelId).parent().find('.dropdown-toggle-label').text('');
					$(modelId).parent().find('.dropdown-toggle-label').text('Model');

					$.each(response, function (key, val) {
						$(modelId).append('<li><a class="dropdown-item model-dropdown" href="javascript:;"><span class="dropdown-item-label">'+val+'</span></a></li>');
					});
				} else {
					$(modelId).append('<option value="" disabled selected>Any model</option>');
					$.each(response, function (key, val) {
						$(modelId).append('<option value='+ key +'>'+ val +'</option>');
					});

				}
			}
		});
	}

	// Selected Plan Submit
	$(document).on('click', '.submit-plan', function(event) {
		event.preventDefault();

		$('.select_addOn').remove();

		if($('.addOn-check:checked').length > 0) {
			$('.addOn-check:checked').each(function(index, elem){
				var addonUuid = $(this).data('addon-uuid');
				var newElement = `<input class="select_addOn" name=\"selected_addOn${index+1}\" type="hidden" value="${ addonUuid }">`;
				$(newElement).insertBefore('.planForm-last');
			});
		}

		$('#planForm').submit();

	});

	$(document).on('change', 'select[id="selectBrand"]', function() {
		var brand_uuid = $(this).find("option:selected").val();
		var elem = $('#boatModel');
		$.ajax({
			url: base_url + '/get-brand-models/' + brand_uuid,
			type: "GET",
			beforeSend: function () {
				elem.attr('disabled', 'disabled');
			},
			complete: function () {
				elem.removeAttr("disabled");
			},
			success: function (response) {
				elem.html('');
				elem.append(`<option value="" selected disabled>-- Select Your Model --</option>`);
				$.each(response.models, function (key, model) {
					elem.append(`
							<option value="${model.model_name}">${model.model_name}</option>
						`);

				});
			}
		});
	});

	$(document).on('change', '.filter', function() {
		$('#filterForm').submit();
	});

	// Select 2 for step one model dropdown
	 $("#selectBrand").select2({
		tags: true,
		createTag: function (params) {
		    return null;
		  },
	 });
	// Select 2 for step one model dropdown
	 $("#boatModel").select2({
		tags: true
	 });

	 // Select 2 for step four states dropdown
	 $("#State").select2({
		tags: true
	 });

	// Select 2 for step four states dropdown
	$("#userProfileStateSelect").select2({
		tags: true,
		createTag: function (params) {
		    return null;
		  },
	});

	// Select 2 for livewire for boat listings
	// $(".livewire-boat-sidebar-model").select2({
	//     tags: true
	// });

	$('form[id="stepTwoForm"]').validate({
    	errorElement: "span",
        rules: {
            fuel_capacity: "required",
            hull_material: "required",
            hull_id : {
            	minlength: 12
            },
            anchor_type: {
            	required: {
            		depends: function (element) {
            			return $('#anchorCheck').is(':checked');
            		}
            	}
            },
            generator_fuel_type: {
            	required: {
            		depends: function (element) {
            			return $('#generatorCheck').is(':checked');
            		}
            	}
            },
            generator_size: {
            	required: {
            		depends: function (element) {
            			return $('#generatorCheck').is(':checked');
            		}
            	}
            },
            generator_hours: {
            	required: {
            		depends: function (element) {
            			return $('#generatorCheck').is(':checked');
            		}
            	}
            },
            cabin_berths: {
            	required: {
            		depends: function (element) {
            			return $('#cabinCheck').is(':checked');
            		}
            	}
            },
            cabin_description: {
            	required: {
            		depends: function (element) {
            			return $('#cabinCheck').is(':checked');
            		}
            	}
            },
            galley_description: {
            	required: {
            		depends: function (element) {
            			return $('#galleyCheck').is(':checked');
            		}
            	}
            },
        },
        ignore: ':hidden:not(.summernote),.note-editable.card-block',
        errorPlacement: function(error, element) {
            if(element.attr("name") == "cabin_description") {
              	error.appendTo('.cabin_description-error');
            }
            else if(element.attr("name") == "galley_description") {
			    error.appendTo('.galley_description-error');
			}
            else {
			    error.insertAfter(element);
			}
        },
        messages: {
            fuel_capacity: {
                required: "Fuel Capacity is required",
            },
            hull_material: "Hull material is required",
            anchor_type: "Anchor Type is required",
            generator_fuel_type: "Generator Fuel Type is required",
            generator_size: "Generator Size is required",
            generator_hours: "Generator hours is required",
            cabin_berths: "Cabin Berths is required",
            cabin_description: "Cabin Description is required",
            galley_description: "Galley Description is required",
        },
        submitHandler: function(form) {
            form.submit();
        }
    });

	$('form[id="stepTwoForm"]').submit(function(e) {
		e.preventDefault();
        $('form[id="stepTwoForm"]').valid();
	});

	function CalculateAllPrices(){
		defaultSelectedValue = $("#default_selected_plan").val();
		addonSelectedValue = $("#default_addon_selected").val();
		discountSelectedValue = $("#default_coupon_selected").val();

		var showOverallCost = 0;

		showOverallCost = parseFloat(defaultSelectedValue) + parseFloat(addonSelectedValue);
		let originalSubTotalValue = showOverallCost;
		console.log('FINALDISCOUNTCOST');
		console.log(FINALDISCOUNTCOST);
		let couponValue = 0;
		if(FINALDISCOUNTCOST){
			let couponTypeValue = FINALDISCOUNTCOST.type;
			let couponAmountValue = FINALDISCOUNTCOST.amount;
			if(couponTypeValue == 'fixed'){
				couponValue = couponAmountValue;
				discountSelectedValue =  couponValue;
			}
			if(couponTypeValue == 'percentage'){
				couponValue = couponAmountValue/100;
				discountSelectedValue = (originalSubTotalValue * couponValue);
			}

			if(discountSelectedValue > 0 ){
				showOverallCost = originalSubTotalValue - discountSelectedValue;
			}

			if(couponTypeValue == 'free'){
				discountSelectedValue = originalSubTotalValue;
				showOverallCost = originalSubTotalValue - discountSelectedValue;
			}
		}

		$(".subTotalAmountLabel").text(parseFloat(originalSubTotalValue).toFixed(2));
		$(".discountAmountLabel").text(parseFloat(discountSelectedValue).toFixed(2));
		$(".show-overallCost").text(parseFloat(showOverallCost).toFixed(2));
	}

	function selectPlanShowhideElems() {
		if($('.apply-coupon-msg').hasClass('d-none')) {
			$('.apply-coupon-msg').removeClass('d-none')
		}
		if(!$('.coupon-applied-msg').hasClass('d-none')) {
			$('.coupon-applied-msg').addClass('d-none')
		}
		if($('.coupon-warning-icon').hasClass('d-none')) {
			$('.coupon-warning-icon').removeClass('d-none')
		}
		if(!$('.coupon-success-icon').hasClass('d-none')) {
			$('.coupon-success-icon').addClass('d-none')
		}
	}

	var realCost = $('.real_cost').val();
	/*Select Plans in select-plan page*/
    $(document).on('click', '.plan-select', function(event) {
    	$("#default_addon_selected").val(0);
		var plan_uuid = $(this).data('uuid');
		var plan_price = $(this).data('price');
		var base_url = $(this).data('ajax-url');
		$('.select_addOn').remove();

		if(!$(this).children().hasClass('btn-primary')) {
			$('.plan-btn').removeClass('btn-primary');
			$('.plan-btn').addClass('btn-outline-dark');
			$(this).children().addClass('btn-primary');
		}

		$.ajax({
			url: base_url + '/get-plan-AddOn/' + plan_uuid,
			type: "GET",
			success: function (response) {
				$('.overall-cost').text('');
				$('.addOns-list').html('');
				var idCount=0;
				$.each(response.addOns, function (key, val) {
					idCount = idCount++;
					$('.addOns-list').append(`<div class=\"card card-dark card-hover card-body px-4 mb-2\">
						<div class=\"form-check form-check-dark\">
							<input class=\"form-check-input addOn-check\" type=\"checkbox\" data-addon-uuid=\"${ val.uuid }\" data-addon-cost=\"${ val.addon_cost }\" id=\"addOn${ ++idCount }\">
							<label class=\"form-check-label d-sm-flex align-items-center justify-content-between\" for=\"addOn${ idCount }\"><span class="d-block px-1"><span class="d-block h6 text-dark mb-2">${ val.addon_name }</span></span><span class="d-block h4 text-dark mb-0">$${ val.addon_cost }</span></label>
						</div>
					</div>`);

				});
				$("#default_selected_plan").val(plan_price);
				CalculateAllPrices();
				$('.plan-uuid').val(plan_uuid);
			}
		});

	});

    /*Select Addons in select-plan page*/
	$(document).on('click', '.addOn-check', function(e) {
		var addOnCostFinal = 0 ;
		$('.addOn-check').each(function () {
		    if($(this).is(":checked")) {
		    	var addOnCost = $(this).data('addon-cost');
				addOnCostFinal = addOnCostFinal + addOnCost;
			}
		});
		$("#default_addon_selected").val(addOnCostFinal);
		CalculateAllPrices();

	});

	/*Verify Coupon*/
    $(document).on('click', '.coupon-verify-btn', function(event) {
    	realCost = $("#default_selected_plan").val();
    	console.log(realCost);
    	var coupon = $("#coupon_code").val();

    	$.ajax({
            url: base_url + '/verify-coupon/' + coupon,
            type: "GET",
            beforeSend: function () {
            	if ($('.coupon-spinner').hasClass("d-none")) {
                    $('.coupon-spinner').removeClass("d-none");
                }
                $('.coupon-verify-btn').prop('disabled', true);
			},
			complete: function () {
				$('.coupon-spinner').addClass("d-none");
				$('.coupon-verify-btn').prop('disabled', false);
			},
			success: function (response) {
				if(response.success) {
					var coupon = response.coupon;
					if(coupon){
						FINALDISCOUNTCOST = coupon;
					}

					if(coupon.type == 'percentage') {
						if($('.stripe-form').hasClass('d-none')) {
							$('.stripe-form').removeClass('d-none');
						}
						if($('.terms-div').hasClass('d-none')) {
							$('.terms-div').removeClass('d-none');
						}
						if($('.auto-renew-div').hasClass('d-none')) {
							$('.auto-renew-div').removeClass('d-none');
						}
						if(!$('.save-free-boat').hasClass('d-none')) {
							$('.save-free-boat').addClass('d-none')
						}
						if($('.plan-submit').hasClass('d-none')) {
							$('.plan-submit').removeClass('d-none')
						}
					}
					else if(coupon.type == 'fixed') {
						if($('.stripe-form').hasClass('d-none')) {
							$('.stripe-form').removeClass('d-none');
						}
						if($('.terms-div').hasClass('d-none')) {
							$('.terms-div').removeClass('d-none');
						}
						if($('.auto-renew-div').hasClass('d-none')) {
							$('.auto-renew-div').removeClass('d-none');
						}
						if(!$('.save-free-boat').hasClass('d-none')) {
							$('.save-free-boat').addClass('d-none')
						}
						if($('.plan-submit').hasClass('d-none')) {
							$('.plan-submit').removeClass('d-none')
						}
					}
					else if(coupon.type == 'free') {
						if(!$('.stripe-form').hasClass('d-none')) {
							$('.stripe-form').addClass('d-none');
						}
						if(!$('.terms-div').hasClass('d-none')) {
							$('.terms-div').addClass('d-none');
						}
						if(!$('.auto-renew-div').hasClass('d-none')) {
							$('.auto-renew-div').addClass('d-none');
						}
						if($('.save-free-boat').hasClass('d-none')) {
							$('.save-free-boat').removeClass('d-none')
						}
						if(!$('.plan-submit').hasClass('d-none')) {
							$('.plan-submit').addClass('d-none')
						}
					}
					if(!$('.apply-coupon-msg').hasClass('d-none')) {
						$('.apply-coupon-msg').addClass('d-none')
					}
					if($('.coupon-applied-msg').hasClass('d-none')) {
						$('.coupon-applied-msg').removeClass('d-none')
					}
					if(!$('.coupon-warning-icon').hasClass('d-none')) {
						$('.coupon-warning-icon').addClass('d-none')
					}
					if($('.coupon-success-icon').hasClass('d-none')) {
						$('.coupon-success-icon').removeClass('d-none')
					}
					$('.coupon-verify-btn').remove();
					$('#coupon_code_section').append(`
						<button type="button" class="btn btn-outline-primary d-block remove-coupon">
                            <span class="spinner-border spinner-border-sm me-2 d-none remove-spinner" role="status" aria-hidden="true"></span><span class="fi-x remove-coupon-icon"></span>
                        </button>`);
					$('#is_coupon_valid').val('true');
					$('#coupon_code').prop('readonly', true);
					CalculateAllPrices();
					toastr.success('Coupon Verified Successfully');
				}
			},
			error: function (reject) {
				if($('.stripe-form').hasClass('d-none')) {
					$('.stripe-form').removeClass('d-none');
				}
				if($('.terms-div').hasClass('d-none')) {
					$('.terms-div').removeClass('d-none');
				}
				if($('.auto-renew-div').hasClass('d-none')) {
					$('.auto-renew-div').removeClass('d-none');
				}
				if(!$('.save-free-boat').hasClass('d-none')) {
					$('.save-free-boat').addClass('d-none')
				}
				if($('.plan-submit').hasClass('d-none')) {
					$('.plan-submit').removeClass('d-none')
				}
				selectPlanShowhideElems();
				$('#is_coupon_valid').val(false);
				$("#coupon_code").val('');
				$('#coupon_code').prop('readonly', false);
				FINALDISCOUNTCOST = ' ';
				CalculateAllPrices();
				toastr.error('Invalid Coupon');
			}
		});
    });

	/*Remove Coupon*/
	$(document).on('click', '.remove-coupon', function(event) {
		$.ajax({
            url: base_url + '/remove-coupon/',
            type: "GET",
            beforeSend: function () {
            	if(!$('.remove-coupon-icon').hasClass('d-none')) {
					$('.remove-coupon-icon').addClass('d-none')
				}
				if($('.remove-spinner').hasClass('d-none')) {
					$('.remove-spinner').removeClass('d-none')
				}
				$('.remove-coupon').prop('disabled', true);
			},
			complete: function () {
				if($('.remove-coupon-icon').hasClass('d-none')) {
					$('.remove-coupon-icon').removeClass('d-none')
				}
				if(!$('.remove-spinner').hasClass('d-none')) {
					$('.remove-spinner').addClass('d-none')
				}
				$('.remove-coupon').prop('disabled', false);
			},
			success: function (response) {
				selectPlanShowhideElems();
				$('.remove-coupon').remove();
				$('#coupon_code_section').append(`<button type="button" class="btn btn-outline-primary d-block coupon-verify-btn">
                        <span class="spinner-border spinner-border-sm me-2 d-none coupon-spinner" role="status" aria-hidden="true"></span>VERIFY
                    </button>`);
				$('#is_coupon_valid').val(false);
				$("#coupon_code").val('');
				$('#coupon_code').prop('readonly', false);
				$(".discountAmountLabel").text('0.00');
				FINALDISCOUNTCOST = ' ';
				CalculateAllPrices();
				toastr.success('Coupon Removed Successfully');
			},
			error: function (reject) {
				toastr.error('Failed to remove coupon');
			}
		});
	});

	/*Save free boat*/
	$(document).on('click', '.save-free-boat', function(event) {
		event.preventDefault();

		var form = document.getElementById('freeBoatForm');
		form.submit();

	});

	/*Anchor Checkbox*/
    $(document).on('click', '#anchorCheck', function(event) {
        if($(this).is(":checked")) {
            $('.anchor-type').removeClass('d-none');
        }else {
            $('.anchor-type').addClass('d-none');
        }
    });

    /*Head Checkbox*/
    $(document).on('click', '#headCheck', function(event) {
        if($(this).is(":checked")) {
            $('.head-section').removeClass('d-none');
        }else {
            $('.head-section').addClass('d-none');
        }
    });

    /*Generator Checkbox*/
    $(document).on('click', '#generatorCheck', function(event) {
        if($(this).is(":checked")) {
            $('.generator-section').removeClass('d-none');
        }else {

        	$("#generator_fuel_type").val('');
        	$("#generator_size").val('');
        	$("#generator_hours").val('');

            $('.generator-section').addClass('d-none');
        }
    });

    if($('#cabinCheck').is(":checked")){
    	$("input[name*=cabin_description]").rules('add', {
            required: true,
            messages: {
                required: "Cabin Description is required"
            }
        });
        $("#cabinDescription").prop("required", true);
    }
    else
    {
		$("#berths").val('');
		$('#cabinDescription').summernote('reset');
		// $("#cabinDescription").val('');
	}

    /*Cabin Checkbox*/
    $(document).on('click', '#cabinCheck', function(event) {
        if($(this).is(":checked")) {
            $("input[name*=cabin_berths]").rules('add', {
                required: true,
                messages: {
                    required: "Cabin berths is required"
                }
            });
            $("input[name*=cabin_description]").rules('add', {
                required: true,
                messages: {
                    required: "Cabin Description is required"
                }
            });
            $("#cabinDescription").prop("required", true);
            $('.cabin-section').removeClass('d-none');
        }else {
        	$("#cabinDescription").prop("required", false);
            $('.cabin-section').addClass('d-none');
        }
    });

    /*Galley Checkbox*/
    $(document).on('click', '#galleyCheck', function(event) {
        if($(this).is(":checked")) {
        	$("input[name*=galley_description]").rules('add', {
                required: true,
                messages: {
                    required: "Galley Description is required"
                }
            });
        	$("#galleyDescription").prop("required", true);
            $('.galley-section').removeClass('d-none');
        }else {
        	$("#galleyDescription").prop("required", false);
            $('.galley-section').addClass('d-none');
        }
    });

	$(document).on('change', '.boat-type', function() {
		var boatType = $(this).val();
		$.ajax({
            url: base_url + '/get-type-category/' + boatType,
            type: "GET",
            beforeSend: function () {

				$("#category").attr('disabled', 'disabled');
			},
			complete: function () {
				$("#category").removeAttr("disabled");
			},
			success: function (response) {
				$('#category').html('');
				$('#category').append(`<option value="" selected disabled>-- Select Category --</option>`);
				$.each(response.categories, function (key, category) {
					$('#category').append(`
							<option value="${category.uuid}">${category.name}</option>
						`);
				});
			}
		});
	});

    $(document).on('click', '#addEngine', function() {
        var num     = $('.engineSection').length;
        var newNum  = new Number(num + 1);
        var prevEngineTypeVal = $("#engineType" + ( newNum-1)).val();
        var prevFuelTypeVal = $("#fuelType" + ( newNum-1)).val();

        var newSection = $('#engineSection' + num).clone().attr("id", "engineSection" + newNum);
        newSection.children(":first").children(":first").children(":first").children("span").attr("id", "engineCount" + newNum).text(newNum);
        newSection.children(":first").children(":first").children("button").removeClass("d-none");
        
        if(prevEngineTypeVal == '' || prevEngineTypeVal == null) {
        	newSection.children(":nth-child(2)").children(":first").children("select").find('option:first').prop('selected', true);
        }else {
        	newSection.children(":nth-child(2)").children(":first").children("select").attr("id", "engineType" + newNum).attr("name", "engine_type" + newNum).val(prevEngineTypeVal);
        }
        if(prevFuelTypeVal == '' || prevFuelTypeVal == null) {
        	newSection.children(":nth-child(2)").children(":nth-child(2)").children("select").find('option:first').prop('selected', true);
        }else {
        	newSection.children(":nth-child(2)").children(":nth-child(2)").children("select").attr("id", "fuelType" + newNum).attr("name", "fuel_type" + newNum).val(prevFuelTypeVal);
        }
        newSection.children(":nth-child(3)").children(":first").children("input").attr("id", "engineMake" + newNum).attr("name", "make" + newNum);
        newSection.children(":nth-child(3)").children(":nth-child(2)").children("input").attr("id", "engineModel" + newNum).attr("name", "model" + newNum);
        newSection.children(":nth-child(4)").children(":first").children("input").attr("id", "horsePower" + newNum).attr("name", "horse_power" + newNum);
        newSection.children(":nth-child(4)").children(":nth-child(2)").children("input").attr("id", "engineHours" + newNum).attr("name", "engine_hours" + newNum);

        newSection.insertAfter('#engineSection' + num);

        // newSection.find('span.error').text('');
        newSection.find('span.error').remove();

        $("#delEngine").removeClass("d-none");

    });
    $(document).on('click', '#addNewEngine', function() {
        var num     = $('.engineSection').length;
        var newNum  = new Number(num + 1);

        var newSection = $('#engineSection' + num).clone().attr("id", "engineSection" + newNum);
        newSection.children(":first").children(":first").children(":first").children("span").attr("id", "engineCount" + newNum).text(newNum);
        newSection.children(":first").children(":first").children("button").removeClass("d-none");
        newSection.children(":nth-child(2)").children(":first").children("select").attr("id", "engineType" + newNum).attr("name", "engine_type" + newNum).val('');

        newSection.children(":nth-child(2)").children(":first").children("select").find('option:first').prop('selected', true);
        newSection.children(":nth-child(2)").children(":nth-child(2)").children("select").attr("id", "fuelType" + newNum).attr("name", "fuel_type" + newNum).val('');
        newSection.children(":nth-child(2)").children(":nth-child(2)").children("select").find('option:first').prop('selected', true);
        newSection.children(":nth-child(3)").children(":first").children("input").attr("id", "engineMake" + newNum).attr("name", "make" + newNum).val('');
        newSection.children(":nth-child(3)").children(":nth-child(2)").children("input").attr("id", "engineModel" + newNum).attr("name", "model" + newNum).val('');
        newSection.children(":nth-child(4)").children(":first").children("input").attr("id", "horsePower" + newNum).attr("name", "horse_power" + newNum).val('');
        newSection.children(":nth-child(4)").children(":nth-child(2)").children("input").attr("id", "engineHours" + newNum).attr("name", "engine_hours" + newNum).val('');

        newSection.insertAfter('#engineSection' + num);

        newSection.find('span.error').remove();

        $("#delEngine").removeClass("d-none");

    });

    $(document).on('click', "#delEngine", function() {

        var num = parseInt($(this).prev().children().text(), 10);

        $("#engineSection" + num).remove();     // remove the selected element
        var sectionLength = $(".engineSection").length;

        $('.engineSection').each(function(index, elem) {
            var newNum = index+1;

            $(this).attr("id", "engineSection" + newNum);
            $(this).children(":first").children(":first").children(":first").children("span").attr("id", "engineCount" + newNum).text(newNum);
            $(this).children(":nth-child(2)").children(":first").children("select").attr("id", "engineType" + newNum).attr("name", "engine_type" + newNum);
            $(this).children(":nth-child(2)").children(":nth-child(2)").children("select").attr("id", "fuelType" + newNum).attr("name", "fuel_type" + newNum);
            $(this).children(":nth-child(3)").children(":first").children("input").attr("id", "engineMake" + newNum).attr("name", "make" + newNum);
            $(this).children(":nth-child(3)").children(":nth-child(2)").children("input").attr("id", "engineModel" + newNum).attr("name", "model" + newNum);
            $(this).children(":nth-child(4)").children(":first").children("input").attr("id", "horsePower" + newNum).attr("name", "horse_power" + newNum);
            $(this).children(":nth-child(4)").children(":nth-child(2)").children("input").attr("id", "engineHours" + newNum).attr("name", "engine_hours" + newNum);

        });

        // if only one element remains, hide the "remove" button
        if (sectionLength == 1) {
            $("#delEngine").addClass("d-none");
        } else {
            $("#delEngine").removeClass("d-none");
        }
    });

    $(document).on('keypress', '.engine-hours', function(e) {
        var regex = new RegExp("^[0-9]+$");
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (regex.test(str)) {
            return true;
        }

        e.preventDefault();
        return false;
    });

    $(document).on('keypress', '#hullId, #fuelCapacity, #holding, #freshWater, #cruisingSpeed, #maxSpeed, #head, #engine_count', function(e) {
        var regex = new RegExp("^[a-zA-Z0-9]+$");
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (regex.test(str)) {
            return true;
        }
        e.preventDefault();
        return false;
    });

    $(document).on('change', '#userProfileCountrySelect', function() {
        var country = $(this).find("option:selected").val();
        var stateElement = $('#userProfileStateSelect');
        $.ajax({
            url: base_url + '/get-states/' + country,
            type: "GET",
            beforeSend: function () {
                //stateElement.attr('disabled', 'disabled');
            },
            success: function (response) {
                $('.profile-state-value').html('Not specified');
                stateElement.html('');
                //stateElement.removeAttr("disabled");

                if(response.states.length > 0) {
                    stateElement.append(`<option value="" selected disabled>-- Select State --</option>`);
                    $.each(response.states, function (key, state) {
                    stateElement.append(`
                            <option value="${state.name}">${state.name}</option>
                        `);

                    });
                }
            }
        });
    });

    $(document).on('change', '.select-country', function() {
        var min = 0;
        var max = 8;
        if( $(this).val() == 'United States') {
            min = 5;
            max = 5;
        }
        $("input[name*=zip_code]").rules('add', {
            minlength:min,
            maxlength:max,
            messages: {
                required: "Zip Code is required "
            }
        });

        var country = $(this).find("option:selected").val();
        var elem = $('.select-state');
        $.ajax({
            url: base_url + '/get-states/' + country,
            type: "GET",
            beforeSend: function () {
                elem.attr('disabled', 'disabled');
            },
            success: function (response) {
                elem.html('');
                elem.removeAttr("disabled");

                if(response.states.length > 0) {
                    elem.append(`<option value="" selected disabled>-- Select State --</option>`);
                    $.each(response.states, function (key, state) {
                    elem.append(`
                            <option value="${state.name}">${state.name}</option>
                        `);

                    });
                }
            }
        });
    });

    $('#userProfileStateSelect').on('select2:select', function (e) {
        var data = e.params.data;
        $('#stateValue').html(data.id);
    });
    // Package terms and Conditions
    $(document).on('click', '#terms', function(){

        if($(this).is(":checked")) {
            $('.plan-submit').removeAttr('disabled');
        }else {
            $('.plan-submit').attr('disabled', 'disabled');
        }
    });

   // JS helps to set live wire listings view types
   $(document).on('click', '.grid-livewires-view', function(){
        $('#viewType').val('grid');
        document.addEventListener('livewire:load', function () {
            var element = document.getElementById('#viewType');
            element.dispatchEvent(new Event('input'));
        });
		if ($(".catalog-livewires-view").hasClass('active')) {
			$(".catalog-livewires-view").removeClass('active');
		}
		if (!$(".catalog-livewires-card").hasClass('d-none')) {
			$(".catalog-livewires-card").addClass('d-none');
		}
		if (!$(".grid-livewires-view").hasClass('active')) {
			$(".grid-livewires-view").addClass('active');
		}
		if ($(".grid-livewires-card").hasClass('d-none')) {
			$(".grid-livewires-card").removeClass('d-none');
		}
	});

   // JS helps to set live wire listings view types
   $(document).on('click', '.catalog-livewires-view', function(){
    $('#viewType').val('list');

	if ($(".grid-livewires-view").hasClass('active')) {
		$(".grid-livewires-view").removeClass('active');
	}
	if (!$(".grid-livewires-card").hasClass('d-none')) {
		$(".grid-livewires-card").addClass('d-none');
	}
	if (!$(".catalog-livewires-view").hasClass('active')) {
		$(".catalog-livewires-view").addClass('active');
	}
	if ($(".catalog-livewires-card").hasClass('d-none')) {
		$(".catalog-livewires-card").removeClass('d-none');
	}
});

	//This function use to set model value for homepage
	$(document).on('click', '.model-dropdown', function() {
		//$(this).addClass('active');
		var selectedMenuContent = $(this).find( '.dropdown-item-label' ).html();
		$(this).parents().find('.modal-label').text('');
		$(this).parents().find('.modal-label').text(selectedMenuContent);
		$('.model-input').val(selectedMenuContent);
	});

	// Function to update model data based on selected brand
	$(document).on('click', '.get-models', function() {
		var url = $(this).data('ajax-url');
		var type = $(this).data('type');
		var modelId = $(this).data('model-id');
		getModels(url, type, modelId);
	});

	// Function to update model data based on selected brand
	$(document).on('change', '.model-select', function() {
		var slug = $(this).val();
		var url = base_url + '/api/models/' + slug;
		var type = $(this).data('type');
		var modelId = $(this).data('model-id');
		getModels(url, type, modelId);
	});

    /*Summernote for all forms*/
    $('.summernote').summernote({
        toolbar: [
            // [groupName, [list of button]]
            ['style', ['bold', 'italic', 'underline']],
            // ['font', ['strikethrough', 'superscript', 'subscript']],
            // ['fontsize', ['fontsize']],
            // ['color', ['color']],
            ['para', ['ul', 'ol']],
            // ['height', ['height']]
        ],
        placeholder: '',
        tabSize: 2,
        height: 80
    });

	// $(".truncate").each(function() {
	//     var showChar = 30;
	//     var ellipsesText = "...";
	//     var content = $(this).html();
	//     if (content.length > showChar) {
	//       var c = content.substr(0, showChar);
	//       var h = content;
	//       var html = '<div class="truncate-text" style="display:block">' + c + '<span class="moreellipses">' + ellipsesText + '&nbsp;&nbsp;<a href="" class="moreless more">more</a></span></span></div><div class="truncate-text" style="display:none">' + h + '<a href="" class="moreless less">Less</a></span></div>';
	//       $(this).html(html);
	//     }
	//   });

	//   $(".moreless").click(function() {
	//     var thisEl = $(this);
	//     var cT = thisEl.closest(".truncate-text");
	//     var tX = ".truncate-text";

	//     if (thisEl.hasClass("less")) {
	//       cT.prev(tX).toggle();
	//       cT.slideToggle();
	//     } else {
	//       cT.toggle();
	//       cT.next(tX).fadeToggle();
	//     }
	//     return false;
	//   });

// Modal View settings use to show form contents modal
$(document).on('click', '.open-model-btn', function () {
	let url = $(this).attr("data-href");
	$("#authModalBox .modal-body").load(url, function (result) {
	  $("#authModalBox").modal({
		backdrop: "static",
		keyboard: false,
		show: true,
	  });

	});
  });

// Save modal form
$(document).on('click', '.save-data', function(e) {

	e.preventDefault();
	var $form = $(this).parents('form');
	var url = $form.attr('action');
	$.ajax({
		type: $form.attr('method'),
		url: url,
		data: $form.serialize(),
		success: function(response) {
			location.reload();
		},
		error: function (reject) {

			if (reject.status === 422) {
				var errors = $.parseJSON(reject.responseText);
				$.each(errors.errors, function (key, val) {
					if (!$('#' + key).hasClass("is-invalid")) {
						$('#' + key).addClass("is-invalid");
					}
					$("#" + key + "_error").text(val);
				});
			}
		}
	});
});

    $('.profile-upload').on('FilePond:addfile', function(e) {
		///console.log('file added event', e.detail.file.file);
		try {
			convertFileToBase64(e.detail.file.file).then((result)=>{
				$('#newFile').val(result);
			});
			//do something with above data string
		  } catch(ex){
			//console.log(ex);
			//handle error
		  }
	});

    /*Step-four Images edit*/
	var files = {};
	if($('.server-image').length) {
		// alert("heheh");
    	var boat_uuid = $('.server-image').data('boat-uuid');
	    var files = function () {
	    	var files = {};
	    	$.ajax({
	    		async: false,
	            url: base_url + '/get-images/' + boat_uuid,
	            type: "GET",
	            success: function (response) {
	            	var collectImages = [];
	            	var imagesNum = response.imagesNum;

	                $.each(response.images, function (key, imagePath) {
	                	let image = imagePath.split("/");
	                	let imagename = image[4];
	                	files[imagename] = base_url + "/" + imagePath;
					});

					for(let img in files) {
						collectImages.push(files[img]);
					}

				    const inputElement = document.querySelector('.boat-images-uploader');
				    var uploadBtn = `<div class="btn btn-primary"><i class="fi-cloud-upload me-1"></i>Upload Images</div><div class="text-dark opacity-70">or drag them in</div>`;
				    const pond = FilePond.create(inputElement, {
				        name: 'image',
				        allowMultiple: true,
				        maxFiles: imagesNum,
				        acceptedFileTypes: [
					        'image/png',
					        'image/jpeg',
					        'image/*'
					    ],
					    itemInsertLocation: 'after',
					    itemInsertInterval: 100,
					    required: true,
				        allowBrowse: true,
				        labelIdle: uploadBtn,
				        labelButtonProcessItem: false,

				        // allowImagePreview: true,

				    });

			    	try {
			    		pond.addFiles(collectImages);
				    } catch(ex){
				    	console.log(ex);
				    }

	            }
	        });

	        return files;
	    }();
	}

	/*Images added one by one*/
	$('.boat-images-uploader').on('FilePond:addfile', function (e) {
		if (!$('.images-warning').hasClass("d-none")) {
	        $('.images-warning').addClass('d-none');
	    }
		try {
			convertFileToBase64(e.detail.file.file).then((result)=>{
				var file_name =  e.detail.file.file.name;
				files[file_name] = result;

				$('.image-uploadDiv').append(`<input type="hidden" class="boat-images" name="boat_images[]"  value="${result}">`);
			});
		} catch(ex){
			console.log(ex);
		}
	});

	/*If tried to upload images more than the limit*/
	$('.boat-images-uploader').on('FilePond:warning', function (e) {
		$('.images-warning').removeClass('d-none');
	});

	/*Remove images from preview*/
    $('.boat-images-uploader').on('FilePond:removefile', function (e) {
		var remove_file = e.detail.file.file.name;
		$('.boat-images').remove();
		delete files[remove_file];

		for(let fileName in files) {
			$('.image-uploadDiv').append(`<input type="hidden" class="boat-images" name="boat_images[]"  value="${files[fileName]}">`);
		}
	});

	/*Step-four videos edit*/
	var videofiles = {};
	if($('.server-video').length) {

    	var boat_uuid = $('.server-video').data('boat-uuid');
	    var videofiles = function () {
	    	var videofiles = {};
	    	$.ajax({
	    		async: false,
	            url: base_url + '/get-videos/' + boat_uuid,
	            type: "GET",
	            success: function (response) {
	            	var collectVideos = [];
	            	var videosNum = response.videosNum;

	            	console.log(response.videos);

	                $.each(response.videos, function (key, videoPath) {
	                	let video = videoPath.split("/");
	                	let videoname = video[4];
	                	videofiles[videoname] = base_url + "/" + videoPath;
					});

					for(let vid in videofiles) {
						collectVideos.push(videofiles[vid]);
					}

				    const inputElement = document.querySelector('.boat-videos-uploader');
				    var uploadBtn = `<div class="btn btn-primary mb-3"><i class="fi-cloud-upload me-1"></i>Upload Videos</div><div class="text-dark opacity-70">or drag them in</div>`;
				    const pond = FilePond.create(inputElement, {
				        allowMultiple: true,
				        maxFiles: videosNum,
				        acceptedFileTypes: [
				        	'video/mp4',
				        	'video/x-m4v',
				        	'video/*'
					    ],
				        allowBrowse: true,
				        labelIdle: uploadBtn,
				        labelButtonProcessItem: true
				    });
			    	try {
			    		pond.addFiles(collectVideos);
				    } catch(ex){
				    	console.log(ex);
				    }

	            }
	        });

	        return videofiles;
	    }();
	}

	/*Videos added one by one*/
	$('.boat-videos-uploader').on('FilePond:addfile', function (e) {
		if (!$('.videos-warning').hasClass("d-none")) {
	        $('.videos-warning').addClass('d-none');
	    }
		try {
			convertFileToBase64(e.detail.file.file).then((result)=>{
				var video_name =  e.detail.file.file.name;
				videofiles[video_name] = result;

				$('.video-uploadDiv').append(`<input type="hidden" class="boat-videos" name="boat_videos[]"  value="${result}">`);
			});
		} catch(ex){
			console.log(ex);
		}
	});

	/*If tried to upload videos more than the limit*/
	$('.boat-videos-uploader').on('FilePond:warning', function (e) {
		$('.videos-warning').removeClass('d-none');
	});

	/*Remove videos from preview*/
    $('.boat-videos-uploader').on('FilePond:removefile', function (e) {
		var remove_file = e.detail.file.file.name;
		$('.boat-videos').remove();
		delete videofiles[remove_file];

		for(let fileName in videofiles) {
			$('.video-uploadDiv').append(`<input type="hidden" class="boat-videos" name="boat_videos[]"  value="${videofiles[fileName]}">`);
		}
	});

    $(document).on('click', '.sell-boats', function () {
        if($(this).data('user-logged')){
            $('.is-sell-boat').val(false);
        }else{
            $('.is-sell-boat').val(true);
        }
    });

    $(document).on('click', '.user-sign-in', function () {
        $('.is-sell-boat').val(false);
    });

    // Function helps to send email to the boat seller
    $(document).on('submit', '.send-mail-to-boat-seller', function(event) {
        event.preventDefault();
        var message = $(this).find('.message-to-seller').val();
        var email = $(this).find('.seller-email').val();
        var submitButtonId = $(this).data('submit');
        $.ajax({
            type: 'POST',
            url: base_url+'/email-to-yacht-seller',
            data: {
                message : message,
                email:email
            },
            beforeSend: function() {
                if ($('#loader').hasClass("d-none")) {
                    $('#loader').removeClass("d-none");
                }
                if (!$('#'+submitButtonId).hasClass("disabled")) {
                    $('#'+submitButtonId).addClass("disabled");
                }
            },
            success: function(response) {
                tostrMessage('success', "Message sended successfully!");
            },
            error: function (reject) {
                tostrMessage('error', 'Failed to send message!');
            },
            complete:function () {
                $('.message-to-seller').val('');
                $('.send-mail-to-boat-seller')[0].reset();
                if ($(".send-mail-to-boat-seller").hasClass('was-validated')) {
                    $(".send-mail-to-boat-seller").removeClass('was-validated');
                }

                if($('#sendMail').hasClass("show")) {
                    $('#sendMail').removeClass("show");
                }
                if ($('#'+submitButtonId).hasClass("disabled")) {
                    $('#'+submitButtonId).removeClass("disabled");
                }
                if (!$('#loader').hasClass("d-none")) {
                    $('#loader').addClass("d-none");
                }
            }
        });
    });

    /*Cancel Subscription Modal Setup*/
    $('#cancelSubscriptionModal').modal({backdrop: 'static', keyboard: false});

    /*Cancel Subscription*/
    $(document).on('click', '.cancel-subscription', function(){
    	var subscription_name = $(this).data('subscription-name');
    	$("#confirm-cancellation-subscription").attr('data-subscription-name', subscription_name);
    	$('#cancelSubscriptionModal').modal('show');
    });

    /*Cancel Subscription Modal*/
    $(document).on('click', '.confirm-cancellation-subscription', function(){

        var subscriptionName = $(this).data('subscription-name');
        var url = base_url + '/cancel-subscription/' + subscriptionName;
        $.ajax({
                type: 'POST',
                url: url,
                beforeSend: function() {
                	$('.confirm-cancellation-subscription').addClass("disabled");
                    $('.cancel-spinner').show();
                },
                success: function(response) {
                	if(response.success){
                		$('.cancel-subscription-text').html(`<h4 class="h4 text-dark d-flex justify-content-center p-4">Your Subscription Auto Renewal has cancelled!</h4>`);
                		$('.cancel-sub-btn-div').html(`<button type="button" class="btn btn-primary mx-2 close-subscription-modal">Ok</button>`);
                	}
                },
                errror: function(reject) {
                	$('.cancel-spinner').hide();
            		if ($('.confirm-cancellation-subscription').hasClass("disabled")) {
		                $('.confirm-cancellation-subscription').removeClass("disabled");
		            }
                    tostrMessage('error', 'Cannot Cancel this Subscription!');
                    $('#cancelSubscriptionModal').modal('hide');
                }
            });
    });

    /*Close Cancelled Subscription Modal after confirm*/
	$(document).on('click', '.close-subscription-modal', function(){
		location.reload();
	});

    /*Delete Listing Modal Setup*/
    $('#deleteListingModal').modal({backdrop: 'static', keyboard: false})

    /*Delete Listing*/
    $(document).on('click', '.delete-listing', function(){
    	var boat_uuid = $(this).data('boat-uuid');
    	$("#confirm-delete-listing").attr('data-boat-uuid', boat_uuid);
    	$('#deleteListingModal').modal('show');
    });

    /*Delete Listing Modal*/
    $(document).on('click', '#confirm-delete-listing', function(){
    	var boat_uuid = $(this).data('boat-uuid');
    	var url = base_url + '/delete-yacht/' + boat_uuid;
    	$.ajax({
                type: 'POST',
                url: url,
                beforeSend: function() {
                	$('#confirm-delete-listing').addClass("disabled");
                    $('.delete-spinner').show();
                },
                success: function(response) {
                	if(response.success){
                		$('.delete-text').html(`<h4 class="h4 text-dark d-flex justify-content-center p-4">Your Yacht removed Successfully!</h4>`);
                		$('.delete-btn-div').html(`<button type="button" class="btn btn-primary mx-2 close-delete-modal">Ok</button>`);
                	}else {
                		$('.cancel-spinner').hide();
                		if ($('#confirm-delete-listing').hasClass("disabled")) {
			                $('#confirm-delete-listing').removeClass("disabled");
			            }
                        tostrMessage('error', 'Cannot delete this Yacht!');
	                    $('#deleteListingModal').modal('hide');
                	}
                },
                errror: function(reject) {
                	$('.cancel-spinner').hide();
            		if ($('#confirm-delete-listing').hasClass("disabled")) {
		                $('#confirm-delete-listing').removeClass("disabled");
		            }
                    tostrMessage('error', 'Cannot delete this Yacht!');
                    $('#deleteListingModal').modal('hide');
                }
            });
    });

    /*Close Deleted Yacht Modal after deletion*/
	$(document).on('click', '.close-delete-modal', function(){
		location.reload();
	});

}

/** Function helps to clear all form data when modal closed */
$("#signInModal").on("hide.bs.modal", function () {
    $('#loginForm')[0].reset();
    /** Clear email fields */
    var emailId = '#signInEmail';
    if ($(emailId).hasClass("is-invalid")) {
        $(emailId).removeClass("is-invalid");
    }
    $('#isSellBoat').val(false);
    $('.email_error').html('');
    $(emailId+'-error').html('');

    /** Clear password fields */
    var passwordId = '#signInPassword';
    if ($(passwordId).hasClass("is-invalid")) {
        $(passwordId).removeClass("is-invalid");
    }
    $('.password_error').html('');
    $(passwordId+'-error').html('');
});
$("#signUpModal").on("hide.bs.modal", function () {
    $('#signupForm')[0].reset();

    /** Clear first name fields */
    var firstNameId = '#signupFirstName';
    if ($(firstNameId).hasClass("is-invalid")) {
        $(firstNameId).removeClass("is-invalid");
    }
    $('.first_name_error').html('');
    $(firstNameId+'-error').html('');

    /** Clear last name fields */
    var lastNameId = '#signupLastName';
    if ($(lastNameId).hasClass("is-invalid")) {
        $(lastNameId).removeClass("is-invalid");
    }
    $('.last_name_error').html('');
    $(lastNameId+'-error').html('');

    /** Clear contact number fields */
    var contactNumberId = '#signupContactNumber';
    if ($(contactNumberId).hasClass("is-invalid")) {
        $(contactNumberId).removeClass("is-invalid");
    }
    $('.contact_number_error').html('');
    $(contactNumberId+'-error').html('');

    /** Clear email fields */
    var emailId = '#signupEmail';
    if ($(emailId).hasClass("is-invalid")) {
        $(emailId).removeClass("is-invalid");
    }
    $('.email_error').html('');
    $(emailId+'-error').html('');

    /** Clear email fields */
    var passwordId = '#signupPassword';
    if ($(passwordId).hasClass("is-invalid")) {
        $(passwordId).removeClass("is-invalid");
    }
    $('.password_error').html('');
    $(passwordId+'-error').html('');

    /** Clear email fields */
    var confirmPasswordId = '#signupPasswordConfirm';
    if ($(confirmPasswordId).hasClass("is-invalid")) {
        $(confirmPasswordId).removeClass("is-invalid");
    }
    $('.email_error').html('');
    $(confirmPasswordId+'-error').html('');
});

/** Function helps to clear all form data when modal closed */
$("#resetModal").on("hide.bs.modal", function () {
    $('#resetForm')[0].reset();
    /** Clear email fields */
    var emailId = '#resetEmail';
    if ($(emailId).hasClass("is-invalid")) {
        $(emailId).removeClass("is-invalid");
    }
    $('.email_error').html('');
    $(emailId+'-error').html('');
});

let setView = (viewType) =>{
    if(viewType == 'grid'){
        if ($(".catalog-livewires-view").hasClass('active')) {
            $(".catalog-livewires-view").removeClass('active');
        }
        if (!$(".catalog-livewires-card").hasClass('d-none')) {
            $(".catalog-livewires-card").addClass('d-none');
        }
        if (!$(".grid-livewires-view").hasClass('active')) {
            $(".grid-livewires-view").addClass('active');
        }
        if ($(".grid-livewires-card").hasClass('d-none')) {
            $(".grid-livewires-card").removeClass('d-none');
        }

    } else {
        if ($(".grid-livewires-view").hasClass('active')) {
            $(".grid-livewires-view").removeClass('active');
        }
        if (!$(".grid-livewires-card").hasClass('d-none')) {
            $(".grid-livewires-card").addClass('d-none');
        }
        if (!$(".catalog-livewires-view").hasClass('active')) {
            $(".catalog-livewires-view").addClass('active');
        }
        if ($(".catalog-livewires-card").hasClass('d-none')) {
            $(".catalog-livewires-card").removeClass('d-none');
        }
    }
}

window.addEventListener('livewire-list-updated', (event) => {
   // console.log('Name updated to: ' + event.detail.view);
   // Block boat check-box on then hide block boats else show block boat form
    if($('#showBlockedBoats').length){
        if($('#showBlockedBoats:checked').val()){
            if($('#liveWireBlockBoats').length){
                $('#liveWireBlockBoats').addClass('d-none');
                if (!$('#liveWireBlockBoats').hasClass("d-none")) {
                    $('#liveWireBlockBoats').addClass("d-none");
                }
            }
            if($('.livewire-unblock-boats').length){
                $('.livewire-unblock-boats').removeClass('d-none');
                if ($('.livewire-unblock-boats').hasClass("d-none")) {
                    $('.livewire-unblock-boats').removeClass("d-none");
                }
            }
        }else{
            if($('#liveWireBlockBoats').length){
                if ($('#liveWireBlockBoats').hasClass("disabled")) {
                    $('#liveWireBlockBoats').removeClass("disabled");
                }
            }
            if($('.livewire-unblock-boats').length){
                if (!$('.livewire-unblock-boats').hasClass("disabled")) {
                    $('.livewire-unblock-boats').addClass("disabled");
                }
            }
        }
    }
    // forEach function
    var forEach = function forEach(array, callback, scope) {
        for (var i = 0; i < array.length; i++) {
            callback.call(scope, i, array[i]); // passes back stuff we need
        }
    }; // Carousel initialisation

    var carousels = document.querySelectorAll('.tns-carousel-wrapper .tns-carousel-inner');
    forEach(carousels, function (index, value) {
        var controlsText;

        if (value.dataset.carouselOptions != undefined && JSON.parse(value.dataset.carouselOptions).axis === 'vertical') {
            controlsText = ['<i class="fi-chevron-up"></i>', '<i class="fi-chevron-down"></i>'];
        } else {
            controlsText = ['<i class="fi-chevron-left"></i>', '<i class="fi-chevron-right"></i>'];
        }

        var defaults = {
            container: value,
            controlsText: controlsText,
            navPosition: 'bottom',
            mouseDrag: true,
            speed: 500,
            autoplayHoverPause: true,
            autoplayButtonOutput: false
        };
        var userOptions;
        if (value.dataset.carouselOptions != undefined) userOptions = JSON.parse(value.dataset.carouselOptions);
        var options = Object.assign({}, defaults, userOptions);
        var carousel = tns(options);
        var carouselWrapper = value.closest('.tns-carousel-wrapper'),
            carouselItems = carouselWrapper.querySelectorAll('.tns-item'),
            carouselInfo = carousel.getInfo(),
            carouselCurrentSlide = carouselWrapper.querySelector('.tns-current-slide'),
            carouselTotalSlides = carouselWrapper.querySelector('.tns-total-slides'); // Center slide

        if (carouselWrapper.classList.contains('tns-center')) {
            var indexCurrentInitial = carouselInfo.index;
            carouselInfo.slideItems[indexCurrentInitial].classList.add('active');
            carousel.events.on('indexChanged', function () {
                var info = carousel.getInfo(),
                    indexPrev = info.indexCached,
                    indexCurrent = info.index;
                info.slideItems[indexPrev].classList.remove('active');
                info.slideItems[indexCurrent].classList.add('active');
            });
        } // Slides count

        if (carouselWrapper.querySelector('.tns-slides-count') === null) return;
        carouselCurrentSlide.innerHTML = carouselInfo.displayIndex;
        carouselTotalSlides.innerHTML = carouselInfo.slideCount;
        carousel.events.on('indexChanged', function () {
            var info = carousel.getInfo();
            carouselCurrentSlide.innerHTML = info.displayIndex;
        });
    });

});

$(document).on('click', '.set-country', function(event) {
    var name = $(this).data('name');
    var code = $(this).data('code');
    var url = base_url + '/switch-currency/'+ code+'/'+ name;
    $.ajax({
        url: url,
        type: "GET",
        complete: function (response) {
            location.reload();
        }
    });
});

$(document).ready(function(){

	//clear fields

	/*My Orders Datatable listing*/
    if($('#myOrdersDatatable').length) {
	    var url = $('#myOrdersDatatable').data('ajax-url');
	    $('#myOrdersDatatable').DataTable({
	        responsive: true,
	        serverSide: true,
	        ajax: {
                url: url,
                data: function (d) {
                    d.search = $('input[type="search"]').val();
                }
            },
	        columns: [
	            {data: 'invoice_id', name: 'invoice_id'},
	            {data: 'order_date', name: 'order_date'},
	            {data: 'status', name: 'status'},
	            {data: 'action', name: 'action', bSortable: false}
	        ]
	    });
    }

    if($('#clientStateId').length){
        // alert($(this).attr('data-state'));
        var state = $('#clientStateId').data('state');
        var exists = false;
        $('#userProfileStateSelect  option').each(function(){
            if (this.value == state) {
                exists = true;
            }
        });
        if(!exists){
            var newOption = new Option(state, state, true, true);
            $('#userProfileStateSelect').append(newOption).trigger('change');
        }
    }
    if($('#viewType').length){
        setView($(this).val());
    }

    frontCommon();

    let tostrMessage = (type, message) => {
		toastr.options = {
			closeButton: true,
			progressBar: true,
			showMethod: 'slideDown',
			// timeOut: 4000
		};
		if (type != '' && message != '') {
			if (type == 'success') {
				toastr.success(message);
			} else {
				toastr.error(message);
			}
		}
	}
    /*Step one form*/
    $("form[id='stepOneForm']").validate({
        rules: {
            category: "required",
            boat_condition: {
                required: true,
            },
            year: "required",
            brand: "required",
            brand_model: "required",
            length: {
                required: true,
                min: 10
            },
            beam: {
                min: 10
            },
            draft: {
                required: true,
                min: 2
            },
            bridge_clearance: {
                min: 2
            },
            price: "required",
            price_currency: "required",
        },
        errorElement: "span",
        errorPlacement: function(error, element) {
		  if(element.attr("name") == "brand_model") {
		    error.appendTo('.brand_model-error');
		  } else {
		    error.insertAfter(element);
		  }
		},
        messages: {
            category: "Category is required",
            boat_condition: {
                required: "Boat condition is required",
            },
            year: "Year is required",
            brand: "Make is required",
            brand_model: "Model is required",
            length: {
                required: "Length field is required",
            },
            draft: {
                required: "Draft field is required",
            },
            price: "Asking Price field is required",
            price_currency: "Currency is required",
        },
        submitHandler: function(form) {
            form.submit();
        }
    });

    /*Step Three form*/
    $("form[id='stepThreeForm']").validate({
    	errorElement: "span",
        rules: {
            general_description: {
            	required: true
            }
        },
        ignore: "hidden:not(.summernote),.note-editable.card-block",
        errorPlacement: function(error, element) {
		  	if(element.attr("name") == "general_description") {
		    	error.appendTo('.general_description-error');
		  	} else {
		    	error.insertAfter(element);
		  	}
		},
        messages: {
            general_description: {
                required: "General Description is required",
            }
        },
        submitHandler: function(form) {
            form.submit();
        }
    });

    $('form[id="stepThreeForm"]').submit(function(e) {
		e.preventDefault();
        $('form[id="stepThreeForm"]').valid();
	});

    /*Step Four form*/
    $("form[id='stepFourForm']").validate({
    	errorElement: "span",
        rules: {
            image: {
                required: true,
            },
            country: {
                required: true,
            },
            state:  {
                required: true,
            },
            zip_code:  {
                required: true,
            },
        },
        errorPlacement: function(error, element) {
		  	if(element.attr("name") == "image") {
		    	setTimeout(function(){
		    		error.appendTo('.image-error');
		    	}, 1);
		  	} else {
		    	error.insertBefore('.videos-warning');
		  	}
		  	console.log('element');
		  	console.log(element);
		  	if(element.attr("name") == "state") {
		    	error.appendTo('.state-error');
		  	} else {
		    	error.insertAfter(element);
		  	}
            if(element.attr("name") == "zip_code") {
                var country = $('#Country').val();
                if(country == 'United States'){
                    if(element.length == 5){
                        return true
                    }
                }else{
                    if((element.length <= 8) && (element.length > 0) ){
                        return true
                    }else{
                        return false;
                    }
                }
            }
		},
        messages: {
            image: {
                required: "Atleast 1 image is required",
            },
            country: {
                required: "Country is required",
            },
            state: {
                required: "State is required",
            },
            zip_code: {
                required: "Zip Code is required",
            },
        },
        submitHandler: function(form) {
            form.submit();
        }
    });

    /*Login form*/
    $("form[id='loginForm']").validate({
        rules: {
            email: "required",
            password: "required",
            is_sell_boat: "nullable"
        },
        errorElement: "span",
        messages: {
            email: {
                required: "Email is required",
            },
            password: {
                required: "Password is required",
            }
        },
        submitHandler: function(form) {
            $.ajax({
                type: 'POST',
                url: base_url+'/login',
                data: {
                    email : form.email.value,
                    password : form.password.value,
                    is_sell_boat: form.is_sell_boat.value
                },
                beforeSend: function() {
                    if ($('#loader').hasClass("d-none")) {
                        $('#loader').removeClass("d-none");
                    }
                    //$('.loginSubmit').prop('disabled', true);
                    if (!$('#loginSubmit').hasClass("disabled")) {
                        $('#loginSubmit').addClass("disabled");
                    }
                },
                success: function(response) {
                	if(response.success == true){
                		window.location.href = response.redirect_url;
                	}else if(response.success == false){
                        tostrMessage('error', response.message);
                	}
                    $('#signInModal').modal('hide');
                    // location.reload();
                },
                error: function (reject) {
                    if (reject.status === 422) {
                        var errors = $.parseJSON(reject.responseText);

                        $.each(errors.errors, function (key, val) {
                            if(key){
                                var capitalKey = key.toLowerCase().replace(/\b[a-z]/g, function(letter) {
                                    return letter.toUpperCase();
                                });
                                var id = '#signin' + capitalKey;
                                if (!$(id).hasClass("is-invalid")) {
                                    $(id).addClass("is-invalid");
                                }
                                $("." + key + "_error").text(val);
                            }
                        });
                    }
                },
                complete:function () {
                    if ($('#loginSubmit').hasClass("disabled")) {
                        $('#loginSubmit').removeClass("disabled");
                    }
                    if (!$('#loader').hasClass("d-none")) {
                        $('#loader').addClass("d-none");
                    }
                }
            });
        }
    });

    /*Login form*/
    $("form[id='signupForm']").validate({
        rules: {
            first_name: "required",
            last_name: "required",
            contact_number : {
                required: false,
                minlength : 6
            },
            email: "required",
            password : {
                required: true,
                minlength : 8
            },
            password_confirmation : {
                required: true,
                equalTo : "#signupPassword"
            }
        },
        errorElement: "span",
        messages: {
            first_name: {
                required: "First name is required",
            },
            last_name: {
                required: "Last name is required",
            },
            email: {
                required: "Email is required",
            },
            password: {
                required: "Password is required",
            },
            password_confirmation : {
                required: "Password confirmation is required",
                equalTo : "Password confirm must be equal to password"
            }
        },
        submitHandler: function(form) {
            $.ajax({
                type: 'POST',
                url: base_url+'/register',
                data: {
                    first_name : form.first_name.value,
                    last_name : form.last_name.value,
                    contact_number : form.contact_number.value,
                    email : form.email.value,
                    password : form.password.value,
                    password_confirmation: form.password_confirmation.value,
                },
                beforeSend: function() {
                    if ($('#loader').hasClass("d-none")) {
                        $('#loader').removeClass("d-none");
                    }
                    //$('#signupSubmit').prop('disabled', true);
                    if (!$('#signupSubmit').hasClass("disabled")) {
                        $('#signupSubmit').addClass("disabled");
                    }
                },
                success: function(response) {
                    if (!$('#loader').hasClass("d-none")) {
                        $('#loader').addClass("d-none");
                    }
                    window.location.href = base_url;
                },
                error: function (reject) {
                    if (reject.status === 422) {
                        var errors = $.parseJSON(reject.responseText);
                        $.each(errors.errors, function (key, val) {
                            if(key){
                                var classString = key.replace('_', '-');
                                var className = '.signup-' + classString;
                                if (!$(className).hasClass("is-invalid")) {
                                    $(className).addClass("is-invalid");
                                }
                                $("." + key + "_error").text(val);
                            }
                        });
                    }
                },
                complete:function () {
                    if ($('#signupSubmit').hasClass("disabled")) {
                        $('#signupSubmit').removeClass("disabled");
                    }
                    if (!$('#loader').hasClass("d-none")) {
                        $('#loader').addClass("d-none");
                    }
                }
            });
        }
    });


     /*Login form*/
     $("form[id='resetForm']").validate({
        rules: {
            email: "required"
        },
        errorElement: "span",
        messages: {
            email: {
                required: "Email is required",
            }
        },
        submitHandler: function(form) {
            $.ajax({
                type: 'POST',
                url: base_url+'/password/email',
                data: {
                    email : form.email.value
                },
                beforeSend: function() {
                    if ($('#loader').hasClass("d-none")) {
                        $('#loader').removeClass("d-none");
                    }
                    //$('#resetSubmit').prop('disabled', true);
                    if (!$('#resetSubmit').hasClass("disabled")) {
                        $('#resetSubmit').addClass("disabled");
                    }
                },
                success: function(response) {
                	if(response.success == true){
                        tostrMessage('success', response.message);
                	}
                    $('#resetModal').modal('hide');
                },
                error: function (reject) {
                    if (reject.status === 422) {
                        var errors = $.parseJSON(reject.responseText);
                        if(!errors.message){
                            $.each(errors.errors, function (key, val) {
                                if(key){
                                    var capitalKey = key.toLowerCase().replace(/\b[a-z]/g, function(letter) {
                                        return letter.toUpperCase();
                                    });
                                    var id = '#resetEmail' + capitalKey;
                                    if (!$(id).hasClass("is-invalid")) {
                                        $(id).addClass("is-invalid");
                                    }
                                    $("." + key + "_error").text(val);
                                }
                            });
                        } else{
                            tostrMessage('error', errors.message);
                            $('#resetModal').modal('hide');
                        }
                    }
                },
                complete:function () {
                    if ($('#resetSubmit').hasClass("disabled")) {
                        $('#resetSubmit').removeClass("disabled");
                    }
                    if (!$('#loader').hasClass("d-none")) {
                        $('#loader').addClass("d-none");
                    }
                }
            });
        }
    });

    $(document).on('click','#showBlockedBoats',function(e){
        if($('#showBlockedBoats:checked').val()){
            if($('#liveWireBlockBoats').length){
                $('#liveWireBlockBoats').addClass('d-none');
                if (!$('#liveWireBlockBoats').hasClass("d-none")) {
                    $('#liveWireBlockBoats').addClass("d-none");
                }
            }
            if($('.livewire-unblock-boats').length){
                $('.livewire-unblock-boats').removeClass('d-none');
                if ($('.livewire-unblock-boats').hasClass("d-none")) {
                    $('.livewire-unblock-boats').removeClass("d-none");
                }
            }
        }else{
            if($('#liveWireBlockBoats').length){
                if ($('#liveWireBlockBoats').hasClass("disabled")) {
                    $('#liveWireBlockBoats').removeClass("disabled");
                }
            }
            if($('.livewire-unblock-boats').length){
                if (!$('.livewire-unblock-boats').hasClass("disabled")) {
                    $('.livewire-unblock-boats').addClass("disabled");
                }
            }
        }
    });
    // Once uncheck generator radio it erase all the data
    $('.generator-check').change(function() {
        if(!this.checked) {
            $('#generator_fuel_type').val('');
            if ($('#generator_fuel_type').hasClass("error")) {
                $('#generator_fuel_type').removeClass("error");
            }
            $('#generator_fuel_type-error').html('');
            $('#generator_size').val('');
            $('#generator_size-error').html('');
            $('#generator_hours').val('');
            $('#generator_hours-error').html('');
        }
    });

    // Once uncheck cabin radio it erase all the data
    $('.cabin-check').change(function() {
        if(!this.checked) {
            $('#berths').val('');
            $('#berths-error').html('');
            $('.cabin_description-error').html('');
            $('#cabinDescription').summernote('reset');
        }
    });

    // Once uncheck galary radio it erase all the data
    $('.galley-check').change(function() {
        if(!this.checked) {
            $('#galleyDescription').summernote('reset');
            $('.galley_description-error').html('');
        }
    });

    $(".character-link").on('click',function() {
        var id = $(this).data('character');
        if(id){
            $('html, body').animate({
                'scrollTop' : $("#"+id+"").position().top
            }, 1000);
        }
    });

    if($('#stepFourForm').length) { //Form is present
        var min = 0;
        var max = 8;
        if($('#Country').val() == 'United States') { //if united states selected
            var min = 5;
            var max = 5;
        }
        $("input[name*=zip_code]").rules('add', {
            minlength:min,
            maxlength:max,
            messages: {
                required: "Zip Code is required "
            }
        });
    }

    //Below functionality to hide filter
    if(!$('#filterForm').length) {
        $('#filterButton').addClass("d-none");
    }

    /*Multiple Select checkbox dropdown*/

    var select = $('.boat-type-multiple');

function formatSelection(state) {
    return state.text;   
}

function formatResult(state) {
    console.log(state)
    if (!state.id) return state.text; // optgroup
    var id = 'state' + state.id.toLowerCase();
    var label = $('<label></label>', { for: id })
            .text(state.text);
    var checkbox = $('<input type="checkbox">', { id: id });
    
    return checkbox.add(label);   
}

select.select2({
    closeOnSelect: false,
    formatResult: formatResult,
    formatSelection: formatSelection,
    escapeMarkup: function (m) {
        return m;
    },
});

$('.make-multiple').select2({
    closeOnSelect: false
});

$('.model-multiple').select2({
    closeOnSelect: false
});

if($('.catalog-livewires-card').length) {

	// const nativeFetch = window.fetch;
	// window.fetch = function(...args) {
	//   	if($('.livewire-loading').hasClass('d-none')) {
	// 		$('.livewire-loading').removeClass('d-none')
	// 	}
	// 	return nativeFetch.apply(window, args);
	// }

	// function hideLoader() {
	// 	if(!$('.livewire-loading').hasClass('d-none')) {
	// 		$('.livewire-loading').addClass('d-none')
	// 	}
	// }

	// window.addEventListener('livewire-list-updated', event => {
	// 	return hideLoader();
	// })


	

	// jQuery(function($) {
	// 	$.fn.select2.amd.require([
	//     	'select2/selection/single',
	//     	'select2/selection/placeholder',
	//     	'select2/selection/allowClear',
	//     	'select2/dropdown',
	//     	'select2/dropdown/search',
	//     	'select2/dropdown/attachBody',
	//     	'select2/utils'
	//   	], function (SingleSelection, Placeholder, AllowClear, Dropdown, DropdownSearch, AttachBody, Utils) {

	// 	var SelectionAdapter = Utils.Decorate(
	//     SingleSelection,
	//     Placeholder
	//     );
	    
	//     SelectionAdapter = Utils.Decorate(
	//       	SelectionAdapter,
	//       	AllowClear
	//     );
	          
	//     var DropdownAdapter = Utils.Decorate(
	//       	Utils.Decorate(
	//       	  	Dropdown,
	//         	DropdownSearch
	//       	),
	//       	AttachBody
	//     );
	    
	// 	var base_element = $('.make-multiple');
	//     $(base_element).select2({
	//     	placeholder: 'Select Make',
	// 	    selectionAdapter: SelectionAdapter,
	// 	    dropdownAdapter: DropdownAdapter,
	// 	    allowClear: true,
	// 	    templateResult: function (data) {

	// 	        if (!data.id) { return data.text; }

	// 	        var $res = $('<div></div>');

	// 	        $res.text(data.text);
	// 	        $res.addClass('wrap');

	// 	        return $res;
	// 	    },
	// 	    templateSelection: function (data) {
	// 	      		if (!data.id) { return data.text; }
	// 	        	var selected = ($(base_element).val() || []).length;
	// 	        	var total = $('option', $(base_element)).length;
	// 	        	return "Selected " + selected + " of " + total;
	// 	      	}	
	// 	    });

	//     $.fn.select2.amd.require([
	//     	'select2/selection/single',
	//     	'select2/selection/placeholder',
	//     	'select2/selection/allowClear',
	//     	'select2/dropdown',
	//     	'select2/dropdown/search',
	//     	'select2/dropdown/attachBody',
	//     	'select2/utils'
	//   	], function (SingleSelection, Placeholder, AllowClear, Dropdown, DropdownSearch, AttachBody, Utils) {

	// 	var SelectionAdapter2 = Utils.Decorate(
	//     SingleSelection,
	//     Placeholder
	//     );
	    
	//     SelectionAdapter = Utils.Decorate(
	//       	SelectionAdapter,
	//       	AllowClear
	//     );
	          
	//     var DropdownAdapter = Utils.Decorate(
	//       	Utils.Decorate(
	//       	  	Dropdown,
	//         	DropdownSearch
	//       	),
	//       	AttachBody
	//     );

	//     var base_element = $('.model-multiple');
	//     $(base_element).select2({
	//     	placeholder: 'Select Model',
	// 	    selectionAdapter: SelectionAdapter2,
	// 	    dropdownAdapter: DropdownAdapter2,
	// 	    allowClear: true,
	// 	    templateResult: function (data) {

	// 	        if (!data.id) { return data.text; }

	// 	        var $res = $('<div></div>');

	// 	        $res.text(data.text);
	// 	        $res.addClass('wrap');

	// 	        return $res;
	// 	    },
	// 	    templateSelection: function (data) {
	// 	      		if (!data.id) { return data.text; }
	// 	        	var selected = ($(base_element).val() || []).length;
	// 	        	var total = $('option', $(base_element)).length;
	// 	        	return "Selected " + selected + " of " + total;
	// 	      	}	
	// 	    });
		  
	// 	});
	  
	// });

}

});
