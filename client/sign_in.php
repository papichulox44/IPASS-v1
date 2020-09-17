<?php
    session_start();
    include_once '../conn.php';
    if(isset($_POST['btn_sign_in']))
    {
      $user = mysqli_real_escape_string($conn,$_POST['username']);
      $upass = mysqli_real_escape_string($conn,$_POST['password']);
      $user = trim($user);
      $upass = trim($upass);
      $res = mysqli_query($conn,"SELECT * FROM contact WHERE contact_email = '$user' AND contact_password = '$upass'");
      $row = mysqli_fetch_array($res);
      $count = mysqli_num_rows($res); 
      if($count == 1)
      {
        $_SESSION['contact'] = $row['contact_id'];
        $id = $row['contact_id'];
        //mysqli_query($conn, "UPDATE user SET log = '1' WHERE user_id = '$id'") or die(mysqli_error());
        echo "<script>document.location='dashboard.php'</script>";
      }      
      else
      {
        echo "<script type='text/javascript'>alert('Sorry, incorrect Sign In details. Please try again.');</script>";
        echo "<script>document.location='sign_in.php'</script>";
      } 

    }
?>
<!doctype html>
<html lang="en" class="no-focus">
    <?php include_once 'head.php';?>
    <body>
        <div id="page-container" class="main-content-boxed">

            <!-- Main Container -->
            <main id="main-container">

                <!-- Page Content -->
                <div class="bg-image" style="background-image: url('../assets/media/photos/cleint_bg.jpg');">

                    <div class="row mx-0 bg-Default-op justify-content-center">
                        <div class="hero-static col-lg-6 col-xl-4">
                            <div class="content content-full overflow-hidden">
                                <!-- Header -->
                                <div class="py-30 text-center" style="margin-bottom: -20px;">
                                    <style type="text/css">
                                        .logo {width: 90px; margin: -20px 0px -50px 0px;}
                                    </style>
                                    <img src="../assets/media/photos/logo-ipass.png" class="logo"> 
                                </div>
                                <!-- END Header -->
                                <form method="post">
                                    <div class="block block-themed block-rounded block-shadow">
                                        <div class="block-header bg-corporate">
                                            <h3 class="block-title">Sign In</h3>
                                        </div>
                                        <div class="block-content text-muted">
                                            <div class="form-group row">
                                                <div class="col-12">
                                                    <label for="login-username">Username</label>
                                                    <input type="email" class="form-control" name="username">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-12">
                                                    <label for="login-password">Password</label>
                                                    <input type="password" class="form-control" name="password">
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
                                                <a class="link-effect text-muted mr-10 mb-5 d-inline-block" href="#">
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