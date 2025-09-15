<?php
include_once 'config.php';
include_once 'function.php'; // for DB connection

define('WAREHOUSE_API_URL', 'https://courier.shipavecorp.com/rpc');
define('WAREHOUSE_API_KEY', 'pub_key_7520691a44bc22bd1eef47ce05bc8ab397e7ba5a93c0ff0222');

// Function to push customer data to warehouse API
function push_customer_to_warehouse($customer) {
    $data = [
        'firstName' => $customer['first_name'],
        'lastName' => $customer['last_name'],
        'accountId' => $customer['account_number'],
        'branch' => $customer['region'],
    ];

    $payload = json_encode($data);

    $ch = curl_init(WAREHOUSE_API_URL . '/public.v1.PublicService/CreateCourierCustomer');
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'X-Logis-Auth: ' . WAREHOUSE_API_KEY,
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $err = curl_error($ch);
    curl_close($ch);

    if ($err) {
        error_log("Warehouse API push_customer_to_warehouse error: $err");
        return false;
    }

    $result = json_decode($response, true);
    if (isset($result['error'])) {
        error_log("Warehouse API push_customer_to_warehouse API error: " . $result['error']);
        return false;
    }

    return $result;
}

// Function to pull package data from warehouse API and update local pre_alert table
function pull_packages_from_warehouse($limit = 50) {
    global $conn;

    $cursor = '';
    $hasMore = true;

    while ($hasMore) {
        $payload = json_encode([
            'cursor' => $cursor,
            'limit' => $limit,
        ]);

        $ch = curl_init(WAREHOUSE_API_URL . '/public.v1.PublicService/ListCourierPackages');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'X-Logis-Auth: ' . WAREHOUSE_API_KEY,
        ]);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        if ($err) {
            error_log("Warehouse API pull_packages_from_warehouse error: $err");
            return false;
        }

        $result = json_decode($response, true);
        if (!isset($result['packages'])) {
            error_log("Warehouse API pull_packages_from_warehouse invalid response");
            return false;
        }

        foreach ($result['packages'] as $package) {
            $trackingNumber = $package['tracking'] ?? '';
            $courierCompany = $package['courierName'] ?? '';
            $description = $package['description'] ?? '';
            $customerName = trim(($package['firstName'] ?? '') . ' ' . ($package['lastName'] ?? ''));
            $weight = $package['weight'] ?? 0;
            $dateCreated = $package['createdAt'] ?? '';
            $accountId = $package['accountId'] ?? '';

            $user_id = 0;
            if ($accountId) {
            $sqlUser = "SELECT id FROM users WHERE account_number = '" . mysqli_real_escape_string($conn, $accountId) . "' LIMIT 1";
                $resUser = mysqli_query($conn, $sqlUser);
                if ($resUser && mysqli_num_rows($resUser) > 0) {
                    $rowUser = mysqli_fetch_assoc($resUser);
                    $user_id = $rowUser['id'];
                }
            }

            $sqlCheck = "SELECT id FROM pre_alert WHERE tracking_number = '" . mysqli_real_escape_string($conn, $trackingNumber) . "'";
            $resCheck = mysqli_query($conn, $sqlCheck);
            if (mysqli_num_rows($resCheck) > 0) {
                $row = mysqli_fetch_assoc($resCheck);
                $sqlUpdate = "UPDATE pre_alert SET
                    courier_company = '" . mysqli_real_escape_string($conn, $courierCompany) . "',
                    describe_package = '" . mysqli_real_escape_string($conn, $description) . "',
                    weight = '" . mysqli_real_escape_string($conn, $weight) . "',
                    created_at = '" . mysqli_real_escape_string($conn, $dateCreated) . "',
                    user_id = " . intval($user_id) . "
                    WHERE id = " . intval($row['id']);
                mysqli_query($conn, $sqlUpdate);
            } else {
                $sqlInsert = "INSERT INTO pre_alert
                    (user_id, tracking_number, courier_company, describe_package, weight, created_at) VALUES (
                    " . intval($user_id) . ",
                    '" . mysqli_real_escape_string($conn, $trackingNumber) . "',
                    '" . mysqli_real_escape_string($conn, $courierCompany) . "',
                    '" . mysqli_real_escape_string($conn, $description) . "',
                    '" . mysqli_real_escape_string($conn, $weight) . "',
                    '" . mysqli_real_escape_string($conn, $dateCreated) . "'
                    )";
                mysqli_query($conn, $sqlInsert);
            }
        }

        $cursor = $result['nextCursor'] ?? '';
        $hasMore = !empty($cursor);
    }

    return true;
}

function fetch_customers_from_warehouse() {
    $ch = curl_init(WAREHOUSE_API_URL . '/public.v1.PublicService/ListCourierCustomers');
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'X-Logis-Auth: ' . WAREHOUSE_API_KEY,
    ]);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $err = curl_error($ch);
    curl_close($ch);

    if ($err) {
        error_log("Warehouse API fetch_customers_from_warehouse error: $err");
        return false;
    }

    $result = json_decode($response, true);
    if (!isset($result['customers'])) {
        error_log("Warehouse API fetch_customers_from_warehouse invalid response");
        return false;
    }

    return $result['customers'];
}

// New function to sync local DB customers with warehouse API customers
function sync_customers_with_warehouse($local_customers) {
    $warehouse_customers = fetch_customers_from_warehouse();
    if ($warehouse_customers === false) {
        // API fetch failed, return local customers only
        return $local_customers;
    }

    // Map warehouse customers by accountId for quick lookup
    $warehouse_map = [];
    foreach ($warehouse_customers as $wc) {
        $warehouse_map[$wc['accountId']] = $wc;
    }

    $merged_customers = $local_customers;

    // Push missing local customers to warehouse API
    foreach ($local_customers as $lc) {
        if (!isset($warehouse_map[$lc['account_number']])) {
            // Push to warehouse API
            $push_result = push_customer_to_warehouse([
                'first_name' => $lc['first_name'],
                'last_name' => $lc['last_name'],
                'account_number' => $lc['account_number'],
                'Region' => $lc['Region'],
            ]);
            if ($push_result !== false) {
                // Add pushed customer to merged list
                $merged_customers[] = [
                    'accountId' => $lc['account_number'],
                    'firstName' => $lc['first_name'],
                    'lastName' => $lc['last_name'],
                    'branch' => $lc['Region'],
                ];
            }
        }
    }

    // Add warehouse customers not in local DB to merged list
    $local_account_numbers = array_column($local_customers, 'account_number');
    foreach ($warehouse_customers as $wc) {
        if (!in_array($wc['accountId'], $local_account_numbers)) {
            $merged_customers[] = $wc;
        }
    }

    return $merged_customers;
}
?>
