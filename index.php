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
        <title>Pync Parcel Chateau — Shipping Made Seamless</title>
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
			 <!-- alertify css -->
         <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/css/alertify.min.css" integrity="sha512-IXuoq1aFd2wXs4NqGskwX2Vb+I8UJ+tGJEu/Dc0zwLNKeQ7CW3Sr6v0yU3z5OQWe3eScVIkER4J9L7byrgR/fA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
						    <a style="<?php echo  $current_file_name == 'index.php' ? 'border-color: #E87946' : ''; ?>"  class="nav-link me-lg-3" href="index.php"> 
						      Home 
						    </a> 
						 </li>
                         <li class="nav-item"><a class="nav-link me-lg-3" href="rates.php">Rates</a></li>
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
	<!--banner/Hero section start-->
        <section class="masthead banner-section">
		       <div class="container"> 
			       <div>
                        <h1>Get it faster.</h1>
                        <h2 class=" mb-3">Love it sooner.</h2>
						<?php 
						
						   if( !isset($_COOKIE['user_id']) ){ 
						   
						      echo "<a href='sign-up.php'><button type='button' class='shadow'>Ship Now</button></a>";
						   
						    };
						?>
                        
                  </div>
			   </div>
        </section>
	   <!--banner/Hero section end-->
	   <!--About us start--> 
		  <section class="container"> 
				 <div class="about-us"> 
					  <h2>About us</h2>
						 <p> 
						 Pync Parcel Chateau isn’t your average courier. We’re a lifestyle-driven delivery service that brings elegance, 
						 reliability, and a dash of excitement to the parcel experience in Jamaica. At our core, 
						 we're about more than logistics—we’re about people, trust, and creating a new kind of delivery standard. 
						  <a href="about-us.php">Read more</a>
					   </p>
				 </div> 
       </section>
		<!--About end -->
	   <!-- Shipping-detail section start-->
	   <section class="Shipping-details">
                 <div id="SDT">    
                    <div>
                         <h2>The World You Ordered, Delivered With Intention.</h2>
                         <p>
						    At Pync Parcel Chateau, we don’t just move 
							packages — we move possibilities. 
							Our seamless process is designed to make global shopping effortless, 
							reliable, and full of delight. From your cart to your Chateau, 
							we ensure that your world arrives with care, clarity, 
							and a Pync of happiness.
						 </p>
                    </div>  
				</div>	
		</section> 
		 <section class='container Shipping-details-text'> 
		   			<div class='row justify-content-center'> 
					   <h5 class="stepByStep_title">Your Pync Parcel, Step by Step</h5>
					    <div class="col-md-5">  
					        <h3> Step<small>1</small> </h3>
					        <h2>Sign Up for Your Pync Chateau Address</h2>
                             <p>
						        Join the Chateau by creating your free account. 
							    You’ll receive your own personalised overseas 
							    shipping address—your gateway to global shopping.
						    </p>	 
                        </div>
                        <div class="col-md-5 ship-dels-img"> 
					     	 <img loading="lazy" src="assets/img/pync-parcel-step-by-step.png" alt="Pync parcel" />
                        </div>							
					</div>
					<div class='row justify-content-center'> 
                        <div class="col-md-5 ship-dels-img"> 
					     	 <img loading="lazy" src="assets/img/PPC_Shop Step.png" alt="" />
                        </div>
                         <div class="col-md-5"> 
					        <h3>Step<small>2</small></h3>
					        <h2>Shop Online Using Your Pync Chateau Address</h2>
                             <p>
						      Browse and shop from your favourite international stores. 
							  At checkout, simply use your assigned Chateau address 
							  as your shipping destination.
						    </p>	 
                        </div>						
					</div> 
					<div class='row justify-content-center'> 
					    <div class="col-md-5"> 
					        <h3> Step<small>3</small></h3>
					        <h2>Send a Pre-Alert to the Pync Chateau</h2>
                             <p>
						        Let us know what’s on the way. Submit 
							    a quick pre-alert so we can identify your package 
								when it arrives and ensure smooth processing.
						    </p>	 
                        </div>
                        <div class="col-md-5 ship-dels-img"> 
					     	 <img loading="lazy" src="assets/img/ppc_pre-alert.png" alt="pre alert" />
                        </div>							
				    </div>
					<div class='row justify-content-center'> 
                        <div class="col-md-5 ship-dels-img"> 
					     	 <img loading="lazy" src="assets/img/ppc-delivery-step.png" alt="" />
                        </div>
                         <div class="col-md-5"> 
					        <h3> Step<small>4</small></h3>
					        <h2>Receive Luxe Delivery, Right to Your Door</h2>
                             <p>
						        Once your package arrives in Jamaica, 
								we’ll handle customs clearance and deliver 
								it straight to you—securely, swiftly, 
								and with signature Pync Chateau care.
						    </p>	 
                        </div>						
					</div> 
		 </section>
       <!--Shipping-detail end--> 
       <!--FAQ section start--> 
    <section class="FAQ-section">
    <div>    
        <div class="faq-heading">
                <h2> How can we help you?</h2>
                 <p>
				   Still curious? We’re here for that.
                   If you didn’t find everything you needed just yet, 
				   feel free to browse our FAQs below or connect 
				   with our Support Center. We’re always happy 
				   to help — on your time, and with our signature Pync care.
			    </p>
        </div>  
  </div>
<div class="FAQ-section-details">   
  <div class="container">
    <div class="row gy-5 gy-lg-0"> 
	  <div class="col-md-6">
        <div class="row justify-content-xl-end">
          <div class="col-12 col-xl-11">
            <h2 class="h1 mb-3 faq-title">Frequently Asked Questions</h2>
            <div class="accordion accordion-flush" id="accordionExample"> 
			   <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                      How does Pync Parcel Chateau work?
                  </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                  <div class="accordion-body">
                    <p>
                       PPC provides a U.S. mailing address for Jamaican shoppers to 
					   receive their online purchases. Once your items arrive at our U.S. 
					   warehouse, we handle the shipping, customs clearance, and final 
					   delivery or pickup in Jamaica.
                   </p>
                  </div>
                </div>
              </div>
			  
              <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwo">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                     Are there any hidden fees in the shipping process?
                  </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                  <div class="accordion-body">
                    <p>
                       No. PPC is transparent with all charges. Your total cost includes freight, customs duties (if applicable), and a handling fee. 
					   We’ll notify you of the final fee before delivery. 
					   No surprise charges.
                   </p>
                  </div>
                </div>
              </div>
              <div class="accordion-item">
                <h2 class="accordion-header" id="headingThree">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                     What types of items can I ship with PPC?
                  </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                  <div class="accordion-body">
                    <p>
                       You can ship a wide variety of items, including clothing, 
					   electronics, cosmetics, and household goods. However, 
					   to comply with Jamaican customs regulations, 
					   restricted or prohibited items such as weapons, 
					   perishable foods,and flammable materials cannot be accepted. 
					   See full list here <a class="RtdItem" href="restricted-items.html">Restricted Items.</a>
					</p>
                  </div>
                </div>
              </div> 
			   <div class="accordion-item">
                <h2 class="accordion-header" id="headingFour">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                        How will I know when my package arrives at your U.S. warehouse?
                  </button>
                </h2>
                <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                  <div class="accordion-body">
                    <p>
                       As soon as your package reaches our U.S. 
					   address, we’ll notify you by email and, or WhatsApp 
					   with the details and tracking information. To avoid delays, 
					   make sure your name and PPC member ID are clearly included on all shipments.
					</p>
                  </div>
                </div>
              </div>
			  <div class="accordion-item">
                <h2 class="accordion-header" id="headingFive">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                      What if my package arrives without my name or member ID?
                  </button>
                </h2>
                <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#accordionExample">
                  <div class="accordion-body">
                    <p>
                      Packages without clear identification may be held 
					  or delayed until we can confirm ownership. 
					  To keep things smooth, always include your 
					  name and PPC member ID on your shipping label when ordering.

					</p>
                  </div>
                </div>
              </div>
			  <div class="accordion-item">
                <h2 class="accordion-header" id="headingSix">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                     Can someone else collect my package for me?
                  </button>
                </h2>
                <div id="collapseSix" class="accordion-collapse collapse" aria-labelledby="headingSix" data-bs-parent="#accordionExample">
                  <div class="accordion-body">
                    <p>
                       	Yes, authorized individuals can collect packages on your behalf, 
					    but only after you’ve updated your authorized user information. 
						A signed release form is required, and your collector must 
					    present a valid ID to ensure a secure and seamless handoff.
					</p>
                  </div>
                </div>
              </div>
			  <div class="accordion-item">
                <h2 class="accordion-header" id="headingSeven">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                      What payment methods does PPC accept?
                  </button>
                </h2>
                <div id="collapseSeven" class="accordion-collapse collapse" aria-labelledby="headingSeven" data-bs-parent="#accordionExample">
                  <div class="accordion-body">
                    <p>
                       We accept cash, debit and credit cards, as well as select digital payment 
					   platforms like Lynk, and payments via our website. Kindly 
					   ensure all payments are completed before delivery or package handoff.
					</p>
                  </div>
                </div>
              </div>
            </div>
		  </div>
        </div>
      </div>
      <div class="col-md-6 faq-img">
        <img class="faq-img img-fluid rounded" loading="lazy" src="assets/img/faq-Illustration.png" alt="How can we help you?">
      </div>
	 </div>
    </div>
  </div>
<!-- img gellary start-->
	<section> 
		<div class="image-gallery"> 
		  <div>
		    <div class="row">
		     <div class="col-md-4 mb-3 mb-lg-0">
			  <div class="hover hover-2 text-white"><img src="assets/img/CX Care Ref.png" alt="CX Care Ref">
			   <div class="hover-overlay"></div>
			   <div class="hover-2-content px-5 py-4">
			     <div> 
				    <h3 class="hover-2-title font-weight-bold mb-0">
				       Real People. Real Care.
					  <span>Because you're more than just a tracking number</span>
				    </h3> 
				</div>
				<p class="hover-2-description mb-0"> <a class="gellary-link" href="contact-us.php">
				 We’re here to help</a>
				</p>
			  </div>
			</div>
		  </div>
		  <div class="col-md-4 mb-3">
			<div class="hover hover-2 text-white"><img src="assets/img/Delivery on Your Time.jpg" alt="Delivery on Your Time">
			  <div class="hover-overlay"></div>
			  <div class="hover-2-content px-5 py-4">
			    <div>  
				 <h3 class="hover-2-title  font-weight-bold mb-0"> 
				  Delivery on Your Time
				   <span>Because your schedule comes first</span>
				</h3>
				</div>
				<p class="hover-2-description  mb-0"><a class="gellary-link" href="help-us.php">Learn more</a></p>
			  </div>
			</div>
		  </div>
		  <div class="col-md-4">
			<div class="hover hover-2 text-white"><img src="assets/img/I.C.C.jpg" alt="I.C.C">
			<div class="hover hover-2 text-white rounded">
			  <div class="hover-overlay"></div>
			  <div class="hover-2-content px-5 py-4">
			    <div> 
				   <h3 class="hover-2-title  font-weight-bold mb-0"> 
				     Care Without Compromise
					  <span>Built on integrity, protection, and real connection</span>
				   </h3>
				</div>
				<p class="hover-2-description  mb-0"> 
				  <a class="gellary-link" href="sign-up.php">Experience the Difference </a>
				</p>
			  </div>
			</div>
		  </div>
		</div>
	  </div>
		</div>
	</section>
<!-- img gellary end-->
</section>  
      <!-- Footer start-->
        <footer class="text-center footer"> 
		  <div class="row mx-4"> 
		    <div class="col-6 col-md-5">
			  <ul>
			  	 <li><a href="rates.php">Rates</a></li>
			  	 <li><a href="restricted-items.php">Restricted Products</a>
				 </li>
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
	  <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/bootstrap.js"></script>
        <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script> 
		<!--Jquery-->
		<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
			  <!-- alertify -->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/AlertifyJS/1.13.1/alertify.min.js" integrity="sha512-JnjG+Wt53GspUQXQhc+c4j8SBERsgJAoHeehagKHlxQN+MtCCmFDghX9/AcbkkNRZptyZU4zC8utK59M5L45Iw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
         <!-- custom JS-->
        <script src="js/custom.js"></script> 
		<?php 
		
		
		 if( isset($_SESSION['message']) ){ ?> 
		 
		<script type="text/javascript"> 
		
		   // ===== alertify======
           alertify.set('notifier','position', 'top-right');
		  alertify.success("<?php echo $_SESSION['message'] ; ?>");
		</script>  
		
		 <?php  
		    
			unset($_SESSION['message']);
			};
		 ?>
    </body>
</html>