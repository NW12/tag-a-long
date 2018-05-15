/**General functions**/

/**Hide Success Messages*/
setTimeout(function () {
    $('.alertMessages').toggle("slide")
}, 1000);

/**
 * Method: updateStatus
 * params: itemId,status
 * */

function updateStatus(controller, itemId, status) {
    
	
    if (status == 1)
    {
        $('.status_label' + itemId).removeClass('label-info').addClass('label-danger').html(lbl_inactive);
    } else {
        $('.status_label' + itemId).removeClass('label-danger').addClass('label-info').html(lbl_active);
    }
    var URL = ADMIN_URL + controller + '/ajaxChangeStatus';
		
    $.ajax({
        type: "POST",
        url: URL,
        data: {
            'itemId': itemId,
            'status': status
        },
        dataType: "html",
        success: function (response) {

            showMessage('alert-success', 'formErrorMsg', response);
            if (status == 1)
            {
                $('.status_button' + itemId).removeAttr('onclick').attr('onclick', 'updateStatus("' + controller + '","' + itemId + '","0")');
                $('.status_button' + itemId + ' > i').removeClass('fa-play').addClass('fa-stop');
                
                $('.status_button' + itemId).removeClass('blue').addClass('red');

                $('.status_sm_button' + itemId).removeAttr('onclick').attr('onclick', 'updateStatus("' + controller + '","' + itemId + '","0")');
                $('.status_sm_button' + itemId + ' > span').removeClass('blue').addClass('red');
                $('.status_sm_button' + itemId + ' > span > i').removeClass('fa-play').addClass('fa-stop');

            } else {
                $('.status_button' + itemId).removeAttr('onclick').attr('onclick', 'updateStatus("' + controller + '","' + itemId + '","1")');
                $('.status_button' + itemId + ' > i').removeClass('fa-stop').addClass('fa-play');
                $('.status_button' + itemId).removeClass('red').addClass('blue');

                $('.status_sm_button' + itemId).removeAttr('onclick').attr('onclick', 'updateStatus("' + controller + '","' + itemId + '","1")');
                $('.status_sm_button' + itemId + ' > span').removeClass('red').addClass('blue');
                $('.status_sm_button' + itemId + ' > span > i').removeClass('fa-stop').addClass('fa-play');

            }

            setTimeout(function () {
                $('#formErrorMsg').hide('slow');
            }, 3000);

        },
        error: function () {

            alert(ajax_alert);

        }

    });

}

function updateStatusDropdown(controller,itemId,status) {
    if (status == 1)
    {
        $('.status_label' + itemId).removeClass('label-info').addClass('label-danger').html(lbl_inactive);
    } else {
        $('.status_label' + itemId).removeClass('label-danger').addClass('label-info').html(lbl_active);
    }
    var URL = ADMIN_URL + controller + '/ajaxChangeStatus';
    $.ajax({
        type: "POST",
        url: URL,
        data: {
            'itemId': itemId,
            'status': status
        },
        dataType: "html",
        success: function (response) {
            showMessage('alert-success', 'formErrorMsg', response);
            if (status == 1)
            {
                 //showMessage('alert-success', 'formErrorMsg', response);
                $('.status_button' + itemId).removeAttr('onclick').attr('onclick', 'updateStatusDropdown("' + controller + '","' + itemId + '","0")');
                $('.status_button' + itemId + ' > i').removeClass('fa-plus').addClass('fa-minus');
                $('.status_button' + itemId).removeClass('blue').addClass('red');

                $('.status_sm_button' + itemId).removeAttr('onclick').attr('onclick', 'updateStatus("' + controller + '","' + itemId + '","0")');
                $('.status_sm_button' + itemId + ' > span').removeClass('blue').addClass('red');
                $('.status_sm_button' + itemId + ' > span > i').removeClass('fa-plus').addClass('fa-minus');

            } else {
                $('.status_button' + itemId).removeAttr('onclick').attr('onclick', 'updateStatusDropdown("' + controller + '","' + itemId + '","1")');
                $('.status_button' + itemId + ' > i').removeClass('fa-minus').addClass('fa-plus');
                $('.status_button' + itemId).removeClass('red').addClass('blue');

                $('.status_sm_button' + itemId).removeAttr('onclick').attr('onclick', 'updateStatus("' + controller + '","' + itemId + '","1")');
                $('.status_sm_button' + itemId + ' > span').removeClass('red').addClass('blue');
                $('.status_sm_button' + itemId + ' > span > i').removeClass('fa-minus').addClass('fa-plus');

            }

            setTimeout(function () {
                $('#formErrorMsg').hide('slow');
            }, 3000);

        },
        error: function () {

            alert(ajax_alert);

        }

    });
}

/**
 
 @Method: deleteListItem
 
 @Param: controller, itemId
 
 @Return: boolean (True,false)
 
 */

function deleteListItem(controller, itemId, id) {

    var ans = confirm('Are you sure! You want to delete.');

    if (ans) {

        if (id > 0) {

            var URL = ADMIN_URL + controller + '/deleteItem/' + itemId;

            //Start AJax Call
            $.ajax({
                type: "POST",
                url: URL,
                dataType: "html",
                success: function (response) {

                    if (response == 1) {
                        //RemoveRow
                        var rowId = controller + '_' + id;
                        removeRow(rowId);
                        //Show SuccesMessage
                        var msg = 'Record deleted successfully.';

                        showMessage('alert-success', 'formErrorMsg', msg);
                        setTimeout(function () {
                            $('#formErrorMsg').slideUp('slow');
                        }, 2000);
                        /*setTimeout(function(){
                         window.location.href = ADMIN_URL+controller;
                         }, 3000);*/
                    } else {

                        //Show errorMessage
                        var msg = 'Record not deleted! try again.';
                        showMessage('alert-danger', 'formErrorMsg', msg);
                    }
                },
                error: function () {
                    alert(ajax_alert);
                }

            });

        }

    }

}

/**
 
 @Method: Check & create Page Slug
 
 @Retrun: listing/HTML
 
 **/

function creatPageSlug() {
    $('#pageExist_error').hide();
    var URL = ADMIN_URL + 'pages/checkPage';
    //Start AJax Call
    $.ajax({
        type: "POST",
        url: URL,
        dataType: "html",
        data: {
            'slug': $('#pageTitle').val()
        },
        success: function (response) {

            if (response == 1) {
                if ($('#old_slug').val() == $('#pageTitle').val()) {
                    $('#slug').val($('#old_slug').val());
                    return false;
                } else {
                    $('#pageExist_error').show();
                    $('#slug').val('');
                    return false;
                }

            } else {
                $('#slug').val(response.trim());
            }
        },
        error: function () {

            alert(ajax_alert);

        }

    });

}
/**
 Validate Password 
 **/


function validate_password() {
    $('#validate_password_error').hide();
    if (!isValidPassword($("#password").val())) {
        msg = 'Password must have at least 6 characters including special characters.';
        showMessage('alert-danger', 'validate_password_error', msg);
        $("#password").focus();
        $("#password").val('');
        return false;
    }
}

/**
 @Method: Check email
 @Retrun: listing/HTML
 **/
function checkEmail() {
    $('#emailExist_error').hide();
    var msg = ''
    if (!isValidEmailAddress($("#email").val())) {
        msg = 'The email address contains illegal characters. Please enter correct email.';
        showMessage('alert-danger', 'emailExist_error', msg);
        $("#email").focus();
        $("#email").val('');
        return false;
    }
    if ($('#email').valid())
    {
        var URL = ADMIN_URL + 'users/checkEmail';
        //Start AJax Call
        $.ajax({
            type: "POST",
            url: URL,
            dataType: "html",
            data: {
                'email': $('#email').val()
            },
            success: function (response) {

                if (response == 1)
                {
                    $('#emailExist_error').html('Email already exists... Try another one.');
                    $('#emailExist_error').show();
                    $('#email').val('');
                    return false;

                } else {
                    return true;
                }
            },
            error: function () {
                alert(ajax_alert);
            }

        });
    }

}

/* check username */
function validate_username() {
    $('#validate_username_error').hide();

    var msg = ''
    if ($("#username").val().length < 5) {
        msg = 'The username should be at least 5 characters long.';
        showMessage('alert-danger', 'validate_username_error', msg);
        $("#username").focus();
        $("#username").val('');
        return false;
    }
    if ($('#email').valid())
    {
        var URL = ADMIN_URL + 'users/checkUsername';
        //Start AJax Call
        $.ajax({
            type: "POST",
            url: URL,
            dataType: "html",
            data: {
                'username': $('#username').val()
            },
            success: function (response) {

                if (response == 1)
                {
                    $('#validate_username_error').html('Username already exists... Try another one.');
                    $('#validate_username_error').show();
                    $('#username').val('');
                    return false;

                } else {
                    return true;
                }
            },
            error: function () {
                alert(ajax_alert);
            }

        });
    }

}

/**
 @Method: Check email
 @Retrun: listing/HTML
 **/
function checkCompanyEmail() {
    $('#emailExist_error').hide();

    var msg = ''
    if (!isValidEmailAddress($("#email").val())) {
        msg = 'The email address contains illegal characters. Please enter correct email.';
        showMessage('alert-danger', 'formErrorMsg', msg);
        $("#email").focus();
        $("#email").val('');
        return false;
    }
    if ($('#email').valid())
    {
        var URL = ADMIN_URL + 'companies/checkEmail';
        //Start AJax Call
        $.ajax({
            type: "POST",
            url: URL,
            dataType: "html",
            data: {
                'email': $('#email').val()
            },
            success: function (response) {

                if (response == 1)
                {
                    $('#emailExist_error').html('Email already exists... Try another one.');
                    $('#emailExist_error').show();
                    $('#email').val('');
                    return false;

                } else {
                    return true;
                }
            },
            error: function () {
                alert(ajax_alert);
            }

        });
    }

}


/**
 @Method: checkCompanyName
 @Retrun: listing/HTML
 **/
function checkCompanyName() {
    $('#companyExist_error').hide();

    if ($('#company_name').valid())
    {
        var URL = ADMIN_URL + 'companies/checkCompany';
        //Start AJax Call
        $.ajax({
            type: "POST",
            url: URL,
            dataType: "html",
            data: {
                'company_name': $('#company_name').val()
            },
            success: function (response) {

                if (response == 1)
                {
                    $('#companyExist_error').html('Company Name already exists... Try another one.');
                    $('#companyExist_error').show();
                    $('#company_name').val('');
                    return false;

                } else {
                    return true;
                }
            },
            error: function () {
                alert(ajax_alert);
            }

        });
    }

}


function creatCategorySlug() {
    $('#CatExist_error').hide();
    var URL = ADMIN_URL + 'categories/checkCatSlug';
    //Start AJax Call
    $.ajax({
        type: "POST",
        url: URL,
        dataType: "html",
        data: {
            'slug': $('#catTitle').val()
        },
        success: function (response) {

            if (response == 1) {
                if ($('#old_category_slug').val() == $('#catTitle').val()) {
                    $('#category_slug').val($('#old_category_slug').val());
                    return false;
                } else {
                    $('#CatExist_error').show();
                    $('#category_slug').val('');
                    return false;
                }

            } else {
                $('#category_slug').val(response.trim());
            }
        },
        error: function () {

            alert(ajax_alert);

        }

    });

}
/** Functions for custom fileds */
/**
 * Method: showCfOptions
 */
function showCfOptions(val) {

    if (val == 'text') {

        $("#additional_info_link").hide();
        $("#additional_options").hide();
        $("#select_list_type").hide();
        $("#additional_info_text").show();

        /* apend options for search type */
        var options = '<option value="text">Text Field'
                + '</option>';

    } else if (val == 'textarea') {

        $("#additional_info_text").hide();
        $("#additional_info_link").hide();
        $("#additional_options").hide();
        $("#select_list_type").hide();

        /* apend options for search type */
        var options = '';

    } else if (val == 'radio') {

        $("#additional_info_text").hide();
        $("#select_list_type").hide();
        $("#additional_info_link").show();

        /* apend options for search type */
        var options = '<option value="selectlist">Dropdown List'
                + '</option><option value="checkbox">'
                + 'Checkbox'
                + '</option><option value="radio" selected="selected">'
                + 'Radio Button' + '</option>';

    } else if (val == 'checkbox') {

        $("#additional_info_text").hide();
        $("#select_list_type").hide();
        $("#additional_info_link").show();

        /* apend options for search type */
        var options = '<option value="selectlist">Dropdown List'
                + '</option><option value="checkbox" selected="selected">'
                + 'Checkbox' + '</option><option value="radio">'
                + 'Radio Button' + '</option>';

    } else if (val == 'selectlist') {

        $("#additional_info_text").hide();
        $("#additional_info_link").show();
        $("#select_list_type").show();

        /* apend options for search type */
        var options = '<option value="selectlist" selected="selected">'
                + 'Dropdown List'
                + '</option><option value="checkbox">'
                + 'Checkbox' + '</option><option value="radio">'
                + 'Radio Button' + '</option>';

    }

    if (val == 'textarea') {
        $('search_typeOptionsDiv').html('');
        $('#search_typeOptionsContainer').slideUp('slow');
        $('#advance_searchOptionsDiv').slideUp('slow');
        $('#searchAbleOptionsContainer').slideUp('slow');
    } else {
        $('#searchAbleOptionsContainer').slideDown('slow');
        $('#advance_searchOptionsDiv').slideDown('slow');
        $('#search_typeOptionsContainer').slideDown('slow');
        $('#search_typeOptionsDiv').html('');
        var listOptions = '<select name="search_type" id="search_type" class="col-xs-12 col-sm-5">'
                + options + '</select>';
        $('#search_typeOptionsDiv').html(listOptions);
    }
}

/**
 * Method: showHideAdvncSearch
 *
 * @param: type
 */
$(function () {
    $('#searchable').on('change', function () {
        if (this.value == 1)
        {
            $('#advance_searchOptionsDiv').slideDown('slow');
        } else
        {
            $('#advance_searchOptionsDiv').slideUp('slow');
            $('#advance_search').val('0');
        }
    });

});


/**
 * Method: addOptions
 *
 * @param: type
 */
function addOptions(type) {
    var output = '';
    // Get size of existing options and add new one.
    $("#additional_options").show('slow');
    var count = $('#additional_options ol').size() + 1;
    output = '<ol id="ol_'
            + count
            + '" class="media-list"> <li id="h_'
            + count
            + '"><strong>Option '
            + count
            + '</strong></li><li><label for="opt_label_'
            + count
            + '">Option Label</label>&nbsp;<input type="text" name="option_label_'
            + count
            + '" id="option_label_'
            + count
            + '" value="" />&nbsp;&nbsp;<button type="button" class="btn btn-danger btn-xs" onclick="delete_cf_options(this.id)" id="'
            + count
            + '"><i class="ti-close"></i> Delete</button></li><li><label for="opt_default_'
            + count
            + '">Default</label>&nbsp;&nbsp;<label class="blue"><input type="radio" name="option_default_'
            + count
            + '"  value="1" id="yes_option_default_'
            + count
            + '" class="ace"/><span class="lbl">Yes</span></label><label class="blue"><input type="radio" name="option_default_'
            + count + '"  value="0" checked="checked" id="no_option_default_'
            + count + '" class="ace" /><span class="lbl">&nbsp;No</span></label></li></ol>';
    $('#additional_options').append(output);
}
/**
 * Method: delete_cf_options
 *
 * @param id
 * @returns {Boolean}
 */
function delete_cf_options(id) {
    var ans = confirm('Are you sure? You want to delete');
    if (ans) {
        // count total ol
        var count = $('#additional_options ol').size();
        // alert(id);
        $("#ol_" + id).remove(); // Remove current ol
        for (var i = 1; i <= count; i++)// Change ids of next elements
        {
            if (i > id) {
                var next = i;
                var new_id = i - 1;
                $("#" + next).attr('id', new_id);
                $("#ol_" + next).attr('id', 'ol_' + new_id);
                $("#h_" + next).html('<strong>Option ' + new_id + '</strong>');
                $("#h_" + next).attr('id', 'h_' + new_id);
                $("#option_label_" + next).attr('name',
                        'option_label_' + new_id);
                $("#option_label_" + next).attr('id', 'option_label_' + new_id);
                $("#yes_option_default_" + next).attr('name',
                        'option_default_' + new_id);
                $("#no_option_default_" + next).attr('name',
                        'option_default_' + new_id);
            }
        }
    }
    return false;
}

/**
 
 * Method: parent_category1
 
 * Return: boolean
 
 * */
function parent_category1(idd, inc) {

    var incc;
    incc = inc;
    incc = incc + 1;
    var allselect = ($('#form_listings .catClass').size() + 2);
    for (i = incc; i <= allselect; i++)
    {
        $('.subCat_' + i).remove();
        //         $('#sub_parent').val('');
        //        $('#extraFields').html('');
    }

    if ($('#' + idd).val() == 0 || $('#' + idd).val() == "") {
        return false;
    } else {

        var URL = ADMIN_URL + 'listings/getSubCategory';
        $
                .ajax({

                    type: "POST",
                    url: URL,
                    data: 'category_id=' + $('#' + idd).val() + '&level=' + inc,
                    dataType: 'json',
                    success: function (data1) {

                        inc++;

                        var subcat = "";
                        if (data1.result_counter == 0) {
                            $('.subCat_' + (inc++)).remove();
                        } else {
                            $('.subCat_' + inc).remove();

                            subcat = '<div class="form-group subCat_'
                                    + inc
                                    + '"><label class="control-label col-xs-12 col-sm-3 no-padding-right">' + data1.label + '</label><div class="col-xs-12 col-sm-9"><div class="clearfix"><select id="category_'
                                    + inc
                                    + '" name="category_id[]"  class="col-xs-12 col-sm-5  catClass" onchange="parent_category1(\'category_'
                                    + inc + '\',' + inc
                                    + ')"><option value="">Select</option>';
                            $.each(data1.result, function () {

                                subcat = subcat + '<option value="'
                                        + this.category_id + '">'
                                        + this.category_name + '</option>';

                            });

                            subcat = subcat + '</select></div></div></div>';



                        }
                        getSubFileds();
                        $('.subCat_' + (--inc)).after(subcat);
                        $('#inc').val($('#form_listings > .catClass').size());



                        var option_all = $(".catClass option:selected").map(function () {
                            if ($(this).val() == 0)
                            {
                            } else {
                                return $(this).val();
                            }

                        }).get().join(',');


                        $('#sub_parent').val(option_all);

                    }
                });
    }
}
/**
 
 * Method: getSubFileds of category with parent_category1() function
 
 * Return: boolean
 
 * */
function getSubFileds(product_id)
{

    $('#extraFields').html('');
    var option_all = $(".catClass option:selected").map(function () {
        return $(this).val();
    }).get().join(',');
    if (product_id == null)
    {
        product_id = 0;
    }
    var data = 'category_id=' + option_all + '&product_id=' + product_id;
    var URL = ADMIN_URL + 'listings/getSubFileds';
    $.ajax({

        type: "POST",

        url: URL,

        data: data,

        dataType: "html",

        success: function (response)
        {
            $('#extraFields').html(response);
        }
    });
}

$(function () {
    $(".radio_media").change(function () {
        if (this.value == 2) {
            $('#vidDiv').stop(true, true).show(500);
            $('#linkDiv').stop(true, true).hide(500);
        } else {
            $('#vidDiv').stop(true, true).hide(500);
            $('#linkDiv').stop(true, true).show(500);
        }
    });

    $(".radio_address").change(function () {
        if (this.value == 1) {
            $('.addressDisableNot').attr('disabled', true);
            $('.addressDisableNot').attr('disabled', true);
            $('.addressDisableNot').attr('disabled', true);
            $('.addressDisableNot').attr('disabled', true);


        } else {
            $('.addressDisableNot').attr('disabled', false);
            $('.addressDisableNot').attr('disabled', false);
            $('.addressDisableNot').attr('disabled', false);
            $('.addressDisableNot').attr('disabled', false);
        }
    });
});

function parse_url(url)
{
    var matches = url.match(/^(?:https?:\/\/)?(?:www\.)?youtube\.com\/watch\?(?=.*v=((\w|-){11}))(?:\S+)?$/);
    if (matches) {
        return true;
    } else {
        $('#video_link').val('');
        $('#video_link').focus();
        alert('Please enter only Youtube URL.');
    }
}
function checkVideo()
{
    var ext = $('#video_name').val().split('.').pop().toLowerCase();
    if ($.inArray(ext, ['mp4', 'flv', 'mpeg', '3gp', 'mov', 'mp3', 'avi', 'mpg', 'mkv', 'webm', 'wmv']) !== -1)
    {
        //get the file size and file type from file input field
        var fsize = $('#video_name')[0].files[0].size;
        //alert(fsize);
        total = parseInt(MAX_UPLOAD_SIZE * 1048576)
        if (fsize > total) //do something if file size more than 1 mb (1048576)
        {
            $('#video_name').val('');
            $('#video_name').focus();
            alert("Upload file size exceeds. Please upload " + MAX_UPLOAD_SIZE + " MB or less size video!");
            return false;
        } else {
            return true;
        }
        return true;
    } else {
        $('#video_name').val('');
        $('#video_name').focus();
        alert('Only following types of videos are allowed to upload (mp4,flv,mpeg,3gp,mov,mp3,avi,mpg,mkv,webm,wmv)');
        return false;
    }
}
function delVideos(id, video) {

    if (delete_confirm())
    {
        $("#video_nameDv").html('');
        $("#old_video_name").val('');
        $.ajax({
            type: "POST",
            url: ADMIN_URL + 'listings/delete_video/' + id,
            data: 'product_id=' + id + '&video_name=' + video,
            success: function (msg) {}
        });
    }
}

/**
 
 @Method: Delete listings Images
 
 @Retrun: listing/HTML
 
 **/
function delete_image(filename, image_id)
{
    URL = ADMIN_URL + 'listings/delete_image';
    var ans = confirm("Are you sure you want to delete this image?") ? !0 : !1;
    if (ans)
    {
        $.ajax({
            type: "POST",
            url: URL,
            data: 'image_id=' + image_id + '&image=' + filename,
            success: function (msg) {
                $('#imagesCount').val($('#imagesCount').val() - 1);
                $('#image_' + image_id).remove();
            }
        });
    }
}

/**
 
 @Method: Hide / Show banner Code or image/URL
 
 **/
$(document).ready(function () {
    $(".is_banners").click(function () {
        var val = $(this).val();
        $("div.banSH").hide();
        $("#banner_" + val).show();
        $("#url").val('');
        $("#b_images").val('');
        $("#bannerCode").val('');
    });


    /**
     @Method: Hide / Show banner Image Sizes
     **/
//    $("#advertising_destination_id").val(1);
    $("#advertising_destination_id").change(function () {
        var val = $(this).val();
        $("div.bImgSize").hide();
        $("#banLoc_" + val).show();
    });
});