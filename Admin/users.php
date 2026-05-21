<?php require ('inc/essentials.php');
require ('inc/db_config.php');
adminLogin();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel-users</title>
    <?php require ('inc/links.php'); ?>
</head>

<body class="bg-light">
    <?php require ('inc/header.php');
    ?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden"> <!----use alt+Z fomr wordwrap--->
                <h3 class="mb-4">USERS</h3>



                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-body">

                        <div class="text-end mb-4 ">
                            <!----<button type="button" class="btn btn-dark shadow-none btn-sm" data-bs-toggle="modal"
                                data-bs-target="#add-room">
                                <i class="bi bi-plus-square"> </i>Add
                            </button>---->
                        </div>

                        <div class="table-responsive">
                            <table class="table table-hover border">
                                <thead>
                                    <tr class="bg-dark text-white">
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Action</th>
                                        
                                    </tr>
                                </thead>
                                <tbody id="users-data">

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>



            </div>
        </div>
    </div>



    

    <?php require ('inc/scripts.php'); ?>
<script src="scripts/users.js"></script>
</body>

</html>