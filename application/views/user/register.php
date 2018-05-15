<style type="text/css">
    .cst_radio input{
        float: left !important;
        display: inline-block !important;
        width: 20% !important;
    }
</style>
<link href="<?php echo base_url('assets/site'); ?>/css/style.css" rel="stylesheet">
 <link type="image/x-icon" rel="icon" href="<?php echo base_url('uploads/site/pic/' . FAVICON); ?>">
            <link type="image/x-icon" rel="shortcut icon" href="<?php echo base_url('uploads/site/pic/' . FAVICON); ?>">
 <div class="container">
            <section id="formHolder">
                <div class="row">
                    <div class="col-sm-6 brand">
                        <div class="heading">
                            <a href="<?php echo site_url(); ?>"><img src="<?php echo base_url('assets/site'); ?>/images/logo/biglogo.png"></a>
                        </div>
                    </div>
                    <div class="col-sm-6 form">
                        <div class="login form-peice switched">
                            <form class="login-form" action="#" method="post">
                            
                                <div class="form-group">
                                    <label for="loginemail">Email Adderss</label>
                                    <input type="email" name="loginemail" id="loginemail" required>
                                </div>
                                <div class="form-group">
                                    <label for="loginPassword">Password</label>
                                    <input type="password" name="loginPassword" id="loginPassword" required>
                                </div>
                                <div class="CTA">
                                    <input type="submit" value="Login">
                                    <a href="#" class="switch">I'm New</a>
                                </div>
                            </form>
                        </div>
                        <div class="signup form-peice">
                            <form class="signup-form" action="<?php echo site_url('user/submit') ?>" method="post">
                            <h2>Create a New Account</h2>
                        <?php  /* ?>
                                <div class="row">

                                    <div class="col-sm-6">
                                        <a href="<?php echo site_url('user/fblogin'); ?>"><img class="img-responsive" src="<?php echo base_url('assets/site'); ?>/images/facebook_signin.png"></a>
                                    </div>
                                    <div class="col-sm-6">
                                        <a href="<?php echo site_url('twitter/auth'); ?>"><img class="img-responsive" src="<?php echo base_url('assets/site'); ?>/images/twitter_signin.png"></a>
                                    </div>
                                </div> <?php  */ ?>
                                <div class="clearfix"></div>
                                 <div class="row cst_radio">
                                     <div class="col-sm-4" for="user_role" >Who You Are?</div>
                                    <div class="col-sm-4"> 
                                       <input type="radio" id="label-1" name="user_role"  value="1" required checked >
                                        <label for="label-1">   Visitor </label> 
                                     </div>
                                      <div class="col-sm-4">
                                      <input type="radio" id="label-2" name="user_role" value="2">
                                      <label for="label-2">   Resident </label> 
                                     </div>
                                </div>
                                <div class="form-group">
                                    <label for="name">Full Name</label>
                                    <input type="text" name="user_name" id="name" class="name" required>
                                    <span class="error"></span>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email Address</label>
                                    <input type="email" name="email" id="email" class="email" required >
                                    <span class="error"></span>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" id="password" class="pass" required>
                                    <span class="error"></span>
                                </div>
                                <div class="form-group">
                                    <label for="passwordCon">Confirm Password</label>
                                    <input type="password" name="passwordCon" id="passwordCon" class="passConfirm" required>
                                    <span class="error"></span>
                                </div>
                                <div class="CTA">
                                    <button class="custom-btn" type="submit" >Signup Now</button>
                                    <a href="<?php echo site_url('user/login'); ?>" class="dec_a">Already have an account?</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
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