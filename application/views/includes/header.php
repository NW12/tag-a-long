    <body>
       <header id="top-header">
            <div class="container">
                <div class="md-data">
                    <div class="left-data">
                        <ul>
                           
                             <?php $cms = get_header_menu(3);
                                foreach ($cms as $key => $value) { 
                             ?>
                            <li><a href="<?php echo site_url('cms/'.$value['slug']); ?>"><?php echo strtoupper($value['title']); ?></a>
                            </li>
                           <?php } ?>
                        </ul>
                    </div>
                    <div class="main-logo">
                        <div class="logo">
                            <a href="<?php echo site_url(); ?>"><img src="<?php echo base_url('uploads/site/pic/'.SITE_LOGO); ?>"></a>
                        </div>
                    </div>
                    <div class="right-data">
                        <ul>
                            <li><a href="<?php echo site_url('residence'); ?>">RESIDENCES</a></li>
                            <?php if($this->session->userdata('users_is_logged_in') == 1): ?>
                           

                            <li class="notify"><a href="<?php echo site_url('user/dashboard'); ?>"><img src="<?php echo base_url('assets/site'); ?>/images/icons/login-icon.png"> DASHBOARD</a> <div id="counter">  </div></li>
                            <li><a href="<?php echo site_url('user/logout'); ?>"><img src="<?php echo base_url('assets/site'); ?>/images/icons/signup.png"> LOGOUT</a></li>
                        <?php else: ?>
                              <li><a href="<?php echo site_url('user/login'); ?>"><img src="<?php echo base_url('assets/site'); ?>/images/icons/login-icon.png"> LOGIN</a></li>
                            <li><a href="<?php echo site_url('user/register'); ?>"><img src="<?php echo base_url('assets/site'); ?>/images/icons/signup.png"> SIGNUP</a></li>
                        <?php endif; ?>
                        </ul>
                    </div>
                </div>
                <div class="xs-data">
                    <div class="col-xs-12">
                        <nav class="navbar navbar-inverse">
                            <div class="container-fluid">
                                <div class="navbar-header">
                                    <a href="index.html"><img src="<?php echo base_url('assets/site'); ?>/images/logo/main-logo-mob.png"></a>
                                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span>
                                        <span class="icon-bar"></span> 
                                    </button>
                                </div>
                                <div class="collapse navbar-collapse" id="myNavbar">
                                    <ul class="nav navbar-nav">
                                        <?php $cms = get_header_menu(3);
                                foreach ($cms as $key => $value) { 
                             ?>
                            <li><a href="<?php echo site_url('cms/'.$value['slug']); ?>"><?php echo strtoupper($value['title']); ?></a>
                            </li>
                           <?php } ?>
                           <li><a href="<?php echo site_url('residence'); ?>">RESIDENCES</a></li>
                                       <?php if($this->session->userdata('users_is_logged_in') == 0): ?>
                            <li><a href="<?php echo site_url('user/login'); ?>"><img src="<?php echo base_url('assets/site'); ?>/images/icons/login-icon.png"> LOGIN</a></li>
                            <li><a href="<?php echo site_url('user/register'); ?>"><img src="<?php echo base_url('assets/site'); ?>/images/icons/signup.png"> SIGNUP</a></li>
                        <?php else: ?>
                             <li class="notify"><a href="<?php echo site_url('user/dashboard'); ?>"><img src="<?php echo base_url('assets/site'); ?>/images/icons/login-icon.png"> DASHBOARD</a> <div id="counter">  </div></li>
                            <li><a href="<?php echo site_url('user/logout'); ?>"><img src="<?php echo base_url('assets/site'); ?>/images/icons/signup.png"> LOGOUT</a></li>
                        <?php endif; ?>
                                    </ul>
                                </div>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
<div class="alert alert-success"  id="formErrorMsg" style="display: none;"></div>
                <?php
        if ($this->session->flashdata('success_message')) { ?>
              <script type="text/javascript">
                  swal({
  title: "<?php echo $this->session->flashdata('success_message'); ?>!",
  text: "",
  icon: "success",
});
              </script>
     <?php   };
        ?>
        <div class="clearfix"></div>
        <!-- Notification -->
        <?php
        if ($this->session->flashdata('error_message')) { ?>
               <script type="text/javascript">
                    swal("<?php echo $this->session->flashdata('error_message'); ?>", "", "error");
                </script>
     <?php   };
        ?>
        </header>