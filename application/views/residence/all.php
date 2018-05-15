<section id="main">
  <div class="section p-top-50">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <div class="from-wide-listing cst_listing_search">
            <form action="<?php echo site_url('search'); ?>" method="get" class="form form--listing">
              <div class="form-item item--search">
                <label class="label">What are you looking for?</label>
                <span class="input-text input-icon-inside form-group">
                <input type="text" name="search" value="<?php echo $_GET['search']; ?>" class="form-control">
                <button class="submit_btn" type="submit"> <i class="input-icon icon_search"></i></button>
                </span> 
              </div>
             
             
            
            </form>
          </div>
         
          <div class="listings listings--grid wil-multiple">
            <?php if(empty($results)): ?>
 <div class=" col-md-12" style="margin-left: 25px;margin-top:15px; text-align: center;"><h3>No Record Found!</h3></div>
    </div>
            <?php else: ?>
            <div class="row" data-col-lg="3">
              <?php foreach ($results as $key => $value) {
                $imgs = explode(',', $value->default_image);
                $srcs = str_replace('residence', 'thumb', $imgs[0]);
                if(file_exists(base_url($srcs))){
                  $src = $srcs;
                }else{
                  $src =$imgs[0];
                }
               ?>
             
              <div class="col-sm-6 col-lg-4">
                <div class="listing listing--grid">
                  <div class="listing__media"> <a title="<?php echo $value->name; ?>" href="<?php echo site_url('residence').'/'.$this->common->encode($value->residence_id); ?>"> <img src="<?php echo base_url($src); ?>" alt="<?php echo $value->name; ?>" > </a>
                 <!--    <div class="listing__cat"> <a href="residence-detail.html">Hotel &amp; Travel</a> <span class="listing__cat-more">+</span>
                      <ul class="listing__cats">
                        <li> <a href="#">Restaurant</a> </li>
                        <li> <a href="#">Education</a> </li>
                        <li> <a href="#">Entertainment</a> </li>
                      </ul>
                    </div> -->
                    </div>
                  <div class="listing__body">
                    <div class="listing__author"> <a href="<?php echo site_url('resident').'/'.$this->common->encode($value->id); ?>"> <img src="<?php getImage($value->photo); ?>"  > </a> </div>
                    <h3 class="listing__title"><a title="<?php echo $value->name; ?>" href="<?php echo site_url('residence').'/'.$this->common->encode($value->residence_id); ?>"><?php echo $value->name; ?></a></h3>
                   <!--  <div class="listgo__rating"> <span class="rating__number">4.0</span> <span class="rating__star"> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star-o"></i> </span> </div> -->
                    <div class="listing__content">
                      <address>
                      <div class="list-con-des"><span><i class="fa fa-map-marker"></i></span> <?php echo $value->addrs; ?></div> 
                      <div class="list-con-des"><span><i class="fa fa-phone"></i></span>  <?php echo $value->telephone; ?></div>
                      </address>
                    </div>
                    <div class="item__actions">
                      <div class="tb">
                        <div class="tb__cell cell-large"> <a href="<?php echo site_url('residence').'/'.$this->common->encode($value->residence_id); ?>">View detail</a> </div>
                        
                      </div>
                    </div>
                  </div>
                </div>
              </div>

             <?php  } ?>
          
             
            
          
             
         <?php endif; ?>
            </div>
            <!----PAGINATION-->
    <nav class="pagination-list margin-top70">
      <?php echo $pagination; ?>
          
               </nav>
    <!----END OF PAGINATION -->
          </div>
        </div>
      </div>
    </div>
  </div>
</section>