<?php  $userdata = $this->session->userdata(); ?> 
<?php $this->load->view('user/user_header' , $userdata); ?>

<!----------END OF INTRO BANNER---------->

<!------Visitors Dashboard-------->


  <div class="container">
    <div class="tab-content">
    <!-----------PROFILE TAB---------->
      <div id="profile" class="tab-pane fade in <?php echo isset($_GET['tab'])?'':'active'; ?>">
        <h2 class="author-page__title"> <i class="icon_id"></i> Profile <span><a href="javascript:void(0)" data-toggle="modal" data-target="#myModal"><i class="fa fa-pencil" ></i> </a></span></h2>
        <div class="row">
        <div class="col-md-4 col-sm-6 animated fadeInLeft">
            <div class="sidebar-background sidebar-background--light">
              <div class="widget widget_author">
                <div class="widget_author__header">
                  <div class="widget_author__avatar"> <img src="<?php echo getImage($userdata['photo']); ?>" alt=""> </div>
                  <div class="overflow-hidden">
                    <h4 class="widget_author__name"><?php echo $userdata['user_name']; ?></h4>
                   </div>
                </div>
                <div class="widget_author__content">
                  <ul class="widget_author__address">
                    <?php if(!empty($userdata['address'])): ?>
                    <li> <i class="fa fa-map-marker"></i><?php echo $userdata['address']; ?> </li>
                  <?php endif;

                  if(!empty($userdata['telephone'])):  ?>
                    <li> <i class="fa fa-phone"></i><?php echo $userdata['telephone']; ?> </li>
                  <?php endif; ?>
                   <!--  <li> <i class="fa fa-map-marker"></i> wiloke.net </li>
                    <li> <i class="fa fa-map-marker"></i> <a href="http://xgio.net/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="402c2933346e272f00272d21292c6e232f2d">[email&#160;protected]</a> </li> -->
                  </ul>
                 <!--  <div class="widget_author__social"> <a href="#"><i class="fa fa-facebook"></i></a> <a href="#"><i class="fa fa-twitter"></i></a> <a href="#"><i class="fa fa-tumblr"></i></a> <a href="#"><i class="fa fa-dribbble"></i></a> <a href="#"><i class="fa fa-youtube-play"></i></a> </div> -->
                </div>
              </div>
            </div>
          </div>
          
          <div class="col-md-8 col-sm-6  animated fadeInRight">
            <div class="account-page">
              <p><?php echo $userdata['description_user']; ?></p>
            </div>
          </div>
          
        </div>
      </div>
    <!-----------END OF PROFILE TAB---------->
      
      <!-----------LISTING TAB---------->
      <div id="listing" class="tab-pane fade"> 
        <h2 class="author-page__title"> <i class="fa fa-list-ul"></i> Residence Listing </h2>
      <div class="row">
   <?php
   if(!empty($listing)):
  
    $i = 0;
    $payment = array();
    foreach ($listing as $value): 
    
    $image = explode(',', $value->default_image);

   ?>
    
      <div class="col-sm-4">
        <div class="listing listing--grid animated fadeInUp">
          <div class="listing__media"> <a href="<?php echo site_url('residence').'/'.$this->common->encode($value->residence_id); ?>"> <img src="<?php echo base_url($image[0]); ?>" alt=""> </a>
          </div>
          <div class="listing__body">
            <h3 class="listing__title"><a href="<?php echo site_url('residence').'/'.$this->common->encode($value->residence_id); ?>"><?php echo $value->name; ?></a></h3>
          <!--   <div class="listgo__rating"> <span class="rating__number">4.0</span> <span class="rating__star"> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star-o"></i> </span> </div> -->
            <div class="listing__content">
              <address>
              <span><i class="fa fa-map-marker"></i></span> <?php echo $value->address; ?><br>
              <span><i class="fa fa-phone"></i></span> <?php echo $value->telephone; ?>
              </address>
            </div>
            <div class="item__actions">
              <div class="tb">
                <div class="tb__cell cell-large"> <a href="<?php echo site_url('residence').'/'.$this->common->encode($value->residence_id); ?>">View detail</a> </div>
                
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php
  
     endforeach; 


     if ($userdata['user_role'] == 1) {
      $pays = getvisitorPayment($userdata['user_id']);
     if(!empty($pays)){

      $payment = $pays;
        $i++;
     }
    }

    if($userdata['user_role'] == 2){

     $pays = getResidentPayment($userdata['user_id']);
     if(!empty($pays)){

      $payment = $pays;
        $i++;
     }
    }

    ?>
  <?php else: ?>
<style type="text/css">.tab-content>.active {
    display: block;
    background: #fff;
        padding-bottom: 20px;
}</style>
   <div class=" col-md-12" style="margin-left: 25px;margin-top:15px; text-align: center;"><h3>No Record Found!</h3>
    </div>
  <?php endif; ?>
    </div>
      
      </div>
      <!-----------END OF LISTING TAB---------->
      
      <!-----------MESSAGES TABE---------->
      <div id="msg" class="tab-pane fade custom-pro  <?php echo isset($_GET['tab'])?'active':''; ?>"> 
      <h2 class="author-page__title"> <i class="fa  fa-comment-o"></i> My Messages</h2>
           <div class="my-profile-bg tab-content">

                <div class="row">
                    <?php
                    if (count($all_inboxMessages) > 0) {
                        ?>
                        <form class="form-horizontal col-md-3 " id="delt_thrd" method="post" action="<?php echo site_url('messages/delete_thread') ?>">
                            <div class="col-md-12 cs-pd-0 converse_msg nopaddingright nopaddingleft" > 
                                        <?php
                                        foreach ($all_inboxMessages as $row) {

                                            $dots = '';
                                            if (count(explode(' ', $row['message'])) > 15) {
                                                $dots = '...';
                                            }
                                            ?>

                                            <div class="col-md-12 cs-pd-0">
                                                <div class="profile-listed" onclick="show_Msg('<?php echo $this->common->encode($row['thread_id']); ?>')" id="ac<?php echo $this->common->encode($row['thread_id']); ?>">
                                              <span class="img-profile">
                                              <img src="<?php echo getImage($row['friend_photo']); ?>" class="img-circle-small">
                                             </span>
                                             <div class="msg-media-body">
                                                    <strong class="name"  ><a><?php echo $row['friend_name']; ?></a></strong>  
                                           
                                                    <?php
                                                    $tim = getVal('created', 'c_messages', 'message_id', $row['max_id']);
                                                    $time11 = time();
                                                    $your_date = intval($tim);
                                                    $datediff = $time11 - $your_date;

                                                    if (floor($datediff / (60 * 60 * 24)) > 0) {
                                                        ?> 
                                                        <span class="time">
                                                            <?php echo date('d/m/Y', intval($tim)); ?> 
                                                        </span>


                                                        <?php
                                                    } else {
                                                        $diff1 = $this->common->dateDiff($time11, intval($tim)) . " ago";
                                                        if (trim($diff1) == "ago") {
                                                            ?>  <span class="time">
                                                                <?php echo 'few seconds ago'; ?>
                                                            </span>


                                                            <?php
                                                        } else {
                                                            ?> 
                                                            <span class="time">
                                                                <?php echo $diff1; ?>
                                                            </span>

                                                       


                                                        <?php
                                                    }
                                                }
                                                ?>
                                           
                                                </div>
                                                </div>
                                      </div>

                                        <?php }
                                        ?>
                                        
                                </div>
                                <div class="clear10"></div>                                
                            
                    
                        <div class="col-md-9  nopaddingright" >
                            <div class="msg_div nopaddingleft">  
                          
                          
                             </div>
                        </div>
                        <?php
                    } else {

                        echo '<div class=" col-md-12" style="margin-left: 25px;margin-top:15px; text-align: center;"><h3>No Record Found!</h3></div>';
                    }
                    ?>
                </div>
            </div>
      
      </div>
      <!-----------END OF MESSAGES TAB---------->
      
      <!-----------PAYMENT HISTORY TAB---------->
      <div id="p-history" class="tab-pane fade woocommerce bg-white">
      <h2 class="author-page__title"> <i class="icon_creditcard"></i> Payment History</h2>
        <div class="wo_shop animated fadeIn">
        <div class="table-responsive cst-table">  
          <table class="shop_table cart table">
            <thead>
              <tr>
                <th class="price-date">Date</th>
                <th class="price-amount">Amount</th>
                <th class="prce-desc">Description</th>
                <th class="price-status">Status</th>
              <!--   <th class="price-action" style="width:200px;">Actions</th> -->
              </tr>
            </thead>
            <?php 

            if($payment != ''){
              foreach ($payment as $pay) {

             ?>
            <tr class="cart_item">
             <!--  <td><input type="checkbox" value=""></td> -->
              <td> <?php echo date("jS F, Y", strtotime($pay['created_at'])); ?> </td>
              <td class="product-price"><span class="amount"><span>$</span><?php echo $pay['paid']; ?></span></td>
              <td><?php echo $pay['addd']; ?> </td>
              <td><div class="success-msg"><?php echo $pay['status']; ?></div></td>
              <!-- <td><a class="btn btn-info"><i class="fa fa-file"></i></a> <a class="btn btn-warning"><i class="fa fa-eye"></i></a> <a class="btn btn-danger"><i class="fa fa-trash-o"></i></a></td> -->
            </tr>
           <?php } 
           }else{  ?>
 <tr class="cart_item">
  <td colspan="4" style="text-align:center;"><h3>No Payment History Found!</h3></td>
 </tr>
           <?php } ?>
            <tr>
            <!--   <td colspan="6" class="actions"><div class="coupon">
                  <label for="coupon_code">Coupon:</label>
                  <input type="text" name="coupon_code" class="input-text" value="" placeholder="Coupon code">
                  <input type="submit" class="button" name="apply_coupon" value="Apply Coupon">
                </div>
                <input type="submit" class="button" name="update_cart" value="Update History" disabled=""></td> -->
            </tr>
          </table>
          </div>
        </div>
      </div>
      <!-- END OF PAYMENT HISTORY TAB -->
    </div>

    <div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <h3 class="form-heading-edit">Profile Edit</h3>
      <div class="modal-body">
        <form class="signup-form" action="<?php echo site_url('user/update_profile') ?>" method="post" enctype="multipart/form-data">
         
         <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" name="user_name" id="name" value="<?php echo $userdata['user_name']; ?>" class="name">
            <span class="error"></span>
        </div>
           <div class="form-group">
            <label for="name">Address</label>
            <input type="text" name="address" value="<?php echo $userdata['address']; ?>" id="Address" class="Address" required>
            <span class="error"></span>
        </div>

           <div class="form-group">
            <label for="name">Country or Nationality</label>
           <input type="text" value="<?php echo $userdata['country_or_nationality']; ?>"  placeholder="Country or nationality" name="country_or_nationality" required>
            <span class="error"></span>
        </div>
       

                   
           <div class="form-group">
            <label for="name">Phone No</label>
            <input type="text" name="telephone" id="telephone" class="telephone" value="<?php echo $userdata['telephone']; ?>" required>
            <span class="error"></span>
        </div>
           <div class="form-group">
            <label for="name">Race</label>
            <input type="text" name="race" id="race" value="<?php echo $userdata['race']; ?>" class="race">
            <span class="error"></span>
        </div>

          <div class="form-group">
            <label for="name">Religion</label>
            <input type="text" name="religion" value="<?php echo $userdata['religion']; ?>" id="religion" class="religion">
            <span class="error"></span>
        </div>
          <div class="form-group">
            <label for="name">Description</label>
            <textarea  name="description_user"  id="description_user" class="religion"><?php echo $userdata['description_user']; ?> </textarea>
            <span class="error"></span>
        </div>

         <div class="form-group">
            <label for="name">Profile Image</label>
            <input type="file" name="photo" value="" accept="image/*" >
            <span class="error"></span>
        </div>
        <div class="CTA">

            <button class="custom-btn" type="submit" >Update</button>
            <button type="button" class="custom-btn cancel-btn" data-dismiss="modal">Close</button>

        </div>
         </form>
      </div>
   
    </div>

  </div>
</div>
  </div>
</section>
<script type="text/javascript">


  $('#address').keyup(function(e){
  if(e.which == 13)
    {
alert('enter pressed'); 
}
}); 


</script>


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

                                             


                                                function show_Msg(tId) {

                                                    URL = BASE_URL + 'messages/detail/' + tId;
                                                    $.ajax({
                                                        type: "POST",
                                                        url: URL,
                                                        data: {'threadId': tId},
                                                        success: function (data) {

                                                            $('#showMsg').html(data);
                                                            $(".profile-listed").removeClass('active');
                                                            $('#ac'+tId).addClass('active');
                                                            $('.msg_user').removeClass('active');
                                                            $('#active_' + tId).addClass('active');
                                                               $('#message_data').scrollTop($('#message_data').height());
                                                                $('#active_' + tId + ' td span i').removeClass('fa-envelope');
                                                            $('#active_' + tId + ' td span i').addClass('fa-envelope-open');
                                                            $('#active_' + tId + ' td span').css('color', '#1fa67a');
                                                             setInterval(function(){ 
                                                              show_Msg2(tId);
                                                             }, 30000);

                                                        }
                                                    });

                                                }


                                                function show_Msg2(tId) {

                                                    URL = BASE_URL + 'messages/detailAjax/' + tId;
                                                    $.ajax({
                                                        type: "POST",
                                                        url: URL,
                                                        data: {'threadId': tId},
                                                        success: function (data) {

                                                            $('#message_data').html(data);
                                                            $(".profile-listed").removeClass('active');
                                                            $('#ac'+tId).addClass('active');
                                                            $('.msg_user').removeClass('active');
                                                            $('#active_' + tId).addClass('active');
                                                               $('#message_data').scrollTop($('#message_data').height());
                                                                $('#active_' + tId + ' td span i').removeClass('fa-envelope');
                                                            $('#active_' + tId + ' td span i').addClass('fa-envelope-open');
                                                            $('#active_' + tId + ' td span').css('color', '#1fa67a');
                                                             setInterval(function(){ 
                                                              show_Msg2(tId);
                                                             }, 30000);

                                                        }
                                                    });

                                                }

                                                

<?php  if (count($all_inboxMessages) > 0) { ?>

                                                    var tId = '<?php echo $this->common->encode($all_inboxMessages[0]['thread_id']); ?>';

                                                    URL = BASE_URL + 'messages/detail/' + tId;
                                                    $.ajax({
                                                        type: "POST",
                                                        url: URL,
                                                        data: {'threadId': tId},
                                                        success: function (data) {
                                                          
                                                            $('#showMsg').html(data);
                                                             $(".profile-listed").removeClass('active');
                                                            $('#ac'+tId).addClass('active');
                                                            $('.msg_user').removeClass('active');
                                                            $('#active_' + tId).addClass('active');
                                                          setInterval(function(){ 
                                                              show_Msg2(tId);
                                                             }, 25000);
                                                        }
                                                    });

<?php }   ?>
 

</script>