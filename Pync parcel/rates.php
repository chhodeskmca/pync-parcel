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
        <title>Rates Summary — Pync Parcel Chateau</title>
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
						     <a style="<?php echo  $current_file_name == 'rates.php' ? 'border-color: #E87946' : ''; ?>"  class="nav-link me-lg-3" href="rates.php">Rates</a> 
					     </li>
                         <li class="nav-item"> 
						  <a class="nav-link me-lg-3" href="costcalculator.php">Cost Calculator</a> 
						 </li>
						 <li class="nav-item"> 
						  <a class="nav-link me-lg-3" href="contact-us.php"> 
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
	    <!-- rate Summary start--> 
	  <section class="rate-area"> 
	    <div class="container"> 
		  <div class="rate-title"> 
		       <h1>Rates</h1>
		  </div>
		<table class="table table-striped shadow">
		  <thead class="shadow">
			<tr>
			  <th scope="col">Service</th>
			  <th scope="col">Rate</th>
			  <th scope="col">Details</th>
			</tr>
		  </thead>
		  <tbody>
			<tr>
			  <td>Year-round Membership</td>
			  <td>Free</td>
			  <td>Enjoy our basic shipping services at no additional fee.</td>
			</tr>
			<tr>
			  <td>Minimum Rate Per lb (min 0.5 lb)</td>
			  <td>$5.00 per lb</td>
			  <td>This is the base rate applied to shipments weighing at least 0.5 lb.</td>
			</tr>
			 <tr>
			  <td>Packages with Bad Address</td>
			  <td>$8.00 per lb</td>
			  <td>For shipments with challenging delivery addresses, we apply 
			      a slightly higher rate for extra care.
			  </td>
			</tr>
		  </tbody>
		</table>
		</div>
	  </section>
	 <!-- rate Summary end-->
	 <!--Shipping Rate start--> 
	 <section class="rate-area shipping-rate"> 
	    <div class="container"> 
		  <div class="rate-title"> 
		      <h1>Shipping Rates (Based on Weight)</h1>
			   <p> 
                 Experience effortless shipping, 
				 curated by Pync Parcel Chateau. 
				 Below is a breakdown of our international 
				 shipping rates for packages valued under US$100. 
				 These rates include both freight and processing, 
				 offering a smooth and secure delivery experience.
 
			   </p> 
			 <div class='shipping-note'> 
			  <h3>Please note:</h3>
			   <ul>
			   	 <li> 
				      Rates shown are estimates and may adjust without notice 
				      based on carrier changes or market conditions. 
			     </li>
			   	 <li> 
				   Shipments are calculated at a minimum of 0.5 lb.
				 </li>
			   </ul>
			    <p> 
			        At Pync, we believe in striking the perfect balance between premium service and cost-conscious solutions. 
				    Whether it’s your first shipment or your fiftieth, we’re here to make every parcel feel like priority.
			    </p>
			 </div>
		  </div>
		<table class="table table-striped shadow">
		  <thead class="shadow">
			<tr>
			  <th scope="col">Weight</th>
			  <th scope="col">Price (USD)</th>
			</tr>
		  </thead>
		  <tbody>
			<tr>
			  <td>0.5 lb</td>
			  <td>$5.00</td>
			</tr>
			 <tr>
			  <td>1 lb</td>
			  <td>$8.00</td>
			</tr>
			<tr>
			  <td>2 lbs</td>
			  <td>$12.50</td>
			</tr>
			<tr>
			  <td>3 lbs</td>
			  <td>$17.00</td>
			</tr>
			<tr>
			  <td>4 lbs</td>
			  <td>$20.00</td>
			</tr> 
			 <tr>
			  <td>5 lbs</td>
			  <td>$23.00</td>
			</tr> 
			 <tr>
			  <td>6 lbs</td>
			  <td>$26.00</td>
			</tr> 
			 <tr>
			  <td>7 lbs</td>
			  <td>$29.00</td>
			</tr> 
			<tr>
			  <td>8 lbs</td>
			  <td>$32.00</td>
			</tr> 
			<tr>
			  <td>9 lbs</td>
			  <td>$35.00</td>
			</tr> 
			<tr>
			  <td>10 lbs</td>
			  <td>$38.00</td>
			</tr> 
			 <tr>
			  <td>11 lbs</td>
			  <td>$41.50</td>
			</tr> 
			 <tr>
			  <td>12 lbs</td>
			  <td>$45.00</td>
			</tr> 
			 <tr>
			  <td>13 lbs</td>
			  <td>$48.50</td>
			</tr> 
			<tr>
			  <td>14 lbs</td>
			  <td>$52.00</td>
			</tr> 
			<tr>
			  <td>15 lbs</td>
			  <td>$55.00</td>
			</tr> 
			<tr>
			  <td>16 lbs</td>
			  <td>$58.00</td>
			</tr>
			 <tr>
			  <td>17 lbs</td>
			  <td>$61.00</td>
			</tr>
			 <tr>
			  <td>18 lbs</td>
			  <td>$64.50</td>
			</tr>
			<tr>
			  <td>19 lbs</td>
			  <td>$68.00</td>
			</tr>
			 <tr>
			  <td>20 lbs</td>
			  <td>$71.50</td>
			</tr>
		  </tbody>
		</table>
		 </div>
	  </section>
	 <!-- Shipping Rate end--> 
	 	 <!-- additional info start--> 
	 <section class="additionalInfo"> 
	    <div class="container"> 
		  <div class="rate-title"> 
			 <div class='shipping-note'> 
			   <ul>
			   	 <li>
				    <h5> For packages above 20 lbs:</h5>
				      <p> 
					    An additional $3.50 per extra lb will be applied.
					  </p>
			     </li> 
				  <li>
				    <h5>Oversize Handling:</h5>
				      <p> 
					     If the package’s width, height, or the sum of both exceeds 60 inches, 
					     an oversize handling fee of $15.00 per package may apply.
					  </p>
			     </li> 
				 <li>
				    <h5>Dimensional Weight:</h5>
				      <p> 
					     If the dimensional weight exceeds the actual weight, 
						 the dimensional weight may be used for pricing.
					  </p>
			     </li>
			   </ul>
			 </div>
		  </div>
	  </div>
	  </section>
	 <!-- additional info end-->
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
			   <!-- <a href="help-us.php"><i class="bi bi-linkedin"></i></a>-->
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