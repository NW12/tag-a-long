<style>
    body { background: #fff !important; }
    .whitebox { background: #fff; padding: 15px 0; }
    #dynamic-table_wrapper .row:first-child{display: none;}
    #dynamic-table_wrapper .row .col-sm-12{padding: 0;}
    #dynamic-table_wrapper .row:last-child{display: none;}
    #dynamic-table_wrapper .row{padding: 0;background: #fff;border: none;}

    #delete_thread{border-radius: 20px;}

     #delete_thread:hover {
    background-color: #071B3E !important;
    font-weight: 600;
    color: #feae52;
}
</style>

<div class="container-fluid container-data margin-50">
    <div class="row">
       
        <div class="col-md-10">
            <?php
            if ($this->session->flashdata('success_msg')) {
                echo '<div class="alert alert-success alertMessage">' . $this->session->flashdata('success_msg') . '</div>';
            } elseif ($this->session->flashdata('error_msg')) {
                echo '<div class="alert alert-danger alertMessage">' . $this->session->flashdata('error_msg') . '</div>';
            }
            ?>

            <div class="product-breadcroumb"> <a href="<?php echo site_url(); ?>"><?php echo lang('lbl_Home'); ?></a> <a ><?php echo lang('lbl_messagesConversation'); ?></a> </div>
            <div class="clear10"></div>
        </div>
        <div class="col-md-10">

            <ul class="product-tab msg_tabs clearfix" role="tablist">
                <li role="presentation" class="<?php echo 'active'; ?> "><a  href="<?php echo site_url('messages/all'); ?>"><i class="fa fa-envelope"></i>&nbsp;<strong>Messages</strong></a></li>

<!--                <li role="presentation"><a  href="<?php echo site_url('messages/order'); ?>"><i class="fa fa-envelope"></i>&nbsp;<strong>Request</strong></a></li>-->


                <li role="presentation"><a  href="<?php echo site_url('notifications'); ?>"><i class="fa fa-warning"></i>&nbsp;<strong><?php echo lang('lbl_notifications'); ?></strong></a></li>



                <li role="presentation"><a  href="<?php echo site_url('connections/blacklist'); ?>"><i class="fa fa-warning"></i>&nbsp;<strong><?php echo lang('lbl_contactBlacklist'); ?></strong></a></li>

                <li role="presentation"><a  href="<?php echo site_url('dispute/all-disputes'); ?>"><i class="fa fa-cubes"></i>&nbsp;<strong>Disputes</strong></a></li>

                <li role="presentation"><a  href="<?php echo site_url('orders/tracking_orders'); ?>"><i class="fa fa-cubes"></i>&nbsp;<strong><?php echo lang('lbl_tracking'); ?></strong></a></li>
            </ul>

        </div>

        <div class="col-md-10">
            <!--            <div class="clear10"></div>-->


            <form class="form-horizontal" name="searchMsg" id="searchMsg" method="get" action="<?php echo site_url('messages/' . $type) ?>">
                <div class="row msg_filter" >

                    <div class="col-md-2"> 
                        <button type="button" id="delete_thread" class="btn btn-danger" onclick="del_thread();"><i class="fa fa-trash-o" aria-hidden="true"></i>
                            &nbsp; Delete</button>

                    </div>

                    <div class="col-md-1" style="margin-top: 10px;">
                        <h4><b>Filter:</b></h4>
                    </div>

                    <div class="col-md-3">
                        <select name="msg_type" onchange="sel_tpe();" class="form-control">
                            <option selected>Type</option>
                            <option value="con" <?php echo ($_GET['msg_type'] == 'con') ? 'selected' : ''; ?>>conversations</option>
                            <option value="req" <?php echo ($_GET['msg_type'] == 'req') ? 'selected' : ''; ?> >Offers</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="msg_date" onchange="sel_date();"  class="form-control">
                            <option value="date" selected>From Date</option>
                            <option value="1" <?php echo ($_GET['msg_date'] == '1') ? 'selected' : ''; ?>>Last day</option>
                            <option value="5" <?php echo ($_GET['msg_date'] == '5') ? 'selected' : ''; ?>>Last 5 days</option>
                            <option value="10" <?php echo ($_GET['msg_date'] == '10') ? 'selected' : ''; ?>>Last 10 days</option>
                            <option value="15" <?php echo ($_GET['msg_date'] == '15') ? 'selected' : ''; ?>>Last 15 days</option>
                            <option value="30" <?php echo ($_GET['msg_date'] == '30') ? 'selected' : ''; ?>>Last 1 month</option>
                            <option value="60" <?php echo ($_GET['msg_date'] == '60') ? 'selected' : ''; ?>>Last 2 months</option>
                        </select>
                    </div>
                    <!--                    <div class="col-md-3">
                                            <input type="text" onblur="sub_search();" class="form-control" name="searchTxt" placeholder="Subject Search" value="<?php echo $searchTxt; ?>" />
                                        </div>-->
                    <div class="col-md-3">
                        <input type="text" onblur="name_search();" class="form-control" name="nameTxt"  placeholder="Name Search" value="<?php echo $nameTxt; ?>" />   </div>
                    <!--<div class="col-md-1"> <button type="submit"><?php echo lang('lbl_search'); ?></button></div>-->

                </div>
            </form>

            <div class="my-profile-bg tab-content">

                <div class="row">
                    <?php
                    if (count($all_inboxMessages) > 0) {
                        ?>
                        <form class="form-horizontal" id="delt_thrd" method="post" action="<?php echo site_url('messages/delete_thread') ?>">
                            <div class="col-md-5 converse_msg nopaddingright nopaddingleft" > 

                                <div class="table-responsive">

                                    <table id="dynamic-table" class="table table-bordered table-hover">
                                        <thead>
                                        <th>Status</th>
                                        <th>From</th>
                                        <th>Subject</th>
                                        <th>Type</th>
                                        <th>Date</th>
                                        </thead>
                                        <?php
                                        foreach ($all_inboxMessages as $row) {
                                            $dots = '';
                                            if (count(explode(' ', $row['message'])) > 15) {
                                                $dots = '...';
                                            }
                                            ?>

                                            <tr class="msg_user" onclick="show_Msg('<?php echo $this->common->encode($row['thread_id']); ?>')"  id="active_<?php echo $this->common->encode($row['thread_id']); ?>">

                                                <?php
                                                $is_read_msg = is_read_msg($row['thread_id'], $this->session->userdata('user_id'));

                                                $check = 0;
                                                foreach ($is_read_msg as $rr) {
                                                    if ($rr['is_read'] == 0) {
                                                        $check = 1;
                                                    }
                                                }
                                                ?>
                                                <td>

                                                    <input class="floatleft delet_thread" style="margin: 9px 10px 0 0;" type="checkbox" name="del_thread[]" value="<?php echo $row['thread_id']; ?>" />

                                                    <?php
                                                    if ($check == 1) {
                                                        echo '<span style="display:block;margin-top:5px;float:left;color:#d34836;"><i class="fa fa-envelope" aria-hidden="true"></i></span>';
                                                    } elseif ($check == 0) {
                                                        echo'<span style="display:block;margin-top:5px;float:left;color:#1fa67a;"><i class="fa fa-envelope-open" aria-hidden="true"></i></span>';
                                                    }
                                                    ?>

                                                </td>

                                                <td>
                                                    <strong class="pull-left"><a><?php echo $row['friend_name']; ?></a></strong>  
                                                </td>
                                                <td>
                                                    <?php echo $row['subject']; ?>  
                                                </td>


                                                <td>
                                                    <?php
                                                    $tim = getVal('created', 'c_messages', 'message_id', $row['max_id']);
                                                    $time11 = time();
                                                    $your_date = intval($tim);
                                                    $datediff = $time11 - $your_date;

                                                    if (floor($datediff / (60 * 60 * 24)) > 0) {
                                                        ?> <span>
                                                            <?php echo date('d/m/Y', intval($tim)); ?> 
                                                        </span>


                                                        <?php
                                                    } else {
                                                        $diff1 = $this->common->dateDiff($time11, intval($tim)) . " ago";
                                                        if (trim($diff1) == "ago") {
                                                            ?>  <span>
                                                                <?php echo lang('lbl_fewSecondAgo'); ?>
                                                            </span>


                                                            <?php
                                                        } else {
                                                            ?> 
                                                            <span>
                                                                <?php echo $diff1; ?>
                                                            </span>

                                                        </td>


                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </tr>
                                        <?php }
                                        ?>

                                    </table>
                                </div>
                                <div class="clear10"></div>                                
                            </div>
                        </form>


                        <div class="col-md-7 msg_div nopaddingleft nopaddingright" >
                            <div id="showMsg"></div>

                        </div>
                        <?php
                    } else {

                        echo' <div class="clear10"></div> <div class="alert alert-danger col-md-10" style="margin-left: 25px;"><b>' . lang('lbl_no_record') . '</b> </div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

                                                function sel_tpe() {
                                                    $('#searchMsg').submit();
                                                }
                                                function sel_date() {
                                                    $('#searchMsg').submit();
                                                }
                                                function name_search() {
                                                    $('#searchMsg').submit();
                                                }

                                                function del_thread() {
                                                    if ($('.delet_thread').is(':checked')) {
                                                        $('#delt_thrd').submit();
                                                    } else {
                                                        alert('please Select threads to delete..');
                                                    }
                                                }

                                                jQuery(function () {
                                                    $('#dynamic-table').dataTable({
                                                        "bPaginate": false,
                                                        "bFilter": false,
                                                        "bInfo": false,
                                                        "aoColumns": [
                                                            {"bSortable": false},
                                                            {"bSortable": true},
                                                            {"bSortable": true},
                                                            {"bSortable": false},
                                                            {"bSortable": true}
                                                        ],
                                                        "aaSorting": [],

                                                    });
                                                });


                                                function show_Msg(tId) {
                                                 
                                                    URL = BASE_URL + 'messages/detail/' + tId;
                                                    $.ajax({
                                                        type: "POST",
                                                        url: URL,
                                                        data: {'threadId': tId},
                                                        success: function (data) {
                                                          
                                                               $('#showMsg').html(data);
                                                            $('#active_' + tId + ' td span i').removeClass('fa-envelope');
                                                            $('#active_' + tId + ' td span i').addClass('fa-envelope-open');
                                                           
                                                            $('.msg_user').removeClass('active');
                                                            $('#active_' + tId).addClass('active');
                                                          


                                                        }
                                                    });

                                                }

<?php /*if (count($all_inboxMessages) > 0) { ?>

                                                    var tId = '<?php echo $this->common->encode($all_inboxMessages[0]['thread_id']); ?>';

                                                    URL = BASE_URL + 'messages/detail/' + tId;
                                                    $.ajax({
                                                        type: "POST",
                                                        url: URL,
                                                        data: {'threadId': tId},
                                                        success: function (data) {

                                                            $('#showMsg').html(data);
                                                            $('.msg_user').removeClass('active');
                                                            $('#active_' + tId).addClass('active');

                                                        }
                                                    });

<?php }  */ ?>


</script>



