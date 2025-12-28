<!DOCTYPE html>

<!-- session start -->
<?php
    session_start();

    include("../../database/to_connect.php"); 

    // Set the inactivity time of 20 minutes (1200 seconds)
    $inactivity_time = 20 * 60;

    // Check if the last_timestamp is set and last_timestamp is greater than 20 minutes
    if (isset($_SESSION['last_timestamp']) && (time() - $_SESSION['last_timestamp']) > $inactivity_time) {
        // Unset and destroy the session
        session_unset();
        session_destroy();

        // Redirect user to login page
        header("Location: ../../database/logout_process.php");
        exit();
    } else {
        // Update the last timestamp
        $_SESSION['last_timestamp'] = time();

        // Regenerate new session id and delete old one to prevent session fixation attack
        session_regenerate_id(true);
    }
    
    $query = "SELECT * FROM user WHERE user_id = '".$_SESSION['adminID']."'"; 
    $result = mysqli_query($conn, $query); 

    $row = mysqli_fetch_assoc($result);
	$adminID = $row["user_id"];
    $nameAdmin = $row["full_name"];
    $user_type = $row["user_type"];

    if (isset($_GET['success']) && $_GET['success'] == 'trueDelete') {
        $alert_type = 'success';
        $alert_message = "Successfully delete the attendance's information.";
    }
?>
<!-- end session start -->

<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SMART FINGERPRINT SECURITY DOOR SYSTEM</title>

    <!-- Icon tab -->
    <link rel="icon" href="../../css/pictures/logo_2.png">

    <!-- Custom fonts for this template -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">     
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../../css/sb-admin-2.min.css" rel="stylesheet">
    <link href="../../css/dashboard_interface.css" rel="stylesheet">

    <!-- Bootstrap core JavaScript-->
    <script src="../../jQuery/jquery.min.js"></script>
    <script src="../../jQuery/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../../jQuery/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../../jQuery/sb-admin-2.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../../jQuery/datatables-demo.js"></script>
    <script src="../../jQuery/jquery.dataTables.min.js"></script>
    <script src="../../jQuery/dataTables.bootstrap4.min.js"></script>
    <link href="../../css/dataTables.bootstrap4.min.css" rel="stylesheet">

    <!-- Calling validation function-->
    <script src="../../jQuery/jScript.js"></script>

    <style>
        #text-center{
            text-align: center;
        }

        .col-auto {
            padding-right: 1px !important;
            padding-left: 2px !important;
        }

        @media print {
            body * {
                visibility: hidden;
            }
            #printContent, #printContent *, #title, #title *, #printDateTitle, #printDateTitle * {
                visibility: visible;
            }
            #printContent {
                position: fixed;
                top: 100px;
                left: 0;
                right: 0;
                margin: 0 auto;
                width: 100%;
                text-align: center;
            }
            #printDateTitle {
                position: fixed;
                top: 70px;
                left: 0;
                right: 0;
                background-color: white;
                color: black;
            }
            #title {
                position: fixed;
                top: 10px;
                left: 0;
                right: 0;
                background-color: white;
                z-index: 9999;
                font-size: 25px;
                color: black;
            }
            
            #printContent table {
                font-size: 17px;
                border-collapse: collapse;
            }

            /* Hide the "Action" column header and data */
            #printContent th:nth-child(4),
            #printContent td:nth-child(5) {
                display: none;
            }

            /* Completely remove the "Action" column to prevent table misalignment */
            #printContent tr th:nth-child(4),
            #printContent tr td:nth-child(5) {
                width: 0;
                padding: 0;
                border: none;
            }

            /* Set portrait orientation */
            @page {
                size: portrait;
            }
        }

    </style>

</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">
            <br>
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div>
                    <?php if (isset($_SERVER['HTTP_USER_AGENT']) && (strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile') !== false || strpos($_SERVER['HTTP_USER_AGENT'], 'Tablet') !== false)): ?>
                        <img class="rounded-circle" src="../../css/pictures/logo_2.png" id="logo" width="100px" height="100px">
                    <?php else: ?>
                        <img class="rounded-circle" src="../../css/pictures/logo_2.png" id="logo" width="140px" height="120px" style="margin-top: 20px">
                        <br><br>
                    <?php endif; ?>
                </div>
            </a>
            
            <br><br>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Dashboard</span></a>
            </li>
            
            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <li class="nav-item">
                <a class="nav-link" href="resident.php">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Residents</span>
                </a>
            </li>
            
            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <li class="nav-item active">
                <a class="nav-link" href="report.php">
                    <i class="fas fa-fw fa-history"></i>
                    <span>History</span>
                </a>
            </li>
            
            <!-- Divider -->
            <hr class="sidebar-divider my-0">
            
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light topbar mb-4 static-top shadow">

                <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                    <i class="fa fa-bars"></i>
                </button>

                <script>
                    $(document).ready(function() {
                        $('#sidebarToggleTop').on('click', function() {
                            $('body').toggleClass('sidebar-toggled');
                            $('.sidebar').toggleClass('toggled');

                            // Check if sidebar is toggled
                            var isToggled = $('.sidebar').hasClass('toggled');
                        
                        });
                    });
                </script>

                    <!-- Topbar Navbar -->

                    <!-- Welcome Heading -->
                    <?php if (isset($_SERVER['HTTP_USER_AGENT']) && (strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile') !== false || strpos($_SERVER['HTTP_USER_AGENT'], 'Tablet') !== false)): ?>
                        <h6 class="h6 mb-0" style="color: #051d40; font-weight: bold;">Welcome!</h6>
                    <?php else: ?>
                        <h5 class="h5 mb-0" style="color: #051d40; font-weight: bold;">Welcome!</h5>
                    <?php endif; ?>

                    <ul class="navbar-nav ml-auto">

                        <div class="topbar-divider d-none d-sm-block"></div>
                        
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-3 d-none d-lg-inline" style="color: #051d40; font-size: 14px; letter-spacing: 1px"><b><?php echo strtoupper($user_type) ?></b></span>
                                <?php if (isset($_SERVER['HTTP_USER_AGENT']) && (strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile') !== false || strpos($_SERVER['HTTP_USER_AGENT'], 'Tablet') !== false)): ?>
                                    <img src="../../css/pictures/admin.png" alt="" style="width:40px; height:40px;" class="rounded-circle">
                                <?php else: ?>
                                    <img src="../../css/pictures/admin.png" alt="" width="50px" height="50px" class="rounded-circle">
                                <?php endif; ?>
                            </a>
                            <div class="dropdown">
                                <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                    <div class="dropdown-user-scroll scrollbar-outer">
                                        <div class="user-box d-flex align-items-center">
                                            <div class="avatar-lg">
                                                <img src="../../css/pictures/admin.png" alt="Profile Image" class="avatar-img rounded-circle">
                                            </div>
                                            <div class="u-text ml-3">
                                                <h4><?php echo $nameAdmin; ?></h4>
                                                <a href="profile.php" class="btn btn-sm mt-2 submitBtn">Profile</a>
                                            </div>
                                        </div>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-black-400"></i> Logout
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Start Logout Modal -->
                <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="warningTitle"><b><i class="fas fa-fw fa-exclamation-triangle"></i> Warning Notification</b></h5>
                    </div>
                    <div class="modal-body">
                        Are you sure to log out?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn notiClose" data-dismiss="modal">No</button>
                        <a type="button" class="btn notiConfirm" href="../../database/logout_process.php">Yes</a>
                    </div>
                    </div>
                </div>
                </div>
                <!-- End Logout Modal -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <?php if (isset($alert_type) && isset($alert_message)) { ?>
                        <div class="alert alert-<?php echo $alert_type; ?>" role="alert">
                            <?php echo $alert_message; ?>
                        </div>
                        <script>
                            setTimeout(function() {
                                document.querySelector('.alert').style.display = 'none';
                            }, 15000); // Hide the alert after 15 seconds
                        </script>
                    <?php } ?>

                    <!-- Page Heading -->
                    <h3 class="h3 mb-0 text-900" id="title">
                        <strong>
                            <i class="fas fa-fw fa-history"></i>
                            History
                        </strong>
                    </h3>

                    <br>

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold"><i class="fas fa-fw fa-fingerprint"></i> Attendance Record</h6>
                        </div>
                        <div class="card-body">

                            <?php if (isset($_SERVER['HTTP_USER_AGENT']) && (strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile') !== false || strpos($_SERVER['HTTP_USER_AGENT'], 'Tablet') !== false)): ?>
                                <form method="GET" action="report.php">
                                    <div class="row align-items-center g-0">
                                        <div class="col-auto">
                                            <h6 class="title_filter mb-0"><i class="fas fa-fw fa-filter" style="color: black"></i></h6>
                                        </div>
                                        <div class="col-auto">
                                            <input class="form-control" type="date" name="date_search" style="width: 140px" required>
                                        </div>
                                        <div class="col-auto">
                                            <button class="btn submitBtn" type="submit">
                                                <i class="fas fa-fw fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            <?php else: ?>
                                <form method="GET" action="report.php">
                                    <div class="row align-items-center g-0">
                                        <div class="col-auto">
                                            <h6 class="title_filter mb-0"><i class="fas fa-fw fa-filter" style="color: black"></i></h6>
                                        </div>
                                        <div class="col-auto">
                                            <input class="form-control" type="date" name="date_search" style="width: 160px" required>
                                        </div>
                                        <div class="col-auto">
                                            <button class="btn submitBtn" type="submit">
                                                <i class="fas fa-fw fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            <?php endif; ?>

                            <br>

                            <div style="float: right">
                                <button onclick="window.print()" class="btn submitBtn" id="print">
                                    <i class="fas fa-fw fa-print" id="print"></i> Print
                                </button>
                            </div>
                            
                            <br><br>

                            <?php
                                if(isset($_GET['date_search'])) {
                                    // Sanitize the search query to prevent SQL injection
                                    $search_date = mysqli_real_escape_string($conn, $_GET['date_search']);

                                    $formattedDateSearch = date('d/m/Y', strtotime($search_date));

                                    $query_attend_search = "SELECT 
                                                                attendance.attend_id,
                                                                attendance.attend_date, 
                                                                attendance.attend_time, 
                                                                resident.num_phone, 
                                                                user.full_name 
                                                            FROM attendance 
                                                            INNER JOIN resident ON attendance.user_id = resident.user_id 
                                                            INNER JOIN user ON resident.user_id = user.user_id  
                                                            WHERE attendance.attend_date = '$search_date'"; 
                                    $result_attend_search = mysqli_query($conn, $query_attend_search);
                                
                            ?>
                            <h6 id="printDateTitle" style="text-align: center; font-weight: bold; color: black; text-shadow: 0 2px 4px rgba(0, 0, 0 , 0.5);">
                                <?php echo $formattedDateSearch; ?>
                            </h6>

                            <div class="table-responsive" id="printContent">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" style="color: black;">
                                    <thead style="text-align:center">
                                        <tr>
                                            <th rowspan="2">Date</th>
                                            <th rowspan="2">Time</th>
                                            <th colspan="2">Resident Information</th>
                                            <th rowspan="2">Action</th>
                                        </tr>
                                        <tr>
                                            <th style="padding-right: 50px; padding-left: 50px;">Name</th> 
                                            <th>Number Phone</th>             
                                        </tr>           
                                    </thead>
                                    <tbody>
                                        <?php
                                            if (mysqli_num_rows($result_attend_search) > 0){
                                                while($row_s_attend = mysqli_fetch_assoc($result_attend_search)) { 
                                                    $resident_s_name = $row_s_attend["full_name"];
                                                    $resident_s_num_phone = $row_s_attend["num_phone"];
                                                    $attendance_s_date = $row_s_attend["attend_date"];
                                                    $attendance_s_time = $row_s_attend["attend_time"];
                                                    $attend_s_id = $row_s_attend["attend_id"];
                                            
                                                    $formattedSearchDate = date('d/m/Y', strtotime($attendance_s_date));
                                                    $formattedSearchTime = date('h:i A', strtotime($attendance_s_time));
                                        ?>
                                            
                                        <tr>
                                            <td id="text-center"><?php echo $formattedSearchDate;?></td>
                                            <td id="text-center"><?php echo $formattedSearchTime;?></td>
                                            <td><?php echo $resident_s_name;?></td>
                                            <td id="text-center"><?php echo $resident_s_num_phone;?></td>
                                            <td id="text-center">
                                                <a class="btn cancelBtn" data-toggle="modal" data-target="#deleteModalCenter<?php echo $attend_s_id;?>">
												   <i class="fas fa-solid fa-trash"></i>
												</a>
                                            </td>
                                        </tr>

                                        <!-- Start Delete Modal -->
                                        <div class="modal fade" id="deleteModalCenter<?php echo $attend_s_id;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="warningTitle"><b><i class="fas fa-fw fa-exclamation-triangle"></i> Warning Notification!</b></h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        Are you confirm to proceed delete this information? <br>
                                                        This cannot be undone!
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn notiClose" data-dismiss="modal">Close</button>
                                                        <a type="button" class="btn notiConfirm" href="../../database/delete_attendance.php?id=<?php echo $attend_s_id;?>">Confirm</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Delete Modal -->
                                            
                                        <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>

                            <?php
                                } else {

                            ?>
                            <div class="table-responsive" id="printContent">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" style="color: black;">
                                    <thead style="text-align:center">
                                        <tr>
                                            <th rowspan="2">Date</th>
                                            <th rowspan="2">Time</th>
                                            <th colspan="2">Resident Information</th>
                                            <th rowspan="2">Action</th>
                                        </tr>
                                        <tr>
                                            <th style="padding-right: 50px; padding-left: 50px;">Name</th> 
                                            <th>Number Phone</th>             
                                        </tr>           
                                    </thead>
                                    <tbody>
                                        <?php
                                            $query_attend = "SELECT 
                                                                attendance.attend_id,
                                                                attendance.attend_date, 
                                                                attendance.attend_time, 
                                                                resident.num_phone, 
                                                                user.full_name 
                                                            FROM attendance 
                                                            INNER JOIN resident ON attendance.user_id = resident.user_id 
                                                            INNER JOIN user ON resident.user_id = user.user_id  
                                                            ORDER BY attendance.attend_date DESC"; 
                                            $result_attend = mysqli_query($conn, $query_attend);
                                                                                        
                                            if (mysqli_num_rows($result_attend) > 0){
                                                while($row_attend = mysqli_fetch_assoc($result_attend)) { 
                                                    $resident_name = $row_attend["full_name"];
                                                    $resident_num_phone = $row_attend["num_phone"];
                                                    $attendance_date = $row_attend["attend_date"];
                                                    $attendance_time = $row_attend["attend_time"];
                                                    $attend_id = $row_attend["attend_id"];
                                            
                                                    $formattedDate = date('d/m/Y', strtotime($attendance_date));
                                                    $formattedTime = date('h:i A', strtotime($attendance_time));
                                        ?>
                                            
                                        <tr>
                                            <td id="text-center"><?php echo $formattedDate;?></td>
                                            <td id="text-center"><?php echo $formattedTime;?></td>
                                            <td><?php echo $resident_name;?></td>
                                            <td id="text-center"><?php echo $resident_num_phone;?></td>
                                            <td id="text-center">
                                                <a class="btn cancelBtn" data-toggle="modal" data-target="#deleteModalCenter<?php echo $attend_id;?>">
												   <i class="fas fa-solid fa-trash"></i>
												</a>
                                            </td>
                                        </tr>

                                        <!-- Start Delete Modal -->
                                        <div class="modal fade" id="deleteModalCenter<?php echo $attend_id;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="warningTitle"><b><i class="fas fa-fw fa-exclamation-triangle"></i> Warning Notification!</b></h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        Are you confirm to proceed delete this information? <br>
                                                        This cannot be undone!
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn notiClose" data-dismiss="modal">Close</button>
                                                        <a type="button" class="btn notiConfirm" href="../../database/delete_attendance.php?id=<?php echo $attend_id;?>">Confirm</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Delete Modal -->
                                            
                                        <?php
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php
                                }
                            ?>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; SMART FINGERPRINT SECURITY DOOR SYSTEM</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <script type="text/javascript">
        $('#dataTable').DataTable({
            "pagingType": "simple",
            "ordering": false
        });
    </script>

</body>

</html>