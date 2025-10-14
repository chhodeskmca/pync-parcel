<?php

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$hostName     = $_ENV['DB_HOST'] ?? 'localhost';
$userName     = $_ENV['DB_USER'] ?? 'root';
$userPassword = $_ENV['DB_PASS'] ?? 'admin';
$dbName       = $_ENV['DB_NAME'] ?? 'freela53_pyncparcelchateau';

if (!defined('WAREHOUSE_API_KEY')) {
    define('WAREHOUSE_API_KEY', $_ENV['WAREHOUSE_API_KEY'] ?? '');
}

if (!defined('WAREHOUSE_API_URL')) {
    define('WAREHOUSE_API_URL', $_ENV['WAREHOUSE_API_URL'] ?? '');
}

if (!defined('IS_PRODUCTION')) {
    define('IS_PRODUCTION', ($_ENV['APP_ENV'] ?? 'development') === 'production');
}

if (!defined('RECAPTCHA_SITE_KEY')) {
    define('RECAPTCHA_SITE_KEY', $_ENV['RECAPTCHA_SITE_KEY'] ?? '');
}

if (!defined('RECAPTCHA_SECRET_KEY')) {
    define('RECAPTCHA_SECRET_KEY', $_ENV['RECAPTCHA_SECRET_KEY'] ?? '');
}

if (!defined('RECAPTCHA_ENABLED')) {
    define('RECAPTCHA_ENABLED', ($_ENV['RECAPTCHA_ENABLED'] ?? 'false') === 'true');
}

$conn = mysqli_connect($hostName, $userName, $userPassword, $dbName);
if (! $conn) {
    die("<h1 style=text-align: center'> Error: establishing A Databse connection </h1>");
}
