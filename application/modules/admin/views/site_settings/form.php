<div class="page-header">

    <h1>

        Site Settings

        <small>

            <i class="ace-icon fa fa-angle-double-right"></i>

            Main site settings

        </small>

    </h1>

</div><!-- /.page-header -->



<div class="row">

    <div class="col-xs-12">



        <?php

        if ($this->session->flashdata('success_message')) {

            echo '<div class="alert alert-success alertMessage">' . $this->session->flashdata('success_message') . '</div>';

        };

        ?>

        <div class="clearfix"></div>

        <!-- Notification -->

        <?php

        if ($this->session->flashdata('error_message')) {

            echo '<div class="alert alert-danger">' . $this->session->flashdata('error_message') . '</div>';

        };

        ?>

        <div class="clearfix"></div>

        <!-- /Notification -->



        <!-- PAGE CONTENT BEGINS -->

        <form class="form-horizontal" role="form" nam="setting_form" id="setting_form" method="post" action="<?php echo base_url('admin/site_settings') ?>" accept-charset="utf-8" enctype="multipart/form-data" >

            <input type="hidden" id="id" name="id" value="<?php echo isset($row) ? $row['id'] : 1 ?>"/>



            <div class="form-group">

                <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="site_name"> Site Name * </label>



                <div class="col-xs-12 col-sm-9">

                    <div class="clearfix">

                        <input type="text"  name="site_name" id="site_name" value="<?php echo $row['site_name']; ?>" placeholder=" Site Name" class="col-xs-12 col-sm-5" required/></div>

                    </div>

                </div>

                <div class="space-2"></div>



                <div class="form-group">

                    <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="site_title">Site Title * </label>



                    <div class="col-xs-12 col-sm-9">

                        <div class="clearfix">

                            <input type="text"  id="site_title" name="site_title" value="<?php echo $row['site_title']; ?>" placeholder="Site Title " class="col-xs-12 col-sm-5" required/></div>

                        </div>

                    </div>

                    <div class="space-2"></div>



                    <div class="form-group">

                        <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="site_keywords">Site Keywords * </label>



                        <div class="col-xs-12 col-sm-9">

                            <div class="clearfix">



                                <textarea  class="col-xs-12 col-sm-5 limited" id="site_keywords" name="site_keywords" placeholder=" Site Keywords" style="height: 150px;" maxlength="1000" required><?php echo $row['site_keywords']; ?></textarea>

                            </div>

                        </div>

                    </div>

                    <div class="space-2"></div>



                    <div class="form-group">

                        <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="site_description"> Site Description * </label>



                        <div class="col-xs-12 col-sm-9">

                            <div class="clearfix">

                                <textarea  class="col-xs-12 col-sm-5 limited" id="site_description" name="site_description" placeholder=" Site Description" style="height: 75px;"  maxlength="1000" required><?php echo $row['site_description']; ?></textarea>

                            </div>

                        </div>

                    </div>

                    <div class="space-2"></div>			



                    <div class="form-group">

                        <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="google_map_key"> Google Map Key * </label>



                        <div class="col-xs-12 col-sm-9">

                            <div class="clearfix">

                                <input type="text"  name="google_map_key" id="google_map_key" value="<?php echo $row['google_map_key']; ?>" placeholder="Google Map Key" class="col-xs-12 col-sm-5" required/></div>

                            </div>

                        </div>

                        <div class="space-2"></div>



                        <div class="form-group">

                            <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="comission_percentage"> Commission Percentage * </label>



                            <div class="col-xs-12 col-sm-9">

                                <div class="clearfix">

                                    <input type="text"  id="comission_percentage" name="comission_percentage" value="<?php echo $row['comission_percentage']; ?>" placeholder="Commission Percentage" class="col-xs-12 col-sm-5" required/></div>

                                </div>

                            </div>

                            <div class="form-group">

                                <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="booking_fee"> Booking Fee * </label>



                                <div class="col-xs-12 col-sm-9">

                                    <div class="clearfix">

                                        <input type="number" step="0.01"  id="booking_fee" name="booking_fee" value="<?php echo $row['booking_fee']; ?>" placeholder="Booking Fee" class="col-xs-12 col-sm-5" required/></div>

                                    </div>

                                </div>

                                <div class="space-2"></div>

                                <div class="form-group">

                                    <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="admin_email"> Admin Email *</label>



                                    <div class="col-xs-12 col-sm-9">

                                        <div class="clearfix">

                                            <input type="email" id="admin_email" name="admin_email" value="<?php echo $row['admin_email']; ?>" placeholder=" Admin Email" class="col-xs-12 col-sm-5" required/></div>

                                        </div>

                                    </div>

                                    <div class="space-2"></div>



                                    <div class="form-group">

                                        <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="admin_phone"> Admin Contact No *</label>



                                        <div class="col-xs-12 col-sm-9">

                                            <div class="clearfix">

                                                <input type="text" id="admin_phone" name="admin_phone" value="<?php echo $row['admin_phone']; ?>" placeholder=" Admin Contact no" class="col-xs-12 col-sm-5" required/></div>

                                            </div>

                                        </div>



                                        <div class="space-2"></div>





                                        <div class="form-group">

                                            <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="admin_address">Admin Address *</label>



                                            <div class="col-xs-12 col-sm-9">

                                                <div class="clearfix">

                                                    <textarea  class="col-xs-12 col-sm-5" id="admin_address" name="admin_address" placeholder="Admin Address " style="height: 75px;" required><?php echo $row['admin_address']; ?></textarea></div>

                                                </div>

                                            </div>

                                            <div class="space-2"></div>

                                            <div class="form-group">

                                                <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="contactus_email">Contact Us Email *</label>



                                                <div class="col-xs-12 col-sm-9">

                                                    <div class="clearfix">

                                                        <input type="email" id="contactus_email" name="contactus_email" value="<?php echo $row['contactus_email']; ?>" placeholder="Contact Us Email " class="col-xs-12 col-sm-5" required/></div>

                                                    </div>

                                                </div>

                                                <div class="space-2"></div>



                                                <div class="form-group">

                                                    <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="contactus_phone"> Contact Us Contact No  *</label>



                                                    <div class="col-xs-12 col-sm-9">

                                                        <div class="clearfix">

                                                            <input type="text" id="contactus_phone" name="contactus_phone" value="<?php echo $row['contactus_phone']; ?>" placeholder="Contact Us COntact No" class="col-xs-12 col-sm-5" required/></div>

                                                        </div>

                                                    </div>

                                                    <div class="space-2"></div>

                                                    <div class="form-group">

                                                        <label class="control-label col-xs-12 col-sm-3 no-padding-right"> PayPal Username *</label>



                                                        <div class="col-xs-12 col-sm-9">

                                                            <div class="clearfix">

                                                                <input type="text" id="paypal_api_username" name="paypal_api_username" value="<?php echo $row['paypal_api_username']; ?>" placeholder="Paypal Api Username" class="col-xs-12 col-sm-5" /></div>

                                                            </div>

                                                        </div>

                                                        <div class="space-2"></div>

                                                        <div class="form-group">

                                                            <label class="control-label col-xs-12 col-sm-3 no-padding-right"> PayPal Password *</label>



                                                            <div class="col-xs-12 col-sm-9">

                                                                <div class="clearfix">

                                                                    <input type="text" id="paypal_api_password" name="paypal_api_password" value="<?php echo $row['paypal_api_password']; ?>" placeholder="Paypal Api Password" class="col-xs-12 col-sm-5" /></div>

                                                                </div>

                                                            </div>

                                                            <div class="space-2"></div>

                                                            <div class="form-group">

                                                                <label class="control-label col-xs-12 col-sm-3 no-padding-right"> PayPal Signature Key *</label>



                                                                <div class="col-xs-12 col-sm-9">

                                                                    <div class="clearfix">

                                                                        <input type="text" id="paypal_api_signature_key" name="paypal_api_signature_key" value="<?php echo $row['paypal_api_signature_key']; ?>" placeholder="Paypal Api Signature Key" class="col-xs-12 col-sm-5" /></div>

                                                                    </div>

                                                                </div>

                                                                <div class="space-2"></div>

                                                                

                                                                <div class="form-group">

                                                                    <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="site_logo">Site Logo *</label>



                                                                    <div  class="col-xs-10 col-sm-4">

                                                                        <input type="file" id="site_logo" name="site_logo">

                                                                        <div class="space-2"></div>

                                                                        <input type="hidden" name="old_logo"  id="old_logo" value="<?php echo $row['site_logo']; ?>">

                                                                        <?php

                                                                        if (isset($row)) {

                                                                            if ($row['en_site_logo'] == '') {

                                                                                $row['en_site_logo'] = 'abc.png';

                                                                            }

                                                                            echo '<img src="' . $this->common->check_image(base_url("uploads/site/pic/" . $row['en_site_logo']), 'no_image.jpg') . '" width="150" height="35" />';

                                                                        }

                                                                        ?>





                                                                    </div>

                                                                </div>

                                                                <div class="space-2"></div>





                                                                <div class="form-group">

                                                                    <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="Favicon"> Favicon Icon *</label>



                                                                    <div  class="col-xs-10 col-sm-4">

                                                                        <input type="file" id="favicon" name="favicon">

                                                                        <div class="space-2"></div>

                                                                        <input type="hidden" name="old_favicon"  id="old_favicon" value="<?php echo $row['favicon']; ?>">

                                                                        <?php

                                                                        if (isset($row)) {

                                                                            if ($row['favicon'] == '') {

                                                                                $row['favicon'] = 'abc.png';

                                                                            }

                                                                            echo '<img src="' . $this->common->check_image(base_url("uploads/site/pic/" . $row['favicon']), 'no_image.jpg') . '" width="16" height="16" />';

                                                                        }

                                                                        ?>



                                                                    </div>

                                                                </div>

                                                                <div class="space-2"></div>

                                                                <div class="clearfix form-actions">

                                                                    <div class="col-md-offset-3 col-md-9">

                                                                        <button class="btn btn-info" type="submit">

                                                                            <i class="ace-icon fa fa-check bigger-110"></i>

                                                                            Submit

                                                                        </button>



                                                                        &nbsp; &nbsp; &nbsp;

                                                                        <button class="btn" type="reset" onclick="clear_form_elements('#setting_form');">

                                                                            <i class="ace-icon fa fa-undo bigger-110"></i>

                                                                            Reset

                                                                        </button>

                                                                    </div>

                                                                </div>



                                                            </form>







                                                            <!-- PAGE CONTENT ENDS -->

                                                        </div><!-- /.col -->

                                                    </div><!-- /.row -->





                                                    <script>

                                                    $(function () {

                                                        $('#setting_form').validate({

                                                            errorElement: 'div',

                                                            errorClass: 'help-block',

                                                            focusInvalid: true,

                                                            highlight: function (e) {

                                                                $(e).closest('.form-group').removeClass('has-info').addClass('has-error');

                                                            },

                                                            success: function (e) {

                                                                $(e).closest('.form-group').removeClass('has-error');

                                                                $(e).remove();

                                                            },

                                                            errorPlacement: function (error, element) {

                                                                if (element.is('input[type=checkbox]') || element.is('input[type=radio]')) {

                                                                    var controls = element.closest('div[class*="col-"]');

                                                                    if (controls.find(':checkbox,:radio').length > 1)

                                                                        controls.append(error);

                                                                    else

                                                                        error.insertAfter(element.nextAll('.lbl:eq(0)').eq(0));

                                                                }

                                                                else if (element.is('.select2')) {

                                                                    error.insertAfter(element.siblings('[class*="select2-container"]:eq(0)'));

                                                                }

                                                                else if (element.is('.chosen-select')) {

                                                                    error.insertAfter(element.siblings('[class*="chosen-container"]:eq(0)'));

                                                                }

                                                                else

                                                                    error.insertAfter(element.parent());

                                                            },

                                                            invalidHandler: function (form) {

                                                            }

                                                        });

});

</script>