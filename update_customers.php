<?php
// Script to update all courier customers in warehouse API daily
include_once 'config.php';
include_once 'warehouse_api.php';

// Run the update
$result = update_all_courier_customers();

if ($result !== false) {
    echo "Updated $result customers successfully.\n";
} else {
    echo "Failed to update customers.\n";
}
?>
