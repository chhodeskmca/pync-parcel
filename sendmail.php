<?php
session_start();

require_once __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

include 'config.php';

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

require_once __DIR__ . '/routes/web.php';
$routes   = include __DIR__ . '/routes/web.php';
$base_url = $routes['base_url'];

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);
//Server settings
//$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
$mail->isSMTP();                                                                                                       //Send using SMTP
$mail->Host       = MAIL_HOST;                                                                                //Set the SMTP server to send through
$mail->SMTPAuth   = true;                                                                                              //Enable SMTP authentication
$mail->Username   = MAIL_USERNAME;                                                                            //SMTP username
$mail->Password   = MAIL_PASSWORD;                                                                            //SMTP password
$mail->SMTPSecure = MAIL_ENCRYPTION === 'tls' ? PHPMailer::ENCRYPTION_STARTTLS : PHPMailer::ENCRYPTION_SMTPS; //Enable implicit TLS encryption
$mail->Port       = MAIL_PORT;                                                                                //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

if (isset($_REQUEST['PasswordResetEmail'])) // for password reset
{
  // forgot Password a email
  try {

    $email      = $_REQUEST['PasswordResetEmail'];
    $token_hash = $_REQUEST['token_hash'];

    //Recipients
    $mail->setFrom(MAIL_USERNAME, APP_NAME);
    $mail->addAddress("$email", 'recipient email address.');

    //Content
    $mail->isHTML(true); //Set email format to HTML
    $mail->Subject = 'Password Reset Request for Your Account';
    $mail->Body    = "
								<div style='border:1px solid #ddd; margin: auto; padding: 11px;'>
									  <h4>Pyncparcel</h4>
									  <img style='max-width:500px; display:block; margin: auto; ' src='" . $base_url . "assets/img/logo.png'>
									  <div style='padding: 20px 16px; width: 205px; margin: auto'>
										  <p style='color: #786d6d; font-weight: 300;'><b>Reset your password</b></p>
										  <a href='" . $base_url . "user-area/new-password.php?token_hash=$token_hash'
												style='padding: 10px; background: #E87946; color: #fff; text-decoration: none;
												border-radius: 3px; cursor: pointer;margin-bottom: 16px;display: inline-block;'>
												Click here to reset password
										  </a>
									  </div>
								</div>
							   ";

    $mail->send();
    $_SESSION['message'] = "<span style='color:#000'>An email has been sent to $email. you'll receive instructions on how to set a new password. Please check your email. </span>";

    if (isset($_REQUEST['AnotherRequest'])) {

      $_SESSION['AnotherRequestMessage'] = "";
      header('location: ' . $base_url . 'forgotpwd.php?mailsent=' . $email . '&AnotherRequest');
    } else {

      header('location: ' . $base_url . 'forgotpwd.php?mailsent=' . $email);
    }

    die();
  } catch (Exception $e) {
    error_log("Password reset email error: " . $e->getMessage());
    $_SESSION['message'] = "Something went wrong, please try again";
    header('location: ' . $base_url . 'forgotpwd.php');
    die();
  }
}
?>
<!-- when user has signed up , I will get a email-->
<?php

if (isset($_POST['signUp_email'])) {

  try {
    $signUp_email   = $_POST['signUp_email'];
    $Account_Number = isset($_POST['Account_Number']) ? strtoupper($_POST['Account_Number']) : 'a/n';
    $first_name     = isset($_POST['first_name']) ? $_POST['first_name'] : 'a/n';

    $body = "<div style='padding:10px; max-width: 700px; margin: auto; color:#222 !important'>

			  <h1 style='font-size: 20px;'>Your <?php echo APP_NAME; ?> Journey Starts Here ✨</h1>
			  <p>Hello $first_name,</p>
			  <p> Welcome to <?php echo APP_NAME; ?> – where shipping is made seamless, and service is made special.

				Below is your unique overseas shipping address. Use this address whenever you’re shopping online so we can get your parcels to you quickly and securely.
				</p>
				<h4>Your Shipping Address:</h4>
			 <p>Line 1:5401 NW 102ND AVE</p>
				<p>Line 2:STE113 - $Account_Number</p>
				<p>City:SUNRISE</p>
				<p>State:Florida</p>
				<p>Country: United States</p>
				<p>Zip Code:33351</p>
				<p>For now, we’re delivering all parcels directly to you. Until your customer dashboard is updated to allow delivery scheduling, please head straight to “My Account” and set up your preferred delivery address. This ensures your parcels get to you without delay.</p>
                <hr />
				<p>Security Tip: <br />
				Always update your address inside your account. Avoid sending personal delivery details through WhatsApp or text — this helps us protect your privacy.
				</p>
			   <hr />
			   <p>We’re thrilled to have you with us, and we can’t wait to make every delivery feel like an unboxing experience you’ll remember.</p>
			   <h4>The Pync Chateau Promise:</h4>
			   <p>Parcels handled with care</p>
			   <p>Clear, timely updates</p>
			   <p>Service with a touch of luxury</p>
			   <h4>Your next steps:</h4>
			   <p>1.Save your shipping address above</p>
			   <p>2.Update your preferred delivery address under “My Account”</p>
			   <p>3.Start shopping and let the <?php echo APP_NAME; ?> take care of the rest</p>
			   <p>Here’s to your first delivery,The <?php echo APP_NAME; ?> Team</p>
		</div>";

    $email = $signUp_email; //$_REQUEST['PasswordResetEmail'] ;
    //Recipients
    $mail->setFrom(MAIL_USERNAME, APP_NAME);
    $mail->addAddress("$email", 'recipient email address.');

    //Content
    $mail->isHTML(true); //Set email format to HTML
    $mail->Subject = 'Welcome to the ' . APP_NAME . ' - Your Shipping Address is Ready!';
    $mail->Body    = $body;

    $mail->send();
    $_SESSION['message'] = "Registration successful. You can now log in";
    header('location: ' . $base_url . 'sign-in.php');
    die();
  } catch (Exception $e) {
    error_log("Sign-up email error: " . $e->getMessage());
    $_SESSION['message'] = "Something went wrong, please try again";
    header('location: ' . $base_url . 'forgotpwd.php');
    die();
  }
}
?>
