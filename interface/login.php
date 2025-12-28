<!DOCTYPE html>
<html lang="en">
<?php

    if (isset($_GET['error']) && $_GET['error'] == 'wrongPsw') {
        $alert_type = 'danger';
        $alert_message = "Wrong password!.";
    } elseif (isset($_GET['error']) && $_GET['error'] == 'wrongUsername') {
        $alert_type = 'danger';
        $alert_message = "Wrong username!.";
    }
    
?>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SMART FINGERPRINT SECURITY DOOR SYSTEM</title>

    <!-- Icon tab -->
    <link rel="icon" href="../css/pictures/logo_2.png">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../css/sb-admin-2.min.css" rel="stylesheet">
    <link href="../css/login_interface.css" rel="stylesheet">

    <!-- To prevent back -->
    <script type="text/javascript">
        function preventBack()
        {
            window.history.forward()
        };

        setTimeout("preventBack()",0);

        window.onunload=function()
        {
            null;
        }
    </script>
    <!-- End to prevent back -->

    <style>
        .form-control {
            border-radius: 30px;
            font-size: .8rem;
            height: 50px;
        }
        .h4 {
            margin-bottom: 10px !important;
        }
        #frontWallpaper {
            background-image: url(../css/pictures/wallpaper_1.png);
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
        }
    </style>

</head>

<body class="bg-gradient" id="frontWallpaper">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block">
                                <img src="../css/pictures/side_wallpaper.avif" style="width: 110%; height: 100%" alt="Image">
                            </div>
                            <div class="col-lg-6" id="login">
                                <div class="p-5">

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

                                    <div class="text-center">
                                        <img class="rounded-circle" src="../css/pictures/logo_2.png" style="height: 160px; width: 160px; margin-bottom: 10px">
                                        
                                        <h5 class="h5 text-900 mb-4" id="titleLogin"><b>Welcome Back!</b></h5>
                                    </div>
                                    <form class="user" id="loginForm" method="post" action="../database/login_process.php">
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="username" placeholder="Username" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control" name="password" placeholder="Password" required>
                                        </div>
                                        <button type="submit" class="btn btn-user btn-block" id="loginButton">
                                            LOGIN
                                        </button>
                                        <hr style="background-color: white">
                                    </form>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>