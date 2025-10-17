<?php
// initialize session
session_start();
include '../config.php';                             // database connection
include '../function.php';                           // function
include '../user-area/authorized-user.php';          // function
$current_file_name = basename($_SERVER['PHP_SELF']); // getting current file name
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>Package - Pync Parcel Chateau</title>
  <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
  <!-- CSS for Tracking icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.4/tutorials/timelines/timeline-5/assets/css/timeline-5.css">
  <!-- CSS Files -->
  <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
  <link rel="stylesheet" href="assets/css/kaiadmin.min.css" />
  <!-- custom css -->
  <link rel="stylesheet" href="assets/css/custom.css" />
</head>

<body>
  <div class="wrapper package-page">
    <!-- Sidebar -->
    <div class="sidebar">
      <div class="sidebar-logo">
        <div class="logo-header">
          <a href="../index.php" class="logo">
            <img src="assets/img/logo.png" alt="navbar brand" class="navbar-brand" />
          </a>
          <div class="nav-toggle">
            <button class="btn btn-toggle toggle-sidebar"><i class="gg-menu-right"></i></button>
            <button class="btn btn-toggle sidenav-toggler"><i class="gg-menu-left"></i></button>
          </div>
          <button class="topbar-toggler more"><i class="gg-more-vertical-alt"></i></button>
        </div>
      </div>
      <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
          <ul class="nav nav-secondary">
            <li class="nav-item active">
              <a href="index.php">
                <img class="home-icon" src="assets/img/home.png" alt="home" />
                <p>Dashboard</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="package.php">
                <img class="package-icon" src="assets/img/package.png" alt="package" />
                <p style="<?php echo $current_file_name == 'package.php' ? 'color: #E87946 !important' : ''; ?>">Packages</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="createprealert.php">
                <img class="ctePrealt-icon" src="assets/img/create-prealert.png" alt="Prealert" />
                <p>Create Pre-alert</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="cost-calculator.php">
                <img class="calculator-icon" src="assets/img/calculator.png" alt="Calculator" />
                <p>Cost Calculator</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="makepayment.php">
                <img class="payment-icon" src="assets/img/payment-protection.png" alt="payment" />
                <p>Make Payment</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="mymiamiaddress.php">
                <img class="user-icon" src="assets/img/location.png" alt="location" />
                <p>My Miami Address</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="user-account.php">
                <img class="user-icon" src="assets/img/user.png" alt="User" />
                <p>My account</p>
              </a>
            </li>
            <li class="nav-item log-out">
              <a href="../user-area/log-out.php">
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
              <img
                src="assets/img/logo.png"
                alt="navbar brand"
                class="navbar-brand"
                height="20" />
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
                <a
                  class="nav-link dropdown-toggle"
                  href="#"
                  id="notifDropdown"
                  role="button"
                  data-bs-toggle="dropdown"
                  aria-haspopup="true"
                  aria-expanded="false">
                  <img class="noti_icon" src="assets/img/notification.png" alt="notification" />
                  <span class="notification">4</span>
                </a>
                <ul
                  class="dropdown-menu notif-box animated fadeIn"
                  aria-labelledby="notifDropdown">
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
                              <img style="width: 30px !important; height: 30px !important"
                                src="assets/img/growth.png"
                                alt="growth" />
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
                              <img style="width: 30px !important; height: 30px !important"
                                src="assets/img/delivery-man.png"
                                alt="delivery-man" />
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
                              <img style="width: 30px !important; height: 30px !important"
                                src="assets/img/order-fulfillment.png"
                                alt="order-fulfillment" />
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
      </div>

      <div class="container">
        <div class="page-inner">
          <?php
          if (isset($_SESSION['message'])) {
            $message_type = $_SESSION['message_type'] ?? 'info';
            $message      = $_SESSION['message'];
            echo "<div class='alert alert-{$message_type} mt-3' role='alert'>{$message}</div>";
            unset($_SESSION['message']);
            unset($_SESSION['message_type']);
          }
          ?>
          <!--My package start-->
          <div class="row">
            <div class="col-md-12">
              <div class="card card-round">
                <?php
                // Pagination parameters
                $limit  = 10;
                $page   = isset($_GET['page']) ? (int) $_GET['page'] : 1;
                $offset = ($page - 1) * $limit;

                // Ensure user id is an integer to avoid SQL injection via improper values
                $user_id = isset($user_id) ? (int) $user_id : 0;

                // Get filter parameters
                // Default to warehouse records only when landing on Packages page
                $type_filter  = isset($_GET['type']) ? mysqli_real_escape_string($conn, $_GET['type']) : 'warehouse';
                $status_filter = isset($_GET['filter']) ? mysqli_real_escape_string($conn, $_GET['filter']) : '';

                // Build queries for union
                $queries = [];
                $count_queries = [];
                if ($type_filter == 'warehouse' || $type_filter == 'all') {
                  $where = "WHERE user_id = $user_id";
                  if ($status_filter) {
                    // Map filter to effective statuses
                    $effective_statuses = [];
                    if ($status_filter == 'Received at Warehouse') {
                      $effective_statuses = ['Received at Origin', 'At Sorting Facility', 'Received at Warehouse'];
                    } elseif ($status_filter == 'In transit to Jamaica') {
                      $effective_statuses = ['In Transit', 'Shipped', 'In Transit to Jamaica'];
                    } elseif ($status_filter == 'Undergoing Customs Clearance') {
                      $effective_statuses = ['Processing at Customs', 'Undergoing Customs Clearance'];
                    } elseif ($status_filter == 'Ready for Delivery Instructions') {
                      $effective_statuses = ['Ready for Pickup', 'Out for Delivery', 'Scheduled for Delivery', 'Ready for Delivery Instructions'];
                    } elseif ($status_filter == 'Delivered') {
                      $effective_statuses = ['Delivered'];
                    }
                    if (!empty($effective_statuses)) {
                      $status_list = "'" . implode("','", $effective_statuses) . "'";
                      $where .= " AND COALESCE(tracking_progress, status) IN ($status_list)";
                    }
                  }
                  // include user_id (PYNC ID) so we can display it in the listing
                  $queries[] = "SELECT 'warehouse' as type, tracking_number, tracking_name AS courier_company, weight, store, invoice_total as package_value, describe_package, created_at, user_id FROM packages $where";
                  $count_queries[] = "SELECT COUNT(*) as cnt FROM packages $where";
                }
                if ($type_filter == 'prealert' || $type_filter == 'all') {
                  $where = "WHERE user_id = $user_id AND tracking_number NOT IN (SELECT tracking_number FROM packages WHERE user_id = $user_id)";
                  $queries[] = "SELECT 'prealert' as type, tracking_number, courier_company, NULL as weight, NULL as store, value_of_package as package_value, describe_package, created_at, user_id FROM pre_alert $where";
                  $count_queries[] = "SELECT COUNT(*) as cnt FROM pre_alert $where";
                }

                // Count total (defensive)
                $total_packages = 0;
                foreach ($count_queries as $cq) {
                  $result_count = mysqli_query($conn, $cq);
                  if ($result_count) {
                    $row_cnt = mysqli_fetch_assoc($result_count);
                    $total_packages += isset($row_cnt['cnt']) ? (int) $row_cnt['cnt'] : 0;
                  }
                }
                $total_pages = $limit > 0 ? ceil($total_packages / $limit) : 0;

                // If there are no queries (shouldn't normally happen) handle gracefully
                $result = false;
                if (!empty($queries)) {
                  // Select with union
                  $sql = implode(' UNION ALL ', $queries) . " ORDER BY created_at DESC LIMIT $limit OFFSET $offset";
                  $result = mysqli_query($conn, $sql);
                }

                if ($result && mysqli_num_rows($result) > 0) {
                ?>
                  <div class="card-header">
                    <div class="card-head-row card-tools-still-right justify-content-center">
                      <div style="font-size: 18px;" class="card-title">
                        <h1>My Packages<?php if ($status_filter) echo ' - ' . htmlspecialchars($status_filter); ?></h1>
                      </div>
                      <div class="card-tools">
                        <select id="typeFilter" class="form-select" onchange="changeType(this.value)">
                          <option value="all" <?php echo $type_filter == 'all' ? 'selected' : ''; ?>>All</option>
                          <option value="warehouse" <?php echo $type_filter == 'warehouse' ? 'selected' : ''; ?>>Warehouse Records</option>
                          <option value="prealert" <?php echo $type_filter == 'prealert' ? 'selected' : ''; ?>>Pre-alerts</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="p-0 card-body">
                    <div class="table-responsive">
                      <table id="mypackages" class="table mb-0 ">
                        <thead class="thead-light">
                          <tr>
                            <th>Tracking</th>
                            <th>PYNC ID</th>
                            <!-- <th>Type</th> -->
                            <th>Courier Company</th>
                            <th>Weight</th>
                            <th>Store</th>
                            <th>Value of Package (USD)</th>
                            <th>Package Description</th>
                            <th>Date</th>
                            <!-- <th>View</th>
                            <th>Payment Status</th> -->
                          </tr>
                        </thead>
                        <tbody style="text-align-last: center;">
                          <?php if ($result) {
                            while ($rows = mysqli_fetch_array($result)) {
                              $user_id  = $rows['user_id'];
                              $sql_user = "SELECT * FROM users WHERE id = $user_id";
                              $row      = mysqli_fetch_array(mysqli_query($conn, $sql_user));
                              if ($row) {
                                $customer_name  = $row['first_name'];
                                $account_number = $row['account_number'];
                              } else {
                                $customer_name  = 'Unknown';
                                $account_number = 'N/A';
                              }
                          ?>
                              <tr>
                                <td><?php if (isset($rows['type']) && $rows['type'] == 'warehouse') { ?>
                                    <a href="tracking.php?tracking=<?php echo htmlspecialchars($rows['tracking_number'] ?? ''); ?>" style="color: #E87946;">
                                      <?php echo htmlspecialchars($rows['tracking_number'] ?? ''); ?>
                                    </a>
                                  <?php } else {
                                      echo htmlspecialchars($rows['tracking_number'] ?? '');
                                    } ?>
                                </td>
                                <td class="text-end"><?php echo isset($account_number) ? htmlspecialchars($account_number) : '—'; ?></td>
                                <!-- <td class="text-end"><?php echo (isset($rows['type']) && $rows['type'] == 'prealert') ? 'Pre-alert' : 'Warehouse Processed'; ?></td> -->
                                <td class="text-end"><?php echo !empty($rows['courier_company']) ? ucfirst(htmlspecialchars($rows['courier_company'])) : 'N/A'; ?></td>
                                <td class="text-end"><?php echo (isset($rows['weight']) && $rows['weight'] != 0) ? htmlspecialchars($rows['weight']) . " lbs" : '—'; ?></td>
                                <td class="text-end"><?php echo (!empty($rows['store']) && $rows['store'] != 0) ? htmlspecialchars($rows['store']) : '—'; ?></td>
                                <td><span class="item_value"><?php
                                                              // show package_value if present; if not for warehouse items, calculate using rates
                                                              if (isset($rows['package_value']) && $rows['package_value'] != "0" && $rows['package_value'] !== null) {
                                                                echo "\$ " . htmlspecialchars(number_format($rows['package_value'], 2));
                                                              } else {
                                                                // try to calculate if weight available and this is a warehouse record
                                                                if (isset($rows['weight']) && is_numeric($rows['weight']) && $rows['weight'] > 0) {
                                                                  echo "\$ " . number_format(calculate_value_of_package(floatval($rows['weight'])), 2);
                                                                } else {
                                                                  echo '—';
                                                                }
                                                              }
                                                              ?></span></td>
                                <td class="text-end"><?php echo htmlspecialchars($rows['describe_package'] ?? ''); ?></td>
                                <td class="text-end"><?php echo (!empty($rows['created_at'])) ? date('d/m/y', strtotime($rows['created_at'])) : ''; ?></td>
                                <!-- <td class="text-end"><a href="tracking.php?tracking=<?php echo htmlspecialchars($rows['tracking_number'] ?? ''); ?>">View</a></td>
                                <td class="text-end"><a href="#" class="update-payment-user" data-tracking="<?php echo htmlspecialchars($rows['tracking_number'] ?? ''); ?>">Update</a></td> -->
                              </tr>
                          <?php }
                          } ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <!-- Pagination -->
                  <!-- Pagination -->
                  <div class="mt-3 panel-footer">
                    <div class="row">
                      <div class="col col-sm-6 col-xs-6">
                        Showing <b><?php echo mysqli_num_rows($result); ?></b> out of <b><?php echo $total_packages; ?></b> entries
                      </div>
                      <div class="col-sm-6 col-xs-6">
                        <ul class="pagination justify-content-end" style="color:black;">
                          <?php
                          $base_url = "?type=$type_filter";
                          if ($status_filter) $base_url .= "&filter=$status_filter";
                          ?>

                          <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                            <a class="page-link" href="<?php echo ($page > 1) ? $base_url . "&page=" . ($page - 1) : '#'; ?>">&laquo;</a>
                          </li>

                          <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                              <a class="page-link" href="<?php echo $base_url; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                            </li>
                          <?php endfor; ?>

                          <li class="page-item <?php echo ($page >= $total_pages) ? 'disabled' : ''; ?>">
                            <a class="page-link" href="<?php echo ($page < $total_pages) ? $base_url . "&page=" . ($page + 1) : '#'; ?>">&raquo;</a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </div>
                <?php
                } else {
                  ?>
                  <div class="card-header">
                    <div class="card-head-row card-tools-still-right justify-content-center">
                      <div style="font-size: 18px;" class="card-title">
                        <h1>My Packages<?php if ($status_filter) echo ' - ' . htmlspecialchars($status_filter); ?></h1>
                      </div>
                      <div class="card-tools">
                        <select id="typeFilter" class="form-select" onchange="changeType(this.value)">
                          <option value="all" <?php echo $type_filter == 'all' ? 'selected' : ''; ?>>All</option>
                          <option value="warehouse" <?php echo $type_filter == 'warehouse' ? 'selected' : ''; ?>>Warehouse Records</option>
                          <option value="prealert" <?php echo $type_filter == 'prealert' ? 'selected' : ''; ?>>Pre-alerts</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="p-0 card-body">
                    <div class="table-responsive">
                      <table id="mypackages" class="table mb-0 ">
                        <thead class="thead-light">
                          <tr>
                            <th>Tracking</th>
                            <th>PYNC ID</th>
                            <!-- <th>Type</th> -->
                            <th>Courier Company</th>
                            <th>Weight</th>
                            <th>Store</th>
                            <th>Value of Package (USD)</th>
                            <th>Package Description</th>
                            <th>Date</th>
                            <!-- <th>View</th>
                            <th>Payment Status</th> -->
                          </tr>
                        </thead>
                        <tbody style="text-align-last: center;"></tbody>
                          <tr>
                            <td colspan="9" style='text-align: center; padding: 50px; font-size: 20px;line-height: 21px;'><center>No Package available.</center></td>
                          </tr>
                      </table>
                    </div>
                  </div>
                <?php
                }
                ?>
              </div>
            </div>
          </div>
          <!--My package end-->
        </div>
        <footer class="footer">
          <div>
            <p class="text-center">
              <small>&copy; 2025 Pync Parcel Chateau Limited. All rights reserved.</small>
            </p>
          </div>
        </footer>
      </div>
    </div>
    <!--   boostrap   -->
    <script src="assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="assets/js/core/popper.min.js"></script>
    <script src="assets/js/core/bootstrap.min.js"></script>
    <script src="assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
    <script src="assets/js/kaiadmin.min.js"></script>
    <script src="assets/js/custom.js"></script>
    <script>
      function changeType(type) {
        const url = new URL(window.location);
        url.searchParams.set('type', type);
        url.searchParams.delete('page'); // Reset to page 1
        window.location.href = url.toString();
      }
    </script>
    <!-- Payment status modal -->
    <div class="modal fade" id="paymentStatusModalUser" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Update Payment Status</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <input type="hidden" id="psu_tracking" />
            <div class="mb-2">
              <label class="form-label">Status</label>
              <select id="psu_status" class="form-select">
                <option value="Pending">Pending</option>
                <option value="Paid">Paid</option>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" id="psu_save" class="btn btn-primary">Save</button>
          </div>
        </div>
      </div>
    </div>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.update-payment-user').forEach(function(el) {
          el.addEventListener('click', function(e) {
            e.preventDefault();
            document.getElementById('psu_tracking').value = this.dataset.tracking;
            var modal = new bootstrap.Modal(document.getElementById('paymentStatusModalUser'));
            modal.show();
          });
        });
        document.getElementById('psu_save').addEventListener('click', function() {
          var tracking = document.getElementById('psu_tracking').value;
          var status = document.getElementById('psu_status').value;
          fetch('../update_payment_status.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'tracking=' + encodeURIComponent(tracking) + '&status=' + encodeURIComponent(status)
          }).then(function(res) {
            return res.json();
          }).then(function(data) {
            if (data && data.success) {
              alert('Payment status updated to ' + data.new_status);
              location.reload();
            } else {
              alert('Failed to update payment status');
            }
          }).catch(function() {
            alert('Network error');
          });
        });
      });
    </script>
</body>

</html>
