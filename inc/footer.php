<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <style>
        .footer {
            width: 100%;
            text-align: center;
            padding: 30px 0;
            background-color: rgb(211, 183, 211);

        }

        .footer h4 {
            color: black;
            margin-top: 20px;
            margin-bottom: 25px;
            font-weight: 600;
        }

        .footer p {
            color: black;
        }
    </style>
</head>

<body>
    <h2 class="mt-3 fw-bold pt-4 h-font mb-0 bg-light text-center">About Us</h2>
    <div class=" py-3 bg-light">
        <div class="container text-center">
            <div class="row">
                <div class="col-md-4">
                    <h5>O'Nest Home Stay</h5>
                    <p>At O'Nest, we believe in offering more than just a stay – we offer an experience.</p>
                </div>
                <div class="col-md-4">
                    <h5>Links</h5>
                    <ul class="list-unstyled ">
                        <li><a href="home.php" class="text-dark">Home</a></li>
                        <li><a href="rooms.php" class="text-dark">Rooms</a></li>
                        <li><a href="about.php" class="text-dark">About</a></li>
                        <li><a href="contact.php" class="text-dark">Contact Us </a></li>
                        <li><a href="gallery.html" class="text-dark">Gallery</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Follow Us</h5>
                    <a target="blank" href="https://www.facebook.com/OnestHomeStay" class="text-dark me-2"><i class="bi bi-facebook"></i> Facebook</a>
                    <a target="blank" href="https://www.instagram.com/oleaf_onesthomestay/" class="text-dark"><i class="bi bi-instagram"></i> Instagram</a>
                </div>
            </div>
        </div>
    </div>


<?php require("Admin/inc/scripts.php");
?>
    <script>
        function setActive() {
            let navbar = document.getElementById('nav-bar');
            let a_tags = navbar.getElementsByTagName('a');
            for (i = 0; i < a_tags.length; i++) {
                let file = a_tags[i].href.split('/').pop();
                let file_name = file.split('.')[0];
                if (document.location.href.indexOf(file_name) >= 0) {
                    a_tags[i].classList.add('active');
                }
            }
        }


        



        function checkLoginToBook(status,room_id) {
            if(status){
                window.location.href='confirm_booking.php?id='+room_id;
            }
            else{
                alert('Please login to Book Room!')
            }
        }

        setActive();
    </script>

</body>

</html>