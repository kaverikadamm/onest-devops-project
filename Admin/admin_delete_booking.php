<?php
require ('inc/db_config.php'); // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bookingId = intval($_POST['id']);

    // Prepare and execute the delete query
    $query = "DELETE FROM bookings1 WHERE id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param('i', $bookingId);
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $con->error]);
    }
    $stmt->close();
}

$con->close();
?>
