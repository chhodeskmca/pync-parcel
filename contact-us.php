<?php 
 	 $current_file_name =  basename($_SERVER['PHP_SELF']);  // getting current file name  

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Contact Us — Pync Parcel Chateau</title>
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
                        <li class="nav-item"> 
						    <a  class="nav-link me-lg-3" href="index.php"> 
						      Home 
						    </a> 
						 </li>
                         <li class="nav-item"> 
						     <a  class="nav-link me-lg-3" href="rates.php">Rates</a> 
					     </li>
                         <li class="nav-item"> 
						  <a  class="nav-link me-lg-3" href="costcalculator.php">Cost Calculator</a> 
						 </li>
						 <li class="nav-item"> 
						  <a style="<?php echo  $current_file_name == 'contact-us.php' ? 'border-color: #E87946' : ''; ?>"class="nav-link me-lg-3" href="contact-us.php"> 
						   <i class="bi bi-telephone-inbound con-icon"></i>
						    Contact us 
						  </a> 
						</li>
                        <li class="nav-item"> 			
						 
						  	<?php  
								 if( isset($_COOKIE['user_id']) ){ 
								 
								    $user_Data = json_decode( $_COOKIE['user_id']) ; 
					              
									echo  "
									       <a class='nav-link me-lg-3' href='user-dashboard/index.php'> 
										      <i class='sing-up-icon bi bi-person'></i>	
										      Dashboard 
										    </a>   
										  ";
									}else{ 
									
									  echo " 
									       <a class='nav-link me-lg-3' href='sign-in.php'> 
										    <i class='sing-up-icon bi bi-person'></i>
										     Sign up/Sign in 
										    </a>   
										  ";
									};  
									
				            ?>
						</li>
						 <?php 
						  if( isset($_COOKIE['user_id']) ){?> 
						 <li class="nav-item sign_out_icon"> 
							  <a class="nav-link me-lg-3" href="user-area/log-out.php"> 
							   <i class="bi bi-box-arrow-right "></i>
							   Log out 
							  </a>  
						</li> 
						<?php } ; ?>
                    </ul>
                </div>
            </div>
        </nav>
	</header>
	 <!--contact us start-->
		<section class="py-3 py-md-5 contact-us">
		  <div class="container">
			<div class="row gy-3 gy-md-4 gy-lg-0">
			  <div class="col-12 col-lg-6 img">
				<img class="img-fluid rounded" loading="lazy" src="assets/img/contact-page.png" alt="Let’s Connect">
			  </div>
			  <div class="col-12 col-lg-6">
				<div class="row justify-content-xl-center">
				  <div class="col-12 col-xl-11">
					<h2 class="h1 mb-3 contactUsTle">Let’s Connect</h2>
					<p class="contactUs-subTle lead text-secondary">
					  Have a question or need support? We’re just a message away.
                      Reach out using any of the options below — we’ll take it from there.
					 </p>
					<div class="d-flex mb-4">
					  <div class="me-4 whatsapp">
					  	 <i class="bi bi-whatsapp"></i>
						
					  </div>
					  <div>
						<h4 class="mb-3">Whatsapp</h4>
						<p class="mb-0">
						  <a class="link-secondary text-decoration-none" href="https://wa.me/18764305351">(876) 430-5351</a>
						</p>
					  </div>
					</div>
					 <div class="d-flex mb-4">
					  <div class="me-4">
					     <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-telephone-outbound" viewBox="0 0 16 16">
						  <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511zM11 .5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-1 0V1.707l-4.146 4.147a.5.5 0 0 1-.708-.708L14.293 1H11.5a.5.5 0 0 1-.5-.5z" />
						</svg>
					  </div>
					  <div>
						<h4 class="mb-3">Phone</h4>
						<p class="mb-0">
						  <a class="link-secondary text-decoration-none" href="tel:8764747309">(876) 474-7309</a>
						</p>
					  </div>
					</div>
					<div class="d-flex">
					  <div class="me-4">
						<svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="currentColor" class="bi bi-envelope-at" viewBox="0 0 16 16">
						  <path d="M2 2a2 2 0 0 0-2 2v8.01A2 2 0 0 0 2 14h5.5a.5.5 0 0 0 0-1H2a1 1 0 0 1-.966-.741l5.64-3.471L8 9.583l7-4.2V8.5a.5.5 0 0 0 1 0V4a2 2 0 0 0-2-2H2Zm3.708 6.208L1 11.105V5.383l4.708 2.825ZM1 4.217V4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v.217l-7 4.2-7-4.2Z" />
						  <path d="M14.247 14.269c1.01 0 1.587-.857 1.587-2.025v-.21C15.834 10.43 14.64 9 12.52 9h-.035C10.42 9 9 10.36 9 12.432v.214C9 14.82 10.438 16 12.358 16h.044c.594 0 1.018-.074 1.237-.175v-.73c-.245.11-.673.18-1.18.18h-.044c-1.334 0-2.571-.788-2.571-2.655v-.157c0-1.657 1.058-2.724 2.64-2.724h.04c1.535 0 2.484 1.05 2.484 2.326v.118c0 .975-.324 1.39-.639 1.39-.232 0-.41-.148-.41-.42v-2.19h-.906v.569h-.03c-.084-.298-.368-.63-.954-.63-.778 0-1.259.555-1.259 1.4v.528c0 .892.49 1.434 1.26 1.434.471 0 .896-.227 1.014-.643h.043c.118.42.617.648 1.12.648Zm-2.453-1.588v-.227c0-.546.227-.791.573-.791.297 0 .572.192.572.708v.367c0 .573-.253.744-.564.744-.354 0-.581-.215-.581-.8Z" />
						</svg>
					  </div>
					  <div>
						<h4 class="mb-3">E-Mail</h4>
						<p>
						  <a class="link-secondary text-decoration-none" href="mailto:pyncaid@pyncparcel.com">pyncaid@pyncparcel.com</a>
						</p>
					  </div>
					</div>
				  </div>
				</div>
			  </div>
			</div>
		  </div>
		</section>
	<!--contact us end-->
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
		        <div class='social-icons-area'>
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
	</body>
</html>