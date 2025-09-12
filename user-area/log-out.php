<?php  
// User logging out
 session_start();
 $_SESSION['message'] = "<span style='color:#fff'>You've been logged out</span>";
 setcookie('user_id', $user_data, time() - (86400 * 150), "/");
 header('location: ../index.php');  
 
?>