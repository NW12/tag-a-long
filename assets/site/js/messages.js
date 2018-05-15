
function getMessages(job_id, conversation_id, div_id) {

    $("#conversation_id").val(conversation_id);
    $.ajax({
        type: "POST",
        url: BASEURL + 'messages/getMessageHistory',
        dataType: "json",
        data: {
            'job_id': job_id,
            'conversation_id': conversation_id
        },
        success: function (response) {
            $("#counter_" + div_id).html('');
            $("#messages_history").empty();
            $("#project_title").html(" ");
            $('#project_title').attr('href',BASEURL + 'task_detail/' + job_id);
            $("#project_title").html("<i style='font-size: 15px' class='fa fa-info-circle' aria-hidden='true'></i>  " + response.project_name);
            $("#messages_history").html(response.history);
            $('#contacts_container').find('.defalut_active').addClass('remove-color');
            $('#contacts_container').find('.defalut_active').removeClass('defalut_active');

            $("#contact_" + div_id).addClass('defalut_active');
            $("#contact_" + div_id).removeClass('remove-color');
            // $(".remove-color").css({"background-color": "#fff", "color": "black"});
            //$("#contact_" + div_id).css({"background-color": "#337ab7", "color": "white"});
            $("#new_messages_container").scrollTop($("#new_messages_container")[0].scrollHeight);


        }
    });
}

function addMessage() {


    var message = $("#message").val();
    var conversation_id = $("#conversation_id").val();
    if ($.trim(message).length > 0) {
        $("#message").val('');
        $.ajax({
            type: "POST",
            url: BASEURL + 'messages/send_message',
            dataType: "json",
            data: {
                'message': message,
                'conversation_id': conversation_id
                        //'to_user_id': to,
                        //'project_id': job_id,
            },
            success: function (response) {
                if (document.getElementById("msg") !== null)
                {
                    $("#msg").remove();
                }

                $("#message_container").append(response.history);
                $("#new_messages_container").scrollTop($("#new_messages_container")[0].scrollHeight);
                $("#message").focus();
                //  $("#new_messages_container").animate({scrollTop: $('#new_messages_container').prop("scrollHeight")}, 1000);
                //$("#messages_history").animate({scrollTop: $container[0].scrollHeight}, "slow");
            }
        });
    } else {
        alert("Plz enter Message");
    }
}
/***************get receiover messages if send any during the chatting**********************/
function get_receiver_messages() {

    var reciver_message_id = $(".recv_message").last().val();
    //  alert(reciver_message_id);
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: BASEURL + "messages/get_receiver_messages",
        data: ({
            'reciver_message_id': reciver_message_id,
            'conversation_id': $("#conversation_id").val(),
        }),
        success: function (data) {
            $("#message_container").append(data.history);
            $("#new_messages_container").animate({scrollTop: 9999999999999999}, '5000');
        }

    });

    //alert("ok");
}
function get_contacts() {
    var active_div = $('#contacts_container').find('.defalut_active').attr("data-id");

    //  alert(reciver_message_id);
    $.ajax({
        type: 'POST',
        dataType: 'json',
        url: BASEURL + "messages/getContacts",
        data: {
            'active_div': active_div,
        },
        success: function (data) {
            $("#contacts_container").html(data)

        }

    });

    //alert("ok");
}
/************************************************/

setInterval(function () {
    get_receiver_messages();
    get_contacts();
}, 10000);


function myFunction() {


    // Declare variables
    var input, filter, ul, li, a, i;
    input = document.getElementById('myInput');
    filter = input.value.toLowerCase();

    ul = document.getElementById("myUL");
    li = ul.getElementsByTagName('li');

    // Loop through all list items, and hide those who don't match the search query
    for (i = 0; i < li.length; i++) {
        //   a = li[i].getElementsByTagName("a")[0].getElementsByTagName("strong")[0];
        a = li[i].getElementsByTagName("strong")[0];
        console.log(a);
        if (a.innerHTML.indexOf(filter) > -1) {
            li[i].style.display = "";
        } else {
            li[i].style.display = "none";
        }
    }
}

