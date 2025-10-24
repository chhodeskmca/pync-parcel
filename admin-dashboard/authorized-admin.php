<?php
include_once __DIR__ . '/../function.php'; // Include to get user_account_information()

$scheme = isset($_SERVER['REQUEST_SCHEME']) ? $_SERVER['REQUEST_SCHEME'] : (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http');
$base_url = $scheme . '://' . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['SCRIPT_NAME'], 2), '/') . '/';

if(isset($_COOKIE['user_id'])){

    if( user_account_information()['role_as']  == 1 ){

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

