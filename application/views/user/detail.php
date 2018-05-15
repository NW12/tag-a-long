<section class="gallery-bg">
  <div class="container">
    <div class="gallery-text">
      <h1>make the world your home</h1>
  
    </div>
  </div>
</section>
<?php //echo '<pre>'; print_r($result); exit; ?>
<!-- WRAPPER CONTENT--> 

<!-- WRAPPER--> 
<!-- MAIN CONTENT-->
<div class="main-content">
  <div class="container">
    <h3 class="title-style-2">Resident Detail</h3>
    <div class="row">
      <div class="col-md-4 col-sm-4  padding-col-right">
        <div class="content-team-detail">
          <div class="content-expert"> <a href="javascript:void(0);" class="img-expert"> <img src="<?php getImage($result[0]['photo']); ?>" alt="" class="img-responsive img"> </a>
           <!-- <div class="caption-expert">
               <div class="item-expert"> <i class="icon-expert fa fa-comment-o"></i> <a href="#" class="title">Talk to me!</a> </div> -->
           <!--    <ul class="social list-inline">
                <li> <a href="#" class="social-expert"> <i class="expert-icon fa fa-facebook"></i> </a> </li>
                <li> <a href="#" class="social-expert"> <i class="expert-icon fa fa-twitter"></i> </a> </li>
                <li> <a href="#" class="social-expert"> <i class="expert-icon fa fa-pinterest-p"></i> </a> </li>
                <li> <a href="#" class="social-expert"> <i class="expert-icon fa fa-google"></i> </a> </li>
              </ul> 
            </div>-->
          </div>
        </div>
      </div>
      <div class="col-md-8 col-sm-8  padding-col-left">
        <div class="wrapper-caption-team">
          <div class="wrapper-team-title"> <a href="#" class="team-title"><?php echo $result[0]['user_name']; ?></a>
            <p class="team-title-small">Resident</p>
            <div class="team-title-andress"> <i class="team-icon fa fa-map-marker"></i> <a href="#" class="item-andress"><?php echo $result[0]['country_or_nationality']; ?></a> </div>
          </div>
          <p class="text"> <?php echo $result[0]['description_user']; ?></p>
      <!--     <div class="group-list">
            <ul class="list-unstyled about-us-list">
              <li>
                <p class="text">See around 100 shows per year</p>
              </li>
              <li>
                <p class="text">Love sharing my knowledge with people from around the world</p>
              </li>
              <li>
                <p class="text">Have performed Off-Broadway with an Oscar nominee</p>
              </li>
              <li>
                <p class="text">Know the theatre business from every angle </p>
              </li>
            </ul>
          </div> -->
        </div>
      </div>
    </div>
  </div>
  <section>
    <div class="hotel-view-main padding-top padding-bottom">
      <div class="container">
        <div class="journey-block">
          <h3 class="title-style-2">Available Residence<!-- <span> (sale off 30%)</span> --> </h3>
          
          <div class="overview-block clearfix">
            <div class="timeline-container">
              <div class="timeline timeline-hotel-view">
            <?php foreach ($result as $key => $value) {
              $img = explode(',', $value['default_image']); 
             ?>
                <div class="timeline-block">
                  <div class="timeline-title"> <span><?php echo $value['name']; ?></span> </div>
                  <div class="timeline-point"> <i class="fa fa-circle-o"></i> </div>
                  <div class="timeline-content">
                    <div class="row">
                      <div class="timeline-custom-col">
                        <div class="image-hotel-view-block">
                          <div class="slider-for group1">
                            <div class="item"> <img src="<?php echo base_url($img[0]); ?>" alt=""> </div>
                          </div>
                        </div>
                      </div>
                      <div class="timeline-custom-col image-col hotels-layout">
                        <div class="content-wrapper">
                          <div class="row">
                        <div class="col-sm-6">
                        <div class="content">
                            <div class="title">
                              <div class="price"> <sup>$</sup> <span class="number"><?php echo $value['perday_price']; ?></span> </div>
                              <p class="for-price">For One Day</p>
                            </div>
                            <p class="text"><?php echo $value['description']; ?></p>
                            <div class="group-btn-tours"> <a href="<?php echo site_url('residence').'/'.$this->common->encode($value['residence_id']); ?>" class="left-btn btn-book-tour">View Detail</a> </div>
                          </div>
                        </div>
                        <div class="col-sm-6">
                         <div class="location-map"></div>

                        </div>
                        </div>
                        </div>
                      </div>
                      
                      
                    </div>
                  </div>
                </div>

                <?php } ?>
                
        
              </div>
            </div>
          </div>
        </div>
      </div>
      
    </div>
  </section>
</div>