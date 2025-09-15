<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Restricted Items  — Pync Parcel Chateau</title>
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
	  <!-- Restricted Product start-->  
	    <section class="restricted-items"> 
		    <div class="container">
                 <h1>Restricted items:</h1>	
			     <p> 
				    Kindly refrain from shipping the items below to your Miami address, 
					as they cannot be transported to Jamaica. If sent, you will 
					be responsible for covering the costs associated with their 
					disposal or return to the sender.
				 </p> 
				 <p style="margin-top:15px;"> 
				    Restricted items include any products where alcohol is 
					the primary ingredient, as well as any quantity of flammable, 
					explosive, or corrosive materials.
				 </p>
				 <div class="RestrictedImslist"> 
				      <p>These items include, but are not limited to:</p>
					  <div class="itemsList row shadow"> 
					      <div class="col-md-6"> 
						     <p><span><img src="assets/img/close.png" alt="close" /></span>Ammunition, firearms and firearm parts</p>
						     <p><span><img src="assets/img/close.png" alt="close" /></span>Lighters</p>
						     <p><span><img src="assets/img/close.png" alt="close" /></span>Fruits</p>
						     <p><span><img src="assets/img/close.png" alt="close" /></span>Gas, poisons</p>
						     <p><span><img src="assets/img/close.png" alt="close" /></span>Tear gas or pepper spray</p>
						     <p><span><img src="assets/img/close.png" alt="close" /></span>Camouflage clothing & material</p>
						     <p><span><img src="assets/img/close.png" alt="close" /></span>Crossbows</p>
						     <p><span><img src="assets/img/close.png" alt="close" /></span>Spears</p>
						     <p><span><img src="assets/img/close.png" alt="close" /></span>Radar detectors</p>
						     <p><span><img src="assets/img/close.png" alt="close" /></span>Toy guns</p>
						     <p><span><img src="assets/img/close.png" alt="close" /></span>Riot gears</p>
						     <p><span><img src="assets/img/close.png" alt="close" /></span>Animals</p>
						  </div>
					      <div class="col-md-6"> 
						     <p><span><img src="assets/img/close.png" alt="close" /></span>Any item with alcohol listed as its first ingredient</p>
						     <p><span><img src="assets/img/close.png" alt="close" /></span>Matches</p>
						     <p><span><img src="assets/img/close.png" alt="close" /></span>Fireworks</p>
						     <p><span><img src="assets/img/close.png" alt="close" /></span>Pressure containers</p>
						     <p><span><img src="assets/img/close.png" alt="close" /></span>Gas - powered tools</p>
						     <p><span><img src="assets/img/close.png" alt="close" /></span>Wet-cell batteries</p>
						     <p><span><img src="assets/img/close.png" alt="close" /></span>Bullet proof vests</p>
						     <p><span><img src="assets/img/close.png" alt="close" /></span>Motorcycles over 700cc</p>
						     <p><span><img src="assets/img/close.png" alt="close" /></span>Handcuffs</p>
						     <p><span><img src="assets/img/close.png" alt="close" /></span>Swords</p>
						     <p><span><img src="assets/img/close.png" alt="close" /></span>Metal detectors</p>
						  </div>
					  </div>
				 </div>
			</div>
		</section>
	  <!-- Restricted Product end-->
	  <!-- Locally Restricted Items start--> 
 <section  class="LocallyRestrictedItems"> 
	           <div class="container"> 
			    <div class="LylRtdIms"> 
				    <h2>Locally Restricted Items</h2>
					<p>
					  Certain items are subject to local regulations or may require special 
					  permits for entry into the country. For further details, 
					  please reach out to our customer service team. 
					</p>
					<p> 
					   Note: Permit requirements may vary based on local regulations. 
					   Please contact customer service for further details.
					</p> 
	           <div class="LylImsLt">
	                <p class="LylImsLt-title">These items include, but are not limited to:</p>
					<div class="restricte-item-table"> 
					<table class="table table-striped shadow">
						  <thead class="shadow">
							<tr>
							  <th scope="col">Item Category A</th>
							  <th scope="col">Permit Required</th>
							  <th scope="col">Item Category B</th>
							  <th scope="col">Permit Required</th>
							</tr>
						  </thead>
						  <tbody>
							<tr>
							  <td>Fur and animal products</td>
							  <td>Yes</td>
							  <td>Explosives</td>
							  <td>Yes</td>
							</tr> 
							<tr>
							  <td>Plant seeds</td>
							  <td>Yes</td>
							  <td>Plants</td>
							  <td>Yes</td>
							</tr> 
							<tr>
							  <td>Items of extremely high value</td>
							  <td>Yes</td>
							  <td>Firearms and ammunition</td>
							  <td>Yes</td>
							</tr> 
							<tr>
							  <td>Illegal drugs</td>
							  <td>Yes</td>
							  <td>Tobacco</td>
							  <td>Yes</td>
							</tr>
							<tr>
							  <td>Toxic substances</td>
							  <td>Yes</td>
							  <td>Lasers of any kind</td>
							  <td>Yes</td>
							</tr> 
							<tr>
							  <td>Wood</td>
							  <td>Yes</td>
							  <td>Perishable items</td>
							  <td>Yes</td>
							</tr> 
							<tr>
							  <td>Gun cleaning kits</td>
							  <td>Yes</td>
							  <td>Armored trucks</td>
							  <td>Yes</td>
							</tr> 
							<tr>
							  <td>Gun holsters</td>
							  <td>Yes</td>
							  <td>Bows & arrows</td>
							  <td>Yes</td>
							</tr>
							<tr>
							  <td>Credit card scanners</td>
							  <td>Yes</td>
							  <td>Gun powder and cartridges</td>
							  <td>Yes</td>
							</tr> 
							<tr>
							  <td>Laser lights</td>
							  <td>Yes</td>
							  <td>Dynamite & nitroglycerine</td>
							  <td>Yes</td>
							</tr> 
							<tr>
							  <td>Firecrackers & flares</td>
							  <td>Yes</td>
							  <td>Processed or unprocessed meats</td>
							  <td>Yes</td>
							</tr> 
							<tr>
							  <td>Red peas/red kidney beans</td>
							  <td>Yes</td>
							  <td>Ground provisions</td>
							  <td>Yes</td>
							</tr>
							<tr>
							  <td>Pharmaceuticals</td>
							  <td>Yes</td>
							  <td>Sugar</td>
							  <td>Yes</td>
							</tr> 
							<tr>
							  <td>Coconut derivatives</td>
							  <td>Yes</td>
							  <td>Oil-producing seeds</td>
							  <td>Yes</td>
							</tr> 
							<tr>
							  <td>Edible oils</td>
							  <td>Yes</td>
							  <td>Soaps</td>
							  <td>Yes</td>
							</tr> 
							<tr>
							  <td>Motor vehicles</td>
							  <td>Yes</td>
							  <td>Alcohol in bulk</td>
							  <td>Yes</td>
							</tr>
							<tr>
							  <td>Pesticides</td>
							  <td>Yes</td>
							  <td>Milk powder and milk-based products</td>
							  <td>Yes</td>
							</tr> 
							<tr>
							  <td>Radios (Two-way)</td>
							  <td>Yes</td>
							  <td>Herbal teas</td>
							  <td>Yes</td>
							</tr> 
							<tr>
							  <td>Chemicals</td>
							  <td>Yes</td>
							  <td></td>
							  <td></td>
							</tr>
							</tr>
						  </tbody>
						</table>
					</div>
						<h4>The Recipient's Responsibility  in the importation process:</h4>
						<p> 
						  The recipient is responsible for understanding the 
						  necessary requirements and procedures for clearing their 
						  purchases through customs, as well as ensuring that all 
						  required documentation is in order. For assistance, 
						  our Pync Parcel customer service team is available to 
						  provide guidance. Please note that Pync Parcel Chateau 
						  is not liable for any customs processes, permits, 
						  documentation, or additional costs incurred 
						  during this process.
						</p>
					</div>
				</div>
			 </div>
	   </section>
	  <!-- Locally Restricted Items end-->
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