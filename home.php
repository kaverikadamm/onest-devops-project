<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>O'Nest Home Stay</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="css/common.css">
    <style>
        .availability-form {
            margin-top: -50px;
            z-index: 2;
            position: relative;
        }

        @media screen and (max-width: 575px) {
            .availability-form {
                margin-top: 25px;
                padding: 0 35px;
            }
        }
    </style>
</head>

<body class="bg-light">
    <?php require('inc/header.php'); ?>

    <?php
    date_default_timezone_set("Asia/Kolkata");

    // Fetch settings
    $settings_q = "SELECT * FROM `settings` WHERE `sr_no`=?";
    $values = [1];
    $settings_r = mysqli_fetch_assoc(select($settings_q, $values, 'i'));

    // Check if bookings are closed
    if ($settings_r['shutdown']) {
        echo "<div class='bg-danger text-center p-2 fw-bold'><i class='bi bi-exclamation-triangle-fill'></i> Bookings are temporarily closed!</div>";
    }
    ?>

    <!-- Modal -->
    <!-------carousel--->
    <div class="container-fluid px-lg-4 mt-4">
        <div class="swiper swiper-container">
            <div class="swiper-wrapper">
                <!-- Carousel slides -->
                <div class="swiper-slide d-flex align-items-center justify-content-center">
                    <img src="images/carousel/onesthotel.jpg" class=" w-100" alt="Slide 1">
                </div>
                <div class="swiper-slide d-flex align-items-center justify-content-center">
                    <img src="images/carousel/onestdecor.jpg" class=" w-100" alt="Slide 1">
                </div>
            </div>
        </div>
    </div>

    <!----check availability form--->
    <div class="container availability-form">
        <div class="row">
            <div class="col-lg-12 bg-white shadow p-4 rounded">
                <h5 class="mb-5 text-center">Check Booking Availability</h5>
                <form action="check_availability.php" method="POST">
    <div class="container">
        <div class="row justify-content-center d-flex ">
            <div class="col-lg-8">
                <div class="row align-items-end">
                    <div class="col-lg-4 mb-3">
                        <label class="form-label" style="font-weight:500;">Check-in</label>
                        <input type="date" name="checkin" class="form-control" required>
                    </div>
                    <div class="col-lg-4 mb-3">
                        <label class="form-label" style="font-weight:500;">Check-out</label>
                        <input type="date" name="checkout" class="form-control" required>
                    </div>
                    <div class="col-lg-4 mt-2 mb-lg-3 px-4">
                        <button type="submit" class="btn text-dark shadow-none" style="background-color:#bc66d1;">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

            </div>
        </div>
    </div>

    <!----room cards--->
    <div class="my-5 px-4">
        <h2 class="fw-bold h-font text-center ">OUR ROOMS</h2>
    </div>
    <div class="container">
        <div class="row">
            <?php
            $room_res = select("SELECT * FROM `rooms` WHERE `status`=? AND `removed`=? ORDER BY `id` DESC LIMIT 3", [1, 0], 'ii');
            while ($room_data = mysqli_fetch_assoc($room_res)) {
                $fac_q = mysqli_query($con, "SELECT f.name FROM `facilities` f 
                        INNER JOIN `room_facilities` rfac ON f.id = rfac.facilities_id
                        WHERE rfac.room_id='$room_data[id]'");

                $facilities_data = "";
                while ($fac_row = mysqli_fetch_assoc($fac_q)) {
                    $facilities_data .= "<span class='badge rounded-pill bg-light text-dark text-wrap me-1 mb-1'>
                            $fac_row[name]
                            </span>";
                }

                $room_thumb = ROOMS_IMG_PATH . "thumbnail.png";
                $thumb_q = mysqli_query($con, "SELECT * FROM `room_images` 
                    WHERE `room_id`='$room_data[id]' 
                    AND `thumb`='1'");

                if (mysqli_num_rows($thumb_q) > 0) {
                    $thumb_res = mysqli_fetch_assoc($thumb_q);
                    $room_thumb = ROOMS_IMG_PATH . $thumb_res['image'];
                }

                $book_btn = "";
                if (!$settings_r['shutdown']) {
                    $login=0;
                    if (isset($_SESSION['USER_LOGIN']) && $_SESSION['USER_LOGIN'] == 'yes') {
                        $login=1;
                    }
                    $book_btn = "<button onclick='checkLoginToBook($login,$room_data[id])' class='btn btn-sm text-dark' style='background-color: #bc66d1;'>Book Now</button>";
                }

                echo <<<data
                    <div class="col-lg-4 col-md-6 my-3">
                        <div class="card border-0 shadow" style="max-width: 350px; margin:auto;">
                            <img src="$room_thumb" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="mb-3">$room_data[name]</h5>
                                <h6 class="mb-4">₹$room_data[price] per night</h6>
                                <div class="facilities mb-4">
                                    <h6 class="mb-1">Facilities</h6>
                                    $facilities_data
                                </div>
                                <div class="Guests mb-3">
                                    <h6 class="mb-1">Guests</h6>
                                    <span class="badge rounded-pill bg-light text-dark text-wrap">
                                    $room_data[adult] Adults </span>
                                    <span class="badge rounded-pill bg-light text-dark text-wrap">
                                    $room_data[children] Children</span>
                                </div>
                                <div class="d-flex justify-content-evenly mb-2">
                                    $book_btn
                                    <a href="room_details.php?id=$room_data[id]" class="btn btn-sm btn-outline-dark shadow-none">More Details</a>
                                </div>
                            </div>
                        </div>
                    </div>       
                data;
            }
            ?>

            <div class="col-lg-12 text-center mt-5">
                <a href="rooms.php" class="btn btn-sm btn-outline-dark rounded shadow-none">More Rooms>>></a>
            </div>
        </div>
    </div>
<!-- Testimonials Section -->
<h2 class="mt-3 fw-bold pt-4 h-font mb-5 text-center">What our guests say</h2>
<div class="container mt-5">
    <div class="swiper swiper-testimonials">
        <div class="swiper-wrapper mb-5">
            <?php
            // Fetch testimonials from the database
            $query = "SELECT * FROM testimonials ORDER BY created_at DESC";
            $result = mysqli_query($con, $query);

            while ($row = mysqli_fetch_assoc($result)) {
                $rating_stars = str_repeat("<i class='bi bi-star-fill text-warning'></i>", $row['rating']);
                $rating_stars .= str_repeat("<i class='bi bi-star-fill text-muted'></i>", 5 - $row['rating']);
                echo "
                    <div class='swiper-slide bg-white'>
                        <div class='profile d-flex align-items-center ms-2 mb-3'>
                            
                            <h6 class='m-0 ms-2'>{$row['user_name']}</h6>
                        </div>
                        <p class='ms-2'>{$row['content']}</p>
                        <div class='rating ms-2 mb-5'>
                            $rating_stars
                        </div>
                    </div>
                ";
            }
            ?>
        </div>
        <div class="swiper-pagination"></div>
    </div>
</div>



    <!-----footer--->
    <?php require('inc/footer.php'); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
      <!-----carousel--->
    <script>
    var swiper = new Swiper(".swiper-container", {
      spaceBetween: 30,
      effect: "fade",
      loop:true,
      autoplay:{
        delay:3500,
        disableOnInteraction:false
      }
    });
  </script>
    <!-----testimonial--->
    <script>
    var swiper = new Swiper('.swiper-testimonials', {
        effect: "coverflow",
        grabCursor: true,
        centeredSlides: true,
        slidesPerView: "auto",
        loop: true,
        coverflowEffect: {
            rotate: 50,
            stretch: 0,
            depth: 100,
            modifier: 1,
            slideShadows: false,
        },
        pagination: {
            el: ".swiper-pagination",
        },
        breakpoints: {
            320: { slidesPerView: 1 },
            640: { slidesPerView: 1 },
            768: { slidesPerView: 2 },
            1024: { slidesPerView: 3 }
        }
    });
</script>

</body>
</html>
