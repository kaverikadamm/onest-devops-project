<?php
session_start();

require('Admin/inc/db_config.php');
require('Admin/inc/essentials.php');

$type=get_safe_value($con,$_POST['type']);
$otp=get_safe_value($con,$_POST['otp']);
if($type=='email'){
	if($otp==$_SESSION['EMAIL_OTP']){
		unset($_SESSION['EMAIL_OTP']);
		echo "done";
	}else{
		echo "no";
	}
}


?>