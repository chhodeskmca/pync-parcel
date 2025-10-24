<?php
session_start();
include('../config.php');

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['emailaddress']);
    $password = $_POST['pwd'];

    $sql = "SELECT * FROM users WHERE email_address = '$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);

        $login_success = false;

        // Check if password matches bcrypt hash
        if (password_verify($password, $user['password_hash'])) {
            $login_success = true;
        } elseif ($user['password_hash'] === md5('pync' . $password)) {
            // Backward compatibility: if matches old md5 hash, rehash to bcrypt
            $new_hash = password_hash($password, PASSWORD_DEFAULT);
            $update_sql = "UPDATE users SET password_hash = '$new_hash' WHERE id = " . $user['id'];
            mysqli_query($conn, $update_sql);
            $login_success = true;
        }

        if ($login_success) {
            $user_data = json_encode(['id' => $user['id']]);
            $_SESSION['user_id'] = $user_data;
            setcookie('user_id', $user_data, time() + (86400 * 30), "/"); // 30 days
            $base_url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['SCRIPT_NAME'], 2), '/') . '/';
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
    } else {
        $_SESSION['message'] = "Invalid email or password";
        header("Location: ../sign-in.php");
        exit();
    }
}
?>
