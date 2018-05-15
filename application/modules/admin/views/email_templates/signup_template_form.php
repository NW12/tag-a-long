<script src="<?php echo base_url('assets/admin/js/ckeditor/ckeditor.js') ?>"></script>

<div class="page-header">

    <h1>

        <?php echo ucwords(str_replace('_', ' ', $controller)) ?>



    </h1>

</div><!-- /.page-header -->



<div class="breadcrumbs" id="breadcrumbs">

    <script type="text/javascript">

    try {

        ace.settings.check('breadcrumbs', 'fixed')

    } catch (e) {

    }

    </script>



    <ul class="breadcrumb">

        <li>

            <i class="ace-icon fa fa-home home-icon"></i>

            <a href="<?php echo base_url('admin/dashboard') ?>">Home</a>

        </li>





        <li class="active"><?php echo "Add Email Template"; ?></li>

    </ul><!-- /.breadcrumb -->





</div>





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



        <div class="space-8"></div>

        <div class="space-8"></div>



        <form id="formEmail" action="<?php echo base_url('admin/email_templates/' . $controller) ?>" class="form-horizontal" role="form" method="post" accept-charset="utf-8">

            <input type="hidden"  id="id" name="id" value="<?php echo $id; ?>"  >

            <div class="form-group">

                <label class="control-label col-xs-12 col-sm-3 no-padding-right">Title *</label>

                <div class="col-xs-12 col-sm-9">

                    <div class="clearfix">

                        <input  type="text" class="col-xs-12 col-sm-5" id="pageTitle" name="title"  placeholder="" value="<?php echo $title; ?>" required ></div>

                    </div>

                </div>

                <div class="space-2"></div>

                <?php

                if ($shw_msg == 1) {

                    ?>

                    <div class="form-group">

                        <label class="control-label col-xs-12 col-sm-3 no-padding-right">Welcome Content *</label>

                        <div class="col-xs-12 col-sm-9">

                            <div class="clearfix">

                                <textarea class="col-xs-12 col-sm-5" id="welcome_content" name="welcome_content"  placeholder="<?php echo $this->lang->line('lbl_welcome_content'); ?>" required><?php echo $welcome_content ?></textarea>

                            </div></div>

                        </div>

                        <div class="space-2"></div>

                        <?php } ?>

                        <div class="form-group">

                            <label class="control-label col-xs-12 col-sm-3 no-padding-right">Content *</label>

                            <div class="col-xs-12 col-sm-9">

                                <div class="clearfix">

                                    <textarea class="col-xs-12 col-sm-5 ckeditor" id="content" name="content"  placeholder="<?php echo $this->lang->line('lbl_content_template'); ?>" required><?php echo $content_data ?></textarea>

                                </div></div>

                            </div>

                            <div class="space-2"></div>



                            <div class="form-group">

                                <label class="control-label col-xs-12 col-sm-3 no-padding-right">&nbsp;</label>

                                <div class="col-xs-12 col-sm-9">

                                    <p class="description"></p>

                                </div>

                            </div>

                            <div class="space-2"></div>

                            <div class="form-group">

                                <label class="control-label col-xs-12 col-sm-3 no-padding-right">Footer *</label>

                                <div class="col-xs-12 col-sm-9">

                                    <div class="clearfix">

                                        <textarea class="col-xs-12 col-sm-5 ckeditor" id="footer" name="footer"  placeholder="<?php echo $this->lang->line('lbl_footer_template'); ?>"><?php echo $footer_data ?></textarea>

                                    </div></div>

                                </div>

                                <div class="space-2"></div>







                                <div class="space-2"></div>



                                <div class="form-group">

                                    <label class="control-label col-xs-12 col-sm-3 no-padding-right">Status *</label>

                                    <div class="col-xs-12 col-sm-9">

                                        <div>

                                            <label class="blue">

                                                <input type="radio" id="status" class="ace" <?php echo ( isset($status) && $status == 1) ? 'checked' : '' ?> value="1" name="status" required>

                                                <span class="lbl">&nbsp;Active</span>

                                            </label>

                                        </div>

                                        <div>

                                            <label class="blue">

                                                <input type="radio" class="ace" <?php echo ( isset($status) && $status == 0) ? 'checked' : '' ?> id="status" value="0" name="status" required>

                                                <span class="lbl">&nbsp;In Active</span>

                                            </label>

                                        </div>

                                    </div>

                                </div>

                                <div class="space-2"></div>







                                <div class="space-2"></div>

                                <div class="clearfix form-actions">

                                    <div class="col-md-offset-3 col-md-9">

                                        <button class="btn btn-info" type="submit">

                                            <i class="ace-icon fa fa-check bigger-110"></i>

                                            Submit

                                        </button>



                                        &nbsp; &nbsp; &nbsp;

                                        <button class="btn" type="reset" onclick="clear_form_elements('#formEmail');">

                                            <i class="ace-icon fa fa-undo bigger-110"></i>

                                            Reset

                                        </button>

                                    </div>

                                </div>



                            </form>



                        </div>

                    </div>



                    <script>

                    $(function () {

                        $('#formEmail').validate({

                            errorElement: 'div',

                            errorClass: 'help-block',

                            focusInvalid: false,

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

                                } else if (element.is('.select2')) {

                                    error.insertAfter(element.siblings('[class*="select2-container"]:eq(0)'));

                                } else if (element.is('.chosen-select')) {

                                    error.insertAfter(element.siblings('[class*="chosen-container"]:eq(0)'));

                                } else

                                error.insertAfter(element.parent());

                            },

                            invalidHandler: function (form) {

                            }

                        });

});





</script>