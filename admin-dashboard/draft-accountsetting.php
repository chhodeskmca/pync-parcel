<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Profile - Pync Parcel Chateau</title>
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
    <div class="wrapper profile">
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
                <a  href="index.php">
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
                <a  href="makepayment.html">
                  <img class="payment-icon" src="assets/img/payment-protection.png" alt="payment" />
                  <p>Make Payment</p>
                </a>
              </li>
			  <li class="nav-item">
                <a  href="makepayment.html">
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
		<!-- account Setting start--> 
	     <div class="row justify-content-center">
		     <div class="col-md-11"> 
				 <div class="card Account-area">
						<div class="card-body">
							<ul class="nav nav-pills nav-secondary nav-pills-no-bd" id="pills-tab-without-border" role="tablist">
								<li class="nav-item">
									<a  class=" nav-link active pills-home-nobd" id="pills-home-tab-nobd" data-bs-toggle="pill" href="#pills-home-nobd" role="tab" aria-controls="pills-home-nobd" aria-selected="true"><img class="user-icon" src="assets/img/user.png" alt="User">Account Information 
									 <p class="supportText">Manage Your Profile</p>
									</a> 
									<div class="mobile_tab account_Tab_btn"> 
									    <img class="user-icon" src="assets/img/user.png" alt= "User">Account Information 
									    <p class="supportText">Manage Your Profile</p>
									     <img id="right-arrow" class="right-arrow" src="assets/img/right-arrow-angle.png" alt="User">
								    </div>
								</li>
						      <!--
								<li class="nav-item">
									<a class="nav-link" id="pills-profile-tab-nobd" data-bs-toggle="pill" href="#pills-profile-nobd" role="tab" aria-controls="pills-profile-nobd" aria-selected="false"><img class="user-icon" src="assets/img/location.png" alt="location">Delivery address</a>
								</li> 
							   -->
								<li class="nav-item">
									<a class="nav-link" id="pills-contact-tab-nobd" data-bs-toggle="pill" href="#pills-contact-nobd" role="tab" aria-controls="pills-contact-nobd" aria-selected="false"><img class="user-icon" src="assets/img/padlock.png" alt="padlock"> 
									 Password 
									 <p class="supportText">Update Your Password</p>
									</a>
									 <div class="mobile_tab reset_Tab_btn">
									    <img class="user-icon" src="assets/img/padlock.png" alt="padlock"> 
									 Password 
									 <p class="supportText">Update Your Password</p>
									 <img id="right-arrow" class="right-arrow1" src="assets/img/right-arrow-angle.png" alt="User">
									 </div>
								</li>
							    <li class="nav-item">
									<a class="nav-link" id="pills-contact-tab-nobd" data-bs-toggle="pill" href="#pills-AuthorizedUsers-nobd" role="tab" aria-controls="pills-contact-nobd" aria-selected="false"><img class="user-icon" src="assets/img/key.png" alt="padlock"> 
									   Authorized Users 
							           <p class="supportText">Approved Persons to Collect Packages </p>
								    </a>
									<div class="mobile_tab AuthorizedUser_tab_btn">
									   <img class="user-icon" src="assets/img/key.png" alt="padlock"> 
									   Authorized Users 
									  <p class="supportText">Approved Persons to Collect Packages</p>
									  <img id="right-arrow" class="right-arrow2" src="assets/img/right-arrow-angle.png" alt="User">
									 </div>
								</li>
							    <li class="nav-item">
									<a class="nav-link" 
									   id="pills-contact-tab-nobd" 
									   data-bs-toggle="pill" 
									   href="#pills-MiamiAddress-nobd" 
									   role="tab" 
									   aria-controls="pills-contact-nobd" 
									   aria-selected="false">
									    <img class="user-icon" src="assets/img/location.png" alt="padlock"> 
									    Miami Address 
									    <p class="supportText">Your Personalized Miami Address</p>
									  </a>
									  <div class="mobile_tab MiamiAddress_tab_btn">
									    <img  class="user-icon" src="assets/img/location.png" alt="padlock"> 
									       Miami Address 
									       <p class="supportText">Your Personalized Miami Address</p>
									   	  <img id="right-arrow" class="right-arrow3" src="assets/img/right-arrow-angle.png" alt="User">
									  </div>
								</li>
							</ul>
							<div class="mt-2 mb-3 tab-content" id="pills-without-border-tabContent">
							<div class="tab-pane fade account_content" id="pills-home-nobd" role="tabpanel" aria-labelledby="pills-home-tab-nobd">
								     <!-- my account -->
										<form disabled id="account-setting">
										  <div class="card-header">
										  <div class="card-title"> 
										      <h1 class="acntSetHeading">Account Number: <span class="account_number">Pync-12906</span></h1>
										  </div>
										  </div>
										  <div class="card-body">
										  <!-- Account settings start-->
											<div class="row justify-content-center">
											  <div class="col-md-4">
												<div class="form-group change-value">
								                <label for="Firstname">First Name <span class="mandatory_field">*</span></label>
												  <input disabled value="MD" type="text" class="form-control" id="Firstname"
												  />
												</div>	
												<div class="form-group change-value">
												  <label for="LastName">Last Name<span class="mandatory_field">*</span></label>
												  <input disabled value="Hanif"
													type="text"
													class="form-control"
													id="LastName"
												  />
												</div>
												 <div class="form-group change-value">
												  <label for="phone1">Phone<span class="mandatory_field">*</span></label>
												  <input maxlength='12' disabled value="183-475-4758"
													type="tel"
													class="form-control txtPhoneNo"
													id="phone1" 
													placeholder="xxx-xxx-xxxx"
												  />
												</div>
											  </div>
											  <div class="col-md-4 col-lg-4">
											   <div class="form-group change-value ">
												  <label for="Birthday">Date of Birth<span class="mandatory_field">*</span></label>
												  <input  disabled value="00-00-00"
													type="date"
													class="form-control"
													id="phone" />
												  </div> 
												 <div class="form-group">
												  <label for="Email">Email Address</label>
												  <input disabled value="hanip4137@gmail.com" type="email" class="form-control" id="Email"
												  />
												</div>
											  </div>  
											  <div class="col-md-4 col-lg-4">
											  <div class="form-group change-value ">
											  <label>Gender<span class="mandatory_field">*</span></label><br />
											  <div id="gender" class="d-flex ">
												<div class="form-check">
												  <input disabled
													class="form-check-input"
													type="radio"
													name="flexRadioDefault"
													id="flexRadioDefault1"
												  />
												  <label
													class="form-check-label"
													for="flexRadioDefault1"
												  >
													Male
												  </label>
												</div>
												<div class="form-check">
												  <input disabled
													class="form-check-input"
													type="radio"
													name="flexRadioDefault"
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
												</div>
											    <div class="form-group change-value">
												  <label for="id">Copy of Photo Identification</label>
												  <br />
												  <input disabled type="file" class="form-control-file w-100"id="id"/>
												</div> 
												<div class="form-group change-value">
												  <label for="id">Other File</label>
												  <br />
												  <input  disabled type="file" class="form-control-file w-100"id="id"/>
												   <br />
												   <p class="fileAllowed"><b>Allowed formats : </b>PDF, DOC, DOCX, JPEG or PNG</p>
												</div> 
											  </div>
											 </div>
											 <!-- Account settings end-->
											 <!-- Delivery preference start -->
											<div class="row justify-content-center">
											 <div class="card-title"> 
										      <h2 class="acntSetHeading">Delivery Preference</h2>
										     </div>
											   <div class="col-md-4 ">	 	              
											    <div class="form-group">
												  <label for="AddressType">Address Type<span class="mandatory_field">*</span></label>
												  <select  disabled class="form-select AddressType" id="AddressType">
													  <option value="0">Choose...</option>
													  <option value="1">Home</option>
													  <option value="2">Office</option>
													  <option value="3">Other</option>
												    </select>
												  </div> 
											  </div>
											   <div class="col-md-4">
											   <div class="form-group">
												  <label for="State">Parish<span class="mandatory_field">*</span></label>
												  <select disabled class="form-select addressParish" id="State">
													 <option value="0" selected>Choose...</option>
													  <option value="1" >Kingston</option>
													  <option value="2">St. Andrew</option>
													  <option value="3">St. Catherine</option>
												    </select>
												</div>   
											    <div class="form-group">
												  <label for="RegionAddress">Region<span class="mandatory_field">*</span></label>
												  <select name="Region" disabled class="form-select shortenedSelect RegionAddress" id="RegionAddress">
													 <option
													    value="0" 
														>Choose...</option>
													  <option  value="1">Kingston</option> 
												  </select>
												  <select name="Region2" style="display:none" disabled class="RegionAddress2 form-select">
												   <option value="0" selected>Choose...</option>
													  <option  value="2">Half-Way Tree</option>
													  <option   value="3">Constant Spring</option>
													  <option  value="4">Cross Roads</option>
												  </select> 
												    <select name="Region3"style="display:none"  disabled class="RegionAddress3 form-select">
													 <option value="0" selected>Choose...</option>
													  <option  value="5">Portmore</option>
													  <option  style="display:none" value="6">Spanish Town</option>
													  <option  value="7">Old Harbour</option>
													  <option  value="8">Bog Walk</option>
													  <option value="9">Linstead</option>
												    </select>
												  </div> 
											    </div>
											    <div class="col-md-4">
                                                 <div class="form-group change-value">
												  <label for="Firstname">Address line 1<span class="mandatory_field">*</span> </label>
												  <input disabled  type="text" class="form-control" id="Firstname"
												  />
												</div>								       <div class="form-group change-value">
												  <label for="Firstname">Address line 2 </label>
												  <input disabled  type="text" class="form-control" id="Firstname"
												  />
												</div> 
											  </div>  
											    <div class="text-center card-action d-flex justify-content-center accountUpdateBtn">
												   <button  class="btn account_info_btn updatePreAltBtn">Enable Edit</button>
												    <button style="display:none" class="btn account_info_update_btn updatePreAltBtn">Update</button>
												</div> 
											 </div>
											  <!-- Delivery preference end -->
										   </div>
										 </form>
								     </div>
							<div class="tab-pane fade pwd_reset_content" id="pills-contact-nobd" role="tabpanel" aria-labelledby="pills-contact-tab-nobd">
								   <form action="#" id='password-reset'>
										  <div class="card-header">
										   <div class="card-title"><!-- <h1 class="acntSetHeading">Account Setting</h1>--></div>
										  </div>
										  <div class="card-body">
										 <div class="row justify-content-center">
											 <div class="col-md-6 col-lg-4">
												 <div class="form-group pwd-show-hide">
												  <label for="password">New password</label>
												  <input disabled
													type="password"
													class="form-control hide-show-pwd"
													id="password"
													placeholder="New password"
												  />
												  <img src="assets/img/hide.png" alt="hide" />
												</div>
												 <div class="form-group pwd-show-hide">
												  <label for="verifyPassword">Verify password</label>
												  <input disabled
													type="password"
													class="form-control hide-show-pwd"
													id="verifyPassword"
													placeholder="Verify password"
												  />
												   <img src="assets/img/hide.png" alt="hide" />
												</div>
												  <div class="card-action d-flex pwdUpdate">
													  <button class="btn pwd-enble-btn updatePreAltBtn">Enable Edit</button>
													   <button style="display:none" class="btn updatePreAltBtn pwd-update-btn">
													     Update 
													   </button>
												 </div>
											  </div>
										  </div>
										</form>
								    </div>
							  	</div>
							 <div class="tab-pane fade pending_payment AuthorizedUser_content" id="pills-AuthorizedUsers-nobd" role="tabpanel" aria-labelledby="pills-profile-tab-nobd"> 
							   <form action="#" id="delivery-setting">
									  <div class="card-body">
									   <div class="row">
										  <div class="col-md-6">
											<div class="form-group">
											  <label for="firstName">First Name</label>
											  <input disabled type="text" placeholder="Gyahi" class="form-control AuthorizedUser " id="firstName"
											  />
											</div>
										     <div class="form-group">
											  <label for="firstName">Last Name</label>
											  <input disabled type="text" placeholder="John" class="form-control AuthorizedUser" id="firstName"
											  />
											</div> 
										  </div>
										  <div class="col-md-6">
										   <div class="form-group">
											  <label for="firstName">Identification Type</label>
											  <input disabled type="text" placeholder="e.g. Passport" class="form-control AuthorizedUser" id="firstName"
											  />
											</div>
										     <div class="form-group">
											  <label for="firstName">ID Number</label>
											  <input disabled type="text" placeholder="e.g. E12345678" class="form-control AuthorizedUser" id="firstName"
											  />
											</div> 
										  </div>
										    <div class="card-action d-flex justify-content-center ">
											     <button class="btn AurizedUsr-enble-btn updatePreAltBtn">     Enable Edit 
												 </button>
												<button style="display:none" class="btn AurizedUsr-update-btn updatePreAltBtn">
													     Update 
												</button>
											</div>
									  </div>
				                  </form>
                                 </div>
							 </div>
							 <div class="tab-pane fade pending_payment MiamiAddress_content" id="pills-MiamiAddress-nobd" role="tabpanel" aria-labelledby="pills-profile-tab-nobd"> 
                                 <p class="text-center">Miami Address</p>
							 </div>
							 </div>
						  </div>
					</div>
			     </div>
		   </div>
		<!-- account Setting end--> 
		</div> 
		<script src="https://cdn.jsdelivr.net/gh/bbbootstrap/libraries@main/imgur.js"></script>
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
	   <!-- user account mobile tabs js -->
       <script src="assets/js/account-mobilet-tab.js"></script> 
	  <script>
	   $('form').submit(false);
	   
        //=============password show and hide===================
	  
	    $('.pwd-show-hide:first-child img').click(function(){ 
		
		   if( $('.pwd-show-hide:first-child input').attr('type') == 'password'){ 
			  $('.pwd-show-hide:first-child input').attr('type', 'text');
		   }else{
			 $('.pwd-show-hide:first-child input').attr('type', 'password');
		   } 
		   
	    }); 
		
	   	$('.pwd-show-hide:nth-child(2) img').click(function(){ 
		
		   if( $('.pwd-show-hide:nth-child(2) input').attr('type') == 'password'){ 
			  $('.pwd-show-hide:nth-child(2) input').attr('type', 'text');
		   }else{
			 $('.pwd-show-hide:nth-child(2) input').attr('type', 'password');
		   } 
		   
	    }); 
	   
	    //=========html input number value and adding dash with number start=========
	   
	    document.getElementById('phone1').addEventListener('keypress', function(event) {
		
            if (!/[0-9]/.test(event.key)) {
                  event.preventDefault();
                  };
            });
			
           $('.txtPhoneNo').on('keydown', function(event) {
			
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
	    // Shorten select option text if it stretches beyond max-width of select element
		document.querySelectorAll('.shortenedSelect option').forEach((optionElement) => {
			const curText = optionElement.textContent;
			optionElement.setAttribute('title', curText);

			// trim multiplier - increase it if the text overflows the input
			const trimMultiplier = 10;

			const computedStyle = getComputedStyle(optionElement.parentElement);
			const lengthToShortenTo = Math.round(parseInt(computedStyle.maxWidth, 10) / trimMultiplier);

			// trim if the current text length is more than necessary
			if (curText.length > lengthToShortenTo) {
				optionElement.textContent = `${curText.substring(0, lengthToShortenTo)}...`;
			}
		});
 </script>
	    <!-- custom js -->
        <script src="assets/js/custom.js"></script> 
  </body>
</html>
