<?php
// Database Setup Script for Pync Parcel Chateau (Improved Version)

// Database configuration
require_once 'db_config.php';

// Step 1: Create database if it doesn't exist
$temp_conn = new mysqli(DB_HOST, DB_USER, DB_PASS);
if ($temp_conn->connect_error) {
    die("Connection failed: " . $temp_conn->connect_error);
}

$sql = "CREATE DATABASE IF NOT EXISTS `" . DB_NAME . "`";
if ($temp_conn->query($sql) === TRUE) {
    echo "Database '" . DB_NAME . "' created successfully or already exists.<br>";
} else {
    die("Error creating database: " . $temp_conn->error . "<br>");
}
$temp_conn->close();

// Step 2: Connect to database
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Step 3: Read schema file
$schema_file = 'database_schema.sql';
if (!file_exists($schema_file)) {
    die("Error: database_schema.sql file not found.<br>");
}

$sql_content = file_get_contents($schema_file);

// Remove comments but keep SQL structure
$sql_content = preg_replace('/--.*?\n/', '', $sql_content);

// Split by semicolons (but keep multiline statements intact)
$statements = array_filter(array_map('trim', preg_split('/;\s*\n/', $sql_content)));

$createStatements = [];
$insertStatements = [];
$alterStatements = [];
$otherStatements = [];

// Step 4: Categorize statements
foreach ($statements as $statement) {
    if (stripos($statement, 'CREATE TABLE') === 0) {
        $createStatements[] = $statement;
    } elseif (stripos($statement, 'INSERT INTO') === 0) {
        $insertStatements[] = $statement;
    } elseif (stripos($statement, 'ALTER TABLE') === 0) {
        $alterStatements[] = $statement;
    } else {
        $otherStatements[] = $statement;
    }
}

// Step 5: Drop tables in reverse dependency order
$dropTables = [
    'shipment_packages',
    'packages',
    'shipments',
    'pre_alert',
    'balance',
    'authorized_users',
    'users'
];

echo "Dropping existing tables (if any)...<br>";
foreach ($dropTables as $table) {
    if ($conn->query("DROP TABLE IF EXISTS `$table`") === TRUE) {
        echo "Dropped table: $table<br>";
    } else {
        echo "Error dropping $table: " . $conn->error . "<br>";
    }
}

echo "<br>Creating tables...<br>";
foreach ($createStatements as $sql) {
    if ($conn->query($sql) === TRUE) {
        echo "Created table: " . substr($sql, 13, 40) . "...<br>";
    } else {
        echo "<b>Error creating table:</b> " . $conn->error . "<br>";
        echo "Statement: $sql<br><br>";
    }
}

echo "<br>Executing INSERT statements...<br>";
foreach ($insertStatements as $sql) {
    if ($conn->query($sql) === TRUE) {
        echo "Inserted sample data.<br>";
    } else {
        echo "<b>Error inserting data:</b> " . $conn->error . "<br>";
        echo "Statement: $sql<br><br>";
    }
}

echo "<br>Executing other SQL statements...<br>";
foreach ($otherStatements as $sql) {
    if ($conn->query($sql) !== TRUE) {
        echo "<b>Error executing statement:</b> " . $conn->error . "<br>";
        echo "Statement: $sql<br><br>";
    }
}

echo "<br>Executing ALTER TABLE statements...<br>";
foreach ($alterStatements as $sql) {
    if ($conn->query($sql) === TRUE) {
        echo "Altered table successfully.<br>";
    } else {
        echo "<b>Error altering table:</b> " . $conn->error . "<br>";
        echo "Statement: $sql<br><br>";
    }
}

echo "<br><b>Database schema setup completed!</b><br><br>";

// Verify created tables
$tables_result = $conn->query("SHOW TABLES");
if ($tables_result) {
    echo "Tables in database:<br>";
    while ($row = $tables_result->fetch_array()) {
        echo $row[0] . "<br>";
    }
} else {
    echo "Error fetching tables: " . $conn->error . "<br>";
}

$conn->close();

echo "<br><a href='admin_user_setup.php'>Click here to setup admin user</a><br>";
echo "<a href='../admin-dashboard/index.php'>Go to Admin Dashboard</a>";
?>
