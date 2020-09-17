<?php
    include_once '../conn.php';
    if(isset($_POST['btn_create_contact']))
    {
        //echo "<script type='text/javascript'>alert('OK');</script>";
        $fname = $_POST['fname']; 
        $mname = $_POST['mname']; 
        $lname = $_POST['lname']; 
        $bdate = $_POST['bdate']; 
        $gender = $_POST['gender'];
        $email = $_POST['email'];  
        $fbname = $_POST['fbname'];
        $messenger = $_POST['messenger'];
        $cnumber = $_POST['cnumber']; 
        $country = $_POST['country']; 
        $city = $_POST['city']; 
        $zip = $_POST['zip']; 
        $street = $_POST['street']; 
        $location = $_POST['location']; 
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
                <div class="bg-image" style="background-image: url('../assets/media/photos/photo24@2x.jpg');">

                    <div class="row mx-0 bg-Default-op justify-content-center">
                        <div class="hero-static col-md-12">
                            <div class="content content-full overflow-hidden">
                                <!-- Header -->
                                <div class="py-30 text-center" style="margin-bottom: -20px;">
                                    <style type="text/css">
                                        .logo {width: 90px; margin: -20px 0px -50px 0px;}
                                    </style>
                                    <img src="../assets/media/photos/logo-ipass.png" class="logo"> 
                                </div>
                                <!-- END Header -->
                                <form class="js-validation-signin" method="post">
                                    <div class="block block-themed block-rounded block-shadow">
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
                                                        <input type="date" class="form-control" id="bdate" name="bdate" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-12">
                                                        <label for="login-username">Gender</label><span class="text-danger"> (require)</span>
                                                        <select class="form-control text-muted" id="gender" name="gender" required>
                                                            <option></option>
                                                            <option value="Male">Male</option>
                                                            <option value="Female">Female</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-12">
                                                        <label for="login-username">Email</label><span class="text-danger"> (require)</span>
                                                        <input type="email" class="form-control" id="email" name="email" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-12">
                                                        <label for="login-username">Fb Name</label><span class="text-danger"> (require)</span>
                                                        <input type="email" class="form-control" id="fbname" name="fbname" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group row">
                                                    <div class="col-12">
                                                        <label for="login-username">Messenger</label>
                                                        <input type="text" class="form-control" id="messenger" name="messenger">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-12">
                                                        <label for="login-username">Contact #</label><span class="text-danger"> (require)</span>
                                                        <input type="text" class="form-control" placeholder="eg: 0000-000-0000" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');" id="cnumber" name="cnumber" required>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-12">
                                                        <label for="login-username">Country</label>
                                                        <select class="form-control text-muted" id="example-select2" style="width: 100%;" data-placeholder="Choose one.." name="country"> <!-- add "js-select2" to class to have a search input -->
                                                            <option></option>
                                                            <?php include 'select_country.php'; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-12">
                                                        <label for="login-username">City</label>
                                                        <input type="text" class="form-control" id="city" name="city">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-12">
                                                        <label for="login-username">Zip Code</label>
                                                        <input type="text" class="form-control" id="zip" name="zip">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-12">
                                                        <label for="login-username">Street</label>
                                                        <input type="text" class="form-control" id="street" name="street">
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-12">
                                                        <label for="login-username">Location</label><span class="text-danger"> (require)</span>
                                                        <input type="text" class="form-control" id="location" name="location" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="block-content bg-body-light">
                                            <div class="form-group text-center row">
                                                <div class="col-sm-4">
                                                    <button type="submit" class="btn btn-sm btn-hero btn-noborder bg-corporate btn-block mb-5" name="btn_create_contact">
                                                        <span class="text-white"><i class="fa fa-plus mr-10"></i> Create</span>
                                                    </button>
                                                </div>
                                                <div class="col-sm-4">
                                                    <a class="btn btn-sm btn-hero btn-noborder btn-alt-secondary btn-block mb-5" href="sign_in.php">
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
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END Page Content -->

            </main>
            <!-- END Main Container -->
        </div>
        <!-- END Page Container -->

        <script src="../assets/js/codebase.core.min.js"></script>
        <script src="../assets/js/codebase.app.min.js"></script>
        <script src="../assets/js/plugins/jquery-validation/jquery.validate.min.js"></script>
        <script src="../assets/js/pages/op_auth_signin.min.js"></script>
    </body>
</html>