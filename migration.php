<?php
include('config.php');

// Add missing columns to users table
$alterQueries = [
    "ALTER TABLE users ADD COLUMN IF NOT EXISTS token_hash VARCHAR(255) DEFAULT NULL;",
    "ALTER TABLE users ADD COLUMN IF NOT EXISTS token_expired_at DATETIME DEFAULT NULL;",
    "ALTER TABLE users ADD COLUMN IF NOT EXISTS delivery_preference VARCHAR(255) DEFAULT NULL;"
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
