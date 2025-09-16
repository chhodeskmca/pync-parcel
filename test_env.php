<?php
require_once __DIR__ . '/vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

printf("Environment variables loaded from .env file:\n");
printf("========================================\n");
print_r($_ENV);
printf("========================================\n");

echo "MAIL_HOST: " . $_ENV['MAIL_HOST'] . "\n";
echo "MAIL_USERNAME: " . $_ENV['MAIL_USERNAME'] . "\n";
echo "MAIL_PASSWORD: " . $_ENV['MAIL_PASSWORD'] . "\n";
echo "MAIL_ENCRYPTION: " . $_ENV['MAIL_ENCRYPTION'] . "\n";
echo "MAIL_PORT: " . $_ENV['MAIL_PORT'] . "\n";
?>
