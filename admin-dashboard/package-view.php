<?php
    // initialize session
    session_start();
	include('../config.php'); // database connection
   	include('../function.php'); // function comes from user dashboard
   	include('function.php'); // function comes from admin dashboard
    include('authorized-admin.php');
	$current_file_name =  basename($_SERVER['PHP_SELF']);  // getting current file name

    // Get tracking number from URL
    $tracking_number = isset($_GET['tracking']) ? mysqli_real_escape_string($conn, $_GET['tracking']) : '';

    // Initialize variables
    $package = null;
    $customer_name = 'Unknown';
    $shipment_number = 'N/A';
    $total_packages = 0;
    $active_packages = 0;

    if (!empty($tracking_number)) {
        // Query package details
        $sql = "SELECT p.*, u.first_name, u.last_name, s.shipment_number
                FROM packages p
                LEFT JOIN users u ON p.user_id = u.id
                LEFT JOIN shipments s ON p.shipment_id = s.id
                WHERE p.tracking_number = '$tracking_number'";
        $result = mysqli_query($conn, $sql);
        if ($result && mysqli_num_rows($result) > 0) {
            $package = mysqli_fetch_assoc($result);
            $customer_name = $package['first_name'] . ' ' . $package['last_name'];
            $shipment_number = $package['shipmentId'] ?? 'N/A';

            // Get total packages in shipment
            if ($package['shipment_id']) {
                $sql_total = "SELECT COUNT(*) as total FROM packages WHERE shipment_id = " . $package['shipment_id'];
                $result_total = mysqli_query($conn, $sql_total);
                $total_packages = mysqli_fetch_assoc($result_total)['total'];

                // Active packages (not delivered)
                $sql_active = "SELECT COUNT(*) as active FROM packages WHERE shipment_id = " . $package['shipment_id'] . " AND status != 'Delivered'";
                $result_active = mysqli_query($conn, $sql_active);
                $active_packages = mysqli_fetch_assoc($result_active)['active'];
            }
        }
    }

    // If no package found, show error
    if (!$package) {
        echo "<div class='alert alert-danger'>Package not found.</div>";
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Package View | Pync Parcel Chateau</title>
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
    <div class="wrapper admin trackingdetails">
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
                  <p> Packages</p>
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
                      <span class="fw-bold"> <?php echo user_account_information()['first_name'] ; ?> </span> 
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
			    <div class="row Tracking-details-are"> 
				      <div class="col-6 Packages_top_info"> 
					    <a href="packages.php">
					     <i class="fa-solid fa-angle-left"></i>
						 </a>
					     <!--<h4>Packages</h4>
						 <h2>Computer</h2>-->
						 <p class="Created_at">Created on <b><?php echo date('M j, Y, g:i A', strtotime($package['created_at'])); ?></b></p>
					  </div>
				      <div class="col-6 setting_icon_area"> 
					      <i data-bs-toggle="dropdown" aria-expanded="false" class="fa-solid fa-ellipsis"></i>
							<div class="dropdown">
							  <ul class="dropdown-menu">
								<li> 
								 <a data-toggle="modal" data-target="#ShipmenUpdating" 
								 class="dropdown-item" href="#"> 
								    <i class="fa fa-edit"></i>
								    Update Shipment 
								   </a> 
								</li>
								<li>
									<a class="dropdown-item delete_Package" href="#">
									 <i class="fa fa-trash"></i>
									 Delete Package 
									</a> 
								</li>
							  </ul>
							</div>
					  </div>
				</div>
			  	<div class="col-md-3 Package-details"> 
					  <h2>Package Details</h2>
					  <div class="box Parcel-box">
					     <img src="assets/img/Packages.png" alt="box" /> 
					   </div>
					  <div class="Package-info"> 
						 <div class="Tracking-value">
							 <span class="heading"> Courier Company</span>
							 <span class="value"><?php echo htmlspecialchars($package['courier_company'] ?? 'N/A'); ?></span>
						</div>

						<div class="Tracking-value">
							 <span class="heading">Value of Package</span>
							 <span id="Package-value" class="value">$<?php echo number_format($package['value_of_package'] ?? 0, 2); ?></span>
						</div>
						<div class="Tracking-value">
							 <span class="heading"> Package Content</span>
							 <span class="value"><?php echo htmlspecialchars($package['describe_package'] ?? 'N/A'); ?></span>
						</div>
						 <div class="Tracking-value">
							 <span class="heading">Merchant</span>
							 <span class="value"><?php echo htmlspecialchars($package['merchant'] ?? 'N/A'); ?></span>
						</div>
						  <div class="Tracking-value">
							 <span  class="heading">Weight</span>
							 <span id="Package-Weight" class="value"><?php echo htmlspecialchars($package['weight'] ?? 'N/A'); ?> lbs</span>
						</div>
                        <div class="Tracking-value">
							 <span class="heading">Charges</span>
							 <span class="value Charges"><span><?php echo $package['invoice_total'] ? '$' . number_format($package['invoice_total'], 2) : 'N/A'; ?></span></span>
						</div>
				  </div>
				</div>
				<div class="col-md-9"> 
				    <div class="row"> 
						<div id="Tracking_number" class="col-md-5 ">
							<h3>Tracking Number</h3>
							<p><?php echo htmlspecialchars($package['tracking_number']); ?></p>
						</div>
						<div id="shipping" class="col-md-5">
							<h3>On Shipment</h3>
							<p><?php echo htmlspecialchars($shipment_number); ?></p>
						</div>
						<div id="Totall-Packages" class="col-md-5 ">
							<h3>Total Packages</h3>
							<p><?php echo $total_packages; ?></p>
						</div>
						<div id="Active-Packages" class="col-md-5 ">
							<h3>Active Packages</h3>
							<p><?php echo $active_packages; ?></p>
						</div>
					     <!--Invoice-->
						<div class="invoice"> 
						   <h2 style="color:#222; font-family:avenir-light !important;text-align: center;margin-top: 30px;margin-bottom: 16px;"> No invoice attached </h2>
							<div>
								<div class="d-flex  justify-content-center">
								   <h3>Click here to upload invoice</h3>
								   <p>Please upload an invoice to avoid any delays in processing at customs</p>
									<img id="selectedImage" src="assets/img/cloud-computing.png"
									alt="example placeholder" />
								</div>
								<div class="d-none justify-content-center">
									<div data-mdb-ripple-init class="btn btn-primary btn-rounded">
										<label class="form-label text-white m-1" for="customFile1">Choose file</label>
										<input type="file" class="form-control d-none" id="customFile1" onchange="displaySelectedImage(event, 'selectedImage')" />
									</div>
								</div>
								<p class="file_Supported"><span>Supported: </span> PDF, PNG or JPG (MAX. 10MB)</p>
							    <div style="display:none" class="alert alert-warning alert-dismissible fade     show" role="alert">
								  <strong style="color: red;"></strong>
								  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							    </div> 
							</div>
						</div>
				 <!--
					<div class="package-details"> 
			         <div class="account_information"> 
				       	 <h3> Account Info </h3>
						<div class="accordion accordion-flush" id="accordionFlushExample">
						  <div class="accordion-item">
							<h2 class="accordion-header">
							  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
								Basic Information
							  </button>
							</h2>
							<div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
							  <div class="accordion-body">
								<div class="Tracking-value"> 
									 <span class="heading">First Name</span>
									 <span class="value">Abdul</span>
								</div> 
								 <div class="Tracking-value"> 
									 <span class="heading">Last Name</span>
									 <span class="value">quadri</span>
								</div>

								<div class="Tracking-value"> 
									 <span class="heading">Phone</span>
									 <span class="value">183-475-4758</span>
								</div>
								<div class="Tracking-value"> 
									 <span class="heading">Email Address</span>
									 <span class="value">example@gmail.com</span>
								</div> 
								<div class="Tracking-value"> 
									 <span class="heading">Date of Birth</span>
									 <span class="value">No set</span>
								</div>  
								<div class="Tracking-value"> 
									 <span class="heading"> Gender</span>
									 <span class="value">Male</span>
								</div> 
								<div class="Tracking-value"> 
									 <span class="heading">Copy of Photo Identification</span>
									 <span class="value"><img width="70px" src="https://dmv.nebraska.gov/sites/default/files/img/NE%20D100%20PR_ADULT_ID_300dpi.jpg" alt="" /></span>
								</div> 
								 <div class="Tracking-value"> 
									 <span class="heading"> Other File </span>
									 <span class="value">No set</span>
								</div> 	
							  </div>
							</div>
						  </div>
						  <div class="accordion-item">
							<h2 class="accordion-header">
							  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
								Delivery Preference
							  </button>
							</h2>
							<div id="flush-collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
							  <div class="accordion-body"> 
								<div class="Tracking-value"> 
									 <span class="heading">Address Type</span>
									 <span class="value">Home</span>
								</div> 
								 <div class="Tracking-value"> 
									 <span class="heading">Parish</span>
									 <span class="value">Kingston</span>
								</div>
								<div class="Tracking-value"> 
									 <span class="heading">Region</span>
									 <span class="value">Half-Way Tree</span>
								</div>
							  </div>
							</div>
						  </div>
						  <div class="accordion-item">
							<h2 class="accordion-header">
							  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
								 Authorized Users
							  </button>
							</h2>
							<div id="flush-collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
							 <div class="accordion-body">
								<div class="Tracking-value"> 
									 <span class="heading">First Name</span>
									 <span class="value">Y</span>
								</div> 
								 <div class="Tracking-value"> 
									 <span class="heading">Last</span>
									 <span class="value">Z</span>
								</div>
								<div class="Tracking-value"> 
									 <span class="heading">Identification Type</span>
									 <span class="value">passport</span>
								</div>
								 <div class="Tracking-value"> 
									 <span class="heading">ID Number</span>
									 <span class="value">E12345678</span>
								</div>	
							  </div>
							</div>
						  </div>
						  <div class="accordion-item">
							<h2 class="accordion-header">
							  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapsefour" aria-expanded="false" aria-controls="flush-collapseThree">
								 Miami Address
							  </button>
							</h2>
							<div id="flush-collapsefour" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
							 <div class="accordion-body">
									<div class="Tracking-value"> 
										No Set
									</div> 		
							  </div>
							</div>
						  </div>
						</div>
				  </div>
			    </div>
			      -->
				</div>
				</div>
			  </div>
		 </div>
		  <!-- Modal for Shipment updating -->
		<div class="modal fade" id="ShipmenUpdating" tabindex="-1" aria-labelledby="ShipmenUpdating" aria-hidden="true">
		  <div class="modal-dialog modal-lg">
			<div class="modal-content">
			  <div class="modal-header"> 
				 <div> 
					<h2>Update Shipment</h2>
				    <p>Modify package information</p>
			    </div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true"><i class="fa fa-close"></i></span>
				</button>
			  </div>
			  <div class="modal-body">
			    <form action="#">
					    <div class="form-group change-value">
							  <label for="Firstname">Courier charge<span class="mandatory_field">*</span> </label>
							  <input placeholder="e.g. $20"  type="number" class="form-control" id="Firstname"
							  />
						</div>
                        <div class="form-group">
						  <label for="AddressType">Tracking progress<span class="mandatory_field">*</span></label>
						  <select   class="form-select AddressType" id="AddressType">
							  <option value="0">Choose...</option>
							  <option value="1">In Transit to Jamaica</option>
							  <option value="1">Received at Warehouse</option>
							  <option value="2">Undergoing Customs Clearance </option>
							  <option value="3">Ready for Delivery Instructions </option>
							  <option value="3">Delivered</option>
							</select>
					   </div> 
					    <div class="form-group">
						  <label for="date">Tracking Date<span class="">*</span></label> 
						   <input type="date"  class="form-control" id="date"
							  />
					   </div> 
                     	<div class="card-action d-flex ">
							   <button type="submit" class="btn my-4 updatePreAltBtn">
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
			$('.delete_Package').click( function(){
				
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
					  text: "The Package has been deleted.",
					  icon: "success"
					});
				  }
				}); 
			});  
        // ===== Invoice upload ===
	    
        // if invoice are clecked, file input will open.		
		$('.invoice .d-flex:first-child').click(function() {
		     $('#customFile1').click(); 
        });
		 
		function displaySelectedImage(event, elementId) {
			const selectedImage = document.getElementById(elementId);
			const fileInput = event.target; 
			
            const fileName  = fileInput.files[0].name;  // getting file name
            const filesize  = fileInput.files[0].size; // getting file size
			const fileSizeMB = (filesize / (1024 * 1024)).toFixed(2); // bytes to MB  
            const fileExtension = (fileName.split('.').pop()).toLowerCase();// Getting the file extension
			 
			if(fileExtension == "png" || fileExtension == "pdf" || fileExtension == "jpg"
			
			){ 
			  if( fileSizeMB < 10  ){ 
			     	if (fileInput.files && fileInput.files[0]) {
				    const reader = new FileReader();

				   reader.onload = function(e) {
					selectedImage.src = e.target.result; 
				};
				reader.readAsDataURL(fileInput.files[0]);
			}
			    }else{ 
				
				   $('.invoice .alert-warning').show();
			       $('.invoice .alert-warning strong').text('Please upload a file Which is less than 10MB');
			    } 
			 }else{ 
			 
			     $('.invoice .alert-warning').show();
			     $('.invoice .alert-warning strong').text('The file not Supported');
				 
			 }
		}
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