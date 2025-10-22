<?php session_start();  // initialize session
    
    
	include('../config.php'); // database connection
	include('../function.php'); // function
    include('../user-area/authorized-user.php'); // function
	$current_file_name =  basename($_SERVER['PHP_SELF']);  // getting current file name 

	if( isset($_REQUEST['pwd_update'] ) ){   
  
         $pwd = ltrim( mysqli_real_escape_string($conn, htmlspecialchars($_REQUEST['New-password'])) ) ;  
	     $hash_password =  md5('pync'.$pwd); 
		 $sql = "UPDATE  users SET Password_Hash = '$hash_password' where id = $user_id "; 
		 if( mysqli_query($conn, $sql)){  
		  
		    $_SESSION['message'] = 'Password has been updated!';
			header('location: user-account.php');
			  
		 }else{ 
		    
			$_SESSION['message'] = "<span style='color:red'>Something went wrong.</span>";
			header('location: user-account.php');
		 }
	
	};
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Profile - Pync Parcel Chateau</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no"  name="viewport" />
	  <!-- CSS for Tracking icons -->
	 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
     <link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.4/tutorials/timelines/timeline-5/assets/css/timeline-5.css"> 
	  <!--alertify css -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/css/alertify.min.css" integrity="sha512-IXuoq1aFd2wXs4NqGskwX2Vb+I8UJ+tGJEu/Dc0zwLNKeQ7CW3Sr6v0yU3z5OQWe3eScVIkER4J9L7byrgR/fA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- CSS Files -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/kaiadmin.min.css" />
	<!-- custom css -->
    <link rel="stylesheet" href="assets/css/custom.css" />
  </head>
  <body>
    <div class="wrapper profile">
      <!-- Sidebar -->
      <div class="sidebar">
        <div class="sidebar-logo">
          <!-- Logo Header -->
          <div class="logo-header">
            <a href="../index.php" class="logo">
              <img
                src="assets/img/logo.png"
                alt="navbar brand"
                class="navbar-brand"
              />
            </a>
            <div class="nav-toggle">
              <button class="btn btn-toggle toggle-sidebar">
                <i class="gg-menu-right"></i>
              </button>
              <button class="btn btn-toggle sidenav-toggler">
                <i class="gg-menu-left"></i>
              </button>
            </div>
            <button class="topbar-toggler more">
              <i class="gg-more-vertical-alt"></i>
            </button>
          </div>
          <!-- End Logo Header -->
        </div>
        <div class="sidebar-wrapper scrollbar scrollbar-inner">
          <div class="sidebar-content">
            <ul class="nav nav-secondary">
              <li class="nav-item active">
                <a  href="index.php">
                   <img class="home-icon" src="assets/img/home.png" alt="home" />
                  <p>Dashboard</p> 
                </a>
              </li>
              <li class="nav-item">
                <a  href="package.php">
                  <img class="package-icon" src="assets/img/package.png" alt="package" />
                  <p>Packages</p>
                </a>
			  </li>
              <li class="nav-item">
                <a  href="createprealert.php">
                  <img class="ctePrealt-icon" src="assets/img/create-prealert.png" alt="Prealert" />
                  <p>Create Pre-alert</p>
                </a>
              </li>
              <li class="nav-item">
                <a  href="cost-calculator.php">
                <img class="calculator-icon" src="assets/img/calculator.png" alt="Calculator" />
                  <p>Cost Calculator</p>
                </a>
              </li> 
			  <li class="nav-item">
                <a  href="makepayment.php">
                  <img class="payment-icon" src="assets/img/payment-protection.png" alt="payment" />
                  <p>Make Payment</p>
                </a>
              </li>
			  <li class="nav-item">
                <a  href="makepayment.php">
                <img class="user-icon" src="assets/img/location.png" alt="location" />
                  <p>My Miami Address</p>
                </a>
              </li>
              <li class="nav-item">
                <a  href="user-account.php">
                <img class="user-icon" src="assets/img/user.png" alt="User" />
                  <p style="<?php echo  $current_file_name == 'user-account.php' ? 'color: #E87946 !important' : ''; ?>">My account</p>
                </a>
              </li>
			   <li class="nav-item log-out">
                <a  href="../user-area/log-out.php">
                <img class="user-icon" src="assets/img/shutdown.png" alt="User" />
                  <p>Log out</p>
                </a>
              </li>
			</ul>
          </div>
        </div>
      </div>
      <!-- End Sidebar -->
      <div class="main-panel">
        <div class="main-header">
          <div class="main-header-logo">
            <!-- Logo Header -->
            <div class="logo-header">
              <a href="index.php" class="logo">
                <img
                  src="assets/img/logo.png"
                  alt="navbar brand"
                  class="navbar-brand"
                  height="20"
                />
              </a>
              <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                  <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                  <i class="gg-menu-left"></i>
                </button>
              </div>
              <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
              </button>
            </div>
            <!-- End Logo Header -->
          </div>
          <!-- Navbar Header -->
          <nav
            class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom"
          >
            <div class="container-fluid">

              <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                <li class="nav-item topbar-icon dropdown hidden-caret">
                  <a
                    class="nav-link dropdown-toggle"
                    href="#"
                    id="notifDropdown"
                    role="button"
                    data-bs-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                  >
                     <img class="noti_icon" src="assets/img/notification.png" alt="notification" />
                    <span class="notification">4</span>
                  </a>
                  <ul
                    class="dropdown-menu notif-box animated fadeIn"
                    aria-labelledby="notifDropdown"
                  >
                    <li>
                      <div class="dropdown-title">
                        You have 4 new notification
                      </div>
                    </li>
                    <li>
                      <div class="notif-scroll scrollbar-outer">
                        <div class="notif-center">
						  <div class="notifi-area"> 
                          <a href="#">
                            <div style="background:#E87946" class="notif-icon">
                               <img width="30px" height="30px" src="assets/img/delivery.png" alt="delivery" />
                            </div>
                            <div class="notif-content">
                              <span class="block"> Received at Warehouse </span>
                              <span class="time">5 minutes ago</span>
                            </div>
                          </a>
						  <span class="notif-del">
						    <img src="assets/img/close.png" alt="close" />
						  </span>
                          </div>
						  <div class="notifi-area"> 
						  <a href="#">
                            <div style="background:#000" class="notif-icon">
                                 <img width="30px" height="30px" src="assets/img/shipped.png" alt="shipped" />
                            </div>
                            <div class="notif-content">
                              <span class="block">
                                In Transit to Jamaica
                              </span>
                              <span class="time">12 minutes ago</span>
                            </div>
                          </a>
						   <span class="notif-del">
						     <img src="assets/img/close.png" alt="close" />
						  </span>
						  </div>
						  <div class="notifi-area"> 
                          <a href="#">
                            <div style="background:#226424" class="notif-img">
                              <img  style="width: 30px !important; height: 30px !important"
                                src="assets/img/growth.png"
                                alt="growth"
                              />
                            </div>
                            <div class="notif-content">
                              <span class="block">
                                Undergoing Customs Clearance
                              </span>
                              <span class="time">12 minutes ago</span>
                            </div>
                          </a>
						    <span class="notif-del">
						     <img src="assets/img/close.png" alt="close" />
						   </span>
						   </div>
						   <div class="notifi-area"> 
                          <a href="#">
                            <div class="notif-icon notif-danger">
                               <img  style="width: 30px !important; height: 30px !important"
                                src="assets/img/delivery-man.png"
                                alt="delivery-man"
                              />
                            </div>
                            <div class="notif-content">
                              <span class="block"> Ready for Delivery Instructions</span>
                              <span class="time">17 minutes ago</span>
                            </div>
                          </a>
						    <span class="notif-del">
						     <img src="assets/img/close.png" alt="close" />
						   </span>
						   </div>
						  <div class="notifi-area"> 
							  <a href="#">
								<div class="notif-icon notif-danger">
									<img  style="width: 30px !important; height: 30px !important"
									src="assets/img/order-fulfillment.png"
									alt="order-fulfillment"
								  />
								</div>
								<div class="notif-content">
								  <span class="block"> Delivered </span>
								  <span class="time">17 minutes ago</span>
								</div>
							  </a>
							   <span class="notif-del">
								 <img src="assets/img/close.png" alt="close" />
							   </span>
						   </div>
                        </div>
                      </div>
                    </li>
                  </ul>
                </li>
                <li class="nav-item">
                      <span class="op-7">Welcome</span>
                      <span class="fw-bold"><?php echo user_account_information()['first_name']  ; ?></span> 
                </li>
              </ul>
            </div>
          </nav>
          <!-- End Navbar -->
        </div> 
		<!--Fetching data from a database --> 
        <div class="container">
        <div class="page-inner">
		<!-- account Setting start--> 
	     <div class="row justify-content-center">
		     <div class="col-md-11"> 
				 <div class="card Account-area">
						<div class="card-body">
							<ul class="nav nav-pills nav-secondary nav-pills-no-bd" id="pills-tab-without-border" role="tablist">
								<li class="nav-item">
									<a  class=" nav-link active pills-home-nobd" id="pills-home-tab-nobd" data-bs-toggle="pill" href="#pills-home-nobd" role="tab" aria-controls="pills-home-nobd" aria-selected="true"><img class="user-icon" src="assets/img/user.png" alt="User">Account Information 
									 <p class="supportText">Manage Your Profile </p>
									</a> 
									<div class="mobile_tab account_Tab_btn"> 
									    <img class="user-icon" src="assets/img/user.png" alt= "User">Account Information 
									    <p class="supportText">Manage Your Profile</p>
									     <img id="right-arrow" class="right-arrow" src="assets/img/right-arrow-angle.png" alt="User">
								    </div>
								</li>
								<li class="nav-item">
									<a class="nav-link" id="pills-contact-tab-nobd" data-bs-toggle="pill" href="#pills-contact-nobd" role="tab" aria-controls="pills-contact-nobd" aria-selected="false"><img class="user-icon" src="assets/img/padlock.png" alt="padlock"> 
									 Password 
									 <p class="supportText">Update Your Password</p>
									</a>
									 <div class="mobile_tab reset_Tab_btn">
									    <img class="user-icon" src="assets/img/padlock.png" alt="padlock"> 
									 Password 
									 <p class="supportText">Update Your Password</p>
									 <img id="right-arrow" class="right-arrow1" src="assets/img/right-arrow-angle.png" alt="User">
									 </div>
								</li>
							    <li class="nav-item">
									<a class="nav-link" id="pills-contact-tab-nobd" data-bs-toggle="pill" href="#pills-AuthorizedUsers-nobd" role="tab" aria-controls="pills-contact-nobd" aria-selected="false"><img class="user-icon" src="assets/img/key.png" alt="padlock"> 
									   Authorized Users 
							           <p class="supportText">Approved Persons to Collect Packages </p>
								    </a>
									<div class="mobile_tab AuthorizedUser_tab_btn">
									   <img class="user-icon" src="assets/img/key.png" alt="padlock"> 
									   Authorized Users 
									  <p class="supportText">Approved Persons to Collect Packages</p>
									  <img id="right-arrow" class="right-arrow2" src="assets/img/right-arrow-angle.png" alt="User">
									 </div>
								</li>
							    <li class="nav-item">
									<a class="nav-link" 
									   id="pills-contact-tab-nobd" 
									   data-bs-toggle="pill" 
									   href="#pills-MiamiAddress-nobd" 
									   role="tab" 
									   aria-controls="pills-contact-nobd" 
									   aria-selected="false">
									    <img class="user-icon" src="assets/img/location.png" alt="padlock"> 
									    Miami Address 
									    <p class="supportText">Your Personalized Miami Address</p>
									  </a>
									  <div class="mobile_tab MiamiAddress_tab_btn">
									    <img  class="user-icon" src="assets/img/location.png" alt="padlock"> 
									       Miami Address 
									       <p class="supportText">Your Personalized Miami Address</p>
									   	  <img id="right-arrow" class="right-arrow3" src="assets/img/right-arrow-angle.png" alt="User">
									  </div>
								</li>
							</ul>
							<div class="mt-2 mb-3 tab-content" id="pills-without-border-tabContent">
							<div class="tab-pane fade account_content" id="pills-home-nobd" role="tabpanel" aria-labelledby="pills-home-tab-nobd">
								     <!-- my account -->
										<form enctype="multipart/form-data"  id="account-setting" method="POST" action='../codes.php'>
										  <div class="card-header">
										  <div class="card-title"> 
										      <h1 class="acntSetHeading">Account Number: 
											   <span class="account_number"><?php echo strtoupper(user_account_information()['account_number'])  ;?></span></h1>
										  </div>
										  </div>
										  <div class="card-body">
										  <!-- Account settings start-->
											<div class="row justify-content-center">
											  <div class="col-md-4">
												<div class="form-group change-value">
								                <label for="Firstname">First Name <span class="mandatory_field">*</span></label>
												  <input required <?php echo isset($_REQUEST['no-update-basic-data'])? '':'disabled'; ?>  
												     name="first_name" value="<?php echo user_account_information()['first_name']  ;?>" 
												     type="text" class="form-control" id="Firstname"
												     />
												   <p style='margin-bottom: 0px;  margin-top: 5px; color: #bf1919; font-size: 16px; line-height: 17px;'> 
												       <?php 
													        if( isset($_SESSION['message-1']) ){ 
														        echo $_SESSION['message-1'];
														        unset($_SESSION['message-1']);
														    };
													 
													    ?>
												     
												   </p>
												</div>	
												<div class="form-group change-value">
												  <label for="LastName">Last Name<span class="mandatory_field">*</span></label>
												  <input  required
												    <?php echo isset($_REQUEST['no-update-basic-data'])? '':'disabled'; ?> 
												    value="<?php echo user_account_information()['last_name']  ; ?>"
												    name='last_name'
													type="text"
													class="form-control"
													id="LastName"
												  />
												    <p style='margin-bottom: 0px;  margin-top: 5px; color: #bf1919; font-size: 16px; line-height: 17px;'> 
												       <?php 
													        if( isset($_SESSION['message-2']) ){ 
														        echo $_SESSION['message-2'];
														        unset($_SESSION['message-2']);
														    };
													 
													    ?>
												     
												    </p>
												</div>
												 <div class="form-group change-value">
												  <label for="phone1">Phone<span class="mandatory_field">*</span></label>
												  <input  required
												    <?php echo isset($_REQUEST['no-update-basic-data'])? '':'disabled'; ?> 
													name="phone"  maxlength='12'   
												    value="<?php echo user_account_information()['phone_number']  ?? ''; ?>"
													type="tel"
													class="form-control txtPhoneNo"
													id="phone1" 
													placeholder="xxx-xxx-xxxx"
												  />
												     <p style='margin-bottom: 0px;  margin-top: 5px;color: #bf1919; font-size: 16px; line-height: 17px;'> 
												        <?php 
													        if( isset($_SESSION['message-3']) ){ 
														        echo $_SESSION['message-3'];
														        unset($_SESSION['message-3']);
														    };
													 
													     ?>
												     
												     </p>
												</div>
											  </div>
											  <div class="col-md-4 col-lg-4">
											   <div class="form-group change-value ">
												  <label for="Birthday">Date of Birth<span class="mandatory_field">*</span></label>
												  <input required  name='BDate'  <?php echo isset($_REQUEST['no-update-basic-data'])? '':'disabled'; ?> value="<?php echo user_account_information()['date_of_birth']  ?? ''; ?>"
													type="date"
													class="form-control"
													id="phone" />
													   <p style='margin-bottom: 0px;  margin-top: 5px;color: #bf1919; font-size: 16px; line-height: 17px;'> 
												        <?php 
													        if( isset($_SESSION['message-4']) ){ 
														        echo $_SESSION['message-4'];
														        unset($_SESSION['message-4']);
														    };
													 
													     ?>
														</p>
												  </div> 
												 <div class="form-group">
												  <label for="Email">Email Address</label>
												  <input  
												   <?php echo isset($_REQUEST['no-update-basic-data'])? '':'disabled'; ?> 
												   value="<?php echo user_account_information()['email_address']  ?? ''; ?>"  
												   type="email" class="form-control" id="Email"
												  />
												</div>
											  </div>  
											  <div class="col-md-4 col-lg-4">
											  <div class="form-group change-value ">
											  <label>Gender<span class="mandatory_field">*</span></label><br />
											  <div id="gender" class="d-flex ">
												<div class="form-check">
												  <input  required <?php echo isset($_REQUEST['no-update-basic-data'])? '':'disabled'; ?> name='Gender'  value="Male"
													class="form-check-input"
													type="radio"
													id="flexRadioDefault1"
													<?php echo (user_account_information()['gender'] ?? '') == 'Male' ? 'checked' : ''   ; ?>
												  />
												  <label
													class="form-check-label"
													for="flexRadioDefault1"
												  >
													Male
												  </label>
												</div>
												<div class="form-check">
												  <input  <?php echo isset($_REQUEST['no-update-basic-data'])? '':'disabled'; ?> value="female" name='Gender'
													class="form-check-input"
													type="radio"
													id="flexRadioDefault2"
													<?php echo (user_account_information()['gender'] ?? '') == 'female' ? 'checked' : ''   ; ?>
												  />
												  <label
													class="form-check-label"
													for="flexRadioDefault2"
												  >
													Female
												  </label>
												  </div> 
												</div>
												<p style='margin-bottom: 0px; margin-top: 5px; color: #bf1919; font-size: 16px;  line-height: 17px'> 
												  <?php 
													        if( isset($_SESSION['message-10']) ){ 
														        echo $_SESSION['message-10'];
														        unset($_SESSION['message-10']);
														    };
													 
												   ?>
														</p>
												</div>
												<div class="form-group change-value">
												  <label for="id">Copy of Photo Identification 
												  </label>
												  <br />
												  <input  
												    hidden  
													name='old_image'  
													value='<?php echo user_account_information()['file'] ?? ''; ?>'
													type="text"  
												  />
													
												  <input <?php echo (user_account_information()['file'] ?? '') == '' ? 'required':''; ?> 
												   name='file'  
												   <?php echo isset($_REQUEST['no-update-basic-data'])? '':'disabled'; ?>  
												   type="file" 
												   class="form-control-file w-100"  
												   id="id" 
												   style="color:<?php echo (user_account_information()['file'] ?? '') == "" ? 'black' : '#fff0'  ; ?>"
												  />
												   <br />
												   <p style='margin-bottom:0px' class="fileAllowed"><b>Allowed formats : </b>PDF, DOC, DOCX, JPEG or PNG (MAX. 10MB)</p>
												        <p style='margin-bottom: 0px; margin-top: 5px; color: #bf1919; font-size: 16px;  line-height: 17px;'> 
												         <?php 
													        if( isset($_SESSION['message-5']) ){ 
														        echo $_SESSION['message-5'];
														        unset($_SESSION['message-5']);
														    };
													 
													      ?>
													</p>
													<div style="margin-bottom: 10px; width: 250px; display: flex;  border: 1px solid #ddd;  padding: 9px;  border-radius: 6px;  color: #978484;  font-size: 14px;  position: relative;"> 
														  <?php 
															if( (user_account_information()['file'] ?? '') != '' ){  
													   ?> 
															<span style=" display: -webkit-box;  -webkit-line-clamp: 1;  -webkit-box-orient: vertical;  overflow: hidden;  width: 180px;">  
															
															  <?php echo user_account_information()['file'] ?? ''; ?> 
															  
															  </span>
															<a target="_blank" style="width: 18px; position: absolute;  right: 10px;  top: 11px; "
															 class="d-flex" 
															 href="../uploaded-file/<?php echo user_account_information()['file'] ?? ''; ?>">
															   <img 
																  width='18px;' 
																  src="assets/img/hide.png"  
																  alt="" 
																/>
															</a>
														<?php }else{ 
														  
														   echo "No file attached";
														
														 } ?>
													</div>
												</div> 
											  </div>
											 </div>
											 <!-- Account settings end-->
											 <!-- Delivery preference start -->
											<div class="row justify-content-center Delivery-Preference">
											 <div class="card-title"> 
										      <h2 class="acntSetHeading">
											   Delivery Preference
											 </h2>
										     </div>
											   <div class="col-md-4 ">	 	              
											    <div class="form-group">
												  <label for="AddressType">Address Type<!--<span class="mandatory_field">*</span>--></label>
												  <select  
												    <?php echo isset($_REQUEST['no-update-basic-data'])? '':'disabled'; ?> 
													 name='AddressType'  class="form-select AddressType" 
													 id="AddressType">
													  <option value="">Choose...</option>
													  <option  
													   <?php  
													      echo (user_account_information()['address_type'] ?? '') == 'Home' ? 'selected' : ''  ;  
														  
														?> value="Home"> 
													    Home 
														</option>
													  <option 
													   <?php  
													      echo (user_account_information()['address_type'] ?? '') == 'Office' ? 'selected' : ''  ;  
													    ?>
													    value="Office"> 
													      Office 
													  </option>
													  <option value="Other" 
													    <?php  
														
													      echo (user_account_information()['address_type'] ?? '') == 'Other' ? 'selected' : ''  ;  
														  
													    ?>
													     > 
													    Other 
													  </option>
												    </select>
													   <p style='margin-bottom: 0px; margin-top: 5px; color: #bf1919; font-size: 16px;  line-height: 17px'> 
												         <?php 
													        if( isset($_SESSION['message-6']) ){ 
														        echo $_SESSION['message-6'];
														        unset($_SESSION['message-6']);
														    };
													 
													      ?>
														</p>
												  </div> 
											  </div>
											   <div class="col-md-4">
											   <div class="form-group">
												  <label for="State">Parish<span class="mandatory_field">*</span></label>
												  <select   required readonly
												   name='Parish'
												   class="form-select" 
												   id="State">
													   <option  value="" >Choose...</option>
													   <option  
													    <?php 
													      echo (user_account_information()['parish'] ?? '') == 'Kingston' ? 'selected' : ''  ;  
													    ?>
													      value="Kingston" > 
														  Kingston
													  </option>
													  <option  
													    <?php 
													      echo (user_account_information()['parish'] ?? '') == 'St. Andrew' ? 'selected' : ''  ;  
													    ?>
													    value="St. Andrew">
														  St. Andrew 
													  </option>
													  <option  
													    <?php  
													      echo (user_account_information()['parish'] ?? '') == 'St. Catherine' ? 'selected' : ''  ;  
														?>
													   value="St. Catherine"> 
													    St. Catherine 
													  </option>
												   </select>
												</div>   
											    <div class="form-group">
												  <label for="RegionAddress">Region<span class="mandatory_field">*</span></label>
												  <select required readonly
													name="Region" class="form-select"  
													id="RegionAddress">
													<option value="">Choose...</option>
													<?php 
														$user_region = user_account_information()['region'] ?? '';
														echo '<option value="' . htmlspecialchars($user_region) . '" selected>' . 
															 htmlspecialchars($user_region) . '</option>';
													?>
                                                    </select>
													 <option class=""
													   <?php
														   echo  (user_account_information()['region'] ?? '') == 'Kingston' ? 'selected' : '' ;
														 ?>
													     value="Kingston"> 
														    Kingston 
														</option>  
													    <option class=""
                                                          <?php 
														    echo  (user_account_information()['region'] ?? '') == 'Half-Way Tree' ? 'selected' : '' ;
													        ?>													  
													      value="Half-Way Tree">Half-Way Tree 
														</option>
													    <option  class=""
                                                           <?php 
														    echo  (user_account_information()['region'] ?? '') == 'Constant Spring' ? 'selected' : '' ;
													       ?>													  
													      value="Constant Spring">Constant Spring 
														 </option>
													    <option   class=""
													       <?php 
														     echo  (user_account_information()['region'] ?? '') == 'Cross Roads' ? 'selected' : '' ;
													        ?>	
													       value="Cross Roads">Cross Roads
														  </option>
													   	  <option class=""
													         <?php 
														       echo  (user_account_information()['region'] ?? '') == 'Portmore' ? 'selected' : '' ;
													          ?>	
													          value="Portmore">Portmore 
															</option>
													        <option class=""
                                                             <?php 
														       echo  (user_account_information()['region'] ?? '') == 'Spanish Town' ? 'selected' : '' ;
													          ?>														  
													          value="Spanish Town">Spanish Town 
															</option>
													        <option class=""
													           <?php 
														        echo  (user_account_information()['region'] ?? '') == 'Old Harbour' ?   'selected' : '' ;
															    ?>
													             value="Old Harbour">Old Harbour 
															</option>
													       <option  class=""
													  	    <?php 
														      echo  (user_account_information()['region'] ?? '') == 'Bog Walk' ? 'selected' : '' ;
													         ?>

													         value="Bog Walk">Bog Walk 
															</option>
													        <option  class=""
													        <?php 
														      echo  (user_account_information()['region'] ?? '') == 'Linstead' ? 'selected' : '' ;
														      ?>
													          value="Linstead">Linstead 
															</option>
												  </select> 
														<p style='margin-bottom: 0px; margin-top: 5px; color: #bf1919; font-size: 16px;  line-height: 17px'> 
												         <?php 
													        if( isset($_SESSION['message-8']) ){ 
														        echo $_SESSION['message-8'];
														        unset($_SESSION['message-8']);
														    };
													 
													      ?>
														</p>
												  </div> 
											    </div>
											   <div class="col-md-4">
                                                 <div class="form-group change-value">
												  <label for="Firstname">Address line 1<span class="mandatory_field">*</span> </label>
												  <input required  <?php echo isset($_REQUEST['no-update-basic-data'])? '':'disabled'; ?>  name="AddressLine1" type="text" class="form-control" id="Firstname"
												  value='<?php echo user_account_information()['address_line1'] ?? ''; ?>'
												  />
												</div>								       <div class="form-group change-value">
												  <label for="Firstname">Address line 2 </label>
												  <input  <?php echo isset($_REQUEST['no-update-basic-data'])? '':'disabled'; ?> name="AddressLine2" type="text" class="form-control" id="Firstname"
												  value='<?php echo user_account_information()['address_line2'] ?? ''; ?>'
												  />
												</div> 
											   </div>  
											    <div class="text-center card-action d-flex justify-content-center accountUpdateBtn">
												    <input type="text" hidden name='user_basic_account_info_btn' /> 
													<?php 											  
														echo isset($_REQUEST['no-update-basic-data'])? '': 
														"<span  class='btn account_info_btn updatePreAltBtn'>Enable Edit</span>";  	
													?>							     
													 <button 
													 style="display:<?php echo isset($_REQUEST['no-update-basic-data'])? 'block': 'none' ?>" 
													 type="submit" id="myForm" 
													 class="btn account_info_update_btn updatePreAltBtn">
													  <img style='display:none' class='spinner'  width="20px" src="../assets/img/spinner.gif" alt="" />
													    Update 
												     </button>
												</div> 
											 </div>
											  <!-- Delivery preference end -->
										   </div>
										 </form>
								     </div>
							<div class="tab-pane fade pwd_reset_content" id="pills-contact-nobd" role="tabpanel" aria-labelledby="pills-contact-tab-nobd">
								   <form action="user-account.php" id='password-reset' method="GET">
										  <div class="card-header">
										   <div class="card-title"><!-- <h1 class="acntSetHeading">Account Setting</h1>--></div>
										  </div>
										  <div class="card-body">
										 <div class="row justify-content-center">
											 <div class="col-md-6 col-lg-4">
											    <div class="form-group pwd-show-hide Existing-Password">
												   	<div> 
														  <label for="password">Verify Existing Password</label> 
														  <input style="border: 1px solid red" disabled style='border:0px'
															type="password"
															class="form-control hide-show-pwd Existing-Pwd"
															placeholder="Enter Existing Password"
														  />
														  <img src="assets/img/hide.png" alt="hide" />
														  <input class='user_id' hidden type="text" value="<?php echo $user_id  ; ?>" /> 
												  </div>
												   <h6 style='font-family: avenir-light !important; color: red;  line-height: 16px;  font-size: 14px;  font-weight: 400;  margin: 0px;  margin-top: 10px;  border: 0px;'></h6>
												</div>
												 <div class="form-group pwd-show-hide New_Password">
												 <div> 
													  <label for="password">New password</label> 
													  <input disabled style='border:0px'
														type="password"
														class="form-control hide-show-pwd new_pwd"
														id="password"
														placeholder="New password"
														name="New-password"
													  />
													  <img src="assets/img/hide.png" alt="hide" />
												  </div>
												  <p style='color: red;  line-height: 16px;  font-size: 14px;  font-weight: 400;  margin: 0px;  margin-top: 10px;  border: 0px;'></p>
												</div>
												 <div class="form-group pwd-show-hide verifypwd_area">
													 <div> 
													  <label for="verifyPassword">Verify password</label>
													  <input disabled style='border:0px'
														type="password"
														class="form-control hide-show-pwd verifyPassword"
														id="verifyPassword"
														placeholder="Verify password"
														name="Verify-password"
													  />
													   <img src="assets/img/hide.png" alt="hide" />
													 </div>
												   <p style='color: red; line-height: 16px; font-size: 14px; font-weight: 400;  margin: 0px;  margin-top: 10px; border: 0px; '></p>
												</div>
												  <div class="card-action d-flex pwdUpdate">
												      <input  hidden type="text" name="pwd_update" />
													  <button class="btn pwd-enble-btn updatePreAltBtn">Enable Edit</button>
													   <button style="display:none" class="btn updatePreAltBtn pwd-update-btn">
													    <img style='display:none' class='spinner'  width="20px" src="../assets/img/spinner.gif" alt="" />
													     Update 
													   </button>
												 </div>
											  </div>
										  </div>
										</form>
								    </div>
								</div>
							 <div class="tab-pane fade pending_payment AuthorizedUser_content" id="pills-AuthorizedUsers-nobd" role="tabpanel" aria-labelledby="pills-profile-tab-nobd"> 
							   <form action="../codes.php" id="delivery-setting" action="GET">
									  <div class="card-body">
									   <div class="row">
										  <div class="col-md-6">
											<div class="form-group">
											  <label for="firstName">First Name</label>
											  <input disabled type="text" placeholder="<?php echo Authorized_User()['first_name']; ?>" class="form-control AuthorizedUser " id="firstName" name='first_name'
											  />
											</div>
										     <div class="form-group">
											  <label for="firstName">Last Name</label>
											  <input disabled type="text" placeholder="<?php echo Authorized_User()['last_name']; ?>" class="form-control AuthorizedUser" id="firstName" name='last_name'
											  />
											</div> 
										  </div>
										  <div class="col-md-6">
										   <div class="form-group">
											  <label for="firstName">Identification Type</label>
											  <input disabled type="text" placeholder="<?php echo Authorized_User()['IdType']; ?>" class="form-control AuthorizedUser" id="firstName" name='IdType'
											  />
											</div>
										     <div class="form-group">
											  <label for="firstName">ID Number</label>
											  <input disabled type="text" placeholder="<?php echo Authorized_User()['IdNumber']; ?>" class="form-control AuthorizedUser" id="firstName" name='IdNber'
											  />
											</div> 
										  </div>
										    <div class="card-action d-flex justify-content-center ">
											       <span class="btn AurizedUsr-enble-btn updatePreAltBtn"> 
												       Enable Edit 
												   </span>
												   <input type="text" hidden name='delivery-updatingBtn' />
												<button style="display:none" type="submit"  class="btn AurizedUsr-update-btn updatePreAltBtn">
												         <img style='display:none' class='spinner'  width="20px" src="../assets/img/spinner.gif" alt="" />
													     Update 
												</button>
											</div>
									  </div>
				                  </form>
                                 </div>
							 </div>
							 <div class="tab-pane fade pending_payment MiamiAddress_content" id="pills-MiamiAddress-nobd" role="tabpanel" aria-labelledby="pills-profile-tab-nobd"> 
                             
							 <div class="Miami_Address"> 
								     <h2 class="text-center" style="font-family: avenir-light !important;">Miami Address </h2>
									 <ul class="list-group">
									  <li class="justify-between list-group-item d-flex"> 
									     <div class='d-flex'> 
										       <div> 
											     Line 1: 
											   </div>
											    <div id="Line1textToCopy"> 
											     5401 NW 102ND AVE
											   </div>
										 </div>
										 <div onclick="Line1()" class='MiamiAddressTextCpy'> 
									         <i class="bi bi-copy"></i>
										 </div>
									  </li>
									  	<li class="justify-between list-group-item d-flex"> 
									     <div class='d-flex'> 
										       <div> 
											     Line 2: 
											   </div>
											    <div id="Line2textToCopy"> 
											     STE113 - <span title="Account Number"><?php echo strtoupper(user_account_information()['account_number']); ?> </span>
											   </div>
										 </div>
										 <div onclick="Line2()" class='MiamiAddressTextCpy'> 
									         <i class="bi bi-copy"></i>
										 </div>
									  </li>
									  <li class="justify-between list-group-item d-flex"> 
									     <div class='d-flex'> 
										       <div> 
											     City: 
											   </div>
											    <div id="citytextToCopy"> 
											     SUNRISE
											   </div>
										 </div>
										 <div onclick="city()" class='MiamiAddressTextCpy'> 
									         <i class="bi bi-copy"></i>
										 </div>
									  </li>
									  <li class="justify-between list-group-item d-flex"> 
									     <div class='d-flex'> 
										       <div> 
											     State: 
											   </div>
											    <div id="statetextToCopy"> 
											     Florida
											   </div>
										 </div>
										 <div onclick="state()" class='MiamiAddressTextCpy'> 
									         <i class="bi bi-copy"></i>
										 </div>
									      
									  </li>
									  	 <li class="justify-between list-group-item d-flex"> 
									     <div class='d-flex'> 
										       <div> 
											     Country: 
											   </div>
											    <div id="CountrytextToCopy"> 
											     United States
											   </div>
										 </div>
										 <div onclick="Country()" class='MiamiAddressTextCpy'> 
									         <i class="bi bi-copy"></i>
										 </div>
									  </li>
									  	<li class="justify-between list-group-item d-flex"> 
									     <div class='d-flex'> 
										       <div> 
											     Zip Code: 
											   </div>
											    <div id="ZipCodetextToCopy"> 
											     33351
											   </div>
										 </div>
										 <div onclick="ZipCode()" class='MiamiAddressTextCpy'> 
									         <i class="bi bi-copy"></i>
										 </div>
									  </li>
									</ul>
								   
								   </div>
							 </div>
							 
							 </div>
						  </div>
					</div>
			     </div>
		   </div>
		<!-- account Setting end--> 
		</div> 
		<script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/imgur.js"></script>
        <footer class="footer">
          <div>
            <p class="text-center">
			 <small>&copy; 2025 Pync Parcel Chateau Limited. All rights reserved.</small></p>
          </div>
        </footer>
      </div>
    </div> 
    <!--   boostrap   -->
    <script src="assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="assets/js/core/popper.min.js"></script>
    <script src="assets/js/core/bootstrap.min.js"></script>
	 <!-- alertify -->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/alertify.min.js" integrity="sha512-JnjG+Wt53GspUQXQhc+c4j8SBERsgJAoHeehagKHlxQN+MtCCmFDghX9/AcbkkNRZptyZU4zC8utK59M5L45Iw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- jQuery Scrollbar -->
    <script src="assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
    <!-- Kaiadmin JS -->
      <script src="assets/js/kaiadmin.min.js"></script> 
	   <!-- user account mobile tabs js -->
       <script src="assets/js/account-mobilet-tab.js"></script> 
	  <script>
        //=============password show and hide===================
	  
	    $('.pwd-show-hide:first-child img').click(function(){ 
		
		   if( $('.pwd-show-hide:first-child input').attr('type') == 'password'){ 
			  $('.pwd-show-hide:first-child input').attr('type', 'text');
		   }else{
			 $('.pwd-show-hide:first-child input').attr('type', 'password');
		   } 
		   
	    }); 
	    $('.pwd-show-hide:nth-child(2) img').click(function(){ 
		
		   if( $('.pwd-show-hide:nth-child(2) input').attr('type') == 'password'){ 
			  $('.pwd-show-hide:nth-child(2) input').attr('type', 'text');
		   }else{
			 $('.pwd-show-hide:nth-child(2) input').attr('type', 'password');
		   } 
		   
	    }); 
	   	$('.pwd-show-hide:nth-child(3) img').click(function(){ 
		
		   if( $('.pwd-show-hide:nth-child(3) input').attr('type') == 'password'){ 
			  $('.pwd-show-hide:nth-child(3) input').attr('type', 'text');
		   }else{
			 $('.pwd-show-hide:nth-child(3) input').attr('type', 'password');
		   } 
		   
	    }); 
	   
	    //=========html input number value and adding dash with number start=========
	   
	    document.getElementById('phone1').addEventListener('keypress', function(event) {
		
            if (!/[0-9]/.test(event.key)) {
                  event.preventDefault();
                  };
            });
			
           $('.txtPhoneNo').on('keydown', function(event) {
             if (event.which === 8 || event.keyCode === 8) {
               // Allow backspace
             } else {
               if ($(this).val().length == 3) {
                 $(this).val($(this).val() + "-");
               } else if ($(this).val().length == 7) {
                 $(this).val($(this).val() + "-");
               }
             }
           });
		
	   // Submission form will start after 1 second
	    $(document).ready(function() {  
		  $('#account-setting').on('submit', function(e) {
			 $('.spinner').css('display', 'inline');
			e.preventDefault(); // Stop form from submitting immediately
			let form = this; // Store reference to the form element

			setTimeout(function() {
			  form.submit(); // Native submit after delay
			}, 1000); // 5000ms = 5 seconds
		  });
		}); 
		
		// Password updating 
		    $new_pwd   =  $(".new_pwd").val();
		    $(".new_pwd").on('input',(function(){ 
			
			   $Verify_pwd   =  $("#verifyPassword").val();
			   $("#verifyPassword").css('border', '1px solid red');
			   $('.verifypwd_area p').text("");  
			
			   $EleNewPwd = $(this) ;
			   $new_pwd = $(this).val() ;
			   if( $new_pwd.length < 8 ){ 
			   
			         $('.New_Password p').css('color', 'red'); //checking password, if less than 8. adding red border or color.
			         $EleNewPwd.css('border', '1px solid red');
				     $('.New_Password p').text('Password must contain at least 8 characters with a capital letter ');
				
			   }; 
	             // //checking password, if more than 8 or equal or At least a capital letter. Password validated.
			if( $new_pwd.length >= 8  && /[A-Z]/.test( $new_pwd  ) )  {  
			
			        $(".new_pwd").css('border', '1px solid #205e22');
			        $('.New_Password p').css('color', '#205e22');
				    $('.New_Password p').text('Good Password!');  
					
					if( $new_pwd == $Verify_pwd ){ 
				  
				       $('.verifypwd_area p').text("Password matched!"); 
                       $('.verifypwd_area p').css('color', '#205e22');
                       $("#verifyPassword").css('border', '1px solid #205e22');					   
				  
				    }else{ 
					
					   $('.verifypwd_area p').css('color', 'red'); //checking password, if less than 8. adding red border or color.
			           $input.css('border', '1px solid red');
				       $('.verifypwd_area p').text("Password didn't match");  
					}
			};
			   
		    })); 
		     // Verify password validation checking or matching.
		    $("#verifyPassword").on('input',(function(){
				
			         $VerifyPwd = $(this).val();
			         $input = $(this);
				
			    if( $new_pwd.length >= 8  && /[A-Z]/.test( $new_pwd)  ){  
				
			         $('.verifypwd_area p').css('color', 'red'); //checking password, if less than 8. adding red border or color.
			         $input.css('border', '1px solid red');
				     $('.verifypwd_area p').text("Password didn't match");  
					 
					 
				  	if( $new_pwd == $VerifyPwd ){ 
				  
				       $('.verifypwd_area p').text("Password matched!"); 
                       $('.verifypwd_area p').css('color', '#205e22');
                       $input.css('border', '1px solid #205e22');					   
				  
				    }; 
					
			  }
	    })); 
         // form submission 
        $('#password-reset').submit(function(event) {
					event.preventDefault();
			    if( $new_pwd.length >= 8  && /[A-Z]/.test( $new_pwd) ){ 
			          
			    if( $new_pwd == $("#verifyPassword").val() ){ 
				    $('.pwd-update-btn .spinner').css('display', 'inline');
					let form = this;
					setTimeout(function() {
						
						$user_id =  $(".user_id").val();   
						$userInputCurrentPwd = $(".Existing-Pwd").val();  
						
							$.post("../user-area/reset-password.php",
							  {
								userInputCurrentPwd  : $userInputCurrentPwd,
								user_id              : $user_id
							  },
							  function(response){
								  
								 if( response == 1){ 
								     form.submit(); // Native submit after delay
								 } 
								 else if( response == 401) 
								 { 
								    $('.Existing-Password h6').text("Please enter Existing Password"); 
									$('.Existing-Pwd').css('border', '1px solid red');
								   
								 }else{ 
								      $('.Existing-Password h6').text("Existing Password incorrect");
									  $('.Existing-Pwd').css('border', '1px solid red');								  
								 }
								 
							  });
							  $('.pwd-update-btn .spinner').css('display', 'none');
					  
					}, 1000); // 5000ms = 5 seconds
				}else{ 
				
			          $("#verifyPassword").css('border', '1px solid red');
				} 
				
			 }else{ 
			        $(".new_pwd").css('border', '1px solid red');
			        $("#verifyPassword").css('border', '1px solid red');
			 
			 }
        });   
		
         // Delivery updating
	    $(document).ready(function() {  
		  $('#delivery-setting').on('submit', function(e) {
			 $('#delivery-setting .spinner').css('display', 'inline');
			e.preventDefault(); // Stop form from submitting immediately
			let form = this; // Store reference to the form element

			setTimeout(function() {
			  form.submit(); // Native submit after delay
			}, 1000); // 5000ms = 5 seconds
		  });
		}); 
		
	// Miami Address  copy
    function Line1() {
      // Get the text
      let text = document.getElementById("Line1textToCopy").innerText;

      // Copy to clipboard
      navigator.clipboard.writeText(text).then(() => {
        alert("Copied: " + text);
      }).catch(err => {
        console.error("Failed to copy: ", err);
      });
    };
	// Line 2
    function Line2() {
      // Get the text
      let text = document.getElementById("Line2textToCopy").innerText;

      // Copy to clipboard
      navigator.clipboard.writeText(text).then(() => {
        alert("Copied: " + text);
      }).catch(err => {
        console.error("Failed to copy: ", err);
      });
    };
	// city
	function city() {
      // Get the text
      let text = document.getElementById("citytextToCopy").innerText;

      // Copy to clipboard
      navigator.clipboard.writeText(text).then(() => {
        alert("Copied: " + text);
      }).catch(err => {
        console.error("Failed to copy: ", err);
      });
    };
	// state
	function state() {
      // Get the text
      let text = document.getElementById("statetextToCopy").innerText;

      // Copy to clipboard
      navigator.clipboard.writeText(text).then(() => {
        alert("Copied: " + text);
      }).catch(err => {
        console.error("Failed to copy: ", err);
      });
    };
	// Country
    function Country() {
      // Get the text
      let text = document.getElementById("CountrytextToCopy").innerText;

      // Copy to clipboard
      navigator.clipboard.writeText(text).then(() => {
        alert("Copied: " + text);
      }).catch(err => {
        console.error("Failed to copy: ", err);
      });
    };
	// Zip Code
	function ZipCode() {
      // Get the text
      let text = document.getElementById("ZipCodetextToCopy").innerText;
      // Copy to clipboard
      navigator.clipboard.writeText(text).then(() => {
        alert("Copied: " + text);
      }).catch(err => {
        console.error("Failed to copy: ", err);
      });
    };
 </script>
      
	  <?php
           if( isset($_SESSION['message']) ){  
	    ?>  
        <script>
            // ===== alertify======
            alertify.set('notifier','position', 'top-right');
		    alertify.success("<?php echo $_SESSION['message'] ; ?>");
		</script>  
		 <?php  
			unset($_SESSION['message']);
			};
		 ?> 
		 
	    <!-- custom js -->
        <script src="assets/js/custom.js"></script>
  </body>
</html>


