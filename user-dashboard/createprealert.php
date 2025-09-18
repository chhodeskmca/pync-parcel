<?php
    // initialize session
    session_start();
    include '../config.php';                             // database connection
    include '../function.php';                           // function
    include '../user-area/authorized-user.php';          // function
    $current_file_name = basename($_SERVER['PHP_SELF']); // getting current file name
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Create Pre-alert - Pync Parcel Chateau</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no"  name="viewport" />
	  <!--alertify css -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/css/alertify.min.css" integrity="sha512-IXuoq1aFd2wXs4NqGskwX2Vb+I8UJ+tGJEu/Dc0zwLNKeQ7CW3Sr6v0yU3z5OQWe3eScVIkER4J9L7byrgR/fA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
    <div class="wrapper create-Prealert">
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
                  <p style="<?php echo $current_file_name == 'createprealert.php' ? 'color: #E87946 !important' : ''; ?>">Create Pre-alert</p>
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
                <a href="mymiamiaddress.php">
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
          <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
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
		    <!-- create prealert start-->
		     <div class="row">
              <div class="col-md-12">
                <div class="card">
				<form method="POST" class="create_PreAlert" action="../codes.php" enctype="multipart/form-data">
                  <div class="card-header">
                    <div class="card-title"><h1 class="ctePrealt">Create Pre-alert</h1></div>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                          <label for="TrackingNumber">Tracking Number</label>
                          <input name="tracking_number"
                            type="text" required
                            class="form-control"
                            id="TrackingNumber"
                            placeholder="Enter Tracking Number"
                          />
                        </div>
						<div class="form-group">
                          <label for="value">Value of Package (USD)</label>
                          <input name="ValueofPackage" required autocomplete="off" id="priceField" step=".01" min="0" onkeypress="return priceCheck(this, event);"
                            type="number"
                            class="form-control floatNumberField"
                            placeholder="0.00"
                          />
                        </div>
                      </div>
                      <div class="col-md-6 col-lg-4">
					   <div class="form-group">
                          <label for="exampleFormControlSelect1"
                            >Courier Company</label
                          >
                          <select name="courier_company" required
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
                          <textarea  name="describe_package" class="form-control" id="comment" rows="3"></textarea>
                        </div>
                      </div>
					   <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                          <label for="Store">merchant (source of purchase)</label>
                          <input required name="merchant"
                            type="text"
                            class="form-control"
                            id="Store"
                            placeholder="Enter Store name"
                          />
                        </div>
						<div class="form-group">
						     <h2 style="font-family:avenir-light !important; color: #495057; font-size: 14px !important; font-weight: 400;">Invoice</h2>
						   	<div class="invoice">
								<div class="d-flex justify-content-center">
								   <h3>Click here to upload invoice</h3>
								   <p>Please upload an invoice to avoid any delays in processing at customs</p>
									<img id="selectedImage" src="../admin-dashboard/assets/img/cloud-computing.png"
									alt="example placeholder" />
								</div>
								<div class="d-none justify-content-center">
									<div data-mdb-ripple-init class="btn btn-primary btn-rounded">
										<label class="form-label text-white m-1" for="customFile1">Choose file</label>
										<input name="file" type="file" class="form-control d-none" id="customFile1" onchange="displaySelectedImage(event, 'selectedImage')" />
									</div>
								</div>
								<p class="file_Supported"><span>Supported: </span> PDF, PNG or JPG (MAX. 10MB)</p>
								<div style="display:none" class="alert alert-warning alert-dismissible fade show" role="alert">
								  <strong style="color: red;"></strong>
								  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
								</div>
							</div>
						</div>
                      </div>
					</div>
                  </div>
                  <div class="card-action d-flex">
				    <input type="text" hidden name="Pre-alert" />
                    <button class="btn pre_cretBtn">
					  <img style='display:none' class='spinner'  width="20px" src="../assets/img/spinner.gif" alt="" />
					  Create
					 </button>
                  </div>
				  </form>
                </div>
              </div>
            </div>
		  <!-- create prealert end-->
			<!--My package start-->
		    <div class="row">
			  <div class="col-md-12">
                <div class="card card-round">
				<?php
                    $sql = "SELECT* FROM pre_alert where User_id = $user_id ORDER BY id DESC";
                    if (mysqli_num_rows(mysqli_query($conn, $sql)) > 0) {
                    ?>
                  <div class="card-header">
                    <div class="card-head-row card-tools-still-right justify-content-center">
                      <div style="font-size: 18px;" class="card-title UpPrealert-heading"><h2>Update Pre-alert</h2></div>
					</div>
                  </div>
                  <div class="card-body p-0">
                    <div class="table-responsive">
                      <!-- Projects table -->
                      <table class="table  mb-0">
                        <thead class="thead-light">
                          <tr>
                            <th scope="col">Tracking Number</th>
                            <th scope="col">Courier Company</th>
                            <th scope="col">Store</th>
                            <th scope="col">Value of Package (USD)</th>
                            <th scope="col">Package Description</th>
                            <th scope="col">Date Created</th>
                          </tr>
                        </thead>
                        <tbody style="text-align-last: center;">
						<?php
                            if (mysqli_num_rows(mysqli_query($conn, $sql)) > 0) {
                                    $result = mysqli_query($conn, $sql);
                                    while ($rows = mysqli_fetch_array($result)) {
                                    ?>
                          <tr>
                            <td class="text-end edit-prealt">
                              <span class="prealert-edit-btn">
                                <a href="updateprealert.php?pre_alert_id=<?php echo isset($rows['id']) ? $rows['id'] : ''; ?>">
                                <img src="assets\img\edit.png" alt="edit" />
                              </a>
                              </span>
                                <?php echo isset($rows['tracking_number']) ? $rows['tracking_number'] : ''; ?>
                            </td>
                            <td><?php echo isset($rows['courier_company']) ? $rows['courier_company'] : ''; ?></td>
                            <td><?php echo isset($rows['merchant']) ? $rows['merchant'] : ''; ?></td>
                            <td><?php echo isset($rows['value_of_package']) ? $rows['value_of_package'] : ''; ?></td>
                            <td><?php echo isset($rows['describe_package']) ? $rows['describe_package'] : ''; ?></td>
                            <td><?php echo isset($rows['created_at']) ? date('d/m/y', strtotime($rows['created_at'])) : ''; ?></td>
                          </tr>
						  <?php
                              }
                                  }
                              ?>
						</tbody>
                      </table>
                    </div>
                  </div>
				<?php
                    } else {
                        echo "
\t\t\t\t\t    <h2 style='text-align: center; padding: 50px;  font-size: 20px;line-height: 21px;'>
\t\t\t\t\t     You have no Pre-alert. Please create Pre-alerts.
\t\t\t\t\t    </h2>
\t\t\t\t\t ";
                    }
                ?>
                </div>
              </div>
            </div>
		   <!--My package end-->
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
     <!-- alertify -->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/alertify.min.js" integrity="sha512-JnjG+Wt53GspUQXQhc+c4j8SBERsgJAoHeehagKHlxQN+MtCCmFDghX9/AcbkkNRZptyZU4zC8utK59M5L45Iw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- jQuery Scrollbar -->
    <script src="assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
    <!-- Kaiadmin JS -->
      <script src="assets/js/kaiadmin.min.js"></script>
	  	  <!-- custom JS -->
	 <script src="assets/js/custom.js" > </script>
	 <script type="text/javascript">
			 function priceCheck(element, event) {
			result = (event.charCode >= 48 && event.charCode <= 57) || event.charCode === 46;
			if (result) {
				let t = element.value;
				if (t === '' && event.charCode === 46) {
					return false;
				}
				let dotIndex = t.indexOf(".");
				let valueLength = t.length;
				if (dotIndex > 0) {
					if (dotIndex + 2 < valueLength) {
						return false;
					} else {
						return true;
					}
				} else if (dotIndex === 0) {
					return false;
				} else {
					return true;
				}
			} else {
				return false;
			}
		};
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
		};
	   // Submission form will start after 1 second
	    $(document).ready(function() {
		  $('.create_PreAlert').on('submit', function(e) {
			 $('.spinner').css('display', 'inline');
			e.preventDefault(); // Stop form from submitting immediately
			let form = this; // Store reference to the form element
			setTimeout(function() {
			  form.submit(); // Native submit after delay
			}, 1000); // 5000ms = 5 seconds
		  });
		});
</script>
       <?php
           if (isset($_SESSION['message'])) {
           ?>
        <script>
            // ===== alertify======
            alertify.set('notifier','position', 'top-right');
		    alertify.success("<?php echo $_SESSION['message']; ?>");
		</script>
		 <?php
             unset($_SESSION['message']);
             }
         ?>
  </body>
</html>