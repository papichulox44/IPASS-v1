<?php
    $contact_id = $row['contact_id'];
    if(isset($_POST['btn_change_password']))
    {
        $pwd1 = $_POST['pwd1'];  
        $update = mysqli_query($conn, "UPDATE contact SET contact_password = '$pwd1' WHERE contact_id='$contact_id'") or die(mysqli_error());
        if($update)
        {
            echo "<script type='text/javascript'>alert('Password change successfully...!');</script>";
            echo "<script>document.location='change_password.php'</script>";
        }
    } 
?>

<!-- Main Container -->
<main id="main-container">
    <!-- Page Content -->
    <div class="content">  
        <div class="block content" style="box-shadow:0px 2px 4px #b3b3b3;">
            <!-- Personal Details -->      
            <form method="post" ...="" onsubmit="return checkForm(this);">
                <h2 class="content-heading text-black">Change Password</h2>
                <div class="row items-push">
                    <div class="col-lg-3">
                        <p class="text-muted">
                            Changing your sign in password is an easy way to keep your account secure.
                        </p>
                        <p class="text-muted">
                            Password must contain:<br>
                            * at least 6 characters<br>
                            * numeric character (0-9)<br>
                            * lowercase character (a-z)<br>
                            * uppercase character (A-Z)<br>
                        </p>
                    </div>
                    <div class="col-lg-7 offset-lg-1">
                        <div class="form-group row">
                            <div class="col-12">
                                <input type="hidden" class="form-control form-control-lg" id="crypto-settings-password" name="real" value="<?php echo $row['contact_password'];?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-12">
                                <label for="crypto-settings-password">Current Password</label>
                                <input type="text" class="form-control form-control-lg" id="crypto-settings-password" name="current" required="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-12">
                                <label for="crypto-settings-password-new">New Password</label>
                                <input type="text" class="form-control form-control-lg" id="crypto-settings-password-new" name="pwd1" required="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-12">
                                <label for="crypto-settings-password-new-confirm">Confirm New Password</label>
                                <input type="text" class="form-control form-control-lg" id="crypto-settings-password-new-confirm" name="pwd2" required="">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-alt-primary" name="btn_change_password">Update</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <script type="text/javascript">
              function checkForm(form)
              {
                if(form.pwd1.value != "" && form.pwd1.value == form.pwd2.value) 
                {                                        
                  if(form.current.value != form.real.value) {
                    alert("Note: Make sure you've entered the correct current password!");
                    form.current.focus();
                    return false;
                  }                                      
                  if(form.pwd1.value == form.current.value) {
                    alert("Note: New password must be different from current password!");
                    form.pwd1.focus();
                    return false;
                  }
                  if(form.pwd1.value.length < 6) {
                    alert("Note: New password must contain at least six characters!");
                    form.pwd1.focus();
                    return false;
                  }
                  re = /[0-9]/;
                  if(!re.test(form.pwd1.value)) {
                    alert("Note: New password must contain at least one number (0-9)!");
                    form.pwd1.focus();
                    return false;
                  }
                  re = /[a-z]/;
                  if(!re.test(form.pwd1.value)) {
                    alert("Note: New password must contain at least one lowercase letter (a-z)!");
                    form.pwd1.focus();
                    return false;
                  }
                  re = /[A-Z]/;
                  if(!re.test(form.pwd1.value)) {
                    alert("Note: New password must contain at least one uppercase letter (A-Z)!");
                    form.pwd1.focus();
                    return false;
                  }
                } 
                else
                {
                  alert("Note: Confirm password not match, please try again.");
                  form.pwd2.focus();
                  return false;
                }
              }
            </script>
        </div> 
    </div>
    <!-- END Page Content -->
</main>
<!-- END Main Container -->