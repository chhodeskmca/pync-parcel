<?php
// Centralized route definitions and base URL

// Determine base URL dynamically (project root). Use dirname() which is more reliable across hosts
// SCRIPT_NAME usually contains the script path (e.g. /Pync-parcel/index.php).
// Use REQUEST_URI as a fallback when SCRIPT_NAME isn't available in some server configs.
$script_name = $_SERVER['SCRIPT_NAME'] ?? ($_SERVER['REQUEST_URI'] ?? '/');

// Determine project root from filesystem so the base URL is independent of the executing
// script location (this avoids building a base_url that accidentally contains "user-area").
// Prefer a filesystem-based calculation: compare DOCUMENT_ROOT to the project directory.
$scheme = (isset($_SERVER['REQUEST_SCHEME']) ? $_SERVER['REQUEST_SCHEME'] : (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http'));
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';

// Resolve filesystem paths
$doc_root = isset($_SERVER['DOCUMENT_ROOT']) ? realpath($_SERVER['DOCUMENT_ROOT']) : false;
$project_dir = realpath(__DIR__ . '/..'); // project root on filesystem

if ($doc_root && $project_dir && strpos($project_dir, $doc_root) === 0) {
  // Project sits under DOCUMENT_ROOT — compute web path portion
  $project_path = '/' . ltrim(str_replace('\\', '/', substr($project_dir, strlen($doc_root))), '/');
  if ($project_path === '/') {
    $project_path = '/';
  } else {
    $project_path = rtrim($project_path, '/') . '/';
  }
  $base_url = $scheme . '://' . $host . $project_path;
} else {
  // Fallback: derive from the request script name (previous method)
  $project_root = dirname($script_name);
  if ($project_root === '\\' || $project_root === '.' || $project_root === '') {
    $project_root = '/';
  } else {
    $project_root = rtrim($project_root, '/') . '/';
  }
  if ($project_root === '//') {
    $project_root = '/';
  }
  $base_url = $scheme . '://' . $host . $project_root;
}

// Define routes
return [
  'base_url' => $base_url,
  'home' => $base_url . 'index.php',
  'sign_in' => $base_url . 'sign-in.php',
  'sign_up' => $base_url . 'sign-up.php',
  'forgot_password' => $base_url . 'forgotpwd.php',
  'new_password' => $base_url . 'user-area/new-password.php',
  'process_signup' => $base_url . 'user-area/process-signup.php',
  // Ensure routes concatenate without producing double slashes.
  'sendmail' => rtrim($base_url, '/') . '/sendmail.php',
  'user_area' => $base_url . 'user-area/',
  'assets' => $base_url . 'assets/',
  'css' => $base_url . 'css/',
  'js' => $base_url . 'js/',
  'webhook_package_update' => $base_url . 'warehouse_api.php?webhook=package_update',
];
