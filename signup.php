<?php
        include("conn.php");

        if(isset($_POST['btn_add']))
        {
          $fname     = htmlspecialchars($_POST['fname']);
          $mname     = htmlspecialchars($_POST['mname']);
          $lname     = htmlspecialchars($_POST['lname']);
          $bdate     = $_POST['bdate'];
          $address     = htmlspecialchars($_POST['address']);
          $contact_number     = htmlspecialchars($_POST['contact_number']);
          $email     = htmlspecialchars($_POST['email']);
          $username     = htmlspecialchars($_POST['username']);
          $password     = md5(mysqli_real_escape_string($conn,$_POST['password']));

          $arrX = array("#AD0000","#AD0046","#AD006F","#AD00A1","#9000AD","#5600AD","#0015AD","#005FAD","#0088AD","#00ADA9","#00AD67","#00AD1D","#6FAD00","#A9AD00","#AD9000","#AD5F00","#AD2500","#5C797C","#39595C","#14292C");
          $randIndex = array_rand($arrX);
          $user_color = $arrX[$randIndex];

          $con = mysqli_query($conn, "SELECT * FROM user WHERE username='$username'");
          if(mysqli_num_rows($con) == 0)
          {
              $insert = mysqli_query($conn, "INSERT INTO user(fname,mname,lname,bdate,address,contact_number,email,username,password,user_color)
                VALUES('$fname','$mname','$lname','$bdate','$address','$contact_number','$email','$username','$password','$user_color')") or die(mysqli_error());
              if($insert)
              {
                echo "<script type='text/javascript'>alert('Data successfully added!!!');</script>";
                echo "<script>document.location='index.php'</script>";
              }
              else
              {
              echo "<script type='text/javascript'>alert('Opps database username not found');</script>";
              }
          }
          else
          {
            echo "<script type='text/javascript'>alert('Username already Exist...!');</script>";
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
                <div class="bg-image" style="background-image: url('assets/media/photos/Team.jpg');">

                    <div class="row mx-0 bg-corporate-op justify-content-center">
                        <div class="hero-static col-lg-8">
                            <div class="content content-full overflow-hidden">
                                <!-- Header -->
                                <div class="py-30 text-center" style="margin-bottom: -20px;">
                                    <style type="text/css">
                                        .logo {width: 90px; margin: -20px 0px -50px 0px;}
                                    </style>
                                    <img src="assets/media/photos/logo-ipass.png" class="logo">
                                </div>
                                <!-- END Header -->
                                <form class="js-validation-signin" method="POST" action="./signup.php" onsubmit="return checkForm(this);">
                                    <div class="block block-themed block-rounded block-shadow shadow">
                                        <div class="block-header bg-corporate">
                                            <h3 class="block-title">Create account</h3>
                                        </div>
                                        <div class="block-content row text-muted">
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <div class="col-12">
                                                        <label for="login-username">First Name</label><span class="text-danger"> (require)</span>
                                                        <input type="text" class="form-control" name="fname" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-12">
                                                        <label for="login-username">Middle Name</label>
                                                        <input type="text" class="form-control" name="mname">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-12">
                                                        <label for="login-username">Last Name</label><span class="text-danger"> (require)</span>
                                                        <input type="text" class="form-control" name="lname" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-12">
                                                        <label for="login-username">Birthdate</label><span class="text-danger"> (require)</span>
                                                        <input type="date" class="form-control" name="bdate" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-12">
                                                        <label for="login-username">Address</label><span class="text-danger"> (require)</span>
                                                        <input type="text" class="form-control" name="address" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <div class="col-12">
                                                        <label for="login-username">Contact Number</label><span class="text-danger"> (require)</span>
                                                        <input type="number" class="form-control" name="contact_number" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-12">
                                                        <label for="login-username">Email</label><span class="text-danger"> (require)</span>
                                                        <input type="email" class="form-control" name="email" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-12">
                                                        <label for="login-username">Username</label><span class="text-danger"> (require)</span>
                                                        <input type="text" class="form-control" name="username" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-12">
                                                        <label for="login-username">Password</label><span class="text-danger"> (require)</span>
                                                        <input type="password" class="form-control" name="password" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-12">
                                                        <label for="login-username">Confirm Password</label><span class="text-danger"> (require)</span>
                                                        <input type="password" class="form-control" name="confirm_password" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="block-content bg-body-light">
                                            <div class="form-group text-center row">
                                                <div class="col-sm-4">
                                                    <button type="submit" class="btn btn-sm btn-hero btn-noborder bg-corporate btn-block mb-5" name="btn_add">
                                                        <span class="text-white"><i class="fa fa-plus mr-10"></i> Create</span>
                                                    </button>
                                                </div>
                                                <div class="col-sm-4">
                                                    <a class="btn btn-sm btn-hero btn-noborder btn-alt-secondary btn-block mb-5" href="index.php">
                                                        <i class="si si-login mr-5"></i> Sign In
                                                    </a>
                                                </div>
                                                <div class="col-sm-4">
                                                    <a class="btn btn-sm btn-hero btn-noborder btn-alt-secondary btn-block mb-5" href="forgot_password.php">
                                                        <i class="fa fa-warning mr-5"></i> Forgot Password
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <!-- END Sign In Form -->
                                <script type="text/javascript">
                                  function checkForm(form)
                                  {
                                    if(form.password.value == form.confirm_password.value)
                                    {
                                      if(form.password.value.length < 6) {
                                        alert("Password must contain at least six characters!");
                                        form.password.focus();
                                        return false;
                                      }
                                      if(form.password.value == form.username.value) {
                                        alert("Password must be different from Username!");
                                        form.password.focus();
                                        return false;
                                      }
                                      re = /[0-9]/;
                                      if(!re.test(form.password.value)) {
                                        alert("Password must contain at least one number (0-9)!");
                                        form.password.focus();
                                        return false;
                                      }
                                      re = /[a-z]/;
                                      if(!re.test(form.password.value)) {
                                        alert("Password must contain at least one lowercase letter (a-z)!");
                                        form.password.focus();
                                        return false;
                                      }
                                      re = /[A-Z]/;
                                      if(!re.test(form.password.value)) {
                                        alert("Password must contain at least one uppercase letter (A-Z)!");
                                        form.password.focus();
                                        return false;
                                      }
                                    }
                                    else
                                    {
                                      alert("Confirmation not match. Please try again.");
                                      form.confirm_password.focus();
                                      return false;
                                    }
                                  }
                                </script>
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
