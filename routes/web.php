<?php
// Centralized route definitions and base URL

// Determine base URL dynamically (project root)
$script_name = $_SERVER['SCRIPT_NAME'];
$path_parts = explode('/', $script_name);
$project_root = '/' . $path_parts[1] . '/'; // e.g., /Pync-parcel-source-files/
$base_url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $project_root;

// Define routes
return [
    'base_url' => $base_url,
    'home' => $base_url . 'index.php',
    'sign_in' => $base_url . 'sign-in.php',
    'sign_up' => $base_url . 'sign-up.php',
    'forgot_password' => $base_url . 'forgotpwd.php',
    'new_password' => $base_url . 'user-area/new-password.php',
    'process_signup' => $base_url . 'user-area/process-signup.php',
    'sendmail' => $base_url . 'sendmail.php',
    'user_area' => $base_url . 'user-area/',
    'assets' => $base_url . 'assets/',
    'css' => $base_url . 'css/',
    'js' => $base_url . 'js/',
    'webhook_package_update' => $base_url . 'warehouse_api.php?webhook=package_update',
];
?>
