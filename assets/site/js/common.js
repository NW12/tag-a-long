$(document).ready(function () {


    $('#paypal_checkbox').click(function () {
        //alert("Checkbox state (method 1) = " + $('#paypal_checkbox').prop('checked'));
        //alert("Checkbox state (method 2) = " + $('#paypal_checkbox').is(':checked'));
        if ($('#paypal_checkbox').is(':checked')) {

        } else {
            var URL = BASEURL + 'bank/updateCredentials';
            $.ajax({
                type: "POST",
                url: URL,
                dataType: "text",
                data: {
                    'id': '1'
                },
                success: function (response) {

                }
            });
            $("#paypal_email").val("");
            $("#creditcard_type").val("");
            $("#card_number").val("");
            $("#paypal_temp_card_no").val("");
            $("#pp_card_number").val("");
            $("#expire_month").val("");
            $("#expire_year").val("");
            $("#paypal_temp_cvv").val("");
            $("#pp_cvv").val("");
            $("#cvv").val("");

        }
    });

    $('#stripe_card').click(function () {
        //alert("Checkbox state (method 1) = " + $('#paypal_checkbox').prop('checked'));
        //alert("Checkbox state (method 2) = " + $('#paypal_checkbox').is(':checked'));
        if ($('#stripe_card').is(':checked')) {

        } else {
            var URL = BASEURL + 'bank/updateCredentials';
            $.ajax({
                type: "POST",
                url: URL,
                dataType: "text",
                data: {
                    'id': '2'
                },
                success: function (response) {

                }
            });
            $("#name_on_ccard").val("");
            $("#temp_stripe_cno").val("");
            $("#ccard_number").val("");
            $("#stripe_expire_month").val("");
            $("#stripe_expire_year").val("");
            $("#temp_stripe_cvv").val("");
            $("#cc_cvv").val("");
            $("#stripe_cvv").val("");

        }
    });

    $('#plateformForm').validate({
        ignore: [],
        rules: {
            issuer_id: {required: true},
            key_id: {required: true},
            certificate_password: {required: true},
            service_email_address: {required: true, email: true},
            validate_file: {required: true},

        },
        messages: {
            issuer_id: {required: "Issuer Id is required"},
            key_id: {required: "Key Id is required"},
            certificate_password: {required: "Certificate Password is required"},
            service_email_address: {required: "Service Account Email Address is required", email: "Email is not valid"},
            validate_file: {required: ".p12 file is required"},
        },
        highlight: function (element) {
            $(element).parent().css("color", "red");
        }

    });


    $('#invite-form').validate({

        rules: {
            associate_name: {required: true},
            associate_email_address: {required: true, email: true},
            account_name: {required: true},
            account_email_address: {required: true, email: true},

        },
        messages: {
            associate_name: {required: "Associate Name is required"},
            associate_email_address: {required: "Associate Email is required", email: "Email is not valid"},
            account_name: {required: "Account Name is required"},
            account_email_address: {required: "Account Email is required", email: "Email is not valid"},

        },
        highlight: function (element) {
            $(element).parent().css("color", "red");
        }

    });


    $("#deleteBtn").on('click', function () {

        var value = $('#old_file').text();
        var id = $("#plateform_id").val();
        var URL = BASEURL + 'certificates/deleteFile';

        $.ajax({
            type: "POST",
            url: URL,
            dataType: "text",
            data: {
                'imageName': value,
                'id': id
            },
            success: function (response) {
                console.log(response);
                $("#filename").val("");
                $('#oldfileDiv').empty();


            }
        });
    });


    $("#profileImageDeleteBtn").on('click', function () {


        var URL = BASEURL + 'profile/deleteProfileImage';

        $.ajax({
            type: "POST",
            url: URL,
            dataType: "text",
            data: {},
            success: function (response) {
                console.log(response);
                $("#profileContainer").remove();
                $("#profile-img").attr("src", BASEURL + "uploads/users/noImage.jpg");

            }
        });
    });

    $("#file_upload").on('change', function () {

        var old = $('#old_file').text();
        if ($.trim(old))
        {
            bootbox.alert('Please delete first uploaded File.');
            $("#file_upload").val('');
            return false;
        }
        var fileExtension = ['p12'];
        var value = $("#file_upload").val();
        if ($.inArray(value.split('.').pop().toLowerCase(), fileExtension) == -1) {
            bootbox.alert("Only formats are allowed : " + fileExtension.join(', '));
            $("#file_upload").val('');
        } else {
            $("#filename").val(value);

        }
    });


    //------------------ Balance Page Functions -------------------------//

   

    $("input[name='payment_type']").click(function () {

        var type = $(this).val();
        var paymentplan = $('input[name=payment_plan]:checked').val();
        if (type == 'paypal') {
            $("#stripformerrorcontainer").hide();
            $('#paypal-div-container').show();
            $('#creditCardForm').hide();
            $("#paypal_payment_pakage_plan").val(paymentplan);

        }
        if (type == 'credit_card') {
            $("#paypalformerrorcontainer").hide();
            $('#paypal-div-container').hide();
            $('#creditCardForm').show();
            $("#credit_card_payment_pakage_plan").val(paymentplan);
        }


    });
    $("input[name='payment_plan']").click(function () {
        var payment_plan = $(this).val();

        if (payment_plan == 'yearly') {
            $(".amount_btn_bal").text($("#discount_price").text());

        } else {
            $(".amount_btn_bal").text($(".amount").val());
        }
        var type = $('input[name=payment_type]:checked').val();


        if (type == 'paypal') {

            $("#paypal_payment_pakage_plan").val(payment_plan);

        } else if (type == 'credit_card') {
            $("#credit_card_payment_pakage_plan").val(payment_plan);

        }
    });






    //------------------ Balance Page Functions -------------------------// 

    $('#dashboard_history_days').change(function () {
        var value = $('#dashboard_history_days option:selected').val();
        $('#dashboard_title').html(value);

    });
});

 function showMessage(cls, divId, message) {
      $("#" + divId).show();
    $("#" + divId).html('');
    var html = '' + message + '';
    $("#" + divId).html(html);
    $("#" + divId).removeClass('alert-info').removeClass('alert-success').removeClass('alert-danger').addClass(cls).show('slow');
    $('html,body').animate({
        scrollTop: $("#" + divId).offset().top - 100
    }, 'slow');
    $('#contentContainer').animate({
        scrollTop: $("#" + divId).offset().top - 100
    }, 'slow');
    setTimeout(function(){  $("#" + divId).hide(); }, 3000);

}

//------------------ Balance Page Functions -------------------------//
function validatePaybyCredit(creditCardForm)
{
    creditCardForm.validate({
        ignore: "input[type='text']:hidden",
        onfocusout: false,
        rules: {
            name_on_ccard: {required: true},
            ccard_number: {required: true, number: true, maxlength: 16, minlength: 16},
            expire_month: {required: true},
            expire_year: {required: true},
            cvv: {required: true, maxlength: 4},
        },
        messages: {
            name_on_ccard: {required: "Name is required"},
            ccard_number: {required: "Valid Card Number is required", number: "Provide a valid card Number",
                maxlength: "Length should be 16 characters", minlength: "Length should be 16 characters"},
            expire_month: {required: "Expire Month is required"},
            expire_year: {required: "Expire Year is required"},
            cvv: {required: "CVV code is required", maxlength: "CVV code should be 4 characters"},
        },

        highlight: function (element) {
            $(element).parent().css("color", "red");
        },
        errorPlacement: function (error, element) {},
        invalidHandler: function (form, validator) {
            var errors = validator.numberOfInvalids();
            if (errors) {
                $('#stripformerrorcontainer').fadeIn('slow');
                $('#stripformerrors').html("<li class='alert-box-li'>" + validator.errorList[0].message + "</li>");
                validator.errorList[0].element.focus(); //Set Focus
            }
        }

    });
}


function stripeResponseHandler(status, response) {
    $('#successContainer').hide();
    $('#stripformerrorcontainer').hide();
    if (response.error) {
        $("#ccard_number").val('');
        $("#cc_cvv").val('');
        $('#stripformerrorcontainer').css('display', 'block');
        $('#stripformerrors').html("<li class='alert-box-li'>" + response.error.message + "</li>");
        $('#loading_img_credit').html('');
        $('.submit').prop('disabled', false); // Re-enable submission
        $('#ccModal').modal('hide');
        $(".modal-backdrop").remove();
        $("body").removeClass("modal-open");
    } else {
        console.log(response);
        var token = response.id;
        console.log("token is: " + token);
        $('#payment-form').append("<input type='hidden' name='token' value='" + token + "' >");
        var paymentForm = document.getElementById('payment-form');
        var form_data = new FormData(paymentForm);
        $("#ccard_number").val('');
        $("#cc_cvv").val('');
        var URL = BASEURL + 'bank/stripe_charge';
        $.ajax({
            url: URL,
            data: form_data,
            dataType: 'json',
            cache: false,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function (res){
            window.location.href = BASEURL + 'cart/success';
				}
        });
    }
}


function ccardNumber(value) {
    var string1 = "XXXX-XXXX-XXXX";
    if (value.indexOf(string1) === -1)
        $("#ccard_number").val(value);
}
function ppcardNumber(value) {
    var string1 = "XXXX-XXXX-XXXX";
    if (value.indexOf(string1) === -1)
        $("#pp_card_number").val(value);
}

function paypalCVV(value) {
    var string1 = "XXX";
    if (value.indexOf(string1) === -1)
        $("#pp_cvv").val(value);
}
function creditcardCVV(value) {
    var string1 = "XXX";
    if (value.indexOf(string1) === -1)
        $("#cc_cvv").val(value);
}

function payByCredit()
{ 

    var imgUrl = BASEURL + 'assets/site/img/ajax-loader.gif';
    $('#loading_img_credit').html("<img src='" + imgUrl + "' />");

    var URL = BASEURL + 'bank/payByCredit';
    var paymentForm = document.getElementById('payment-form');
    var value = $.trim($("#temp_stripe_cno").val());

    var string1 = "X";
    if (value.includes(string1)) {

        $.ajax({
            url: BASEURL + "bank/getCreditCardCreditendials",
            data: form_data,
            dataType: 'json',
            async: false,
            type: 'POST',
            success: function (res) {
                if (res.success) {

                    $("#ccard_number").val(res.cc_no);
                    $("#cc_cvv").val(res.cvv);
                }

            }
        });
    }
    console.log(paymentForm);
    var form_data = new FormData(paymentForm);
    var creditForm = $("#payment-form");
    validatePaybyCredit(creditForm);
    if (creditForm.valid()) {

        creditForm.find('.submit').prop('disabled', true);
        Stripe.card.createToken(creditForm, stripeResponseHandler);
       
        return false;
    } else {
        $('.submit').prop('disabled', false);
        $('#ccModal').modal('hide');
        $(".modal-backdrop").remove();
        $("body").removeClass("modal-open");
        $('#loading_img_credit').html('');
        $('#errorContainer').show();
    }
}

//------------------ Balance Page Functions -------------------------//

function validateReasonForm(supportForm)
{
    supportForm.validate({
        rules: {
            user_name: {required: true},
            reason: {required: true},
            comment: {required: true},
        },
        messages: {
            user_name: {required: "Name is required"},
            reason: {required: "Subject is required"},
            comment: {required: "Comments required"},
        },
        highlight: function (element) {
            $(element).parent().css("color", "red");
        },
    });

}
function submitReason()
{
    var imgUrl = BASEURL + 'assets/site/images/loading.gif';
    $('#supportLoaderImg').html("<img src='" + imgUrl + "' />");

    var URL = BASEURL + 'support/submitReason';
    var supportForm = document.getElementById('supportForm');
    var form_data = new FormData(supportForm);
    var supportForm = $("#supportForm");
    validateReasonForm(supportForm);
    if (supportForm.valid()) {
        $.ajax({
            url: URL,
            data: form_data,
            dataType: 'json',
            cache: false,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function (res) {
                $('#supportLoaderImg').html('');
                if (res.status == 0)
                {
                    bootbox.alert(res.msg);

                }
                if (res.status == 1)
                {
                    $("#supportForm input").val('');
                    $("#supportForm textarea").val('');
                    $('#supportFormContainer').hide();
                    $('#supportSuccessContainer').show();
                }
            }
        });

    } else {
        $('#supportLoaderImg').html('');
    }
}

function showLoader() {
    $('#loaderDiv').css("display", "block");
}

function hideLoader() {
    $('#loaderDiv').css("display", "none").delay(800);
}


function payPalByCredit()
{
    $('#successContainer').hide();
    $("#paypalformerrorcontainer").hide();
    var imgUrl = BASEURL + 'assets/site/images/loading.gif';
    $('#loading_img_credit2').html("<img src='" + imgUrl + "' />");
    var card_number = $("#pp_card_number").val();
    if (card_number) {
        var newcardnum = card_number.replace(/\-/g, '');
        $("#pp_card_number").val(newcardnum);
    }

    var URL = BASEURL + 'bank/payPalByCredit';
    var paymentForm = document.getElementById('paypalForm');
    var form_data = new FormData(paymentForm);
    var paymentFormInfo = $('#paypalForm');
    validatePayPalbyCredit(paymentFormInfo);
    if (paymentFormInfo.valid()) {
        $("#pp_card_number").val(card_number);
        paymentFormInfo.find('.submit').prop('disabled', true);

        $.ajax({
            url: URL,
            data: form_data,
            dataType: 'json',
            cache: false,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function (res) {
                $('.submit').prop('disabled', false);
                $('#ppModal').modal('hide');
                $(".modal-backdrop").remove();
                $("body").removeClass("modal-open");
                $("body").css("padding-right", "0");
                console.log(res.status);
                $('#loading_img_credit2').html('');
                if (res.status == 0)
                {
                    $("#paypalformerrorcontainer").show();
                    $("#paypalformerrors").show();
                    $("#paypalformerrors").empty();
                    $("#paypalformerrors").html("<li  class='alert-box-li'>" + res.msg + "</li>");

                }
                if (res.status == 1)
                {

                    $('#successContainer').html(res.msg);
                    $('#successContainer').show();

                    $("#historyContainer").fadeOut(500, function () {
                        $(this).hide();
                        $(this).fadeIn(500, function () {
                            $("#msg_line").text(res.msg_line);
                            $("#payment_plan").text(res.payment_plan);
                            $("#installs_purchased").text(res.installs_purchased);
                            $("#expire_date").text(res.expire_date);
                            $("#balance").text('$' + res.amount);
                            $("#last_purchase").text(res.created_at);
                            $("#total_spent").text('$' + res.total_spent);
                            $("#user_total_installs").text(res.new_user_installs);
                            $("#user-installs").text(res.new_user_installs);
                            console.log(res.created_at);
                            $(this).show();

                        });
                        $('#pageformsection').fadeOut(500, function () {
                            $('#payment-form input').val('');
                            $(this).remove();
                        });
                    });
                }


            }
        });
    } else {
        $('.submit').prop('disabled', false);
        $(".modal-backdrop").remove();
        $("body").removeClass("modal-open");
        $("body").css("padding-right", "0");
        $('#ppModal').modal('hide');
        $('#loading_img_credit2').html('');
        $('#errorContainer').show();
    }

    return false;

}

function validatePayPalbyCredit(creditCardForm)
{
    creditCardForm.validate({
        onfocusout: false,
        rules: {
            paypal_email: {required: true, email: true},
            paypal_creditcard_type: {required: true},
            paypal_card_number: {required: true, maxlength: 16, minlength: 16},
            paypal_expire_month: {required: true},
            paypal_expire_year: {required: true},
            paypal_cvv: {required: true, maxlength: 4},
        },
        messages: {
            paypal_email: {required: "Email is required", email: "Provide a valid Email Address"},
            paypal_creditcard_type: {required: "Credit Card Type is required"},
            paypal_card_number: {required: "Valid Card Number is required",
                maxlength: "Length should be 16 characters", minlength: "Length should be 16 characters"},
            paypal_expire_month: {required: "Expire Month is required"},
            paypal_expire_year: {required: "Expire Year is required"},
            paypal_cvv: {required: "CVV code is required", maxlength: "CVV code should be 4 characters"},
        },

        highlight: function (element) {
            $(element).parent().css("color", "red");
        },
        errorPlacement: function (error, element) {},
        invalidHandler: function (form, validator) {
            var errors = validator.numberOfInvalids();
            if (errors) {
                $('#paypalformerrorcontainer').fadeIn('slow');
                $('#paypalformerrors').html("<li class='alert-box-li'>" + validator.errorList[0].message + "</li>");
                validator.errorList[0].element.focus(); //Set Focus
            }
        }

    });
}