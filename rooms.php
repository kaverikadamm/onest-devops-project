<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room page</title>
    <!-- Option 1: Include in HTML -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
  <link rel="stylesheet" href="css/common.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        .container2 {
            background-color: rgb(211, 183, 211);
        }

        .btn1 {
            background-color: purple;
        }
      
    </style>
</head>
<?php
    include("inc/header.php")
        ?>
<section class="container2">
    

    <body class="con bg-light">

        <div class=" px-4">
            <h2 class="fw-bold h-font text-center pt-5 pb-3 ">OUR ROOMS</h2>
        </div>
        <div class="h-line bg-dark"></div>

        <div class="container-fluid d-flex justify-content-center ">
           


                <div class="col-lg-9 col-md-12 px-4 ">

                    <?php
                    $room_res = select("SELECT * FROM `rooms` WHERE `status`=? AND `removed`=?", [1, 0], 'ii');
                    while ($room_data = mysqli_fetch_assoc($room_res)) {

                        //get facilities of room
                    
                        $fac_q = mysqli_query($con, "SELECT f.name FROM `facilities` f 
                        INNER JOIN `room_facilities` rfac ON f.id = rfac.facilities_id
                        WHERE rfac.room_id='$room_data[id]'");

                        $facilities_data = "";
                        while ($fac_row = mysqli_fetch_assoc($fac_q)) {
                            $facilities_data .= "<span class='badge rounded-pill bg-light text-dark text-wrap me-1 mb-1'>
                            $fac_row[name]
                            </span>";
                        }

                        // get thumbnail of image
                    
                        $room_thumb = ROOMS_IMG_PATH . "thumbnail.png";

                        $thumb_q = mysqli_query($con, "SELECT * FROM `room_images` 
                    WHERE `room_id`='$room_data[id]' 
                    AND `thumb`='1'");

                        if (mysqli_num_rows($thumb_q) > 0) {
                            $thumb_res = mysqli_fetch_assoc($thumb_q);
                            $room_thumb = ROOMS_IMG_PATH . $thumb_res['image'];
                        }

                        //shutdown purpose
                        $settings_q = "SELECT * FROM `settings` WHERE `sr_no`=?";
                        $values = [1];

                        $settings_r = mysqli_fetch_assoc(select($settings_q, $values, 'i'));
                        $book_btn = "";
                        if (!$settings_r['shutdown']) {
                            $login = 0;
                            if (isset($_SESSION['USER_LOGIN']) && $_SESSION['USER_LOGIN'] == 'yes') {
                                $login = 1;
                            }

                            $book_btn = "<button onclick='checkLoginToBook($login,$room_data[id])' class='btn btn-sm w-100 text-white border mb-2 rounded' style='background-color: purple; padding: 7px; text-decoration: none;'>Book Now</button>";
                        }

                        //print room card
                        echo <<<data
                    <div class="card mb-4 border-0 shadow ">
                        <div class="row g-0 p-3 align-items-center">
                            <div class="col-md-5 mb-lg-0 mb-md-0 mb-3">
                                <img src="$room_thumb" class="img-fluid rounded">
                            </div>
                            <div class="col-md-5 px-lg-3 px-md-3 px-0">
                                <h5 class="mb-3 ">$room_data[name]</h5>
                                
                                <div class="Facilities mb-3">
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
                            </div>
                            <div class="col-md-2 test  -center">
                                <div class="card-body">
                                    <h6 class="mb-4">₹$room_data[price] per night</h6>
                                     $book_btn
                                    <a href="room_details.php?id=$room_data[id]"
                                        class="btn btn-sm w-100 btn-outline-dark shadow-none border text-center rounded"
                                        style="text-decoration: none;">More Details</a>


                                </div>
                            </div>
                        </div>
                    </div>
                    data;




                    }
                    ?>




                </div>
            
        </div>

        <?php
        include("inc/footer.php") ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
            </script>
    </body>

</section>




</html>