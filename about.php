<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hero-section {
            background: #f8f9fa;
            padding: 20px 0;
        }
        .hero-section h1 {
            font-size: 3rem;
        }
        .about-section {
            padding: 5px 0;
        }
        .about-section img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
<?php
    require('inc/header.php');
    ?>
    <!-- Hero Section -->
    <header class="hero-section text-center ">
        <div class="container">
            <h1 class="mt-5">About Us</h1>
          
        </div>
    </header>

    <!-- About Section -->
    <section class="about-section">
        <div class="container">
            <div class="row">
                <div class="col-md-6 mt-5">
                    <h2><b>O'Nest Home Stay</b></h2>
                    <p class="mt-4">A holiday at O'Nest Home Stay is a journey back to your roots. You get to see a snap shot of the rural life and indulge yourself in activities that refreshes and soul.
If you want to experience the lush green interiors of the Konkan land, white sandy beaches, visit historic forts, majestic waterfalls, back waters or even take a short trek in the jungles of Konkan hitherto untouched - Look no more, O'nest Home stay offers all this and more!!
Located in the interiors of Konkan in Devrukh, just 40kms away from Ratnagiri, O'nest Homestay is an ideal place to head to for a break free vacation. O'nest Homestay is much more than a tourist destination.You get to experience the real Konkan and also stay near all the major tourist attractions of the region!

</p>
                </div>
                <div class="col-md-6">
                    <img src="images/onesthotel.jpg" alt="About Us">
                </div>
            </div>
        </div>
    </section>
       <?php 
   require('inc/footer.php');
   ?>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
        </script>
</body>
</html>
