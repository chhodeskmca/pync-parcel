<?php 
     session_start();
 	 $current_file_name =  basename($_SERVER['PHP_SELF']);  // getting current file name  

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Create Your Account — Pync Parcel Chateau</title>
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.6.0/css/fontawesome.min.css" integrity="sha384-NvKbDTEnL+A8F/AA5Tc5kmMLSJHUO868P+lDtTpJIeQdGYaUIuLr4lVGOEA1OcMy" crossorigin="anonymous">
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Google fonts-->
        <link rel="preconnect" href="https://fonts.gstatic.com" />
        <link href="https://fonts.googleapis.com/css2?family=Newsreader:ital,wght@0,600;1,600&amp;display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,300;0,500;0,600;0,700;1,300;1,500;1,600;1,700&amp;display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,400;1,400&amp;display=swap" rel="stylesheet" />
		<!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
		  <!--Google recaptcha-->
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
		   <!--custom css-->
        <link href="css/custom.css" rel="stylesheet" />
    </head>
    <body id="page-top">
	 <!-- Navigation-->
	 <header class="home-header fixed-top">
        <nav class="navbar navbar-expand-lg shadow-sm" id="mainNav">
            <div class="container">
                <a class="navbar-brand fw-bold" href="index.php">
				  <img class="logo" src="assets/img/logo.png" alt="" />
				</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"> Menu<i class="bi-list"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ms-auto me-4 my-3 my-lg-0">
                        <li class="nav-item"><a class="nav-link me-lg-3" href="index.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link me-lg-3" href="rates.php">Rates</a></li>
                         <li class="nav-item" ><a class="nav-link me-lg-3" href="costcalculator.php">Cost Calculator</a></li>
                         <li data-bs-toggle="modal" data-bs-target="#feedbackModal"class="nav-item"> 
                          <i class="sing-up-icon bi bi-person"></i>						
						  <a class="nav-link me-lg-3" href="sign-in.php">Sign in</a> 
						</li>
                        <li class="nav-item"> 
						  <i class="bi bi-telephone-inbound con-icon"></i>
						  <a class="nav-link me-lg-3" href="contact-us.php">Contact us</a> 
						</li>
                    </ul>
                </div>
            </div>
        </nav>
	</header>
 <!--Sign up form start-->	
<section class="overflow-hidden signUp-form">
  <div class="confm-area">
		<div class="bg-gradient-primary-to-secondary p-4"> 
			<h5 class="Register-title font-alt text-white">Register</h5>
			<?php
			 if( isset($_SESSION['message']) ){ ?>
			 
				 <div style="color:#d91313 !important" class="alert alert-warning alert-dismissible fade show" role="alert">
					<?php  
					   echo $_SESSION['message'];  
					   unset($_SESSION['message']);
					?>
				  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
				
			<?php } ?> 
		</div>
		 <div class="border-0 p-4">
			<form id="myForm" class="row" action="user-area/process-signup.php" method='POST'>
				   <!-- Email address input-->
				<div class="col-md-6 mb-3">
				    <label for="firstName">First name<small class="star">*</small></label>
					<input autocomplete value="<?php echo isset($_REQUEST['FName']) ? $_REQUEST['FName']: '';  ?>"   name="fname" class="form-control" id="firstName" type="text" placeholder="First name"/>
				</div>
				<div class="col-md-6 mb-3">
				    <label for="lname">Last name <small class="star">*</small></label>
					<input value="<?php echo isset($_REQUEST['LName']) ? $_REQUEST['LName']: '';  ?>" autocomplete name="lname" class="form-control" id="lname" type="text" placeholder="Last name" />
				</div> 
				 <div class="col-md-6  mb-3">
				    <label id="phone" for="txtPhoneNo">Phone number <small class="star">*</small></label>
					<input value="<?php echo isset($_REQUEST['Number']) ? $_REQUEST['Number']: '';  ?>"  id="txtPhoneNo"  name="phone"  class="form-control" maxlength="12"  type="tel" placeholder="xxx-xxx-xxxx" />
				</div>
				 <div class="col-md-6 mb-3">
				    <label for="email">Email address<small class="star">*</small></label>
					<input value="<?php echo isset($_REQUEST['Emailaddress']) ? $_REQUEST['Emailaddress']: '';  ?>" autocomplete name="emailaddress" class="form-control" id="email" type="email" placeholder="Email address" />
				</div>
				<div class="col-md-6 mb-3">
				    <label for="pass">Password<small class="star">*</small></label>
					<div id="signup_pwd"> 
					 <input autocomplete name='pwd'  class="form-control" id="pass" type="password" placeholder="Password">
					 <img class="pwd-show-hide"  src="assets/img/show-pwd.png" alt="show password" />
					</div>
	
				</div>
				<div class="col-md-6 mb-3">
				    <label autocomplete for="verifypwd">Verify password<small class="star">*</small></label>
					<div id="signup_pwd"> 
					   <input name="verifypwd" class="form-control" id="verifypwd" type="password" placeholder="Verify password" />
					   <img id="show-hide-verifyPwd" src="assets/img/show-pwd.png" alt="show password" /> 
					</div>
				</div>
				<div class="checkbox-wrapper-33">
					<label class="checkbox">
					<input name="i_accepted" class="checkbox__trigger visuallyhidden" type="checkbox" />
					<span class="checkbox__symbol">
					  <svg aria-hidden="true" class="icon-checkbox" width="28px" height="28px" viewBox="0 0 28 28" version="1" xmlns="http://www.w3.org/2000/svg">
						<path d="M4 14l8 7L24 7"></path>
					  </svg>
					</span>
					</label>
					<p>I accept the <a href="terms-and-conditions.php">terms and conditions</a> of Pync Parcel Chateau</p>
				</div>
				<!-- recaptcha-->
				<div class="Google-recaptcha"> 
				   <div class="g-recaptcha" data-sitekey="6LdJX2orAAAAADNLtaBt1_hthT7n2xq1xcVwSR9q"></div>
				</div>
				<!-- Submit Button-->
				<div class="d-grid">
				 <input hidden type="text" name="signup" />
				  <button  class="btn btn-primary rounded-pill btn-lg" type="submit">
				     <img class="spinner" style="display: none;" width="20px" src="assets/img/spinner.gif" alt="">
					 Sign up 
				 </button> 
			    </div>
				<div class="signIn-forPass"> 
				   <a href="sign-in.php">Log in</a>
				   <a href="forgotpwd.php">Forgot password?</a>
				</div>
			</form>
			</div>
	   </div>
  </div>
</section>
	<!--Sign up form end-->
      <!-- Footer-->
	   <footer class="text-center footer"> 
		  <div class="row mx-4"> 
		    <div class="col-6 col-md-5">
			  <ul>
			  	 <li><a href="rates.php">Rates</a></li>
			  	 <li><a href="restricted-items.php">Restricted Products</a></li>
			  	 <li><a href="help-us.php">Help</a></li>
			  	 <li><a href="refund-and-claims-policy.php">Refund and Claims Policy</a></li>
			  </ul>
			</div>
		    <div class="col-6 col-md-4"> 
			   <ul>
			  	 <li><a href="costcalculator.php">Cost Calculator</a></li>
			  	 <li><a href="about-us.php">About Us</a></li>
			  	 <li><a href="terms-and-conditions.php">Terms and Conditions</a></li>
			  </ul>
			</div>
		    <div class="col-md-3 social-icons">
			  <p>Social Links</p>
			  <div>
			  
			    <a href="https://www.instagram.com/pyncparcelchateau/"><i class="bi bi-instagram"></i></a>
			    <!--<a href="help-us.php"><i class="bi bi-linkedin"></i></a>-->
			    <a href="https://www.facebook.com/profile.php?id=61579506960802"><i class="bi bi-facebook"></i></a>
				<a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-twitter-x" viewBox="0 0 16 16">
                <path d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865z"/>
                </svg></a>
			    <a href="#"><i class="bi bi-youtube"></i></a>
			    <a href="#"><i class="bi bi-whatsapp"></i></a>
				
			  </div>
			</div>
		  </div>
           <div class="text-white-50 small">
                    <div>&copy; 2025 Pync Parcel Chateau Limited. All rights reserved.</div>
            </div>
        </footer>  
		 <div class="loader-area"> <span class="loader"></span>	 </div>	
		<script src="https://www.google.com/recaptcha/api.js" async defer></script>
	   <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/bootstrap.js"></script>
        <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script> 
		<!--Jquery-->
		<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
	   <script type="text/javascript">  
	   
	    //=============password show and hide===================
	    $('.pwd-show-hide').click(function(){ 
		
		   if( $("#pass[name='pwd']").attr('type') == 'password'){
			   
			  $("#pass[name='pwd']").attr('type', 'text');
			  
		   }else{
			 $("#pass[name='pwd']").attr('type', 'password');
		   } 
		   
	    }); 
	   	$('#show-hide-verifyPwd').click(function(){ 
		
		   if( $('#verifypwd').attr('type') == 'password'){ 
			  $('#verifypwd').attr('type', 'text');
		   }else{
			 $('#verifypwd').attr('type', 'password');
		   } 
		   
	    }); 
            // html input number value and adding dash with number start
	            document.getElementById('txtPhoneNo').addEventListener('keypress', function(event) {
           if (!/[0-9]/.test(event.key)) {
                  event.preventDefault();
                  };
            });
	            $(document).ready(function () {
                $("#txtPhoneNo").keyup(function (e) { 
				   $keyNumber = parseInt(e.keyCode) ;
				    if(   $keyNumber != 8 && $keyNumber != 46  ){ 
		
                    if ($(this).val().length == 3) {
					
                        $(this).val($(this).val() + "-");
                    }
                    else if ($(this).val().length == 7) {
                        $(this).val($(this).val() + "-");
                    } 
				   
				   };
                });
            });    
			// html input number value and adding dash with number end 
	   // Submission forn will start after 1 second 
	   
	    $(document).ready(function() {
		  $('#myForm').on('submit', function(e) {
			$('.spinner').css('display', 'inline');
			e.preventDefault(); // Stop form from submitting immediately
			let form = this; // Store reference to the form element

			setTimeout(function() {
			  form.submit(); // Native submit after delay
			}, 1000); // 5000ms = 5 seconds
		  });
		}); 
		
		</script>
        <script src="js/custom.js"></script> 
    </body>
</html>