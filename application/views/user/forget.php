<section class="gallery-bg">
  <div class="container">
    <div class="gallery-text">
      <h1>make the world your home</h1>
      <h2 class="header-page__title">Change password </h2>
    </div>
  </div>
</section>

	           <div class="reg-section" style="padding:40px 0px ">
           	      <!-- <div class="container">
                    <div class="check-caption">
  										<h2 align="center">Forget Password</h2>
  									</div>
                  </div>   -->
                      <div class="container">
                      <div class="row">
                        <div class="col-sm-6 col-sm-offset-3">
                           <div class="acc_caption mrg_tp_20">
                                <h4>Change Password</h4>
                           </div>
                           <form action="<?php echo base_url('home/userforgetpass'); ?>" method="post">
                            <div class="quick_response psrw_box">
                             
                              <div class="form-group">
                               <input class="form-control" type="Password" name="password" value="" placeholder="New Password" minlength="6" maxlength="20" required>
                               <input class="form-control" type="hidden" name="email" value="<?php echo $_GET['e']; ?>" placeholder="New Password" >
                              </div>
                             <div class="form-group">
                               <input class="form-control" type="Password" name="confirmpassword" value="" placeholder="Retype Password" minlength="6" maxlength="20" required>
                             </div>
                             <button type="submit" class="custom-btn">Change password</button>
                            </div>
                           </form>
                        </div>
                      </div>  
                        </div>
                        </div>
      
       