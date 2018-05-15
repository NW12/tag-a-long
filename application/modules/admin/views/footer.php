<?php

$currentPage = $this->uri->segment(2);

?>

<div class="footer">

    <div class="footer-inner">

        <div class="footer-content">

            <span class="bigger-120">

                <span class="blue bolder"><?php echo SITE_NAME?></span>

                &copy; <?php echo date("Y");?>

            </span>



            &nbsp; &nbsp;

            <span class="action-buttons">

                <a href="#">

                    <i class="ace-icon fa fa-twitter-square light-blue bigger-150"></i>

                </a>



                <a href="#">

                    <i class="ace-icon fa fa-facebook-square text-primary bigger-150"></i>

                </a>



                <a href="#">

                    <i class="ace-icon fa fa-rss-square orange bigger-150"></i>

                </a>

            </span>

        </div>

    </div>

</div>



<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">

    <i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>

</a>

</div><!-- /.main-container -->





<script src="<?php echo base_url('assets/admin/js/bootstrap.min.js');?>"></script>



<!-- page specific plugin scripts -->



<!--[if lte IE 8]>

  <script src="<?php echo base_url('assets/admin/js/excanvas.min.js');?>"></script>

  <![endif]-->

  <script src="<?php echo base_url('assets/admin/js/jquery-ui.custom.min.js');?>"></script>

  <script src="<?php echo base_url('assets/admin/js/jquery.ui.touch-punch.min.js');?>"></script>

  <script src="<?php echo base_url('assets/admin/js/chosen.jquery.min.js');?>"></script>

  <!--<script src="<?php echo base_url('assets/admin/js/fuelux.spinner.min.js');?>"></script>-->

  <script src="<?php echo base_url('assets/admin/js/bootstrap-datepicker.min.js');?>"></script>

  <script src="<?php echo base_url('assets/admin/js/moment.min.js');?>"></script>

  <script src="<?php echo base_url('assets/admin/js/jquery.inputlimiter.1.3.1.min.js');?>"></script>

  <!--<script src="<?php // echo base_url('assets/admin/js/jquery.maskedinput.min.js');?>"></script>-->

  <script src="<?php echo base_url('assets/admin/js/bootstrap-tag.min.js');?>"></script>



  <script src="<?php echo base_url('assets/admin/js/jquery.validate.min.js');?>"></script>



  <!-- ace scripts -->

  <script src="<?php echo base_url('assets/admin/js/ace-elements.min.js');?>"></script>

  <script src="<?php echo base_url('assets/admin/js/ace.min.js');?>"></script>





  <script src="<?php echo base_url('assets/admin/js/application.js');?>"></script>

  <!-- Custom scripts -->

  <script src="<?php echo base_url('assets/admin/js/custom/global.js');?>"></script>

  <script src="<?php echo base_url('assets/admin/js/custom/custom_functions.js');?>"></script>

</body>

</html>