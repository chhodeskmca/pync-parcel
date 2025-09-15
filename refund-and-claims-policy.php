<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Refund & Claims Policy — Pync Parcel Chateauy</title>
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
     <!-- Terms and Condition start--> 
	<section class="RefundClmPlcy-area"> 
	       <div class="container RefundClmPlcy"> 
		      <h1>Refund & Claims Policy</h1> 
			  <p class="mb-3"> Last Updated: May 24, 2025</p>  
			  <p class="mb-3">
			    At  Pync Parcel Chateau, we’re committed to 
			    delivering your packages safely and with care. 
				However, we understand that sometimes 
				things may not go as planned — whether 
				due to supplier packaging issues or 
				damage during international transit. 
				This policy outlines how we handle 
				such cases and what steps you can take. 
			 </p> 
			 <h2>1.	Scope of Our Responsibility</h2>
			  <p class="mb-3"> 
			    Pync Parcel Chateau acts as a 
				forwarding and final-mile delivery 
				service. We inspect packages at 
				our Miami warehouse to ensure 
				they do not contain prohibited 
				items and are suitable for 
				shipping into Jamaica. However:
			  </p>
			   <div> 
				   <ul> 
				      <li> 
					       We do not accept liability for packages that are
						   damaged, contain missing items, or incorrect 
						   items prior to entering our care — including 
						   any issues arising during the 
						   merchant-to-Miami shipping leg
                       </li>
				      <li>
					       Inbound shipping fees, customs duties, 
						   and final-mile delivery charges are non-refundable.
					  </li>
				   </ul>
				</div> 
				 <h2>2. Restricted and Prohibited Items</h2>
				 <p class="mb-3"> 
				   We reserve the right to open, inspect, 
				   and reject shipments that violate laws or freight regulations. 
				   This includes but is not limited to: 
				 </p> 
				 <div> 
				   <ul> 
				      <li>Illegal substances</li>
				      <li>Weapons, ammunition, explosives</li>
				      <li>Counterfeit goods or replicas</li>
				      <li>Undeclared perishables or hazardous materials</li>
				      <li>Items requiring permits without supporting documentation</li>
				   </ul>
				</div> 
				<p class="mb-3">
				  If any such items are discovered, they may be seized, returned, 
				  or destroyed at the customer’s expense. 
				  We are not liable for delays, penalties, 
				  or losses due to non-compliant shipments. 
				</p> 
				<h2>3. Damage Notification & Customer Action</h2>
				<p class="mb-3"> 
				   If our team identifies abnormal external damage upon receipt 
				   at our Miami facility, we will notify you.
				</p> 
				<p> 
				   Abnormal external damage includes:
				</p>
				  <div> 
				   <ul> 
				      <li>Major crushing or punctures</li>
				      <li>Tears, water damage, or severe denting</li>
				      <li>Any impact that reasonably suggests potential harm to contents</li>
				      <li>
					     Minor cosmetic wear, scuffs, or 
					     packaging wrinkles that do not compromise the function or appearance of the item do not qualify.
                       </li>
				   </ul>
				</div> 
				<p class="mb-3"> If damage is reported:</p>
			     <div> 
				   <ul> 
				      <li> 
					     You may arrange for pickup from our Miami 
						 location if applicable. We do not process returns 
						  via third-party shippers.
					 </li>
				      <li>
					      If the item proceeds to Jamaica and you detect damage 
						  on delivery, you must notify us within 24 hours, 
						  including clear photos and your tracking number.
					  </li>
				   </ul>
				</div> 
				<h2>4. Internal vs. External Damage</h2> 
				<p class="mb-3">If an item is damaged inside an intact external box:</p>
			    <div> 
				   <ul> 
				      <li> 
					     This is typically classified as a concealed damage issue.
					 </li>
				      <li>
					     Pync Parcel Chateau does not assume liability for 
						 internal breakage caused by poor merchant packaging 
						 or handling during the pre-Miami shipping leg.
					  </li>
					   <li>
					     Customers are advised to contact their supplier directly for redress.
					  </li>
				   </ul>
				</div> 
				  <h2>5. Ineligible Claims</h2>
				  <p class="mb-3"> 
				    Claims will not be honored if:
				  </p>
				 <div> 
				   <ul> 
				      <li> 
					      The package was not checked immediately upon delivery or pickup.
					 </li>
				      <li>
					     You report damage more than 24 hours after receiving your parcel.
					  </li>
					   <li>
					     You report missing or incorrect items, regardless of 
						 timing — these issues should be resolved directly with your supplier.
					  </li>
					  	<li>
					       You attempt to request a return through our address 
						   — it functions solely as a forwarding and inspection hub.
					  </li>
				   </ul>
				</div> 
				 <h2>6.	When We Accept Responsibility</h2>
				 <p class="md-3">We will accept responsibility and offer compensation if:</p>
				 <div> 
				   <ul> 
				      <li> 
					      A package is mishandled locally by our Jamaica delivery team.
					 </li>
				      <li>
					     Clear evidence shows negligence or damage occurred after the item entered our care.
					  </li>
				   </ul>
				</div> 
				 <p class="mb-3"> 
				   Eligible cases may receive a refund or account credit based 
				   on the declared value of the item, not exceeding USD $150.
				 </p>
				 <p class="mb-3">To qualify, customers must provide:</p>
				 <div> 
				   <ul> 
				      <li> 
					     Evidence of abnormal external damage linked to local handling;
					 </li>
				      <li>
					     Supporting photos and tracking number within the reporting time frame.
					  </li>
				   </ul>
				</div> 
				<h2>7. Insurance Disclaimer</h2>
				 <p class="mb-3">Unless you’ve arranged additional coverage:</p>
				 <div> 
				   <ul> 
				      <li> 
					     Shipments are not insured through Pync Parcel Chateau.
					 </li>
				      <li>
					    Customers are advised to insure high-value items via their supplier or a third-party provider.
					  </li>
				   </ul>
				</div>
				<p class="mb-3"> 
				   By using our service, you accept full responsibility for 
				   the declared value and condition of your shipment 
				   unless you’ve entered into a formal insurance agreement with us.
				</p>
				<h2>8. Liability Limitation</h2>
				 <p class="mb-3">If we are found at fault:</p>
				<div> 
				   <ul> 
				      <li> 
					      Compensation is limited to the declared value or 
						  USD $150 per shipment — whichever is lower.
					 </li>
				      <li>
					      This limit applies unless a written agreement states otherwise.
					  </li>
				   </ul>
				</div>
				<h2>9. Summary of Claims Process</h2>
			  <div class="summaryClmPross">	
				<table> 
				  <tr>
				  	<th>Issue</th>
				  	<th>Action</th>
				  </tr> 
				  <tr>
				  	<td>Damage before entering our care</td>
				  	<td>Contact your supplier directly</td>
				  </tr>	
				  <tr>
				  	<td>Package arrives visibly damaged</td>
				  	<td>Notify us within 24 hrs (with photos) at pyncaid@pyncparcel.com</td>
				  </tr>
				   <tr>
				  	<td>Item damaged inside sealed, undamaged box</td>
				  	<td>Contact your supplier (not covered by PPC)</td>
				  </tr>
				   <tr>
				  	<td>Missing or incorrect items</td>
				  	<td>Contact your supplier (not covered by PPC)</td>
				  </tr>
				  	<tr>
				   	  <td>Damaged during local delivery</td>
				     <td>We’ll investigate and resolve fairly — refund or credit if eligible</td>
				  </tr>
			    	</table> 
			  </div>
				<p class="mb-3">Questions or Concerns?</p>
				<p class="mb-3">
				  We’re here to support you. For any questions 
				  about our Refund & Claims Policy, please contact 
				  us at pyncaid@pyncparcel.com or message us 
				  on WhatsApp during business hours. 
				</p> 
				<small class="mb-3 legalnotice d-none"> 
				   Legal Notice: <br />
                  “Pync Parcel Chateau” and “PPC” are trading names 
				  of Pync Parcel Chateau Limited, a legally registered 
				  company in Jamaica. References to “Pync 
				  Parcel Chateau” and “PPC” throughout this 
				  site, policy, or communication are intended 
				  to represent the operations and services 
				  provided by Pync Parcel Chateau Limited.
				</small>
		   </div>
	</section>
	<!--Terms and Condition end-->
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
	</body>
</html>