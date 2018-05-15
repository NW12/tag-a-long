<style>
    .btn-default:hover {
        color: #333;
        background-color: #4c4c4c;
        border-color: #adadad;
        color: white;
    }.modal {
        text-align: center;
        padding: 0!important;
    }
    .lighten-login:hover{
      background-color: #940000;
      color: #fff;
    }
    .lighten-login{background-color: #ddd;font-weight: bold;color: #000;transition: all 0.3s;}

    .modal:before {
        content: '';
        display: inline-block;
        height: 100%;
        vertical-align: middle;
        margin-right: -4px;
    }

    .modal-dialog {
        display: inline-block;
        text-align: left;
        vertical-align: middle;
    }
    .pd-0{
      float: none;
      margin:60px auto;
      margin-bottom: 0;
    }
</style>
    <div id="loading_img_credit"> </div>
  <div id="stripformerrorcontainer" style="display: none" class="alert-form alert-box">
                                                            <ul id="stripformerrors"></ul>
                                                        </div>

            <form id="payment-form" method="post" action="<?php echo base_url('bank/stripe_charge'); ?>"  >


                <h5 style="margin-bottom: 14px;font-weight: 600;">Enter Card Details</h5>

                <div class="form-group">
                    <label for="name_on_ccard" class="sr-only">Name on Card</label>
                    <input id="name_on_ccard" type="text" value=""  name="name_on_ccard" class="form-control" placeholder="Name on Card" required="required">
                </div>

                    <div class="form-group">

                        <label for="card_number" class="sr-only">Card Number</label>
                        <input type="text" size="20" data-stripe="number" id="ccard_number" name="ccard_number" class="form-control" placeholder="Card Number" required="" maxlength="16" value="">
                    </div>

                <div class="row">

                    <div class="col-xs-4 mg-rit-lef-00">
                        <div class="form-group">

                            <input type="text" value="" id="stripe_expire_month" data-stripe="exp_month" name="expire_month" class="form-control" placeholder="MM" required="">

                        </div>
                    </div>

                    <div class="col-xs-4 mg-rit-lef-00">
                        <div class="form-group">

                            <input type="text" value="" id="stripe_expire_year" data-stripe="exp_year" name="expire_year" class="form-control" placeholder="YYYY" required="">

                        </div>
                    </div>


                        <div class="col-xs-4 mg-rit-lef-01">
                            <div class="form-group">

                                <input type="text" value="" id="stripe_cvv" data-stripe="cvc" name="cvv" class="form-control" placeholder="CVV" required="">
                            </div>
                        </div>

                </div>





                                                                <!--MODAL-->
    <button type="button" class="btn btn-lg lighten-login  btn-block submit" type="button" onclick="payByCredit()" data-toggle="modal" >Pay $ <?php echo $total; ?><span class="amount_btn_bal"></span>
    </button>




            </form>











<script type="text/javascript" src="https://js.stripe.com/v2/"></script>

<script type="text/javascript">
    Stripe.setPublishableKey('<?php echo STRIPE_PK; ?>');
</script>