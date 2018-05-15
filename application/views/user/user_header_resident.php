<?php  $userdata = $this->session->userdata(); ?> 
<style type="text/css">
   .header-page__account {margin-top: 50px;}
.gallery-bg {margin-bottom: 0px;    height: 140px;opacity: 0.9; }
.nav li a {font-size: 18px;}
.account-nav__addlisting.pull-right a {text-transform: uppercase;font-size: 16px;}
.cancel-btn {padding: 9px 30px;}
.menu-list{margin-bottom: 0px;}
</style>
<section class="gallery-bg">
  <div class="container">
<!--     <div class="gallery-text">
      <h1>make the world your home</h1>
    </div> -->
    <div class="header-page__account">
      <div class="header-page__account-avatar"> <img src="<?php  getImage($userdata['photo']); ?>" alt="">
        <h4 class="header-page__account-name"><?php echo $userdata['user_name']; ?></h4>
        <span class="member-item__role role--admin"> <i class="fa fa-gitlab"></i> <?php echo $userdata['user_role'] == '1' ? 'Visitor':'Resident'; ?> </span> </div>
 
    </div>
  </div>
</section>

<section class="dashboard-section">
  <div class="menu-list">
    <div class="container">
    <!-----------TABS LIST---------->
      <ul class="nav nav-tabs dashboard-menu">
   
        <?php if($userdata['user_role'] == 2){ ?>
        <div class="account-nav__addlisting pull-right"> <a href="<?php echo site_url('user/dashboard'); ?>" class="listgo-btn btn-primary listgo-btn--sm listgo-btn--round">Go To Dashboard</a> </div>
        <?php } ?>
      </ul>
      <!-----------END OF TAB LIST---------->
    </div>
  </div>