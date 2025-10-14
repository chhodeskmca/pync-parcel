<?php
// initialize session
session_start();
include '../config.php'; // database connection
// initialize user variables from user sign up form
$pwd          = ltrim(mysqli_real_escape_string($conn, htmlspecialchars($_POST['pwd'])));
$VerifyPwd    = ltrim(mysqli_real_escape_string($conn, htmlspecialchars($_POST['verifypwd'])));
$first_name   = mysqli_real_escape_string($conn, htmlspecialchars($_POST['first_name']));
$last_name    = mysqli_real_escape_string($conn, htmlspecialchars($_POST['last_name']));
$Number       = mysqli_real_escape_string($conn, htmlspecialchars($_POST['phone']));
$Emailaddress = mysqli_real_escape_string($conn, htmlspecialchars($_POST['emailaddress']));

$sql        = "SELECT * FROM users where email_address = '$Emailaddress'";
$result     = mysqli_query($conn, $sql);
$table_rows = mysqli_num_rows($result);

// ================== sign up validation checking start================

if (! isset($_POST['signup'])) {
  header("location: ../index.php");
  die();
} else if ($first_name == "") {

  $_SESSION['message'] = 'Please Enter first Name';
  //If first name not entered, Redirect to signup page
  header("location: ../sign-up.php?first_name=$first_name&last_name=$last_name&Number=$Number&Emailaddress=$Emailaddress");
  die();
} else if (! preg_match('/[a-z]/i', $first_name)) {

  $_SESSION['message'] = 'The Name  must contain characters(a-z)';
  // If not any letter entered, Redirect to signup page
  header("location: ../sign-up.php?first_name=$first_name&last_name=$last_name&Number=$Number&Emailaddress=$Emailaddress");
  die();
} else if ($last_name == "") {

  $_SESSION['message'] = 'Please Enter last Name';
  //If last name not entered, Redirect to signup page
  header("location: ../sign-up.php?first_name=$first_name&last_name=$last_name&Number=$Number&Emailaddress=$Emailaddress");
  die();
} else if ($Number == "") {

  //If Number not entered, Redirect to signup page
  $_SESSION['message'] = 'Please Enter Number';
  header("location: ../sign-up.php?first_name=$first_name&last_name=$last_name&Number=$Number&Emailaddress=$Emailaddress");
  die();
} else if (strlen($Number) < 11) {

  //If The Number not more than 11, Redirect to signup page
  $_SESSION['message'] = 'The Number must be valid';
  header("location: ../sign-up.php?first_name=$first_name&last_name=$last_name&Number=$Number&Emailaddress=$Emailaddress");
  die();
} else if ($Emailaddress == "") {

  //If emailaddress  not entered, Redirect to signup page
  $_SESSION['message'] = 'Please Enter Email address';
  header("location: ../sign-up.php?first_name=$first_name&last_name=$last_name&Number=$Number&Emailaddress=$Emailaddress");
  die();
} else if (! filter_var($Emailaddress, FILTER_VALIDATE_EMAIL)) {

  //If email not valid, Redirect to signup page
  $_SESSION['message'] = 'Th Email address must be valid ';
  header("location: ../sign-up.php?first_name=$first_name&last_name=$last_name&Number=$Number&Emailaddress=$Emailaddress");
  die();
} else if ($table_rows > 0) {

  //If email already exist, Redirect to signup page
  $_SESSION['message'] = 'The Email is already registered. Please try logging in instead';
  header("location: ../sign-up.php?first_name=$first_name&last_name=$last_name&Number=$Number&Emailaddress=$Emailaddress");
  die();
} else if ($pwd == "") {

  //If Password  not entered, Redirect to signup page
  $_SESSION['message'] = 'Please Enter Password';
  header("location: ../sign-up.php?first_name=$first_name&last_name=$last_name&Number=$Number&Emailaddress=$Emailaddress");
  die();
} else if (! (strlen($pwd) > 7 && preg_match('/[A-Z]/', $pwd))) {

  //If Password  not entered, Redirect to signup page
  $_SESSION['message'] = 'Password must contain at least 8 characters with a capital letter';

  header("location: ../sign-up.php?first_name=$first_name&last_name=$last_name&Number=$Number&Emailaddress=$Emailaddress");
  die();
} else if ($pwd !== $VerifyPwd) {
  //If Password  not  matched, Redirect to signup page
  $_SESSION['message'] = "The passwords don’t match.";
  header("location: ../sign-up.php?first_name=$first_name&last_name=$last_name&Number=$Number&Emailaddress=$Emailaddress");
  die();
} else if (! isset($_POST['i_accepted'])) {

  // Password  not  matched, Redirect to signup page
  $_SESSION['message'] = "Please check (I accept the terms and conditions of Pync Parcel Chateau)";
  header("location: ../sign-up.php?first_name=$first_name&last_name=$last_name&Number=$Number&Emailaddress=$Emailaddress");
  die();
} else if (RECAPTCHA_ENABLED && (! isset($_POST['g-recaptcha-response']) || empty($_POST['g-recaptcha-response']))) {

  // if response variable not found or empty, Redirect to signup page
  $_SESSION['message'] = "Error in recaptcha verification";
  header("location: ../sign-up.php?first_name=$first_name&last_name=$last_name&Number=$Number&Emailaddress=$Emailaddress");
  die();
}

if (RECAPTCHA_ENABLED) {
  $response = $_POST['g-recaptcha-response'];
  $secret = RECAPTCHA_SECRET_KEY; // recaptcha secret key
  $VerifyResponse = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$response");
  $api_response = json_decode($VerifyResponse); // API response

  if (!$api_response->success) {

    // Password  not  matched, Redirect to signup page
    $_SESSION['message'] = "Recaptcha verification api : something went wrong";
    header("location: ../sign-up.php?first_name=$first_name&last_name=$last_name&Number=$Number&Emailaddress=$Emailaddress");
    die();
  };
}
// ================== sign up validation checking end================

// inserting  sign up data of users
$hash_password  = password_hash($pwd, PASSWORD_DEFAULT);
$Account_Number = 'Pync-' . rand(1, 100000); // generating account number
$created_at     = date("Y-m-d H:i:s");       //date("m-d-Y H:i:s");
$sql            = "INSERT INTO users (first_name, last_name, phone_number, email_address, password_hash, account_number, created_at)
    VALUES ('$first_name', '$last_name', ' $Number', '$Emailaddress', '$hash_password', '$Account_Number', '$created_at')";

if (mysqli_query($conn, $sql)) {

  $last_id = mysqli_insert_id($conn);
  $sql     = "INSERT INTO  authorized_users (user_id) VALUES ($last_id)";
  if (mysqli_query($conn, $sql)) {
    // Include warehouse API functions
    include_once __DIR__ . '/../warehouse_api.php';

    // Fetch inserted user data
    $user_sql    = "SELECT * FROM users WHERE id = $last_id";
    $user_result = mysqli_query($conn, $user_sql);
    $user_data   = mysqli_fetch_assoc($user_result);

    // Push customer data to warehouse
    push_customer_to_warehouse($user_data);

    //$_SESSION['message'] = "Registration successful. You can now log in";

    $routes = include __DIR__ . '/../routes/web.php';

    $redirect_url = IS_PRODUCTION ? SIGNUP_REDIRECT_URL_PROD : SIGNUP_REDIRECT_URL_DEV;
    if (! $redirect_url) {
      $redirect_url = $routes['sendmail'];
    }
    // Use POST redirect to avoid exposing sensitive data in URL
    echo "<form id='redirectForm' action='$redirect_url' method='POST'>
            <input type='hidden' name='first_name' value='$first_name'>
            <input type='hidden' name='Account_Number' value='$Account_Number'>
            <input type='hidden' name='signUp_email' value='$Emailaddress'>
          </form>
          <script>document.getElementById('redirectForm').submit();</script>";
    exit();
  } else {

    $_SESSION['message'] = "Something went wrong. Please try later";
    header('location: ../sign-up.php');
    die();
  }
} else {

  $_SESSION['message'] = "Something went wrong. Please try later";
  header('location: ../sign-up.php');
  die();
}
