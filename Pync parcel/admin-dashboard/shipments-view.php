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
    <title>Shipments view - Pync Parcel Chateau</title>
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
				<div class=" col-md-12 Shipments_updating">
				    <div class="beckToCustomer d-flex justify-content-between"> 
				         <a href="shipments.php">
					     <i class="fa-solid fa-angle-left"></i>
						 </a>
						<div class="col-6 setting_icon_area"> 
					      <i data-bs-toggle="dropdown" aria-expanded="false" class="fa-solid fa-ellipsis"></i>
							<div class="dropdown">
							  <ul class="dropdown-menu">
								<li> 
								 <a data-toggle="modal" data-target="#edit-shipping" 
								 class="dropdown-item" href="#"> 
								    <i class="fa fa-edit"></i>
								    Update Shipment 
								   </a> 
								</li>
								<li> 
								 <a data-toggle="modal" data-target="#UpdatePackagesStatus" 
								 class="dropdown-item" href="#"> 
									<i class="fa-solid fa-box-open"></i>
								    Update packages status
								   </a> 
								</li>
								<li> 
								 <a data-toggle="modal" data-target="#SendEmail" 
								 class="dropdown-item" href="#"> 
									<i class="fa-solid fa-envelope"></i>
								    Send Email
								   </a> 
								</li>
								<li>
									<a class="dropdown-item delete_Package delete_shipment" href="#">
									 <i class="fa fa-trash"></i>
									  Delete shipment 
									</a> 
								</li>
								<!--
								<li>
									<a class="dropdown-item delete_Package" href="#">
									 <i class="fa fa-envelope" aria-hidden="true"></i>
									  Send email
									</a> 
								</li>--> 
							  </ul>
							</div>
					  </div>
				    </div>
				    <div class="Shipment_title_area"> 
					   <p class="title">Shipments</p>
					   <h2 class="Shipment_tracking">00VAK6I2113T9VW-2X7W <img src="assets/img/sea.png" alt="sea" /></h2>
						<span class="Shipment-status">Completed</span>
						<p class="created_date">Created on Jul 31, 2025, 7:28 PM</p>
						<p class="Shipment-type">Sea</p>
				    </div>
				    <div class="row Shipments_details" id="Customer_info"> 
						<div  class="col-md-3">
                            <div class="d-flex justify-content-between"> 
							    <p>Gross revenue</p>
								<img style="width: 43px;height: 41px;" src="assets/img/profit.png" alt="profit" />
							</div>						
							<h3>$260.00 JMD</h3>							
						</div>
						<div  class="col-md-3">
                            <div class="d-flex justify-content-between"> 
							    <p>Packages</p>
								<img style="width: 43px;height: 41px;" src="assets/img/shipment-package.png" alt="profit" />
							</div>						
							<h3>5</h3>							
						</div>
						<div  class="col-md-3">
                            <div class="d-flex justify-content-between"> 
							    <p>Weight</p>
								<img style="width: 43px;height: 41px;" src="assets/img/scale.png" alt="profit" />
							</div>						
							<h3>5 lb</h3>							
						</div>
						<div  class="col-md-3">
                            <div class="d-flex justify-content-between"> 
							    <p>Volume</p>
								<img style="width: 43px;height: 41px;" src="assets/img/box.png" alt="shipment package" />
							</div>						
							<h3>45896.00 ft3</h3>							
						</div> 
					</div>
					<div class="shipment_items"><!---->
					<div class="row"> 
					   <div class="search-form col-md-6"> 
						 <form action="#" class="input-group">
						     <input placeholder="Scan or add package...." type="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />   
							<button type="submit" class="manually-add-btn btn my-4 ">
								 Manually Add
							</button>
						</form>
						</div>						 
					   <div class="search-form col-md-6"> 
						 <form action="#" class="input-group">
							<input type="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
							<button type="submit" class="btn btn-outline-primary"   data-mdb-ripple-init> <img class="search-icon" src="assets/img/search.png" alt="" /></button>
						 </form>
					  </div>
					</div>
						   <div class="panel-body table-responsive shadow">
								<table class="table-area">
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
										<tr>
											<td>76rt3276i45786324</td>
											<td><img src="assets/img/fedex.png" alt="" /></td>
											<td>Laptop</td> 
											<td> <span class="customer_name"> Abdul </span> </td>
											<td>6 lbs</td>
											<td> <span class="item_value">$10.00</span></td>
											<td> 
											  <span style="display: block;   padding: 2px 10px;   border-radius: 7px;background:green; color:#90ee90">Delivered</span>  
											</td>
											<td> 
											    <span style="display: block; padding: 2px 10px; border-radius: 7px;background:#86efac; color:#55643d" class="Inv-status">PAID</span>
											 </td>
											<td> <span class="invoice">N/A</span></td>
											<td>$10</td>
											<td> Apr 29, 2025, 10:43 PM </td>
											<td>
												<ul class="action-list">
													<li> 
													  <a href="package-view.php"> 
														 <i class="fa-solid fa-eye"></i>
													  </a> 
													</li>
												</ul>
											</td>
										</tr> 
										<tr>
											<td>76rt3276i45786324</td>
											<td><img src="assets/img/amazon.png" alt="" /></td>
											<td>Laptop</td>
											<td> <span class="customer_name"> Abdul </span> </td>
											<td>6 lbs</td>
											<td> <span class="item_value">$10.00</span></td>
											<td>
											   <span style="display: block;   padding: 2px 10px;   border-radius: 7px;background:green; color:#90ee90">Delivered</span> 
											</td>
											<td> 
											  <span style="display: block;   padding: 2px 10px;   border-radius: 7px; background:#86efac; color:#55643d" class="Inv-status">PAID</span>
											</td>
											<td> <span class="invoice">N/A</span></td>
											<td>$10</td>
											<td> Apr 29, 2025, 10:43 PM </td>
											<td>
												<ul class="action-list">
													<li> 
													  <a href="package-view.php"> 
														 <i class="fa-solid fa-eye"></i>
													  </a> 
													</li>
												</ul>
											</td>
										</tr> 
										<tr>
											<td>76rt3276i45786324</td>
											<td><img src="assets/img/f.png" alt="" /></td>
											<td>Laptop</td>
											<td> <span class="customer_name"> Abdul </span> </td>
											<td>6 lbs</td>
											<td> <span class="item_value">$10.00</span></td>
											<td> 
											  <span style="display: block;   padding: 2px 10px;   border-radius: 7px;background:green; color:#90ee90">Delivered</span>   
											</td>
											<td><span style="display: block;   padding: 2px 10px;   border-radius: 7px;background:#86efac; color:#55643d" class="Inv-status">PAID</span></td>
											<td> <span class="invoice">N/A</span></td>
											<td>$10</td>
											<td> Apr 29, 2025, 10:43 PM </td>
											<td>
												<ul class="action-list">
													<li> 
													  <a href="package-view.php"> 
														 <i class="fa-solid fa-eye"></i>
													  </a> 
													</li>
												</ul>
											</td>
										</tr> 
									 </tbody>
								</table>
							</div>
					   </div>
				   </div>
			     </div>
	         </div>
          </div>
	     <!-- Modal for edit shipping -->
		<div class="modal fade" id="edit-shipping" tabindex="-1" aria-labelledby="edit-shipping" aria-hidden="true">
		  <div class="modal-dialog modal-lg">
			<div class="modal-content">
			  <div class="modal-header"> 
			   <div class="creatShiptitle"> 
					<h2>Update Shipment</h2>
				    <p>Modify shipment information</p>
			    </div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true"><i class="fa fa-close"></i></span>
				</button>
			  </div>
			  <div class="modal-body">
			    <form action="#">	
                        <div class="form-group">
						  <label for="Type">Type</label>
						  <select   class="form-select Type" id="Type">
							  <option value="0">Select a shipment type</option>
							  <option value="1">Air</option>
							  <option value="1">Air Express</option>
							  <option value="2">Sea</option>
							</select>
					    </div>
						<div class="form-group">
						  <label for="Type">Shipment status</label>
						   <select   class="form-select Type" id="Type">
							  <option value="0">Preparing</option>
							  <option value="1">Shipped</option>
							  <option value="1">Processing at Customs</option>
							  <option value="2">At Sorting Facility</option>
							  <option selected value="2">Completed</option>
							</select>
					   </div>
					   <div class="form-group change-value">
							  <label for="Description">Description (optional)</label>
							  <input placeholder="barrels, 40ft express container, FLIGHT 637"  type="text" class="form-control" id="Description"
							  />
						</div>
					    <div class="form-group">
						  <label for="Type">Origin</label>
						  <select   class="form-select Type" id="Type">
							  <option value="0">Choose...</option>
							  <option value="1">St. Elizabeth (STORE)</option>
							  <option value="1">Half Tree (Drop Off) (STORE)</option>
							  <option value="2">Portland (Knutsford) (STORE)</option>
							  <option value="2">May  Pen (Plaza) (STORE)</option>
							  <option value="2">Negril Store (STORE)</option>
							  <option value="2">Falmouth Store Main (STORE)</option>
							  <option value="2">Montego Bay Fairview Branch (STORE)</option>
							  <option value="2">Miami Warehouse (WAREHOUSE)</option>
							  <option value="2">Hagley Park (STORE)</option>
							</select>
					   </div>
					    <div class="form-group">
						  <label for="Type">Destination</label>
						  <select   class="form-select Type" id="Type">
							  <option value="0">Choose...</option>
							  <option value="1">St. Elizabeth (STORE)</option>
							  <option value="1">Half Tree (Drop Off) (STORE)</option>
							  <option value="2">Portland (Knutsford) (STORE)</option>
							  <option value="2">May  Pen (Plaza) (STORE)</option>
							  <option value="2">Negril Store (STORE)</option>
							  <option value="2">Falmouth Store Main (STORE)</option>
							  <option value="2">Montego Bay Fairview Branch (STORE)</option>
							  <option value="2">Miami Warehouse (WAREHOUSE)</option>
							  <option value="2">Hagley Park (STORE)</option>
							</select>
					   </div>
                     	<div class="card-action d-flex update_shipments">
							   <button type="submit" class="btn my-4 ">
								 Save 
							   </button>
						</div>					   
				</form>
			  </div>
			</div>
		  </div>
		</div> 
		<!-- Modal for Shipment updating -->
		<div class="modal fade" id="UpdatePackagesStatus" tabindex="-1" aria-labelledby="UpdatePackagesStatus" aria-hidden="true">
		  <div class="modal-dialog modal-lg">
			<div class="modal-content">
			  <div class="modal-header"> 
				 <div class="creatShiptitle"> 
					<h2>Update package status</h2>
				    <p>Bulk update package statuses</p>
			    </div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true"><i class="fa fa-close"></i></span>
				</button>
			  </div>
			  <div class="modal-body">
			    <form action="#">
                        <div class="form-group">
						  <label for="AddressType"> 
						    Update package status
						  </label>
						    <select   class="form-select AddressType" id="AddressType">
							  <option value="0">Choose...</option>
							  <option value="1">Received at Origin</option>
							  <option value="1">Preparing Shipment</option>
							  <option value="2">Shipped</option>
							  <option value="3">In Transit</option>
							  <option value="3">At Destination Port</option>
							  <option value="3">Processing at Customs</option>
							  <option value="3">Checking for Package</option>
							  <option value="3">At Sorting Facility</option>
							  <option value="3">Out for Delivery</option>
							  <option value="3">Ready for Pickup</option>
							  <option value="3">Scheduled for Delivery</option>
							  <option value="3">Delivered</option>
							</select>
					   </div>
					    <div class="form-group change-value d-flex">
						    <input style="transform: scale(1.4);margin-right: 10px;"  type="checkbox" id="Description"
							  />
							<label style="margin: 0px;" for="Description">Send notification email</label>
						</div>
                     	<div class="card-action d-flex ">
							   <button type="submit" class="btn my-4 updatePreAltBtn">
								 Apply 
							   </button>
						</div>					   
				</form>
			  </div>Send Email
			</div>
		  </div>
		</div>
	    <!-- Modal for Shipment updating -->
		<div class="modal fade" id="SendEmail" tabindex="-1" aria-labelledby="SendEmail" aria-hidden="true">
		  <div class="modal-dialog modal-lg">
			<div class="modal-content">
			  <div class="modal-header"> 
				 <div class="creatShiptitle"> 
					<h2>Send Email</h2>
				    <p>Send a broadcast email to customers in shipment</p>
			    </div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true"><i class="fa fa-close"></i></span>
				</button>
			  </div>
			  <div class="modal-body">
			    <form action="#">
					    <div class="form-group">
						  <label for="AddressType"> 
						    Subject
						  </label>
						  <input class="form-control" placeholder="<Subject> (Ex. Shipment Delay)" type="text" />
					    </div>
					    <div class="form-group">
						  <p style="margin: 0px;">Body</p>
						  <label for="AddressType"> 
						    Hi Jack
						  </label>
						   <textarea placeholder="Type your message here." class="form-control"  name="" id="" cols="30" rows="10">fdg</textarea>
					    </div>
                     	<div class="card-action d-flex ">
							   <button type="submit" class="btn my-4 updatePreAltBtn">
								 Apply 
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
	   //Swal.fire("SweetAlert2 is working!"); 
			$('.delete_shipment').click( function(){
				
			  Swal.fire({
				  title: "Are you sure?",
				  text: "You won't be able to revert this!",
				  icon: "warning",
				  showCancelButton: true,
				  confirmButtonColor: "#3085d6",
				  cancelButtonColor: "#d33",
				  confirmButtonText: "Yes, delete it!"
				}).then((result) => {
				  if (result.isConfirmed) {
					Swal.fire({
					  title: "Deleted!",
					  text: "The Shipment has been deleted.",
					  icon: "success"
					});
				  }
				}); 
			});  
      </script>  	 
  </body>
</html>






<!-- 
 	  <div class="col-md-6 Tracking-area">
			      <h1 class="trackingHeading">Tracking Information</h1>
				   <ul class="timeline">
				    <li class="timeline-item">
					  <span class="timeline-icon">
					     <i class="bi-check-lg text-primary"></i>
					  </span>
					 <div class="timeline-body">
					  <div class="timeline-content">
						<div class="card text-bg-primary">
						  <div class="card-header">10/7/2025</div>
						  <div class="card-body">
							<p>Received at Warehouse</p>
						  </div>
						</div>
					  </div>
					</div>
				  </li>
				   <li class="timeline-item">
					<span style="opacity: 0.5;" class="timeline-icon">
					  <i class="bi-check-lg text-primary"></i>
					</span>
					<div class="timeline-body">
					  <div class="timeline-content">
						<div class="card text-bg-primary">
						  <div class="card-header">20/07/205</div>
						  <div class="card-body">
							<p>In Transit to Jamaica</p>
						  </div>
						</div>
					  </div>
					</div>
				  </li> 
				  <li class="timeline-item">
					<span style="opacity: 0.5;" class="timeline-icon">
					  <i class="bi-check-lg text-primary"></i>
					</span>
					<div class="timeline-body">
					  <div class="timeline-content">
						<div class="card text-bg-primary">
						  <div class="card-header">25/07/205</div>
						  <div class="card-body">
							<p>Undergoing Customs Clearance</p>
						  </div>
						</div>
					  </div>
					</div>
				  </li> 
				  <li class="timeline-item">
					<span style="opacity: 0.5;" class="timeline-icon">
					  <i class="bi-check-lg text-primary"></i>
					</span>
					<div class="timeline-body">
					  <div class="timeline-content">
						<div class="card text-bg-primary">
						  <div class="card-header">30/07/205</div>
						  <div class="card-body">
							<p>Ready for Delivery Instructions</p>
						  </div>
						</div>
					  </div>
					</div>
				  </li>
				   <li class="timeline-item">
					<span style="opacity: 0.5;" class="timeline-icon">
					  <i class="bi-check-lg text-primary"></i>
					</span>
					<div class="timeline-body">
					  <div class="timeline-content">
						<div class="card text-bg-primary">
						  <div class="card-header">3/08/205</div>
						  <div class="card-body">
							<p>Delivered</p>
						  </div>
						</div>
					  </div>
					</div>
				  </li>
				</ul>
			  </div>
-->