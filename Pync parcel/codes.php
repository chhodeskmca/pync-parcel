<?php 
    session_start();  
    $Tracking_Number = $_REQUEST['Tracking_Number'] ;
	include('config.php'); // database connection
	include('function.php'); // function connection
	//error_reporting(E_ALL);
    //ini_set('display_errors', 1);
	//==================================================User basic account info updating start===============================
    if( isset($_REQUEST['user_basic_account_info_btn'] ) ){ 
	     // User  form input values
		$FName        =  ltrim( mysqli_real_escape_string($conn, htmlspecialchars($_REQUEST['FName'])) );
		$LName        =  ltrim( mysqli_real_escape_string($conn, htmlspecialchars($_REQUEST['LName'])) );
		$phone        =  ltrim( mysqli_real_escape_string($conn, htmlspecialchars($_REQUEST['phone'])) );
		$BDate        =  ltrim( mysqli_real_escape_string($conn, htmlspecialchars($_REQUEST['BDate'])) );
		$Gender       =  ltrim( mysqli_real_escape_string($conn, htmlspecialchars($_REQUEST['Gender'])) );
		$AddressType  =  ltrim( mysqli_real_escape_string($conn, htmlspecialchars($_REQUEST['AddressType'])) );
		$Parish       =  ltrim( mysqli_real_escape_string($conn, htmlspecialchars($_REQUEST['Parish'])) );
		$AddressLine1 =  ltrim( mysqli_real_escape_string($conn, htmlspecialchars($_REQUEST['AddressLine1'])) );
		$AddressLine2 =  ltrim( mysqli_real_escape_string($conn, htmlspecialchars($_REQUEST['AddressLine2'])) );
		$Region       =  ltrim( mysqli_real_escape_string($conn, htmlspecialchars($_REQUEST['Region'])) ); 
		$oldImage     =   $_REQUEST['old_image'] ;
		$File         =   ''; 
		if( $FName == '' ) 
		{    
			$_SESSION['message-1'] =  'Please Enter First Name';
			$_SESSION['message']   =  'Please Enter First Name';
	        header('location: user-dashboard/user-account.php?no-update-basic-data='); 
            die();
		};
	    if( $LName == '') 
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
		$sql = "UPDATE users SET FName = '$FName', LName = '$LName', PhoneNumber = '$phone', DateOfBirth = '$BDate', Gender = '$Gender', 
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
		 
		 //unlink("uploaded-file/IMG_20230110_165249.jpg");
	};
     //==================================================User basic account info updating end===============================
	
     //================================================== Authorized Users Start=============================== 
	if( isset( $_REQUEST['delivery-updatingBtn'] )){ 
	  
	     $FName = ltrim( mysqli_real_escape_string($conn, htmlspecialchars($_REQUEST['Fname'])) );
	     $Lname = ltrim( mysqli_real_escape_string($conn, htmlspecialchars($_REQUEST['Lname'])) );
	     $IdType = ltrim( mysqli_real_escape_string($conn, htmlspecialchars($_REQUEST['IdType'])) );
	     $FName = ltrim( mysqli_real_escape_string($conn, htmlspecialchars($_REQUEST['IdNber']))); 
		 
        $sql = "UPDATE authorized_users SET  FName ='$FName', LName ='$Lname', IdType ='$IdType', IdNumber ='$FName' WHERE id = $user_id"; 
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
	    
		$Tracking_Number = ltrim( mysqli_real_escape_string($conn, htmlspecialchars($_REQUEST['Tracking_Number'])) );
	    $ValueofPackage = ltrim( mysqli_real_escape_string($conn, htmlspecialchars($_REQUEST['ValueofPackage'])) );
	    $Courier_Company = ltrim( mysqli_real_escape_string($conn, htmlspecialchars($_REQUEST['Courier_Company'])) );
	    $Describe_Package = ltrim( mysqli_real_escape_string($conn, htmlspecialchars($_REQUEST['Describe_Package']))); 
	    $Merchant = ltrim( mysqli_real_escape_string($conn, htmlspecialchars($_REQUEST['Merchant']))); 
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
				
				$File  = $_FILES['file']['name'] ; //file name
		        $fileTmp   =   $_FILES['file']['tmp_name'];  
			};
				
		 $sql = "INSERT INTO pre_alert ( User_id , Tracking_Number, Value_of_Package, Courier_Company, Merchant, Describe_Package, invoice) VALUES ( $user_id, '$Tracking_Number', $ValueofPackage, '$Courier_Company', '$Merchant', '$Describe_Package',  '$File')";
		 
		 if( mysqli_query( $conn,  $sql )){ 
		 
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
  
    $Tracking_Number = $_REQUEST['Tracking_Number'] ;
    $Value_of_Package = $_REQUEST['Value_of_Package'] ;
    $Courier_Company = $_REQUEST['Courier_Company'] ;
    $Package_Content = $_REQUEST['Package_Content'] ;
    $Merchant = $_REQUEST['Merchant'] ;
    $Pre_alert_id = $_REQUEST['Pre_alert_id'] ;
    $old_image = ltrim($_REQUEST['old_image']) ;
	
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
				$File  = $_FILES['file']['name'] ;
		
		};
	
		$sql = "UPDATE pre_alert SET Tracking_Number = '$Tracking_Number', Value_of_Package =  $Value_of_Package, Courier_Company = '$Courier_Company', Merchant = '$Merchant', Describe_Package ='$Package_Content', invoice = '$File' WHERE id = $Pre_alert_id";
		if( mysqli_query($conn, $sql)){ 
		 
		      	    if(  $_FILES['file']['name'] != ''){ 
				   
					unlink("uploaded-file/$old_image");
					$fileTmp   =   $_FILES['file']['tmp_name'];  
					$File_name =   $_FILES['file']['name'];  
					
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
	
 Echo "You are not allowed to this page!";
 





?>