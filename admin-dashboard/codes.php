<?php 
    // initialize session
    session_start();   
	include('../config.php'); // database connection
 if( isset($_REQUEST['user_basic_account_info_btn'] ) ){ 
	     // User  form input values
		$first_name        =  ltrim( mysqli_real_escape_string($conn, htmlspecialchars($_REQUEST['first_name'])) );
		$last_name        =  ltrim( mysqli_real_escape_string($conn, htmlspecialchars($_REQUEST['last_name'])) );
		$phone        =  ltrim( mysqli_real_escape_string($conn, htmlspecialchars($_REQUEST['phone'])) );
		$BDate        =  ltrim( mysqli_real_escape_string($conn, htmlspecialchars($_REQUEST['BDate'])) );
		$Gender       =  ltrim( mysqli_real_escape_string($conn, htmlspecialchars($_REQUEST['Gender'])) );
		$AddressType  =  ltrim( mysqli_real_escape_string($conn, htmlspecialchars($_REQUEST['AddressType'])) );
		$Parish       =  ltrim( mysqli_real_escape_string($conn, htmlspecialchars($_REQUEST['Parish'])) );
		$AddressLine1 =  ltrim( mysqli_real_escape_string($conn, htmlspecialchars($_REQUEST['AddressLine1'])) );
		$AddressLine2 =  ltrim( mysqli_real_escape_string($conn, htmlspecialchars($_REQUEST['AddressLine2'])) );
		$Region       =   '' ;
		$oldImage     =   $_REQUEST['old_image'] ;
		$File         =   ''; 
	    if ( $_REQUEST['Region'] != '' )
		   { 
				$Region =  ltrim( mysqli_real_escape_string($conn, htmlspecialchars($_REQUEST['Region'])) );
			}
	    else if( $_REQUEST['Region2'] != '')
			{ 
			  $Region = ltrim( mysqli_real_escape_string($conn, htmlspecialchars($_REQUEST['Region2'])) );
			}
		else if(  $_REQUEST['Region3'] != '' )
			{ 
			  $Region = ltrim( mysqli_real_escape_string($conn, htmlspecialchars($_REQUEST['Region3'])) );
			};  
		if( $first_name == '' ) 
		{    
			$_SESSION['message-1'] =  'Please Enter First Name';
			$_SESSION['message']   =  'Please Enter First Name';
	        header('location: user-dashboard/user-account.php?no-update-basic-data='); 
            die();
		};
	    if( $last_name == '') 
	    { 
		      
			$_SESSION['message-2'] =  'Please Enter Last Name';
			$_SESSION['message']   =  'Please Enter Last Name';
	        header('location: user-dashboard/user-account.php?no-update-basic-data='); 
            die();
		};
		if( $phone == '') 
		{   
			$_SESSION['message-3'] =  'Please Enter Phone number';
			$_SESSION['message']   =  'Please Enter Phone number';
	        header('location: user-dashboard/user-account.php?no-update-basic-data='); 
            die();
		}; 
		if( $BDate == '' ) 
		{ 
			$_SESSION['message-4'] =  'Please Enter Date of Birth';
			$_SESSION['message']   =  'Please Enter Date of Birth';
	        header('location: user-dashboard/user-account.php?no-update-basic-data='); 
            die();
		};
	    if(  !isset( $_REQUEST['Gender']) ) 
		{ 
			$_SESSION['message-10'] =  'Please Enter Gender';
			$_SESSION['message']   =  'Please Enter Gender';
	        header('location: user-dashboard/user-account.php?no-update-basic-data='); 
            die();
		};
		if( $_FILES['file']['name'] == '' )  
		{
			
			if( user_account_information()['file'] == ''){ 
			
			   $_SESSION['message-5'] =  'Please Enter your Copy of Photo Identification';
			   $_SESSION['message']   =  'Please Enter your Copy of Photo Identification';
	           header('location: user-dashboard/user-account.php?no-update-basic-data='); 
               die(); 
			
			}else{ 
			
			 $File  = $oldImage;
			
			}
		
			
		}else{ 
				$fileExtension =   pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);  // getting file extension
				if(    $fileExtension != 'pdf' && $fileExtension != 'doc' 
					   && $fileExtension != 'docx' && $fileExtension != 'jpg' &&  
					   $fileExtension != 'jpeg' && $fileExtension != 'png') 
				{  
					$_SESSION['message-5'] =  'The file is not allowed';
					$_SESSION['message']   =  'The file is not allowed';
					header('location: user-dashboard/user-account.php?no-update-basic-data='); 
					die();
				} 
			    if( $_FILES['file']['size'] / 1024 / 1024 >= 10 ) // MAX size 10MB allowed
				{ 
					$_SESSION['message-5'] =  'The file is too large';
					$_SESSION['message']   =  'The file is too large';
					header('location: user-dashboard/user-account.php?no-update-basic-data='); 
					die(); 
					
				}; 
				$File  = $_FILES['file']['name'] ;
		
		};		
		if( $AddressType == '') 
		{ 
			$_SESSION['message-6'] =  'Please Enter Address Type';
			$_SESSION['message']   =  'Please Enter Address Type';
	        header('location: user-dashboard/user-account.php?no-update-basic-data='); 
            die();
		}
		if( $Parish == '') 
		{ 
			$_SESSION['message-7'] =  'Please Enter Parish';
			$_SESSION['message']   =  'Please Enter Parish';
	        header('location: user-dashboard/user-account.php?no-update-basic-data='); 
            die();
		};		
	    if(  $Region == '' ) 
		{ 
			$_SESSION['message-8'] =  'Please Enter Region';
			$_SESSION['message']   =  'Please Enter Region';
	        header("location: user-dashboard/user-account.php?no-update-basic-data=$Region"); 
            die();
			
		}; 
		if(  $AddressLine1 == '' ) 
		{ 
			$_SESSION['message-9'] =  'Please Enter Address Line 1';
			$_SESSION['message']   =  'Please enter Address Line 1';
	        header('location: user-dashboard/user-account.php?no-update-basic-data='); 
            die();
			
		};
		
		// Updating user basic information
		$sql = "UPDATE users SET first_name = '$first_name', last_name = '$last_name', PhoneNumber = '$phone', DateOfBirth = '$BDate', Gender = '$Gender', 
	            file = '$File', AddressType = '$AddressType', Parish = '$Parish', Region = '$Region', 
				AddressLine1 = '$AddressLine1', AddressLine2 = '$AddressLine2' WHERE id = $user_id";
		if( mysqli_query($conn, $sql)){
				    
			    if(  $_FILES['file']['name'] != ''){ 
				   
					unlink("uploaded-file/$oldImage");
					$fileTmp   =   $_FILES['file']['tmp_name'];  
					$File_name =   $_FILES['file']['name'];  
					
					if( move_uploaded_file($fileTmp, "uploaded-file/$File_name") ){ 
					  
						$_SESSION['message']   =  'Account information has been updated';
						header('location: user-dashboard/user-account.php'); 
						die();
					
										
					}else{ 
					
					    $_SESSION['message']  = "Something went wrong, Please try later";
						header('location: user-dashboard/user-account.php');
						die();	
					}; 
					
				};	
					
				$_SESSION['message']   =  'Account information has been updated';
				header('location: user-dashboard/user-account.php'); 
				die();
				
		 }else{ 
		  
			$_SESSION['message']   =  'Something went wrong, Please try later.1';
	        header('location: user-dashboard/user-account.php'); 
            die(); 
		 
		 }; 
	};
     //==================================================User basic account info updating end===============================


     //================================================== Credit adding in user account start===============================
	 
	 if( isset($_REQUEST['new_credit_btn']) ){ 
	    
		        $new_credit    =  ltrim( mysqli_real_escape_string($conn, htmlspecialchars($_REQUEST['new_credit'])) );
		        $user_id       =  ltrim( mysqli_real_escape_string($conn, htmlspecialchars($_REQUEST['user_id'])) );
		        $user_name     =  ltrim( mysqli_real_escape_string($conn, htmlspecialchars($_REQUEST['user_name'])) );
		        $account_number =  ltrim( mysqli_real_escape_string($conn, htmlspecialchars($_REQUEST['account_number'])) ); 
				
				 $sql = "SELECT total_balance FROM balance WHERE user_id = $user_id";
				 $result = mysqli_query($conn, $sql);
				    if( mysqli_num_rows($result) > 0 )
					{
				       $rows = mysqli_fetch_array($result);
					   $total_balance =  $rows['total_balance'] + $new_credit;

						$sql =  "UPDATE balance SET total_balance = $total_balance WHERE user_id = $user_id";

						if( mysqli_query($conn, $sql)){
						$sql = "INSERT INTO balance (user_id, amount, created_at) VALUES ($user_id, $new_credit, NOW())";
						  if( mysqli_query($conn, $sql) ){

								$_SESSION['message']   =  'Credit updated successfully';
								header("location: customer-view.php?user_id=$user_id&user_name=$user_name&account_number=$account_number");
								die();

						  }else{

							    $_SESSION['message']   =  'Something went wrong';
								header("location: customer-view.php?user_id=$user_id&user_name=$user_name&account_number=$account_number");
								die();
						  }
						}else{

						        $_SESSION['message']   =  'Something went wrong';
								header("location: customer-view.php?user_id=$user_id&user_name=$user_name&account_number=$account_number");
								die();
						}

				    }else{

						// If no balance record exists, insert new one
						$sql = "INSERT INTO balance (user_id, total_balance, amount, created_at) VALUES ($user_id, $new_credit, $new_credit, NOW())";
						if( mysqli_query($conn, $sql) ){

							$_SESSION['message']   =  'Credit updated successfully';
							header("location: customer-view.php?user_id=$user_id&user_name=$user_name&account_number=$account_number");
							die();

						}else{

							$_SESSION['message']   =  'Something went wrong';
							header("location: customer-view.php?user_id=$user_id&user_name=$user_name&account_number=$account_number");
							die();
						}
					};
				
	          
		};
		//================================================== Credit adding in user account end=============================== 
		
		//================================================== Pre-alert showing for Pre-alert page start ===============================  
		
		if( isset($_REQUEST['showing_PreAlert_for_PreAlert_page']) ){ 
		
		     $Pre_alert_id = $_REQUEST['Pre_alert_id']; 
			 $sql     = "SELECT* FROM pre_alert where id = $Pre_alert_id"; 
			 $result  = mysqli_query($conn, $sql); 
			 $rows = mysqli_fetch_assoc($result); 
			 echo json_encode($rows);
		     
		}
		 
		//================================================== Pre-alert showing for Pre-alert page end  =============================== 
	   
?>