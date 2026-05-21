<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ROOM DETAILS</title>
    <!-- Include Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        .container2 {
            background-color: rgb(211, 183, 211);
        }

        .btn1 {
            background-color: purple;
        }

        .review-img {
            width: 60px;
            /* Adjust the width as needed */
            height: 60px;
            /* Adjust the height as needed */
            object-fit: cover;
            /* Ensures the image maintains aspect ratio */
        }
    </style>
</head>

<body class="bg-light">
    <section class="container2">
        <?php include("inc/header.php"); ?>

        <?php
        if (!isset($_GET['id'])) {
            header('Location: rooms.php');
            exit();
        }

        $data = filteration($_GET);
        $room_res = select("SELECT * FROM `rooms` WHERE `id`=? AND `status`=? AND `removed`=?", [$data['id'], 1, 0], 'iii');

        if (mysqli_num_rows($room_res) == 0) {
            header('Location: rooms.php');
            exit();
        }
        $room_data = mysqli_fetch_assoc($room_res);
        ?>

        <div class="container">
            <div class="row">
                <div class="col-12 my-5 mb-4 px-4">
                    <h2 class="fw-bold"><?php echo htmlspecialchars($room_data['name']); ?></h2>
                    <div style="font-size: 14px;">
                        <a href="index.php" class="text-secondary text-decoration-none">HOME</a>
                        <span class="text-secondary"> > </span>
                        <a href="rooms.php" class="text-secondary text-decoration-none">ROOMS</a>
                    </div>
                </div>

                <div class="col-lg-7 col-md-12 px-4">
                    <div id="roomCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <?php
                            $room_img = ROOMS_IMG_PATH . "thumbnail.png";
                            $img_q = mysqli_query($con, "SELECT * FROM `room_images` WHERE `room_id`='$room_data[id]'");
                            if (mysqli_num_rows($img_q) > 0) {
                                $active_class = 'active';
                                while ($img_res = mysqli_fetch_assoc($img_q)) {
                                    echo "
                                    <div class='carousel-item $active_class'>
                                        <img src='" . ROOMS_IMG_PATH . $img_res['image'] . "' class='d-block w-100 rounded'>
                                    </div>";
                                    $active_class = '';
                                }
                            } else {
                                echo "
                                <div class='carousel-item active'>
                                    <img src='$room_img' class='d-block w-100'>
                                </div>";
                            }
                            ?>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#roomCarousel"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#roomCarousel"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>

                <div class="col-lg-5 col-md-12 px-4">
                    <div class="card mb-4 border-0 shadow-sm rounded-3">
                        <div class="card-body">
                            <?php
                            echo <<<price
                             <h4>₹$room_data[price] per night</h4>
                            price;

                           

                            $fac_q = mysqli_query($con, "SELECT f.name FROM `facilities` f 
                        INNER JOIN `room_facilities` rfac ON f.id = rfac.facilities_id
                        WHERE rfac.room_id='$room_data[id]'");

                            $facilities_data = "";
                            while ($fac_row = mysqli_fetch_assoc($fac_q)) {
                                $facilities_data .= "<span class='badge rounded-pill bg-light text-dark text-wrap me-1 mb-1'>
                            $fac_row[name]
                            </span>";
                            }
                            echo <<<facilities
                            
                            <div class="Facilities mb-4">
                                <h6 class="mb-1">Facilities</h6>
                                    $facilities_data
                                </div>
                            facilities;

                            echo <<<guests
                             <div class="Guests mb-3">
                                    <h6 class="mb-1">Guests</h6>
                                    <span class="badge rounded-pill bg-light text-dark text-wrap">
                                    $room_data[adult] Adults </span>
                                    <span class="badge rounded-pill bg-light text-dark text-wrap">
                                    $room_data[children] Children</span>
                                </div>
                             guests;

                            echo <<<area
                                 <div class="mb-3">
                                <h6 class="mb-1">Area</h6>
                                <span class='badge rounded-pill bg-light text-dark text-wrap me-1 mb-1'>
                                 $room_data[area] sq. ft.
                                </span>
                                 </div>
                             area;
                            //shutdown purpose
                            $settings_q = "SELECT * FROM `settings` WHERE `sr_no`=?";
                            $values = [1];

                            $settings_r = mysqli_fetch_assoc(select($settings_q, $values, 'i'));
                            $book_btn = "";
                            if (!$settings_r['shutdown']) {
                                $login=0;
                                if (isset($_SESSION['USER_LOGIN']) && $_SESSION['USER_LOGIN'] == 'yes') {
                                    $login=1;
                                }
                            echo <<<book
                             <button onclick='checkLoginToBook($login,$room_data[id])' class="btn w-100 text-white border mb-1 rounded" style="background-color: purple; padding: 7px; text-decoration: none;">Book Now</button>    
                             book;
                            }

                            ?>
                        </div>
                    </div>
                </div>

                <div class="col-12 mt-4 px-4">
                    <div class="mb-4">
                        <h5>Description</h5>
                        <p>
                            <?php echo $room_data['description'] ?>
                        </p>
                    </div>
                    <div>
                     
                    </div>
                </div>

                <?php include("inc/footer.php"); ?>

            </div>
        </div>
    </section>

    <!-- Include Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz4fnFO9ON9tykeM9dX+RfiRkUQ7f2jovQfAKt3J7Xn9lQp5c9Q7A8F/4Q"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-c7F3bQ8MW5BlR1/r7V2mEvCpm5B/hQTJv/JzUs7Pp6U1aXcbGm2p9TNTt6Y68Ae"
        crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
        </script>
        
</body>

</html>