<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User login Page</title>
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
                            <!---<h2 class=" mt-5 text-center">Please register to login</h2>-->
                                <h2 class="title__line--6 mt-5 text-center">Login to your account</h2>
                            </div>
                        </div>
                        <div class="col-xs-12">
                            <form id="login-form">
                                <div class="single-contact-form">
                                    <div class="contact-box name">
                                        <input type="email" required name="login_email" id="login_email" placeholder="Your Email*"
                                            style="width:100%">
                                    </div>
                                    <span class="field_error" id="login_email_error"></span>
                                </div>
                                <div class="single-contact-form">
                                    <div class="contact-box name">
                                        <input type="password" required name="login_password" id="login_password"
                                            placeholder="Your Password*" style="width:100%">
                                    </div>
                                    <span class="field_error" id="login_password_error"></span>
                                </div>

                                <div class="contact-btn">
                                    <button type="button" class="fv-btn" onclick="user_login()">Login</button>
                                    <a class="ms-3 mb-3 " href="forgot_password.php">forgot Password</a>
                                </div>
                            </form>
                            <div class="form-output login_msg">
                                <p class="form-messege field_error"></p>
                            </div>
                        </div>
                    </div>

                </div>


                
    </section>
    <?php include("inc/footer.php"); ?>

   
	<script src="custom.js"></script>
    <script src="jquery-3.2.1.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
        </script>
    
</body>

</html>