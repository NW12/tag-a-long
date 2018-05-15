<style type="text/css">
.img-div img {
    width: 100% !important;
}
div#image_preview img {
    width: 20%;
    float: left;
    height: 100px;
    margin: 5;
}
.img-div {
    display: inline-block;
    width: 20%;
    position: relative;
    float: left;
    margin: 6px 8px 16px 0;
}

.img-div span {
   position: absolute;
    font-size: 15px;
    color: red;
    right: 1%;
    top: 5%;
    font-weight: bold;
    background: #fff;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    line-height: 17px;
    text-align: center;}
.cst_time_picker input[type=checkbox]{
  width:23px;
  float: left;
}
</style>
<?php $this->load->view('user/user_header_resident' , $userdata); ?>

  <!-------ADD LISTING FORM -->
  <div class="add-listing-section" style="background-color: #f5f5f5" >
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-lg-offset-2">
          <h2 class="author-page__title"> <i class="icon_pencil-edit"></i> Add Residence </h2>
            <form action="<?php echo site_url('user/residentupdate') ?>" method="post" enctype="multipart/form-data">
          <div class="account-page">
            <div class="form form--listing">
              <h4 class="profile-title">Residence</h4>
            <input type="hidden" name="residence_id" value="<?php echo $row->residence_id; ?>">
              <div class="row">
                <div class="col-sm-12">
                  <div class="form-item ">
                    <label class="label">Residence Name <sup>*</sup></label>
                    <span class="input-text">
                    <input type="text" name="name" value="<?php echo $row->name; ?>" required>
                    </span>  </div>
                </div>
               
                 <div class="col-sm-6">
                    <div class="form-item"> <span class="input-text">
                      <input type="text" id="address" placeholder="Address" name="address" required value="<?php echo $row->address; ?>"  >
                      </span> </div>
                      <input type="hidden" id="city" name="city" value="<?php echo $row->city; ?>"  />
                      <input type="hidden" id="country" name="country_id" value="<?php echo $row->country_id; ?>"  />
                      <input type="hidden" id="city2" name="city2"   />
<input type="hidden" id="cityLat" name="latitude" value="<?php echo $row->latitude; ?>"  />
<input type="hidden" id="cityLng" name="longitude" value="<?php echo $row->longitude; ?>"  />  
                  </div>
                  <div class="col-sm-6">
                    <div class="form-item"> <span class="input-text">
                      <input type="text" placeholder="Nearest MRT Station" name="mrt_station" value="<?php echo $row->mrt_station; ?>"  required>
                      </span> </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-item"> <span class="input-text">
                      <input type="text" placeholder="Maximum Persons" name="maximum_persons" value="<?php echo $row->maximum_persons; ?>"  required>
                      </span> </div>
                  </div>
                   <div class="col-sm-6">
                    <div class="form-item"> <span class="input-text">
                      <input type="text" placeholder="Per day Fare" value="<?php echo $row->perday_price; ?>" name="perday_price" required>
                      </span> </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-item"> <span class="input-text">
                      <input type="text" value="<?php echo $row->cusine; ?>"  placeholder="Cuisine" name="cusine" required>
                      </span> </div>
                  </div>

                   
                    
                            <div class="col-sm-12"> 
                <label class="label">Day & Time of visit</label>


             
                  <?php  $days = array();
    for ($i = 0; $i < 7; $i++) {
        $days[$i] = jddayofweek($i,1);
    }

    $dayss = explode(',', $row->dateofvisit);
        $timeto = explode(',', $row->totimeofvisit);
        $timefrom = explode(',', $row->fromtimeofvisit);
      foreach ($days as $key => $valu) {
       if(in_array($key, $dayss)){
        $dyaexist = 'checked';
      }else{
         $dyaexist = '';
      }

     ?>
        <div class="row depart-at active cst_time_picker" id="depart-at">
                  <div class="col-sm-4"> <span class="input-text input-icon-inside">
                    <input class="" value="<?php echo $key; ?>"  type="checkbox" name="dateofvisit[<?php echo $key; ?>]" <?php echo $dyaexist; ?> >
                   <?php echo $valu; ?> </span> </div>
                  <div class="col-sm-4 col-xs-6"> <span class="input-text input-icon-inside">
                    <input value="<?php echo $timefrom[$key]; ?>" type="text" placeholder="From" name="fromtimeofvisit[<?php echo $key; ?>]" class="timepick" >
                    <i class="input-icon icon_clock_alt"></i> </span> </div>
                    <div class="col-sm-4 col-xs-6"> <span class="input-text input-icon-inside">
                    <input value="<?php echo $timeto[$key]; ?>" type="text" placeholder="To" name="totimeofvisit[<?php echo $key; ?>]" class="timepick" >
                    <i class="input-icon icon_clock_alt"></i> </span> </div>
                </div>

<?php
                 }

     ?>
     </div>
                <div class="col-sm-12">
                  <div class="form-item">
                    <label class="label">Description</label>
                    <span class="input-text">
                    <textarea rows="4" cols="10" name="description"  required><?php echo $row->description; ?> </textarea>
                    </span> </div>
                </div>
                
              
                <div class="col-sm-12">
                  <div class="form-item gallery">
                    <label class="label">Add Gallery</label>
                    <div class="wil-addlisting-gallery">
                      <input type="file" id="upload_file" name="upload_file[]" onchange="preview_image();" multiple accept="image/*" />
                             <div id="image_preview">
                               <?php 
                               if(!empty($row->default_image)):
                               $imgs = explode(',', $row->default_image);
                                  foreach ($imgs  as $k => $img): ?> 
                                  <div class="img-div" id="im<?php echo $k; ?>">
                                    <span onclick="delimg('<?php echo $img; ?>', '<?php echo $k; ?>');">x</span>
                                  <img src="<?php echo base_url($img); ?>">
                                </div>
                                <?php endforeach; 
                                endif; ?>

                             </div>
                    </div>
                  </div>
                </div>
                <div class="col-sm-12">
                
                 <label class="label">Speciality</label>
                <div class="form-item item--avoid">
                  <?php foreach ($speciality as $value): ?>
                  <?php $spc = explode(',', $row->speciality); ?> 
                <label class="input-checkbox">
                <input type="checkbox" name="speciality[<?php echo $value->id; ?>]" value="<?php echo $value->id; ?>" <?php if(in_array($value->id,  $spc)){ echo 'checked'; }else{ echo ''; } ?> >
                <span></span>
                <?php echo ucwords($value->name); ?>
                </label>

              <?php endforeach; ?>
                </div>
                </div>

                 <div class="form-group">
                <label class="control-label col-xs-12 col-sm-3 no-padding-right">Status *</label>
                <div class="col-xs-12 col-sm-9">
                    <div>
                        <label class="blue">
                            <input type="radio" id="status" class="ace" <?php echo ( isset($row) && isset($row->status) == 1) ? 'checked' : '' ?> value="1" name="status" required>
                            <span class="lbl">&nbsp;Active</span>
                        </label>
                    </div>
                    <div>
                        <label class="blue">
                            <input type="radio" class="ace" <?php echo ( isset($row) && isset($row->status) == 0) ? 'checked' : '' ?> id="status" value="0" name="status" required>
                            <span class="lbl">&nbsp;Inactive</span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="space-2"></div>
              </div>

              <div class="row">
                <div class="col-sm-12">
                  <div class="profile-actions">
                  <input type="reset" onclick="oldurl();" class="listgo-btn  listgo-btn--sm" value="Cancel">
                    <input type="submit" class="listgo-btn btn-primary  listgo-btn--sm" value="Save">
                  </div>
                </div>
              </div>
            
            </div>
          </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div style="display:none" id="garbage">
  </div>

 
  <script type="text/javascript">

    function oldurl(){
      location = ' <?php echo site_url('residence').'/'.$this->common->encode($row->residence_id); ?>';
    }

        function preview_image() 
{
 var total_file=document.getElementById("upload_file").files.length;
 for(var i=0;i<total_file;i++)
 {
  $('#image_preview').append("<img src='"+URL.createObjectURL(event.target.files[i])+"'>");
 }
}
  </script>

  <script src="http://maps.googleapis.com/maps/api/js?key=<?php echo GOOGLE_MAP_KEY; ?>&libraries=places" type="text/javascript"></script>

<script type="text/javascript">
    function initialize() {
        var input = document.getElementById('address');
        var autocomplete = new google.maps.places.Autocomplete(input);
        google.maps.event.addListener(autocomplete, 'place_changed', function () {
            var place = autocomplete.getPlace();
           $('#garbage').html(place.adr_address);

            document.getElementById('city2').value = place.name;
            document.getElementById('city').value = $('.locality').text();
            document.getElementById('country').value = $('.country-name').text();
            document.getElementById('cityLat').value = place.geometry.location.lat();
            document.getElementById('cityLng').value = place.geometry.location.lng();
        });
    }


    google.maps.event.addDomListener(window, 'load', initialize); 
</script>
<script type="text/javascript">
  function delimg(img , idss){
  
    imagesarray = '<?php echo $row->default_image; ?>';    
    var sp = imagesarray.split(",");       
       y = jQuery.grep(sp, function(value) {
           return value != img;
        });
var r = confirm("Are You Sure.?");
if (r == true) {
     URL = BASE_URL + 'user/delete_img';
     id = '<?php echo $row->residence_id; ?>';
        $.ajax({
            type: "POST",
            url: URL,
            data: {'default_image': y , 'id' : id},
            success: function (data) {                
                $('#im'+idss).remove();
            }
        });
} 
    
  }
</script>