<section id="main" >
    <div class="section listing-single-wrap2" style="padding-bottom: 0px; ">
      <div class="container">
        <div class="row">
          <div class="col-md-8">
          
          <!------SINGLE RESIDENCE---------->
            <div class="listing-single cst-listing">
              <div class="listing-single__header">
              	<!--TITLE -->
                <h1 class="listing-single__title"><?php echo ucwords($detail->name); ?></h1>
                <!--RESIODENCE META-->
                <div class="cst-wrap">
                <div class="listing-single__meta col-md-12">
                  <div class="listing-single__date"> <span class="listing-single__label">Posted on: <span class="date-cst"><?php echo date("F j, Y, g:i a" , strtotime($detail->date_created)); ?> </span>  </span></div>
                               
                </div>
                
                <!--RESIODENCE ACTIONS-->
                <div class="listing-single__actions">
              <div class="listing-single__date "> <h3 class="text-right" style="padding: 0 15px;">$<?php echo $detail->perday_price; ?> </h3> </div>
                </div>
              </div>
              </div>
              <!--RESIDENCE IMAGE-->
              <div class="listing-single__media slider-cst">
               

 <ul id="imageGallery">
      <?php 
      $images = explode(',', $detail->default_image);
      $i = 0;
      foreach ($images as $key => $value): ?>
     
       <li data-thumb="<?php echo base_url($value); ?>" data-src="<?php echo base_url($value); ?>">
    <img src="<?php echo base_url($value); ?>">
  </li>

    <?php $i++; endforeach; ?>
</ul>

               </div>
              
              <!--RESIDENCE DESCRIPTION / REVIEW TABS-->
              <div class="tab--2 listing-single__tab">
                <ul class="nav nav-tabs">
                  <li class="active"><a href="#tab-descriptions" data-toggle="tab"> Description</a></li>
                 <!--  <li><a href="#tab-review" data-toggle="tab">Review &amp; Rating</a></li> -->
                </ul>
                
                <div class="tab-content">
                <!--RESIDENCE DESCRIPTION TAB-->
                  <div class="tab-pane active" id="tab-descriptions">
                    <div class="listing-single__content">
                      <p><?php echo $detail->description; ?></p>
                    
                      
                       <!--RESIDENCE FEATURES LIST-->
                      <h3 style="font-size: 24px; margin-bottom: 0;">Featured List</h3>
                      <br>
                      <ul class="wil-icon-list">
                        <?php foreach ($speciality as $value): ?>
                         <?php if (in_array($value->id, explode(',', $detail->speciality)))
                          {
                         $iicalass =  "icon_box-checked";
                         $dis = '';
                          }else{
                            $iicalass =  "icon_close_alt2";
                              $dis = 'disable';
                          }

                           ?>
                        <li class="<?php echo $dis; ?>" ><i class="<?php echo $iicalass; ?>"></i> <?php echo ucwords($value->name); ?></li>
                  
                         <?php endforeach; ?>
                      </ul>
                    </div>
                  </div>
                   <!--END OF RESIDENCE DESCRIPTION TAB-->
                   
                  <!--RESIDENCE REVIEW / RATING TAB--> 
                  <div class="tab-pane" id="tab-review">
                    <div id="comments" class="comments">
                      <div class="comments__header">
                        <h4 class="comment__title"> 02 Comments <a href="#" class="comments__header-create listgo-btn--round">Write A Comment</a> </h4>
                        <select class="comments__header-order">
                          <option>New Date</option>
                          <option>Top Comments</option>
                        </select>
                      </div>
                      <!--REVIEWS-->
                      <ul class="review-rating">
                        <li class="review-rating__label"> <span class="review-rating__star"> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star-o"></i> </span> <span class="review-rating__label-title">100 Rating</span> </li>
                        <li class="review-rating__item"> <span class="review-rating__star"> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> </span>
                          <div class="review-rating__bar">
                            <div class="review-rating__bar-percent" style="width: 70%"></div>
                          </div>
                        </li>
                        <li class="review-rating__item"> <span class="review-rating__star"> <i class="fa fa-star-o"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> </span>
                          <div class="review-rating__bar">
                            <div class="review-rating__bar-percent" style="width: 20%"></div>
                          </div>
                        </li>
                        <li class="review-rating__item"> <span class="review-rating__star"> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> </span>
                          <div class="review-rating__bar">
                            <div class="review-rating__bar-percent" style="width: 10%"></div>
                          </div>
                        </li>
                        <li class="review-rating__item"> <span class="review-rating__star"> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> </span>
                          <div class="review-rating__bar">
                            <div class="review-rating__bar-percent" style="width: 15%"></div>
                          </div>
                        </li>
                        <li class="review-rating__item"> <span class="review-rating__star"> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star-o"></i> <i class="fa fa-star"></i> </span>
                          <div class="review-rating__bar">
                            <div class="review-rating__bar-percent" style="width: 5%"></div>
                          </div>
                        </li>
                      </ul>
                      
                      <!--COMMENTS-->
                      <ol class="commentlist">
                        <li class="comment">
                          <div class="comment__inner">
                            <div class="comment__avatar"> <img src="<?php getImage($this->session->userdata['photo']); ?>" alt=""> <span class="member-item__role role--admin"> <i class="fa fa-gitlab"></i>Administrator </span> </div>
                            <div class="comment__body"> <cite class="comment__title">Wayne Stone</cite> <span class="comment__rated"> <span class="selected"> <a class="fa fa-star-o"></a> <a class="fa fa-star-o"></a> <a class="fa fa-star-o active"></a> <a class="fa fa-star-o"></a> <a class="fa fa-star-o"></a> </span> </span> <span class="comment__date">Jun 7, 2015</span>
                              <div class="comment__content"> Nunc ac convallis magna. Sed quam nisi, pretium eu tristique sed, lobortis ac augue. In non lectus blandit, vehicula ligula faucibus, accumsan lectus. Integer dapibus risus vel sodales hendrerit. Morbi eu odio sit amet lectus vestibulum scelerisque.
                                
                              </div>
                              <span class="comment__edit-reply"> <a rel="nofollow" class="comment-reply-link" href="#">Reply</a> <a class="comment-edit-link" href="#">Edit</a> <a href="#" class="comment-like active"> <i class="icon_like"></i><span class="comment-like__count">20</span> </a> </span> </div>
                          </div>
                        </li>
                      </ol>
                      
                      <!--WRITE NEW COMMENT-->
                      <a href="#" class="comments__showmore"> Show More <span class="comments__showmore-loading"><span></span></span> </a> </div>
                    <div id="comment-respond" class="comment-respond">
                      <h3 class="comment-reply-title">Leave your comment</h3>
                      <div class="row">
                        <form action="#" class="comment-form">
                          <p class="col-sm-6">
                            <label>Name <sup>*</sup></label>
                            <input type="text" required aria-required="true">
                          </p>
                          <p class="col-sm-6">
                            <label>Email <sup>*</sup></label>
                            <input type="text" required aria-required="true">
                          </p>
                          <p class="col-sm-12">
                            <label>Your Rating</label>
                            <span class="comment__rate"> <span> <a class="fa fa-star-o"></a> <a class="fa fa-star-o"></a> <a class="fa fa-star-o"></a> <a class="fa fa-star-o"></a> <a class="fa fa-star-o"></a> </span> </span> </p>
                          <p class="col-sm-12">
                            <label>Comment</label>
                            <textarea rows="5" cols="10"></textarea>
                          </p>
                          
                          <p class="col-sm-12">
                            <input class="listgo-btn--round" type="submit" value="Submit">
                            <span class="review_status error-msg">Please fill Title, Description and Rating</span> </p>
                        </form>
                      </div>
                    </div>
                  </div>
                  
                   <!--END OF RESIDENCE REVIEW / RATING TAB--> 
                </div>
              </div>
              <!--END OF TABS-->
              <?php if($this->session->userdata('user_role') == 2 && $this->session->userdata('user_id') == $detail->id){ ?>
              <div class="listing-single-actions"> 
              <a href="<?php echo site_url('user/addresident'); ?>" class="listgo-btn listgo-btn--round listgo-btn--sm btn-primary"><i class="fa fa-plus"></i><span>Add Residence</span></a> 
              <a href="<?php echo site_url('user/editresident/'.$detail->residence_id); ?>" class="listgo-btn listgo-btn--sm listgo-btn--round"><i class="fa fa-pencil"></i><span>Edit Residence</span></a>
              <a href="javascript:void(0);" onclick="delres('<?php echo site_url('user/delete_residence/'.$detail->residence_id); ?>');" class="listgo-btn listgo-btn--sm listgo-btn--round"><i class="fa fa-trash-o "></i><span>Delete Residence</span></a>
               </div>
               <?php } ?>
            </div>

          <!------END OF SINGLE RESIDENCE---------->  
          </div>
          
          
          <div class="col-md-4">
            <div class="sidebar-background sidebar-background--light">
            <!------RESIDENT DETAIL---------->
              <div class="widget widget_author">
                <div class="widget_author__header">
                <!---AVATAR -->
                  <div class="widget_author__avatar"><a href="<?php echo site_url('resident').'/'.$this->common->encode($detail->id); ?>"> <img src="<?php getImage($detail->photo); ?>" alt="">  </a></div>
                  <div class="overflow-hidden">
                    <h4 class="widget_author__name"><?php echo $detail->user_name; ?></h4>
                    <span class="widget_author__role role--admin"> <i class="fa fa-gitlab"></i> Resident </span> </div>
                </div>
                <div class="widget_author__content">
                  <ul class="widget_author__address">
                    <li> <i class="fa fa-map-marker"></i> <?php echo $detail->addrs; ?></li>
                    <li> <i class="fa fa-phone"></i> <?php echo $detail->telephone; ?> </li>
                 <!--    <li> <i class="fa fa-envelope"></i> <a href="http://xgio.net/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="a6cacfd5d288c1c9e6c1cbc7cfca88c5c9cb">[email&#160;protected]</a> </li> -->
                  </ul>
               <!--    <div class="widget_author__social"> <a href="#"><i class="fa fa-facebook"></i></a> <a href="#"><i class="fa fa-twitter"></i></a> <a href="#"><i class="fa fa-tumblr"></i></a> <a href="#"><i class="fa fa-dribbble"></i></a> <a href="#"><i class="fa fa-youtube-play"></i></a> </div> -->
  
    <?php if($this->session->userdata('user_role') != '2'): ?>
      <form action="<?php echo site_url('cart/add_to_cart'); ?>" method="post">
                <input type="hidden" name="id" value="<?php echo $detail->residence_id; ?>">
                  <div class="widget_author__link"> <button type="submit">Book Now</button> </div>
                  </form>
                </div>
              </div>
              
              <?php endif; ?>
              
              <div class="widget widget_author_calendar">
                <h4 class="widget_title"> <i class="icon_clock_alt"></i> Available Timing</h4>
                <div class="widget_author-calendar">
                  <ul>
                     <?php  
                    $dayss = explode(',', $detail->dateofvisit);
                    $timeto = explode(',', $detail->totimeofvisit);
                    $timefrom = explode(',', $detail->fromtimeofvisit);

                     $days = array();
    for ($i = 0; $i < 7; $i++) {
        $days[$i] = jddayofweek($i,1);
    }
      foreach ($days as $key => $valu) {
      if(in_array($key, $dayss)){
        $dyaexist = 'time';
      }else{
         $dyaexist = 'time time--close';
      }
     ?>
                    <li> <span class="day"><?php echo $valu; ?></span> <span class="time"><?php echo ($dyaexist == 'time')?$timefrom[$key].' - '.$timeto[$key]:'Closed'; ?></span> </li>
                  <?php } ?>
                  
                  </ul>
                </div>
              </div>
              <?php if($this->session->userdata('user_role') == 1){ ?>
            <div class="message-ex widget_author__link">
            <a href="javascript:void(0)">Send Message  <i class="fa fa-envelope" aria-hidden="true"></i></a>
            </div>
            <?php } ?>
            <div class="form widget_author__link message-cst">
                            <form action="#" id="messageForm" >
                              <input type="hidden" name="to_user_id" value="<?php echo $detail->id; ?>">
                              <input type="hidden" name="from_user_id" value="<?php echo $this->session->userdata('user_id'); ?>">
                                <div class="clearfix"></div>
                               <!--  <div class="form-group">
                                    <label for="sub" class="">Subject:</label>  -->
                                    <input type="hidden" name="subject"  id="ss" class="form-control" placeholder="Subject" value="123" required>
                               <!--  </div> -->
                                <div class="form-group">
                                <label for="message" class="">Message:</label>
                                  <textarea class="form-control" name="message" id="mm" cols="30" rows="10" placeholder="Message" required></textarea>
                                </div>
                                    <button type="button" onclick="sendmsg();">Send <i class="fa fa-share-square" aria-hidden="true"></i></button>
                            </form>
                    </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
<!-- BUTTON BACK TO TOP-->
<div class="map-block">
        <div class="map-info">
          <h3 class="title-style-2">Contact Us</h3>
          <p class="address"> <i class="fa fa-map-marker"></i><?php echo $detail->addrs; ?></p>
          <div class="footer-block"> <a href="https://maps.google.com?ll=<?php echo $detail->latitude; ?>,<?php echo $detail->longitude; ?>&q=restaurant@" class="btn btn-open-map" target="_blank">Open Map</a> </div>
        </div>
         <div id="map"></div>
      </div>

     
<script>


      var map;
      var infowindow;

      function initMap() {
         var pyrmont = {lat: <?php echo $detail->latitude; ?>, lng: <?php echo $detail->longitude; ?>};

        map = new google.maps.Map(document.getElementById('map'), {
          center: pyrmont,
          zoom: 15
        });

        infowindow = new google.maps.InfoWindow();
        var service = new google.maps.places.PlacesService(map);
        service.nearbySearch({
          location: pyrmont,
          radius: 500,
          type: ['restaurant']
        }, callback);
      }

      function callback(results, status) {

        if (status === google.maps.places.PlacesServiceStatus.OK) {
          for (var i = 0; i < results.length; i++) {
            createMarker(results[i]);
          }
        }
      }

      function createMarker(place) {

        var placeLoc = place.geometry.location;
        var marker = new google.maps.Marker({
          map: map,
          position: place.geometry.location
        });

        google.maps.event.addListener(marker, 'click', function() {
          infowindow.setContent(place.name);
          infowindow.open(map, this);
        });
      }
    </script>


    <script src="https://maps.googleapis.com/maps/api/js?key=<?php echo GOOGLE_MAP_KEY; ?>&libraries=places&callback=initMap" async defer></script>

    <script type="text/javascript">
       $(document).ready(function() {
    $('#imageGallery').lightSlider({
        gallery:true,
        item:1,
        loop:true,
        thumbItem:5,
        slideMargin:0,
        enableDrag: false,
        currentPagerPosition:'left',
        onSliderLoad: function(el) {

        }   
    });  
  });
  $( ".message-ex a" ).click(function() {
  $( ".message-cst" ).slideToggle( "slow", function() {
  });
});
    </script>

    <script type="text/javascript">
      
        function sendmsg(){
         var validator = $( "#messageForm" ).validate();
          if($("#messageForm").valid()){
               $.ajax({
        type: "POST",
        url: '<?php echo site_url('messages/send_message') ?>',
        data: $( "#messageForm" ).serialize(),
        dataType: "html",
        success: function (response) {
          var msg = 'Message Sent SuccessFully';         
           swal(msg, "", "success");
          $('#ss').val('');
          $('#mm').val('');

        },
        error: function () {

            alert(ajax_alert);

        }

    });
          }else{
            return false;
          }
 }

    </script>
    <script type="text/javascript">
      function delres(url){
        swal({
  title: "Are you sure?",
  text: "Once deleted, you will not be able to recover this Residence",
  icon: "warning",
  buttons: true,
  dangerMode: true,
}).then((willDelete) => {
  if (willDelete) {
    location = url;
  } else {
    swal("Residence Not Deleted..!");
    $('.swal-button--confirm').click();
  }
});

      }
    </script>