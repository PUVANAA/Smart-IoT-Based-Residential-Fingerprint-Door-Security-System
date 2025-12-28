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

    if (isset($_GET['success']) && $_GET['success'] == 'true') {
        $alert_type = 'success';
        $alert_message = "Successfully saved the resident's information.";
    } elseif (isset($_GET['success']) && $_GET['success'] == 'trueUpdate') {
        $alert_type = 'success';
        $alert_message = "Successfully update the resident's information.";
    } elseif (isset($_GET['success']) && $_GET['success'] == 'trueDelete') {
        $alert_type = 'success';
        $alert_message = "Successfully delete the resident's information.";
    } elseif (isset($_GET['success']) && $_GET['success'] == 'trueDeleteAll') {
        $alert_type = 'success';
        $alert_message = "Successfully delete all the resident's information.";
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

    <script>
		function updateValValue() {
            $.ajax({
                url: 'update_value_scan.php', // Your PHP file for database update
                type: 'POST',
                data: {val_value: 2}, // Only send the value, not the student ID
                success: function(response) {
					console.log('val_value updated successfully');
				},
				error: function(xhr, status, error) {
					console.log('Error updating val_value: ' + error);
				}
            });
        }

        function updateValueAndShowModal(resident_id) {
            $.ajax({
                url: 'update_value_delete.php', // Your PHP file for database update
                type: 'POST',
                data: {val_value: 4}, // Only send the value, not the student ID
                success: function(response) {
                    if(response === 'success') {
                        // Once the database is updated, trigger the modal
                        $('#deleteModalCenter' + resident_id).modal('show');
                    } else {
                        alert('Error updating value');
                    }
                }
            });
        }

        function updateCancelDelete() {
            $.ajax({
                url: 'update_value_delete_cancel.php', // Your PHP file for database update
                type: 'POST',
                data: {val_value: 2}, // Only send the value, not the student ID
                success: function(response) {
					console.log('val_value updated successfully');
				},
				error: function(xhr, status, error) {
					console.log('Error updating val_value: ' + error);
				}
            });
        }
    </script>

    <style>
        #text-center{
            text-align: center;
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

            <li class="nav-item active">
                <a class="nav-link" href="resident.php">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Residents</span>
                </a>
            </li>
            
            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <li class="nav-item">
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
                            <i class="fas fa-fw fa-users"></i>
                            Residents
                        </strong>
                    </h3>

                    <br>

                    <div style="float: right">
                        <a class="btn submitBtn" id="updateValBtn" data-toggle="modal" data-target="#addModalCenter">
                            <i class="fas fa-fw fa-user-plus"></i> Register Resident
                        </a>
                    </div>
                    
                    <?php
                        // PHP code to update val_value in thumb_no table when click new student
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            mysqli_query($conn, "UPDATE thumb_no SET val_value='1'");
                        }
                    ?>

                    <!-- Start add Modal -->
                    <div class="modal fade" id="addModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">
                                        <i class="fas fa-fw fa-user-plus"></i> Register Resident
                                    </h5>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" action="../../database/register_resident.php"> <!-- Add action attribute here -->
                                        <div class="form-group">
                                            <label for="service-name" class="col-form-label">Full Name</label>
                                            <input class="form-control" type="text" id="fullName" name="fullName" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="service-price" class="col-form-label">Identity Card/Passport Number</label>
                                            <input class="form-control" type="text" name="ic_num" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="service-price" class="col-form-label">Number Phone</label>
                                            <input class="form-control" type="text" name="numPhone" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="service-price" class="col-form-label">Fingerprint ID</label>
                                            <select class="form-control" name="fingerID" required>
                                                <option value="" disabled selected>Please select the fingerprint ID</option>
                                                <?php 
                                                    // Fetch existing fingerprint IDs
                                                    $query_fingerID = "SELECT fingerprint_id FROM resident"; 
                                                    $result_fingerID = mysqli_query($conn, $query_fingerID);
                                                            
                                                    // Create an array to store the existing fingerprint IDs
                                                    $existing_fingerIDs = [];
                                                    if (mysqli_num_rows($result_fingerID) > 0){
                                                        while($row_finger = mysqli_fetch_assoc($result_fingerID)) { 
                                                            $existing_fingerIDs[] = $row_finger["fingerprint_id"];
                                                        }
                                                    }

                                                    // Generate the dropdown options, excluding existing fingerprint IDs
                                                    for ($i = 1; $i <= 127; $i++) {
                                                        if (!in_array($i, $existing_fingerIDs)) {
                                                            echo "<option value='$i'>$i</option>";
                                                        }
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" id="closeModalBtn" class="btn notiClose" data-dismiss="modal" onclick="updateValValue()">Close</button>
                                    <button type="submit" class="btn notiConfirm">Submit</button>
                                </div>
                                    </form>
                            </div>
                        </div>
                    </div>
                    <!-- End Add Modal -->

                    <br><br>
                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div style="float: right">
                                <a class="btn cancelBtn" style="width: 130px; margin-right: 3px; margin-left: 3px; margin-bottom: 3px" data-toggle="modal" data-target="#deleteAllModalCenter">
                                    <i class="fas fa-solid fa-trash"></i> Delete All
                                </a>
                            </div>

                            <br><br>

                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" style="color: black;">
                                    <thead style="text-align:center">
                                        <tr>
                                            <th>Resident ID</th>
                                            <th>Name</th>
                                            <th>Identity Card/Passport Number</th>
                                            <th>Number Phone</th>
                                            <th>Action</th>
                                        </tr>          
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $query_resident = "SELECT 
                                                                    user.full_name, 
                                                                    user.username, 
                                                                    user.user_id,
                                                                    resident.fingerprint_id, 
                                                                    resident.num_phone
                                                                FROM resident
                                                                INNER JOIN user ON resident.user_id = user.user_id 
                                                                ORDER BY resident.fingerprint_id ASC"; 
                                            $result_resident = mysqli_query($conn, $query_resident);
                                                
                                            if (mysqli_num_rows($result_resident) > 0){
                                                while($row_resident = mysqli_fetch_assoc($result_resident)) { 
                                                    $finger_id = $row_resident["fingerprint_id"];
                                                    $resident_name = $row_resident["full_name"];
                                                    $ic_number = $row_resident["username"];
                                                    $num_phone = $row_resident["num_phone"];
                                                    $resident_id = $row_resident["user_id"];
                                        ?>
                                        <tr>
                                            <td id="text-center"><?php echo $finger_id;?></td>
                                            <td><?php echo $resident_name;?></td>
                                            <td id="text-center"><?php echo $ic_number;?></td>
                                            <td id="text-center"><?php echo $num_phone;?></td>
                                            <td style="text-align: center">
                                                <a class="btn submitBtn" style="width: 40px; margin-right: 3px; margin-left: 3px; margin-bottom: 3px" data-toggle="modal" data-target="#editModalCenter<?php echo $resident_id;?>">
                                                    <i class="fas fa-solid fa-pen"></i>
                                                </a>
                                                <a class="btn cancelBtn" style="width: 40px; margin-right: 3px; margin-left: 3px; margin-bottom: 3px" 
												   data-toggle="modal" data-target="#deleteModalCenter<?php echo $resident_id;?>" 
												   onclick="updateValueAndShowModal(<?php echo $resident_id; ?>)">
												   <i class="fas fa-solid fa-trash"></i>
												</a>

                                            </td>
                                        </tr>
                                        <!-- Start Edit Modal -->
                                        <div class="modal fade" id="editModalCenter<?php echo $resident_id;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLongTitle">
                                                            <i class="fas fa-fw fa-pen"></i> Update Resident
                                                        </h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="POST" action="../../database/update_resident.php"> <!-- Add action attribute here -->
                                                            <div class="form-group">
                                                                <label for="service-name" class="col-form-label">Full Name</label>
                                                                <input class="form-control" type="text" id="fullName" name="fullName" value="<?php echo $resident_name; ?>" required>
                                                                <input class="form-control" type="hidden" id="residentID" name="residentID" value="<?php echo $resident_id; ?>" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="service-price" class="col-form-label">Identity Card/Passport Number</label>
                                                                <input class="form-control" type="text" name="ic_num" value="<?php echo $ic_number; ?>" required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="service-price" class="col-form-label">Number Phone</label>
                                                                <input class="form-control" type="text" name="numPhone" value="<?php echo $num_phone; ?>" required>
                                                            </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" id="closeModalBtn" class="btn notiClose" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn notiConfirm">Update</button>
                                                    </div>
                                                        </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Edit Modal -->
                                        <!-- Start Delete Modal -->
                                        <div class="modal fade" id="deleteModalCenter<?php echo $resident_id;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="warningTitle"><b><i class="fas fa-fw fa-exclamation-triangle"></i> Warning Notification!</b></h5>
                                                    </div>
                                                    <div class="modal-body">
                                                        Are you confirm to proceed delete <b><?php echo $resident_name; ?></b> information? <br>
                                                        This cannot be undone!
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn notiClose" data-dismiss="modal" onclick="updateCancelDelete()">Close</button>
                                                        <a type="button" class="btn notiConfirm" href="../../database/delete_resident.php?id=<?php echo $resident_id;?>&fingerID=<?php echo $finger_id; ?>">Confirm</a>
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

                        </div>
                    </div>
                    
                    <!-- Start Delete All Modal -->
                    <div class="modal fade" id="deleteAllModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="warningTitle"><b><i class="fas fa-fw fa-exclamation-triangle"></i> Warning Notification!</b></h5>
                                </div>
                                <div class="modal-body">
                                    Are you confirm to proceed delete all the resident's information? <br>
                                    This cannot be undone!
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn notiClose" data-dismiss="modal">Close</button>
                                    <a type="button" class="btn notiConfirm" href="../../database/delete_all_resident.php">Confirm</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Delete Modal -->

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

        document.getElementById("updateValBtn").addEventListener("click", function() {
            // AJAX request to update val_value using PHP
            var xhr = new XMLHttpRequest();
            xhr.open("POST", window.location.href, true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    // Trigger the modal after the update is successful
                    $('#addModalCenter').modal('show');
                }
            };
            xhr.send();
        });
    </script>

</body>

</html>