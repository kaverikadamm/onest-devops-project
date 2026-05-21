<?php
require ("Admin/inc/scripts.php");


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>contact page</title>
    <!-- Option 1: Include in HTML -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        .container2 {
            background-color: rgb(212, 211, 243);
        }



    </style>
</head>
<section class="container2">

    <body class=" bg-light">
        <?php
        include ("inc/header.php")
            ?>
        <div class="my-5 px-4">
            <h2 class="fw-bold h-font text-center"> CONTACT US</h2>
        </div>
        <div class="h-line bg-dark"></div>
        <p class="text-center  mt-3">
            Tell us more and we'll find best solution for you.
        </p>
        <div class="container">
            <div class="row">

                <div class="col-lg-6 col-md-6 mb-5 px-4 mt-5">
                    <div class="bg-white rounded shadow p-4">
                        <iframe class="w-100 rounded mb-4" height="320px"
                            src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7627.949959522347!2d73.6228428!3d17.0738765!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3bc1e667acc66599%3A0xe0c819be10aa2753!2sO&#39;NEST%20Luxury%20Homestay!5e0!3m2!1sen!2sin!4v1776868565021!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"                       
                            loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        <h5>Address</h5>
                        <a href="https://maps.app.goo.gl/VNADBw4APD88MztR6" target="_blank"
                            class="d-inline-block text-decoration-none text-dark mb-4">
                            <i class="bi bi-geo-alt-fill"></i> Ozare Road, Sanmitra Nagar, Devrukh, Maharashtra 415804
                        </a>


                        <h5 class="">Call us</h5>
                        <a href="tel: +917776668887" class="d-inline-block mb-2 text-decoration-none text-dark">
                            <i class="bi bi-telephone-fill"></i>+918378987789
                        </a>
                        <br>
                        <a href="tel: +91777998875" class="d-inline-block mb-2 text-decoration-none text-dark">
                            <i class="bi bi-telephone-fill"></i> +918378987789
                        </a>


                        <h5 class="mt-4">Email</h5>
                        <a href="mailto:kaverikadam893@gmail.com"
                            class="d-inline-block mb-2 text-decoration-none text-dark"> <i class="bi bi-envelope-fill">
                            </i>onesthomestay@gmail.com</a>


                        <h5 class="mt-4">Follow us</h5>
                       
                        <a target="blank" href="https://www.facebook.com/OnestHomeStay" class="d-inline-block text-dark fs-5 me-3">
                            <i class="fa fa-facebook"></i>
                        </a>

                        <a target="blank" href="https://www.instagram.com/oleaf_onesthomestay/" class="d-inline-block  text-dark fs-5 ">
                            <i class="fa fa-instagram"></i>
                        </a>

                    </div>
                </div>
                <div class="col-lg-6 col-md-6 mb-5 px-4 mt-5">
                    <div class="bg-white rounded shadow p-4">
                        <form method="POST">
                            <h5>Send a message</h5>
                            <div class="mt-3">
                                <label class="form-label require" style="font-weight: 500;">Name</label>
                                <input name="name" required type="text" class="form-control shadow-none">
                            </div>
                            <div class="mt-3">
                                <label class="form-label" style="font-weight: 500;">Email</label>
                                <input name="email" required type="email" class="form-control shadow-none">
                            </div>
                            <div class="mt-3">
                                <label class="form-label" style="font-weight: 500;">Subject</label>
                                <input name="subject" required type="text" class="form-control shadow-none">
                            </div>
                            <div class="mt-3">
                                <label class="form-label" style="font-weight: 500;">Message</label>
                                <textarea name="message" required class="form-control shadow-none" rows="5"
                                    style="resize: none"></textarea>
                                <button name="send" type="submit" class="btn mt-3"
                                    style="background-color:purple; color: white;">Send</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>
        </div>
        </div>
        </div>


        <?php
        if (isset($_POST['send'])) {
            $frm_data = filteration($_POST);
            $q = "INSERT INTO `user_queries`(`name`, `email`, `subject`, `message`) VALUES (?,?,?,?)";
            $values = [$frm_data['name'], $frm_data['email'], $frm_data['subject'], $frm_data['message']];
            $res = insert($q, $values, 'ssss');
            if ($res == 1) {
                alert('success', 'Mail sent');
            } else {
                alert('error', 'Server Down! Try again later');
            }
        }
        ?>

    </body>
</section>
<?php
include ("inc/footer.php") ?>



</html>