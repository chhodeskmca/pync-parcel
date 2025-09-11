<?php session_start(); ?>
<?php 
     echo $_SESSION['message'] ;
     
	include('../config.php'); // database connection
    $email =  ltrim( mysqli_real_escape_string($conn, htmlspecialchars($_REQUEST['email'])) ) ;
    $pwd   =  ltrim( mysqli_real_escape_string($conn, htmlspecialchars($_REQUEST['pwd'])) ) ;
    $hash_password =  md5('pync'.$pwd);
    if( !isset( $_GET['sing-in']) ){ 
	 	    header('location: ../index.php'); 
            die();
	}
    else if( !isset( $email ) || $email == "" ){ 
	     
		$_SESSION['message'] =  'Please Enter Email';
	    header('location: ../sign-in.php'); 
        die();
	}
    else if( !isset( $pwd ) || $pwd == "" ){ 
	     
		$_SESSION['message'] =  'Please Enter Password';
	    header('location: ../sign-in.php'); 
        die();
	}; 
	
    // Checking user email address exists or not in database;
    $sql = "SELECT * FROM users WHERE EmailAddress = '$email'";  
    $result = mysqli_query($conn,  $sql);
	$rows  =  mysqli_fetch_assoc($result); 
	
	
    if( !(mysqli_num_rows($result) == 1 && $rows['Password_Hash'] == $hash_password) ){ 
	    
	    $_SESSION['message'] = "<span style='color:#ff8f00'  class='bi bi-exclamation-triangle'> </span> Incorrect email or password." ;
        header('location: ../sign-in.php'); 
        die(); 
		
	};  
	// user account data storing in cookie
	$user = array 
		( 
		  'id'=>$rows['id'] 
		) ; 
	  
	$user = json_encode($user); // user account data array to json
    setcookie('user_id', $user, time() + (86400 * 150), "/"); // 86400 = 1 day 
	  $Name = $rows['FName'] ;
	  $_SESSION['log-in-message'] = "Welcome! $Name to Dashboard" ;
	  header('location: https://practice.freelancerhanip.com/final_pyncparcel_manageme/user-dashboard/index.php'); 
	  

	


?>




