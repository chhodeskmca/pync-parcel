<?php 
    session_start();  
    $tracking_number = $_REQUEST['tracking_number'] ?? null;
	include('config.php'); // database connection
	include('function.php'); // function connection
	error_reporting(E_ALL);
    ini_set('display_errors', 1);
	//==================================================User basic account info updating start===============================
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
		$Region       =  ltrim( mysqli_real_escape_string($conn, htmlspecialchars($_REQUEST['Region'])) ); 
		$oldImage     =   $_REQUEST['old_image'] ?? '';
		$File         =   ''; 
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
		if( empty($phone) )
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
			//$_SESSION['message-6'] =  'Please Enter Address Type';
			//$_SESSION['message']   =  'Please Enter Address Type';
	        //header('location: user-dashboard/user-account.php?no-update-basic-data='); 
           // die();
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
		$sql = "UPDATE users SET first_name = '$first_name', last_name = '$last_name', phone_number = '$phone', date_of_birth = '$BDate', gender = '$Gender',
	            file = '$File', address_type = '$AddressType', parish = '$Parish', region = '$Region',
				address_line1 = '$AddressLine1', address_line2 = '$AddressLine2' WHERE id = $user_id";
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

			     $sql = "SELECT * FROM delivery_preference WHERE user_id = $user_id AND address_type = '$AddressType' " ; //checking if address not saved
			     if( mysqli_num_rows(mysqli_query($conn, $sql)) == 0){ 

			          $sql =  "INSERT INTO delivery_preference (user_id, address_type, parish, region, address_line1, address_line2) 
			          VALUES ($user_id, '$AddressType', '$Parish', '$Region', '$AddressLine1', '$AddressLine2')" ;   
			          mysqli_query($conn, $sql) ;

			     }else if( 1 ){ 

			      $sql = "UPDATE delivery_preference SET address_type = '$AddressType', parish ='$Parish', region ='$Region', 
			             address_line1='$AddressLine1', address_line2 ='$AddressLine2'  WHERE user_id = $user_id AND address_type = '$AddressType' ";  
			             mysqli_query($conn, $sql);

			     }	 
				$_SESSION['message']   =  "Account information has been updated";
				header('location: user-dashboard/user-account.php'); 
				die();

		 }else{ 

			$_SESSION['message']   =  'Something went wrong, Please try later.1';
	        header('location: user-dashboard/user-account.php'); 
            die(); 

		 }; 
		 
		 //unlink("uploaded-file/IMG_20230110_165249.jpg");
	};
     //==================================================User basic account info updating end===============================
	
     //================================================== Authorized Users Start=============================== 
	if( isset( $_REQUEST['delivery-updatingBtn'] )){ 
	  
	     $first_name = ltrim( mysqli_real_escape_string($conn, htmlspecialchars($_REQUEST['first_name'])) );
	     $last_name = ltrim( mysqli_real_escape_string($conn, htmlspecialchars($_REQUEST['last_name'])) );
	     $IdType = ltrim( mysqli_real_escape_string($conn, htmlspecialchars($_REQUEST['IdType'])) );
	     $first_name = ltrim( mysqli_real_escape_string($conn, htmlspecialchars($_REQUEST['IdNber']))); 
		 
        $sql = "UPDATE authorized_users SET  first_name ='$first_name', last_name ='$last_name', IdType ='$IdType', IdNumber ='$first_name' WHERE id = $user_id"; 
		if( mysqli_query($conn, $sql)){ 
		
		        $_SESSION['message']   =  'Updating has been successfully';
				header('location: user-dashboard/user-account.php'); 
			    die();
		}else{ 
		
		    $_SESSION['message']   =  'Something went wrong, Please try later';
		    header('location: user-dashboard/user-account.php'); 
			die();
		};
    		 
	};
	 
     //================================================== Authorized Users  end===============================
 
     //================================================== Pre alert Start===============================
 
     if( isset($_REQUEST['Pre-alert']) ){ 
	    
		$tracking_number = ltrim( mysqli_real_escape_string($conn, htmlspecialchars($_REQUEST['tracking_number'])) );
	    $ValueofPackage = ltrim( mysqli_real_escape_string($conn, htmlspecialchars($_REQUEST['ValueofPackage'])) );
	    $courier_company = ltrim( mysqli_real_escape_string($conn, htmlspecialchars($_REQUEST['courier_company'])) );
	    $describe_package = ltrim( mysqli_real_escape_string($conn, htmlspecialchars($_REQUEST['describe_package']))); 
	    $merchant = ltrim( mysqli_real_escape_string($conn, htmlspecialchars($_REQUEST['merchant']))); 
	    $File = $_FILES['file']['name'] == '' ? '' : $_FILES['file']['name'] ;

			if(  $File != ''){

		        // File uploading
		        $fileExtension =   pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);  // getting file extension
				if(    $fileExtension != 'pdf' && $fileExtension != 'doc'
					   && $fileExtension != 'docx' && $fileExtension != 'jpg' &&
					   $fileExtension != 'jpeg' && $fileExtension != 'png')
				{
					$_SESSION['message']   =  'The file is not allowed';
					header('location: user-dashboard/createprealert.php');
					die();

				}
			    if( $_FILES['file']['size'] / 1024 / 1024 >= 10 ) // MAX size 10MB allowed
				{
					$_SESSION['message']   =  'The file is too large';
					header('location: user-dashboard/createprealert.php');
					die();

				};

				$File  = uniqid('', true) . '.' . $fileExtension ; //unique file name
		        $fileTmp   =   $_FILES['file']['tmp_name'];
			};
				
		 $sql = "INSERT INTO pre_alert ( User_id , tracking_number, value_of_package, courier_company, merchant, describe_package, invoice, created_at) VALUES ( $user_id, '$tracking_number', $ValueofPackage, '$courier_company', '$merchant', '$describe_package',  '$File', NOW())";

		 if( mysqli_query( $conn,  $sql )){

		     // Insert into packages table
		 $sql_package = "INSERT INTO packages (user_id, tracking_number, courier_company, describe_package, weight, value_of_package, store, created_at) VALUES ($user_id, '$tracking_number', '$courier_company', '$describe_package', '—', $ValueofPackage, '$merchant', NOW())";
		     mysqli_query($conn, $sql_package);

             // Insert old pre-alerts not in packages
             $sql_old_prealerts = "INSERT INTO packages (user_id, tracking_number, courier_company, describe_package, weight, value_of_package, store, created_at)
                 SELECT User_id, tracking_number, courier_company, describe_package, '—', value_of_package, merchant, created_at
                 FROM pre_alert
                 WHERE User_id = $user_id
                 AND tracking_number NOT IN (SELECT tracking_number FROM packages WHERE user_id = $user_id)";
             mysqli_query($conn, $sql_old_prealerts);
		 
		       if(  $File != '' ){
				    
					 if( move_uploaded_file($fileTmp, "uploaded-file/$File") )
					    { 
							 
								$_SESSION['message']   =  'You have created pre-alert successfully';
								 header('location: user-dashboard/createprealert.php'); 
								 die();
								
						}
						else{ 
							
								$_SESSION['message']  = "Something went wrong, Please try later";
								header('location: user-dashboard/createprealert.php');
								die();	
				        };
		        }else{ 
				
				        $_SESSION['message']   =  'You have created pre-alert successfully';
						header('location: user-dashboard/createprealert.php'); 
						die();
				}
		 }else{ 
		 
				 $_SESSION['message']  = "Something went wrong, Please try later";
				 header('location: user-dashboard/createprealert.php');
				 die();
		 
		 };
	 
	 };
 
 //================================================== Pre alert end===============================
 
  //================================================== Pre alert updating start===============================
 
  if( isset($_REQUEST['updatePreAltBtn']) ){

    $tracking_number = $_REQUEST['tracking_number'] ;
    $value_of_package = $_REQUEST['value_of_package'] ;
    $courier_company = $_REQUEST['courier_company'] ;
    $describe_package = $_REQUEST['describe_package'] ;
    $merchant = $_REQUEST['merchant'] ;
    $Pre_alert_id = $_REQUEST['Pre_alert_id'] ;
    $old_image = ltrim($_REQUEST['old_image']) ;

    // Get old tracking_number for packages update
    $sql_old = "SELECT tracking_number FROM pre_alert WHERE id = $Pre_alert_id AND User_id = $user_id";
    $result_old = mysqli_query($conn, $sql_old);
    $old_tracking_number = '';
    if ($result_old && mysqli_num_rows($result_old) > 0) {
        $row_old = mysqli_fetch_assoc($result_old);
        $old_tracking_number = $row_old['tracking_number'];
    }

    // Check if editing is locked after 24 hours
    $sql_check = "SELECT created_at FROM pre_alert WHERE id = $Pre_alert_id AND User_id = $user_id";
    $result = mysqli_query($conn, $sql_check);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if (!isset($row['created_at']) || empty($row['created_at'])) {
            // Old records without created_at are considered old, lock them
            $_SESSION['message'] = 'Editing is locked after 24 hours of creation.';
            header("location: user-dashboard/updateprealert.php?pre_alert_id=$Pre_alert_id");
            die();
        } else {
            $created_at = strtotime($row['created_at']);
            $now = time();
            if (($now - $created_at) > 0) { // lock all past records
                $_SESSION['message'] = 'Editing is locked after 24 hours of creation.';
                header("location: user-dashboard/updateprealert.php?pre_alert_id=$Pre_alert_id");
                die();
            }
        }
    } else {
        $_SESSION['message'] = 'Pre-alert not found.';
        header("location: user-dashboard/createprealert.php");
        die();
    }

	 	if( $_FILES['file']['name'] == '' )
		{
		   $File  = $old_image;

		}else{
				$fileExtension =   pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);  // getting file extension
				if( $fileExtension != 'pdf' && $fileExtension != 'doc'
					&& $fileExtension != 'docx' && $fileExtension != 'jpg' &&
					$fileExtension != 'jpeg' && $fileExtension != 'png')
				{
					$_SESSION['message']   =  'The file is not allowed';
					header("location: user-dashboard/updateprealert.php?pre_alert_id=$Pre_alert_id");
					die();
				}
			    if( $_FILES['file']['size'] / 1024 / 1024 >= 10 ) // MAX size 10MB allowed
				{
					$_SESSION['message']   =  'The file is too large';
					header("location: user-dashboard/updateprealert.php?pre_alert_id=$Pre_alert_id");
					die();

				};
				$File  = uniqid('', true) . '.' . $fileExtension ;

		};

		$sql = "UPDATE pre_alert SET tracking_number = '$tracking_number', value_of_package =  $value_of_package, courier_company = '$courier_company', merchant = '$merchant', describe_package ='$describe_package', invoice = '$File' WHERE id = $Pre_alert_id";
		if( mysqli_query($conn, $sql)){
		    // Update corresponding package record
		    $sql_update_package = "UPDATE packages SET tracking_number = '$tracking_number', courier_company = '$courier_company', describe_package = '$describe_package', value_of_package = $value_of_package, store = '$merchant' WHERE user_id = $user_id AND tracking_number = '$old_tracking_number'";
		    mysqli_query($conn, $sql_update_package);
		 
		      	    if(  $_FILES['file']['name'] != ''){

					unlink("uploaded-file/$old_image");
					$fileTmp   =   $_FILES['file']['tmp_name'];
					$File_name =   $File;

					if( move_uploaded_file($fileTmp, "uploaded-file/$File_name") ){
					  
						$_SESSION['message']   =  'Pre-alert has been updated';
						header('location: user-dashboard/createprealert.php'); 
						die();
					
										
					}else{ 
					
					    $_SESSION['message']  = "Something went wrong, Please try later";
						header('location: user-dashboard/createprealert.php'); 
						die();	
					};
					
				}else{ 
				
				  	$_SESSION['message']   =  'Pre-alert has been updated';
					header('location: user-dashboard/createprealert.php'); 
					die();
				}	
		
		}else{ 
		        $_SESSION['message']   =  'Something went wrong, Please try later';
			    header("location: user-dashboard/updateprealert.php?pre_alert_id=$Pre_alert_id"); 
			    die(); 
		};
    }; 
 //================================================== Pre alert updating end===============================
 
 //================================================== password updating start===============================
  
  
  	if( isset($_REQUEST['pwd_update'] ) ){   
  
         $pwd = ltrim( mysqli_real_escape_string($conn, htmlspecialchars($_REQUEST['NewPassword'])) ) ;  
	     $hash_password =  md5('pync'.$pwd); 
		 $sql = "UPDATE  users SET Password_Hash = '$hash_password' where id = $user_id"; 
		 if( mysqli_query($conn, $sql)){  

			echo 200;
			  
		 }else{ 
		     
			echo 401;
		 }
	
	};
	
 //================================================== password updating end=============================== 
 
 //==================================================address type updating start=============================== 
 
   	if( isset($_REQUEST['addresType']) ){  
   	    
   	    $address_type =  $_REQUEST['addresType'] ;
   	     
   	     $sql = "SELECT * FROM delivery_preference WHERE user_id = $user_id AND address_type = '$address_type' " ; //checking if address  saved
			     if( mysqli_num_rows(mysqli_query($conn, $sql)) == 1){  
			         
			         $result = mysqli_query($conn, $sql) ;  
			         $rows   = mysqli_fetch_assoc($result); 
			         echo json_encode($rows);
			         
			         
			     }else{ 
			         
			         echo 0;
			     };
			     
   	 }
 //==================================================address type updating end===============================




?>