<?php 
    // initialize session
    session_start();  
	include('../config.php'); // database connection 
	if( isset($_REQUEST['email']) ) 
	{ 
		
		$Email = ltrim( mysqli_real_escape_string($conn, htmlspecialchars($_REQUEST['email'])) ) ; 
		// checking email exists or not in database
		$sql = "SELECT * FROM users where emailaddress = '$Email'";
		$result = mysqli_query($conn, $sql);
		$table_rows =  mysqli_num_rows( $result ) ;
		
	  if( !isset($_REQUEST['email'])  ){  
	  
			 header('location: ../index.php');
			 die(); 
	   } 
	   else if( $table_rows < 1){ 
			$_SESSION['message'] = "We don't have an account with this email address."; 
			  header('location: ../forgotpwd.php');
			  die(); 
		};  
		 $rows = mysqli_fetch_array( $result) ;  
		 $user_id = $rows['id'];
		 
		 $Token =  bin2hex(random_bytes(16)) ; 
		 $reset_token_hash  =  hash('sha256',  $Token); 
		 $token_expired_at  = date('Y-m-d H-i-s', time() + 60*60);  
		 $sql = "UPDATE users SET Token_hash = '$reset_token_hash', token_expired_at = '$token_expired_at' WHERE id = $user_id";  
		 
		if( mysqli_query($conn, $sql) ){  
		 
    		   if( isset( $_REQUEST['AnotherRequest'] ) ){ 
    		       
    		        header("location: ../../sendmail.php?PasswordResetEmail=$Email&token_hash=$reset_token_hash&AnotherRequest");  // redirect to send mail page.
    		   }else{ 
    		       
    		        header("location: ../../sendmail.php?PasswordResetEmail=$Email&token_hash=$reset_token_hash");  // redirect to send mail page.
    		   }
    			
    		  die();
			
		}else{ 
		
			 $_SESSION['message'] = "Something went wrong, please try again";
			 header('location: ../forgotpwd.php');
			 die();
		}; 
  }
	// reset password from user account-setting page
	
	if( isset( $_REQUEST['userInputCurrentPwd'] ) ){ 
	
	     $reset_password =  ltrim($_REQUEST['userInputCurrentPwd']); 
		 if( !$reset_password == '' ) 
		{ 
				 $user_id        = $_REQUEST['user_id'];
				 $hash_password  = md5('pync'.$reset_password);
				 
				 $sql    = "SELECT* FROM  users where Password_Hash = '$hash_password' AND id = $user_id"; 
				 $result =  mysqli_query($conn, $sql);
				 $rows = mysqli_num_rows($result);
				 
				 echo $rows; 	 
					 
		}else{ 
		
		      echo 401 ;   
		}
	  
	}; 
?>