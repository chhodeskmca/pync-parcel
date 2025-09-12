<?php
session_start();
include __DIR__ . '/../config.php';
include __DIR__ . '/../warehouse_api.php';
include __DIR__ . '/authorized-admin.php'; // Ensure admin is authorized

if (!isset($_COOKIE['user_id']) || user_account_information()['Role_As'] != 1) {
    http_response_code(403);
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit;
}

$result = pull_packages_from_warehouse();

if ($result) {
    $_SESSION['message'] = 'Package data pulled successfully from warehouse.';
    header('Location: packages.php');
} else {
    $_SESSION['message'] = 'Failed to pull package data from warehouse.';
    header('Location: packages.php');
}
exit;
?>
