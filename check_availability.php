<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="css/common.css">
</head>
<body>
<nav id="nav-bar" class="navbar navbar-expand-lg navbar-light bg-white px-lg-3 py-lg-2 shadow-sm sticky-top ">
    <div class="container-fluid ">
      <a class="navbar-brand me-5 fw-bold fs-3 h-font" href="home.php">O'Nest Home Stay</a>
      <button class="navbar-toggler " type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon shadow-none"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link  me-2" href="home.php">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link me-2" href="rooms.php">Rooms</a>
          </li>
          <li class="nav-item">
            <a class="nav-link me-2" href="about.php">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link me-2" href="contact.php">Contact us</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="gallery.html">Gallery</a>
          </li>

        </ul>
        <div class="d-flex">

          <?php
          if (isset($_SESSION['USER_LOGIN']) && $_SESSION['USER_LOGIN'] == 'yes') {
            echo <<<data
                <div class="btn-group">
                <button type="button" class="btn custom-bg  text-light me-2 shadow-none btn-outline-dark btn-secondary dropdown-toggle" data-bs-toggle="dropdown" data-bs-display="static" aria-expanded="false">
                  $_SESSION[USER_NAME]
                </button>
                <ul class="dropdown-menu dropdown-menu-lg-end">
                     <li><a class="dropdown-item" href="my_bookings.php">Bookings</a></li>
                  <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                </ul>
              </div>

            data;
          }
          else{
            echo<<<data
              <button type="button" class="btn btn-outline-dark custom-bg text-white  shadow-none me-lg-2 me-3"
            onclick="window.location.href='login.php';">
            Login</button>
             <button type="button" class="btn btn-outline-dark custom-bg text-white  shadow-none me-lg-2 me-3"
            onclick="window.location.href='register.php';">
            Register</button>
            data;
          }
          ?>
        


        </div>
      </div>
    </div>
  </nav>


    <div class="container">
        <div class="row">
        <?php
require('admin/inc/db_config.php');
require('admin/inc/essentials.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $checkin = $_POST['checkin'];
    $checkout = $_POST['checkout'];
  

    // Validate dates
    if (empty($checkin) || empty($checkout)) {
        echo "Please provide both check-in and check-out dates.";
        exit;
    }

    // Fetch available rooms
    $query = "
        SELECT r.*, 
        (SELECT COUNT(*) FROM bookings1 b WHERE b.room_id = r.id AND (
            (b.check_in <= ? AND b.check_out >= ?) OR
            (b.check_in >= ? AND b.check_in <= ?)
        )) as booked
        FROM rooms r
        WHERE r.status = ? AND r.removed = ?
        HAVING booked = 0
    ";

    $stmt = $con->prepare($query);

    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($con->error));
    }

    // Bind parameters
    $status = 1; // Assuming status is 1 for active rooms
    $removed = 0; // Assuming removed is 0 for not removed rooms
    $stmt->bind_param('ssssii', $checkin, $checkin, $checkout, $checkout, $status, $removed);

    if ($stmt->execute()) {
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($room = $result->fetch_assoc()) {
                $fac_q = mysqli_query($con, "SELECT f.name FROM `facilities` f 
                    INNER JOIN `room_facilities` rfac ON f.id = rfac.facilities_id
                    WHERE rfac.room_id='$room[id]'");

                $facilities_data = "";
                while ($fac_row = mysqli_fetch_assoc($fac_q)) {
                    $facilities_data .= "<span class='badge rounded-pill bg-light text-dark text-wrap me-1 mb-1'>
                        $fac_row[name]
                        </span>";
                }

                $room_thumb = ROOMS_IMG_PATH . "thumbnail.png";
                $thumb_q = mysqli_query($con, "SELECT * FROM `room_images` 
                    WHERE `room_id`='$room[id]' 
                    AND `thumb`='1'");

                if (mysqli_num_rows($thumb_q) > 0) {
                    $thumb_res = mysqli_fetch_assoc($thumb_q);
                    $room_thumb = ROOMS_IMG_PATH . $thumb_res['image'];
                }

                $book_btn = "<button onclick='checkLoginToBook(" . (isset($_SESSION['USER_LOGIN']) && $_SESSION['USER_LOGIN'] == 'yes' ? 1 : 0) . ",$room[id])' class='btn btn-sm text-dark' style='background-color: #bc66d1;'>Book Now</button>";

                echo <<<data
                    <div class="col-lg-4 col-md-6 my-3">
                        <div class="card border-0 shadow" style="max-width: 350px; margin:auto;">
                            <img src="$room_thumb" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5>$room[name]</h5>
                                <h6 class="mb-4">₹$room[price] per night</h6>
                                <div class="facilities mb-4">
                                    <h6 class="mb-1">Facilities</h6>
                                    $facilities_data
                                </div>
                                <div class="Guests mb-3">
                                    <h6 class="mb-1">Guests</h6>
                                    <span class="badge rounded-pill bg-light text-dark text-wrap">
                                    $room[adult] Adults </span>
                                    <span class="badge rounded-pill bg-light text-dark text-wrap">
                                    $room[children] Children</span>
                                </div>
                                <div class="rating mb-4">
                                    <h6 class="mb-1">Ratings</h6>
                                    <span class="badge rounde-pill bg-light">
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                        <i class="bi bi-star-fill text-warning"></i>
                                    </span>
                                </div>
                                <div class="d-flex justify-content-evenly mb-2">
                                    $book_btn
                                    <a href="room_details.php?id=$room[id]" class="btn btn-sm btn-outline-dark shadow-none">More Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                data;
            }
        } else {
            echo "<p class='mt-5 mb-5'><b>No rooms available for the selected dates.</b> </p>";
        }
    } else {
        die('Execute failed: ' . htmlspecialchars($stmt->error));
    }

    $stmt->close();
}
?>
        </div>

    </div>
<?php require('inc/footer.php'); ?>
</body>
</html>

