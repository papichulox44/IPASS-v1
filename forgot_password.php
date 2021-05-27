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
                        <div class="hero-static col-lg-6 col-xl-4">
                            <div class="content content-full overflow-hidden">
                                <!-- Header -->
                                <div class="py-30 text-center" style="margin-bottom: -20px;">
                                    <style type="text/css">
                                        .logo {width: 90px; margin: -20px 0px -50px 0px;}
                                    </style>
                                    <img src="assets/media/photos/logo-ipass.png" class="logo">
                                </div>
                                <!-- END Header -->
                                    <div class="block block-themed block-rounded block-shadow">
                                        <div class="block-header bg-corporate">
                                            <h3 class="block-title">Forgot password</h3>
                                        </div>
                                        <div class="block-content text-muted">
                                            <div class="form-group row">
                                                <div class="col-12">
                                                    <label for="login-username">Email</label>
                                                    <input type="email" class="form-control" id="email">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-12">
                                                    <button type="submit" class="btn btn-sm btn-hero btn-noborder bg-corporate btn-block" onclick="forgot_password()">
                                                        <span class="text-white"><i class="fa fa-send mr-10"></i> Send</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="block-content bg-body-light">
                                            <div class="form-group text-center">
                                                <a class="link-effect text-muted mr-10 mb-5 d-inline-block" href="signup.php">
                                                    <i class="fa fa-plus mr-5"></i> Create Account
                                                </a>
                                                <a class="link-effect text-muted mr-10 mb-5 d-inline-block" href="index.php">
                                                    <i class="si si-login mr-5"></i> Sign In
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
        <script src="./assets/js/codebase.core.min.js"></script>
        <script src="./assets/js/codebase.app.min.js"></script>
        <script src="./assets/js/plugins/jquery-validation/jquery.validate.min.js"></script>
        <script src="./assets/js/pages/op_auth_signin.min.js"></script>
        <script type="text/javascript">
            function forgot_password()
            {

                email = document.getElementById("email").value;
                // alert(email);
                if (email ==  '') {
                    alert('Please fill up valid email address!');
                } else {
                    if(confirm("Are you sure you?"))
                    {
                        $.ajax({
                        url:"gg.php",
                        method:"post",
                        data:{
                            email:email,
                            forgot_password:1,
                        },
                        success:function(response){
                             if (response == 'success') {
                                alert('Credentials already sent to your email. Thank you!')
                                location.replace("http://localhost/ipass/")
                             } else {
                                alert('Please input valid email. Thank you!');
                             }
                        }
                        });
                    }
                }
            }
        </script>

    </body>
</html>
