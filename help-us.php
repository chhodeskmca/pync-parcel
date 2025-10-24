<?php
// Help page using the same layout, header and footer as about-us.php
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="Help and onboarding information for new users" />
  <meta name="author" content="Pync Parcel Chateau" />
  <title>Help — Pync Parcel Chateau</title>
  <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
  <!-- Bootstrap icons-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6.6.0/css/fontawesome.min.css" crossorigin="anonymous">
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
  <style>
    /* Page-specific small tweaks to match site styling */
    .help-hero {
      padding: 36px 0;
      background: #f7f7f7;
    }

    .help-card {
      background: #fff;
      border-radius: 8px;
      padding: 28px;
      box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);
    }

    .help-steps ol {
      padding-left: 1.25rem;
    }

    .help-steps li {
      margin-bottom: 12px;
    }

    @media (max-width: 767px) {
      .help-hero {
        padding: 18px 0;
      }

      .help-card {
        padding: 18px;
      }
    }
  </style>
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
              <a class="nav-link me-lg-3" href="index.php">
                Home
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link me-lg-3" href="rates.php">Rates</a>
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
              if (isset($_COOKIE['user_id'])) {

                $user_Data = json_decode($_COOKIE['user_id']);

                echo  "
																					 <a class='nav-link me-lg-3' href='user-dashboard/index.php'> 
																							<i class='sing-up-icon bi bi-person'></i> 
																							Dashboard 
																						</a>   
																					";
              } else {

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
            if (isset($_COOKIE['user_id'])) { ?>
              <li class="nav-item sign_out_icon">
                <a class="nav-link me-lg-3" href="user-area/log-out.php">
                  <i class="bi bi-box-arrow-right "></i>
                  Log out
                </a>
              </li>
            <?php }; ?>
          </ul>
        </div>
      </div>
    </nav>
  </header>

  <!-- Help content start -->
  <section class="py-3 py-md-5 help-us-sec">
    <div class="container">
				<div class="row gy-3 gy-md-4 gy-lg-0 justify-content-center">
					<div class="col-12">
            <div class="d-none d-md-block text-center">
              <h2>You’ve Signed Up — Now What?</h2>
              <p class="lead fs-4 aboutUs-subtitle mb-3">
                Welcome to the Pync Chateau! 🎉 Now that you’ve joined the family, here’s what happens next.
              </p>

              <div class="help-steps mt-4">
                <h4>1. Get Your Overseas Shipping Address</h4>
                <p>After signing up, you’ll receive your unique overseas shipping address. Use this address when shopping online from your favourite international stores — it’s the key to getting your packages safely to Jamaica.</p>

                <h4 class="mt-3">2. Set Up Your Preferred Delivery Address</h4>
                <p>Right now, we deliver straight to your door — no pick-ups, no detours. To make sure your packages arrive exactly where you want them:</p>
                <ul>
                  <li>Head to <strong>My Account</strong> in your dashboard.</li>
                  <li>Add and save your preferred delivery addresses.</li>
                </ul>
                <p><strong>Security tip:</strong> Always update your address inside your account. Avoid sending personal delivery details through WhatsApp or text — this helps us protect your privacy.</p>

                <h4 class="mt-3">3. Pre-Alerts vs. Live Records</h4>
                <p>When you upload a pre-alert, it helps us know what’s on the way.</p>
                <ul>
                  <li>A pre-alert will always show the weight as “—” since the package hasn’t physically reached us yet.</li>
                  <li>Once your package is received, we create a live record with its actual weight and details.</li>
                </ul>
                <p>This way, you can easily spot what’s “on the way” versus what’s already in our hands.</p>

                <h4 class="mt-3">4. Scheduling Your Delivery</h4>
                <p>We’re working on an exciting update so you can choose your delivery date and time directly from your dashboard. Until then, here’s how to request a delivery slot:</p>
                <ol>
                  <li>Send us a WhatsApp message at <strong>876-430-5351</strong>.</li>
                  <li>We’ll share available delivery days and times.</li>
                  <li>You choose the one that works best, and we’ll confirm.</li>
                </ol>

                <p class="mt-3 mb-0">That’s it! You shop, ship, and we take care of the rest — making sure your parcels arrive seamlessly, securely, and with a little Chateau touch. ✨</p>
              </div>
            </div>
            <div class="d-block d-md-none text-center">
              <h2>Q: I’ve signed up — what happens next?</h2>
              <p>A: Welcome to the Chateau! 🎉Here’s your quick start:</p>
              <ol>
                <li>Shop & ship using your new overseas address (check your inbox for it!).</li>
                <li>Tell us where to home your packages — add your delivery address in “My Account”. <br>Security tip: Keep it safe, update only in your account — never by text or WhatsApp.</li>
                <li>Know your records:<br>Pre-alert = weight shows “ — ” (your package is on the way to us).<br>Live record = weight is listed (we’ve received your package).</li>
                <li>Lock in delivery: Until in-dashboard scheduling is ready, WhatsApp 876-430-5351. We’ll share times, you choose, we deliver.</li>
              </ol>
              <p>You shop, we deliver — always with the signature Chateau care  .✨</p>
            </div>
					</div>
				</div>
    </div>
  </section>
  <!-- Help content end -->

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
            <a href="#"><i class="bi bi-instagram"></i></a>
            <a href="#"><i class="bi bi-facebook"></i></a>
            <a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-twitter-x" viewBox="0 0 16 16">
                <path d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865z" />
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
  <div class="loader-area"> <span class="loader"></span> </div>
  <!-- Bootstrap core JS-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Core theme JS-->
  <script src="js/bootstrap.js"></script>
  <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
  <!--Jquery-->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" crossorigin="anonymous"></script>
  <!-- custom JS-->
  <script src="js/custom.js"></script>
</body>

</html>
