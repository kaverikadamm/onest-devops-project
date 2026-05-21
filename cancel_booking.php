<?php
require('admin/inc/db_config.php'); // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the booking ID from the POST request
    $bookingId = intval($_POST['id']);

    // Prepare the SQL query to update the booking status to 'canceled'
    $query = "UPDATE bookings1 SET status = 'canceled' WHERE id = ?";
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
