<?php 
    // initialize session
    session_start();  
	include('../config.php'); // database connection
   	include('../function.php'); // function comes from user dashboard
   	include('function.php'); // function comes from admin dashboard
    include('authorized-admin.php'); 
	$current_file_name =  basename($_SERVER['PHP_SELF']);  // getting current file name 
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Customer View - Pync Parcel Chateau</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no"  name="viewport" />
	 <!-- alertify css -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/css/alertify.min.css" integrity="sha512-IXuoq1aFd2wXs4NqGskwX2Vb+I8UJ+tGJEu/Dc0zwLNKeQ7CW3Sr6v0yU3z5OQWe3eScVIkER4J9L7byrgR/fA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<!-- CSS Files -->
    <link rel="stylesheet" href="../user-dashboard/assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../user-dashboard/assets/css/kaiadmin.min.css" />
	<!-- font awesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<!-- custom css -->
    <link rel="stylesheet" href="../user-dashboard/assets/css/custom.css" />
    <link rel="stylesheet" href="assets/css/admin.css" />
    <style type="text/css"> 
	  .alertify-notifier div{ 
      background: #226424 !important;
      color:#fff;
	}
   .my-4.submit {
	padding: 6px 13px;
	border-radius: 2px;
	font-size: 18px;
	color: #fff;
	font-weight: 900;
	background: #E87946;
	transition: 0.3s;
} 
.my-4.submit:hover {
	background: #E87946D9;
}
 .userProfileUpdate {
	padding: 6px 13px;
	border-radius: 2px;
	font-size: 18px;
	color: #fff;
	font-weight: 900;
	background: #E87946;
	transition: 0.3s;
} 
.userProfileUpdate:hover {
	background: #E87946D9;
}
	</style> 
  </head>
  <body>
    <div class="wrapper  admin trackingdetails">
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
                <a href="index.php">
                   <img class="home-icon" src="assets/img/home.png" alt="home" />
                  <p>Home</p> 
                </a>
              </li>
              <li class="nav-item">
                <a href="packages.php">
                  <img class="package-icon" src="assets/img/package.png" alt="package" />
                  <p>Packages</p>
                </a>
			  </li>
			   <li class="nav-item">
                <a href="customers.php">
                  <img class="user-icon" src="assets/img/user.png" alt="User" />
                  <p>Customers</p>
                </a>
              </li>
              <li class="nav-item">
                <a  href="prealerts.php">
                <img class="user-icon" src="assets/img/sidebar-notification.png" alt="User" />
                  <p>Pre-alert</p>
                </a>
              </li>
			  <li class="nav-item">
                <a  href="shipments.php">
                <img class="user-icon" src="assets/img/boxes.png" alt="User" />
                  <p>Shipments</p>
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
              <a href="index.html" class="logo">
                <img
                  src="assets/img/kaiadmin/logo_light.svg"
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
                      <span class="fw-bold"><?php echo user_account_information()['FName'] ; ?></span> 
                </li>
              </ul>
            </div>
          </nav>
          <!-- End Navbar -->
        </div>
      <div class="container">
          <div class="page-inner py-5">
			 <!--Tracking details end-->  
			  <div class="row">
				<div class=" col-md-12">
				   <div class="beckToCustomer"> 
				         <a href="customers.php">
					     <i class="fa-solid fa-angle-left"></i>
						 </a>
				   </div>
				    <div class="row" id="Customer_info"> 
					 
					   <?php 
					         
					     if( isset($_REQUEST['user_id']) && isset($_REQUEST['user_name']) && isset($_REQUEST['AccountNumber'])){ 
						 
					    ?>
						<div  class="col-md-3 col-lg-2">	
							<p>Customer info</p>
							<h3><?php echo $_REQUEST['user_name'] ; ?></h3>				
							<h4><?php echo $_REQUEST['AccountNumber'] ; ?></h4>	
                            <div class="text-center"><span>unverified</span></div>							
						</div> 
						<div  class="col-md-3  col-lg-2">
							<p class="d-flex justify-content-between"> <span>Credit Balance </span>
							  <span data-toggle="modal" data-target="#credit_Increase_area" 
								 class="plus-sign"> 
							      <i  class="fa-solid fa-plus"> </i> 
							  </span>   
						    </p>
							<h3> 
							   <?php 
							   
									$user_id =  $_REQUEST['user_id'] ; 
									$sql     = "SELECT* FROM users where id = $user_id "; 
									$result  =  mysqli_query($conn, $sql); 
									$rows    = mysqli_fetch_array($result); 
									
									echo "$" . $rows['Total_Balance'];
									
								?> 
							 </h3>				
                            <div class="text-center"> 
							  Amount on account owed to customer
							</div>
							
						</div>
						<div class="col-md-3 col-lg-2"> 
						
							<p>Outstanding Balance</p>
							<h3>$0.00</h3>				
                            <div class="text-center">
							  00 balance when credit applied
							</div>			
						</div> 
						<div class="col-md-3  col-lg-2 "> 	
						
						    <p>Packages Ready</p>
							<h3>0</h3>				
                            <div class="text-center"> 
							  Packages available
							</div>				
						</div> 
					    <div  class="col-md-3 col-lg-2"> 	
						
							<p>Store Location</p>
							<h3>Portland (Knutsford)</h3>									
						</div> 
					<div class="package-details customerview"> 
					   <div class="card">
						<div class="card-body">
							<ul class="nav nav-pills nav-secondary nav-pills-no-bd" id="pills-tab-without-border" role="tablist">
								<li class="nav-item submenu" role="presentation">
									<a class="nav-link active" id="pills-home-tab-nobd" data-bs-toggle="pill" href="#pills-home-nobd" role="tab" aria-controls="pills-home-nobd" aria-selected="true">Packages</a>
								</li>
								<li class="nav-item submenu" role="presentation">
									<a class="nav-link" id="pills-profile-tab-nobd" data-bs-toggle="pill" href="#pills-profile-nobd" role="tab" aria-controls="pills-profile-nobd" aria-selected="false" tabindex="-1">Credit History</a>
								</li>
								<li class="nav-item submenu" role="presentation">
									<a class="nav-link" id="pills-contact-tab-nobd" data-bs-toggle="pill" href="#pills-contact-nobd" role="tab" aria-controls="pills-contact-nobd" aria-selected="false" tabindex="-1">Account</a>
								</li>
							</ul>
						    <div class="tab-content mt-2 mb-3" id="pills-without-border-tabContent">
							  <div class="tab-pane fade active show" id="pills-home-nobd" role="tabpanel" aria-labelledby="pills-home-tab-nobd">
									<div class="panel packages ">
									<div class="panel-heading">
									 <p style="font-size: 30px;   font-weight: 900; font-weight: 700;color: #E87946;" class="title text-center">Packages</p>
									</div>   
											<?php 
											    $user_id =  $_REQUEST['user_id'] ; 
												$sql = "SELECT* FROM pre_alert where User_id = $user_id"; 
												if( mysqli_num_rows( mysqli_query($conn, $sql)) > 0  ){ 
												  
										 
											?> 
										<div class="loading" style="color:#E87946; text-align: center;   font-size: 20px;   margin-bottom: 10px;"> 
											<span style="background: #E87946;  margin-right: 10px;"  
											class="spinner-grow spinner-grow-sm"  
											role="status" aria-hidden="true"> </span>Loading...
										</div>
									  <div class="panel-body table-responsive">
										<table class="table-area ">
											<thead>
												<tr>
													<th>Tracking</th>
													<th>Courier</th>
													<th>Description</th>
													<th>Customer</th>
													<th>Weight</th>
													<th>Item Value</th>
													<th>Status</th>
													<th>Inv Status</th>
													<th>Invoice</th>
													<th>Inv Total</th>
													<th>Created at</th>
													<th>View</th>
												</tr>
											</thead>
											<tbody> 
										   <?php 
											 
												  $result = mysqli_query($conn, $sql) ;
												  while( $rows = mysqli_fetch_array($result) ){  
											?>
											
												<tr>
													<td><?php echo $rows['Tracking_Number']; ?></td>
													<td><?php echo $rows['Courier_Company']; ?></td>
													<td><?php echo $rows['Describe_Package']; ?></td>
													<td> <span class="customer_name"><?php echo $_REQUEST['user_name']; ?></span> </td>
													<td>6 lbs</td>
													<td> <span class="item_value"><?php echo $rows['Value_of_Package']; ?></span></td>
													<td> <span class="status">Undergoing Customs Clearance</span> </td>
													<td><span class="Inv-status">Open</span></td>
													<td> <span class="invoice"> 
													    <?php 
													    
														   if( ! ltrim($rows['invoice']) == ''){  
														 
														 ?>

														<a
														 style=" 
														    width: 50px;
														    display: -webkit-box !important;  -webkit-line-clamp: 1;  -webkit-box-orient: vertical;overflow: hidden;padding: 0px 4px;  margin: 0px;  border: 1px solid #e3e3e34f;  color: #514f4f;  border-radius: 3px;  font-size: 12px; 
														   "
														 class="d-flex" 
														 href="../uploaded-file/<?php echo $rows['invoice'] ; ?>">
														 <?php echo $rows['invoice'] ; ?>
														</a> 
														<?php
															 }else{ 
															 echo "N/A";
															 
															 }
													    ?>			  
													</span></td>
													<td>$10</td>
													<td><?php echo timeAgo($rows['Create_at']); ?></td>
													<td>
														<ul class="action-list">
															<li> 
															  <a href="packages.php"> 
																 <i class="fa-solid fa-eye"></i>
															  </a> 
															</li>
														</ul>
													</td>
												</tr> 
												<?php }; ?>
											</tbody>
										</table>
									</div> 
										<?php  
										  }else{ 
										   
												echo "<p class='text-center' style='font-size: 25px'>No Package available.</p>";
										  }				  
										?> 
								</div>
					    </div>
						 <div class="tab-pane fade pending_payment" id="pills-profile-nobd" role="tabpanel" aria-labelledby="pills-profile-tab-nobd">
							<div class="row justify-content-center Credit-History"> 
							    <div class="col-md-6"> 
								   <p style="font-size:30px; font-weight: 900; color: #E87946; font-weight: 700;" class="title text-center">Credit History</p> 
								   <?php 
										$user_id =  $_REQUEST['user_id'] ; 
										$sql = "SELECT* FROM balance where user_id = $user_id ORDER BY Create_at DESC "; 
										 $result = mysqli_query($conn, $sql) ; 
										if(  mysqli_num_rows( $result) > 0  ) 
										{ 
										  
									        while( $rows = mysqli_fetch_array($result)  ){ 
											
											        $Add_New_Credit = $rows['Add_New_Credit'] ;
													$timestamp = $rows['Create_at'] ;
													$date = new DateTime($timestamp);
													$Create_at =  $date->format("M j, Y, g:i A"); 
													
												    echo " 
															<div class='d-flex justify-content-between'> 
																<span style='color:#696c71;font-size: 20px;  margin-bottom: 5px;  display: block;  font-weight: 700;'><b> $$Add_New_Credit </b></span>
																<span style='color:#696c71'>$Create_at</span>
															</div> 
														";
									          } 
										}else{ 
												 echo "<p class='text-center'>No History</p>";
									    };
								    ?>
								</div>
							</div>
						 </div>
						  <div class="tab-pane fade" id="pills-contact-nobd" role="tabpanel" aria-labelledby="pills-contact-tab-nobd">
						        <?php 
							   
									$user_id =  $_REQUEST['user_id'] ; 
									$sql     = "SELECT* FROM users where id = $user_id "; 
									$result  =  mysqli_query($conn, $sql); 
									$rows    = mysqli_fetch_array($result); 
             
									
								?> 
							<div class="row">
								 <div class="col-md-6">
								  <p class="title" style="font-size: 30px; font-weight: 900; color: #E87946; font-weight: 700;text-align:center">Basic Information</p>
									<div class="Tracking-value"> 
										 <span class="heading">First Name</span>
										 <span class="value"><?php echo $rows['FName'] ; ?></span>
									</div> 
									 <div class="Tracking-value"> 
										 <span class="heading">Last Name</span>
										 <span class="value"><?php echo $rows['LName'] ; ?></span>
									</div>

									<div class="Tracking-value"> 
										 <span class="heading">Phone</span>
										 <span class="value"><?php echo $rows['PhoneNumber'] ; ?></span>
									</div>
									<div class="Tracking-value"> 
										 <span class="heading">Email Address</span>
										 <span class="value"><?php echo $rows['EmailAddress'] ; ?></span>
									</div> 
									<div class="Tracking-value"> 
										 <span class="heading">Date of Birth</span>
										 <span class="value"> 
										      <?php echo ltrim($rows['DateOfBirth']) == '' ? 'N/A' : ltrim($rows['DateOfBirth']) ; ?> 
										 </span>
									</div>  
									<div class="Tracking-value"> 
										 <span class="heading"> Gender</span>
										 <span class="value"> 
										    <?php echo ltrim($rows['Gender']) == '' ? 'N/A' : ltrim($rows['Gender']) ;?> 
										 </span>
									</div> 
									<div class="Tracking-value"> 
										 <span class="heading">Copy of Photo Identification</span>
										 <span class="value">
										   <?php   
										   
										   
										    if( ltrim($rows['file']) != '' ){ 
											
											  $file = $rows['file'] ;
											  echo " 
											  <a href='../uploaded-file/$file'> 
											      <img width='40px' height='40px' src='../uploaded-file/$file' alt='' /> 
											   </a>
											";
											
											}else{ 
											  echo "N/A";
											}; 
										   
										   
										   ?> 
										  </span>
									</div> 
									<!--
									 <div class="Tracking-value"> 
										 <span class="heading"> Other File </span>
										 <span class="value">No set</span>
									</div> 	-->
									</div>
								    <div class="col-md-6"> 
									  <p class="title" style="font-size: 30px;font-weight: 900;color: #E87946; font-weight: 700; text-align:center">Delivery Preference</p>
										<div class="Tracking-value"> 
											 <span class="heading">Address Type</span>
											 <span class="value"> 
											 <?php echo ltrim($rows['AddressType']) == '' ? 'N/A' : ltrim($rows['AddressType']) ;  ?></span>
										</div> 
										 <div class="Tracking-value"> 
											 <span class="heading">Parish</span>
											 <span class="value"> 
											  <?php echo ltrim($rows['Parish']) == '' ? 'N/A' : ltrim($rows['Parish']) ; ?></span>
										</div>
										<div class="Tracking-value"> 
											 <span class="heading">Region</span>
											 <span class="value">
											  <?php echo ltrim($rows['Region']) == '' ? 'N/A' : ltrim($rows['Region']) ; ?></span>
										</div>
							        </div>
									<div class="col-md-6">
									  <p class="title" style="font-size: 30px;font-weight: 900;font-weight: 700; text-align:center; color: #E87946;">Authorized Users</p>
										<div class="Tracking-value">  
											 <?php 
										   
												$user_id =  $_REQUEST['user_id'] ; 
												$sql     = "SELECT* FROM authorized_users where Id = $user_id "; 
												$result  =  mysqli_query($conn, $sql); 
												$rows    = mysqli_fetch_array($result); 
						 
											?> 
											 <span class="heading">First Name</span>
											 <span class="value"><?php echo ltrim($rows['FName']) == '' ? 'N/A' : ltrim($rows['FName']) ; ?></span>
										</div> 
										 <div class="Tracking-value"> 
											 <span class="heading">Last</span>
											 <span class="value"><?php echo ltrim($rows['LName']) == '' ? 'N/A' : ltrim($rows['LName']) ; ?></span>
										</div>
										<div class="Tracking-value"> 
											 <span class="heading">Identification Type</span>
											 <span class="value"><?php echo ltrim($rows['IdType']) == '' ? 'N/A' : ltrim($rows['IdType']) ; ?></span>
										</div>
										 <div class="Tracking-value"> 
											 <span class="heading">ID Number</span>
											 <span class="value"><?php echo ltrim($rows['IdNumber']) == '' ? 'N/A' : ltrim($rows['IdNumber']) ; ?></span>
										</div>	
							       </div>
								   	<div class="col-md-6">
									 <p class="title" style="font-size: 30px;   font-weight: 900;color: #E87946; font-weight: 700; text-align:center">Miami Address</p>
									<div class="Tracking-value"> 
									     <span     class="heading">Line 1 : </span>
									     <span   class="value">5401 NW 102ND AVE</span>
									</div>
                                    <div class="Tracking-value"> 
									     <span    class="heading">Line 2 : </span>
									     <span  class="value">STE113 - <span title='Account Number'><?php echo $_REQUEST['AccountNumber'] ; ?></span></span>
									</div>
                                     <div class="Tracking-value"> 
									     <span    class="heading">City : </span>
									     <span class="value">SUNRISE</span>
									</div>
                                    <div class="Tracking-value"> 
									     <span   class="heading">State : </span>
									     <span class="value">Florida</span>
									</div> 
                                    <div class="Tracking-value"> 
									     <span  class="heading">Country : </span>
									     <span class="value">United States</span>
									</div> 
                                    <div class="Tracking-value"> 
									     <span class="heading">Zip Code : </span>
									     <span class="value">33351</span>
									</div> 									
							       </div>
							   </div>
						     </div>
							</div>
						</div>
					</div>
				    </div>
						 <?php 
						  
							   }  
							   else{ 
								   
									echo "<p class='text-center' style='font-size: 25px'> Something went wrong</p>";
								 } 
						 ?>
				    </div>
				   </div>
			     </div>
	         </div>
          </div>
        <!-- Modal for Shipment updating -->
		<div class="modal fade" id="credit_Increase_area" tabindex="-1" aria-labelledby="credit_Increase_area" aria-hidden="true">
		  <div class="modal-dialog modal-lg">
			<div class="modal-content">
			  <div class="modal-header justify-content-end">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true"><i class="fa fa-close"></i></span>
				</button>
			  </div>
			  <div class="modal-body">
			    <form action="codes.php"  method="GET" class="Add_credit" >
					    <div class="form-group change-value">
						    <div class="credit_titile"> 
							    <h2>Credit</h2>
                                <p>Add credit to customer account</p>
                             							<div class="row"> 
							   <div class="col-6"> 
							      <h5>Current Credit Balance</5> 
								  <h3 id="Current_Credit">7.00</h3>
							   </div>
							    <div class="col-6"> 
							         <h5>New Balance</h5> 
								     <h3 class="New_credit">$0.00</h3>
							    </div>
							</div>	
                              <p style="margin: 0px;color: #222;font-weight: 700;">Account</p>					
							  <input name="New_credit" id="credit_adding" placeholder="0" value="0"  type="number" class="form-control"
							  />
							</div>
						</div>	
                     	<div class="card-action d-flex justify-content-center">
						      <input hidden type="text" name="user_id" value="<?php echo $_REQUEST['user_id']; ?>" />
						      <input hidden type="text" name="user_name" value="<?php echo $_REQUEST['user_name']; ?>" />
						      <input hidden type="text" name="AccountNumber" value="<?php echo $_REQUEST['AccountNumber']; ?>" />
						      <input hidden type="text" name="new_Credit_btn" />
							  <button name="new_Credit_btn" type="submit" class=" my-4 submit">
							    <img class="spinner" style="display:none;" width="20px" src="assets/img/spinner.gif" alt="" />
								 Submit 
							   </button>
						</div>					   
				</form>
			  </div>
			</div>
		  </div>
		</div>
        <!-- Modal for user profile updating -->
		<div class="modal fade" id="userProfileUpdating" tabindex="-1" aria-labelledby="userProfileUpdating" aria-hidden="true">
		  <div class="modal-dialog modal-lg user_profile_edit_modal">
			<div class="modal-content">
			  <div class="modal-header justify-content-end">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true"><i class="fa fa-close"></i></span>
				</button>
			  </div>
			  <div class="modal-body"> 
			    <form action="#"  >
					    <div class="form-group change-value row">
						    <div class="col-md-6 userProfileData">
							   <p style="color: #E87946;">Basic Information</p>
								<div class=""> 
								   <label for="First-name">First name</label>
								   <input 
								     name="FName"
								     value="Abdul"
									 id="First-name" 
									 placeholder="Abdul"
									 type="text" class="form-control"/>
					 
								</div>
                                <div> 
								   <label for="last-name">Last name</label>
								   <input  
								     name="LName"
								     value="quadri" 
									 id="last-name" 
									 placeholder="quadri"
									 type="text" class="form-control"/>
					 
								</div>
                                <div> 
								   <label for="PhoneNumber">Phone</label>
								   <input 
								     name="phone"
								     value="183-475-4758" 
									 id="PhoneNumber" maxlength='12'
									 placeholder="xxx-xxx-xxxx"
									 type="tel" class="form-control"/>
					 
								</div>
                                <div> 
								   <label for="Email-Address">Email Address</label>
								   <input value="Last name" 
									 id="Email-Address" 
									 placeholder="example@gmail.com"
									 type="email" class="form-control"/>
					 
								</div>
                                <div> 
								   <label for="Date">Date of Birth</label>
								   <input 
								     name="BDate"
								     value="Last name" 
									 id="Date" 
									 type="date" class="form-control"/>
					 
								</div>
                                 <div> Parish,AddressLine1,AddressLine2, old_image
								  <label>Gender<span class="mandatory_field">*</span></label><br />
								  <div id="gender" class="d-flex form-control">
									<div>
									  <input 
										class="form-check-input"
										type="radio"
										name="Gender"
										id="flexRadioDefault1"
									  />
									  <label
										class="form-check-label"
										for="flexRadioDefault1"
									  >
										Male
									  </label>
									</div>
									<div>
									  <input 
										class="form-check-input"
										type="radio"
										name="Gender"
										id="flexRadioDefault2"
										checked
									  />
									  <label
										class="form-check-label"
										for="flexRadioDefault2"
									  >
										Female
									  </label>
									  </div> 
									</div>
								 </div> AddressType
                                <div> 
								   <label for="Photo">
								    Copy of Photo Identification 
								   </label>
								   <input
									 id="Photo" 
									 type="file" class="form-control"/>
									 <img style="margin-top:5px;" width="70px" src="https://dmv.nebraska.gov/sites/default/files/img/NE%20D100%20PR_ADULT_ID_300dpi.jpg" alt="" />
					 
								</div>
                                <div>
								  <p style="color: #E87946;">Miami Address</p>
								   <input value="N/A"
									 id="Miami-Address" 
									 placeholder="Enter Miami Address"
									 type="text" class="form-control"/>
					 
								</div>								
							</div>
							<div class="col-md-6 userProfileData"> 
							       <p style="color: #E87946;">Authorized Users</p>
								<div> 
								   <label for="FirstName">First Name</label>
								   <input value="Abdul"
									 id="FirstName" 
									 placeholder="First Name"
									 type="text" class="form-control"/>
					 
								</div>
							    <div> 
								   <label for="FirstName">Last name</label>
								   <input value="quadri"
									 id="FirstName" 
									 placeholder="Z"
									 type="text" class="form-control"/>
					 
								</div>
							    <div> 
								   <label for="Passport">Identification Type</label>
								   <input value="Passport"
									 id="Passport" 
									 placeholder="Passport"
									 type="text" class="form-control"/>
					 
								</div>
							    <div> 
								   <label for="ID-Number">ID Number</label>
								   <input value="E12345678"
									 id="ID-Number" 
									 placeholder="ID Number"
									 type="text" class="form-control"/>
					 
								</div>
							</div>
						</div>	
                     	<div class="card-action d-flex justify-content-center">
							   <button type="submit" class=" my-4 userProfileUpdate">
							    <img class="spinner" style="display:none;" width="20px" src="assets/img/spinner.gif" alt="" />
								 Update 
							   </button>
						</div>					   
				</form>
			  </div>
			</div>
		  </div>
		</div>
	   <footer class="footer">
          <div>
            <p class="text-center">
			 <small>&copy; 2025 Pync Parcel Chateau Limited. All rights reserved.</small></p>
          </div>
        </footer>
      </div>
    </div> 
	  <!-- alertify -->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/alertify.min.js" integrity="sha512-JnjG+Wt53GspUQXQhc+c4j8SBERsgJAoHeehagKHlxQN+MtCCmFDghX9/AcbkkNRZptyZU4zC8utK59M5L45Iw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!--   boostrap   -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="assets/js/core/popper.min.js"></script>
    <script src="assets/js/core/bootstrap.min.js"></script>

    <!-- jQuery Scrollbar -->
    <script src="assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
    <!-- Kaiadmin JS -->
      <script src="assets/js/kaiadmin.min.js"></script>
	      <!-- sweetalert JS -->
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.22.2/dist/sweetalert2.all.min.js"> 
	</script>
     <!-- custom js -->
      <script src="assets/js/custom.js"></script> 
	  <script type="text/javascript"> 
		   $(window).on('load', function() {
			// Page is fully loaded 
			  $('.table-responsive').show('slow');
			  $('.loading').hide();
			});
	  </script>
	  <script type="text/javascript">
	    // alertify
	    alertify.set('notifier','position', 'top-right');
	    //=========html input number value and adding dash with number start=========
	    document.getElementById('PhoneNumber').addEventListener('keypress', function(event) {
		
            if (!/[0-9]/.test(event.key)) {
                  event.preventDefault();
                  };
            });
			
           $('#PhoneNumber').on('keydown', function(event) {
			
           if (event.which === 8 || event.keyCode === 8) { 
		
	        }else{ 
		
	        if ($(this).val().length == 3) {
					
                    $(this).val($(this).val() + "-");
                    }
                    else if ($(this).val().length == 7) {
                        $(this).val($(this).val() + "-");
                    } 
	        } 
		});
		
	      // Credit adding to customer account
		  $('#credit_adding').on('change', function(){ 
		  
		         const newCredit = parseFloat($(this).val());
			     if( newCredit < 0 ){ 
				    
				   var negativeValues = '-$' + Math.abs(newCredit).toFixed(2);
				   $('.New_credit').text(negativeValues);
				   
				 }else{ 
				 
				    const positiveValues = "$"+newCredit;
					$('.New_credit').text(positiveValues);
				 };
		}); 
		
		// Credit submission
        $('.Add_credit').on('submit', function(e){
		     $('.spinner').show();
			 e.preventDefault();
			 let form = this;
		     setTimeout(balance, 1000);
			 
			function balance(){ 
			 
		     var New_credit = parseFloat($('#credit_adding').val()) ;
		    if( New_credit > 0 ){
				
				form.submit();
			 
            }else{ 
			    alertify.success("<span style='color:red; display:block'>Error</span> Credit amount cannot be less than or equal to 0");
				$('.spinner').hide();
			 }
		  }			
	   });
	   
      </script> 
	  </script>
		<?php
		   if( isset($_SESSION['message']) ){  
		?>  
		<script>
			// ===== alertify======
			alertify.success("<span style='color:yellow; display:block'> Success</span> <?php echo  $_SESSION['message']; ?>");
		</script>  
		 <?php  
			unset($_SESSION['message']);
			};
		 ?> 		 
  </body>
</html>
