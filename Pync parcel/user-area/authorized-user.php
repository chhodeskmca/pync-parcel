<?php 
 if(isset($_COOKIE['user_id'])){ 
 
   echo user_account_information()['Role_As'];
    if( user_account_information()['Role_As']  == 1 ){ 
        
        // You are admin
		header('location: ../admin-dashboard/index.php');  // redirecting to admin dashboard; 
		
	};
 }else{ 

  echo "<h1>Sorry, you are not allowed to access this page. </h1>"; 
  die();

}


?>

