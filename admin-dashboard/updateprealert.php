<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Update Pre-alert - Pync Parcel Chateau</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no"  name="viewport" />
	  <!-- CSS for Tracking icons -->
	 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
     <link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.4/tutorials/timelines/timeline-5/assets/css/timeline-5.css"> 
    <!-- CSS Files -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/kaiadmin.min.css" />
	<!-- custom css -->
    <link rel="stylesheet" href="assets/css/custom.css" />
  </head>
  <body>
    <div class="wrapper updateprealert">
      <!-- Sidebar -->
      <div class="sidebar">
        <div class="sidebar-logo">
          <!-- Logo Header -->
          <div class="logo-header">
            <a href="index.php" class="logo">
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
                  <p>Dashboard</p> 
                </a>
              </li>
              <li class="nav-item">
                <a href="package.php">
                  <img class="package-icon" src="assets/img/package.png" alt="package" />
                  <p>Packages</p>
                </a>
			  </li>
              <li class="nav-item">
                <a  href="createprealert.html">
                  <img class="ctePrealt-icon" src="assets/img/create-prealert.png" alt="Prealert" />
                  <p>Create Pre-alert</p>
                </a>
              </li>
			  <li class="nav-item">
                <a href="#">
                <img class="calculator-icon" src="assets/img/calculator.png" alt="Calculator" />
                  <p>Cost Calculator</p>
                </a>
              </li> 
              <li class="nav-item">
                <a href="makepayment.html">
                  <img class="payment-icon" src="assets/img/payment-protection.png" alt="payment" />
                  <p>Make Payment</p>
                </a>
              </li>
			  <li class="nav-item">
                <a  href="mymiamiaddress.html">
                <img class="user-icon" src="assets/img/location.png" alt="location" />
                  <p>My Miami Address</p>
                </a>
              </li>
              <li class="nav-item">
                <a  href="accountsetting.html">
                <img class="user-icon" src="assets/img/user.png" alt="User" />
                  <p>My account</p>
                </a>
              </li>
			   <li class="nav-item log-out">
                <a  href="#">
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
                      <span class="fw-bold">Hanif</span> 
                </li>
              </ul>
            </div>
          </nav>
          <!-- End Navbar -->
        </div>
        <div class="container">
          <div class="page-inner">
            <!--update Prealert  start--> 
			 <div class="row">
              <div class="col-md-12">
                <div class="card">
				<form action="#">
                  <div class="card-header">
                    <div class="card-title"><h1 class="UpdatePrealt">Update Pre-alert</h1></div>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                          <label for="TrackingNumber">Tracking Number</label>
                          <input value="76rt3276i45786324"
                            type="email"
                            class="form-control"
                            id="TrackingNumber"
                            placeholder="Enter Tracking Number"
                          />
                        </div>
						<div class="form-group">
                          <label for="value">Value of Package (USD)</label>
                          <input value="10.21"
                            type="number"
                            class="form-control"
                            id="value"
                            placeholder="Enter value"
                          />
                        </div>					
                      </div>
                      <div class="col-md-6 col-lg-4">
					   <div class="form-group">
                          <label for="exampleFormControlSelect1"
                            >Courier Company</label
                          >
                          <select
                            class="form-select"
                            id="exampleFormControlSelect1"
                          >
                            <option>Amazon</option>
                            <option>DHL</option>
                            <option>FedEx</option>
                            <option>UPS</option>
                            <option>USPS</option>
                            <option>Other</option>
                          </select>
                        </div>
						 <div class="form-group">
                          <label for="comment">Describe Package Content (eg. Sun-glasses)</label>
                          <textarea value="shoes" class="form-control" id="comment" rows="3">shoes
                          </textarea>
                        </div>
                      </div>
					   <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                          <label for="Store">merchant (source of purchase)</label>
                          <input value="Alibaba"
                            type="text"
                            class="form-control"
                            id="Store"
                            placeholder="Enter Store name"
                          />
                        </div>
                      </div>
					</div>
                  </div>
                  <div class="card-action d-flex">
                    <button class="btn updatePreAltBtn">Update</button>
                  </div>
				  </form>
                </div>
              </div>
            </div>
			<!--Update Prealert end-->
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
    <script src="assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="assets/js/core/popper.min.js"></script>
    <script src="assets/js/core/bootstrap.min.js"></script>

    <!-- jQuery Scrollbar -->
    <script src="assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
    <!-- Kaiadmin JS -->
      <script src="assets/js/kaiadmin.min.js"></script>
  </body>
</html>
