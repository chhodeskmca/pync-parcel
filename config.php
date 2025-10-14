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

if (!defined('APP_ENV')) {
    define('APP_ENV', $_ENV['APP_ENV'] ?? 'development');
}

if (!defined('IS_PRODUCTION')) {
    define('IS_PRODUCTION', (APP_ENV ?? 'development') === 'production');
}

if (!defined('RECAPTCHA_SITE_KEY')) {
    define('RECAPTCHA_SITE_KEY', $_ENV['RECAPTCHA_SITE_KEY'] ?? '6LdJX2orAAAAADNLtaBt1_hthT7n2xq1xcVwSR9q');
}

if (!defined('RECAPTCHA_SECRET_KEY')) {
    define('RECAPTCHA_SECRET_KEY', $_ENV['RECAPTCHA_SECRET_KEY'] ?? '6LdJX2orAAAAAFGf0vxYIvKGxET4GNkBiQjtPpsR');
}

if (!defined('RECAPTCHA_ENABLED')) {
    define('RECAPTCHA_ENABLED', ($_ENV['RECAPTCHA_ENABLED'] ?? 'false') === 'true');
}

if (!defined('MAIL_HOST')) {
    define('MAIL_HOST', $_ENV['MAIL_HOST'] ?? '');
}

if (!defined('MAIL_USERNAME')) {
    define('MAIL_USERNAME', $_ENV['MAIL_USERNAME'] ?? '');
}

if (!defined('MAIL_PASSWORD')) {
    define('MAIL_PASSWORD', $_ENV['MAIL_PASSWORD'] ?? '');
}

if (!defined('MAIL_ENCRYPTION')) {
    define('MAIL_ENCRYPTION', $_ENV['MAIL_ENCRYPTION'] ?? 'tls');
}

if (!defined('MAIL_PORT')) {
    define('MAIL_PORT', $_ENV['MAIL_PORT'] ?? 587);
}

if (!defined('SIGNUP_REDIRECT_URL_PROD')) {
    define('SIGNUP_REDIRECT_URL_PROD', $_ENV['SIGNUP_REDIRECT_URL_PROD'] ?? '');
}

if (!defined('SIGNUP_REDIRECT_URL_DEV')) {
    define('SIGNUP_REDIRECT_URL_DEV', $_ENV['SIGNUP_REDIRECT_URL_DEV'] ?? '');
}

if (!defined('APP_NAME')) {
    define('APP_NAME', $_ENV['APP_NAME'] ?? 'Pync Parcel Chateau');
}

$conn = mysqli_connect($hostName, $userName, $userPassword, $dbName);
if (! $conn) {
    die("<h1 style=text-align: center'> Error: establishing A Databse connection </h1>");
}
