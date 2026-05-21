<?php
require('admin/inc/db_config.php'); // Include database connection
require('admin/inc/essentials.php'); // Include essential functions
session_start();

if (!isset($_SESSION['USER_ID'])) {
  header('Location: login.php');
  exit();
}

$user_id = $_SESSION['USER_ID'];

$query = "SELECT b.id, b.check_in, b.check_out, r.name AS room_name, r.price, b.status
          FROM bookings1 b
          JOIN rooms r ON b.room_id = r.id
          WHERE b.user_id = ?
          ORDER BY b.created_at DESC";
$stmt = $con->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>My Bookings</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/common.css">
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
          } else {
            echo <<<data
              <button type="button" class="btn btn-outline-dark shadow-none me-lg-2 me-3"
            onclick="window.location.href='login.php';">
            Login/Register</button>
            data;
          }
          ?>



        </div>
      </div>
    </div>
  </nav>



  <div class="container py-4">
    <h3 class="mb-4">My Bookings</h3>
    <div class="table-responsive">
      <table class="table table-hover border text-center">
        <thead>
          <tr class="bg-dark text-white">
            <th scope="col">#</th>
            <th scope="col">Room Details</th>
            <th scope="col">Booking Details</th>
            <th scope="col">Price</th>
            <th scope="col">Status</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $result->fetch_assoc()): ?>
            <?php
            // Calculate the number of days
            $check_in = new DateTime($row['check_in']);
            $check_out = new DateTime($row['check_out']);
            $interval = $check_in->diff($check_out);
            $number_of_days = $interval->days;

            // Calculate the total price
            $total_price = $row['price'] * $number_of_days;

            // Determine the status label
            $status_label = '';
            switch ($row['status']) {
              case 'confirmed':
                $status_label = 'Confirmed';
                break;
              case 'canceled':
                $status_label = 'canceled';
                break;
              default:
                $status_label = 'Pending';
                break;
            }

            // Determine the action button based on status
            $cancel_button = $row['status'] === 'confirmed' ? "" : "<button class='btn btn-danger rounded-pill btn-sm' onclick='cancelBooking({$row['id']})'>Cancel Booking</button>";

            ?>
            <tr>
              <td><?php echo $row['id']; ?></td>
              <td><strong><?php echo $row['room_name']; ?></strong></td>
              <td>
                Check-In: <?php echo $row['check_in']; ?><br>
                Check-Out: <?php echo $row['check_out']; ?>
              </td>
              <td>₹<?php echo $total_price; ?></td>
              <td><?php echo $status_label; ?></td>
              <td>
                <?php if ($row['status'] === 'pending'): ?>
                  <button class='btn btn-danger rounded-pill btn-sm cancel-button' data-id='<?php echo $row['id']; ?>'>
                    Cancel Booking
                  </button>
                <?php endif; ?>
              </td>


            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
  <!-- Testimonials Submission Form -->
  <div class="container mb-5 mt-5">
    <h3 class="text-center">Submit a review</h3>
    <form action="submit_testimonial.php" method="POST">
      <div class="mb-3">
        <label for="userName" class="form-label">Your Name</label>
        <input type="text" class="form-control" id="userName" name="user_name" required>
      </div>

      <div class="mb-3">
        <label for="testimonialContent" class="form-label">Your Review</label>
        <textarea class="form-control" id="testimonialContent" name="content" rows="4" required></textarea>
      </div>
      <div class="mb-3">
        <label for="rating" class="form-label">Rating</label>
        <select class="form-select" id="rating" name="rating" required>
          <option value="" disabled selected>Select rating</option>
          <option value="1">1 Star</option>
          <option value="2">2 Stars</option>
          <option value="3">3 Stars</option>
          <option value="4">4 Stars</option>
          <option value="5">5 Stars</option>
        </select>
      </div>
      <button type="submit" class="btn custom-bg">Submit review</button>
    </form>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      document.querySelectorAll('.cancel-button').forEach(button => {
        button.addEventListener('click', function () {
          const bookingId = this.getAttribute('data-id');
          const row = this.closest('tr');
          cancelBooking(bookingId, row);
        });
      });
    });

    function cancelBooking(bookingId, row) {
      if (confirm("Are you sure you want to cancel this booking?")) {
        fetch('cancel_booking.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
          },
          body: `id=${bookingId}`
        })
          .then(response => response.json())
          .then(data => {
            if (data.status === 'success') {
              alert('Booking canceled successfully.');
              // Remove the table row
              row.remove();
            } else {
              alert('Failed to cancel booking. Please try again.');
            }
          });
      }
    }
  </script>

</body>

</html>

<?php
$stmt->close();
$con->close();
?>