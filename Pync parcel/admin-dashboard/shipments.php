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
    <title>Shipments | Pync Parcel Chateau</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no"  name="viewport" />
	  <!-- CSS for Tracking icons -->
	 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
     <link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.4/tutorials/timelines/timeline-5/assets/css/timeline-5.css"> 
    <!-- CSS Files -->
    <link rel="stylesheet" href="../user-dashboard/assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../user-dashboard/assets/css/kaiadmin.min.css" />
	<!-- font awesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<!-- custom css -->
    <link rel="stylesheet" href="../user-dashboard/assets/css/custom.css" />
    <link rel="stylesheet" href="assets/css/admin.css" />
  </head>
  <body>
    <div class="wrapper  admin">
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
              <li class="nav-item">
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
			  <li class="nav-item <?php echo  $current_file_name == 'shipments.php' ? 'active' : ''; ?>">
                <a  href="shipments.php">
                <img class="user-icon" src="assets/img/boxes.png" alt="User" />
                  <p style="<?php echo  $current_file_name == 'shipments.php' ? 'color: #E87946 !important' : ''; ?>">Shipments</p>
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
          <div class="page-inner">
			<!--Order history start-->
            <div class="row">
               <div class="col-md-offset-1 col-md-12">
                <div class="panel packages ">
                <div class="panel-heading">
                    <div class="row">
                        <div class="d-flex justify-content-between add_shipping">
                            <h4 class="title">Shipments</h4>
							 <span data-toggle="modal" data-target="#create_shipping"><i class="fa-solid fa-plus"></i> New</span>
                        </div>
                    </div>
                </div>
				<div class="search-form"> 
					 <form action="#" class="input-group">
						<input type="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
						<button type="submit" class="btn btn-outline-primary"   data-mdb-ripple-init> <img class="search-icon" src="assets/img/search.png" alt="" /></button>
					 </form>
				  </div>
                <div class="panel-body table-responsive ">
                    <table class="table-area shadow m-auto">
                        <thead>
                            <tr>
                                <th>Number</th>
                                <th>Type</th>
                                <th>Origin</th>
                                <th>Destination</th>
                                <th>Status</th>
                                <th>Description</th>
                                <th>Created at</th>
                                <th>View</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>038NA4KFTQPLOZN-HH96</td>
                                <td><img src="assets/img/air.png" alt="air" /></td>
                                <td>Half Tree (Drop Off)</td>
                                <td>Miami Warehouse</td>
                                <td><span style="background:#fde047;padding: 4px; border-radius:5px;color:#222;font-size: 11px;display:inline-block">PREPARING</span></td>
                                <td>N/A</td>
                                <td>Jul 25, 2025, 10:10 AM</td>
                                <td>
                                    <ul class="action-list">
                                        <li> 
										  <a href="shipments-view.php"> 
										     <i class="fa-solid fa-eye"></i>
										  </a> 
									    </li>
                                    </ul>
                                </td>
                            </tr> 
						    <tr>
                                <td>0H70-B6S23D0G132V06R</td>
                                <td><img src="assets/img/Air-Express.png" alt="air" /></td>
                                <td>May Pen (Plaza)</td>
                                <td>May Pen (Plaza)</td>
                                <td><span style="background:#93c5fd;padding: 4px; border-radius:5px;color:#222;font-size: 11px;display:inline-block">SHIPPED</span></td>
                                <td>Sesth MBJ</td>
                                <td>Apr 9, 2025, 2:25 AM</td>
                                <td>
                                    <ul class="action-list">
                                        <li> 
										  <a href="shipment-sview.php"> 
										     <i class="fa-solid fa-eye"></i>
										  </a> 
									    </li>
                                    </ul>
                                </td>
                            </tr> 
							<tr>
                                <td>WSUMBK0L05X0860-XE6R</td>
                                <td><img src="assets/img/sea.png" alt="air" /></td>
                                <td>Miami Warehouse</td>
                                <td>Montego Bay Fairview Branch</td>
                                <td><span style="background:#d8b4fe;padding: 4px; border-radius:5px;color:#222;font-size: 11px;display:inline-block">AT SORTING FACILITY</span></td>
                                <td>Free me</td>
                                <td>Jun 26, 2025, 9:59 PM</td>
                                <td>
                                    <ul class="action-list">
                                        <li> 
										  <a href="shipments-view.php"> 
										     <i class="fa-solid fa-eye"></i>
										  </a> 
									    </li>
                                    </ul>
                                </td>
                            </tr> 
						  </tbody>
                    </table>
                </div>
				<!--
                <div class="panel-footer">
                    <div class="row">
                        <div class="col col-sm-6 col-xs-6">showing <b>5</b> out of <b>25</b> entries</div>
                        <div class="col-sm-6 col-xs-6">
                            <ul class="pagination hidden-xs pull-right">
                                <li><a href="#"><</a></li>
                                <li class="active"><a href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li><a href="#">4</a></li>
                                <li><a href="#">5</a></li>
                                <li><a href="#">></a></li>
                            </ul>
                            <ul class="pagination visible-xs pull-right">
                                <li><a href="#"><</a></li>
                                <li><a href="#">></a></li>
                            </ul>
                        </div>
                    </div>
                </div>-->
            </div>
        </div>
    </div>
	     <!--Order history end--> 
 </div>
      <!-- Modal for creating shipping -->
		<div class="modal fade" id="create_shipping" tabindex="-1" aria-labelledby="create_shipping" aria-hidden="true">
		  <div class="modal-dialog modal-lg">
			<div class="modal-content">
			  <div class="modal-header"> 
			   <div class="creatShiptitle"> 
					<h2>New Shipment</h2>
				    <p>Crates a shipment for packages</p>
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
								 Create 
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
    <!--   boostrap   -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="assets/js/core/popper.min.js"></script>
    <script src="assets/js/core/bootstrap.min.js"></script>

    <!-- jQuery Scrollbar -->
    <script src="assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
    <!-- Kaiadmin JS -->
      <script src="assets/js/kaiadmin.min.js"></script>
	  <!-- custom js -->
      <script src="assets/js/custom.js"></script> 
  </body>
</html>