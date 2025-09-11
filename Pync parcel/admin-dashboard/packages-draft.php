<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Tracking - Pync Parcel Chateau</title>
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
    <div class="wrapper tacking">
      <!-- Sidebar -->
      <div class="sidebar">
        <div class="sidebar-logo">
          <!-- Logo Header -->
          <div class="logo-header">
            <a href="index.html" class="logo">
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
                <a href="index.html">
                   <img class="home-icon" src="assets/img/home.png" alt="home" />
                  <p>Dashboard</p> 
                </a>
              </li>
              <li class="nav-item">
                <a href="package.html">
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
                <a  href="#">
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
                      <span class="fw-bold">Hanif</span> 
                </li>
              </ul>
            </div>
          </nav>
          <!-- End Navbar -->
        </div>
        <div class="container">
        <div class="page-inner">
	    <section class="bsb-timeline-5 py-5 py-xl-8">
	   <div class="row justify-content-center">
	      <div class="Tracking-close">
		     <a href="package.html"><img src="assets/img/close.png" alt="close"></a>
		  </div>
	   <div class="col-md-5 Package-details"> 
		 <div class="box"><img src="assets/img/box.png" alt="box" /></div>
		  <div class="Package-info"> 
			<h2>Package Details</h2>
			<div class="Tracking-value"> 
				 <span class="heading"> Tracking Number</span>
				 <span class="value">76rt3276i45786324 </span>
			</div> 
			 <div class="Tracking-value"> 
				 <span class="heading"> Courier Company</span>
				 <span class="value"> Amazon</span>
			</div>

			<div class="Tracking-value"> 
				 <span class="heading">Value of Package</span>
				 <span class="value">$10.21</span>
			</div>
			<div class="Tracking-value"> 
				 <span class="heading"> Package Content</span>
				 <span class="value">shoes</span>
			</div>  
			 <div class="Tracking-value"> 
				 <span class="heading">Merchant</span>
				 <span class="value">Alibaba</span>
			</div>  
	  </div>
  </div>
  <div class="col-md-7 Tracking-area">
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
		<span style="opacity: 0.2;" class="timeline-icon">
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
		<span style="opacity: 0.2;" class="timeline-icon">
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
		<span style="opacity: 0.2;" class="timeline-icon">
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
		<span style="opacity: 0.2;" class="timeline-icon">
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
</div>
</section> 
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
	 <!-- custom JS -->
	 <script src="assets/js/custom.js" > </script> 
  </body>
</html>
</script>