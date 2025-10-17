<?php
    // Initialize session
    session_start();
    include '../config.php';        // database connection
    include '../function.php';      // function comes from user dashboard
    include 'function.php';         // function comes from admin dashboard
    include '../warehouse_api.php'; // warehouse API functions
    include 'authorized-admin.php';
    include 'ShipmentController.php';                    // shipment controller
    $current_file_name = basename($_SERVER['PHP_SELF']); // getting current file name

    // Initialize controller
    $shipmentController = new ShipmentController($conn);

    // Handle sync request
    $sync_message = '';
    if (isset($_GET['sync']) && $_GET['sync'] === '1') {
        $sync_result = $shipmentController->syncShipmentsFromWarehouse();
        if ($sync_result['success']) {
            $sync_message = '<div class="alert alert-success">Shipments synced successfully!</div>';
        } else {
            $sync_message = '<div class="alert alert-danger">Failed to sync shipments: ' . htmlspecialchars($sync_result['error']) . '</div>';
        }
    }

    // Handle AJAX requests
    if (isset($_GET['ajax']) && $_GET['ajax'] == '1') {
        handleAjaxRequest($shipmentController);
        exit;
    }

    // Handle update check requests
    if (isset($_GET['check_updates']) && $_GET['check_updates'] == '1') {
        handleUpdateCheck($shipmentController);
        exit;
    }

    // Pagination and filter parameters
    $limit  = 10; // Number of packages per page
    $page   = isset($_GET['page']) ? (int) $_GET['page'] : 1;
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    $status = isset($_GET['status']) ? trim($_GET['status']) : '';
    $sort   = isset($_GET['sort']) ? trim($_GET['sort']) : 'created_at DESC';

    // Validate sort parameter for security
    $allowed_sorts = [
        'created_at DESC', 'created_at ASC',
        'tracking_number ASC', 'tracking_number DESC',
        'value_of_package DESC', 'value_of_package ASC',
    ];
    if (! in_array($sort, $allowed_sorts)) {
        $sort = 'created_at DESC';
    }

    // Validate pagination parameters
    $validation_errors = $shipmentController->validatePaginationParams($page, $limit);
    if (! empty($validation_errors)) {
        $page          = 1; // Reset to first page on validation error
        $error_message = '<div class="alert alert-warning">Invalid pagination parameters. Showing first page.</div>';
    }

    $data            = $shipmentController->getShipments($page, $limit, $search, $status, $sort);
    $shipments       = $data['shipments'];
    $total_shipments = $data['total'];
    $total_pages     = ceil($total_shipments / $limit);

    // Handle errors
    $error_message = '';
    if (empty($shipments)) {
        $shipments       = [];
        $total_shipments = 0;
        $total_pages     = 0;
    }

    /**
     * Handle AJAX requests for search/filter/pagination
     */
    function handleAjaxRequest($controller)
    {
        $limit  = 10;
        $page   = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $status = isset($_GET['status']) ? trim($_GET['status']) : '';
        $sort   = isset($_GET['sort']) ? trim($_GET['sort']) : 'created_at DESC';

        // Validate sort parameter
        $allowed_sorts = [
            'created_at DESC', 'created_at ASC',
            'tracking_number ASC', 'tracking_number DESC',
            'value_of_package DESC', 'value_of_package ASC',
        ];
        if (! in_array($sort, $allowed_sorts)) {
            $sort = 'created_at DESC';
        }

        $data            = $controller->getShipments($page, $limit, $search, $status, $sort);
        $shipments       = $data['shipments'];
        $total_shipments = $data['total'];
        $total_pages     = ceil($total_shipments / $limit);

        // Generate table HTML
        ob_start();
    ?>
    <div class="panel-body table-responsive">
        <table class="table m-auto shadow table-striped table-hover table-bordered">
        <thead class="table-light">
            <tr>
              <th>Shipment Number</th>
              <th>Type</th>
              <!-- <th>Origin</th> -->
              <!-- <th>Destination</th> -->
              <th>Status</th>
              <th>Description</th>
              <th>Created At</th>
              <!-- <th>Packages</th>
              <th>Total Weight</th>
              <th>Gross Revenue</th>
              <th>Route</th>
              <th>Status</th>
              <th>Date</th> -->
              <th>View</th>
            </tr>
        </thead>
        <tbody>
            <?php if (! empty($shipments)) {?>
                <?php foreach ($shipments as $shipment) {?>
                    <tr>
                        <td><?php echo htmlspecialchars($shipment['shipment_number'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($shipment['type'] ?? ''); ?></td>
                        <!-- <td><?php echo htmlspecialchars($shipment['origin'] ?? '—'); ?></td> -->
                        <!-- <td><?php echo htmlspecialchars($shipment['desitination'] ?? '—'); ?></td> -->
                        <!-- <td><?php echo htmlspecialchars($shipment['origin'] ?? ''); ?> → <?php echo htmlspecialchars($shipment['destination'] ?? ''); ?></td> -->
                        <td><span style="background:#fde047;padding: 4px; border-radius:5px;color:#222;font-size: 11px;display:inline-block"><?php echo htmlspecialchars($shipment['status'] ?? ''); ?></span></td>
                        <td><?php echo htmlspecialchars($shipment['description'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars(timeAgo($shipment['created_at'] ?? '')); ?></td>
                        <td>
                            <ul class="action-list">
                                <li>
                                  <a href="shipments-view.php?tracking=<?php echo htmlspecialchars($shipment['shipment_number'] ?? ''); ?>">
                                     <i class="fa-solid fa-eye"></i>
                                  </a>
                                </li>
                            </ul>
                        </td>
                    </tr>
                <?php }?>
            <?php } else {?>
                <tr>
                    <td colspan="9" style="text-align: center;">No shipments found matching your criteria</td>
                </tr>
            <?php }?>
          </tbody>
        </table>
    </div>
    <?php
        $table_html = ob_get_clean();

            // Generate pagination HTML
            ob_start();
        ?>
    <div class="mt-3 panel-footer">
        <div class="row">
            <div class="col col-sm-6 col-xs-6">Showing <b><?php echo count($shipments); ?></b> out of <b><?php echo $total_shipments; ?></b> entries</div>
            <div class="col-sm-6 col-xs-6">
                <ul class="pagination justify-content-end" style="color:black;">
                    <?php if ($page > 1) {?>
                        <li class="page-item"><a class="page-link" href="?page=<?php echo $page - 1; ?>&search=<?php echo urlencode($search); ?>&status=<?php echo urlencode($status); ?>&sort=<?php echo urlencode($sort); ?>"><</a></li>
                    <?php } else {?>
                        <li class="page-item disabled"><a class="page-link" href="#"><</a></li>
                    <?php }?>
                    <?php for ($i = 1; $i <= $total_pages; $i++) {?>
                        <li class="page-item<?php echo $i == $page ? 'active' : ''; ?>"><a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>&status=<?php echo urlencode($status); ?>&sort=<?php echo urlencode($sort); ?>"><?php echo $i; ?></a></li>
                    <?php }?>
                    <?php if ($page < $total_pages) {?>
                        <li class="page-item"><a class="page-link" href="?page=<?php echo $page + 1; ?>&search=<?php echo urlencode($search); ?>&status=<?php echo urlencode($status); ?>&sort=<?php echo urlencode($sort); ?>">></a></li>
                    <?php } else {?>
                        <li class="page-item disabled"><a class="page-link" href="#">></a></li>
                    <?php }?>
                </ul>
            </div>
        </div>
    </div>
    <?php
        $pagination_html = ob_get_clean();

            // Return JSON response
            header('Content-Type: application/json');
            echo json_encode([
                'table'       => $table_html,
                'pagination'  => $pagination_html,
                'total'       => $total_shipments,
                'page'        => $page,
                'total_pages' => $total_pages,
            ]);
        }

        /**
         * Handle update check requests
         */
        function handleUpdateCheck($controller)
        {
            // Get basic stats for update checking
            $stats = $controller->getShipmentStats();

            header('Content-Type: application/json');
            echo json_encode([
                'has_updates' => false, // You can implement more sophisticated update detection
                'stats'       => $stats,
                'timestamp'   => time(),
            ]);
        }
    ?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Shipments | Pync Parcel Chateau</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no"  name="viewport" />
    <!-- CSS for Tracking icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.4/tutorials/timelines/timeline-5/assets/css/timeline-5.css">
    <!-- CSS Files -->
    <link rel="stylesheet" href="../user-dashboard/assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../user-dashboard/assets/css/kaiadmin.min.css" />
    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- custom css -->
    <link rel="stylesheet" href="../user-dashboard/assets/css/custom.css" />
    <link rel="stylesheet" href="assets/css/admin.css" />
  </head>
  <body>
    <div class="wrapper admin">
      <!-- Sidebar -->
      <div class="sidebar">
        <div class="sidebar-logo">
          <!-- Logo Header -->
          <div class="logo-header">
            <a href="../index.php" class="logo">
              <img src="assets/img/logo.png" alt="navbar brand" class="navbar-brand" />
            </a>
            <div class="nav-toggle">
              <button class="btn btn-toggle toggle-sidebar">
                <i class="gg-menu-right"></i>
              </button>
              <button class="btn btn-toggle sidenav-toggler">
                <i class="gg-menu-left"></i>
              </button>
            </div>
            <button class="topbar-toggler more">
              <i class="gg-more-vertical-alt"></i>
            </button>
          </div>
          <!-- End Logo Header -->
        </div>
        <div class="sidebar-wrapper scrollbar scrollbar-inner">
          <div class="sidebar-content">
            <ul class="nav nav-secondary">
              <li class="nav-item">
                <a href="index.php">
                   <img class="home-icon" src="assets/img/home.png" alt="home" />
                  <p>Home</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="packages.php">
                  <img class="package-icon" src="assets/img/package.png" alt="package" />
                  <p>Packages</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="customers.php">
                  <img class="user-icon" src="assets/img/user.png" alt="User" />
                  <p>Customers</p>
                </a>
              </li>
              <li class="nav-item">
                <a  href="prealerts.php">
                <img class="user-icon" src="assets/img/sidebar-notification.png" alt="User" />
                  <p>Pre-alert</p>
                </a>
              </li>
              <li class="nav-item                                  <?php echo $current_file_name == 'shipments.php' ? 'active' : ''; ?>">
                <a  href="shipments.php">
                <img class="user-icon" src="assets/img/boxes.png" alt="User" />
                  <p style="<?php echo $current_file_name == 'shipments.php' ? 'color: #E87946 !important' : ''; ?>">Shipments</p>
                </a>
              </li>
              <li class="nav-item log-out">
                <a  href="../user-area/log-out.php">
                <img class="user-icon" src="assets/img/shutdown.png" alt="User" />
                  <p>Log out</p>
                </a>
              </li>
            </ul>
          </div>
        </div>
       </div>
      <!-- End Sidebar -->
      <div class="main-panel">
        <div class="main-header">
          <div class="main-header-logo">
            <!-- Logo Header -->
            <div class="logo-header">
              <a href="index.php" class="logo">
                <img src="assets/img/logo.png" alt="navbar brand" class="navbar-brand" height="20" />
              </a>
              <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                  <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                  <i class="gg-menu-left"></i>
                </button>
              </div>
              <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
              </button>
            </div>
            <!-- End Logo Header -->
          </div>
          <!-- Navbar Header -->
          <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
            <div class="container-fluid">
              <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
                <li class="nav-item topbar-icon dropdown hidden-caret">
                  <a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                     <img class="noti_icon" src="assets/img/notification.png" alt="notification" />
                    <span class="notification">4</span>
                  </a>
                  <ul class="dropdown-menu notif-box animated fadeIn" aria-labelledby="notifDropdown">
                    <li>
                      <div class="dropdown-title">
                        You have 4 new notification
                      </div>
                    </li>
                    <li>
                      <div class="notif-scroll scrollbar-outer">
                        <div class="notif-center">
                          <div class="notifi-area">
                          <a href="#">
                            <div style="background:#E87946" class="notif-icon">
                               <img width="30px" height="30px" src="assets/img/delivery.png" alt="delivery" />
                            </div>
                            <div class="notif-content">
                              <span class="block"> Received at Warehouse </span>
                              <span class="time">5 minutes ago</span>
                            </div>
                          </a>
                          <span class="notif-del">
                            <img src="assets/img/close.png" alt="close" />
                          </span>
                          </div>
                          <div class="notifi-area">
                          <a href="#">
                            <div style="background:#000" class="notif-icon">
                                 <img width="30px" height="30px" src="assets/img/shipped.png" alt="shipped" />
                            </div>
                            <div class="notif-content">
                              <span class="block">
                                In Transit to Jamaica
                              </span>
                              <span class="time">12 minutes ago</span>
                            </div>
                          </a>
                           <span class="notif-del">
                             <img src="assets/img/close.png" alt="close" />
                          </span>
                          </div>
                          <div class="notifi-area">
                          <a href="#">
                            <div style="background:#226424" class="notif-img">
                              <img  style="width: 30px !important; height: 30px !important" src="assets/img/growth.png" alt="growth" />
                            </div>
                            <div class="notif-content">
                              <span class="block">
                                Undergoing Customs Clearance
                              </span>
                              <span class="time">12 minutes ago</span>
                            </div>
                          </a>
                            <span class="notif-del">
                             <img src="assets/img/close.png" alt="close" />
                           </span>
                           </div>
                           <div class="notifi-area">
                          <a href="#">
                            <div class="notif-icon notif-danger">
                               <img  style="width: 30px !important; height: 30px !important" src="assets/img/delivery-man.png" alt="delivery-man" />
                            </div>
                            <div class="notif-content">
                              <span class="block"> Ready for Delivery Instructions</span>
                              <span class="time">17 minutes ago</span>
                            </div>
                          </a>
                            <span class="notif-del">
                             <img src="assets/img/close.png" alt="close" />
                           </span>
                           </div>
                          <div class="notifi-area">
                              <a href="#">
                                <div class="notif-icon notif-danger">
                                    <img  style="width: 30px !important; height: 30px !important" src="assets/img/order-fulfillment.png" alt="order-fulfillment" />
                                </div>
                                <div class="notif-content">
                                  <span class="block"> Delivered </span>
                                  <span class="time">17 minutes ago</span>
                                </div>
                              </a>
                               <span class="notif-del">
                                 <img src="assets/img/close.png" alt="close" />
                               </span>
                           </div>
                        </div>
                      </div>
                    </li>
                  </ul>
                </li>
                <li class="nav-item">
                      <span class="op-7">Welcome</span>
                      <span class="fw-bold"><?php echo user_account_information()['first_name']; ?></span>
                </li>
              </ul>
            </div>
          </nav>
          <!-- End Navbar -->
        </div>
      <div class="container">
          <div class="page-inner">
            <!--Order history start-->
            <div class="row">
               <div class="col-md-offset-1 col-md-12">
                <div class="panel packages ">
                <div class="panel-heading">
                    <div class="row">
                        <div class="d-flex justify-content-between add_shipping align-items-center">
                            <h4 class="title">Shipments</h4>
                            <div>
                                <span><a href="?sync=1" style="color:white !important;"><i class="fa-solid fa-sync"></i> Sync</a></span>
                                <span data-toggle="modal" data-target="#create_shipping"><i class="fa-solid fa-plus"></i> New</span>
                            </div>
                        </div>
                    </div>
                    <?php if (! empty($sync_message)) {
                            echo $sync_message;
                        }
                    ?>
                    <?php if (! empty($error_message)) {
                            echo $error_message;
                        }
                    ?>
                </div>
                <!-- Search and Filter Container -->
                <div class="search-filter-container" style="display:none;">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="search-input-group">
                                <input type="search" id="searchInput" class="form-control" placeholder="Search by tracking number, description, or shipment number..." aria-label="Search" />
                                <button type="button" id="searchBtn" class="btn-search">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6">
                                    <select id="statusFilter" class="form-select">
                                        <option value="">All Statuses</option>
                                        <option value="pending">Pending</option>
                                        <option value="in_transit">In Transit</option>
                                        <option value="delivered">Delivered</option>
                                        <option value="cancelled">Cancelled</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <select id="sortBy" class="form-select">
                                        <option value="created_at DESC">Newest First</option>
                                        <option value="created_at ASC">Oldest First</option>
                                        <option value="tracking_number ASC">Tracking Number A-Z</option>
                                        <option value="value_of_package DESC">Highest Value</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="filter-badges" id="filterBadges"></div>
                </div>

                <!-- Loading Overlay -->
                <div class="loading-overlay" id="loadingOverlay">
                    <div>
                        <div class="loading-spinner"></div>
                        <div class="loading-text">Loading shipments...</div>
                    </div>
                </div>

                <!-- Progress Container -->
                <div class="progress-container d-none" id="progressContainer">
                    <div class="alert alert-progress">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1">
                                <strong>Processing...</strong>
                                <div class="progress mt-2">
                                    <div class="progress-bar progress-bar-custom" id="progressBar" style="width: 0%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<div class="panel-body table-responsive" style="display: none;">
    <table class="table m-auto shadow table-striped table-hover table-bordered">
        <thead class="table-light">
            <tr>
                <th>Shipment Number</th>
                <th>Type</th>
                <!-- <th>Origin</th> -->
                <!-- <th>Destination</th> -->
                <th>Status</th>
                <th>Description</th>
                <th>Created At</th>
                <!-- <th>Packages</th>
                <th>Total Weight</th>
                <th>Gross Revenue</th>
                <th>Route</th>
                <th>Status</th>
                <th>Date</th> -->
                <th>View</th>
            </tr>
        </thead>
        <tbody>
            <?php if (! empty($shipments)) {?>
                <?php foreach ($shipments as $shipment) {?>
                    <tr>
                        <td><?php echo htmlspecialchars($shipment['shipment_number'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars($shipment['type'] ?? ''); ?></td>
                        <!-- <td><?php echo htmlspecialchars($shipment['origin'] ?? '—'); ?></td> -->
                        <!-- <td><?php echo htmlspecialchars($shipment['desitination'] ?? '—'); ?></td> -->
                        <!-- <td><?php echo htmlspecialchars($shipment['origin'] ?? ''); ?> → <?php echo htmlspecialchars($shipment['destination'] ?? ''); ?></td> -->
                        <td><span style="background:#fde047;padding: 4px; border-radius:5px;color:#222;font-size: 11px;display:inline-block"><?php echo htmlspecialchars($shipment['status'] ?? ''); ?></span></td>
                        <td><?php echo htmlspecialchars($shipment['description'] ?? ''); ?></td>
                        <td><?php echo htmlspecialchars(timeAgo($shipment['created_at'] ?? '')); ?></td>
                        <td>
                            <ul class="action-list">
                                <li>
                                  <a href="shipments-view.php?tracking=<?php echo htmlspecialchars($shipment['shipment_number'] ?? ''); ?>">
                                     <i class="fa-solid fa-eye"></i>
                                  </a>
                                </li>
                            </ul>
                        </td>
                    </tr>
                <?php }?>
            <?php } else {?>
                <tr>
                    <td colspan="9" style="text-align: center;">No shipments found matching your criteria</td>
                </tr>
            <?php }?>
          </tbody>
    </table>
</div>
                <!-- Pagination -->
                <div class="mt-3 panel-footer">
                    <div class="row">
                        <div class="col col-sm-6 col-xs-6">Showing <b><?php echo count($shipments); ?></b> out of <b><?php echo $total_shipments; ?></b> entries</div>
                        <div class="col-sm-6 col-xs-6">
                            <ul class="pagination justify-content-end" style="color:black;">
                                <?php if ($page > 1) {?>
                                    <li class="page-item"><a class="page-link" href="?page=<?php echo $page - 1; ?>"><</a></li>
                                <?php } else {?>
                                    <li class="page-item disabled"><a class="page-link" href="#"><</a></li>
                                <?php }?>
                                <?php for ($i = 1; $i <= $total_pages; $i++) {?>
                                    <li class="page-item<?php echo $i == $page ? 'active' : ''; ?>"><a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                                <?php }?>
                                <?php if ($page < $total_pages) {?>
                                    <li class="page-item"><a class="page-link" href="?page=<?php echo $page + 1; ?>">></a></li>
                                <?php } else {?>
                                    <li class="page-item disabled"><a class="page-link" href="#">></a></li>
                                <?php }?>
                            </ul>
                            <ul class="pagination visible-xs pull-right d-none">
                                <?php if ($page > 1) {?>
                                    <li class="page-item"><a class="page-link" href="?page=<?php echo $page - 1; ?>"><</a></li>
                                <?php } else {?>
                                    <li class="page-item disabled"><a class="page-link" href="#"><</a></li>
                                <?php }?>
                                <?php if ($page < $total_pages) {?>
                                    <li class="page-item"><a class="page-link" href="?page=<?php echo $page + 1; ?>">></a></li>
                                <?php } else {?>
                                    <li class="page-item disabled"><a class="page-link" href="#">></a></li>
                                <?php }?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
     <!--Order history end-->
 </div>
      <!-- Modal for creating shipping -->
        <div class="modal fade" id="create_shipping" tabindex="-1" aria-labelledby="create_shipping" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
               <div class="creatShiptitle">
                    <h2>New Shipment</h2>
                    <p>Crates a shipment for packages</p>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true"><i class="fa fa-close"></i></span>
                </button>
              </div>
              <div class="modal-body">
                <form action="#">
                        <div class="form-group">
                          <label for="Type">Type</label>
                          <select   class="form-select Type" id="Type">
                              <option value="0">Select a shipment type</option>
                              <option value="1">Air</option>
                              <option value="1">Air Express</option>
                              <option value="2">Sea</option>
                            </select>
                       </div>
                       <div class="form-group change-value">
                              <label for="Description">Description (optional)</label>
                              <input placeholder="barrels, 40ft express container, FLIGHT 637"  type="text" class="form-control" id="Description"
                              />
                        </div>
                        <div class="form-group">
                          <label for="Type">Origin</label>
                          <select   class="form-select Type" id="Type">
                              <option value="0">Choose...</option>
                              <option value="1">St. Elizabeth (STORE)</option>
                              <option value="1">Half Tree (Drop Off) (STORE)</option>
                              <option value="2">Portland (Knutsford) (STORE)</option>
                              <option value="2">May  Pen (Plaza) (STORE)</option>
                              <option value="2">Negril Store (STORE)</option>
                              <option value="2">Falmouth Store Main (STORE)</option>
                              <option value="2">Montego Bay Fairview Branch (STORE)</option>
                              <option value="2">Miami Warehouse (WAREHOUSE)</option>
                              <option value="2">Hagley Park (STORE)</option>
                            </select>
                       </div>
                        <div class="form-group">
                          <label for="Type">Destination</label>
                          <select   class="form-select Type" id="Type">
                              <option value="0">Choose...</option>
                              <option value="1">St. Elizabeth (STORE)</option>
                              <option value="1">Half Tree (Drop Off) (STORE)</option>
                              <option value="2">Portland (Knutsford) (STORE)</option>
                              <option value="2">May  Pen (Plaza) (STORE)</option>
                              <option value="2">Negril Store (STORE)</option>
                              <option value="2">Falmouth Store Main (STORE)</option>
                              <option value="2">Montego Bay Fairview Branch (STORE)</option>
                              <option value="2">Miami Warehouse (WAREHOUSE)</option>
                              <option value="2">Hagley Park (STORE)</option>
                            </select>
                       </div>
                        <div class="card-action d-flex update_shipments">
                               <button type="submit" class="my-4 btn ">
                                 Create
                               </button>
                        </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <footer class="footer">
          <div>
            <p class="text-center">
             <small>&copy; 2025 Pync Parcel Chateau Limited. All rights reserved.</small></p>
          </div>
        </footer>
      </div>
    </div>
    <!--   boostrap   -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="assets/js/core/popper.min.js"></script>
    <script src="assets/js/core/bootstrap.min.js"></script>

    <!-- jQuery Scrollbar -->
    <script src="assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
    <!-- Kaiadmin JS -->
      <script src="assets/js/kaiadmin.min.js"></script>
      <!-- custom js -->
      <script src="assets/js/custom.js"></script>
  </body>
</html>
<script type="text/javascript">
    $(document).ready(function() {
        // Initialize variables
        let currentPage = 1;
        let searchTimeout;
        let isLoading = false;

        // Show table on page load
        $(window).on('load', function() {
            $('.table-responsive').show('slow');
            $('#loadingOverlay').fadeOut();
        });

        // Enhanced search functionality
        $('#searchInput').on('input', function() {
            const searchTerm = $(this).val().trim();
            if (searchTerm.length >= 2 || searchTerm.length === 0) {
                performSearch(searchTerm);
            }
        });

        // Search button click
        $('#searchBtn').on('click', function() {
            const searchTerm = $('#searchInput').val().trim();
            performSearch(searchTerm);
        });

        // Filter functionality
        $('#statusFilter, #sortBy').on('change', function() {
            performSearch($('#searchInput').val().trim());
        });

        // Perform search and filter
        function performSearch(searchTerm) {
            if (isLoading) return;

            isLoading = true;
            showLoading();

            const statusFilter = $('#statusFilter').val();
            const sortBy = $('#sortBy').val();

            // Update filter badges
            updateFilterBadges(searchTerm, statusFilter, sortBy);

            $.ajax({
                url: 'shipments.php',
                type: 'GET',
                data: {
                    search: searchTerm,
                    status: statusFilter,
                    sort: sortBy,
                    page: 1,
                    ajax: 1
                },
                success: function(response) {
                    // Update table content
                    const $response = $(response);
                    $('.table-responsive').html($response.find('.table-responsive').html());
                    $('.panel-footer').html($response.find('.panel-footer').html());

                    // Reinitialize pagination
                    initializePagination();

                    hideLoading();
                    isLoading = false;
                },
                error: function() {
                    hideLoading();
                    isLoading = false;
                    showError('Search failed. Please try again.');
                }
            });
        }

        // Update filter badges
        function updateFilterBadges(search, status, sort) {
            let badges = '';

            if (search) {
                badges += `<span class="badge badge-primary filter-badge" data-type="search">${search} <i class="fa fa-times"></i></span>`;
            }

            if (status) {
                badges += `<span class="badge badge-info filter-badge" data-type="status">${status} <i class="fa fa-times"></i></span>`;
            }

            if (sort !== 'created_at DESC') {
                badges += `<span class="badge badge-secondary filter-badge" data-type="sort">${$('#sortBy option:selected').text()} <i class="fa fa-times"></i></span>`;
            }

            $('#filterBadges').html(badges);

            // Remove filter on badge click
            $('.filter-badge').on('click', function() {
                const type = $(this).data('type');
                if (type === 'search') {
                    $('#searchInput').val('');
                } else if (type === 'status') {
                    $('#statusFilter').val('');
                } else if (type === 'sort') {
                    $('#sortBy').val('created_at DESC');
                }
                performSearch($('#searchInput').val().trim());
            });
        }

        // Initialize pagination
        function initializePagination() {
            $('.pagination .page-link').on('click', function(e) {
                e.preventDefault();
                const href = $(this).attr('href');
                if (href && href !== '#') {
                    const urlParams = new URLSearchParams(href.split('?')[1]);
                    const page = urlParams.get('page');

                    if (page) {
                        loadPage(parseInt(page));
                    }
                }
            });
        }

        // Load specific page
        function loadPage(page) {
            if (isLoading) return;

            isLoading = true;
            showLoading();

            const searchTerm = $('#searchInput').val().trim();
            const statusFilter = $('#statusFilter').val();
            const sortBy = $('#sortBy').val();

            $.ajax({
                url: 'shipments.php',
                type: 'GET',
                data: {
                    search: searchTerm,
                    status: statusFilter,
                    sort: sortBy,
                    page: page,
                    ajax: 1
                },
                success: function(response) {
                    const $response = $(response);
                    $('.table-responsive').html($response.find('.table-responsive').html());
                    $('.panel-footer').html($response.find('.panel-footer').html());

                    initializePagination();
                    hideLoading();
                    isLoading = false;

                    // Smooth scroll to top of table
                    $('html, body').animate({
                        scrollTop: $('.panel-body').offset().top - 100
                    }, 300);
                },
                error: function() {
                    hideLoading();
                    isLoading = false;
                    showError('Failed to load page. Please try again.');
                }
            });
        }

        // Show loading overlay
        function showLoading() {
            $('#loadingOverlay').fadeIn(200);
        }

        // Hide loading overlay
        function hideLoading() {
            $('#loadingOverlay').fadeOut(200);
        }

        // Show progress bar
        function showProgress() {
            $('#progressContainer').removeClass('d-none');
            $('#progressBar').css('width', '0%');

            let progress = 0;
            const interval = setInterval(function() {
                progress += Math.random() * 15;
                if (progress >= 90) {
                    clearInterval(interval);
                }
                $('#progressBar').css('width', progress + '%');
            }, 200);
        }

        // Hide progress bar
        function hideProgress() {
            $('#progressBar').css('width', '100%');
            setTimeout(function() {
                $('#progressContainer').addClass('d-none');
            }, 300);
        }

        // Show error message
        function showError(message) {
            const errorHtml = `<div class="alert alert-danger alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>`;
            $('.panel-heading').prepend(errorHtml);

            // Auto remove after 5 seconds
            setTimeout(function() {
                $('.alert-danger').fadeOut();
            }, 5000);
        }

        // Real-time updates (polling every 30 seconds)
        setInterval(function() {
            if (!isLoading && document.visibilityState === 'visible') {
                // Check for updates silently
                $.ajax({
                    url: 'shipments.php',
                    type: 'GET',
                    data: { check_updates: 1 },
                    success: function(response) {
                        // You can implement update notification logic here
                        // For now, just log that updates are being checked
                        console.log('Checking for shipment updates...');
                    }
                });
            }
        }, 30000);

        // Initialize on page load
        initializePagination();

        // Clear search on escape key
        $(document).on('keydown', function(e) {
            if (e.keyCode === 27) { // Escape key
                $('#searchInput').val('');
                performSearch('');
            }
        });

        // Enter key support for search
        $('#searchInput').on('keypress', function(e) {
            if (e.which === 13) { // Enter key
                performSearch($(this).val().trim());
            }
        });
    });
</script>
