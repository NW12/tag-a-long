


<input type="hidden" id="thread_id" name="thread_id" value="<?php echo $thread_id; ?>">
<input type="hidden" id="friend_id" name="friend_id" value="<?php echo $friend_id; ?>">

<input type="hidden" name="user_name" id="user_name" value="<?php echo $userdata['user_name'] ?>">
<input type="hidden" id="member_url" name="member_url" value="<?php echo site_url('profile/' . $userdata['user_name']) ?>">
<input type="hidden" id="subject" name="subject" value="<?php echo $messages[0]['subject']; ?>">





<div class="clear"></div>

<span id="message_data">
    <?php
    
    //$this->common->aasort($messages, 'message_id');
  /*  print_r($messages);
    exit;*/
    foreach ($messages as $msg) {
        ?>

        <?php
        if ($msg['from_user_id'] == $this->session->userdata('user_id')) {
            $cls1 = 'pull-right ';
            $cls2 = 'pull-left to';
            $clr1 = 'form-msg';
        } else {
            $cls1 = 'pull-left to';
            $cls2 = 'pull-right from';
             $clr1 = 'to-msg';
             
        }
        ?>

        <div class="msg-box" id="del_msg_<?php echo $msg['message_id'] ?>">
            <div class="featured-user media <?php echo $clr1; ?>">

                <div class="featured-user-home-img-small media-left <?php echo $cls1; ?>">

 
                </div>
                <div class="media-body">
                <span class="img-chat"> <img src="<?php echo getImage($msg['photo']); ?>" class="img-circle-small">
                </span>

                    <!--<div class="featured-user-home-text-small  <?php echo $cls1; ?>">
                        <h4 class="media-heading">
                            <?php
                         
                                ?><a href="javascript:void(0);"><?php echo $msg['user_name'] ?></a>
                           
                        </h4>
                        <?php
                        $time11 = time();
                        $your_date = intval($msg['created']);
                        $datediff = $time11 - $your_date;

                        if (floor($datediff / (60 * 60 * 24)) > 0) {
                            echo date('M d Y g:i a', intval($msg['created']));
                        } else {
                            $diff1 = $this->common->dateDiff($time11, intval($msg['created'])) . " ago";
                            if (trim($diff1) == "ago") {
                                echo lang('lbl_fewSecondAgo');
                            } else {
                                echo $diff1;
                            }
                        }
                        ?></div>-->

                  <span class="<?php if (str_word_count($msg['message']) > 50) echo 'excerpt' ?> <?php echo $cls1; ?>">
                    <?php echo $msg['message']; ?>
                </span>
                    <div class=" <?php echo $cls2; ?>">
                        <a class="ancorClick" onclick="del_messages(<?php echo $msg['message_id']; ?>);" title="Delete"><i class="fa fa-times"></i></a>
                    </div>
                </div>

                <div class="clear5"></div>

               

              
        </div>
        </div>

     
    <?php } ?>

</span>
 <div class="user-post">

        <textarea type="text" class="form-control " placeholder="" id="message" name="message"></textarea> <script type="text/javascript">/*<![CDATA[*/(function (a) {

                a.fn.autoResize = function (j) {
                    var b = a.extend({onResize: function () {}, animate: true, animateDuration: 150, animateCallback: function () {}, extraSpace: 20, limit: 1000}, j);
                    this.filter('textarea').each(function () {
                        var c = a(this).css({resize: 'none', 'overflow-y': 'hidden'}), k = c.height(), f = (function () {
                            var l = ['height', 'width', 'lineHeight', 'textDecoration', 'letterSpacing'], h = {};
                            a.each(l, function (d, e) {
                                h[e] = c.css(e)
                            });
                            return c.clone().removeAttr('id').removeAttr('name').css({position: 'absolute', top: 0, left: -9999}).css(h).insertBefore(c)
                        })(), i = null, g = function () {
                            f.height(0).val(a(this).val()).scrollTop(10000);
                            var d = Math.max(f.scrollTop(), k) + b.extraSpace, e = a(this).add(f);
                            if (i === d) {
                                return
                            }
                            i = d;
                            if (d >= b.limit) {
                                a(this).css('overflow-y', '');
                                return
                            }
                            b.onResize.call(this);
                            b.animate && c.css('display') === 'block' ? e.stop().animate({height: d}, b.animateDuration, b.animateCallback) : e.height(d)
                        };
                        c.unbind('.dynSiz').bind('keyup.dynSiz', g).bind('keydown.dynSiz', g).bind('change.dynSiz', g)
                    });
                    return this
                }
            })(jQuery);
            $('textarea#message').autoResize(); /*]]>*/</script>

        <div classs="clear5"></div>
 <div classs="clear5"></div>
        <ul class="bottom-icons" style="padding:0;margin:0;">
            <li style="padding:0;margin:0;"><button onclick="sendMemberMessage()" style="margin-right:0;" class="post-btn" type="button">Send</button></li>
        </ul>
        <br>
    </div>


<script type="text/javascript">
    var xhr = '';
function sendMemberMessage() {

    if (xhr == null) {

        return false;
    }

    if ($.trim($('#message').val()) != "") {
        var result = $('#message').val();
        var message = $('#message').val();
        var thread_id = $('#thread_id').val();
        var subject = $('#subject').val();
        var friend_id = $('#friend_id').val();

        var formData = new FormData();
        formData.append('message', message);
        formData.append('thread_id', thread_id);
        formData.append('subject', subject);
        formData.append('friend_id', friend_id);


        xhr = $.ajax({

            url: BASE_URL + 'messages/sendMemberMessage',
            type: "POST",
            data: formData,
            dataType: "json",
            async: false,
            processData: false,
            contentType: false,

            success: function (msg) {
                var document = '';
                var upload = '';
                var img = '';

              

                var message = "";
                message = message + '<div class="msg-box del_msg" >',
                        message = message + '<div class="featured-user media form-msg">',
                       
                        message = message + '<div class="media-body"> <span class="img-chat"> <img src="<?php echo getImage($msg['photo']); ?>" class="img-circle-small"></span><!--<div class="featured-user-home-text-small  pull-right">',
                        message = message + '<<h4 class="media-heading">',
                        message = message + '<a href="' + $('#member_url').val() + '">' + $('#user_name').val() + '</a>',
                        message = message + '</h4>a few second ago</div>-->',
                        
                        message = message + '<span class="pull-right">' + result + '</span>',
						message = message + '</div>',
                        message = message + '<div class="clear"></div>',
                        message = message + '</div></div>';
                        

                $('#message_data').append(message);
               

                $('#message').val('');
                $('.del_msg').attr('id', 'del_msg_' + msg.id);
                $('.del_msg').attr('tabindex', '1');
                $('#message_data > li').removeClass('del_msg');
                $('#del_msg_' + msg.id).focus();
                $('#del_msg_' + msg.id).removeAttr('tabindex');

                 $('#message_data').scrollTop($('#message_data')[0].scrollHeight);

            }
        });
    }
}
</script>

<script type="text/javascript">
     function del_messages(mId) {


        swal({
  title: "Are you sure?",
  text: "Once deleted, you will not be able to recover this Message",
  icon: "warning",
  buttons: true,
  dangerMode: true,
}).then((willDelete) => {
  if (willDelete) {

     URL = BASE_URL + 'messages/delete_msg';
        $.ajax({
            type: "POST",
            url: URL,
            data: {'id': mId},
            success: function (data) {
                var msg = 'Message deleted successfully';   
                  swal(msg, "", "success");
                $('#del_msg_' + mId).remove();
            }
        });

  } else {
    swal("Message not deleted ");
  }
});

       
    }


   
</script>