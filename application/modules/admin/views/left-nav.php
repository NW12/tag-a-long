<?php

$currentPage = $this->uri->segment(2);



$openSite = $openSite1 = $openDash = $openPages = $openPages1 = $openUsers = $openUsers1 = '';

$openRoles = $openRoles1 = $openCat = $openCat1 = $openPro = $openPro1 = $openslider = $openslider1 = '';

$opentest = $opentest1 = $opensponsor = $opensponsor1 = $opensocial = $opensocial1 = '';

$opennews = $opennews1 = $openfeed = $openfeed1 = $openfields = $openfields1 = '';

$openpack = $openpack1 = $openCompany = $openCompany1 = $openPay = $openPay1 = '';

$openAdv1 = $openAdv1 = $openAdvPack = $openAdvPack1 = $openVideos = $openVideos1 = $openImages = $openImages1 = '';

$openJobs = $openJobs1 = $openAdminUser = $openAdminUser1 = '';



if ($currentPage == 'site_settings') {

    $openSite = 'active open';

    $openSite1 = 'active';

} elseif ($currentPage == 'dashboard') {

    $openDash = 'active';

} elseif ($currentPage == 'pages') {

    $openPages = 'active open';

    $openPages1 = 'active';

} elseif ($currentPage == 'users') {

    $openAdmin = 'active open';

    $openAdmin1 = 'active';

}

elseif ($currentPage == 'tracks') {

    $openTrack = 'active open';

    $openTrack1 = 'active';

}elseif ($currentPage == 'roles') {

    $openRoles = 'active open';

    $openRoles1 = 'active';

}  elseif ($currentPage == 'payment_integration') {

    $openPay = 'active open';

    $openPay1 = 'active';

}  elseif ($currentPage == 'email_templates' && $subPage == 'registration_account_templete') {

    $openRegister = 'active open';

    $openEmailtemplate = 'active';

} elseif ($currentPage == 'email_templates') {

    $openEmailtemplate = 'active open';

    $openEmailtemplate = 'active';

}



$role_id = $this->engineinit->get_session_super_admin();

?>

<!-- sidebar menu -->

<div id="sidebar" class="sidebar                  responsive">

    <script type="text/javascript">

    try {

        ace.settings.check('sidebar', 'fixed')

    } catch (e) {

    }

    </script>

    <ul class="nav nav-list">

        <li class="<?php echo $openDash; ?>">

            <a href="<?php echo base_url('admin/dashboard'); ?>">

                <i class="menu-icon fa fa-tachometer"></i>

                <span class="menu-text"> Dashboard </span>

            </a>



            <b class="arrow"></b>

        </li>





        <li class="<?php echo $openSite; ?>">

            <a href="#" class="dropdown-toggle">

                <i class="menu-icon fa fa-desktop"></i>

                <span class="menu-text">

                    Site

                </span>



                <b class="arrow fa fa-angle-down"></b>

            </a>



            <b class="arrow"></b>



            <ul class="submenu">



                <?php

                if (rights(5) == true) {

                    ?>

                    <li class="<?php echo $openSite1; ?>">

                        <a href="<?php echo base_url('admin/site_settings'); ?>">

                            <i class="menu-icon fa fa-caret-right"></i>

                            Site settings

                        </a>



                        <b class="arrow"></b>

                    </li>

                    <?php } ?>



                    <li class="">

                        <a href="<?php echo base_url(); ?>">

                            <i class="menu-icon fa fa-caret-right"></i>

                            View Site

                        </a>



                        <b class="arrow"></b>

                    </li>



                    <li class="">

                        <a href="<?php echo base_url('admin/login/logout'); ?>">

                            <i class="menu-icon fa fa-caret-right"></i>

                            Logout

                        </a>



                        <b class="arrow"></b>

                    </li>





                </ul>

            </li>





            <?php

            if ($this->session->userdata('role_id') == 0) {

                ?>

                <li class="<?php echo $openRoles; ?>">

                    <a href="#" class="dropdown-toggle">

                        <i class="menu-icon fa fa-cog"></i>

                        <span class="menu-text">

                            Roles

                        </span>



                        <b class="arrow fa fa-angle-down"></b>

                    </a>



                    <b class="arrow"></b>



                    <ul class="submenu">



                        <li class="<?php echo $openRoles1; ?>">

                            <a href="<?php echo base_url('admin/roles'); ?>">

                                <i class="menu-icon fa fa-caret-right"></i>

                                Roles

                            </a>



                            <b class="arrow"></b>

                        </li>



                    </ul>

                </li>

                <?php } ?>



                <?php

                if (rights(10) == true) {

                    ?>



                    <li class="<?php echo $openAdminUser; ?>">

                        <a href="#" class="dropdown-toggle">

                            <i class="menu-icon fa fa-file-text-o"></i>

                            <span class="menu-text"> Admin Users </span>



                            <b class="arrow fa fa-angle-down"></b>

                        </a>



                        <b class="arrow"></b>



                        <ul class="submenu">

                            <li class="<?php echo $openAdminUser1; ?>">

                                <a href="<?php echo base_url('admin/admin_users'); ?>">

                                    <i class="menu-icon fa fa-caret-right"></i>

                                    Manage Admins

                                </a>



                                <b class="arrow"></b>



                            </li>

                        </ul>

                    </li>



                    <?php } ?> 

                    <?php

                    if (rights(1) == true) {

                        ?>



                        <li class="<?php echo $openAdmin; ?>">

                            <a href="#" class="dropdown-toggle">

                                <i class="menu-icon fa fa-list-alt"></i>

                                <span class="menu-text"> Users </span>



                                <b class="arrow fa fa-angle-down"></b>

                            </a>



                            <b class="arrow"></b>



                            <ul class="submenu">

                                <li class="<?php echo $openAdmin1; ?>">

                                    <a href="<?php echo base_url('admin/users'); ?>">

                                        <i class="menu-icon fa fa-caret-right"></i>

                                        Manage Users

                                    </a>



                                    <b class="arrow"></b>

                                </li>

                            </ul>

                        </li>



                        <?php } ?>



                        <?php

                        if (rights(1) == true) {

                            ?>



                            <li class="<?php echo $openTrack; ?>">

                                <a href="#" class="dropdown-toggle">

                                    <i class="menu-icon fa fa-list-alt"></i>

                                    <span class="menu-text"> Tracks </span>



                                    <b class="arrow fa fa-angle-down"></b>

                                </a>



                                <b class="arrow"></b>



                                <ul class="submenu">

                                    <li class="<?php echo $openTrack1; ?>">

                                        <a href="<?php echo base_url('admin/tracks'); ?>">

                                            <i class="menu-icon fa fa-caret-right"></i>

                                            Manage Tracks

                                        </a>



                                        <b class="arrow"></b>

                                    </li>

                                </ul>

                            </li>



                            <?php } ?>



                            <?php

                            if (rights(24) == true) {

                                ?>

                                <li class="<?php echo $openPages; ?>">

                                    <a href="#" class="dropdown-toggle">

                                        <i class="menu-icon fa fa-file-text-o"></i>

                                        <span class="menu-text"> CMS Pages </span>



                                        <b class="arrow fa fa-angle-down"></b>

                                    </a>



                                    <b class="arrow"></b>



                                    <ul class="submenu">

                                        <li class="<?php echo $openPages1; ?>">

                                            <a href="<?php echo base_url('admin/pages'); ?>">

                                                <i class="menu-icon fa fa-caret-right"></i>

                                                Manage CMS Pages

                                            </a>



                                            <b class="arrow"></b>

                                        </li>



                                    </ul>

                                </li>

                                <?php } ?>

                                <li class="<?php echo $openEmailtemplate; ?>">

                                    <a href="#" class="dropdown-toggle">

                                        <i class="menu-icon fa fa-credit-card"></i>

                                        <span class="menu-text"> Email Templates </span>



                                        <b class="arrow fa fa-angle-down"></b>

                                    </a>



                                    <b class="arrow"></b>



                                    <ul class="submenu">

                                        <li class="<?php echo $openRegister; ?>">

                                            <a href="<?php echo base_url('admin/email_templates/registration_account_templete'); ?>">

                                                <i class="menu-icon fa fa-caret-right"></i>

                                                Registration 

                                            </a>

                                            <b class="arrow"></b>

                                        </li>



                                        <li class="<?php echo $openRegister; ?>">

                                            <a href="<?php echo base_url('admin/email_templates/forgotpassword_account_templete'); ?>">

                                                <i class="menu-icon fa fa-caret-right"></i>

                                                Forgot Password 

                                            </a>

                                            <b class="arrow"></b>

                                        </li>



                                        <li class="<?php echo $openRegister; ?>">

                                            <a href="<?php echo base_url('admin/email_templates/contact_us_templete'); ?>">

                                                <i class="menu-icon fa fa-caret-right"></i>

                                                Contact Us 

                                            </a>

                                            <b class="arrow"></b>

                                        </li>

                                        <li class="<?php echo $openRegister; ?>">

                                            <a href="<?php echo base_url('admin/email_templates/newsletter'); ?>">

                                                <i class="menu-icon fa fa-caret-right"></i>

                                                Newsletter 

                                            </a>

                                            <b class="arrow"></b>

                                        </li>





                                    </ul>

                                </li>

        <!--

        <li class="<?php echo $openslider; ?>">

            <a href="#" class="dropdown-toggle">

                <i class="menu-icon fa fa-sliders"></i>

                <span class="menu-text"> Home Page Slider </span>



                <b class="arrow fa fa-angle-down"></b>

            </a>



            <b class="arrow"></b>



            <ul class="submenu">

                <li class="<?php echo $openslider1; ?>">

                    <a href="<?php echo base_url('admin/home_slider'); ?>">

                        <i class="menu-icon fa fa-caret-right"></i>

                        Manage Home Slider

                    </a>



                    <b class="arrow"></b>

                </li>



            </ul>

        </li>



        <li class="<?php echo $opentest; ?>">

            <a href="#" class="dropdown-toggle">

                <i class="menu-icon fa fa-book"></i>

                <span class="menu-text"> Testimonials </span>



                <b class="arrow fa fa-angle-down"></b>

            </a>



            <b class="arrow"></b>



            <ul class="submenu">

                <li class="<?php echo $opentest1; ?>">

                    <a href="<?php echo base_url('admin/testimonials'); ?>">

                        <i class="menu-icon fa fa-caret-right"></i>

                        Manage Testimonials

                    </a>



                    <b class="arrow"></b>

                </li>



            </ul>

        </li>





        <li class="<?php echo $opensocial; ?>">

            <a href="#" class="dropdown-toggle">

                <i class="menu-icon fa fa-share-alt"></i>

                <span class="menu-text"> Social Media </span>



                <b class="arrow fa fa-angle-down"></b>

            </a>



            <b class="arrow"></b>



            <ul class="submenu">

                <li class="<?php echo $opensocial1; ?>">

                    <a href="<?php echo base_url('admin/social_media'); ?>">

                        <i class="menu-icon fa fa-caret-right"></i>

                        Manage Social Media

                    </a>



                    <b class="arrow"></b>

                </li>



            </ul>

        </li>



        <li class="<?php echo $opennews; ?>">

            <a href="#" class="dropdown-toggle">

                <i class="menu-icon fa fa-bullhorn"></i>

                <span class="menu-text"> NewsLetters </span>



                <b class="arrow fa fa-angle-down"></b>

            </a>



            <b class="arrow"></b>



            <ul class="submenu">

                <li class="<?php echo $opennews1; ?>">

                    <a href="<?php echo base_url('admin/newsletter'); ?>">

                        <i class="menu-icon fa fa-caret-right"></i>

                        Manage NewsLetters

                    </a>



                    <b class="arrow"></b>

                </li>



            </ul>

        </li>





        <li class="<?php echo $openfeed; ?>">

            <a href="#" class="dropdown-toggle">

                <i class="menu-icon fa fa-envelope-o"></i>

                <span class="menu-text"> Feedback </span>



                <b class="arrow fa fa-angle-down"></b>

            </a>



            <b class="arrow"></b>



            <ul class="submenu">

                <li class="<?php echo $openfeed; ?>">

                    <a href="<?php echo base_url('admin/feedback'); ?>">

                    <i class="menu-icon fa fa-caret-right"></i>

                    Manage Feedback

                </a>



                <b class="arrow"></b>

            </li>



        </ul>

    </li>

    - ->

   

</ul><!-- /.nav-list -->



<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">

    <i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>

</div>



<script type="text/javascript">

try {

    ace.settings.check('sidebar', 'collapsed')

} catch (e) {

}

</script>

</div>

<!-- /sidebar menu -->