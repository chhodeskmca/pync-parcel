<?php
include_once 'config.php';
include_once 'function.php'; // for DB connection

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
function pull_packages_from_warehouse($limit = 10) {
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
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err = curl_error($ch);
        curl_close($ch);

        if ($err) {
            error_log("Warehouse API pull_packages_from_warehouse curl error: $err");
            return false;
        }

        if ($http_code !== 200) {
            error_log("Warehouse API pull_packages_from_warehouse HTTP error: $http_code, Response: $response");
            return false;
        }

        $result = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            error_log("Warehouse API pull_packages_from_warehouse JSON decode error: " . json_last_error_msg() . ", Response: $response");
            return false;
        }

        if (!isset($result['packages'])) {
            error_log("Warehouse API pull_packages_from_warehouse invalid response structure, missing 'packages' key. Response: " . json_encode($result));
            return false;
        }
        // echo "<pre>";
        // print_r($result['packages']);die();
        foreach ($result['packages'] as $package) {
            $trackingNumber = $package['tracking'] ?? '';
            $courierCompany = $package['courierName'] ?? '';
            $description = $package['description'] ?? '';
            $customerName = trim(($package['firstName'] ?? '') . ' ' . ($package['lastName'] ?? ''));
            $weight = $package['weight'] ?? 0;
            $dateCreated = $package['createdAt'] ?? '';
            $accountId = $package['accountId'] ?? '';

            $trackingName = $package['trackingName'] ?? null;
            $dimLength = $package['dimLength'] ?? null;
            $dimWidth = $package['dimWidth'] ?? null;
            $dimHeight = $package['dimHeight'] ?? null;
            $shipmentStatus = $package['shipmentStatus'] ?? null;
            $shipmentType = $package['shipmentType'] ?? null;
            $branch = $package['branch'] ?? null;
            $tag = $package['tag'] ?? null;

            $mysqlDate = '';
            if (!empty($dateCreated)) {
                try {
                    $dt = new DateTime($dateCreated);
                    $mysqlDate = $dt->format('Y-m-d H:i:s');
                } catch (Exception $e) {
                    $mysqlDate = date('Y-m-d H:i:s');
                }
            } else {
                $mysqlDate = date('Y-m-d H:i:s');
            }

            $user_id = 0;
            if ($accountId) {
            $sqlUser = "SELECT id FROM users WHERE account_number = '" . mysqli_real_escape_string($conn, $accountId) . "' LIMIT 1";
                $resUser = mysqli_query($conn, $sqlUser);
                if ($resUser && mysqli_num_rows($resUser) > 0) {
                    $rowUser = mysqli_fetch_assoc($resUser);
                    $user_id = $rowUser['id'];
                }
            }

            if ($user_id == 0) {
                continue; // Skip packages without a matching user
            }

            $sqlCheck = "SELECT id FROM packages WHERE tracking_number = '" . mysqli_real_escape_string($conn, $trackingNumber) . "'";
            $resCheck = mysqli_query($conn, $sqlCheck);
            if (mysqli_num_rows($resCheck) > 0) {
                $row = mysqli_fetch_assoc($resCheck);
                $sqlUpdate = "UPDATE packages SET
                    courier_company = '" . mysqli_real_escape_string($conn, $courierCompany) . "',
                    describe_package = '" . mysqli_real_escape_string($conn, $description) . "',
                    weight = " . floatval($weight) . ",
                    tracking_name = '" . mysqli_real_escape_string($conn, $trackingName) . "',
                    dim_length = " . ($dimLength !== null ? floatval($dimLength) : "NULL") . ",
                    dim_width = " . ($dimWidth !== null ? floatval($dimWidth) : "NULL") . ",
                    dim_height = " . ($dimHeight !== null ? floatval($dimHeight) : "NULL") . ",
                    shipment_status = '" . mysqli_real_escape_string($conn, $shipmentStatus) . "',
                    shipment_type = '" . mysqli_real_escape_string($conn, $shipmentType) . "',
                    branch = '" . mysqli_real_escape_string($conn, $branch) . "',
                    tag = '" . mysqli_real_escape_string($conn, $tag) . "',
                    created_at = '" . mysqli_real_escape_string($conn, $mysqlDate) . "',
                    user_id = " . intval($user_id) . "
                    WHERE id = " . intval($row['id']);
                $updateResult = mysqli_query($conn, $sqlUpdate);
                if (!$updateResult) {
                    error_log("Warehouse API pull_packages_from_warehouse DB update error: " . mysqli_error($conn) . " for tracking: $trackingNumber");
                } else {
                    error_log("Warehouse API pull_packages_from_warehouse updated package: $trackingNumber");
                }
            } else {
                $sqlInsert = "INSERT INTO packages
                    (user_id, tracking_number, courier_company, describe_package, weight, tracking_name, dim_length, dim_width, dim_height, shipment_status, shipment_type, branch, tag, created_at) VALUES (
                    " . intval($user_id) . ",
                    '" . mysqli_real_escape_string($conn, $trackingNumber) . "',
                    '" . mysqli_real_escape_string($conn, $courierCompany) . "',
                    '" . mysqli_real_escape_string($conn, $description) . "',
                    " . floatval($weight) . ",
                    '" . mysqli_real_escape_string($conn, $trackingName) . "',
                    " . ($dimLength !== null ? floatval($dimLength) : "NULL") . ",
                    " . ($dimWidth !== null ? floatval($dimWidth) : "NULL") . ",
                    " . ($dimHeight !== null ? floatval($dimHeight) : "NULL") . ",
                    '" . mysqli_real_escape_string($conn, $shipmentStatus) . "',
                    '" . mysqli_real_escape_string($conn, $shipmentType) . "',
                    '" . mysqli_real_escape_string($conn, $branch) . "',
                    '" . mysqli_real_escape_string($conn, $tag) . "',
                    '" . mysqli_real_escape_string($conn, $mysqlDate) . "'
                    )";
                $insertResult = mysqli_query($conn, $sqlInsert);
                if (!$insertResult) {
                    error_log("Warehouse API pull_packages_from_warehouse DB insert error: " . mysqli_error($conn) . " for tracking: $trackingNumber");
                } else {
                    error_log("Warehouse API pull_packages_from_warehouse inserted package: $trackingNumber");
                }
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
                'region' => $lc['region'],
            ]);
            if ($push_result !== false) {
                // Add pushed customer to merged list
                $merged_customers[] = [
                    'accountId' => $lc['account_number'],
                    'firstName' => $lc['first_name'],
                    'lastName' => $lc['last_name'],
                    'branch' => $lc['region'],
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
