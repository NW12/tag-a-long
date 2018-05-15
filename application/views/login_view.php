
  <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SeeSPore</title>
        <link href="<?php echo base_url('assets/site'); ?>/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?php echo base_url('assets/site'); ?>/css/style.css" rel="stylesheet">
        <link href="<?php echo base_url('assets/site'); ?>/css/login-register.css" rel="stylesheet">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500" rel="stylesheet">
          <script src="<?php echo base_url('assets/site'); ?>/js/sweetalert.min.js"></script>
        <style type="text/css">
            .alert-danger {
    color: #a94442;
    background-color: #f2dede;
    border-color: #ebccd1;
    width: 76%;
    float: right;
    margin-right: 5px;
}
        </style>
    </head>

        <!-- top-header -->
 <?php echo htmlspecialchars_decode($content); ?>

  
   <script src=" https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js "></script>
    <script src="<?php echo base_url('assets/site'); ?>/js/bootstrap.js "></script>

           <script type="text/javascript">
               $('#Visitor-form').hide();
                        $('#Resident-form').hide();
                    $('input:radio[name="user"]').change(
                    function(){
                     if ($(this).is(':checked') && $(this).val() == 'Visitor') {
                        $('#Visitor-form').show();
                        $('#Resident-form').hide();
       }

        if ($(this).is(':checked') && $(this).val() == 'Resident') {
                        $('#Resident-form').show();
                        $('#Visitor-form').hide();
       }
                 
                    });
                            </script>
    <script>
        $(document).ready(function () {
            'use strict';
            var usernameError = true,
                    emailError = true,
                    passwordError = true,
                    passConfirm = true;
            if (navigator.userAgent.toLowerCase().indexOf('firefox') > -1) {
                $('.form form label').addClass('fontSwitch');
            }
            $('input').focus(function () {
                $(this).siblings('label').addClass('active');
            });
            $('input').blur(function () {
                if ($(this).hasClass('name')) {
                    if ($(this).val().length === 0) {
                        $(this).siblings('span.error').text('Please type your full name').fadeIn().parent('.form-group').addClass('hasError');
                        usernameError = true;
                    } else if ($(this).val().length > 1 && $(this).val().length <= 6) {
                        $(this).siblings('span.error').text('Please type at least 6 characters').fadeIn().parent('.form-group').addClass('hasError');
                        usernameError = true;
                    } else {
                        $(this).siblings('.error').text('').fadeOut().parent('.form-group').removeClass('hasError');
                        usernameError = false;
                    }
                }
                if ($(this).hasClass('email')) {
                    if ($(this).val().length == '') {
                        $(this).siblings('span.error').text('Please type your email address').fadeIn().parent('.form-group').addClass('hasError');
                        emailError = true;
                    } else {
                        $(this).siblings('.error').text('').fadeOut().parent('.form-group').removeClass('hasError');
                        emailError = false;
                    }
                }
                if ($(this).hasClass('pass')) {
                    if ($(this).val().length < 8) {
                        $(this).siblings('span.error').text('Please type at least 8 charcters').fadeIn().parent('.form-group').addClass('hasError');
                        passwordError = true;
                    } else {
                        $(this).siblings('.error').text('').fadeOut().parent('.form-group').removeClass('hasError');
                        passwordError = false;
                    }
                }
                if ($('.pass').val() !== $('.passConfirm').val()) {
                    $('.passConfirm').siblings('.error').text('Passwords don\'t match').fadeIn().parent('.form-group').addClass('hasError');
                    passConfirm = false;
                } else {
                    $('.passConfirm').siblings('.error').text('').fadeOut().parent('.form-group').removeClass('hasError');
                    passConfirm = false;
                }
                if ($(this).val().length > 0) {
                    $(this).siblings('label').addClass('active');
                } else {
                    $(this).siblings('label').removeClass('active');
                }
            });
            $('a.switch').click(function (e) {
                $(this).toggleClass('active');
                e.preventDefault();
                if ($('a.switch').hasClass('active')) {
                    $(this).parents('.form-peice').addClass('switched').siblings('.form-peice').removeClass('switched');
                } else {
                    $(this).parents('.form-peice').removeClass('switched').siblings('.form-peice').addClass('switched');
                }
            });
           
            $('a.profile').on('click', function () {
                location.reload(true);
            });
        });
    </script>

