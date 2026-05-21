<?php
require ('../inc/db_config.php');  // Include database connection
require('../inc/essentials.php');
session_start();

if (isset($_POST['check_availability'])) {
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];
    $room_id = $_SESSION['room']['id'];
    $room_price = $_SESSION['room']['price'];

    $query = "SELECT * FROM bookings1 WHERE room_id = ? AND ((check_in <= ? AND check_out >= ?) OR (check_in <= ? AND check_out >= ?))";
    $stmt = $con->prepare($query);
    $stmt->bind_param('issss', $room_id, $check_in, $check_in, $check_out, $check_out);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(['status' => 'unavailable']);
    } elseif ($check_in > $check_out) {
        echo json_encode(['status' => 'check_out_earlier']);
    } elseif ($check_in < date('Y-m-d')) {
        echo json_encode(['status' => 'check_in_earlier']);
    } elseif ($check_in == $check_out) {
        echo json_encode(['status' => 'check_in_out_equal']);
    } else {
        $days = (new DateTime($check_out))->diff(new DateTime($check_in))->days;
        $total_amount = $room_price * $days;
        echo json_encode(['status' => 'available', 'days' => $days, 'payment' => $total_amount]);
    }
}

if (isset($_POST['book'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $check_in = $_POST['checkin'];
    $check_out = $_POST['checkout'];
    $price = $_SESSION['room']['price'];
    $days = (new DateTime($check_out))->diff(new DateTime($check_in))->days;
    $total_amount = $price * $days;
    $room_id = $_SESSION['room']['id'];
    $user_id = $_SESSION['USER_ID']; // Get logged-in user ID

    $query = "INSERT INTO bookings1 (name, email, room_id, check_in, check_out, price, user_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $con->prepare($query);
    $stmt->bind_param('ssssssi', $name, $email, $room_id, $check_in, $check_out, $total_amount, $user_id);
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error']);
    }

    $stmt->close();
}

?>
