<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php include("inc/header.php"); ?>

    <section class="htc__contact__area ptb--100 bg__white">
        <div class="container mt-5">
            <div class="row">
                <div class="col-md-6">
                    <div class="contact-form-wrap mt--60">
                        <div class="col-xs-12">
                            <div class="contact-title">
                                <h2 class="title__line--6 mt-5">forgot Password</h2>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <form id="login-form" method="post">
                                <div class="single-contact-form">
                                    <div class="contact-box name">
                                        <input type="text" name="email" id="email" placeholder="Your Email*"
                                            style="width:100%">
                                    </div>
                                    <span class="field_error" id="email_error" style="color:red;"></span>
                                </div>

                                <div class="contact-btn">
                                    <button type="button" class="fv-btn" id="btn_submit"
                                        onclick="forgot_password()">Submit</button>
                                        <button type="button" class="fv-btn ms-3" id="btn_login">go to login</button>
                                </div>
                               
                                   
                           
                                <script>
                                    document.getElementById('btn_login').addEventListener('click', function () {
                                        window.location.replace('login.php'); // Redirect to the login page
                                    });
                                </script>
                            </form>
                            <div class="form-output login_msg">
                                <p class="form-messege field_error"></p>
                            </div>
                        </div>
                    </div>

                </div>



            </div>
    </section>
    <?php include("inc/footer.php"); ?>

    <input type="hidden" id="is_email_verified" />
    <input type="hidden" id="is_mobile_verified" />
    <script>
        function forgot_password() {
            jQuery('#email_error').html('');
            var email = jQuery('#email').val();
            if (email == '') {
                jQuery('#email_error').html('Please enter email id');
            } else {
                jQuery('#btn_submit').html('Please wait...');
                jQuery('#btn_submit').attr('disabled', true);
                jQuery.ajax({
                    url: 'forgot_password_submit.php',
                    type: 'post',
                    data: 'email=' + email,
                    success: function (result) {
                        jQuery('#email_error').html(result);
                        jQuery('#btn_submit').html('Submit');
                        jQuery('#btn_submit').attr('disabled', false);
                    }
                });
            }
        }


    </script>
    <script src="custom.js"></script>
    <script src="jquery-3.2.1.min.js"></script>
    <script src="main.js"></script>



</body>

</html>