<?php
require ('../inc/db_config.php');    /*---the two dots are used to go outside of inc--*/
require ('../inc/essentials.php');
adminLogin();


if (isset($_POST['get_general'])) {
    $q = "SELECT * FROM `settings` WHERE `sr_no`=?";
    $values = [1];
    $res = select($q, $values, "i");                     /* i is integer type and this select function is created in db_config.php---*/
    $data = mysqli_fetch_assoc($res);
    $json_data = json_encode($data);
    echo $json_data;
}




if (isset($_POST['upd_shutdown'])) 
{
    $frm_data =($_POST['upd_shutdown']==0)? 1 : 0;             //if else condition is used (ternary operator)

    $q = "UPDATE `settings` SET `shutdown`=? WHERE `sr_no`=?";
    $values = [$frm_data, 1];                      //values of above query
    $res = update($q, $values, 'ii');               
    echo $res;
}

?>