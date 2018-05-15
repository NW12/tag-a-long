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

                        <div class="login form-peice">
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
                            <form class="login-form" action="<?php echo site_url('user/loginSubmit'); ?>" method="post">
                            <?php  /* ?>   
                            <div class="row">
                                    <div class="col-sm-6">
                                        <a href="javascript:void(0)" data-toggle="modal" data-target="#myModal" ><img class="img-responsive" src="<?php echo base_url('assets/site'); ?>/images/facebook_signin.png"></a>
                                    </div>
                                    <div class="col-sm-6">
                                        <a href="#"><img class="img-responsive" src="<?php echo base_url('assets/site'); ?>/images/twitter_signin.png"></a>
                                    </div>
                                </div> 
                                <?php */ ?>
                                <h2>Login</h2>
                                <div class="form-group">
                                    <label for="loginemail">Email Address</label>
                                    <input type="email" name="email" id="loginemail" required>
                                </div>
                                <div class="form-group">
                                    <label for="loginPassword">Password</label>
                                    <input type="password" name="password" id="loginPassword" required>
                                </div>
                                <div class="CTA">
                                    <input type="submit" value="Login">
                                    <a href="<?php echo site_url('user/register'); ?>" class="">I am new</a> 
                                    <a href="javascript:void(0)" data-toggle="modal" data-target="#myModal2" class="psw-for pull-right">Forgot Password? </a>
                                </div>
                            </form>
   
                        </div>
                        <div class="signup form-peice switched">
                            <form class="signup-form" action="#" method="post">
                           
                            <?php  /* ?>   
                                <div class="row">
                                    <div class="col-sm-6">
                                        <a href="#"><img class="img-responsive" src="<?php echo base_url('assets/site'); ?>/images/facebook_signin.png"></a>
                                    </div>
                                    <div class="col-sm-6">
                                        <a href="#"><img class="img-responsive" src="<?php echo base_url('assets/site'); ?>/images/twitter_signin.png"></a>
                                    </div>
                                </div>
                                <?php */ ?>
                                <div class="clearfix"></div>
                                <div class="form-group">
                                    <label for="name">Full Name</label>
                                    <input type="text" name="username" id="name" class="name">
                                    <span class="error"></span>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email Adderss</label>
                                    <input type="email" name="emailAdress" id="email" class="email">
                                    <span class="error"></span>
                                </div>
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" id="password" class="pass">
                                    <span class="error"></span>
                                </div>
                                <div class="form-group">
                                    <label for="passwordCon">Confirm Password</label>
                                    <input type="password" name="passwordCon" id="passwordCon" class="passConfirm">
                                    <span class="error"></span>
                                </div>
                                <div class="CTA">
                                    <input type="submit" value="Signup Now" id="submit">
                                    <a href="#" class="switch">I have an account</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </div>


<div class="modal fade" id="myModal2" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        
        <div class="modal-body">
        
      <form action="<?php echo site_url('user/forget'); ?>" method="POST">
        <div class="form-group">
           <h4 style="text-align: center;display: block;width:100%"> Reset your password </h4>
<p>Please enter the email address assoociated with your account, and we'll email you a link to reset your password. </p>
        <label for="email">Email address:</label>
        <input class="form-control" type="email" name="email" id="name" value="" class="name" required>
        </div>
        <button class="custom-btn" style="margin: 0 auto;display: block;" type="submit" >SEND RESET LINK</button>


      </form> 
        
      </div>

      
    </div>

     </div>
          </div>