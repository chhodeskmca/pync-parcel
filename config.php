<?php

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$hostName     = $_ENV['DB_HOST'] ?? 'localhost';
$userName     = $_ENV['DB_USER'] ?? 'root';
$userPassword = $_ENV['DB_PASS'] ?? 'admin';
$dbName       = $_ENV['DB_NAME'] ?? 'freela53_pyncparcelchateau';

define('WAREHOUSE_API_KEY', $_ENV['WAREHOUSE_API_KEY'] ?? '');

define('IS_PRODUCTION', ($_ENV['APP_ENV'] ?? 'development') === 'production');

$conn = mysqli_connect($hostName, $userName, $userPassword, $dbName);
if (! $conn) {
    die("<h1 style=text-align: center'> Error: establishing A Databse connection </h1>");
}
