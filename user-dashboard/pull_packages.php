<?php
session_start();
include_once '../warehouse_api.php';

if (pull_packages_from_warehouse()) {
    $_SESSION['message'] = "Packages successfully pulled from Warehouse.";
    $_SESSION['message_type'] = "success";
} else {
    $_SESSION['message'] = "Failed to pull packages from Warehouse API.";
    $_SESSION['message_type'] = "error";
}

header("Location: package.php");
exit;
?>
