<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Terms & Conditions — Pync Parcel Chateau</title>
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
	<section class="termsAndCn"> 
	       <div class="container terms-and-condition"> 
		      <h1>Terms and Conditions</h1> 
		       <span class="d-block mb-3  lastupdated">Last Updated: June 6, 2025</span>
			  <p class="mb-3">
			      Welcome to Pync Parcel Chateau. By accessing our website 
				  or using our services, you agree to these Terms and Conditions, 
				  which govern your relationship with Pync Parcel Chateau Limited, 
				  a company registered in Jamaica. Please read them carefully. 
				  If you do not agree, please do not use our services.
			 </p>
			  <h2><small>1.</small> Definitions</h2>
              	<div> 
				   <ul> 
				      <li> 
					     "Company," "we," "our," or "us" refers to Pync Parcel 
						  Chateau Limited, which operates under the trading name Pync
						  Parcel Chateau.
                        </li>
				      <li>
					    "Customer" or "you" refers to any individual or entity using our services.
					  </li>
				      <li>
					     "International Shipping Address" refers 
						 to the address assigned for package forwarding 
						 outside Jamaica.
					  </li> 
					   <li>
					     "Service" includes all logistics, shipping, communication, 
						 and related services provided by us.
					  </li>
				   </ul>
				</div> 
				 <h2><small>2.</small> Account registration & responsibility</h2>
				 <div> 
				   <ul> 
				      <li> 
					      Customers must register to use certain services, 
						  including package tracking, pre-alert submissions, 
						  and access to billing history. Registration also enables 
						  secure communication and personalized account management. 
						  You agree to provide accurate information and keep your 
						  login credentials secure.
                        </li>
				      <li>
					     Pync Parcel Chateau does not knowingly provide services 
						 to minors. We reserve the right to cancel accounts 
						 associated with underage users or suspected fraudulent activity.
					  </li>
					  <li>
					     Customers are responsible for all activities under their account.
					  </li>
				   </ul>
				</div> 
				<h2><small>3.</small> Identification & verification</h2>
				<div> 
				   <ul> 
				      <li> 
					     Identity verification is mandatory. 
						 We may request valid photo ID and other supporting documents.
                       </li>
				      <li>
					    Failure to comply may result in suspension or denial of service.
					  </li>
				   </ul>
				</div> 
				<h2><small>4.</small> Communication consent</h2>
				<h5 style="font-size: 20px !important;">By interacting with us via email, chat, WhatsApp, SMS, or calls, you consent to receive:</h5>
				<div> 
				   <ul> 
				      <li>Service-related updates.</li>
				      <li>Transaction notifications.</li>
				      <li>Promotional content, unless you opt out via your account or email preferences.</li>
				   </ul>
				</div> 
				<h2><small>5.</small> Cookies</h2>
				<p>
				    Our website uses cookies to enhance user experience. 
				    You may disable cookies via your browser settings, 
				    but this may affect website functionality. 
			   </p> 
			    <h2><small>6. </small>International shipping service</h2>
			    <div> 
				   <ul> 
				      <li>
					      Customers using the International Shipping Address must
					      pre-alert each shipment.
                      </li>
				      <li> 
					    Each package is treated as a unique shipment, 
						charged according to our posted rates.
                      </li>
				      <li> 
					     Packages may be inspected by customs authorities, 
						 our logistics partners, or authorized representatives 
						 of Pync Parcel Chateau Limited to ensure compliance 
						 with international shipping regulations. Customers 
						 may be notified if their package is held, opened, 
						 or flagged for further verification, depending 
						 on the circumstances and legal obligations involved.
.                      </li>
				      <li> 
					     We do not transport prohibited items 
						 (e.g., cash, controlled substances, weapons). 
						 Violations will be reported to authorities.
                      </li>
				      <li> 
					    Any undeclared or misdeclared items may be subject 
						to reassessment, delay, or penalty. Customers 
						will bear any resulting cost.
.                     </li>
				      <li> 
					     Unclaimed shipments held over 
						 60 days may be discarded or destroyed at our discretion.
                      </li>
				   </ul>
				</div>
				<h2><small>7. </small>Customs & compliance</h2>
                 <div> 
				   <ul style="margin-bottom:0px;"> 
				      <li>
					     Customers are responsible for complying with all 
					     applicable laws and customs requirements. 
					  </li>
				      <li>Customers must:</li>
				   </ul>
				</div> 
				  <div style="margin-left: 14px;"> 
				   <ul style="margin-bottom:0px;"> 
				      <li>Complete necessary customs forms.</li>
				      <li>Submit accurate product descriptions and values.</li>
				      <li>Pay all applicable duties, taxes, and regulatory fees.</li>
				   </ul>
				</div> 
			    <div> 
				   <ul> 
				      <li>
					    We will process shipments below USD $1,000 without 
						prior consent. For values exceeding this threshold,
					    advance authorization and payment are required. 
					</li>
				   </ul>
				</div> 
				<h2><small>8.</small> Service fees & payments</h2>
				<div> 
				   <ul> 
				      <li>
					   Current pricing is available at <a href="rates.php"> Rates </a>.
					</li>
					  <li>Fees are subject to change without notice.</li>
					 <li>
					   	Pync Parcel Chateau Limited is not liable for bank fees, 
						card interest, or foreign exchange charges imposed 
						by payment processors.
					</li>
				   </ul>
				</div> 
                <h2><small>9. </small>Data protection & privacy</h2>
				<p>We respect your privacy. Our policy includes:</p>
                <div> 
				   <ul> 
				      <li>
					     Collecting only essential information.
					  </li>
					  <li>
					     Using data to improve service delivery.
                       </li>
					  <li>
					     Securely storing data with encryption and access controls.
                      </li>
					  <li>
					     Sharing data only with relevant 
						 partners and under legal obligation.
                       </li>
					  <li>
					      Your use of our website implies consent 
						  to our data practices, including:
                      </li>
					  <li>
					      Email, SMS, and WhatsApp communications.
                       </li>
					  <li> 
					     Cookies and site analytics.
                      </li>
				   </ul>
				</div> 
				<p>Marketing preferences (which you may opt out of).</p>
				<p>
				   Requests for data deletion, correction, or access may be sent to: 
				   pyncaid@pyncparcel.com 
				</p>
				 <h2><small>10. </small>Cancellation & suspension</h2>
				 <div> 
				   <ul> 
				      <li>
					     Pync Parcel Chateau reserves the right to cancel 
						 accounts or refuse service for suspected fraud, 
					     policy violations, or illegal activity.
					</li>
					  <li>
					    Customers may cancel their account at any time. 
						Outstanding balances must be cleared before termination.
					  </li>
					 <li>
					   	Pync Parcel Chateau Limited is not liable for bank fees, 
						card interest, or foreign exchange charges imposed 
						by payment processors.
					</li>
				   </ul>
				</div> 
				 <h2><small>11. </small>License & acceptable use</h2>
				 <div> 
				   <ul> 
				      <li>
					    We grant you a limited, non-transferable, 
					    revocable license to use our platform for personal use.
					</li>
					  <li>
					      Unauthorized use, reverse engineering, data scraping, 
						  or commercial exploitation of our content is prohibited.
					  </li>
				   </ul>
				</div> 
				 <h2><small>12. </small>Intellectual property</h2>
				<div> 
				   <ul> 
				      <li>
					     All content, branding, logos, 
						 and software are the property of Pync Parcel Chateau Limited.
					</li>
					  <li>
					      Unauthorized use, reproduction, or 
						  distribution is strictly prohibited.
					  </li>
				   </ul>
				</div> 
				 <h2><small>13. </small>Limitation of liability</h2>
				 <p>Pync Parcel Chateau Limited shall not be liable for:</p>
				 <div> 
				   <ul> 
				      <li>
					    Delays caused by customs or third-party logistics providers.
					</li>
					  <li>
					    Loss or damage due to customer misdeclaration or improper packaging.
					  </li>
					  <li>
					     Any indirect, incidental, or consequential damages.
					  </li>
				   </ul>
				</div> 
				 <h2><small>14. </small>Disputes & governing law</h2>
				 <div> 
				   <ul> 
				      <li>
					    These Terms are governed by the laws of Jamaica.
					</li>
					  <li>
					    Any disputes shall be resolved first through good-faith 
						negotiations. If unresolved, matters 
						shall be submitted to the appropriate Jamaican court.
					  </li>
				   </ul>
				</div> 
				 <h2><small>15. </small>Updates & revisions</h2>
				 <p>
				   We may revise these Terms periodically. Any updates will be 
				   communicated via email, posted on our website, or displayed within your 
				   account dashboard. Continued use of our services indicates 
				    acceptance of the revised Terms. 
				</p>
				<p> 
				  Contact Us For questions, complaints, or concerns, 
				  please contact us at: pyncaid@pyncparcel.com
				</p>
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
    			    <a href="https://wa.me/18764305351""><i class="bi bi-whatsapp"></i></a>
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