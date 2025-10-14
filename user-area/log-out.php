<?php
// User logging out
 session_start();
 setcookie('user_id', '', time() - (86400 * 150), "/");
 header('location: ../index.php');

?>
