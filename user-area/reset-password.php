<?php
// initialize session
session_start();
include '../config.php'; // database connection
if (isset($_REQUEST['email'])) {

    $email = trim(strtolower(mysqli_real_escape_string($conn, htmlspecialchars($_REQUEST['email']))));
    // checking email exists or not in database
    $sql        = "SELECT * FROM users where email_address = '$email'";
    $result     = mysqli_query($conn, $sql);
    $table_rows = mysqli_num_rows($result);
    if ($table_rows < 1) {
        $_SESSION['message'] = "We don't have an account with this email address.";
        header('location: ../forgotpwd.php');
        die();
    }
    $rows    = mysqli_fetch_array($result);
    $user_id = $rows['id'];
	echo "<pre>";
	print_r($rows);die();
    $Token            = bin2hex(random_bytes(16));
    $reset_token_hash = hash('sha256', $Token);
    $token_expired_at = date('Y-m-d H:i:s', time() + 60 * 60);
    $sql              = "UPDATE users SET token_hash = '$reset_token_hash', token_expired_at = '$token_expired_at' WHERE id = $user_id";

    if (mysqli_query($conn, $sql)) {

        if (isset($_REQUEST['AnotherRequest'])) {

            header("location: ../sendmail.php?PasswordResetEmail=$email&token_hash=$reset_token_hash&AnotherRequest"); // redirect to send mail page.
        } else {

            header("location: ../sendmail.php?PasswordResetEmail=$email&token_hash=$reset_token_hash"); // redirect to send mail page.
        }

        die();

    } else {
        echo "Reset password update failed: " . mysqli_error($conn) . " | SQL: " . $sql;
        //error_log("Reset password update failed: " . mysqli_error($conn) . " | SQL: " . $sql);
        //$_SESSION['message'] = "Something went wrong, please try again";
        //header('location: ../forgotpwd.php');
        die();
    }
}
// reset password from user account-setting page

if (isset($_REQUEST['userInputCurrentPwd'])) {

    $reset_password = ltrim($_REQUEST['userInputCurrentPwd']);
    if (! $reset_password == '') {
        $user_id       = $_REQUEST['user_id'];

        $sql    = "SELECT * FROM users WHERE id = $user_id";
        $result = mysqli_query($conn, $sql);
        $user = mysqli_fetch_assoc($result);

        if (password_verify($reset_password, $user['password_hash'])) {
            echo 1;
        } else {
            echo 0;
        }

    } else {

        echo 401;
    }

}
