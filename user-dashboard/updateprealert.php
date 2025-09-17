<?php 
    // initialize session
    session_start();  
	include('../config.php'); // database connection
	include('../function.php'); // function
    include('../user-area/authorized-user.php'); // function
	$current_file_name =  basename($_SERVER['PHP_SELF']);  // getting current file name 
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Update Pre-alert - Pync Parcel Chateau</title>
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
    <div class="wrapper updateprealert">
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
                <a href="cost-calculator.php">
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
                      <span class="fw-bold"><?php echo user_account_information()['first_name'] ; ?></span> 
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
				<?php 
				
				
				
				 if( isset($_REQUEST['pre_alert_id']) && $_REQUEST['pre_alert_id'] != "" ){ 
				  
				     $Pre_alert_id = $_REQUEST['pre_alert_id'];
					 
     $sql = "SELECT * FROM pre_alert where id = $Pre_alert_id AND User_id = $user_id";

				    if( mysqli_num_rows( mysqli_query($conn, $sql)) == 1  ){

					   $rows =  mysqli_fetch_array(mysqli_query($conn, $sql));

					   // Check if editing is locked after 24 hours
					   if (!isset($rows['created_at']) || empty($rows['created_at'])) {
					       // Old records without created_at are considered old, lock them
					       echo "<h2 style='text-align: center; padding: 50px; font-size: 20px;line-height: 21px;'>This pre-alert cannot be edited as it was created more than 24 hours ago.</h2>";
					       exit;
					   } else {
					       $created_at = strtotime($rows['created_at']);
					       $now = time();
					       if (($now - $created_at) > 86400 || $created_at > $now) { // lock if more than 24 hours old or future date
					           echo "<h2 style='text-align: center; padding: 50px; font-size: 20px;line-height: 21px;'>This pre-alert cannot be edited as it was created more than 24 hours ago.</h2>";
					           exit;
					       }
					   }
					
					?>
				<form class="Pre_alert_updating" action="../codes.php" method="POST" enctype="multipart/form-data">
				   <input type="text" name="Pre_alert_id" value="<?php echo $rows['id']; ?>" hidden />
                  <div class="card-header">
                    <div class="card-title"><h1 class="UpdatePrealt">Update Pre-alert</h1></div>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                          <label for="TrackingNumber">Tracking Number</label>
                          <input value="<?php echo $rows['tracking_number']; ?>"
						    name="tracking_number"
                            type="text"
                            class="form-control"
                            id="TrackingNumber"
                            placeholder="Enter Tracking Number"
                          />
                        </div>
						<div class="form-group">
                          <label for="value">Value of Package (USD)</label>
                          <input value="<?php echo $rows['value_of_package']; ?>"
						    name="value_of_package"
                            type="number"
                            class="form-control"
                            id="value"
                            placeholder="Enter value"
                          />
                        </div>					
                      </div>
                      <div class="col-md-6 col-lg-4">
					   <div class="form-group">
                          <label for="exampleFormControlSelect1">Courier Company</label>
                          <select name="courier_company" class="form-select" id="exampleFormControlSelect1">
                            <option <?php echo $rows['courier_company'] == 'Amazon' ? 'selected' : ''  ; ?> >Amazon</option>
                            <option <?php echo $rows['courier_company'] == 'DHL' ? 'selected' : ''  ; ?> >DHL</option> 
                            <option <?php echo $rows['courier_company'] == 'FedEx' ? 'selected' : ''  ; ?> >FedEx</option>
                            <option <?php echo $rows['courier_company'] == 'UPS'? 'selected' : ''  ; ?>>UPS</option>
                            <option <?php echo $rows['courier_company'] == 'USPS'? 'selected' : '' ; ?>>USPS</option>
                            <option <?php echo $rows['courier_company'] == 'Other'? 'selected' : ''  ; ?> >Other</option>
                          </select>
                        </div>
						 <div class="form-group">
                          <label for="comment">Describe Package Content (eg. Sun-glasses)</label>
                          <textarea name="describe_package" class="form-control" id="comment" rows="3"><?php echo $rows['describe_package']; ?></textarea>
                        </div>
                      </div>
					   <div class="col-md-6 col-lg-4">
                        <div class="form-group">
                          <label for="Store">merchant (source of purchase)</label>
                          <input name="merchant" value="<?php echo $rows['merchant']; ?>"
                            type="text"
                            class="form-control"
                            id="Store"
                            placeholder="Enter Store name"
                          />
                        </div>
					     <div class="form-group change-value">
							  <label for="id">invoice
							  </label>
							  <br />
							  <input  
								hidden  
								name='old_image'  
								value='<?php echo $rows['invoice']; ?>'
								type="text"  
							  />
								
							  <input  
							   name='file'  
							   type="file" 
							   class="form-control-file w-100"  
							   id="id" 
							   style="
							   border: 2px solid #E87946; color:<?php echo $rows['invoice'] == "" ? 'black' : '#fff0'  ; ?>"
							  />
							   <br />
							   <p style='margin-bottom:0px' class="fileAllowed"><b>Allowed formats : </b>PDF, DOC, DOCX, JPEG or PNG (MAX. 10MB)</p>
									<p style='margin-bottom: 0px; margin-top: 5px; color: #bf1919; font-size: 16px;  line-height: 17px;'> 
								</p>
								<div style="margin-bottom: 10px; width: 250px; display: flex;  border: 1px solid #ddd;  padding: 9px;  border-radius: 6px;  color: #201f1f;  font-size: 14px;  position: relative;"> 
								  <?php 
										if(  ltrim($rows['invoice']) != '' ){  
								   ?> 
										<span style=" display: -webkit-box;  -webkit-line-clamp: 1;  -webkit-box-orient: vertical;  overflow: hidden;  width: 180px;">  
										
										  <?php echo $rows['invoice'] ; ?> 
										  
										  </span>
										<a style="width: 18px; position: absolute;  right: 10px;  top: 11px; "
										 class="d-flex" 
										 href="../uploaded-file/<?php echo $rows['invoice'] ; ?>">
										   <img 
											  width='18px;' 
											  src="assets/img/hide.png"  
											  alt="" 
											/>
										</a>
									<?php }else{ 
									  
									   echo "No invoice attached";
									
									 } ?>
								</div>
                           </div> 
                      </div>
					</div>
                  </div>
                  <div class="card-action d-flex">
				    <input  hidden type="text" name="updatePreAltBtn" />
                     <button name="updatePreAltBtn" class="btn updatePreAltBtn"> 
					 <img style='display:none' class='spinner'  width="20px" src="../assets/img/spinner.gif" alt="" />
					   Update 
					 </button>
                  </div>
				  </form>
				<?php  
				
				    }else{ 
					 echo "
					        <h2 style='text-align: center; padding: 50px;  font-size: 20px;line-height: 21px;'>
					         Something went wrong.
					        </h2> 
					      ";
					};
				  }else{ 
				  
				   echo "
					    <h2 style='text-align: center; padding: 50px;  font-size: 20px;line-height: 21px;'>
					      Something went wrong.
					    </h2> 
					 ";
				  }				  
				?> 
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
    <!-- alertify -->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/alertify.min.js" integrity="sha512-JnjG+Wt53GspUQXQhc+c4j8SBERsgJAoHeehagKHlxQN+MtCCmFDghX9/AcbkkNRZptyZU4zC8utK59M5L45Iw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- jQuery Scrollbar -->
    <script src="assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
    <!-- Kaiadmin JS -->
      <script src="assets/js/kaiadmin.min.js"></script>
	  
	  <script type="text/javascript"> 
	  
	    // Submission form will start after 1 second
	    $(document).ready(function() {  
		  $('.Pre_alert_updating').on('submit', function(e) {
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