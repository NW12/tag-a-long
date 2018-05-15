<section class="gallery-bg">
  <div class="container">
    <div class="gallery-text">
      <h1>make the world your home</h1>
    </div>
  </div>
</section>
<div id="wrap-page">
<section id="main"  class="woocommerce">
  <div class="wo_shop cart-chechk">
    <div class="container">
    <!------- CART -->
    <div class="row">
    	<div class="col-md-8 col-md-offset-2">
        <div class="box-checkout">
        <div class="cart-title-checkout">
        <h3>Selected Resident</h3>
        </div>
        <div class="cart-page">
     
        <ul class="checkout-detail">
        	<?php foreach ($this->cart->contents() as $cart) { 
        	$am = ($cart['amount'] * PERCENTAGE)/100; ?>
        	<li><span>Resident:</span> <span class="right"><?php echo $cart['name']; ?></span></li>
            <li><span>Address:</span> <span class="right"><?php echo $cart['options']['address']; ?></span></li>
            <li><span>Persons:</span> <span class="right"><?php echo $cart['options']['persons']; ?></span></li>
            <li><span>Days:</span> <span class="right"><?php echo $cart['qty']; ?></span></li>
            <li><span>Amount:</span> <span class="right">$ <?php echo $am; ?></span></li>
          <?php  } ?>
        </ul>
        </div>
        <div class="cart-title-checkout">
        <h3>Please select how would you like to pay</h3>
          </div>
        <div class="billing-info">
        <div class="billing-method">
        
        		<div class="form-item">
                      <label class="input-radio">
                        <input name="method" id="Paypal" type="radio">
                        <span></span>Paypal </label>
                      <label class="input-radio">
                        <input name="method" id="card" type="radio">
                        <span></span>Credit Card </label>
             </div>
        </div>
        <div id="paypal-div" style="display: none;">
          <a href="<?php echo site_url('cart/payment'); ?>">Checkout with
          <span><img src="<?php echo base_url('assets/site/img/paypal.png') ?>" class="img-responsive"></span>
        </a>
      </div>
        <div class="billing-method" id="card-div" style="display: none;">
        <h5>Enter card information</h5>
  
  <div class="form-group row">
    <label  class="col-md-3 col-form-label">We Accepted</label>
    <div class="col-md-9"> <img src="<?php echo  base_url('assets/site') ?>/images/cards.jpg"> </div>
  </div>
  
   <?php
 $data['total'] = $am;
    echo $this->load->view('cart/bank_view.php' , $data); ?>
  
         </div>
        </div>
        </div>
    </div>
    </div>
    </div>
    </div>
    </section>

    <script type="text/javascript">
    	$( "#card" ).click(function() {
$("#card-div").show();
$("#paypal-div").hide();
});
    	$( "#Paypal" ).click(function() {
$("#paypal-div").show();
$("#card-div").hide();
});
    	
    </script>