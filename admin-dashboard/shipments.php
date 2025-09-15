<?php
// initialize session
session_start();
include '../config.php';  // database connection
include '../function.php';  // function comes from user dashboard
include 'function.php';  // function comes from admin dashboard
include 'authorized-admin.php';
$current_file_name = basename($_SERVER['PHP_SELF']);  // getting current file name

// Pagination parameters
$limit = 50;  // Number of shipments per page
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Fetch total count for pagination
$sql_count = "SELECT COUNT(*) as total FROM shipments";
$result_count = mysqli_query($conn, $sql_count);
$total_shipments = mysqli_fetch_assoc($result_count)['total'];
$total_pages = ceil($total_shipments / $limit);

// Fetch paginated shipments from local DB
$sql = "SELECT * FROM shipments ORDER BY id DESC LIMIT $limit OFFSET $offset";
$result = mysqli_query($conn, $sql);

$shipments = [];
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        // Use snake_case column names directly
        $shipments[] = $row;
    }
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
              <li class="nav-item <?php echo $current_file_name == 'shipments.php' ? 'active' : ''; ?>">
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
              <a href="index.html" class="logo">
                <img src="assets/img/kaiadmin/logo_light.svg" alt="navbar brand" class="navbar-brand" height="20" />
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
                        <div class="d-flex justify-content-between add_shipping">
                            <h4 class="title">Shipments</h4>
                             <span data-toggle="modal" data-target="#create_shipping"><i class="fa-solid fa-plus"></i> New</span>
                        </div>
                    </div>
                </div>
                <div class="search-form">
                     <form action="#" class="input-group">
                        <input type="search" class="rounded form-control" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                        <button type="submit" class="btn btn-outline-primary"   data-mdb-ripple-init> <img class="search-icon" src="assets/img/search.png" alt="" /></button>
                     </form>
                  </div>
                <div class="loading"
                    style="color:#E87946; text-align: center;   font-size: 20px;   margin-bottom: 10px;">
                    <span style="background: #E87946;  margin-right: 10px;"
                        class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true">
                    </span>Loading...
                </div>
<div class="panel-body table-responsive" style="display: none;">
    <table class="table m-auto shadow table-striped table-hover table-bordered">
        <thead class="table-light">
            <tr>
                <th>Shipment Number</th>
                <th>Type</th>
                <th>Origin</th>
                <th>Destination</th>
                <th>Status</th>
                <th>Description</th>
                <th>Created at</th>
                <th>View</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($shipments)) { ?>
                <?php foreach ($shipments as $shipment) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($shipment['shipment_number']); ?></td>
                        <td><img src="assets/img/<?php echo strtolower($shipment['type']); ?>.png" alt="<?php echo htmlspecialchars($shipment['type']); ?>" /></td>
                        <td><?php echo htmlspecialchars($shipment['origin']); ?></td>
                        <td><?php echo htmlspecialchars($shipment['destination']); ?></td>
                        <td><span style="background:#fde047;padding: 4px; border-radius:5px;color:#222;font-size: 11px;display:inline-block"><?php echo htmlspecialchars($shipment['status']); ?></span></td>
                        <td><?php echo htmlspecialchars($shipment['description'] ?? 'N/A'); ?></td>
                        <td><?php echo htmlspecialchars(date('M d, Y, h:i A', strtotime($shipment['created_at']))); ?></td>
                        <td>
                            <ul class="action-list">
                                <li>
                                  <a href="shipments-view.php?id=<?php echo $shipment['id']; ?>">
                                     <i class="fa-solid fa-eye"></i>
                                  </a>
                                </li>
                            </ul>
                        </td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td colspan="8" style="text-align: center;">No shipments available</td>
                </tr>
            <?php } ?>
          </tbody>
    </table>
</div>
                <!-- Pagination -->
                <div class="mt-3 panel-footer">
                    <div class="row">
                        <div class="col col-sm-6 col-xs-6">Showing <b><?php echo count($shipments); ?></b> out of <b><?php echo $total_shipments; ?></b> entries</div>
                        <div class="col-sm-6 col-xs-6">
                            <ul class="pagination justify-content-end" style="color:black;">
                                <?php if ($page > 1) { ?>
                                    <li class="page-item"><a class="page-link" href="?page=<?php echo $page - 1; ?>"><</a></li>
                                <?php } else { ?>
                                    <li class="page-item disabled"><a class="page-link" href="#"><</a></li>
                                <?php } ?>
                                <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                                    <li class="page-item<?php echo $i == $page ? 'active' : ''; ?>"><a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                                <?php } ?>
                                <?php if ($page < $total_pages) { ?>
                                    <li class="page-item"><a class="page-link" href="?page=<?php echo $page + 1; ?>">></a></li>
                                <?php } else { ?>
                                    <li class="page-item disabled"><a class="page-link" href="#">></a></li>
                                <?php } ?>
                            </ul>
                            <ul class="pagination visible-xs pull-right d-none">
                                <?php if ($page > 1) { ?>
                                    <li class="page-item"><a class="page-link" href="?page=<?php echo $page - 1; ?>"><</a></li>
                                <?php } else { ?>
                                    <li class="page-item disabled"><a class="page-link" href="#"><</a></li>
                                <?php } ?>
                                <?php if ($page < $total_pages) { ?>
                                    <li class="page-item"><a class="page-link" href="?page=<?php echo $page + 1; ?>">></a></li>
                                <?php } else { ?>
                                    <li class="page-item disabled"><a class="page-link" href="#">></a></li>
                                <?php } ?>
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
    $(window).on('load', function() {
        // Page is fully loaded
        $('.table-responsive').show('slow');
        $('.loading').hide();
    });
</script>
