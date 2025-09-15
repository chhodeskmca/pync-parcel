<?php
// Admin User Setup Script for Pync Parcel Chateau
// This script will create the default admin user

// Database configuration
require_once 'db_config.php';

// Create connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<h2>Admin User Setup for Pync Parcel Chateau</h2>";

// Read and execute the admin setup file
$setup_file = 'admin_user_setup.sql';
if (file_exists($setup_file)) {
    $sql_content = file_get_contents($setup_file);

    // Split the SQL file into individual statements
    $statements = array_filter(array_map('trim', explode(';', $sql_content)));

    foreach ($statements as $statement) {
        if (!empty($statement) && !preg_match('/^--/', $statement)) { // Skip comments and empty lines
            if ($conn->query($statement) === TRUE) {
                echo "Executed: " . substr($statement, 0, 50) . "...<br>";
            } else {
                echo "Error executing statement: " . $conn->error . "<br>";
                echo "Statement: " . $statement . "<br><br>";
            }
        }
    }
    echo "<br><strong>Admin user setup completed successfully!</strong><br>";
    echo "<br><strong>Default Admin Credentials:</strong><br>";
    echo "Email: admin-ppc@pyncparcel.com<br>";
    echo "Password: admin123<br>";
    echo "<span style='color: red;'><strong>⚠️ IMPORTANT: Change the default password after first login!</strong></span><br>";
} else {
    echo "Error: admin_user_setup.sql file not found.<br>";
}

// Close connection
$conn->close();

echo "<br><a href='./admin-dashboard/index.php'>Go to Admin Dashboard Login</a><br>";
echo "<a href='./index.php'>Go to Home Page</a>";
?>
