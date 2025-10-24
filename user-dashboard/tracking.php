<?php
    session_start();
    include '../config.php';
    include '../function.php';
    include '../user-area/authorized-user.php';

    global $user_id;
    if (!$user_id) {
        header('Location: ../sign-in.php');
        exit;
    }

    $tracking_number = isset($_GET['tracking']) ? mysqli_real_escape_string($conn, $_GET['tracking']) : '';
    $package         = null;
    if ($tracking_number) {
        $sql    = "SELECT p.*, pr.merchant FROM packages p LEFT JOIN `pre_alert` pr ON p.tracking_number = pr.tracking_number AND p.user_id = pr.user_id WHERE p.tracking_number = '$tracking_number' AND p.user_id = $user_id";
        $result = mysqli_query($conn, $sql);
        if ($result && mysqli_num_rows($result) > 0) {
            $package = mysqli_fetch_assoc($result);
        }
    }

    if (! $package) {
        echo "<div class='mt-5 text-center alert alert-danger'>Package not found or access denied.</div>";
        exit;
    }

    // Define tracking steps
    $steps = [
        'Received at Warehouse',
        'In Transit to Jamaica',
        'Undergoing Customs Clearance',
        'Ready for Delivery Instructions',
        'Delivered',
    ];

    // Parse tracking_history to get dates for each step
    $tracking_history = json_decode($package['tracking_history'] ?? '[]', true);
    if (! is_array($tracking_history)) {
        $tracking_history = [];
    }

    // Create a map of step to date
    $step_dates = [];
    foreach ($tracking_history as $entry) {
        $step_dates[$entry['step']] = $entry['date'];
    }

    // Determine completed steps based on tracking_progress or status
    $current_status  = $package['tracking_progress'] ?? $package['status'];
    $completed_up_to = 0;
    if (stripos($current_status, 'Received at Warehouse') !== false) {
        $completed_up_to = 1;
    } elseif (stripos($current_status, 'In Transit to Jamaica') !== false) {
        $completed_up_to = 2;
    } elseif (stripos($current_status, 'Undergoing Customs Clearance') !== false) {
        $completed_up_to = 3;
    } elseif (stripos($current_status, 'Ready for Delivery Instructions') !== false) {
        $completed_up_to = 4;
    } elseif (stripos($current_status, 'Delivered') !== false) {
        $completed_up_to = 5;
    } else {
        $completed_up_to = 0;
    }
    // none completed

  // Allowed tracking steps (same as admin)
  $steps = [
    'Received at Warehouse',
    'In Transit to Jamaica',
    'Undergoing Customs Clearance',
    'Ready for Delivery Instructions',
    'Delivered',
  ];

  // Handle user updates (charge amount, status, invoice) — allow only for owner
  if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_package'])) {
    // Ensure package belongs to current user
    if ($package['user_id'] != $user_id) {
      echo "<div class='alert alert-danger'>Access denied.</div>";
    } else {
      $courier_charge    = mysqli_real_escape_string($conn, $_POST['courier_charge'] ?? '');
      $tracking_progress = mysqli_real_escape_string($conn, $_POST['tracking_progress'] ?? '');

      // Handle invoice upload
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
            // delete old invoice if present and different
            if (! empty($package['invoice_file']) && $package['invoice_file'] !== $invoice_file_path) {
              $old_path = __DIR__ . '/' . $package['invoice_file'];
              if (file_exists($old_path)) {
                @unlink($old_path);
              }
            }
          } else {
            echo "<div class='alert alert-danger'>Failed to move uploaded file.</div>";
          }
        }
      }

      $updates = [];
      if (! empty($courier_charge)) {
        $updates[] = "invoice_total = '" . floatval($courier_charge) . "'";
      }
      if (! empty($tracking_progress) && in_array($tracking_progress, $steps)) {
        // allow user to set status (no strict progression check for user)
        $safe_tracking_progress = substr(mysqli_real_escape_string($conn, $tracking_progress), 0, 255);
        $updates[] = "tracking_progress = '" . $safe_tracking_progress . "'";
        // append to tracking_history
        $current_history = json_decode($package['tracking_history'] ?? '[]', true);
        if (! is_array($current_history)) $current_history = [];
        $current_history[] = ['step' => $tracking_progress, 'date' => date('Y-m-d H:i:s')];
        $updates[] = "tracking_history = '" . mysqli_real_escape_string($conn, json_encode($current_history)) . "'";
      }
      if (! empty($invoice_file_path)) {
        $updates[] = "invoice_file = '" . mysqli_real_escape_string($conn, $invoice_file_path) . "'";
      }

      if (! empty($updates)) {
        $update_sql = "UPDATE packages SET " . implode(', ', $updates) . " WHERE tracking_number = '" . mysqli_real_escape_string($conn, $package['tracking_number']) . "'";
        if (mysqli_query($conn, $update_sql)) {
          echo "<div class='alert alert-success'>Package updated successfully.</div>";
          // refresh package data
          $sql = "SELECT p.*, pr.merchant FROM packages p LEFT JOIN `pre_alert` pr ON p.tracking_number = pr.tracking_number AND p.user_id = pr.user_id WHERE p.tracking_number = '" . mysqli_real_escape_string($conn, $package['tracking_number']) . "' AND p.user_id = $user_id";
          $result = mysqli_query($conn, $sql);
          if ($result && mysqli_num_rows($result) > 0) {
            $package = mysqli_fetch_assoc($result);
            // rebuild tracking history map
            $tracking_history = json_decode($package['tracking_history'] ?? '[]', true);
            $step_dates = [];
            foreach ($tracking_history as $entry) {
              $step_dates[$entry['step']] = $entry['date'];
            }
          }
        } else {
          echo "<div class='alert alert-danger'>Error updating package: " . mysqli_error($conn) . "</div>";
        }
      }
    }
  }

?>
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
                <a href="makepayment.php">
                  <img class="payment-icon" src="assets/img/payment-protection.png" alt="payment" />
                  <p>Make Payment</p>
                </a>
              </li>
			  <li class="nav-item">
                <a  href="mymiamiaddress.php">
                <img class="user-icon" src="assets/img/location.png" alt="location" />
                  <p>My Miami Address</p>
                </a>
              </li>
              <li class="nav-item">
                <a  href="user-account.php">
                <img class="user-icon" src="assets/img/user.png" alt="User" />
                  <p>My account</p>
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
                      <span class="fw-bold"><?php echo user_account_information()['first_name']; ?></span>
                </li>
              </ul>
            </div>
          </nav>
          <!-- End Navbar -->
        </div>
        <div class="container">
        <div class="page-inner">
	    <section class="py-5 bsb-timeline-5 py-xl-8">
	   <div class="row justify-content-center">
	      <div class="Tracking-close">
		     <a href="package.php"><img src="assets/img/close.png" alt="close"></a>
		  </div>
	   <div class="col-md-5 Package-details">
		 <div class="box"><img src="assets/img/box.png" alt="box" /></div>
		  <div class="Package-info">
			<h2>Package Details</h2>
			<div class="Tracking-value">
				 <span class="heading"> Tracking Number</span>
				 <span class="value"><?php echo htmlspecialchars($package['tracking_number']); ?></span>
			</div>
			 <div class="Tracking-value">
				 <span class="heading"> Courier Company</span>
				 <span class="value"><?php echo htmlspecialchars($package['courier_company'] ?? 'N/A'); ?></span>
			</div>

      <div class="Tracking-value">
         <span class="heading">Value of Package</span>
         <span class="value">$<?php echo number_format($package['value_of_package'] ?? 0, 2); ?></span>
      </div>
      <!-- Update form: charge amount, status, invoice upload (ADMIN_ONLY) -->
      <!-- <form method="POST" enctype="multipart/form-data" class="mt-3">
        <div class="mb-2">
          <label class="form-label">Charge Amount (USD)</label>
          <input type="text" name="courier_charge" class="form-control" value="<?php echo isset($package['invoice_total']) ? htmlspecialchars(number_format($package['invoice_total'], 2)) : ''; ?>" placeholder="Enter charge amount or leave blank to use calculated value">
        </div>
        <div class="mb-2">
          <label class="form-label">Status</label>
          <select name="tracking_progress" class="form-select">
            <option value="">-- Keep current --</option>
            <?php foreach ($steps as $s) { ?>
              <option value="<?php echo htmlspecialchars($s); ?>" <?php echo (isset($package['tracking_progress']) && $package['tracking_progress'] == $s) ? 'selected' : ''; ?>><?php echo htmlspecialchars($s); ?></option>
            <?php } ?>
          </select>
        </div>
        <div class="mb-2">
          <label class="form-label">Invoice (upload/replace)</label>
          <?php if (!empty($package['invoice_file'])) { ?>
            <div class="mb-1"><a target="_blank" href="<?php echo htmlspecialchars($package['invoice_file']); ?>">View current invoice</a></div>
          <?php } ?>
          <input type="file" name="invoice_file" accept=".pdf,.png,.jpg,.jpeg" class="form-control" />
        </div>
        <div>
          <button type="submit" name="update_package" class="update-package btn btn-primary">Save</button>
        </div>
      </form> -->
			<div class="Tracking-value">
				 <span class="heading"> Package Content</span>
				 <span class="value"><?php echo htmlspecialchars($package['describe_package'] ?? 'N/A'); ?></span>
			</div>
			 <div class="Tracking-value">
				 <span class="heading">merchant</span>
				 <span class="value"><?php echo htmlspecialchars($package['merchant'] ?? 'N/A'); ?></span>
			</div>
	  </div>
  </div>
  <div class="col-md-7 Tracking-area">
	<h1 class="trackingHeading">Tracking Information</h1>
	<ul class="timeline">
	<?php
        foreach ($steps as $index => $step) {
            $step_date = isset($step_dates[$step]) ? date('m/d/Y', strtotime($step_dates[$step])) : date('m/d/Y', strtotime($package['created_at'])); // Use history date or created_at as fallback
            $opacity   = ($index < $completed_up_to) ? '1' : '0.2';
        ?>
	  <li class="timeline-item">
		<span style="opacity:		                      <?php echo $opacity; ?>;" class="timeline-icon">
		  <i class="bi-check-lg text-primary"></i>
		</span>
		<div class="timeline-body">
		  <div class="timeline-content">
			<div class="card text-bg-primary">
			  <div class="card-header"><?php echo $step_date; ?></div>
			  <div class="card-body">
				<p><?php echo $step; ?></p>
			  </div>
			</div>
		  </div>
		</div>
	  </li>
	<?php }?>
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
