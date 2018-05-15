<div class="page-header">

    <h1>

        Admin Users



    </h1>

</div> 



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



        <li>

            <a href="<?php echo base_url('admin/admin_users') ?>">Admin Users</a>

        </li>

        <li class="active">Add admins</li>

    </ul> 





</div>





<div class="row">

    <div class="col-xs-12">



        <?php

        if ($this->session->flashdata('success_message')) {

            echo '<div class="alert alert-success alertMessage">' . $this->session->flashdata('success_message') . '</div>';

        };

        ?>

        <div class="clearfix"></div>



        <?php

        if ($this->session->flashdata('error_message')) {

            echo '<div class="alert alert-danger">' . $this->session->flashdata('error_message') . '</div>';

        };

        ?>

        <div class="clearfix"></div>





        <div class="space-8"></div>

        <div class="space-8"></div>

        <form id="users_form" name="users_form" action="<?php echo base_url('admin/admin_users/add') ?>" class="form-horizontal" role="form" method="post"  accept-charset="utf-8" enctype="multipart/form-data">



            <input type="hidden" name="action" id="action" value="<?php echo $action; ?>">



            <input type="hidden"  id="id" name="id" value="<?php echo $row['id']; ?>"  >

            <?php if(!isset($profile_check)){ ?>

            <div class="form-group">

                <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="admin_users">Role*</label>

                <div class="col-xs-12 col-sm-9">

                    <select id="role_id" name="role_id" class="col-xs-12 col-sm-5" >

                        <option value="">---- Select Role -----</option>

                        <?php

                        $roles = get_roles();

                        if (($roles)) {

                            foreach ($roles as $role) {

                                ?>

                                <option value="<?php echo $role['id'] ?>"><?php echo $role['role'] ?></option>

                                <?php

                            }

                        }

                        ?>



                    </select>

                </div>

            </div>

            <script>$("#role_id").val(<?php echo $row['role_id'] ?>);</script>

            <?php  } ?>

            <div class="form-group">

                <label class="control-label col-xs-12 col-sm-3 no-padding-right">First Name *</label>

                <div class="col-xs-12 col-sm-9">

                    <div class="clearfix">

                        <input type="text" class="col-xs-12 col-sm-5" id="first_name" name="first_name"  placeholder="First Name" value="<?php echo $row['first_name']; ?>" required>

                    </div>

                </div>

            </div>

            <div class="space-2"></div>

            <div class="form-group">

                <label class="control-label col-xs-12 col-sm-3 no-padding-right">Last Name *</label>

                <div class="col-xs-12 col-sm-9">

                    <div class="clearfix">

                        <input type="text" class="col-xs-12 col-sm-5" id="last_name" name="last_name" placeholder="Last Name" value="<?php echo $row['last_name'] ?>" required />

                    </div></div>

                </div>

                <div class="space-2"></div>

                <div class="form-group">

                    <label class="control-label col-xs-12 col-sm-3 no-padding-right">Full Name *</label>

                    <div class="col-xs-12 col-sm-9">

                        <div class="clearfix">

                            <input type="text" class="col-xs-12 col-sm-5" id="last_name" name="full_name" placeholder="Full Name" value="<?php echo $row['full_name'] ?>" required />

                        </div></div>

                    </div>

                    <div class="space-2"></div>

                    <div class="form-group">

                        <label class="control-label col-xs-12 col-sm-3 no-padding-right">User Name *</label>

                        <div class="col-xs-12 col-sm-9">

                            <div class="clearfix">

                                <input type="text" class="col-xs-12 col-sm-5" id="user_name" name="user_name" placeholder="User Name" value="<?php echo $row['user_name'] ?>" required />

                            </div></div>

                        </div>

                        <div class="space-2"></div>





                        <div class="form-group">

                            <label class="control-label col-xs-12 col-sm-3 no-padding-right" for="photo">Photo</label>



                            <div  class="col-xs-10 col-sm-4">

                                <input type="file" id="photo" name="photo">

                                <div class="space-2"></div>

                                <input type="hidden" name="old_photo"  id="old_photo" value="<?php echo $row['profile_image']; ?>">

                                <?php

                                if (isset($row)) {

                                    if ($row['profile_image'] == '') {

                                        $row['profile_image'] = 'abc.png';

                                    }

                                    echo '<img src="' . $this->common->check_image(base_url("uploads/admin_users/small/" . $row['profile_image']), 'no_image.jpg') . '" width="50" height="50" />';

                                }

                                ?>





                            </div>

                        </div>

                        <div class="space-2"></div>

                        <div class="form-group">

                            <label class="control-label col-xs-12 col-sm-3 no-padding-right">Email *</label>

                            <div class="col-xs-12 col-sm-9">

                                <div class="clearfix">



                                    <input type="email" class="col-xs-12 col-sm-5 ckeditor" id="email" name="email" value="<?php echo $row['email'] ?>"  placeholder="Email"  onchange="checkEmail();" required/>

                                    <label class="help-block" id="emailExist_error" style="display: none;"></label>

                                </div>

                            </div>

                        </div>

                        <div class="space-2"></div>

                        <div class="form-group">

                            <label class="control-label col-xs-12 col-sm-3 no-padding-right">Password <?php echo (!isset($row)) ? '*' : '' ?></label>

                            <div class="col-xs-12 col-sm-9">

                                <div class="clearfix">



                                    <input type="password" class="col-xs-12 col-sm-5 ckeditor" id="password" name="password"  placeholder="Password" <?php echo (!isset($row)) ? 'required' : '' ?>/>



                                </div>

                            </div>

                        </div>









                        <div class="form-group">

                            <label class="control-label col-xs-12 col-sm-3 no-padding-right">Status *</label>

                            <div class="col-xs-12 col-sm-9">

                                <div>

                                    <label class="blue">

                                        <input type="radio" id="status" class="ace" <?php echo ( isset($row) && $row['is_active'] == 1) ? 'checked' : '' ?> value="1" name="is_active" required>

                                        <span class="lbl">&nbsp;Active</span>

                                    </label>

                                </div>

                                <div>

                                    <label class="blue">

                                        <input type="radio" class="ace" <?php echo ( isset($row) && $row['is_active'] == 0) ? 'checked' : '' ?> id="status" value="0" name="is_active" required>

                                        <span class="lbl">&nbsp;Inactive</span>

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

                                <button class="btn" type="reset" onclick="clear_form_elements('#users_form');">

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

                $('#users_form').validate({

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



