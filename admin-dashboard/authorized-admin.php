<?php
include_once __DIR__ . '/../function.php'; // Include to get user_account_information()

$base_url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME'], 2) . '/';

if(isset($_COOKIE['user_id'])){

    if( user_account_information()['Role_As']  == 1 ){

        // You are admin, proceed to load the page

	}else{

	    header('location: ' . $base_url . 'sign-in.php');
        exit();
	}

 }else{

  header('location: ' . $base_url . 'sign-in.php');
  exit();

}


?>

