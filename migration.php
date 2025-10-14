<?php
include('config.php');

// Add missing columns to users table
$alterQueries = [
    "ALTER TABLE users ADD COLUMN IF NOT EXISTS token_hash VARCHAR(255) DEFAULT NULL;",
    "ALTER TABLE users ADD COLUMN IF NOT EXISTS token_expired_at DATETIME DEFAULT NULL;",
    "ALTER TABLE users ADD COLUMN IF NOT EXISTS delivery_preference VARCHAR(255) DEFAULT NULL;",
    // Add missing columns to packages table
    "ALTER TABLE packages ADD COLUMN IF NOT EXISTS tracking_name VARCHAR(255) DEFAULT NULL;",
    "ALTER TABLE packages ADD COLUMN IF NOT EXISTS dim_length DECIMAL(10,2) DEFAULT NULL;",
    "ALTER TABLE packages ADD COLUMN IF NOT EXISTS dim_width DECIMAL(10,2) DEFAULT NULL;",
    "ALTER TABLE packages ADD COLUMN IF NOT EXISTS dim_height DECIMAL(10,2) DEFAULT NULL;",
    "ALTER TABLE packages ADD COLUMN IF NOT EXISTS shipment_status VARCHAR(100) DEFAULT NULL;",
    "ALTER TABLE packages ADD COLUMN IF NOT EXISTS shipment_type VARCHAR(100) DEFAULT NULL;",
    "ALTER TABLE packages ADD COLUMN IF NOT EXISTS branch VARCHAR(100) DEFAULT NULL;",
    "ALTER TABLE packages ADD COLUMN IF NOT EXISTS tag VARCHAR(100) DEFAULT NULL;",
    "ALTER TABLE packages ADD COLUMN IF NOT EXISTS tracking_history JSON DEFAULT NULL;"
];

foreach ($alterQueries as $query) {
    if (mysqli_query($conn, $query)) {
        echo "Executed: $query\n";
    } else {
        echo "Error executing: $query - " . mysqli_error($conn) . "\n";
    }
}

echo "Migration completed.\n";
?>
