require("./bootstrap");

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";

window.show_toastr = function show_toastr(type, message) {
    var f = document.getElementById("liveToast");
    var a = new bootstrap.Toast(f).show();
    if (type == "success" || type == "Success") {
        $("#liveToast").removeClass("bg-danger");
        $("#liveToast").addClass("bg-success");
    } else {
        $("#liveToast").removeClass("bg-success");
        $("#liveToast").addClass("bg-danger");
    }
    $("#liveToast .toast-body").html(message);
};

$(function() {
    $(document).on("click", ".bs-pass-para", function() {
        // $('.bs-pass-para').click(function (event) {
        var form = $(this).closest("form");
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-success",
                cancelButton: "btn btn-danger",
            },
            buttonsStyling: true,
        });
        swalWithBootstrapButtons
            .fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
                reverseButtons: true,
            })
            .then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
    });
});


window.handleFormValidation = function handleFormValidation(data, prefix = "") {
    $('.is-invalid').removeClass('is-invalid');
    for (let error in data.responseJSON.errors) {   
        let error_element = error;
        if (prefix != "") {
            error_element += `_${prefix}`
        }
        console.log(error_element);
        $(`#${error_element}`).addClass('is-invalid');
        let messages = "";
        data.responseJSON.errors[error].forEach(message => {
            messages += `${message}`;
            // messages += `<p class="m-0 p-0">${message}</p>`;
        });
        $(`#${error_element}_invalid`).html(messages);
    }
}

window.modalHide = function modalHide(modal) {
    bootstrap.Modal.getInstance(document.querySelector(`#${modal}`)).hide();
}