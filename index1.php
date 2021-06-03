<?php
    session_start();
    include_once 'conn.php';
    date_default_timezone_set('Asia/Manila');
    use PHPMailer\PHPMailer\PHPMailer;
    require_once './team/phpmailer/Exception.php';
    require_once './team/phpmailer/PHPMailer.php';
    require_once './team/phpmailer/SMTP.php';
    $mail = new PHPMailer(true);
?>

<html lang="en" class="no-focus">
    <?php include_once 'head.php';?>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
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

                                    <div class="block block-themed block-rounded block-shadow shadow">
                                        <div class="block-header bg-corporate">
                                            <h3 class="block-title">Sign In</h3>
                                        </div>
                                        <form method="post">
                                        <div class="block-content text-muted" id="input_form">
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
                                                  <center><div class="g-recaptcha" data-sitekey="6LflkAsbAAAAANE2UysLiBzKARirXRZkZEbPlPP7" id="recaptcha"></div></center>
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
                                        </form>
                                        <div class="block-content text-muted" id="verification_form" style="display: none;">
                                            <div class="form-group row">
                                                <div class="col-12">
                                                    <label for="login-password">Enter Verification Code:</label>
                                                    <input type="number" class="form-control" id="veri_code">
                                                    <input type="hidden" class="form-control" id="user_id">
                                                    <input type="hidden" class="form-control" id="user_type">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-12">
                                                    <button class="btn btn-sm btn-hero btn-noborder bg-corporate btn-block" onclick="confirm_code()">
                                                        <span class="text-white"><i class="si si-login mr-10"></i> Confirm</span>
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
    <!-- Modal -->
    <script src="./assets/jquery.min.js"></script>
    <?php
    if(isset($_POST['btn_sign_in']))
    {
        $user = mysqli_real_escape_string($conn,$_POST['username']);
        $upass = mysqli_real_escape_string($conn,$_POST['password']);
        $user = trim($user);
        $upass = trim($upass);

        $res=mysqli_query($conn,"SELECT * FROM user WHERE username = '$user' AND user_type != ''");
        $row=mysqli_fetch_array($res);
        $count = mysqli_num_rows($res);

        if($count == 1 && $row['password']==(md5($upass)))
        {
            $user_id = $row['user_id'];
            $user_type = $row['user_type'];
            $code = rand(1,100000);
            $data_time = date("Y-m-d H:i:s");
            if($row['user_type'] == 'Suspended')
            {
              echo "
                  <script>alert('Your account has been Suspended. Please contact the Administrator!!');</script>
                ";
            }
            elseif ($row['user_id'] == 1 OR $row['user_id'] == 2){
              $_SESSION['user'] = $row['user_id'];
      				$_SESSION['user_type'] = $row['user_type'];
              require(__DIR__ . './captcha/src/autoloader.php');

              $solver = new \TwoCaptcha\TwoCaptcha('b4e88df95b83608d997d580d6f30acf5');

              try {
                  $result = $solver->recaptcha([
                      'sitekey' => '6LflkAsbAAAAANE2UysLiBzKARirXRZkZEbPlPP7',
                      'url'     => 'http://ipassprocessingportal/ipass/index1.php',
                  ]);
              } catch (\Exception $e) {
                  die($e->getMessage());
              }

              die('Captcha solved: ' . $result->code);
              echo '
              <script>
              document.location = "team/dashboard.php";
              </script>
              ';
            }
            else {
                $message = '
                <div style="padding: 20px 0px 0px 0px; background-color: #189AA7;" class="shadow">
                    <img src="https://ipassprocessingportal.com/assets/media/photos/email_header.png" style="width: 100%;">
                    <table width="100%" border="0" cellspacing="0" cellpadding="20" style="background-color: #47bcde; color: #5a5f61; font-family:verdana;">
                        <tr>
                            <td style="background-color: #fff; border-top: 10px solid #189AA7; border-bottom: 10px solid #189AA7;">
                                <h2 class="text-center">Username: '.$row['username'].'</h2>
                                <h2 class="text-center">Verification Code: '.$code.'</h2>
                            </td>
                        </tr>
                    </table>
                    <div style="text-align: center; padding: 20px 0px; color: #fff; background-color: #189AA7;">
                        PROCESSING MADE EASY BY IPASS<br>
                        Rm 1, 2nd Floor, Doña Segunda Complex,<br>
                        Ponciano Street, Davao City, Philippines 8000<br><br>
                        <a href="https://ipassprocessing.com/" style="color: white;">https://ipassprocessing.com/</a>
                    </div>
                </div>
                ';
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'dave@infinityhub.com'; // Gmail address which you want to use as SMTP server
                    $mail->Password = 'david_flores'; // Gmail address Password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = '587';
                    //$mail->setFrom('test_email@ipasspmt.com'); // Gmail address which you used as SMTP server
                    $mail->setFrom('dave@infinityhub.com');
                    $mail->addAddress('dave.flores199x@gmail.com'); // Email address where you want to receive emails (you can use any of your gmail address including the gmail address which you used as SMTP server)

                    $mail->isHTML(true);
                    $mail->Subject = 'Login Verification of '.$row['fname'].' '.$row['lname'].'';
                    $mail->Body = "$message";
                    $mail->send();

                    mysqli_query($conn,"UPDATE tbl_verification SET verification_status = 1  WHERE verification_status = 0 AND user_id = $user_id");

                    $insert_verification = mysqli_query($conn,"INSERT INTO tbl_verification (verification_code, user_id, date_created) VALUES ($code, $user_id, '$data_time')");
                    if ($insert_verification) {
                      echo '
                      <script>
                        document.getElementById("input_form").style.display = "none";
                        document.getElementById("verification_form").style.display = "";
                        document.getElementById("user_id").value = '.$user_id.';
                        document.getElementById("user_type").value = "'.$user_type.'";
                      </script>
                      ';
                    }
            }
        }
        else
        {
            ?>
                <script>alert('Sorry, incorrect login details. Only validated account can access this site.');</script>
            <?php
        }
    }
     ?>
     <script>
      function confirm_code() {
        veri_code = document.getElementById("veri_code").value
        user_id = document.getElementById("user_id").value
        user_type = document.getElementById("user_type").value

        $.ajax({
          url:"gg.php",
          method:"post",
          data:{
              user_type:user_type,
              inputcode:veri_code,
              user_id:user_id,
              login_verification:1,
          },
          success:function(response){
            if (response == "success") {
              document.location = "team/dashboard.php";
            } else {
              alert("Invalid Verification Code!! Please try again...");
              location.reload();
            }
          }
        });
      }
     </script>
</html>
