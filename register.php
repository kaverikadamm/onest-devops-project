<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration Page</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php include("inc/header.php"); ?>

    <section class="htc__contact__area ptb--100 bg__white">
        <div class="container mt-5 d-flex justify-content-center">
           
                <div class="col-md-6">
                    <div class="contact-form-wrap mt--60">
                        <div class="col-xs-12">
                            <div class="contact-title">
                                <h2 class="title__line--6 mt-5 mb-2 text-center ">Create an account</h2>
                                <p class="mb-5 text-center">Already a user? <a href="login.php">Log in</a></p>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <form id="register-form" method="post">
                                <div class="single-contact-form">
                                    <div class="contact-box name">
                                        <input type="text" name="name" id="name" placeholder="Your Name*"
                                            style="width:100%">
                                    </div>
                                    <span class="field_error" id="name_error"></span>
                                </div>
                                <div class="single-contact-form">
                                    <div class="contact-box name">
                                        <input type="text" name="email" id="email" placeholder="Your Email*"
                                            style="width:45%">


                                        <button type="button" class="fv-btn email_sent_otp height_60px"
                                            onclick="email_sent_otp()">Send OTP</button>

                                        <input type="text" id="email_otp" placeholder="OTP" style="width:45%"
                                            class="email_verify_otp">


                                        <button type="button" class="fv-btn email_verify_otp height_60px"
                                            onclick="email_verify_otp()">Verify OTP</button>

                                        <span id="email_otp_result"></span>
                                    </div>
                                    <span class="field_error" id="email_error"></span>
                                </div>
                             
                                <div class="single-contact-form">
                                    <div class="contact-box name">
                                        <input type="password" name="password" id="password"
                                            placeholder="Your Password*" style="width:100%">
                                    </div>
                                    <span class="field_error" id="password_error" ></span>
                                </div>

                                <div class="contact-btn ">
                                    <button type="button" class="fv-btn" onclick="user_register()" 
                                        id="btn_register">Create Account</button>
                                </div>
                            </form>
                            <div class="form-output register_msg">
                                <p class="form-messege field_error"></p>
                            </div>
                        </div>
                    </div>

                </div>

          
    </section>
    <?php include("inc/footer.php"); ?>

    <input type="hidden" id="is_email_verified" />
    <input type="hidden" id="is_mobile_verified" />
    <script>
        function email_sent_otp() {
            jQuery('#email_error').html('');
            var email = jQuery('#email').val();
            if (email == '') {
                jQuery('#email_error').html('Please enter email id');
            } else {
                jQuery('.email_sent_otp').html('Please wait..');
                jQuery('.email_sent_otp').attr('disabled', true);
                jQuery.ajax({
                    url: 'send_otp.php',
                    type: 'post',
                    data: 'email=' + email + '&type=email',
                    success: function (result) {
                        if (result == 'done') {
                            jQuery('#email').attr('disabled', true);
                            jQuery('.email_verify_otp').show();
                            jQuery('.email_sent_otp').hide();

                        } else if (result == 'email_present') {
                            jQuery('.email_sent_otp').html('Send OTP');
                            jQuery('.email_sent_otp').attr('disabled', false);
                            jQuery('#email_error').html('Email id already exists');
                        } else {
                            jQuery('.email_sent_otp').html('Send OTP');
                            jQuery('.email_sent_otp').attr('disabled', false);
                            jQuery('#email_error').html('Please try after sometime');
                        }
                    }
                });
            }
        }
        function email_verify_otp() {
            jQuery('#email_error').html('');
            var email_otp = jQuery('#email_otp').val();
            if (email_otp == '') {
                jQuery('#email_error').html('Please enter OTP');
            } else {
                jQuery.ajax({
                    url: 'check_otp.php',
                    type: 'post',
                    data: 'otp=' + email_otp + '&type=email',
                    success: function (result) {
                        if (result == 'done') {
                            jQuery('.email_verify_otp').hide();
                            jQuery('#email_otp_result').html('Email id verified');
                            jQuery('#is_email_verified').val('1');
                        } else {
                            jQuery('#email_error').html('Please enter valid OTP');
                        }
                    }

                });
            }
        }


    </script>
	<script src="custom.js"></script>
    <script src="jquery-3.2.1.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
        </script>
    
</body>

</html>