<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CONFIRM BOOKING</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        .container2 { background-color: rgb(211, 183, 211); }
        .btn1 { background-color: purple; }
        .review-img { width: 60px; height: 60px; object-fit: cover; }
    </style>
</head>
<body class="bg-light">
    <section class="container2">
        <?php include("inc/header.php"); ?>
        <?php
        $settings_q = "SELECT * FROM settings WHERE sr_no=?";
        $values = [1];
        $settings_r = mysqli_fetch_assoc(select($settings_q, $values, 'i'));

        if (!isset($_GET['id']) || $settings_r['shutdown'] == true) {
            redirect('rooms.php');
        } else if (!(isset($_SESSION['USER_LOGIN']) && $_SESSION['USER_LOGIN'] == 'yes')) {
            redirect('rooms.php');
        }

        $data = filteration($_GET);
        $room_res = select("SELECT * FROM rooms WHERE id=? AND status=? AND removed=?", [$data['id'], 1, 0], 'iii');

        if (mysqli_num_rows($room_res) == 0) {
            header('Location: rooms.php');
            exit();
        }
        $room_data = mysqli_fetch_assoc($room_res);

        $_SESSION['room'] = [
            "id" => $room_data['id'],
            "name" => $room_data['name'],
            "price" => $room_data['price'],
            "payment" => null,
            "available" => false,
        ];

        $user_res = select("SELECT * FROM users WHERE id=? LIMIT 1", [$_SESSION['USER_ID']], "i");
        $user_data = mysqli_fetch_assoc($user_res);
        ?>
        <div class="container">
            <div class="row">
                <div class="col-12 my-5 mb-4 px-4">
                    <h2 class="fw-bold">CONFIRM BOOKING</h2>
                    <div style="font-size: 14px;">
                        <a href="home.php" class="text-secondary text-decoration-none">HOME</a>
                        <span class="text-secondary"> > </span>
                        <a href="rooms.php" class="text-secondary text-decoration-none">ROOMS</a>
                    </div>
                </div>
                <div class="col-lg-7 col-md-12 px-4">
                    <div id="roomCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <?php
                            $room_img = ROOMS_IMG_PATH . "thumbnail.png";
                            $img_q = mysqli_query($con, "SELECT * FROM room_images WHERE room_id='$room_data[id]'");
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
                        <div class="card p-3 shadow-sm rounded">
                            <h5><?php echo $room_data['name']; ?></h5>
                            <h6>₹<?php echo $room_data['price']; ?> per night </h6>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-md-12 px-4">
                    <div class="card mb-4 border-0 shadow-sm rounded-3">
                        <div class="card-body">
                            <form action="book.php" method="POST" id="booking_form">
                                <h6 class="mb-3">BOOKING DETAILS</h6>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Name</label>
                                        <input name="name" type="text" value="<?php echo $user_data['name']; ?>" class="form-control shadow-none" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Email</label>
                                        <input name="email" type="text" value="<?php echo $user_data['email']; ?>" class="form-control shadow-none" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">Check-in</label>
                                        <input name="checkin" onchange="check_availability()" class="form-control shadow-none" required type="date">
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <label class="form-label">Check-Out</label>
                                        <input name="checkout" onchange="check_availability()" class="form-control shadow-none" required type="date">
                                    </div>
                                    <div class="col-12">
                                        <div class="spinner-border text-dark mb-3 d-none" id="info_loader" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        <h6 class="text-danger mb-3" id="pay_info">Provide Check-in and Check-Out date!</h6>
                                        <button name="pay_now" class="btn w-100 text-white" style="background-color:#a23ebb;" disabled>Confirm Booking</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <?php include("inc/footer.php"); ?>
            </div>
        </div>
    </section>
    <script>
        let booking_form = document.getElementById('booking_form');
        let info_loader = document.getElementById('info_loader');
        let pay_info = document.getElementById('pay_info');

        function check_availability() {
            let checkin_val = booking_form.elements['checkin'].value;
            let checkout_val = booking_form.elements['checkout'].value;

            booking_form.elements['pay_now'].setAttribute('disabled', true);
            if (checkin_val !== '' && checkout_val !== '') {
                pay_info.classList.add('d-none');
                pay_info.classList.replace('text-dark', 'text-danger');
                info_loader.classList.remove('d-none');

                let data = new FormData();
                data.append('check_availability', '');
                data.append('check_in', checkin_val);
                data.append('check_out', checkout_val);

                let xhr = new XMLHttpRequest();
                xhr.open("POST", "Admin/ajax/confirm_booking.php", true);

                xhr.onload = function () {
                    let response = JSON.parse(this.responseText);

                    if (response.status === 'check_in_out_equal') {
                        pay_info.innerText = 'You cannot check-out on the same day!';
                    } else if (response.status === 'check_out_earlier') {
                        pay_info.innerText = 'Check-out date is earlier than check-in date!';
                    } else if (response.status === 'check_in_earlier') {
                        pay_info.innerText = "Check-in date is earlier than today's date";
                    } else if (response.status === 'unavailable') {
                        pay_info.innerText = "Room not available for this check-in date!";
                    } else {
                        pay_info.innerHTML = "No. of Days: " + response.days + "<br>Total Amount to Pay: ₹" + response.payment;
                        pay_info.classList.replace('text-danger', 'text-dark');
                        {
                            booking_form.elements['pay_now'].removeAttribute('disabled');
                            booking_form.addEventListener('submit', function (e) {
                                e.preventDefault();
                                submitBooking();
                            });
                        }
                    }
                    pay_info.classList.remove('d-none');
                    info_loader.classList.add('d-none');
                }
                xhr.send(data);
            }
        }

        function submitBooking() {
            let data = new FormData(booking_form);
            data.append('book', '');

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "Admin/ajax/confirm_booking.php", true);

            xhr.onload = function () {
                let response = JSON.parse(this.responseText);
                if (response.status === 'success') {
                    alert("Booking confirmed successfully!");
                    window.location.href = 'thank_you.php'; // Redirect to a thank you page
                } else {
                    alert("An error occurred while confirming your booking. Please try again.");
                }   
            }
            xhr.send(data);
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9ON9tykeM9dX+RfiRkUQ7f2jovQfAKt3J7Xn9lQp5c9Q7A8F/4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-c7F3bQ8MW5BlR1/r7V2mEvCpm5B/hQTJv/JzUs7Pp6U1aXcbGm2p9TNTt6Y68Ae" crossorigin="anonymous"></script>
</body>
</html>
