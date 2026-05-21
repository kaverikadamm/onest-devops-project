
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings</title>
    <!-- Bootstrap CSS link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/common.css">
    <!-- Custom CSS -->
</head>
<body class="bg-light">
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


<?php

require('admin/inc/db_config.php'); // Make sure to include your database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_name = mysqli_real_escape_string($con, $_POST['user_name']);
    $content = mysqli_real_escape_string($con, $_POST['content']);
    $rating = (int)$_POST['rating'];

    // Insert testimonial into the database
    $query = "INSERT INTO testimonials (user_name, content, rating) VALUES (?,?, ?)";
    $stmt = $con->prepare($query);
    $stmt->bind_param('ssi', $user_name,  $content, $rating);

    if ($stmt->execute()) {
        echo "<br></br><br></br> <h3>Testimonial submitted successfully.</h3>";
        echo"<a  href='home.php' class='btn btn-primary mb-5'>Go to home</a>";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>


 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
        </script>
    
</body>
<?php
require('inc/footer.php');
?>
</html>

