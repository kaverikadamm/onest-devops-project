<?php
require('../inc/db_config.php');    // Ensure this path is correct and points to the correct db_config.php
require('../inc/essentials.php');
adminLogin();



if (isset($_POST['get_users'])) {
    $res = selectAll('users');
    $i = 1; // Start from 1 for better user experience



    $data = "";

    while ($row = mysqli_fetch_assoc($res)) {

        $del_btn = "<button type='button'onclick='remove_user($row[id])' class='btn btn-danger  shadow-none'>
        <i class='bi bi-trash'> </i>
        </button>";
        $date = date("d-m-Y", strtotime($row['added_on']));
        $data .= "
            <tr>
            <td>$i</td>
            <td>$row[name]</td>
            <td>$row[email]</td>
            <td>$row[added_on]</td>
            <td>$del_btn</td>


            </tr>
        ";
        $i++;
    }

    echo $data;
}




if (isset($_POST['remove_user'])) {

    $frm_data = filteration($_POST);

    $res1 = update("DELETE FROM `users` WHERE `id`=?", [$frm_data['user_id']], 'i');
    if ($res1) {
        echo 1;
    } else {
        echo 0;
    }
}



if (isset($_POST['toggle_status'])) {
    $frm_data = filteration($_POST);

    $q = "UPDATE `rooms` SET `status`=? WHERE `id`=?";
    $v = [$frm_data['value'], $frm_data['toggle_status']];

    echo update($q, $v, 'ii') ? 1 : 0;
}
?>