
        <section class="becomeahost">
            <div class="container">
                <h1>Contact Us</h1>
            </div>
        </section>
        <section class="becomeahost-content contact-form-mar">
            <div class="container">
                <div class="col-md-6 col-sm-6 col-xs-12" id="map1" style="height:525px;">
              <!--   <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d27225.338749113325!2d74.25945266773917!3d31.464582508824225!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3919015f82b0b86f%3A0x2fcaf9fdeb3d02e6!2sJohar+Town%2C+Lahore%2C+Pakistan!5e0!3m2!1sen!2s!4v1516358658533" width="100%" height="525" frameborder="0" style="border:0" allowfullscreen=""></iframe> -->
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12 form-contact">
                    <div class="title">
                     <h2>Contact Us</h2>
                </div>
                    <div class="form-container">
                       
                        <form class="signup-form" id="commentForm" action="<?php echo site_url('home/formsubmit'); ?>" method="post" class="form" role="form">
                            <div class="row">
                                <div class="col-xs-6 col-md-6">
                                <div class="form-group">    
                                      <input class="form-control" name="name" placeholder="First Name" type="text" required autofocus />
                                </div>   
                                  </div>
                                <div class="col-xs-6 col-md-6">
                                    <div class="form-group">  
                                        <input class="form-control" name="lastname" placeholder="Last Name" type="text" required />
                                    </div>  
                                </div>
                            </div>
                            <div class="form-group">
                                <input class="form-control" name="email" placeholder="Email" type="email" required />
                            </div>
                            <div class="form-group">
                                <input class="form-control" name="number" placeholder="Contact Number" type="number" min="0" required />
                            </div>
                            <div class="form-group">
                                 <textarea class="form-control" id="" cols="30" rows="10" name="message" required ></textarea>
                            </div>
                            <div class="form-group">
                                <button class="custom-btn" type="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
      
       <script type="text/javascript" src="https://maps.google.com/maps/api/js?key=<?php echo GOOGLE_MAP_KEY; ?>"></script>


<script>

                                var lats = '<?php echo LAT; ?>';
                                var lons = '<?php echo LONG; ?>';

                                var myCenter = new google.maps.LatLng(lats, lons);

                                function initialize()
                                {
                                    var mapProp = {
                                        center: myCenter,
                                        zoom: 14, scrollwheel: false,
                                        mapTypeId: google.maps.MapTypeId.ROADMAP
                                    };

                                    var maps = new google.maps.Map(document.getElementById("map1"), mapProp);

                                    var marker = new google.maps.Marker({
                                        position: myCenter,
                                        'draggable': false,
                                        animation: google.maps.Animation.DROP,
                                        title: ""
                                    });

                                    marker.setMap(maps);

                                    var infowindow = new google.maps.InfoWindow({
                                        content: "<?php echo CONTACTUS_ADDRESS; ?>"

                                    });
                                    marker.addListener('click', function () {
                                        infowindow.open(maps, marker);
                                    });
                                    infowindow.open(maps, marker);
                                }

                                google.maps.event.addDomListener(window, 'load', initialize);


</script>
