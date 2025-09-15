<?php
session_start();
include('../config.php');

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['emailaddress']);
    $password = mysqli_real_escape_string($conn, $_POST['pwd']);
    $hashed_password = md5('pync' . $password);

    $sql = "SELECT * FROM users WHERE email_address = '$email' AND password_hash = '$hashed_password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        $user_data = json_encode(['id' => $user['id']]);
        $_SESSION['user_id'] = $user_data;
        setcookie('user_id', $user_data, time() + (86400 * 30), "/"); // 30 days
        $base_url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME'], 2) . '/';
        if ($user['role_as'] == 1) {
            $redirect_url = $base_url . 'admin-dashboard/index.php';
        } else {
            $redirect_url = $base_url . 'user-dashboard/index.php';
        }
        header("Location: $redirect_url");
        exit();
    } else {
        $_SESSION['message'] = "Invalid email or password";
        header("Location: ../sign-in.php");
        exit();
    }
}
?>
