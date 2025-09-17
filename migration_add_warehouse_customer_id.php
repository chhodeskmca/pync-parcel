<?php
include('config.php');

// Add warehouse_customer_id column to users table if it does not exist
$checkColumnQuery = "SHOW COLUMNS FROM users LIKE 'warehouse_customer_id'";
$result = mysqli_query($conn, $checkColumnQuery);

if (mysqli_num_rows($result) == 0) {
    $alterQuery = "ALTER TABLE users ADD COLUMN warehouse_customer_id VARCHAR(255) DEFAULT NULL";
    if (mysqli_query($conn, $alterQuery)) {
        echo "Column 'warehouse_customer_id' added to users table successfully.\n";
    } else {
        echo "Error adding column 'warehouse_customer_id': " . mysqli_error($conn) . "\n";
    }
} else {
    echo "Column 'warehouse_customer_id' already exists in users table.\n";
}
?>
