<!-- <section class="gallery-bg">
  <div class="container">
    <div class="gallery-text">
      <h1>make the world your home</h1>
      <h2 class="header-page__title">Cart</h2>
    </div>
  </div>
</section> -->
<div id="wrap-page">
<section id="main"  class="woocommerce">
  <div class="section wo_shop">
    <div class="container">
    <!-- <h2 class="text-center">Your Selected Resident</h2> -->
<?php $carts = $this->cart->contents();  
if($carts > 0 && !empty($carts)):
echo form_open('cart/update_cart');


  foreach ($carts as $key => $cart) {
   $am = ($cart['amount'] * PERCENTAGE)/100;
    $image = explode(',', $cart['options']['image']);
              echo form_hidden('cart[' . $cart['id'] . '][id]', $cart['id']);
              echo form_hidden('cart[' . $cart['id'] . '][rowid]', $cart['rowid']);
              echo form_hidden('cart[' . $cart['id'] . '][name]', $cart['name']);
              echo form_hidden('cart[' . $cart['id'] . '][price]', $cart['price']);
             

?>
    <div class="row">
    	<div class="col-md-12">
        <div class="cart-page">
       	<div class="resident-img">
           <!--  <a href="javascript:void(0);"><img src="<?php echo base_url($image[0]); ?>"></a> 
            <ul id="imageGallery">
      <?php 
      $i = 0;
      foreach ($image as $key => $value): ?>
     
       <li data-thumb="<?php echo base_url($value); ?>" data-src="<?php echo base_url($value); ?>">
    <img src="<?php echo base_url($value); ?>">
  </li>

    <?php $i++; endforeach; ?>
</ul> -->
<div class="cart-title resident-title"><?php echo $cart['name'] ?></div>
            </div>
            <div class="table-responsive">
        <table class="shop_table cart cst-cart">
        <thead>
          <tr>
            <th class="product-name" style="min-width: 300px;">Address</th>
            <th class="product-quantity" style="max-width: 40px !important;padding: 15px 10px;">Persons</th>
            <th class="product-quantity" style="max-width: 40px !important;padding: 15px 10px;">Days</th>
            <th class="product-quantity">Date From</th>
            <th class="product-quantity">Date To</th>
            <th class="product-price">Amount</th>
            <th class="product-subtotal">Total</th>
          </tr>
        </thead>
        <tr class="cart_item">
          <td><?php echo $cart['options']['address'] ?></td>
          <td class="product-quantity"><div class="quantity">
              <input type="number" step="1" name="<?php echo 'cart['. $cart['id'] . '][persons]'; ?>" style="width: 70px !important;" min="1" max="<?php echo $cart['options']['persons']; ?>" value="<?php echo $cart['options']['persons']; ?>" title="Persons" class="input-text qty text"  pattern="[0-9]*">
            </div></td>
            <td class="product-quantity"><div class="quantity">
              <input type="number" min="1"  style="width: 70px !important;" value="<?php echo $cart['qty']; ?>" title="Days" class="input-text qty text"  name="<?php echo 'cart['. $cart['id'] . '][qty]'; ?>" id="qty" pattern="[0-9]*">
            </div></td>
            <td class="product-quantity"><div class="quantity">
               <input type="text" id="start_date" value="<?php echo $cart['options']['date_from']; ?>"  name="<?php echo 'cart['. $cart['id'] . '][date_from]'; ?>" class="hasDatepicker" required>
            </div></td>
            <td class="product-quantity"><div class="quantity">
              <input type="text" onchange="caldat();" id="end_date" value="<?php echo $cart['options']['date_to']; ?>"  name="<?php echo 'cart['. $cart['id'] . '][date_to]'; ?>" class="hasDatepicker" required>
            </div></td>
          <td class="product-price"><span class="amount"><span>$</span><?php echo $cart['price'] ?></span></td>

          <td class="product-subtotal" data-title="Total"><span class="amount"><span>$</span><?php echo $cart['amount']; ?></span></td>
        </tr>
        
        <tr>
          <td colspan="8" class="actions">
            <input type="submit" class="button" name="update_cart" value="Update Cart" ></td>
        </tr>
      </table>
        </div>
        
            </div>
    </div>
    
<div class="col-md-5 col-xs-12 pull-right ">  
      <div class="cart-collaterals cst-bg-clr">
      <div class="cart-title resident-title">Cart Totals</div>
        <div class="cart_totals">
         
          <table class="shop_table">
            <tbody>
            <!--   <tr class="cart-subtotal">
                <th>Subtotal</th>
                <td data-title="Subtotal"><span class="amount"><span>$</span><?php echo $cart['amount']; ?></span></td>
              </tr> -->
              <tr class="order-total">
                <th>Total (Resident will be charged)</th>
                <td data-title="Total"><strong> <span class="amount"><span>$</span><?php echo $cart['amount']; ?></span> </strong></td>
              </tr>
               <tr class="order-total">
                <th>Commission (You have to pay now) </th>
                <td data-title="Total"><strong> <span class="amount"><span>$</span><?php echo $am; ?></span> </strong></td>
              </tr>
            </tbody>
          </table>
           <?php 

       echo form_hidden('cart[' . $cart['id'] . '][options]', $cart['options']);
       echo form_close();   
     }
?> 
            <div class="cart-title-checkout">
        <h3>Payment Method</h3>
          </div>
        <div class="billing-info" style="padding-bottom:50px; ">
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
     <!--    <h4>Enter card information</h4> -->
  
  <div class="form-group row">
   <!--  <label  class="col-md-3 col-form-label">We Accepted</label> -->
    
  </div>
  
   <?php
 $data['total'] = $am;
    echo $this->load->view('cart/bank_view.php' , $data); ?>
  <div class="col-md-12" style="margin-bottom: 10px;" > <img style="margin: 0 auto; display: block;" src="<?php echo  base_url('assets/site') ?>/images/cards.jpg"> </div>
         </div> </div>
        </div>
      </div>
      </div>
        </div>
        
    
   
   <?php  else: ?>

       <div class="cart-empty">
        <h3>Cart Is Empty..!</h3>
        <a href="<?php echo site_url('residence'); ?>">Go To Residences</a>
              </div>
      
    <?php endif; ?>
   
    </div>
  </div>
</section>

    <script type="text/javascript">
       $(document).ready(function() {
    $('#imageGallery').lightSlider({
        gallery:false,
        item:1,
        loop:true,
        pause:4000,
        auto:true,
        pager: false,
        speed:4000,
        pauseOnHover:true ,
        mode:'fade',
        slideMargin:0,
        enableDrag: false,
        currentPagerPosition:'left',
        onSliderLoad: function(el) {

        }   
    });  
  });
  $( ".message-ex a" ).click(function() {
  $( ".message-cst" ).slideToggle( "slow", function() {
  });
});
    </script>

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
    <script type="text/javascript">
      function caldat(){
// end - start returns difference in milliseconds 
var start= $("#start_date").datepicker("getDate");
    var end= $("#end_date").datepicker("getDate");
    days = (end- start) / (1000 * 60 * 60 * 24);
    $("#qty").val(Math.round(days));
}
    </script>