
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


 