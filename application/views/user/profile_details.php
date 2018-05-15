<style type="text/css">
input[type="file"] {
    display: none;
}
</style>
<section class="gallery-bg profile-info-page">
  <div class="container">
    <div class="row">
      <div class="col-md-8 col-md-offset-2">
        <form id="regForm" action="<?php echo site_url('user/profile_details'); ?>" method="post">
          <input type="hidden" name="user_role" id="user_role">
          <!-- One "tab" for each step in the form: -->
          <div class="tab">
            <h3>Who you are?</h3>
            <div class="row">
              <div class="col-sm-6"> <a href="javascript:void(0);" onclick="checkuser(1);" class="user-box">
                <div class="user-img"> <img src="<?php echo base_url('assets/site'); ?>/images/visitor-icon.png"> </div>
                <h4 >Visitor</h4>
                </a> </div>
              <div class="col-sm-6"> <a onclick="checkuser(2);" href="javascript:void(0)" class="user-box">
                <div class="user-img"> <img src="<?php echo base_url('assets/site'); ?>/images/resident-icon.png"> </div>
                <h4 > Resident</h4>
                </a> </div>
            </div>
          </div>
          <div class="tab">
            <h3>Personal Information</h3>
            <div class="account-page">
              <div class="form form--profile">
                <!-- <label class="input-toggle fr"> Public profile &nbsp;
                  <input type="checkbox">
                  <span></span> </label> -->
                <div class="row">
                  <div class="col-sm-4">
                    <div class="profile-avatar"> <img src="<?php echo base_url('assets/site'); ?>/images/avatar/4.jpg" alt="">
                      <div class="profile-avatar__change"> <i class="fa fa-camera"></i> <a href="javascript:void(0);" onclick="uploadImg();">Change Avatar</a> <input type="file" name="photo" id="imgupload"> </div>
                    </div>
                  </div>
                  <div class="col-sm-8">
                    <div class="form-item"> <span class="input-text">
                      <input type="text" value="<?php echo $this->session->userdata('user_name'); ?>" placeholder="Full Name" readonly="readonly">
                      </span> </div>
                    <div class="form-item"> <span class="input-text">
                      <input type="email" value="<?php echo $this->session->userdata('email'); ?>" placeholder="Email" readonly="readonly">
                      </span> </div>
                    <div class="form-item ">
                      <label class="input-radio">
                        <input name="sex" type="radio">
                        <span></span> Female </label>
                      <label class="input-radio">
                        <input name="sex" type="radio">
                        <span></span> Male </label>
                    </div>
                  </div>
                </div>
                <div class="clearfix"></div>
                <div class="row">
                  <div class="col-md-4 col-sm-6">
                    <div class="form-item"> <span class="input-text">
                      <input type="text" name="religion" placeholder="Religion" required>
                      </span> </div>
                  </div>
                  <div class="col-md-4 col-sm-6">
                    <div class="form-item"> <span class="input-text">
                      <input type="text" name="race" placeholder="Race" required>
                      </span> </div>
                  </div>
                  <div class="col-md-4 col-sm-6">
                    <div class="form-item"> <span class="input-text">
                      <input type="text" name="language" placeholder="Language" required>
                      </span> </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-item"> <span class="input-text">
                      <input type="text" name="address" required placeholder="Address">
                      </span> </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-item"> <span class="input-text">
                      <input type="text" placeholder="Phone" name="telephone" required>
                      </span> </div>
                  </div>
                  <div class="col-sm-12">
                    <div class="form-item"> <span class="input-text">
                      <textarea rows="4" cols="10" placeholder="Descriptions"></textarea>
                      </span> </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="tab">
            <h3>Residence Information</h3>
            <div class="account-page">
              <div class="form form--profile">
                <div class="row">
                  <div class="col-sm-6">
                    <div class="form-item"> <span class="input-text">
                      <input type="text" name="nearest_mrt_station" placeholder="Nearest MRT Station">
                      </span> </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-item"> <span class="input-text">
                      <input type="text" name="maximum_persons" placeholder="Maximum Persons">
                      </span> </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-item"> <span class="input-text">
                      <input type="text" name="any_cuisine_preference" placeholder="Cusine">
                      </span> </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-item"> <span class="input-text">
                      <input type="text" name="any_specialty" placeholder="Speciality">
                      </span> </div>
                  </div>
                </div>
                <label class="label">Date & Time of Availability</label>
                <div class="row depart-at active" id="depart-at">
                  <div class="col-xs-6"> <span class="input-text input-icon-inside">
                    <input class="input-datepicker hasDatepicker" value="" id="dp1519043639339" type="text" name="days_availability_and_preferred_time">
                    <i class="input-icon icon_table"></i> </span> </div>
                  <div class="col-xs-6"> <span class="input-text input-icon-inside">
                    <input value="08:00" type="text" class="timepick" name="time">
                    <i class="input-icon icon_clock_alt"></i> </span> </div>
                </div>
              </div>
            </div>

          </div>
          <div class="tab">
            <div class="text-center">
              <h5 class="update-status success-msg"><i class="fa fa-check-circle"></i> Thank you! All information is updated successfully.</h5>
              <button type="button" class="listgo-btn btn-primary listgo-btn--round">Go To Dashboard</button>
            </div>
          </div>
          <div style="overflow:auto;">
            <div style="float:right;">
              <button class="listgo-btn btn-default listgo-btn--sm listgo-btn--round" type="button" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
              <button class="listgo-btn btn-primary listgo-btn--sm listgo-btn--round" type="button" id="nextBtn" onclick="nextPrev(1)">Next</button>
              <button type="submit" id="sb" class="listgo-btn btn-primary listgo-btn--sm listgo-btn--round">Submit</button>
            </div>
          </div>
          <!-- Circles which indicates the steps of the form: -->
          <div style="text-align:center;margin-top:40px;"> <span class="step"></span> <span class="step"></span> <span class="step"></span> <span class="step"></span> </div>
        </form>
      </div>
    </div>
  </div>
</section>

<script type="text/javascript">
var currentTab = 0; 
showTab(currentTab); 
$('#sb').hide();
function showTab(n) {

  var x = document.getElementsByClassName("tab");
   x[n].style.display = "block";

  if (n == 0) {
    document.getElementById("prevBtn").style.display = "none";
    document.getElementById("nextBtn").style.display = "none";
  } else {
    document.getElementById("prevBtn").style.display = "inline";
     document.getElementById("nextBtn").style.display = "inline";
  }
  if (n == (x.length - 2)) {
    document.getElementById("nextBtn").innerHTML = "Submit";
    $('#nextBtn').hide();
    $('#sb').show();
  } else {
    document.getElementById("nextBtn").innerHTML = "Next";
  }
   fixStepIndicator(n);

}

function nextPrev(n) {
  $('#sb').hide();
  var x = document.getElementsByClassName("tab");
  x[currentTab].style.display = "none";
  currentTab = currentTab + n;

  if (currentTab >= x.length) {
    document.getElementById("regForm").submit();
    return false;
  }
  showTab(currentTab);
}

function validateForm() {

  var x, y, i, valid = true;
  x = document.getElementsByClassName("tab");
  y = x[currentTab].getElementsByTagName("input");
  for (i = 0; i < y.length; i++) {

    if (y[i].value == "") {
      y[i].className += " invalid";
      valid = false;
    }
  }
  if (valid) {
    document.getElementsByClassName("step")[currentTab].className += " finish";
  }
  return valid;
}

function fixStepIndicator(n) {
  var i, x = document.getElementsByClassName("step");
  for (i = 0; i < x.length; i++) {
    x[i].className = x[i].className.replace(" active", "");
  }
  x[n].className += " active";
}


function checkuser(role){
  $("#user_role").val(role);
  nextPrev(1);

}

function uploadImg(){
  $("#imgupload").click();
}
</script>