      <section id="bg-img-2">

            <div class="container">

                <div class="col-md-3 col-sm-6">

                    <div class="about-2">

                        <img src="<?php echo base_url('assets/site'); ?>/images/icons/About-2.png">

                        <p><?php echo FOO_DESCRIPTION; ?></p>

                    </div>

                </div>

                <div class="col-md-3 col-sm-6">

                    <div class="links">

                        <h2>User Help</h2>

                        <ul>

                            <?php $cms = get_pages_footer(20 , 1);

                            $i = 0;

                                foreach ($cms as $key => $value) {

                                    $i++;



                             ?>

                            <li><a href="<?php echo site_url('cms/'.$value['slug']); ?>"><i class="fa fa-angle-double-right" aria-hidden="true"></i><?php echo $value['title']; ?></a>

                            </li>

                           <?php } ?>

                        </ul>

                    </div>

                </div>

                <div class="col-md-3 col-sm-6">

                    <div class="links">

                        <h2>Quick Links</h2>

                        <ul>

                            <?php $cms = get_pages_footer(20 , 0);

                            $i = 0;

                                foreach ($cms as $key => $value) {

                                    $i++;



                             ?>

                            <li><a href="<?php echo site_url('cms/'.$value['slug']); ?>"><i class="fa fa-angle-double-right" aria-hidden="true"></i><?php echo $value['title']; ?></a>

                            </li>

                           <?php } ?>

                        </ul>

                    </div>

                </div>

                <div class="col-md-3 col-sm-6">

                    <div class="links">

                        <h2>Contact Info</h2>

                        <div class="contact">

                            <span><img src="<?php echo base_url('assets/site'); ?>/images/icons/map.png"></span>

                            <h3><?php echo ADMIN_ADDRESS; ?></h3>

                        </div>

                        <div class="contact">

                            <span><img src="<?php echo base_url('assets/site'); ?>/images/icons/phone.png"></span>

                            <h3><?php echo ADMIN_PHONE; ?></h3>

                        </div>

                        <div class="contact">

                            <span><img src="<?php echo base_url('assets/site'); ?>/images/icons/envelope.png"></span>



                          <a href="mailto:<?php echo ADMIN_EMAIL; ?>" target="_top">

                            <?php echo ADMIN_EMAIL; ?>

                            </a>

                        </div>

                    </div>

                </div>

                <div class="clearfix"></div>

                <div class="copy-right">

                    <h2>© Copyright 2018 <?php echo SITE_NAME; ?> Designed By, <span><a href="https://www..com/" target="_blank"></a></span> </h2>

                </div>

            </div>

        </section>



          </body>

<script type="text/javascript">

    BASEURL = '<?php echo base_url(); ?>';

</script>

   <script src="https://cdnjs.cloudflare.com/ajax/libs/webshim/1.16.0/dev/polyfiller.js"></script>





    <script src="<?php echo base_url('assets/admin/js/bootstrap-datepicker.min.js');?>"></script>

    <script src="<?php echo base_url('assets/admin/js/validation/jquery.validate.js');?>"></script>

<script src="<?php echo base_url('assets/admin/js/validation/additional-methods.js');?>"></script>

    <script src="<?php echo base_url('assets/site/js/common.js');?>"></script>



  <script>

        webshim.activeLang('en');

        webshims.polyfill('forms');

        webshims.cfg.no$Switch = true;

    </script>



    <script type="text/javascript">

        var dateToday = new Date();

        $('.hasDatepicker').datepicker({

        setDate: dateToday,

        todayHighlight: true,

         });

        $('input.timepick').timepicker({});

    </script>



 <script type="text/javascript">

     $("#commentForm").validate({});

 </script>

 <script type="text/javascript">



                 <?php

        if ($this->session->flashdata('success_message') || $this->session->flashdata('error_message')) { ?>



    setTimeout(function(){ $('.swal-button--confirm').click(); }, 5000);

    <?php } ?>

</script>



<script type="text/javascript">





$(function () {

    setTimeout(all_notifcations, 2000);



});



var xhrm = '';

function all_notifcations() {



    xhrm = $.ajax({

        dataType: "json",

        type: "POST",

        global: false,

        url: BASE_URL + 'messages/unread_mes',

        success: function (data) {

           if(data != 0){

            $("#counter").html('<span class="badge">'+data+'</span>');



           }else{

             $("#counter").html(' ');

           }

            setTimeout(all_notifcations, 5000);

        }

    });



}

</script>