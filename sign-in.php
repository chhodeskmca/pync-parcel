<?php session_start(); ?>
<?php
include('function.php');

$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$base_url = $scheme . '://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']) . '/';

   if( isset($_COOKIE['user_id']) ){
		if( user_account_information()['role_as']  == 1 ){
			header('location: ' . $base_url . 'admin-dashboard/index.php');
		}else{
			header('location: ' . $base_url . 'user-dashboard/index.php');
		}
      };
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Sign In — Pync Parcel Chateau</title>
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
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">Menu<i class="bi-list"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ms-auto me-4 my-3 my-lg-0">
                        <li class="nav-item"><a class="nav-link me-lg-3" href="index.php">Home</a></li>
                         <li class="nav-item"><a class="nav-link me-lg-3" href="rates.php">Rates</a></li>
                         <li class="nav-item" ><a class="nav-link" href="costcalculator.php">Cost Calculator</a></li>
                        <li data-bs-toggle="modal" data-bs-target="#feedbackModal"class="nav-item"> 
                          <i class="sing-up-icon bi bi-person"></i>						
						  <a class="nav-link me-lg-3" href="sign-up.php">Sign up</a> 
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
		<div class=" bg-gradient-primary-to-secondary p-4"> 
		 <h5 class="Register-title font-alt text-white">Sign In</h5>
		 	<?php
		 	
		 	 
			 if( isset($_SESSION['message']) ){ ?>
			 
				 <div style="padding: 5px 16px; background:#357d69; border:#357d69; color:#fff !important" class="d-flex alert alert-warning alert-dismissible fade show justify-content-between" role="alert">
					<span style="margin-top: 9px;"> 
					  <?php  
					     echo $_SESSION['message'];  
					     unset($_SESSION['message']);
					  ?> 
					</span>
				  <i style="font-size: 28px; cursor: pointer;" data-bs-dismiss="alert" aria-label="Close" class="bi bi-x"></i>
				</div>
				
			<?php } ?> 
		</div>
		<div class="border-0 p-4">
	        <form id="myForm" class="row" action="user-area/sign-in.php" method="POST">
				   <!-- Email address input-->
			   <div class="col-md-6 mb-3">
			        <label for="email">Email address</label>
					<input name="emailaddress" required class="form-control" id="email" type="email" placeholder="Email address" />
				</div>
			    <div class="col-md-6 mb-3">
				    <label for="pass">Password </label>
					<div id="signup_pwd">
					 <input autocomplete name='pwd'  class="form-control" id="pass" type="password" placeholder="Password">
					 <img class="pwd-show-hide"  src="assets/img/show-pwd.png" alt="show password" />
					</div>
				</div>
				<!-- Submit Button-->
				<div class="d-grid">
				  <input name="login" hidden type="text" />
				  <button  name="login" class="btn btn-primary rounded-pill btn-lg" type="submit">
				      <img class="spinner" style="display: none;" width="20px" src="assets/img/spinner.gif" alt=""> Sign in
				 </button>
				</div>
				 <div class="signIn-forPass"> 
				   <a href="sign-up.php">Sign up</a>
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
			  	 <!--<li><a href="#">Help</a></li>-->
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
		        <div class="social-icons-area">
    			  <p>Social Links</p>
    			  <div>
    			    <a href="https://www.instagram.com/pyncparcelchateau/"><i class="bi bi-instagram"></i></a>
    			    <!--<a href="help-us.php"><i class="bi bi-linkedin"></i></a>-->
    			    <a href="https://www.facebook.com/profile.php?id=61579506960802"><i class="bi bi-facebook"></i></a>
    				<a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-twitter-x" viewBox="0 0 16 16">
                    <path d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865z"/>
                    </svg></a>
    			    <a href="#"><i class="bi bi-youtube"></i></a>
    			    <a href="https://wa.me/18764305351"><i class="bi bi-whatsapp"></i></a>
    			  </div>
			  </div>
			</div>
		  </div>
           <div class="text-white-50 small">
                    <div>&copy; 2025 Pync Parcel Chateau Limited. All rights reserved.</div>
            </div>
        </footer>  
		 <div class="loader-area"> <span class="loader"></span>	 </div>	
	  <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/bootstrap.js"></script>
        <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script> 
		<!--Jquery-->
		<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
         <!-- custom JS-->
        <script src="js/custom.js"></script> 
		<script type="text/javascript"> 
	    //=============password show and hide===================
	    $('.pwd-show-hide').click(function(){ 
		
		   if( $("#pass[name='pwd']").attr('type') == 'password'){
			   
			  $("#pass[name='pwd']").attr('type', 'text');
			  
		   }else{
			 $("#pass[name='pwd']").attr('type', 'password');
		   } 
		   
	    }); 
		
        // Submission form will start immediately without delay
	    $(document).ready(function() {
		  $('#myForm').on('submit', function(e) {
			$('.spinner').css('display', 'inline');
			// e.preventDefault(); // Removed delay, allow immediate submission
			// let form = this; // Store reference to the form element

			// setTimeout(function() {
			//  form.submit(); // Native submit after delay
			// }, 1000); // 5000ms = 5 seconds
		  });
		});
		</script>
    </body>
</html>