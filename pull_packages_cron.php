<?php
// Cron job script to pull packages from warehouse API every 5 minutes
// Usage: Add to crontab: */5 * * * * /usr/bin/php /path/to/pull_packages_cron.php

include_once 'config.php';
include_once 'warehouse_api.php';

// Pull packages from warehouse
$result = pull_packages_from_warehouse(50); // Pull 50 at a time to avoid timeouts

if ($result) {
    echo "Packages pulled successfully at " . date('Y-m-d H:i:s') . "\n";
} else {
    echo "Failed to pull packages at " . date('Y-m-d H:i:s') . "\n";
}
?>
