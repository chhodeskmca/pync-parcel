<?php
// Database Configuration for Pync Parcel Chateau
// This matches the existing config.php settings

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

define('DB_HOST', $_ENV['DB_HOST'] ?? 'localhost');
define('DB_USER', $_ENV['DB_USER'] ?? 'root');
define('DB_PASS', $_ENV['DB_PASS'] ?? 'admin'); // Default password from config.php
define('DB_NAME', $_ENV['DB_NAME'] ?? 'freela53_pyncparcelchateau'); // Default DB name from config.php
?>
