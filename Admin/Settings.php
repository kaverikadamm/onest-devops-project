<?php require ('inc/essentials.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel-Settings</title>
    <?php require ('inc/links.php'); ?>
</head>

<body class="bg-light">
    <?php require ('inc/header.php');

    ?>

    <div class="container-fluid" id="main-content">
        <div class="row">
            <div class="col-lg-10 ms-auto p-4 overflow-hidden"> <!----use alt+Z for wordwrap--->
                <h3 class="mb-4">SETTINGS</h3>


                


                <!---shutdown section---->
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="card-title m-0">Shutdown Website</h5>
                            <div class="form-check form-switch">
                                <form>
                                    <input onchange="upd_shutdown(this.value)" class="form-check-input" type="checkbox"
                                        id="shutdown_toggle">
                                </form>
                            </div>
                        </div>
                        <p class="card-text">
                            No customers will be allowed to book resort rooms when shutdown mode is on
                        </p>

                    </div>
                </div>


            </div>
        </div>
    </div>
    <?php require ('inc/scripts.php'); ?>

    <!--Ajax code-->
    <script>
        let general_data;


        function get_general() {
        

            let shutdown_toggle = document.getElementById('shutdown_toggle');


            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/settings_crud.php", true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onload = function () {
                general_data = JSON.parse(this.responseText);




                if (general_data.shutdown == 0) {
                    shutdown_toggle.checked = false;           //0 means false i.e website is sot shut down
                    shutdown_toggle.value = 0;
                }
                else {
                    shutdown_toggle.checked = true;
                    shutdown_toggle.value = 1;

                }
            }

            xhr.send('get_general');

        }



        function upd_shutdown(val) {

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "ajax/settings_crud.php", true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onload = function () {
                if (this.responseText == 1 && general_data.shutdown == 0) {
                    showAlert('success', 'Site has been Shutdown');

                }
                else {
                    showAlert('success', 'shutdown mode off!');
                }
                get_general();
            }

            xhr.send('upd_shutdown=' + val);

        }

        window.onload = function () {
            get_general();

        }
    </script>
</body>

</html>