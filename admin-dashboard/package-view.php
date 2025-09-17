<?php
    // initialize session
    session_start();
    include '../config.php';   // database connection
    include '../function.php'; // function comes from user dashboard
    include 'function.php';    // function comes from admin dashboard
    include 'authorized-admin.php';
    $current_file_name = basename($_SERVER['PHP_SELF']); // getting current file name

    // Get tracking number from URL
    $tracking_number = isset($_GET['tracking']) ? mysqli_real_escape_string($conn, $_GET['tracking']) : '';

    // Initialize variables
    $package               = null;
    $customer_name         = 'Unknown';
    $shipment_number       = 'N/A';
    $total_packages        = 0;
    $active_packages       = 0;
    $customer_email        = 'N/A';
    $customer_phone        = 'N/A';
    $customer_dob          = 'N/A';
    $customer_gender       = 'N/A';
    $customer_photo_id     = null;
    $customer_other_file   = 'N/A';
    $delivery_address_type = 'N/A';
    $delivery_parish       = 'N/A';
    $delivery_region       = 'N/A';
    $authorized_users      = [];

    if (! empty($tracking_number)) {
        // Query package details with user and shipment info
        $sql = "SELECT p.*, u.first_name, u.last_name, u.email_address as email, u.phone_number as phone, u.date_of_birth, u.gender, s.shipment_number,
                d.address_type, d.parish, d.region
                FROM packages p
                LEFT JOIN users u ON p.user_id = u.id
                LEFT JOIN shipments s ON p.shipment_id = s.id
                LEFT JOIN delivery_preference d ON u.id = d.user_id
                WHERE p.tracking_number = '$tracking_number'";
        $result = mysqli_query($conn, $sql);
        if ($result && mysqli_num_rows($result) > 0) {
            $package               = mysqli_fetch_assoc($result);
            $customer_name         = $package['first_name'] . ' ' . $package['last_name'];
            $customer_email        = $package['email'] ?? 'N/A';
            $customer_phone        = $package['phone'] ?? 'N/A';
            $customer_dob          = $package['date_of_birth'] ?? 'N/A';
            $customer_gender       = $package['gender'] ?? 'N/A';
            $customer_photo_id     = $package['photo_id'] ?? null;
            $customer_other_file   = $package['other_file'] ?? 'N/A';
            $shipment_number       = $package['shipment_number'] ?? 'N/A';
            $delivery_address_type = $package['address_type'] ?? 'N/A';
            $delivery_parish       = $package['parish'] ?? 'N/A';
            $delivery_region       = $package['region'] ?? 'N/A';

            // Get total packages in shipment
            if ($package['shipment_id']) {
                $sql_total      = "SELECT COUNT(*) as total FROM packages WHERE shipment_id = " . $package['shipment_id'];
                $result_total   = mysqli_query($conn, $sql_total);
                $total_packages = mysqli_fetch_assoc($result_total)['total'];

                // Active packages (not delivered)
                $sql_active      = "SELECT COUNT(*) as active FROM packages WHERE shipment_id = " . $package['shipment_id'] . " AND status != 'Delivered'";
                $result_active   = mysqli_query($conn, $sql_active);
                $active_packages = mysqli_fetch_assoc($result_active)['active'];

                // Get authorized users for shipment
                $sql_auth_users    = "SELECT first_name, last_name, identification_type, id_number FROM authorized_users WHERE shipment_id = " . $package['shipment_id'];
                $result_auth_users = mysqli_query($conn, $sql_auth_users);
                if ($result_auth_users && mysqli_num_rows($result_auth_users) > 0) {
                    while ($row = mysqli_fetch_assoc($result_auth_users)) {
                        $authorized_users[] = $row;
                    }
                }
            }
        }
    }

    // Handle package update
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_package'])) {
        $courier_charge    = mysqli_real_escape_string($conn, $_POST['courier_charge'] ?? '');
        $tracking_progress = mysqli_real_escape_string($conn, $_POST['tracking_progress'] ?? '');
        $tracking_date     = mysqli_real_escape_string($conn, $_POST['tracking_date'] ?? '');

        // Handle invoice file upload
        $invoice_file_path = null;
        if (isset($_FILES['invoice_file']) && $_FILES['invoice_file']['error'] === UPLOAD_ERR_OK) {
            $allowed_extensions = ['pdf', 'png', 'jpg', 'jpeg'];
            $file_tmp_path      = $_FILES['invoice_file']['tmp_name'];
            $file_name          = basename($_FILES['invoice_file']['name']);
            $file_size          = $_FILES['invoice_file']['size'];
            $file_ext           = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

            if (! in_array($file_ext, $allowed_extensions)) {
                echo "<div class='alert alert-danger'>Invalid file type. Only PDF, PNG, JPG files are allowed.</div>";
            } elseif ($file_size > 10 * 1024 * 1024) {
                echo "<div class='alert alert-danger'>File size exceeds 10MB limit.</div>";
            } else {
                $upload_dir = __DIR__ . '/uploads/invoices/';
                if (! is_dir($upload_dir)) {
                    mkdir($upload_dir, 0755, true);
                }
                $new_file_name = uniqid('invoice_') . '.' . $file_ext;
                $destination   = $upload_dir . $new_file_name;
                if (move_uploaded_file($file_tmp_path, $destination)) {
                    $invoice_file_path = 'uploads/invoices/' . $new_file_name;
                } else {
                    echo "<div class='alert alert-danger'>Failed to move uploaded file.</div>";
                }
            }
        }

        // Convert tracking_date to MySQL format if provided
        $tracking_date_mysql = '';
        if (! empty($tracking_date)) {
            $dt = DateTime::createFromFormat('Y-m-d', $tracking_date);
            if ($dt) {
                $tracking_date_mysql = $dt->format('Y-m-d H:i:s');
            }
        }

        // Update package
        $update_sql = "UPDATE packages SET ";
        $updates    = [];
        if (! empty($courier_charge)) {
            $updates[] = "invoice_total = '" . floatval($courier_charge) . "'";
        }
        if (! empty($tracking_progress)) {
            // Sanitize and limit tracking_progress length to avoid data truncation error
            $safe_tracking_progress = substr(mysqli_real_escape_string($conn, $tracking_progress), 0, 255);
            $updates[]              = "tracking_progress = '" . $safe_tracking_progress . "'";
        }
        if (! empty($tracking_date_mysql)) {
            $updates[] = "created_at = '" . $tracking_date_mysql . "'";
        }
        if (! empty($invoice_file_path)) {
            $updates[] = "invoice_file = '" . mysqli_real_escape_string($conn, $invoice_file_path) . "'";
        }

        if (! empty($updates)) {
            $update_sql .= implode(', ', $updates) . " WHERE tracking_number = '$tracking_number'";
            if (mysqli_query($conn, $update_sql)) {
                echo "<div class='alert alert-success'>Package updated successfully.</div>";
                // Refresh package data
                $result = mysqli_query($conn, $sql);
                if ($result && mysqli_num_rows($result) > 0) {
                    $package = mysqli_fetch_assoc($result);
                }
            } else {
                echo "<div class='alert alert-danger'>Error updating package: " . mysqli_error($conn) . "</div>";
            }
        }
    }

    // If no package found, show error
    if (! $package) {
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
                      <span class="fw-bold">                                             <?php echo user_account_information()['first_name']; ?> </span>
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
							 <span class="heading">merchant</span>
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
						<?php if (! empty($package['invoice_file'])): ?>
						   <h2 style="color:#222; font-family:avenir-light !important;text-align: center;margin-top: 30px;margin-bottom: 16px;">
							Invoice Attached: <a href="<?php echo htmlspecialchars($package['invoice_file']); ?>" target="_blank">View Invoice</a>
						   </h2>
						<?php else: ?>
						   <h2 style="color:#222; font-family:avenir-light !important;text-align: center;margin-top: 30px;margin-bottom: 16px;"> No invoice attached </h2>
						<?php endif; ?>
							<div>
								<div class="d-flex  justify-content-center" style="cursor:pointer;" onclick="document.getElementById('invoice_file').click();">
								   <h3>Click here to upload invoice</h3>
								   <p>Please upload an invoice to avoid any delays in processing at customs</p>
									<img id="selectedImage" src="assets/img/cloud-computing.png"
									alt="example placeholder" />
								</div>
								<form action="" method="POST" enctype="multipart/form-data" id="invoiceUploadForm" style="display:none;">
									<input type="file" name="invoice_file" id="invoice_file" accept=".pdf,.png,.jpg,.jpeg" onchange="document.getElementById('invoiceUploadForm').submit();" />
									<input type="hidden" name="update_package" value="1" />
									<input type="hidden" name="courier_charge" value="<?php echo htmlspecialchars($package['invoice_total'] ?? ''); ?>" />
									<input type="hidden" name="tracking_progress" value="<?php echo htmlspecialchars($package['tracking_progress'] ?? ''); ?>" />
									<input type="hidden" name="tracking_date" value="<?php echo date('Y-m-d', strtotime($package['created_at'])); ?>" />
								</form>
								<p class="file_Supported"><span>Supported: </span> PDF, PNG or JPG (MAX. 10MB)</p>
							    <div style="display:none" class="alert alert-warning alert-dismissible fade     show" role="alert">
								  <strong style="color: red;"></strong>
								  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							    </div>
							</div>
						</div>
					<!-- <div class="package-details">
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
									 <span class="value"><?php echo htmlspecialchars($package['first_name'] ?? 'N/A'); ?></span>
								</div>
								 <div class="Tracking-value">
									 <span class="heading">Last Name</span>
									 <span class="value"><?php echo htmlspecialchars($package['last_name'] ?? 'N/A'); ?></span>
								</div>

								<div class="Tracking-value">
									 <span class="heading">Phone</span>
									 <span class="value"><?php echo htmlspecialchars($customer_phone); ?></span>
								</div>
								<div class="Tracking-value">
									 <span class="heading">Email Address</span>
									 <span class="value"><?php echo htmlspecialchars($customer_email); ?></span>
								</div>
								<div class="Tracking-value">
									 <span class="heading">Date of Birth</span>
									 <span class="value"><?php echo htmlspecialchars($customer_dob); ?></span>
								</div>
								<div class="Tracking-value">
									 <span class="heading"> Gender</span>
									 <span class="value"><?php echo htmlspecialchars($customer_gender); ?></span>
								</div>
								<div class="Tracking-value">
									 <span class="heading">Copy of Photo Identification</span>
									 <span class="value"><?php if ($customer_photo_id): ?><img width="70px" src="<?php echo htmlspecialchars($customer_photo_id); ?>" alt="Photo ID" /><?php else: ?>No set<?php endif; ?></span>
								</div>
								 <div class="Tracking-value">
									 <span class="heading"> Other File </span>
									 <span class="value"><?php echo htmlspecialchars($customer_other_file); ?></span>
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
									 <span class="value"><?php echo htmlspecialchars($delivery_address_type); ?></span>
								</div>
								 <div class="Tracking-value">
									 <span class="heading">Parish</span>
									 <span class="value"><?php echo htmlspecialchars($delivery_parish); ?></span>
								</div>
								<div class="Tracking-value">
									 <span class="heading">Region</span>
									 <span class="value"><?php echo htmlspecialchars($delivery_region); ?></span>
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
								<?php if (! empty($authorized_users)): ?>
									<?php foreach ($authorized_users as $user): ?>
										<div class="Tracking-value">
											 <span class="heading">First Name</span>
											 <span class="value"><?php echo htmlspecialchars($user['first_name']); ?></span>
										</div>
										 <div class="Tracking-value">
											 <span class="heading">Last Name</span>
											 <span class="value"><?php echo htmlspecialchars($user['last_name']); ?></span>
										</div>
										<div class="Tracking-value">
											 <span class="heading">Identification Type</span>
											 <span class="value"><?php echo htmlspecialchars($user['identification_type']); ?></span>
										</div>
										 <div class="Tracking-value">
											 <span class="heading">ID Number</span>
											 <span class="value"><?php echo htmlspecialchars($user['id_number']); ?></span>
										</div>
									<?php endforeach; ?>
								<?php else: ?>
									<div class="Tracking-value">
										No authorized users set
									</div>
								<?php endif; ?>
							  </div>
							</div>
						  </div>
						  <div class="accordion-item">
							<h2 class="accordion-header">
							  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapsefour" aria-expanded="false" aria-controls="flush-collapsefour">
								 Miami Address
							  </button>
							</h2>
							<div id="flush-collapsefour" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
							 <div class="accordion-body">
									<div class="Tracking-value">
										<?php
                                            // Query for Miami address if exists
                                            $miami_address = 'No Set';
                                            if ($package['user_id']) {
                                                $sql_miami    = "SELECT address FROM miami_addresses WHERE user_id = " . $package['user_id'];
                                                $result_miami = mysqli_query($conn, $sql_miami);
                                                if ($result_miami && mysqli_num_rows($result_miami) > 0) {
                                                    $miami_address = mysqli_fetch_assoc($result_miami)['address'];
                                                }
                                            }
                                            echo htmlspecialchars($miami_address);
                                        ?>
									</div>
							  </div>
							</div>
						  </div>
						</div>
				  </div>
			    </div> -->
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
			    <form action="" method="POST">
					    <input type="hidden" name="update_package" value="1">
					    <div class="form-group change-value">
							  <label for="courier_charge">Courier charge<span class="mandatory_field">*</span> </label>
							  <input placeholder="e.g. $20"  type="number" class="form-control" id="courier_charge" name="courier_charge" value="<?php echo htmlspecialchars($package['invoice_total'] ?? ''); ?>"
							  />
						</div>
                        <div class="form-group">
						  <label for="tracking_progress">Tracking progress<span class="mandatory_field">*</span></label>
							  <select   class="form-select AddressType" id="tracking_progress" name="tracking_progress">
							  <option value="">Choose...</option>
						 <option value="In Transit to Jamaica"						                                       <?php echo(isset($package['tracking_progress']) && $package['tracking_progress'] == 'In Transit to Jamaica') ? 'selected' : ''; ?>>In Transit to Jamaica</option>
							  <option value="Received at Warehouse"							                                        <?php echo(isset($package['tracking_progress']) && $package['tracking_progress'] == 'Received at Warehouse') ? 'selected' : ''; ?>>Received at Warehouse</option>
							  <option value="Undergoing Customs Clearance"							                                               <?php echo(isset($package['tracking_progress']) && $package['tracking_progress'] == 'Undergoing Customs Clearance') ? 'selected' : ''; ?>>Undergoing Customs Clearance</option>
							  <option value="Ready for Delivery Instructions"							                                                  <?php echo(isset($package['tracking_progress']) && $package['tracking_progress'] == 'Ready for Delivery Instructions') ? 'selected' : ''; ?>>Ready for Delivery Instructions</option>
							  <option value="Delivered"							                            <?php echo(isset($package['tracking_progress']) && $package['tracking_progress'] == 'Delivered') ? 'selected' : ''; ?>>Delivered</option>
							</select>
					   </div>
					    <div class="form-group">
						  <label for="tracking_date">Tracking Date<span class="">*</span></label>
						 <input type="date"  class="form-control" id="tracking_date" name="tracking_date" value="<?php echo date('Y-m-d', strtotime($package['created_at'])); ?>"
						   max="<?php echo date('Y-m-d'); ?>"
						   min="<?php echo date('Y-m-d', strtotime('-2 days')); ?>"
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
