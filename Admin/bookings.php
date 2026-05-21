<?php
require('inc/db_config.php'); // Include database connection
require('inc/essentials.php'); // Include essential functions (like adminLogin)
adminLogin(); // Ensure the user is logged in as admin
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Bookings</title>
    <?php require('inc/links.php'); // Include CSS and JS links ?>
</head>

<body class="bg-light">
    <?php require('inc/header.php'); // Include admin header ?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">BOOKINGS</h3>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">
                        <div class="text-end mb-4">
                            <!-- Optional: Add buttons or other elements here -->
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover border text-center">
                                <thead>
                                    <tr class="bg-dark text-white">
                                        <th scope="col">#</th>
                                        <th scope="col">User Details</th>
                                        <th scope="col">Room Details</th>
                                        <th scope="col">Booking Details</th>
                                        <th scope="col">Price</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="table-data">
                                    <?php
                                    // Fetch booking details including room price and status
                                    $query = "SELECT b.id, b.name, b.email, b.room_id, b.check_in, b.check_out, b.created_at, r.name AS room_name, r.price, b.status
                                              FROM bookings1 b
                                              JOIN rooms r ON b.room_id = r.id
                                              ORDER BY b.created_at DESC";
                                    $result = $con->query($query);

                                    if (!$result) {
                                        echo "<tr><td colspan='7'>Error fetching bookings: " . $con->error . "</td></tr>";
                                    } else {
                                        while ($row = $result->fetch_assoc()) {
                                            // Calculate the number of days
                                            $check_in = new DateTime($row['check_in']);
                                            $check_out = new DateTime($row['check_out']);
                                            $interval = $check_in->diff($check_out);
                                            $number_of_days = $interval->days;

                                            // Calculate the total price
                                            $total_price = $row['price'] * $number_of_days;

                                            // Determine the status label
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
                                            $action_button = $row['status'] === 'pending' ? "<button class='btn btn-success rounded-pill btn-sm' onclick='confirmBooking({$row['id']})'>Confirm</button>" : "";

                                            echo "<tr>
                                                    <td>{$row['id']}</td>
                                                    <td>
                                                        <strong>{$row['name']}</strong><br>
                                                        {$row['email']}
                                                    </td>
                                                    <td>
                                                       <b>Room Name:</b> <br>
                                                        {$row['room_name']}
                                                    </td>
                                                    <td>
                                                        <b>Check-In:</b> {$row['check_in']}<br>
                                                       <b> Check-Out:</b> {$row['check_out']}<br>
                                                       <b> Created At:</b> {$row['created_at']}
                                                    </td>
                                                    <td>
                                                      <b>  ₹{$total_price}</b>
                                                    </td>
                                                    <td>
                                                       <b> {$status_label} </b>
                                                    </td>
                                                    <td>
                                                        {$action_button}
                                                        <button class='btn btn-danger rounded-pill btn-sm' onclick='deleteBooking({$row['id']})'>Delete</button>
                                                    </td>
                                                </tr>";
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require('inc/scripts.php'); ?>
    <script src="scripts/bookings.js"></script>
    <script>
        function confirmBooking(bookingId) {
            if (confirm("Are you sure you want to confirm this booking?")) {
                fetch('bookings.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `id=${bookingId}`
                }).then(response => response.json()).then(data => {
                    if (data.status === 'success') {
                        alert('Booking confirmed successfully.');
                        location.reload();
                    } else {
                        alert('Failed to confirm booking. Please try again.');
                    }
                });
            }
        }

        function deleteBooking(bookingId) {
            if (confirm("Are you sure you want to delete this booking?")) {
                fetch('admin_delete_booking.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `id=${bookingId}`
                }).then(response => response.json()).then(data => {
                    if (data.status === 'success') {
                        alert('Booking deleted successfully.');
                        location.reload();
                    } else {
                        alert('Failed to delete booking. Please try again.');
                    }
                });
            }
        }
    </script>
</body>

</html>

<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bookingId = intval($_POST['id']);

    // Update the booking status to 'confirmed'
    $query = "UPDATE bookings1 SET status = 'confirmed' WHERE id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $bookingId);
    $success = $stmt->execute();

    if ($success) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error']);
    }

    $stmt->close();
}



$con->close();
?>