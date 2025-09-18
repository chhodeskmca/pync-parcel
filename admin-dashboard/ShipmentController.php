<?php
/**
 * ShipmentController handles business logic for shipment-related operations
 * Separates data fetching, processing, and validation from presentation layer
 */

class ShipmentController {
    private $conn;
    private $cache_dir = '../cache/';
    private $cache_expiry = 300; // 5 minutes

    public function __construct($db_connection) {
        $this->conn = $db_connection;
        $this->ensureCacheDirectory();
    }

    /**
     * Ensure cache directory exists
     */
    private function ensureCacheDirectory() {
        if (!is_dir($this->cache_dir)) {
            mkdir($this->cache_dir, 0755, true);
        }
    }

    /**
     * Get cached data if available and not expired
     */
    private function getCache($key) {
        $cache_file = $this->cache_dir . md5($key) . '.cache';
        if (file_exists($cache_file) && (time() - filemtime($cache_file)) < $this->cache_expiry) {
            return unserialize(file_get_contents($cache_file));
        }
        return false;
    }

    /**
     * Set cache data
     */
    private function setCache($key, $data) {
        $cache_file = $this->cache_dir . md5($key) . '.cache';
        file_put_contents($cache_file, serialize($data));
    }

    /**
     * Clear cache for a specific key
     */
    private function clearCache($key) {
        $cache_file = $this->cache_dir . md5($key) . '.cache';
        if (file_exists($cache_file)) {
            unlink($cache_file);
        }
    }

    /**
     * Get paginated packages in shipments with search, filter, and sort support
     */
    public function getPackagesInShipments($page = 1, $limit = 10, $search = '', $status = '', $sort = 'created_at DESC', $use_cache = true) {
        $cache_key = "packages_shipments_page_{$page}_limit_{$limit}_search_" . md5($search) . "_status_{$status}_sort_" . md5($sort);

        if ($use_cache && empty($search) && empty($status)) {
            $cached = $this->getCache($cache_key);
            if ($cached !== false) {
                return $cached;
            }
        }

        $offset = ($page - 1) * $limit;

        // Build WHERE clause
        $where_conditions = ["p.shipment_id IS NOT NULL"];
        $params = [];
        $types = "";

        if (!empty($search)) {
            $search_term = "%{$search}%";
            $where_conditions[] = "(p.tracking_number LIKE ? OR p.describe_package LIKE ? OR s.shipment_number LIKE ?)";
            $params = array_merge($params, [$search_term, $search_term, $search_term]);
            $types .= "sss";
        }

        if (!empty($status)) {
            $where_conditions[] = "s.status = ?";
            $params[] = $status;
            $types .= "s";
        }

        $where_clause = implode(" AND ", $where_conditions);

        // Get total count with filters
        $count_sql = "SELECT COUNT(*) as total FROM packages p LEFT JOIN shipments s ON p.shipment_id = s.id WHERE {$where_clause}";
        $count_stmt = mysqli_prepare($this->conn, $count_sql);
        if (!$count_stmt) {
            error_log("ShipmentController: Failed to prepare count statement - " . mysqli_error($this->conn));
            return ['packages' => [], 'total' => 0, 'error' => 'Database error'];
        }

        if (!empty($params)) {
            mysqli_stmt_bind_param($count_stmt, $types, ...$params);
        }
        mysqli_stmt_execute($count_stmt);
        $count_result = mysqli_stmt_get_result($count_stmt);
        $total = mysqli_fetch_assoc($count_result)['total'];
        mysqli_stmt_close($count_stmt);

        // Get paginated data with filters and sorting
        $sql = "SELECT p.*, s.shipment_number, s.type, s.origin, s.destination, s.status as shipment_status
                FROM packages p
                LEFT JOIN shipments s ON p.shipment_id = s.id
                WHERE {$where_clause}
                ORDER BY {$sort} LIMIT ? OFFSET ?";

        $stmt = mysqli_prepare($this->conn, $sql);
        if (!$stmt) {
            error_log("ShipmentController: Failed to prepare statement - " . mysqli_error($this->conn));
            return ['packages' => [], 'total' => 0, 'error' => 'Database error'];
        }

        // Add limit and offset parameters
        $all_params = array_merge($params, [$limit, $offset]);
        $all_types = $types . "ii";

        mysqli_stmt_bind_param($stmt, $all_types, ...$all_params);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $packages = [];
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $packages[] = $row;
            }
        }

        mysqli_stmt_close($stmt);

        $data = ['packages' => $packages, 'total' => $total];

        if ($use_cache && empty($search) && empty($status)) {
            $this->setCache($cache_key, $data);
        }

        return $data;
    }

    /**
     * Get paginated packages in shipments with caching (backward compatibility)
     */
    public function getPackagesInShipmentsBasic($page = 1, $limit = 10, $use_cache = true) {
        return $this->getPackagesInShipments($page, $limit, '', '', 'created_at DESC', $use_cache);
    }

    /**
     * Sync shipments from warehouse API
     */
    public function syncShipmentsFromWarehouse() {
        try {
            // Clear cache when syncing
            $this->clearCachePattern("packages_shipments_*");

            include_once '../warehouse_api.php';
            $result = pull_shipments_from_warehouse();

            if ($result === false) {
                error_log("ShipmentController: Failed to sync shipments from warehouse");
                return ['success' => false, 'error' => 'Failed to sync shipments'];
            }

            return ['success' => true, 'message' => 'Shipments synced successfully'];
        } catch (Exception $e) {
            error_log("ShipmentController: Exception during sync - " . $e->getMessage());
            return ['success' => false, 'error' => 'Exception during sync: ' . $e->getMessage()];
        }
    }

    /**
     * Clear cache patterns matching a wildcard
     */
    private function clearCachePattern($pattern) {
        $files = glob($this->cache_dir . '*.cache');
        foreach ($files as $file) {
            $key = basename($file, '.cache');
            // Simple pattern matching - in production, use more sophisticated matching
            if (strpos($key, str_replace('*', '', $pattern)) !== false) {
                unlink($file);
            }
        }
    }

    /**
     * Validate pagination parameters
     */
    public function validatePaginationParams($page, $limit) {
        $errors = [];

        if (!is_numeric($page) || $page < 1) {
            $errors[] = 'Invalid page number';
        }

        if (!is_numeric($limit) || $limit < 1 || $limit > 100) {
            $errors[] = 'Invalid limit (must be 1-100)';
        }

        return $errors;
    }

    /**
     * Get shipment by tracking number or simple ID
     */
    public function getShipmentByTracking($tracking) {
        if (empty($tracking)) {
            return false;
        }

        $sql = "SELECT * FROM shipments WHERE shipment_number = ? OR shipmentSimpleId = ?";
        $stmt = mysqli_prepare($this->conn, $sql);
        if (!$stmt) {
            error_log("ShipmentController: Failed to prepare getShipmentByTracking statement - " . mysqli_error($this->conn));
            return false;
        }

        mysqli_stmt_bind_param($stmt, "ss", $tracking, $tracking);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            $shipment = mysqli_fetch_assoc($result);
            mysqli_stmt_close($stmt);
            return $shipment;
        }

        mysqli_stmt_close($stmt);
        return false;
    }

    /**
     * Get packages for a specific shipment
     */
    public function getPackagesByShipmentId($shipment_id) {
        if (empty($shipment_id) || !is_numeric($shipment_id)) {
            return [];
        }

        $sql = "SELECT p.*, u.first_name, u.last_name
                FROM packages p
                LEFT JOIN users u ON p.user_id = u.id
                WHERE p.shipment_id = ?
                ORDER BY p.created_at DESC";

        $stmt = mysqli_prepare($this->conn, $sql);
        if (!$stmt) {
            error_log("ShipmentController: Failed to prepare getPackagesByShipmentId statement - " . mysqli_error($this->conn));
            return [];
        }

        mysqli_stmt_bind_param($stmt, "i", $shipment_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $packages = [];
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $packages[] = $row;
            }
        }

        mysqli_stmt_close($stmt);
        return $packages;
    }

    /**
     * Get paginated shipments with search, filter, and sort support
     */
    public function getShipments($page = 1, $limit = 100, $search = '', $status = '', $sort = 'created_at DESC', $use_cache = true) {
        $cache_key = "shipments_page_{$page}_limit_{$limit}_search_" . md5($search) . "_status_{$status}_sort_" . md5($sort);

        if ($use_cache && empty($search) && empty($status)) {
            $cached = $this->getCache($cache_key);
            if ($cached !== false) {
                return $cached;
            }
        }

        $offset = ($page - 1) * $limit;

        // Build WHERE clause
        $where_conditions = [];
        $params = [];
        $types = "";

        if (!empty($search)) {
            $search_term = "%{$search}%";
            $where_conditions[] = "(shipment_number LIKE ? OR type LIKE ? OR origin LIKE ? OR destination LIKE ?)";
            $params = array_merge($params, [$search_term, $search_term, $search_term, $search_term]);
            $types .= "ssss";
        }

        if (!empty($status)) {
            $where_conditions[] = "status = ?";
            $params[] = $status;
            $types .= "s";
        }

        $where_clause = !empty($where_conditions) ? "WHERE " . implode(" AND ", $where_conditions) : "";

        // Get total count with filters
        $count_sql = "SELECT COUNT(*) as total FROM shipments {$where_clause}";
        $count_stmt = mysqli_prepare($this->conn, $count_sql);
        if (!$count_stmt) {
            error_log("ShipmentController: Failed to prepare count statement - " . mysqli_error($this->conn));
            return ['shipments' => [], 'total' => 0, 'error' => 'Database error'];
        }

        if (!empty($params)) {
            mysqli_stmt_bind_param($count_stmt, $types, ...$params);
        }
        mysqli_stmt_execute($count_stmt);
        $count_result = mysqli_stmt_get_result($count_stmt);
        $total = mysqli_fetch_assoc($count_result)['total'];
        mysqli_stmt_close($count_stmt);

        // Get paginated data with filters and sorting
        $sql = "SELECT s.*,
                       COUNT(p.id) as total_packages,
                       SUM(p.weight) as total_weight,
                       SUM(p.value_of_package) as gross_revenue
                FROM shipments s
                LEFT JOIN packages p ON s.id = p.shipment_id
                {$where_clause}
                GROUP BY s.id
                ORDER BY {$sort} LIMIT ? OFFSET ?";

        $stmt = mysqli_prepare($this->conn, $sql);
        if (!$stmt) {
            error_log("ShipmentController: Failed to prepare statement - " . mysqli_error($this->conn));
            return ['shipments' => [], 'total' => 0, 'error' => 'Database error'];
        }

        // Add limit and offset parameters
        $all_params = array_merge($params, [$limit, $offset]);
        $all_types = $types . "ii";

        mysqli_stmt_bind_param($stmt, $all_types, ...$all_params);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        $shipments = [];
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                // Format the data
                $row['total_packages'] = (int)$row['total_packages'];
                $row['total_weight'] = (float)$row['total_weight'];
                $row['gross_revenue'] = (float)$row['gross_revenue'];
                $row['volume'] = (float)$row['volume']; // Assuming volume is stored in shipments table
                $shipments[] = $row;
            }
        }

        mysqli_stmt_close($stmt);

        $data = ['shipments' => $shipments, 'total' => $total];

        if ($use_cache && empty($search) && empty($status)) {
            $this->setCache($cache_key, $data);
        }

        return $data;
    }

    /**
     * Get shipment statistics
     */
    public function getShipmentStats() {
        $cache_key = "shipment_stats";

        $cached = $this->getCache($cache_key);
        if ($cached !== false) {
            return $cached;
        }

        $stats = [
            'total_packages_in_shipments' => 0,
            'total_shipments' => 0,
            'active_shipments' => 0
        ];

        // Total packages in shipments
        $sql = "SELECT COUNT(*) as count FROM packages WHERE shipment_id IS NOT NULL";
        $result = mysqli_query($this->conn, $sql);
        if ($result) {
            $stats['total_packages_in_shipments'] = mysqli_fetch_assoc($result)['count'];
        }

        // Total shipments
        $sql = "SELECT COUNT(*) as count FROM shipments";
        $result = mysqli_query($this->conn, $sql);
        if ($result) {
            $stats['total_shipments'] = mysqli_fetch_assoc($result)['count'];
        }

        // Active shipments (not deleted)
        $sql = "SELECT COUNT(*) as count FROM shipments WHERE status != 'Deleted'";
        $result = mysqli_query($this->conn, $sql);
        if ($result) {
            $stats['active_shipments'] = mysqli_fetch_assoc($result)['count'];
        }

        $this->setCache($cache_key, $stats);

        return $stats;
    }
}
?>
