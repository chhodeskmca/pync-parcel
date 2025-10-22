<?php
session_start();
include 'config.php';
include 'function.php';
// Ensure only admins can update payment status
if (function_exists('user_account_information')) {
    $current_user = user_account_information();
    if (!isset($current_user['role_as']) || intval($current_user['role_as']) !== 1) {
        http_response_code(403);
        echo json_encode(['error' => 'Forbidden']);
        exit;
    }
}

// Simple endpoint to update payment status and adjust balance
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
}

$tracking = isset($_POST['tracking']) ? mysqli_real_escape_string($conn, $_POST['tracking']) : '';
$new_status = isset($_POST['status']) ? mysqli_real_escape_string($conn, $_POST['status']) : '';

if (!$tracking || !in_array($new_status, ['Paid', 'Pending'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid input']);
    exit;
}

// Ensure column exists
$add_col_sql = "ALTER TABLE packages ADD COLUMN IF NOT EXISTS payment_status VARCHAR(20) DEFAULT 'Pending'";
// Some MySQL versions don't support IF NOT EXISTS for ADD COLUMN; try safely
mysqli_query($conn, $add_col_sql);

// Fetch package
$sql = "SELECT * FROM packages WHERE tracking_number = '" . mysqli_real_escape_string($conn, $tracking) . "' LIMIT 1";
$res = mysqli_query($conn, $sql);
if (! $res || mysqli_num_rows($res) == 0) {
    http_response_code(404);
    echo json_encode(['error' => 'Package not found']);
    exit;
}
$pkg = mysqli_fetch_assoc($res);
$prev_status = $pkg['payment_status'] ?? 'Pending';
$user_id = intval($pkg['user_id']);

// determine amount: prefer invoice_total, fall back to calculate_value_of_package
$amount = 0.0;
if (!empty($pkg['invoice_total'])) {
    $amount = floatval($pkg['invoice_total']);
} else if (!empty($pkg['weight']) && is_numeric($pkg['weight']) && $pkg['weight'] > 0) {
    $amount = calculate_value_of_package(floatval($pkg['weight']));
}

// Update package payment_status
$u_sql = "UPDATE packages SET payment_status = '" . mysqli_real_escape_string($conn, $new_status) . "' WHERE tracking_number = '" . mysqli_real_escape_string($conn, $tracking) . "'";
$ok = mysqli_query($conn, $u_sql);
if (! $ok) {
    http_response_code(500);
    echo json_encode(['error' => 'Failed to update package']);
    exit;
}

// Adjust balance only if amount > 0 and status transition requires adjustment
if ($amount > 0 && $user_id > 0) {
    // fetch balance
    $bal_res = mysqli_query($conn, "SELECT total_balance FROM balance WHERE user_id = $user_id LIMIT 1");
    $current_balance = 0.0;
    if ($bal_res && mysqli_num_rows($bal_res) > 0) {
        $brow = mysqli_fetch_assoc($bal_res);
        $current_balance = floatval($brow['total_balance']);
    }

    // Determine net change
    $delta = 0.0;
    if ($new_status == 'Pending' && $prev_status != 'Pending') {
        // add to outstanding -> decrease total_balance
        $delta = -1 * $amount;
    } elseif ($new_status == 'Paid' && $prev_status == 'Pending') {
        // remove from outstanding -> increase total_balance
        $delta = $amount;
    }

    if ($delta != 0.0) {
        $new_balance = $current_balance + $delta;
        // upsert into balance table
        if ($bal_res && mysqli_num_rows($bal_res) > 0) {
            mysqli_query($conn, "UPDATE balance SET total_balance = " . floatval($new_balance) . ", add_new_credit = 0 WHERE user_id = $user_id");
        } else {
            mysqli_query($conn, "INSERT INTO balance (user_id, total_balance, add_new_credit, created_at) VALUES ($user_id, " . floatval($new_balance) . ", 0, NOW())");
        }
        // insert audit record
        mysqli_query($conn, "INSERT INTO balance (user_id, add_new_credit, total_balance, created_at) VALUES ($user_id, " . floatval($delta) . ", " . floatval($new_balance) . ", NOW())");
    }
}

echo json_encode(['success' => true, 'new_status' => $new_status]);
exit;
