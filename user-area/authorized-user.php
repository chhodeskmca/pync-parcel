<?php
include('../function.php');
$base_url = (isset($_SERVER['REQUEST_SCHEME']) ? $_SERVER['REQUEST_SCHEME'] : 'http') . '://' . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['SCRIPT_NAME'], 2), '/') . '/';

 if(isset($_COOKIE['user_id'])){

    if( user_account_information()['role_as']  == 1 ){

        // You are admin
		header('location: ' . $base_url . 'admin-dashboard/index.php');  // redirecting to admin dashboard;
		exit();

	} else {
        // You are a regular user
        if (strpos($_SERVER['REQUEST_URI'], 'user-dashboard') === false) {
            header('location: ' . $base_url . 'user-dashboard/index.php');  // redirecting to user dashboard;
            exit();
        }
    }
 }else{

  header('location: ' . $base_url . 'sign-in.php');
  exit();

}


?>

