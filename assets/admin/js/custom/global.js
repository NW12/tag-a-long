$(function () {

    /* modal */
    $('.modal').on('shown.bs.modal', function () {
        var curModal = this;
        $('.modal').each(function () {
            if (this != curModal) {
                $(this).modal('hide');
            }
        });
    });



    $(".datepicker").datepicker();

});
function checkEmailVAlid(value, id)
{
    var msg = '';
    if (!isValidEmailAddress(value)) {
        msg = 'The email address contains illegal characters. Please enter correct email.';
        alert(msg);
        $("#" + id).focus();
        $("#" + id).val('');
        return false;
    }
}


//email validation function
function isValidEmailAddress(emailAddress) {
    var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
    return pattern.test(emailAddress);
}
function isValidPassword(password) {
    var pattern = /^(?=.*[$@$!%*#?&])[A-Za-z\d$@$!%*#?&]{6,}$/;
    return pattern.test(password);
}

//url validation function
function is_valid_url(url) {
    return /^(http(s)?:\/\/)?(www\.)?[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}(:[0-9]{1,5})?(\/.*)?$/.test(url);
}

$(function () {


    $('#photo').change(function () {
        var ext = $('#photo').val().split('.').pop().toLowerCase();

        if ($.inArray(ext, ['jpg', 'jpeg', 'png', 'gif']) == -1) {
            alert(image_error_msg);
            $('#photo').val('');
            $('#testImg').attr('src', '');
            $('#testImg').hide();
            return false;
        }
        var isChrome = /Chrome/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor);
        var isSafari = /Safari/.test(navigator.userAgent) && /Apple Computer/.test(navigator.vendor);
        if (isSafari) {
            var nAgt = navigator.userAgent;
            var fullVersion = '' + parseFloat(navigator.appVersion);
            var verOffset;
            if ((verOffset = nAgt.indexOf("Safari")) != -1) {
                fullVersion = parseFloat(nAgt.substring(verOffset + 7));
                if ((verOffset = nAgt.indexOf("Version")) != -1)
                    fullVersion = parseFloat(nAgt.substring(verOffset + 8));
            }
            if (fullVersion >= 7)
            {
                readURL(this);
            } else {
                $('#imgShow').html($('#photo').val());
            }

        } else

        {
            readURL(this);
        }
    });
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            var file = input.files[0];
            var image = new Image();
            reader.readAsDataURL(file);
            reader.onload = function (_file) {
                image.src = _file.target.result;
                image.onload = function () {
                    $('#testImg').show();
                    $('#testImg').attr('src', image.src);
                };

            };

        }
    }

    $('#image').change(function () {
        var ext = $('#image').val().split('.').pop().toLowerCase();

        if ($.inArray(ext, ['jpg', 'jpeg', 'png', 'gif']) == -1) {
            alert(image_error_msg);
            $('#image').val('');
            $('#testImg').attr('src', '');
            $('#testImg').hide();
            return false;
        }
        var isChrome = /Chrome/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor);
        var isSafari = /Safari/.test(navigator.userAgent) && /Apple Computer/.test(navigator.vendor);
        if (isSafari) {
            var nAgt = navigator.userAgent;
            var fullVersion = '' + parseFloat(navigator.appVersion);
            var verOffset;
            if ((verOffset = nAgt.indexOf("Safari")) != -1) {
                fullVersion = parseFloat(nAgt.substring(verOffset + 7));
                if ((verOffset = nAgt.indexOf("Version")) != -1)
                    fullVersion = parseFloat(nAgt.substring(verOffset + 8));
            }
            if (fullVersion >= 7)
            {
                readURL_image(this);
            } else {
                $('#imgShow').html($('#photo').val());
            }
        } else

        {
            readURL_image(this);
        }
    });
    function readURL_image(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            var file = input.files[0];
            var image = new Image();
            reader.readAsDataURL(file);
            reader.onload = function (_file) {
                image.src = _file.target.result;
                image.onload = function () {
                    $('#testImg').show();
                    $('#testImg').attr('src', image.src);
                };

            };

        }
    }

    $('#logo').change(function () {
        var ext = $('#logo').val().split('.').pop().toLowerCase();

        if ($.inArray(ext, ['jpg', 'jpeg', 'png', 'gif']) == -1) {
            alert(image_error_msg);
            $('#logo').val('');
            $('#testImglogo').attr('src', '');
            $('#testImglogo').hide();
            return false;
        }
        var isChrome = /Chrome/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor);
        var isSafari = /Safari/.test(navigator.userAgent) && /Apple Computer/.test(navigator.vendor);
        if (isSafari) {
            var nAgt = navigator.userAgent;
            var fullVersion = '' + parseFloat(navigator.appVersion);
            var verOffset;
            if ((verOffset = nAgt.indexOf("Safari")) != -1) {
                fullVersion = parseFloat(nAgt.substring(verOffset + 7));
                if ((verOffset = nAgt.indexOf("Version")) != -1)
                    fullVersion = parseFloat(nAgt.substring(verOffset + 8));
            }
            if (fullVersion >= 7)
            {
                readURL1(this);
            } else {
                $('#imgShowlogo').html($('#logo').val());
            }
        } else

        {
            readURL1(this);
        }
    });
    function readURL1(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            var file = input.files[0];
            var image = new Image();
            reader.readAsDataURL(file);
            reader.onload = function (_file) {
                image.src = _file.target.result;
                image.onload = function () {
                    $('#testImglogo').show();
                    $('#testImglogo').attr('src', image.src);
                };

            };

        }
    }

});


function delete_confirm() {
    return confirm("Are you sure you want to delete this record?") ? !0 : !1
}
$(document).ready(function () {
    $('#selectall-chk-box').click(function (event) {
        if (this.checked) {
            $('.chkMe').each(function () {
                this.checked = true;
            });
        } else {
            $('.chkMe').each(function () {
                this.checked = false;
            });
        }
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

}

function goToURL(url) {
    window.location.href = url;
}

function removeRow(rowId) {
    $('#' + rowId).remove();
}

function clear_form_elements(ele) {
    $(ele).find(':input').each(function () {
        switch (this.type) {
            case 'password':
            case 'hidden':
            case 'select-multiple':
            case 'select-one':
            case 'text':
            case 'email':
            case 'url':
            case 'file':
            case 'number':
            case 'textarea':
                $(this).val('');
                break;
            case 'radio':
            case 'checkbox':
                this.checked = false;
        }
    });
}

function updateOrder(controller, formId) {
    var URL = ADMIN_URL + controller + '/ajaxUpdateOrder';
    var data = $('#' + formId).serialize();
    $.ajax({
        type: "POST",
        url: URL,
        data: data,
        dataType: "html",
        success: function (response) {
            showMessage('alert-success', 'formErrorMsg', response);
            setTimeout(function () {
                window.location.href = ADMIN_URL + controller;
            }, 1000);
        },
        error: function () {
            alert("Error occured during Ajax request...");
        }
    });
}
$(document).ajaxStart(function () {
    showLoader();
});
$(document).ajaxStop(function () {
    hideLoader();
});

function showLoader() {
    if ($('#show_loader').val() == 0)
    {
        $('#loaderDiv').css("display", "block");
    }
}

function hideLoader() {
    $('#loaderDiv').css("display", "none").delay(800);
}
