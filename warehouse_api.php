<?php
include_once 'config.php';
include_once __DIR__ . '/function.php'; // for DB connection
include_once __DIR__ . '/admin-dashboard/CacheManager.php';        // Include cache manager

// Configuration constants for API handling
define('API_MAX_RETRIES', 3);
define('API_RETRY_DELAY', 1);      // seconds
define('API_TIMEOUT', 30);         // seconds
define('API_CONNECT_TIMEOUT', 10); // seconds
define('API_CACHE_TTL', 300);      // 5 minutes cache for API responses
define('API_RATE_LIMIT_MAX', 50);  // Max requests per minute

/**
 * Enhanced logging function with structured data
 */
function log_api_interaction($function_name, $level, $message, $context = [])
{
    $timestamp = date('Y-m-d H:i:s');
    $log_entry = "[$timestamp] [$level] $function_name: $message";

    if (! empty($context)) {
        $log_entry .= " | Context: " . json_encode($context);
    }

    error_log($log_entry);

    // Also log to a dedicated API log file
    $log_file = __DIR__ . '/logs/api_interactions.log';
    $log_dir  = dirname($log_file);
    if (! is_dir($log_dir)) {
        mkdir($log_dir, 0755, true);
    }
    file_put_contents($log_file, $log_entry . PHP_EOL, FILE_APPEND);
}

/**
 * Validate API response structure
 */
function validate_api_response($response, $expected_keys = [])
{
    if (! is_array($response)) {
        return ['valid' => false, 'error' => 'Response is not an array'];
    }

    if (isset($response['error'])) {
        return ['valid' => false, 'error' => $response['error']];
    }

    foreach ($expected_keys as $key) {
        if (! isset($response[$key])) {
            return ['valid' => false, 'error' => "Missing required key: $key"];
        }
    }

    return ['valid' => true];
}

/**
 * Batch process multiple API requests to reduce overhead
 */
function batch_api_requests($requests, $batch_size = 5)
{
    $results = [];
    $batches = array_chunk($requests, $batch_size);

    foreach ($batches as $batch_index => $batch) {
        log_api_interaction('batch_api_requests', 'INFO', "Processing batch " . ($batch_index + 1) . " of " . count($batches), [
            'batch_size'    => count($batch),
            'total_batches' => count($batches),
        ]);

        // Process each request in the batch
        foreach ($batch as $request_index => $request) {
            $request_id = $request['id'] ?? "batch_{$batch_index}_{$request_index}";

            try {
                $result = make_api_request(
                    $request['url'],
                    $request['method'] ?? 'POST',
                    $request['payload'] ?? null,
                    $request['headers'] ?? [],
                    $request['expected_keys'] ?? [],
                    $request['use_cache'] ?? true,
                    $request['cache_ttl'] ?? null
                );

                $results[$request_id] = $result;

                // Add small delay between requests to avoid overwhelming the API
                if ($request_index < count($batch) - 1) {
                    usleep(100000); // 0.1 seconds
                }

            } catch (Exception $e) {
                log_api_interaction('batch_api_requests', 'ERROR', 'Exception in batch request', [
                    'request_id' => $request_id,
                    'error'      => $e->getMessage(),
                ]);

                $results[$request_id] = [
                    'success' => false,
                    'error'   => 'Exception: ' . $e->getMessage(),
                ];
            }
        }

        // Add delay between batches to respect rate limits
        if ($batch_index < count($batches) - 1) {
            sleep(1); // 1 second between batches
        }
    }

    return $results;
}

/**
 * Batch update customer data to warehouse API
 */
function batch_update_customers($customers, $batch_size = 10)
{
    if (empty($customers)) {
        return ['success' => true, 'message' => 'No customers to update'];
    }

    $requests = [];
    foreach ($customers as $index => $customer) {
        if (! isset($customer['warehouse_customer_id']) || ! isset($customer['first_name'])) {
            continue; // Skip invalid customers
        }

        $data = [
            'id'        => $customer['warehouse_customer_id'],
            'firstName' => $customer['first_name'],
            'lastName'  => $customer['last_name'] ?? '',
            'accountId' => strtoupper($customer['account_number']),
            'branch'    => $customer['region'] ?? 'Unknown',
        ];

        $payload = json_encode($data);
        if ($payload === false) {
            continue; // Skip if JSON encoding fails
        }

        $requests[] = [
            'id' => "customer_update_{$index}",
            'url'           => WAREHOUSE_API_URL . '/public.v1.PublicService/UpdateCourierCustomer',
            'method'        => 'POST',
            'payload'       => $payload,
            'headers'       => [
                'Content-Type: application/json',
                'X-Logis-Auth: ' . WAREHOUSE_API_KEY,
            ],
            'expected_keys' => [],
            'use_cache'     => false, // Don't cache updates
        ];
    }

    $batch_results = batch_api_requests($requests, $batch_size);

    $success_count = 0;
    $error_count   = 0;
    $errors        = [];

    foreach ($batch_results as $request_id => $result) {
        if ($result['success']) {
            $success_count++;
        } else {
            $error_count++;
            $errors[] = "Failed to update customer {$request_id}: " . ($result['error'] ?? 'Unknown error');
        }
    }

    log_api_interaction('batch_update_customers', 'INFO', 'Batch customer update completed', [
        'total_customers'    => count($customers),
        'successful_updates' => $success_count,
        'failed_updates'     => $error_count,
    ]);

    return [
        'success'         => $error_count === 0,
        'total_processed' => count($customers),
        'successful'      => $success_count,
        'failed'          => $error_count,
        'errors'          => $errors,
    ];
}

/**
 * Make API request with retry mechanism and enhanced error handling
 */
function make_api_request($url, $method = 'POST', $payload = null, $headers = [], $expected_keys = [])
{
    $cache       = new CacheManager();
    $rateLimiter = new RateLimiter(API_RATE_LIMIT_MAX, 60);

    // Use URL + payload as cache key
    $cache_key = md5($url . ($payload ?? ''));

    // Check cache first
    $cached_response = $cache->get($cache_key);
    if ($cached_response !== false) {
        log_api_interaction('make_api_request', 'INFO', 'Returning cached response', ['url' => $url]);
        return ['success' => true, 'result' => $cached_response];
    }

                            // Check rate limit
    $client_id = 'default'; // Could be enhanced to identify clients uniquely
    if (! $rateLimiter->isAllowed($client_id)) {
        $error_msg = 'Rate limit exceeded';
        log_api_interaction('make_api_request', 'ERROR', $error_msg, ['url' => $url]);
        return ['success' => false, 'error' => $error_msg];
    }

    $retries    = 0;
    $last_error = '';

    while ($retries < API_MAX_RETRIES) {
        try {
            $ch = curl_init();

            // Set basic options
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, API_TIMEOUT);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, API_CONNECT_TIMEOUT);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);

            // Set method-specific options
            if ($method === 'POST') {
                curl_setopt($ch, CURLOPT_POST, true);
                if ($payload !== null) {
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
                }
            } elseif ($method === 'GET') {
                curl_setopt($ch, CURLOPT_HTTPGET, true);
            }

            // Set headers
            if (! empty($headers)) {
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            }

            // Execute request
            $response   = curl_exec($ch);
            $http_code  = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            $curl_error = curl_error($ch);
            $curl_errno = curl_errno($ch);

            curl_close($ch);

            // Handle cURL errors
            if ($curl_errno !== 0) {
                $last_error = "cURL error ($curl_errno): $curl_error";
                log_api_interaction('make_api_request', 'ERROR', $last_error, [
                    'url'    => $url,
                    'method' => $method,
                    'retry'  => $retries + 1,
                ]);

                if ($retries < API_MAX_RETRIES - 1) {
                    sleep(API_RETRY_DELAY * ($retries + 1)); // Exponential backoff
                    $retries++;
                    continue;
                }
                return ['success' => false, 'error' => $last_error, 'http_code' => $http_code];
            }

            // Handle HTTP errors
            if ($http_code < 200 || $http_code >= 300) {
                $last_error = "HTTP error: $http_code";
                log_api_interaction('make_api_request', 'ERROR', $last_error, [
                    'url'      => $url,
                    'method'   => $method,
                    'response' => substr($response, 0, 500),
                    'retry'    => $retries + 1,
                ]);

                // Retry on server errors (5xx) but not on client errors (4xx)
                if ($http_code >= 500 && $retries < API_MAX_RETRIES - 1) {
                    sleep(API_RETRY_DELAY * ($retries + 1));
                    $retries++;
                    continue;
                }
                return ['success' => false, 'error' => $last_error, 'http_code' => $http_code, 'response' => $response];
            }

            // Parse JSON response
            $result = json_decode($response, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                $last_error = "JSON decode error: " . json_last_error_msg();
                log_api_interaction('make_api_request', 'ERROR', $last_error, [
                    'url'      => $url,
                    'method'   => $method,
                    'response' => substr($response, 0, 500),
                ]);
                return ['success' => false, 'error' => $last_error, 'response' => $response];
            }

            // Validate response structure
            $validation = validate_api_response($result, $expected_keys);
            if (! $validation['valid']) {
                log_api_interaction('make_api_request', 'ERROR', $validation['error'], [
                    'url'    => $url,
                    'method' => $method,
                    'result' => $result,
                ]);
                return ['success' => false, 'error' => $validation['error'], 'result' => $result];
            }

            // Cache successful response
            $cache->set($cache_key, $result, API_CACHE_TTL);

            log_api_interaction('make_api_request', 'INFO', 'Request successful', [
                'url'       => $url,
                'method'    => $method,
                'http_code' => $http_code,
            ]);

            return ['success' => true, 'result' => $result, 'http_code' => $http_code];

        } catch (Exception $e) {
            $last_error = "Exception: " . $e->getMessage();
            log_api_interaction('make_api_request', 'ERROR', $last_error, [
                'url'    => $url,
                'method' => $method,
                'retry'  => $retries + 1,
            ]);

            if ($retries < API_MAX_RETRIES - 1) {
                sleep(API_RETRY_DELAY * ($retries + 1));
                $retries++;
                continue;
            }
            return ['success' => false, 'error' => $last_error];
        }
    }

    return ['success' => false, 'error' => $last_error];

}
// Function to push customer data to warehouse API
function push_customer_to_warehouse($customer)
{
    try {
        // Validate input data
        if (! isset($customer['first_name']) || ! isset($customer['last_name']) || ! isset($customer['account_number'])) {
            log_api_interaction('push_customer_to_warehouse', 'ERROR', 'Missing required customer data');
            return ['success' => false, 'error' => 'Missing required customer data'];
        }

        $data = [
            'firstName' => $customer['first_name'],
            'lastName'  => $customer['last_name'],
            'accountId' => strtoupper($customer['account_number']),
            'branch'    => $customer['region'] ?? 'Unknown',
        ];

        $payload = json_encode($data);
        if ($payload === false) {
            log_api_interaction('push_customer_to_warehouse', 'ERROR', 'Failed to encode JSON payload');
            return ['success' => false, 'error' => 'Failed to encode JSON payload'];
        }

        $url     = WAREHOUSE_API_URL . '/public.v1.PublicService/CreateCourierCustomer';
        $headers = [
            'Content-Type: application/json',
            'X-Logis-Auth: ' . WAREHOUSE_API_KEY,
        ];

        $api_response = make_api_request($url, 'POST', $payload, $headers, ['customer']);

        if (! $api_response['success']) {
            return $api_response;
        }

        $result = $api_response['result'];

        // Save warehouse_customer_id if successful
        if (isset($result['customer']) && isset($result['customer']['id'])) {
            global $conn;
            $warehouse_customer_id = $result['customer']['id'];
            $update_sql            = "UPDATE users SET warehouse_customer_id = ? WHERE id = ?";
            $stmt                  = mysqli_prepare($conn, $update_sql);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "si", $warehouse_customer_id, $customer['id']);
                if (mysqli_stmt_execute($stmt)) {
                    log_api_interaction('push_customer_to_warehouse', 'INFO', 'Saved warehouse_customer_id', [
                        'customer_id'           => $customer['id'],
                        'warehouse_customer_id' => $warehouse_customer_id,
                    ]);
                    mysqli_stmt_close($stmt);
                    return ['success' => true, 'result' => $result];
                } else {
                    $db_error = mysqli_stmt_error($stmt);
                    log_api_interaction('push_customer_to_warehouse', 'ERROR', 'Failed to save warehouse_customer_id', [
                        'error'       => $db_error,
                        'customer_id' => $customer['id'],
                    ]);
                    mysqli_stmt_close($stmt);
                    return ['success' => false, 'error' => 'Database update failed: ' . $db_error];
                }
            } else {
                $db_error = mysqli_error($conn);
                log_api_interaction('push_customer_to_warehouse', 'ERROR', 'Failed to prepare database statement', [
                    'error' => $db_error,
                ]);
                return ['success' => false, 'error' => 'Database prepare failed: ' . $db_error];
            }
        }

        return ['success' => true, 'result' => $result];

    } catch (Exception $e) {
        log_api_interaction('push_customer_to_warehouse', 'ERROR', 'Exception occurred', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);
        return ['success' => false, 'error' => 'Exception: ' . $e->getMessage()];
    }
}

// Function to update customer data in warehouse API
function update_courier_customer($customer)
{
    try {
        // Validate input data
        if (! isset($customer['warehouse_customer_id']) || ! isset($customer['first_name']) ||
            ! isset($customer['last_name']) || ! isset($customer['account_number'])) {
            log_api_interaction('update_courier_customer', 'ERROR', 'Missing required customer data');
            return ['success' => false, 'error' => 'Missing required customer data'];
        }

        // Validate warehouse_customer_id is not empty
        if (empty($customer['warehouse_customer_id'])) {
            log_api_interaction('update_courier_customer', 'ERROR', 'Invalid warehouse_customer_id');
            return ['success' => false, 'error' => 'Invalid warehouse_customer_id'];
        }

        $data = [
            'id'        => $customer['warehouse_customer_id'],
            'firstName' => $customer['first_name'],
            'lastName'  => $customer['last_name'],
            'accountId' => strtoupper($customer['account_number']),
            'branch'    => $customer['region'] ?? 'Unknown',
        ];

        $payload = json_encode($data);
        if ($payload === false) {
            log_api_interaction('update_courier_customer', 'ERROR', 'Failed to encode JSON payload');
            return ['success' => false, 'error' => 'Failed to encode JSON payload'];
        }

        $url     = WAREHOUSE_API_URL . '/public.v1.PublicService/UpdateCourierCustomer';
        $headers = [
            'Content-Type: application/json',
            'X-Logis-Auth: ' . WAREHOUSE_API_KEY,
        ];

        $api_response = make_api_request($url, 'POST', $payload, $headers);

        if (! $api_response['success']) {
            return $api_response;
        }

        $result = $api_response['result'];

        // Save warehouse_customer_id if returned (for cases where it might change)
        if (isset($result['success']) && $result['success'] && isset($result['customer_id'])) {
            global $conn;
            $warehouse_customer_id = $result['customer_id'];
            $update_sql            = "UPDATE users SET warehouse_customer_id = ? WHERE id = ?";
            $stmt                  = mysqli_prepare($conn, $update_sql);

            if ($stmt) {
                mysqli_stmt_bind_param($stmt, "si", $warehouse_customer_id, $customer['id']);
                if (mysqli_stmt_execute($stmt)) {
                    log_api_interaction('update_courier_customer', 'INFO', 'Updated warehouse_customer_id', [
                        'customer_id'           => $customer['id'],
                        'warehouse_customer_id' => $warehouse_customer_id,
                    ]);
                    mysqli_stmt_close($stmt);
                    return ['success' => true, 'result' => $result];
                } else {
                    $db_error = mysqli_stmt_error($stmt);
                    log_api_interaction('update_courier_customer', 'ERROR', 'Failed to update warehouse_customer_id', [
                        'error'       => $db_error,
                        'customer_id' => $customer['id'],
                    ]);
                    mysqli_stmt_close($stmt);
                    return ['success' => false, 'error' => 'Database update failed: ' . $db_error];
                }
            } else {
                $db_error = mysqli_error($conn);
                log_api_interaction('update_courier_customer', 'ERROR', 'Failed to prepare database statement', [
                    'error' => $db_error,
                ]);
                return ['success' => false, 'error' => 'Database prepare failed: ' . $db_error];
            }
        }

        return ['success' => true, 'result' => $result];

    } catch (Exception $e) {
        log_api_interaction('update_courier_customer', 'ERROR', 'Exception occurred', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ]);
        return ['success' => false, 'error' => 'Exception: ' . $e->getMessage()];
    }
}

// Function to pull shipments data from warehouse API and update local shipments table
function pull_shipments_from_warehouse($limit = 10)
{
    global $conn;

    $cursor  = '';
    $hasMore = true;

    while ($hasMore) {
        $payload = json_encode([
            'cursor' => $cursor,
            'limit'  => $limit,
        ]);

        $ch = curl_init(WAREHOUSE_API_URL . '/public.v1.PublicService/ListShipments');  
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
            error_log("Warehouse API pull_shipments_from_warehouse curl error: $err");
            return false;
        }

        if ($http_code !== 200) {
            error_log("Warehouse API pull_shipments_from_warehouse HTTP error: $http_code, Response: $response");
            return false;
        }

        $result = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            error_log("Warehouse API pull_shipments_from_warehouse JSON decode error: " . json_last_error_msg() . ", Response: $response");
            return false;
        }

        if (! isset($result['shipments'])) {
            error_log("Warehouse API pull_shipments_from_warehouse invalid response structure, missing 'shipments' key. Response: " . json_encode($result));
            return false;
        }

        foreach ($result['shipments'] as $shipment) {
            $shipmentNumber   = $shipment['id'] ?? '';
            $type             = $shipment['ShipmentType'] ?? '';
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
            $shipmentSimpleId = $shipment['simpleId'] ?? null;
            $shipmentStatus   = $shipment['ShipmentType'] ?? null;

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
                    error_log("Warehouse API pull_shipments_from_warehouse DB update error: " . mysqli_error($conn) . " for shipment: $shipmentNumber");
                } else {
                    error_log("Warehouse API pull_shipments_from_warehouse updated shipment: $shipmentNumber");
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
                    error_log("Warehouse API pull_shipments_from_warehouse DB insert error: " . mysqli_error($conn) . " for shipment: $shipmentNumber");
                } else {
                    error_log("Warehouse API pull_shipments_from_warehouse inserted shipment: $shipmentNumber");
                }
            }
        }

        $cursor  = $result['nextCursor'] ?? '';
        $hasMore = ! empty($cursor);
    }

    return true;
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

            // Get store from pre-alert merchant
            $store = '-';
            if (! empty($trackingNumber) && isset($user_id) && $user_id > 0) {
                $sqlPreAlert = "SELECT Merchant FROM pre_alert WHERE Tracking_Number = '" . mysqli_real_escape_string($conn, $trackingNumber) . "' AND User_id = " . intval($user_id) . " LIMIT 1";
                $resPreAlert = mysqli_query($conn, $sqlPreAlert);
                if ($resPreAlert && mysqli_num_rows($resPreAlert) > 0) {
                    $rowPreAlert = mysqli_fetch_assoc($resPreAlert);
                    $store       = $rowPreAlert['Merchant'] ?? '-';
                }
            }

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
            if ($addedToShipmentAt !== null && $addedToShipmentAt !== '0001-01-01T00:00:00Z' && $addedToShipmentAt !== '0001-01-01 00:00:00') {
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
                $row = mysqli_fetch_assoc($resCheck);

                // Calculate value_of_package using the function
                include_once 'function.php';
                $value_of_package = calculate_value_of_package(floatval($weight));

                $sqlUpdate = "UPDATE packages SET
                    tracking_number = '" . mysqli_real_escape_string($conn, $trackingNumber) . "',
                    courier_company = '" . mysqli_real_escape_string($conn, $courierCompany) . "',
                    describe_package = '" . mysqli_real_escape_string($conn, $description) . "',
                    weight = " . floatval($weight) . ",
                    value_of_package = " . floatval($value_of_package) . ",
                    store = '" . mysqli_real_escape_string($conn, $store) . "',
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
                // Calculate value_of_package using the function
                include_once 'function.php';
                $value_of_package = calculate_value_of_package(floatval($weight));

                $sqlInsert = "INSERT INTO packages
                    (user_id, tracking_number, courier_company, describe_package, weight, value_of_package, store, tracking_name, dim_length, dim_width, dim_height, shipment_status, shipment_type, branch, tag, courier_id, courier_customer_id, added_to_shipment_at, shipment_simple_id, warehouse_package_id, created_at, shipment_id) VALUES (
                    " . intval($user_id) . ",
                    '" . mysqli_real_escape_string($conn, $trackingNumber) . "',
                    '" . mysqli_real_escape_string($conn, $courierCompany) . "',
                    '" . mysqli_real_escape_string($conn, $description) . "',
                    " . floatval($weight) . ",
                    " . floatval($value_of_package) . ",
                    '" . mysqli_real_escape_string($conn, $store) . "',
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
                                     // Get region from delivery_preference (home region)
            $region = $lc['region']; // default from users
            global $conn;
            if (isset($conn) && $conn) {
                $sql_dp = "SELECT region FROM delivery_preference WHERE user_id = " . intval($lc['id']) . " LIMIT 1";
                $res_dp = mysqli_query($conn, $sql_dp);
                if ($res_dp && mysqli_num_rows($res_dp) > 0) {
                    $row_dp = mysqli_fetch_assoc($res_dp);
                    $region = $row_dp['region'];
                }
            }
            // Push to warehouse API
            $push_result = push_customer_to_warehouse([
                'first_name'     => $lc['first_name'],
                'last_name'      => $lc['last_name'],
                'account_number' => $lc['account_number'],
                'region'         => $region,
            ]);
            if ($push_result !== false) {
                // Add pushed customer to merged list
                $merged_customers[] = [
                    'accountId' => $lc['account_number'],
                    'firstName' => $lc['first_name'],
                    'lastName'  => $lc['last_name'],
                    'branch'    => $region,
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

// Function to update all courier customers in warehouse API with latest data
function update_all_courier_customers()
{
    global $conn;
    if (! isset($conn) || ! $conn) {
        error_log("Warehouse API update_all_courier_customers: Database connection not available");
        return false;
    }

    // Fetch all users with warehouse_customer_id
    $sql = "SELECT u.id, u.first_name, u.last_name, u.account_number, u.warehouse_customer_id, COALESCE(dp.region, u.region) as region
            FROM users u
            LEFT JOIN delivery_preference dp ON u.id = dp.user_id
            WHERE u.warehouse_customer_id IS NOT NULL AND u.warehouse_customer_id != ''";
    $result = mysqli_query($conn, $sql);
    if (! $result) {
        error_log("Warehouse API update_all_courier_customers: Query failed: " . mysqli_error($conn));
        return false;
    }

    $updated_count = 0;
    while ($row = mysqli_fetch_assoc($result)) {
        $customer = [
            'first_name'            => $row['first_name'],
            'last_name'             => $row['last_name'],
            'account_number'        => $row['account_number'],
            'region'                => $row['region'],
            'warehouse_customer_id' => $row['warehouse_customer_id'],
        ];

        $update_result = update_courier_customer($customer);
        if ($update_result !== false) {
            $updated_count++;
        }
    }

    error_log("Warehouse API update_all_courier_customers: Updated $updated_count customers");
    return $updated_count;
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

    // Get store from pre-alert merchant
    $store = '-';
    if (! empty($trackingNumber) && isset($user_id) && $user_id > 0) {
        $sqlPreAlert = "SELECT Merchant FROM pre_alert WHERE Tracking_Number = '" . mysqli_real_escape_string($conn, $trackingNumber) . "' AND User_id = " . intval($user_id) . " LIMIT 1";
        $resPreAlert = mysqli_query($conn, $sqlPreAlert);
        if ($resPreAlert && mysqli_num_rows($resPreAlert) > 0) {
            $rowPreAlert = mysqli_fetch_assoc($resPreAlert);
            $store       = $rowPreAlert['Merchant'] ?? '-';
        }
    }

    // Calculate value_of_package using the function
    include_once __DIR__ . '/function.php';
    $value_of_package = calculate_value_of_package(floatval($weight));

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
            value_of_package = " . floatval($value_of_package) . ",
            store = '" . mysqli_real_escape_string($conn, $store) . "',
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
            (user_id, tracking_number, courier_company, describe_package, weight, value_of_package, store, tracking_name, dim_length, dim_width, dim_height, shipment_status, shipment_type, branch, tag, courier_id, courier_customer_id, added_to_shipment_at, shipment_simple_id, warehouse_package_id, created_at, shipment_id) VALUES (
            " . intval($user_id) . ",
            '" . mysqli_real_escape_string($conn, $trackingNumber) . "',
            '" . mysqli_real_escape_string($conn, $courierCompany) . "',
            '" . mysqli_real_escape_string($conn, $description) . "',
            " . floatval($weight) . ",
            " . floatval($value_of_package) . ",
            '" . mysqli_real_escape_string($conn, $store) . "',
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

        // Get user_id from existing package
        $user_id = $row['user_id'] ?? 0;

        // Get store from pre-alert merchant
        $store = '-';
        if (! empty($trackingNumber) && $user_id > 0) {
            $sqlPreAlert = "SELECT Merchant FROM pre_alert WHERE Tracking_Number = '" . mysqli_real_escape_string($conn, $trackingNumber) . "' AND User_id = " . intval($user_id) . " LIMIT 1";
            $resPreAlert = mysqli_query($conn, $sqlPreAlert);
            if ($resPreAlert && mysqli_num_rows($resPreAlert) > 0) {
                $rowPreAlert = mysqli_fetch_assoc($resPreAlert);
                $store       = $rowPreAlert['Merchant'] ?? '-';
            }
        }

        $sqlUpdate = "UPDATE packages SET
            courier_company = '" . mysqli_real_escape_string($conn, $courierCompany) . "',
            describe_package = '" . mysqli_real_escape_string($conn, $description) . "',
            weight = " . floatval($weight) . ",
            store = '" . mysqli_real_escape_string($conn, $store) . "',
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
