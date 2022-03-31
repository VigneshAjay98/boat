let boatCommon = () => {

    // Ajax header declared
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Main Delete record function
    deleteConfirmation = (url, redirectUrl) => {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            showCancelButton: true,
            confirmButtonText: `Delete`,
            confirmButtonColor: "#dc3545",
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
             if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    type: "DELETE",
                    success: function (response) {
                        window.location = redirectUrl;
                    },
                    error: function (response) {
                        window.location = redirectUrl;
                    },
                });
            }
        });
    };
}


    // Modal View settings use to show form contents modal
    $(document).on('click', '.open-model-btn', function () {
        let url = $(this).attr("data-href");
        let title = $(this).attr("data-title");
        let size = $(this).attr("data-size");
        $("#boatModalBox .modal-body").load(url, function (result) {
          $("#boatModalBox .modal-title").html(title);
          if (size == 'lg') {
            $("#modalMainDiv").addClass('modal-lg');
          } else {
            if ($("#modalMainDiv").hasClass('modal-lg')) {
              $("#modalMainDiv").removeClass('modal-lg');
            }
          }
          $("#boatModalBox").modal({
            backdrop: "static",
            keyboard: false,
            show: true,
          });

        });
      });

      // Preview Profile Image
      $(document).on('change', '#getFile', function() {
        let reader = new FileReader();
        reader.onload = (e) => {
            $('#previewImage').attr('src', e.target.result);
        }
        reader.readAsDataURL(this.files[0]);
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

    // // Remove temporary image after reset
    // $(document).on("click", ".reset-user", function () {
    //     const defaultImagePath = $(this).attr('default-image');
    //     const uploadedImage = ((base_url == $(this).data('image')) || (base_url + '/' == $(this).data('image')) ) ? $(this).data('image') : '';
    //     console.log(base_url+'  '+$(this).data('image'));
    //     if(uploadedImage) {
    //         $('.avatar').attr('src', uploadedImage);
    //     }else {
    //         $('.avatar').attr('src', defaultImagePath);
    //     }
    // });


    // delete confirmation box for all modules
    $(document).on("click", ".delete-confirmation", function (event) {
        event.preventDefault();
        let url = $(this).attr("href");
        let redirectUrl = $(this).data("redirect-url");
        deleteConfirmation(url, redirectUrl);
    });

    let commonListing = () => {

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

        //on click change brand status
        $(document).on('click', '.brand-status', function () {
            var uuid = $(this).attr('data-uuid');
            var status = $(this).attr('data-status');
            var statusButton = $(this);
            if($('#brandsDatatable').length){
                Swal.fire({
                    title: "Are you sure, you want to change status?",
                    showCancelButton: true,
                    confirmButtonText: `Confirm`,
                    confirmButtonColor: "#dc3545",
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                     if (result.isConfirmed) {
                        $.ajaxSetup({
                            headers: {
                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                            },
                        });
                        $.ajax({
                            url: base_url + '/admin/brands-status/' + uuid + '/' + status,
                            type: 'GET',
                            beforeSend: function () {
                                $(".loading").show();
                            },
                            complete: function () {
                                $(".loading").hide();
                            },
                            success: function (response) {
                                if(response.brand.is_active == 'N'){
                                    statusButton.attr("checked", false);
                                }else{
                                    statusButton.attr("checked", true);
                                }

                                if(response.status == 'prohibited'){
                                    tostrMessage('error', response.message);
                                    $('#brandsDatatable').DataTable().ajax.reload();
                                }else{
                                    tostrMessage('success', 'Brand status updated successfully!');
                                    statusButton.attr("data-status", response.brand.is_active);
                                }
                            },
                            error: function (xhr, status, error) {
                                tostrMessage('error', 'Failed to update brand status!');
                            },
                        });
                    }else{
                        $('#brandsDatatable').DataTable().ajax.reload();
                    }
                });
            }
        });

        //on click change model status
        $(document).on('click', '.model-status', function () {
            var uuid = $(this).attr('data-uuid');
            var status = $(this).attr('data-status');
            var statusButton = $(this);
            if($('#modelsDatatable').length){
                Swal.fire({
                    title: "Are you sure, you want to change status?",
                    showCancelButton: true,
                    confirmButtonText: `Confirm`,
                    confirmButtonColor: "#dc3545",
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                     if (result.isConfirmed) {
                        $.ajaxSetup({
                            headers: {
                                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                            },
                        });
                        $.ajax({
                            url: base_url + '/admin/models-status/' + uuid + '/' + status,
                            type: 'GET',
                            beforeSend: function () {
                                $(".loading").show();
                            },
                            complete: function () {
                                $(".loading").hide();
                            },
                            success: function (response) {
                                tostrMessage('success', 'Model status updated successfully!');
                                if(response.model.is_active == 'N'){
                                    statusButton.attr("checked", false);
                                }else{
                                    statusButton.attr("checked", true);
                                }
                                statusButton.attr("data-status", response.model.is_active);
                            },
                            error: function (response) {
                                tostrMessage('error', 'Failed to update model status!');
                            },
                        });
                    }else{
                        $('#modelsDatatable').DataTable().ajax.reload();
                    }
                });
            }
        });


        var url = $('#usersDatatable').data('ajax-url');
        var userTable = $('#usersDatatable').DataTable({
            responsive: true,
            serverSide: true,
            ajax: {
                url: url,
                data: function (d) {
                    d.search = $('input[type="search"]').val();
                }
            },
            columns: [
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'contact_number', name: 'contact_number'},
                {data: 'action', name: 'action', bSortable: false}
            ]
        });

        userTable.draw();

        $(document).on('change', 'input[type="search"]', function(e) {
            userTable.draw();
        });

        if($('#brandsDatatable').length){
            var url = $('#brandsDatatable').data('ajax-url');
            $('#brandsDatatable').DataTable({
                // processing: true,
                responsive: true,
                serverSide: true,
                ajax: url,
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'status', name: 'status', bSortable: false},
                    {data: 'action', name: 'action', bSortable: false}
                ]
            });
        }

        if($('#modelsDatatable').length){
            var url = $('#modelsDatatable').attr('data-ajax-url');
            $('#modelsDatatable').DataTable({
                // processing: true,
                responsive: true,
                serverSide: true,
                ajax: url,
                columns: [
                    {data: 'model_name', name: 'model_name'},
                    {data: 'brand_name', name: 'brand_name'},
                    {data: 'status', name: 'status', bSortable: false},
                    {data: 'action', name: 'action', bSortable: false}
                ]
            });
        }

        if($('#plansDatatable').length){
            var url = $('#plansDatatable').data('ajax-url');
            $('#plansDatatable').DataTable({
                // processing: true,
                responsive: true,
                serverSide: true,
                ajax: url,
                columns: [
                    {data: 'name', name: 'name'},
                    {data: 'price', name: 'price',  bSortable: false},
                    {data: 'duration_weeks', name: 'duration_weeks',  bSortable: false},
                    {data: 'image_number', name: 'image_number',  bSortable: false},
                    {data: 'video_number', name: 'video_number' ,  bSortable: false},
                    {data: 'action', name: 'action', bSortable: false}
                ]
            });
        }

        if($('#couponsDatatable').length){
            var url = $('#couponsDatatable').data('ajax-url');
            $('#couponsDatatable').DataTable({
                // processing: true,
                responsive: true,
                serverSide: true,
                ajax: url,
                columns: [
                    {data: 'code', name: 'code'},
                    {data: 'type', name: 'type'},
                    {data: 'amount', name: 'amount',  bSortable: false},
                    {data: 'expiry_date', name: 'expiry_date',  bSortable: false},
                    {data: 'action', name: 'action', bSortable: false}
                ]
            });
        }

        if($('#planAddonsDatatable').length){
            var url = $('#planAddonsDatatable').data('ajax-url');
            $('#planAddonsDatatable').DataTable({
                // processing: true,
                responsive: true,
                serverSide: true,
                ajax: url,
                columns: [
                    {data: 'addon_name', name: 'addon_name'},
                    {data: 'plan_name', name: 'plan_name', bSortable: false},
                    {data: 'addon_cost', name: 'addon_cost', bSortable: false},
                    {data: 'action', name: 'action', bSortable: false}
                ]
            });
        }


        /*Options Listing*/
        url = $('#optionsDatatable').data('ajax-url');

        var optionsTable = $('#optionsDatatable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: url,
                data: function (d) {
                    d.option_type = $('#select_option_type').val();
                    d.search = $('input[type="search"]').val();
                }
            },
            columns: [
                {data: 'name', name: 'name'},
                {data: 'option_type', name: 'option_type'},
                {data: 'is_active', name: 'is_active', bSortable: false},
                {data: 'action', name: 'action', bSortable: false}
            ]
        });

        optionsTable.draw();

        $(document).on('change', '#select_option_type, input[type="search"]', function(e) {
            optionsTable.draw();
        });

        //Update options Status
        var updateStatus = (tableId, url) => {

            Swal.fire({
                title: "Are you sure, you want to change status?",
                showCancelButton: true,
                confirmButtonText: `Confirm`,
                confirmButtonColor: "#dc3545",
            }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    $.ajaxSetup({
                        headers: {
                          "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                        },
                    });
                  $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: url,
                    success: function (response) {
                        tostrMessage('success', response.message);
                    },
                    error: function (response) {
                        tostrMessage('error', response.responseJSON.message);
                        $('#' + tableId).DataTable().ajax.reload();
                    },
                  });
                }else{
                    $('#' + tableId).DataTable().ajax.reload();
                }
            });
        }

        //check Options status toggle change
        $(document).on('click', '.optionStatus', function () {
          var option_uuid = $(this).data("uuid");
          var base_url = $(this).data("url");
          var url = base_url + "/admin/option-status/" + option_uuid;
          var tableId = $(this).parents('table').attr('id');
          updateStatus(tableId, url);
        });

        /*Categories Datatable listing*/
        url = $('#categoriesDatatable').data('ajax-url');
        $('#categoriesDatatable').DataTable({
            responsive: true,
            serverSide: true,
            ajax: url,
            columns: [
                {data: 'name', name: 'name'},
                {data: 'type', name: 'type'},
                {data: 'is_active', name: 'is_active', bSortable: false},
                {data: 'action', name: 'action', bSortable: false}
            ]
        });

        //check Category status toggle change
        $(document).on('click', '.categoryStatus', function () {
            var category_uuid = $(this).data("uuid");
            var base_url = $(this).data("url");
            var url = base_url + "/admin/category-status/" + category_uuid;
            var tableId = $(this).parents('table').attr('id');
            updateStatus(tableId, url);
        });

    }

   InitSummernote = () =>{
       //Category Description Summernote
        $('.summernote').summernote({
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline']],
                ['para', ['ul', 'ol']],
            ],
            placeholder: 'Description',
            tabSize: 2,
            height: 80
        });
   }
$(document).ready(function () {
    InitSummernote();
    boatCommon();
    commonListing();
});
