<?php
    session_start();
    include_once 'conn.php';
    date_default_timezone_set('Asia/Manila');

    if(isset($_POST['btn_sign_in']))
    {
        $user = mysqli_real_escape_string($conn,$_POST['username']);
        $upass = mysqli_real_escape_string($conn,$_POST['password']);
        $user = trim($user);
        $upass = trim($upass);

        $res=mysqli_query($conn,"SELECT user_id, username, password, user_type FROM user WHERE username = '$user' AND user_type != ''");
        $row=mysqli_fetch_array($res);
        $count = mysqli_num_rows($res);

        if($count == 1 && $row['password']==(md5($upass)))
        {
            $_SESSION['user'] = $row['user_id'];
            $_SESSION['user_type'] = $row['user_type'];
            $a_id = $row['user_id'];
            mysqli_query($conn, "UPDATE user SET log = '1' WHERE user_id = '$a_id'") or die(mysqli_error());
            if($row['user_type'] == 'Suspended')
            {
              echo "
                  <script>alert('Your account has been Suspended. Please contact the Administrator!!');</script>
                ";
            } else {
                header("Location:team/dashboard.php");
            }
        }
        else
        {
            ?>
                <script>alert('Sorry, incorrect login details. Only validated account can access this site.');</script>
            <?php
        }
    }
    $date_maintenance = '2020-11-05';
    if (date("Y-m-d") == $date_maintenance) {
    // header("Location: http://ipasspmt.com/");
?>


<?php } else { ?>
<html lang="en" class="no-focus">
    <?php include_once 'head.php';?>
    <body>
        <div id="page-container" class="main-content-boxed">
            <!-- Main Container -->
            <main id="main-container">
                <!-- Page Content -->
                <div class="bg-image" style="background-image: url('assets/media/photos/Team.jpg');">
                    <div class="row mx-0 bg-corporate-op justify-content-center">
                        <div class="hero-static col-lg-6 col-xl-4">
                            <div class="content content-full overflow-hidden">
                                <!-- Header -->
                                <div class="py-30 text-center" style="margin-bottom: -20px;">
                                    <style type="text/css">
                                        .logo {width: 90px; margin: -20px 0px -50px 0px;}
                                    </style>
                                    <img src="assets/media/photos/logo-ipass.png" class="logo corporate">
                                </div>
                                <!-- END Header -->
                                <form method="post">
                                    <div class="block block-themed block-rounded block-shadow shadow">
                                        <div class="block-header bg-corporate">
                                            <h3 class="block-title">Sign In</h3>
                                        </div>
                                        <div class="block-content text-muted">
                                            <div class="form-group row">
                                                <div class="col-12">
                                                    <label for="login-username">Username</label>
                                                    <input type="text" class="form-control" name="username" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-12">
                                                    <label for="login-password">Password</label>
                                                    <input type="password" class="form-control" name="password" required>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-12">
                                                    <button type="submit" class="btn btn-sm btn-hero btn-noborder bg-corporate btn-block" name="btn_sign_in">
                                                        <span class="text-white"><i class="si si-login mr-10"></i> Sign In</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="block-content bg-body-light">
                                            <div class="form-group text-center">
                                                <a class="link-effect text-muted mr-10 mb-5 d-inline-block" href="signup.php">
                                                    <i class="fa fa-plus mr-5"></i> Create Account
                                                </a>
                                                <a class="link-effect text-muted mr-10 mb-5 d-inline-block" href="forgot_password.php">
                                                    <i class="fa fa-warning mr-5"></i> Forgot Password
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <!-- END Sign In Form -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END Page Content -->
            </main>
            <!-- END Main Container -->
        </div>
        <!-- END Page Container -->
    </body>
</html>
<?php } ?>
