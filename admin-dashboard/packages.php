<?php
// initialize session
session_start();
include '../config.php'; // database connection
include '../function.php'; // function comes from user dashboard
include 'function.php'; // function comes from admin dashboard
include 'authorized-admin.php';
$current_file_name = basename($_SERVER['PHP_SELF']); // getting current file name
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Packages | Pync Parcel Chateau</title>
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <!-- CSS for Tracking icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet"
        href="https://unpkg.com/bs-brain@2.0.4/tutorials/timelines/timeline-5/assets/css/timeline-5.css">
    <!-- CSS Files -->
    <link rel="stylesheet" href="../user-dashboard/assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../user-dashboard/assets/css/kaiadmin.min.css" />
    <!-- font awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- custom css -->
    <link rel="stylesheet" href="../user-dashboard/assets/css/custom.css" />
    <link rel="stylesheet" href="assets/css/admin.css" />
</head>

<body>
    <div class="wrapper  admin">
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
                        <li class="nav-item <?php echo $current_file_name == 'packages.php' ? 'active' : ''; ?>">
                            <a href="packages.php">
                                <img class="package-icon" src="assets/img/package.png" alt="package" />
                                <p style="<?php echo $current_file_name == 'packages.php' ? 'color: #E87946 !important' : ''; ?>">Packages</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="customers.php">
                                <img class="user-icon" src="assets/img/user.png" alt="User" />
                                <p>Customers</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="prealerts.php">
                                <img class="package-icon" src="assets/img/sidebar-notification.png" alt="package" />
                                <p>Pre-alert</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="shipments.php">
                                <img class="user-icon" src="assets/img/boxes.png" alt="User" />
                                <p>Shipments</p>
                            </a>
                        </li>
                        <!-- <li class="nav-item">
                          <a  href="receivals.php">
                          <img class="user-icon" src="assets/img/receiver.png" alt="User" />
                            <p>Receivals</p>
                          </a>
                        </li> -->
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
                        <a href="index.html" class="logo">
                            <img src="assets/img/kaiadmin/logo_light.svg" alt="navbar brand" class="navbar-brand"
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
                                <a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
                                                            <img width="30px" height="30px"
                                                                src="assets/img/delivery.png" alt="delivery" />
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
                                                            <img width="30px" height="30px"
                                                                src="assets/img/shipped.png" alt="shipped" />
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
                                                                src="assets/img/growth.png" alt="growth" />
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
                                                            <span class="block"> Ready for Delivery
                                                                Instructions</span>
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
                                <span class="fw-bold"><?php echo user_account_information()['FName']; ?></span>
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
                                    <div>
                                        <div>
                                            <h4 class="title">Packages</h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="search-form">
                                    <form action="#" class="input-group">
                                        <input type="search" class="form-control rounded" placeholder="Search"
                                            aria-label="Search" aria-describedby="search-addon" />
                                        <button type="submit" class="btn btn-outline-primary" data-mdb-ripple-init>
                                            <img class="search-icon" src="assets/img/search.png"
                                                alt="" /></button>
                                    </form>
                                </div>
                                <div class="sort-form d-flex justify-content-between align-items-center">
                                    <form action="#" method="GET">
                                        <label for="sort">Sort by:</label>
                                        <select name="sort" id="sort" onchange="this.form.submit()">
                                            <option value="latest" <?php echo !isset($_GET['sort']) || $_GET['sort'] == 'latest' ? 'selected' : ''; ?>>Latest First</option>
                                            <option value="oldest" <?php echo isset($_GET['sort']) && $_GET['sort'] == 'oldest' ? 'selected' : ''; ?>>Oldest First</option>
                                        </select>
                                    </form>
                                    <form action="pull_packages.php" method="POST" style="margin:0;">
                                        <button type="submit" class="btn btn-warning">Pull Packages from
                                            Warehouse</button>
                                    </form>
                                </div>
                                <div class="loading"
                                    style="color:#E87946; text-align: center;   font-size: 20px;   margin-bottom: 10px;">
                                    <span style="background: #E87946;  margin-right: 10px;"
                                        class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true">
                                    </span>Loading...
                                </div>
                                <?php

            $sort = isset($_GET['sort']) ? $_GET['sort'] : 'latest';
            $order = ($sort == 'oldest') ? 'ASC' : 'DESC';
            $sql = "SELECT* FROM pre_alert ORDER BY Create_at $order";
            if (mysqli_num_rows(mysqli_query($conn, $sql)) > 0) {
              ?>
                                <div class="panel-body table-responsive shadow">
                                    <table class="table-area ">
                                        <thead>
                                            <tr>
                                                <th>Tracking</th>
                                                <th>Courier</th>
                                                <th>Description</th>
                                                <th>Customer</th>
                                                <th>Weight</th>
                                                <th>Item Value</th>
                                                <th>Status</th>
                                                <th>Inv Status</th>
                                                <th>Invoice</th>
                                                <th>Inv Total</th>
                                                <th>Created at</th>
                                                <th>View</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                              $result = mysqli_query($conn, $sql);
                                              echo "<pre>";
                                              print_r($result);die;
                                              while ($rows = mysqli_fetch_array($result)) {
                                                $User_id = $rows['User_id'];
                                                $sql = "SELECT* FROM users where id = $User_id";
                                                $row = mysqli_fetch_array(mysqli_query($conn, $sql));
                                                if ($row) {
                                                  $customer_name = $row['FName'];
                                                  $AccountNumber = $row['AccountNumber'];
                                                } else {
                                                  $customer_name = 'Unknown';
                                                  $AccountNumber = 'N/A';
                                                }

                                              ?>
                                            <tr>
                                                <td><?php echo $rows['Tracking_Number']; ?></td>
                                                <td><?php echo $rows['Courier_Company']; ?></td>
                                                <td><?php echo $rows['Describe_Package']; ?></td>
                                                <td> <span class="customer_name"> <?php echo $customer_name; ?></span> </td>
                                                <td>N/A</td>
                                                <td> <span class="item_value">$<?php echo $rows['Value_of_Package']; ?></span></td>
                                                <td> <span class="status">Undergoing Customs Clearance</span> </td>
                                                <td><span class="Inv-status">Open</span></td>
                                                <td> <span class="invoice">N/A</span></td>
                                                <td>$10</td>
                                                <td><?php echo timeAgo($rows['Create_at']); ?></td>
                                                <td>
                                                    <ul class="action-list">
                                                        <li>
                                                            <a href="package-view.php">
                                                                <i class="fa-solid fa-eye"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            <?php
                };

                ?>
                                            <tr>
                                                <td>76rt3276i45786324</td>
                                                <td>Amazon</td>
                                                <td>Laptop</td>
                                                <td> <span class="customer_name"> Abdul </span> </td>
                                                <td>6 lbs</td>
                                                <td> <span class="item_value">$10.00</span></td>
                                                <td> <span
                                                        style="background: hsl(140.6, 84.2%, 92.5%); color:hsl(142.4, 47.8%, 30.8%)"
                                                        class="status">Delivered</span> </td>
                                                <td><span class="Inv-status">Open</span></td>
                                                <td> <span class="invoice">N/A</span></td>
                                                <td>$10</td>
                                                <td> Apr 29, 2025, 10:43 PM </td>
                                                <td>
                                                    <ul class="action-list">
                                                        <li>
                                                            <a href="package-view.php">
                                                                <i class="fa-solid fa-eye"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>76rt3276i45786324</td>
                                                <td>Amazon</td>
                                                <td>Laptop</td>
                                                <td> <span class="customer_name"> Abdul </span> </td>
                                                <td>6 lbs</td>
                                                <td> <span class="item_value">$10.00</span></td>
                                                <td> <span
                                                        style="background:rgb(219, 234, 254); color:rgb(45, 110, 199);"
                                                        class="status">Received at Warehouse</span> </td>
                                                <td><span class="Inv-status">Open</span></td>
                                                <td> <span class="invoice">N/A</span></td>
                                                <td>$10</td>
                                                <td> Apr 29, 2025, 10:43 PM </td>
                                                <td>
                                                    <ul class="action-list">
                                                        <li>
                                                            <a href="package-view.php">
                                                                <i class="fa-solid fa-eye"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <?php
            } else {
              echo "<p class='text-center' style='font-size: 25px'>No Packages available.</p>";
            }
            ?>
                                <!--
                <div class="panel-footer">
                    <div class="row">
                        <div class="col col-sm-6 col-xs-6">showing <b>5</b> out of <b>25</b> entries</div>
                        <div class="col-sm-6 col-xs-6">
                            <ul class="pagination hidden-xs pull-right">
                                <li><a href="#"><</a></li>
                                <li class="active"><a href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                                <li><a href="#">4</a></li>
                                <li><a href="#">5</a></li>
                                <li><a href="#">></a></li>
                            </ul>
                            <ul class="pagination visible-xs pull-right">
                                <li><a href="#"><</a></li>
                                <li><a href="#">></a></li>
                            </ul>
                        </div>
                    </div>
                </div>-->
                            </div>
                        </div>
                    </div>

                    <!--Order history end-->
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
