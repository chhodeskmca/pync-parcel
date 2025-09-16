<?php
include_once 'config.php';
include_once 'function.php'; // for DB connection

// Function to push customer data to warehouse API
function push_customer_to_warehouse($customer)
{
    $data = [
        'firstName' => $customer['first_name'],
        'lastName'  => $customer['last_name'],
        'accountId' => $customer['account_number'],
        'branch'    => $customer['region'],
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
    $err      = curl_error($ch);
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
function pull_packages_from_warehouse($limit = 10)
{
    global $conn;

    $cursor  = '';
    $hasMore = true;

    while ($hasMore) {
        $payload = json_encode([
            'cursor' => $cursor,
            'limit'  => $limit,
        ]);

        $ch = curl_init(WAREHOUSE_API_URL . '/public.v1.PublicService/ListCourierPackages');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'X-Logis-Auth: ' . WAREHOUSE_API_KEY,
        ]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response  = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $err       = curl_error($ch);
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

        if (! isset($result['packages'])) {
            error_log("Warehouse API pull_packages_from_warehouse invalid response structure, missing 'packages' key. Response: " . json_encode($result));
            return false;
        }
        // echo "<pre>";
        // print_r($result['packages']);die();
        foreach ($result['packages'] as $package) {
            $trackingNumber = $package['tracking'] ?? '';
            $courierCompany = $package['courierName'] ?? '';
            $description    = $package['description'] ?? '';
            $customerName   = trim(($package['firstName'] ?? '') . ' ' . ($package['lastName'] ?? ''));
            $weight         = $package['weight'] ?? 0;
            $dateCreated    = $package['createdAt'] ?? '';
            $accountId      = $package['accountId'] ?? '';

            $trackingName   = $package['trackingName'] ?? null;
            $dimLength      = $package['dimLength'] ?? null;
            $dimWidth       = $package['dimWidth'] ?? null;
            $dimHeight      = $package['dimHeight'] ?? null;
            $shipmentStatus = $package['shipmentStatus'] ?? null;
            $shipmentType   = $package['shipmentType'] ?? null;
            $branch         = $package['branch'] ?? null;
            $tag            = $package['tag'] ?? null;

            // New warehouse API fields
            $firstName          = $package['firstName'] ?? null;
            $lastName           = $package['lastName'] ?? null;
            $shipmentId         = $package['shipmentId'] ?? null;
            $warehousePackageId = $package['id'] ?? null;
            $courierId          = $package['courierId'] ?? null;
            $courierCustomerId  = $package['courierCustomerId'] ?? null;
            $addedToShipmentAt  = $package['addedToShipmentAt'] ?? null;
            $shipmentSimpleId   = $package['shipmentSimpleId'] ?? null;

            $mysqlDate = '';
            if (! empty($dateCreated)) {
                try {
                    $dt        = new DateTime($dateCreated);
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

            // Check if shipmentId exists in shipments table
            $shipment_id_value = "NULL";
            if ($shipmentId !== null) {
                $check_sql    = "SELECT id FROM shipments WHERE id = " . intval($shipmentId);
                $check_result = mysqli_query($conn, $check_sql);
                if ($check_result && mysqli_num_rows($check_result) > 0) {
                    $shipment_id_value = intval($shipmentId);
                }
            }

            // Convert addedToShipmentAt to MySQL format
            $added_to_shipment_at_value = "NULL";
            if ($addedToShipmentAt !== null) {
                try {
                    $dt                         = new DateTime($addedToShipmentAt);
                    $added_to_shipment_at_value = "'" . $dt->format('Y-m-d H:i:s') . "'";
                } catch (Exception $e) {
                    $added_to_shipment_at_value = "NULL";
                }
            }

            $sqlCheck = "SELECT id FROM packages WHERE tracking_number = '" . mysqli_real_escape_string($conn, $trackingNumber) . "'";
            $resCheck = mysqli_query($conn, $sqlCheck);
            if (mysqli_num_rows($resCheck) > 0) {
                $row       = mysqli_fetch_assoc($resCheck);
                $sqlUpdate = "UPDATE packages SET
                    tracking_number = '" . mysqli_real_escape_string($conn, $trackingNumber) . "',
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
                    courier_id = " . ($courierId !== null ? "'" . mysqli_real_escape_string($conn, $courierId) . "'" : "NULL") . ",
                    courier_customer_id = " . ($courierCustomerId !== null ? "'" . mysqli_real_escape_string($conn, $courierCustomerId) . "'" : "NULL") . ",
                    added_to_shipment_at = " . $added_to_shipment_at_value . ",
                    shipment_simple_id = " . ($shipmentSimpleId !== null ? "'" . mysqli_real_escape_string($conn, $shipmentSimpleId) . "'" : "NULL") . ",
                    warehouse_package_id = " . ($warehousePackageId !== null ? "'" . mysqli_real_escape_string($conn, $warehousePackageId) . "'" : "NULL") . ",
                    created_at = '" . mysqli_real_escape_string($conn, $mysqlDate) . "',
                    user_id = " . intval($user_id) . ",
                    shipment_id = " . $shipment_id_value . "
                    WHERE id = " . intval($row['id']);
                $updateResult = mysqli_query($conn, $sqlUpdate);
                if (! $updateResult) {
                    error_log("Warehouse API pull_packages_from_warehouse DB update error: " . mysqli_error($conn) . " for tracking: $trackingNumber");
                } else {
                    error_log("Warehouse API pull_packages_from_warehouse updated package: $trackingNumber");
                }
            } else {
                $sqlInsert = "INSERT INTO packages
                    (user_id, tracking_number, courier_company, describe_package, weight, tracking_name, dim_length, dim_width, dim_height, shipment_status, shipment_type, branch, tag, courier_id, courier_customer_id, added_to_shipment_at, shipment_simple_id, warehouse_package_id, created_at, shipment_id) VALUES (
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
                    " . ($courierId !== null ? "'" . mysqli_real_escape_string($conn, $courierId) . "'" : "NULL") . ",
                    " . ($courierCustomerId !== null ? "'" . mysqli_real_escape_string($conn, $courierCustomerId) . "'" : "NULL") . ",
                    " . $added_to_shipment_at_value . ",
                    " . ($shipmentSimpleId !== null ? "'" . mysqli_real_escape_string($conn, $shipmentSimpleId) . "'" : "NULL") . ",
                    " . ($warehousePackageId !== null ? "'" . mysqli_real_escape_string($conn, $warehousePackageId) . "'" : "NULL") . ",
                    '" . mysqli_real_escape_string($conn, $mysqlDate) . "',
                    " . $shipment_id_value . "
                    )";
                $insertResult = mysqli_query($conn, $sqlInsert);
                if (! $insertResult) {
                    error_log("Warehouse API pull_packages_from_warehouse DB insert error: " . mysqli_error($conn) . " for tracking: $trackingNumber");
                } else {
                    error_log("Warehouse API pull_packages_from_warehouse inserted package: $trackingNumber");
                }
            }
        }

        $cursor  = $result['nextCursor'] ?? '';
        $hasMore = ! empty($cursor);
    }

    return true;
}

function fetch_customers_from_warehouse()
{
    $ch = curl_init(WAREHOUSE_API_URL . '/public.v1.PublicService/ListCourierCustomers');
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'X-Logis-Auth: ' . WAREHOUSE_API_KEY,
    ]);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $err      = curl_error($ch);
    curl_close($ch);

    if ($err) {
        error_log("Warehouse API fetch_customers_from_warehouse error: $err");
        return false;
    }

    $result = json_decode($response, true);
    if (! isset($result['customers'])) {
        error_log("Warehouse API fetch_customers_from_warehouse invalid response");
        return false;
    }

    return $result['customers'];
}

// New function to sync local DB customers with warehouse API customers
function sync_customers_with_warehouse($local_customers)
{
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
        if (! isset($warehouse_map[$lc['account_number']])) {
            // Push to warehouse API
            $push_result = push_customer_to_warehouse([
                'first_name'     => $lc['first_name'],
                'last_name'      => $lc['last_name'],
                'account_number' => $lc['account_number'],
                'region'         => $lc['region'],
            ]);
            if ($push_result !== false) {
                // Add pushed customer to merged list
                $merged_customers[] = [
                    'accountId' => $lc['account_number'],
                    'firstName' => $lc['first_name'],
                    'lastName'  => $lc['last_name'],
                    'branch'    => $lc['region'],
                ];
            }
        }
    }

    // Add warehouse customers not in local DB to merged list
    $local_account_numbers = array_column($local_customers, 'account_number');
    foreach ($warehouse_customers as $wc) {
        if (! in_array($wc['accountId'], $local_account_numbers)) {
            $merged_customers[] = $wc;
        }
    }

    return $merged_customers;
}

// Webhook handler to receive package updates from warehouse system

function process_package_created($package, $conn)
{
    // Extract package fields with fallback defaults
    $trackingNumber = $package['tracking'] ?? '';
    $courierCompany = $package['courierName'] ?? '';
    $description    = $package['description'] ?? '';
    $customerName   = trim(($package['firstName'] ?? '') . ' ' . ($package['lastName'] ?? ''));
    $weight         = $package['weight'] ?? 0;
    $dateCreated    = $package['createdAt'] ?? '';
    $accountId      = $package['accountId'] ?? '';

    $trackingName   = $package['trackingName'] ?? '';
    $dimLength      = $package['dimLength'] ?? null;
    $dimWidth       = $package['dimWidth'] ?? null;
    $dimHeight      = $package['dimHeight'] ?? null;
    $shipmentStatus = $package['shipmentStatus'] ?? '';
    $shipmentType   = $package['shipmentType'] ?? '';
    $branch         = $package['branch'] ?? '';
    $tag            = $package['tag'] ?? '';

    $firstName          = $package['firstName'] ?? null;
    $lastName           = $package['lastName'] ?? null;
    $shipmentId         = $package['shipmentId'] ?? null;
    $warehousePackageId = $package['id'] ?? null;
    $courierId          = $package['courierId'] ?? null;
    $courierCustomerId  = $package['courierCustomerId'] ?? null;
    $addedToShipmentAt  = $package['addedToShipmentAt'] ?? null;
    $shipmentSimpleId   = $package['shipmentSimpleId'] ?? null;

    $mysqlDate = '';
    if (! empty($dateCreated)) {
        try {
            $dt        = new DateTime($dateCreated);
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
        error_log("Warehouse API webhook: No user found for accountId: $accountId");
        return false; // Skip packages without a matching user
    }

    $shipment_id_value = "NULL";
    if ($shipmentId !== null) {
        $check_sql    = "SELECT id FROM shipments WHERE shipmentSimpleId = '" . mysqli_real_escape_string($conn, $shipmentId) . "' LIMIT 1";
        $check_result = mysqli_query($conn, $check_sql);
        if ($check_result && mysqli_num_rows($check_result) > 0) {
            $row               = mysqli_fetch_assoc($check_result);
            $shipment_id_value = intval($row['id']);
        }
    }

    $added_to_shipment_at_value = "NULL";
    if ($addedToShipmentAt !== null) {
        try {
            $dt                         = new DateTime($addedToShipmentAt);
            $added_to_shipment_at_value = "'" . $dt->format('Y-m-d H:i:s') . "'";
        } catch (Exception $e) {
            $added_to_shipment_at_value = "NULL";
        }
    }

    $sqlCheck = "SELECT id FROM packages WHERE tracking_number = '" . mysqli_real_escape_string($conn, $trackingNumber) . "'";
    $resCheck = mysqli_query($conn, $sqlCheck);
    if (mysqli_num_rows($resCheck) > 0) {
        $row       = mysqli_fetch_assoc($resCheck);
        $sqlUpdate = "UPDATE packages SET
            tracking_number = '" . mysqli_real_escape_string($conn, $trackingNumber) . "',
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
            courier_id = " . ($courierId !== null ? "'" . mysqli_real_escape_string($conn, $courierId) . "'" : "NULL") . ",
            courier_customer_id = " . ($courierCustomerId !== null ? "'" . mysqli_real_escape_string($conn, $courierCustomerId) . "'" : "NULL") . ",
            added_to_shipment_at = " . $added_to_shipment_at_value . ",
            shipment_simple_id = " . ($shipmentSimpleId !== null ? "'" . mysqli_real_escape_string($conn, $shipmentSimpleId) . "'" : "NULL") . ",
            warehouse_package_id = " . ($warehousePackageId !== null ? "'" . mysqli_real_escape_string($conn, $warehousePackageId) . "'" : "NULL") . ",
            created_at = '" . mysqli_real_escape_string($conn, $mysqlDate) . "',
            user_id = " . intval($user_id) . ",
            shipment_id = " . $shipment_id_value . "
            WHERE id = " . intval($row['id']);
        $updateResult = mysqli_query($conn, $sqlUpdate);
        if (! $updateResult) {
            error_log("Warehouse API webhook DB update error: " . mysqli_error($conn) . " for tracking: $trackingNumber");
            return false;
        } else {
            error_log("Warehouse API webhook updated package: $trackingNumber");
            return true;
        }
    } else {
        $sqlInsert = "INSERT INTO packages
            (user_id, tracking_number, courier_company, describe_package, weight, tracking_name, dim_length, dim_width, dim_height, shipment_status, shipment_type, branch, tag, courier_id, courier_customer_id, added_to_shipment_at, shipment_simple_id, warehouse_package_id, created_at, shipment_id) VALUES (
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
            " . ($courierId !== null ? "'" . mysqli_real_escape_string($conn, $courierId) . "'" : "NULL") . ",
            " . ($courierCustomerId !== null ? "'" . mysqli_real_escape_string($conn, $courierCustomerId) . "'" : "NULL") . ",
            " . $added_to_shipment_at_value . ",
            " . ($shipmentSimpleId !== null ? "'" . mysqli_real_escape_string($conn, $shipmentSimpleId) . "'" : "NULL") . ",
            " . ($warehousePackageId !== null ? "'" . mysqli_real_escape_string($conn, $warehousePackageId) . "'" : "NULL") . ",
            '" . mysqli_real_escape_string($conn, $mysqlDate) . "',
            " . $shipment_id_value . "
            )";
        $insertResult = mysqli_query($conn, $sqlInsert);
        if (! $insertResult) {
            error_log("Warehouse API webhook DB insert error: " . mysqli_error($conn) . " for tracking: $trackingNumber");
            return false;
        } else {
            error_log("Warehouse API webhook inserted package: $trackingNumber");
            return true;
        }
    }
}

function process_shipment_created($shipment, $conn)
{
    $shipmentNumber   = $shipment['shipmentNumber'] ?? '';
    $type             = $shipment['type'] ?? '';
    $origin           = $shipment['origin'] ?? '';
    $destination      = $shipment['destination'] ?? '';
    $description      = $shipment['description'] ?? '';
    $grossRevenue     = $shipment['grossRevenue'] ?? 0;
    $totalPackages    = $shipment['totalPackages'] ?? 0;
    $totalWeight      = $shipment['totalWeight'] ?? 0;
    $volume           = $shipment['volume'] ?? 0;
    $userId           = $shipment['userId'] ?? null;
    $departureDate    = $shipment['departureDate'] ?? null;
    $arrivalDate      = $shipment['arrivalDate'] ?? null;
    $status           = $shipment['status'] ?? 'Preparing';
    $shipmentSimpleId = $shipment['shipmentSimpleId'] ?? null;
    $shipmentStatus   = $shipment['shipmentStatus'] ?? null;

    $sqlCheck = "SELECT id FROM shipments WHERE shipment_number = '" . mysqli_real_escape_string($conn, $shipmentNumber) . "'";
    $resCheck = mysqli_query($conn, $sqlCheck);
    if (mysqli_num_rows($resCheck) > 0) {
        $row       = mysqli_fetch_assoc($resCheck);
        $sqlUpdate = "UPDATE shipments SET
            type = '" . mysqli_real_escape_string($conn, $type) . "',
            origin = '" . mysqli_real_escape_string($conn, $origin) . "',
            destination = '" . mysqli_real_escape_string($conn, $destination) . "',
            description = '" . mysqli_real_escape_string($conn, $description) . "',
            gross_revenue = " . floatval($grossRevenue) . ",
            total_packages = " . intval($totalPackages) . ",
            total_weight = " . floatval($totalWeight) . ",
            volume = " . floatval($volume) . ",
            user_id = " . ($userId !== null ? intval($userId) : "NULL") . ",
            departure_date = " . ($departureDate !== null ? "'" . mysqli_real_escape_string($conn, $departureDate) . "'" : "NULL") . ",
            arrival_date = " . ($arrivalDate !== null ? "'" . mysqli_real_escape_string($conn, $arrivalDate) . "'" : "NULL") . ",
            status = '" . mysqli_real_escape_string($conn, $status) . "',
            shipmentSimpleId = " . ($shipmentSimpleId !== null ? "'" . mysqli_real_escape_string($conn, $shipmentSimpleId) . "'" : "NULL") . ",
            shipmentStatus = " . ($shipmentStatus !== null ? "'" . mysqli_real_escape_string($conn, $shipmentStatus) . "'" : "NULL") . "
            WHERE id = " . intval($row['id']);
        $updateResult = mysqli_query($conn, $sqlUpdate);
        if (! $updateResult) {
            error_log("Warehouse API webhook DB update error: " . mysqli_error($conn) . " for shipment: $shipmentNumber");
            return false;
        } else {
            error_log("Warehouse API webhook updated shipment: $shipmentNumber");
            return true;
        }
    } else {
        $sqlInsert = "INSERT INTO shipments
            (shipment_number, type, origin, destination, description, gross_revenue, total_packages, total_weight, volume, user_id, departure_date, arrival_date, status, shipmentSimpleId, shipmentStatus) VALUES (
            '" . mysqli_real_escape_string($conn, $shipmentNumber) . "',
            '" . mysqli_real_escape_string($conn, $type) . "',
            '" . mysqli_real_escape_string($conn, $origin) . "',
            '" . mysqli_real_escape_string($conn, $destination) . "',
            '" . mysqli_real_escape_string($conn, $description) . "',
            " . floatval($grossRevenue) . ",
            " . intval($totalPackages) . ",
            " . floatval($totalWeight) . ",
            " . floatval($volume) . ",
            " . ($userId !== null ? intval($userId) : "NULL") . ",
            " . ($departureDate !== null ? "'" . mysqli_real_escape_string($conn, $departureDate) . "'" : "NULL") . ",
            " . ($arrivalDate !== null ? "'" . mysqli_real_escape_string($conn, $arrivalDate) . "'" : "NULL") . ",
            '" . mysqli_real_escape_string($conn, $status) . "',
            " . ($shipmentSimpleId !== null ? "'" . mysqli_real_escape_string($conn, $shipmentSimpleId) . "'" : "NULL") . ",
            " . ($shipmentStatus !== null ? "'" . mysqli_real_escape_string($conn, $shipmentStatus) . "'" : "NULL") . "
            )";
        $insertResult = mysqli_query($conn, $sqlInsert);
        if (! $insertResult) {
            error_log("Warehouse API webhook DB insert error: " . mysqli_error($conn) . " for shipment: $shipmentNumber");
            return false;
        } else {
            error_log("Warehouse API webhook inserted shipment: $shipmentNumber");
            return true;
        }
    }
}

function process_package_added_to_shipment($package, $shipment, $conn)
{
    $trackingNumber    = $package['tracking'] ?? '';
    $shipmentId        = $shipment['id'] ?? null;
    $addedToShipmentAt = $package['addedToShipmentAt'] ?? null;

    if (empty($trackingNumber) || $shipmentId === null) {
        error_log("Warehouse API webhook: Missing tracking or shipmentId for package.added.to.shipment");
        return false;
    }

    // Find the shipment DB id by shipmentSimpleId
    $shipment_db_id  = null;
    $sql_shipment    = "SELECT id FROM shipments WHERE shipmentSimpleId = '" . mysqli_real_escape_string($conn, $shipmentId) . "' LIMIT 1";
    $result_shipment = mysqli_query($conn, $sql_shipment);
    if ($result_shipment && mysqli_num_rows($result_shipment) > 0) {
        $row_shipment   = mysqli_fetch_assoc($result_shipment);
        $shipment_db_id = intval($row_shipment['id']);
    } else {
        error_log("Warehouse API webhook: Shipment not found for shipmentSimpleId: $shipmentId");
        return false;
    }

    $added_to_shipment_at_value = "NULL";
    if ($addedToShipmentAt !== null) {
        try {
            $dt                         = new DateTime($addedToShipmentAt);
            $added_to_shipment_at_value = "'" . $dt->format('Y-m-d H:i:s') . "'";
        } catch (Exception $e) {
            $added_to_shipment_at_value = "NULL";
        }
    }

    $sqlUpdate = "UPDATE packages SET
        shipment_id = " . $shipment_db_id . ",
        added_to_shipment_at = " . $added_to_shipment_at_value . "
        WHERE tracking_number = '" . mysqli_real_escape_string($conn, $trackingNumber) . "'";
    $updateResult = mysqli_query($conn, $sqlUpdate);
    if (! $updateResult) {
        error_log("Warehouse API webhook DB update error: " . mysqli_error($conn) . " for tracking: $trackingNumber");
        return false;
    } else {
        error_log("Warehouse API webhook updated package shipment: $trackingNumber");
        return true;
    }
}

function process_package_updated($package, $conn)
{
    // Similar to created, but update if exists, else insert
    $trackingNumber = $package['tracking'] ?? '';
    if (empty($trackingNumber)) {
        error_log("Warehouse API webhook: Missing tracking for package.updated");
        return false;
    }

    $sqlCheck = "SELECT id FROM packages WHERE tracking_number = '" . mysqli_real_escape_string($conn, $trackingNumber) . "'";
    $resCheck = mysqli_query($conn, $sqlCheck);
    if (mysqli_num_rows($resCheck) > 0) {
        // Update existing
        $row = mysqli_fetch_assoc($resCheck);
        // Extract fields
        $courierCompany     = $package['courierName'] ?? '';
        $description        = $package['description'] ?? '';
        $weight             = $package['weight'] ?? 0;
        $trackingName       = $package['trackingName'] ?? '';
        $dimLength          = $package['dimLength'] ?? null;
        $dimWidth           = $package['dimWidth'] ?? null;
        $dimHeight          = $package['dimHeight'] ?? null;
        $shipmentStatus     = $package['shipmentStatus'] ?? '';
        $shipmentType       = $package['shipmentType'] ?? '';
        $branch             = $package['branch'] ?? '';
        $tag                = $package['tag'] ?? '';
        $courierId          = $package['courierId'] ?? null;
        $courierCustomerId  = $package['courierCustomerId'] ?? null;
        $shipmentSimpleId   = $package['shipmentSimpleId'] ?? null;
        $warehousePackageId = $package['id'] ?? null;

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
            courier_id = " . ($courierId !== null ? "'" . mysqli_real_escape_string($conn, $courierId) . "'" : "NULL") . ",
            courier_customer_id = " . ($courierCustomerId !== null ? "'" . mysqli_real_escape_string($conn, $courierCustomerId) . "'" : "NULL") . ",
            shipment_simple_id = " . ($shipmentSimpleId !== null ? "'" . mysqli_real_escape_string($conn, $shipmentSimpleId) . "'" : "NULL") . ",
            warehouse_package_id = " . ($warehousePackageId !== null ? "'" . mysqli_real_escape_string($conn, $warehousePackageId) . "'" : "NULL") . "
            WHERE id = " . intval($row['id']);
        $updateResult = mysqli_query($conn, $sqlUpdate);
        if (! $updateResult) {
            error_log("Warehouse API webhook DB update error: " . mysqli_error($conn) . " for tracking: $trackingNumber");
            return false;
        } else {
            error_log("Warehouse API webhook updated package: $trackingNumber");
            return true;
        }
    } else {
        // Insert new, call created
        return process_package_created($package, $conn);
    }
}

function process_package_deleted($package, $conn)
{
    $trackingNumber = $package['tracking'] ?? '';
    if (empty($trackingNumber)) {
        error_log("Warehouse API webhook: Missing tracking for package.deleted");
        return false;
    }

    $sqlUpdate    = "UPDATE packages SET shipment_status = 'Deleted' WHERE tracking_number = '" . mysqli_real_escape_string($conn, $trackingNumber) . "'";
    $updateResult = mysqli_query($conn, $sqlUpdate);
    if (! $updateResult) {
        error_log("Warehouse API webhook DB update error: " . mysqli_error($conn) . " for tracking: $trackingNumber");
        return false;
    } else {
        error_log("Warehouse API webhook marked package as deleted: $trackingNumber");
        return true;
    }
}

function process_package_removed_from_shipment($package, $conn)
{
    $trackingNumber = $package['tracking'] ?? '';
    if (empty($trackingNumber)) {
        error_log("Warehouse API webhook: Missing tracking for package.removed.from.shipment");
        return false;
    }

    $sqlUpdate    = "UPDATE packages SET shipment_id = NULL, added_to_shipment_at = NULL WHERE tracking_number = '" . mysqli_real_escape_string($conn, $trackingNumber) . "'";
    $updateResult = mysqli_query($conn, $sqlUpdate);
    if (! $updateResult) {
        error_log("Warehouse API webhook DB update error: " . mysqli_error($conn) . " for tracking: $trackingNumber");
        return false;
    } else {
        error_log("Warehouse API webhook removed package from shipment: $trackingNumber");
        return true;
    }
}

function process_package_change_ownership($package, $conn)
{
    $trackingNumber = $package['tracking'] ?? '';
    $accountId      = $package['accountId'] ?? '';
    if (empty($trackingNumber) || empty($accountId)) {
        error_log("Warehouse API webhook: Missing tracking or accountId for package.change.ownership");
        return false;
    }

    $user_id = 0;
    $sqlUser = "SELECT id FROM users WHERE account_number = '" . mysqli_real_escape_string($conn, $accountId) . "' LIMIT 1";
    $resUser = mysqli_query($conn, $sqlUser);
    if ($resUser && mysqli_num_rows($resUser) > 0) {
        $rowUser = mysqli_fetch_assoc($resUser);
        $user_id = $rowUser['id'];
    }

    if ($user_id == 0) {
        error_log("Warehouse API webhook: No user found for accountId: $accountId");
        return false;
    }

    $sqlUpdate    = "UPDATE packages SET user_id = " . intval($user_id) . " WHERE tracking_number = '" . mysqli_real_escape_string($conn, $trackingNumber) . "'";
    $updateResult = mysqli_query($conn, $sqlUpdate);
    if (! $updateResult) {
        error_log("Warehouse API webhook DB update error: " . mysqli_error($conn) . " for tracking: $trackingNumber");
        return false;
    } else {
        error_log("Warehouse API webhook changed ownership for package: $trackingNumber to user: $user_id");
        return true;
    }
}

function process_shipment_updated($shipment, $conn)
{
    // Similar to created, update if exists, else insert
    $shipmentId = $shipment['id'] ?? '';
    if (empty($shipmentId)) {
        error_log("Warehouse API webhook: Missing id for shipment.updated");
        return false;
    }

    $sqlCheck = "SELECT id FROM shipments WHERE shipmentSimpleId = '" . mysqli_real_escape_string($conn, $shipmentId) . "' LIMIT 1";
    $resCheck = mysqli_query($conn, $sqlCheck);
    if (mysqli_num_rows($resCheck) > 0) {
        // Update existing
        $type             = $shipment['ShipmentType'] ?? $shipment['type'] ?? '';
        $origin           = $shipment['origin'] ?? '';
        $destination      = $shipment['destination'] ?? '';
        $description      = $shipment['description'] ?? '';
        $grossRevenue     = $shipment['grossRevenue'] ?? 0;
        $totalPackages    = $shipment['totalPackages'] ?? 0;
        $totalWeight      = $shipment['totalWeight'] ?? 0;
        $volume           = $shipment['volume'] ?? 0;
        $departureDate    = $shipment['departureDate'] ?? null;
        $arrivalDate      = $shipment['arrivalDate'] ?? null;
        $status           = $shipment['status'] ?? 'Preparing';
        $shipmentSimpleId = $shipment['simpleId'] ?? $shipment['shipmentSimpleId'] ?? null;
        $shipmentStatus   = $shipment['ShipmentType'] ?? $shipment['shipmentStatus'] ?? null;

        $sqlUpdate = "UPDATE shipments SET
            type = '" . mysqli_real_escape_string($conn, $type) . "',
            origin = '" . mysqli_real_escape_string($conn, $origin) . "',
            destination = '" . mysqli_real_escape_string($conn, $destination) . "',
            description = '" . mysqli_real_escape_string($conn, $description) . "',
            gross_revenue = " . floatval($grossRevenue) . ",
            total_packages = " . intval($totalPackages) . ",
            total_weight = " . floatval($totalWeight) . ",
            volume = " . floatval($volume) . ",
            departure_date = " . ($departureDate !== null ? "'" . mysqli_real_escape_string($conn, $departureDate) . "'" : "NULL") . ",
            arrival_date = " . ($arrivalDate !== null ? "'" . mysqli_real_escape_string($conn, $arrivalDate) . "'" : "NULL") . ",
            status = '" . mysqli_real_escape_string($conn, $status) . "',
            shipmentSimpleId = " . ($shipmentSimpleId !== null ? "'" . mysqli_real_escape_string($conn, $shipmentSimpleId) . "'" : "NULL") . ",
            shipmentStatus = " . ($shipmentStatus !== null ? "'" . mysqli_real_escape_string($conn, $shipmentStatus) . "'" : "NULL") . "
            WHERE shipmentSimpleId = '" . mysqli_real_escape_string($conn, $shipmentId) . "'";
        $updateResult = mysqli_query($conn, $sqlUpdate);
        if (! $updateResult) {
            error_log("Warehouse API webhook DB update error: " . mysqli_error($conn) . " for shipment: $shipmentId");
            return false;
        } else {
            error_log("Warehouse API webhook updated shipment: $shipmentId");
            return true;
        }
    } else {
        // Insert new
        return process_shipment_created($shipment, $conn);
    }
}

function process_shipment_deleted($shipment, $conn)
{
    $shipmentId = $shipment['id'] ?? '';
    if (empty($shipmentId)) {
        error_log("Warehouse API webhook: Missing id for shipment.deleted");
        return false;
    }

    $sqlUpdate    = "UPDATE shipments SET status = 'Deleted' WHERE shipmentSimpleId = '" . mysqli_real_escape_string($conn, $shipmentId) . "'";
    $updateResult = mysqli_query($conn, $sqlUpdate);
    if (! $updateResult) {
        error_log("Warehouse API webhook DB update error: " . mysqli_error($conn) . " for shipment: $shipmentId");
        return false;
    } else {
        error_log("Warehouse API webhook marked shipment as deleted: $shipmentId");
        return true;
    }
}

if (isset($_GET['webhook']) && $_GET['webhook'] === 'package_update') {
    // Read the raw input data
    $input = file_get_contents('php://input');

    // Fallback to GET data if input is empty and method is GET
    if (empty($input) && $_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['data'])) {
        $input = $_GET['data'];
    }

    // Support for payload in GET parameter
    if (empty($input) && isset($_GET['payload'])) {
        $input = $_GET['payload'];
    }

    // Support for form-encoded payload
    if (empty($input) && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['payload'])) {
        $input = $_POST['payload'];
    }

                                        // Log the request to file
    $timestamp = date('Y-m-d\TH:i:sP'); // ISO 8601 format
    $method    = $_SERVER['REQUEST_METHOD'];
    $headers   = getallheaders(); // Get all headers
    $body      = $input;

    $log_entry = $timestamp . " - METHOD: " . $method . "\n";
    $log_entry .= "HEADERS: " . print_r($headers, true) . "\n";
    $log_entry .= "BODY: " . $body . "\n\n";

    file_put_contents('webhook_log.txt', $log_entry, FILE_APPEND);

    // Process all events in the log file
    global $conn;
    if (! isset($conn) || ! $conn) {
        error_log("Webhook: Database connection not available");
        http_response_code(500);
        echo json_encode(['error' => 'Database connection failed']);
        exit;
    }

    $log_content     = file_get_contents('webhook_log.txt');
    $entries         = explode("\n\n", trim($log_content));
    $processed_count = 0;
    $errors          = [];

    foreach ($entries as $entry) {
        if (empty(trim($entry))) {
            continue;
        }

        // Extract BODY from entry
        $lines     = explode("\n", $entry);
        $body_line = '';
        $in_body   = false;
        foreach ($lines as $line) {
            if (strpos($line, 'BODY: ') === 0) {
                $body_line = substr($line, 6);
                $in_body   = true;
            } elseif ($in_body) {
                $body_line .= "\n" . $line;
            }
        }

        if (empty($body_line)) {
            continue;
        }

        $data = json_decode($body_line, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $errors[] = 'Invalid JSON in log entry: ' . json_last_error_msg();
            continue;
        }

        $event     = $data['event'] ?? '';
        $processed = false;

        if ($event === 'package.created') {
            $package = $data['package'] ?? [];
            if (! empty($package)) {
                $processed = process_package_created($package, $conn);
            }
        } elseif ($event === 'package.updated') {
            $package = $data['package'] ?? [];
            if (! empty($package)) {
                $processed = process_package_updated($package, $conn);
            }
        } elseif ($event === 'package.deleted') {
            $package = $data['package'] ?? [];
            if (! empty($package)) {
                $processed = process_package_deleted($package, $conn);
            }
        } elseif ($event === 'package.added.to.shipment') {
            $package  = $data['package'] ?? [];
            $shipment = $data['shipment'] ?? [];
            if (! empty($package) && ! empty($shipment)) {
                $processed = process_package_added_to_shipment($package, $shipment, $conn);
            }
        } elseif ($event === 'package.removed.from.shipment') {
            $package = $data['package'] ?? [];
            if (! empty($package)) {
                $processed = process_package_removed_from_shipment($package, $conn);
            }
        } elseif ($event === 'package.change.ownership') {
            $package = $data['package'] ?? [];
            if (! empty($package)) {
                $processed = process_package_change_ownership($package, $conn);
            }
        } elseif ($event === 'shipment.created') {
            $shipment = $data['shipment'] ?? [];
            if (! empty($shipment)) {
                $processed = process_shipment_created($shipment, $conn);
            }
        } elseif ($event === 'shipment.updated') {
            $shipment = $data['shipment'] ?? [];
            if (! empty($shipment)) {
                $processed = process_shipment_updated($shipment, $conn);
            }
        } elseif ($event === 'shipment.deleted') {
            $shipment = $data['shipment'] ?? [];
            if (! empty($shipment)) {
                $processed = process_shipment_deleted($shipment, $conn);
            }
        }

        if ($processed) {
            $processed_count++;
        } else {
            $errors[] = 'Failed to process event: ' . $event;
        }
    }

    // Clear the log file after processing
    if (file_exists('webhook_log.txt')) {
        file_put_contents('webhook_log.txt', '');
        // unlink('webhook_log.txt');
    }

    http_response_code(200);
    echo json_encode([
        'status'           => 'success',
        'processed_events' => $processed_count,
        'errors'           => $errors,
    ]);
    exit;
}
