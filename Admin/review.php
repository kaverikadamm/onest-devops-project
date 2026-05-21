<?php
require('inc/essentials.php');
require('inc/db_config.php');
adminLogin();

// Check if a delete request has been made
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    
    // Prepare and execute the delete query
    $delete_query = "DELETE FROM testimonials WHERE id = ?";
    $stmt = $con->prepare($delete_query);
    
    if ($stmt) {
        $stmt->bind_param("i", $delete_id);
        if ($stmt->execute()) {
            // Redirect to avoid re-submission on refresh
            header('Location: review.php');
            exit();
        } else {
            echo "Error deleting testimonial: " . $con->error;
        }
        $stmt->close();
    } else {
        echo "Error preparing the delete query: " . $con->error;
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Testimonials</title>
    <?php require('inc/links.php'); ?>
</head>

<body class="bg-light">
    <?php require('inc/header.php'); ?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden">
                <h3 class="mb-4">Reviews and ratings</h3>

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
                                        <th scope="col">Name</th>
                                        <th scope="col" width="40%">Content</th>
                                        <th scope="col">Rating</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="testimonials-data">
                                    <?php
                                    // Fetch testimonials from the database
                                    $query = "SELECT * FROM testimonials ORDER BY created_at DESC";
                                    $result = $con->query($query);

                                    if (!$result) {
                                        echo "<tr><td colspan='6'>Error fetching testimonials: " . $con->error . "</td></tr>";
                                    } else {
                                        while ($row = $result->fetch_assoc()) {
                                            // Generate star rating
                                            $rating_stars = str_repeat("<i class='bi bi-star-fill text-warning'></i>", $row['rating']);
                                            $rating_stars .= str_repeat("<i class='bi bi-star-fill text-muted'></i>", 5 - $row['rating']);

                                            echo "<tr>
                                                    <td>{$row['id']}</td>
                                                  <td>{$row['user_name']}</td>
                                                    <td>{$row['content']}</td>
                                                    <td>$rating_stars</td>
                                                    <td>
                                                        <button class='btn btn-danger rounded-pill btn-sm' onclick='deleteTestimonial({$row['id']})'>Delete</button>
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
    <script>
        function deleteTestimonial(id) {
            if (confirm('Are you sure you want to delete this testimonial?')) {
                window.location.href = `review.php?delete_id=${id}`;
            }
        }
    </script>
</body>

</html>

<?php
$con->close();
?>
