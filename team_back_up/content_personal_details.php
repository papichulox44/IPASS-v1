<?php
    include("../conn.php");
    $user_id = $row['user_id'];

    $md_primary_darker = "";
    $md_text = "text-muted";
    $md_body = "";
    if($mode_type == "Dark") //insert
    { 
        $md_primary_darker = "bg-primary-darker";
        $md_text = "text-white";
        $md_body = "bg-gray-darker text-body-color-light";
    }


      if(isset($_POST['btn_update_details']))
      {
        $fname     = $_POST['fname'];  
        $mname     = $_POST['mname'];  
        $lname     = $_POST['lname']; 
        $address     = $_POST['address'];  
        $cnumber     = $_POST['cnumber'];       
        $email     = $_POST['email'];   
        $bdate     = $_POST['bdate'];            

        $update = mysqli_query($conn, "UPDATE user SET fname='$fname',mname='$mname',lname='$lname',bdate='$bdate',email='$email',contact_number='$cnumber',address='$address' WHERE user_id='$user_id'") or die(mysqli_error());
        if($update)
        {
          echo "<script type='text/javascript'>alert('Data updated successfully...!');</script>";
                echo "<script>document.location='main_personal_details.php'</script>";
        }
        else
        {
          echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Cannot update data contact admin</div>';
        }
      }  
  
      if(isset($_POST['btn_change_password']))
      {
        $current = $_POST['current']; 
        $pwd1 = md5(mysqli_real_escape_string($conn,$_POST['pwd1']));
        
        if($row['password']==(md5($current)))
        {
            $update = mysqli_query($conn, "UPDATE user SET password='$pwd1' WHERE user_id='$user_id'") or die(mysqli_error());
            if($update)
            {
              echo "<script type='text/javascript'>alert('Password change successfully...!');</script>";
                    echo "<script>document.location='main_personal_details.php'</script>";
            }
            else
            {
              echo '<div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>Cannot update data contact admin</div>';
            }
        }
        else
        {   
            echo "<script type='text/javascript'>alert('Note: Please input the correct current password. Please try again.');</script>";          
        }
      }    
    ?>
<main id="main-container">
    <div class="content <?php echo $md_primary_darker; ?>">
        <div class="block">
            <div class="block-content block-rounded <?php echo $md_body; ?> shadow">                           
                <!-- User Profile -->
                <h2 class="content-heading <?php echo $md_text; ?>">
                    <span id="id_contact" class="badge bg-gray-dark float-right mt-5" style="font-size: 13px; color: #fff;">ID: <?php echo $row['user_id'];?></span>
                    Personal Details
                </h2>
                <div class="row items-push">
                    <div class="col-lg-4">
                        <div class="block block-themed text-center">                                         
                            <div class="block-content block-content-full block-sticky-options pt-30 <?php echo $md_primary_darker; ?>" style="background-color: #e6e6e6;">
                                    <?php if($row['profile_pic'] != ""): ?>
                                        <img class="prof" src="../assets/media/upload/<?php echo $row['profile_pic']; ?>">
                                    <?php else: ?>
                                        <img class="prof" src="../assets/media/photos/avatar.jpg">
                                    <?php endif; ?>
                            </div>
                            <div class="block-content block-content-full block-content-sm bg-gd-corporate">
                                <div class="font-w600 text-white mb-5"><?php echo $row['fname']; ?> <?php echo $row['mname']; ?> <?php echo $row['lname']; ?></div>
                                <div class="font-size-sm text-white-op">NAME</div>
                            </div>
                            <div class="block-content <?php echo $md_primary_darker; ?>">
                                <div class="row items-push">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="form-group row">
                            <div class="col-6">
                                <label for="crypto-settings-street-1">User ID</label>
                                <input type="text" class="form-control form-control-lg" id="crypto-settings-street-1" name="crypto-settings-street-1" value="<?php echo $row['user_id'];?>" readonly>
                            </div>
                            <div class="col-6">
                                <label for="crypto-settings-street-1">Username</label>
                                <input type="text" class="form-control form-control-lg" id="crypto-settings-street-1" name="username" value="<?php echo $row['username'];?>" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-6">
                                <label for="crypto-settings-street-1">Select picture</label>
                                <input class="form-control bg-corporate inputlable" type="file" name="file"  id="tran_attachment" required>
                            </div>                                            
                            <div class="col-6">
                                <label for="crypto-settings-street-1">Click Save</label>
                                <button type="button" class="btn btn-sm btn-hero btn-noborder btn-primary btn-block" onclick="update_profile()">Update</button>
                            </div>
                        </div>                                            
                    </div>
                </div>  
                <!-- END User Profile -->

                <!-- Personal Details -->
                <form method="post">
                    <h2 class="content-heading <?php echo $md_text; ?>">Personal Details</h2>
                    <div class="row items-push">
                        <div class="col-lg-3">
                            <p class="<?php echo $md_text; ?>">
                                Your personal information is never shown to other users.
                            </p>                                        
                        </div>
                        <div class="col-lg-7 offset-lg-1">
                            <div class="form-group row">
                                <div class="col-6">
                                    <label for="crypto-settings-street-1">First Name</label>
                                    <input type="text" class="form-control form-control-lg" id="crypto-settings-street-1" name="fname" value="<?php echo $row['fname'];?>" required>
                                </div>
                                <div class="col-6">
                                    <label for="crypto-settings-street-1">Middle Name</label>
                                    <input type="text" class="form-control form-control-lg" id="crypto-settings-street-1" name="mname" value="<?php echo $row['mname'];?>" required>
                                </div>
                            </div> 
                            <div class="form-group row">
                                <div class="col-6">
                                    <label for="crypto-settings-street-1">Last Name</label>
                                    <input type="text" class="form-control form-control-lg" name="lname" value="<?php echo $row['lname'];?>" required>
                                </div>
                                <div class="col-6">
                                    <label for="crypto-settings-street-1">Birthdate</label>
                                    <input type="date" class="form-control form-control-lg" id="crypto-settings-street-1" name="bdate" value="<?php echo $row['bdate'];?>" required>
                                </div>
                            </div> 
                            <div class="form-group row">                                            
                                <div class="col-6">
                                    <label for="crypto-settings-street-1">Email Address</label>
                                    <input type="email" class="form-control form-control-lg" name="email" value="<?php echo $row['email'];?>" required>
                                </div>
                                <div class="col-6">
                                    <label for="crypto-settings-street-1">Contact Number</label>
                                    <input type="text" class="form-control form-control-lg" name="cnumber" value="<?php echo $row['contact_number'];?>" placeholder="eg: 0000-000-0000" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required>
                                </div>
                            </div> 
                            <div class="form-group row">
                                <div class="col-12">
                                    <label for="crypto-settings-email">Address</label>
                                    <input type="text" class="form-control form-control-lg" id="crypto-settings-email" name="address" placeholder="Enter your email.." value="<?php echo $row['address'];?>" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <button type="but" class="btn btn-alt-primary" name="btn_update_details">Update</button>
                                </div>
                            </div>
                        </div>
                    </div>                                                         
                </form>
                <!-- END Personal Details -->   
                                            <!-- Change Password-->
                <form method="post" ... onsubmit="return checkForm(this);">
                    <h2 class="content-heading <?php echo $md_text; ?>">Change Password</h2>
                    <div class="row items-push">
                        <div class="col-lg-3">
                            <p class="<?php echo $md_text; ?>">
                                Changing your sign in password is an easy way to keep your account secure.
                            </p>
                            <p class="<?php echo $md_text; ?>">
                                Password must contain:<br>
                                * at least 6 characters<br>
                                * numeric character (0-9)<br>
                                * lowercase character (a-z)<br>
                                * uppercase character (A-Z)
                            </p>
                        </div>
                        <div class="col-lg-7 offset-lg-1">
                            <div class="form-group row">
                                <div class="col-12">
                                    <input type="hidden" class="form-control form-control-lg" id="crypto-settings-password" name="real" value="<?php echo $row['password'];?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <label for="crypto-settings-password">Current Password</label>
                                    <input type="text" class="form-control form-control-lg" id="crypto-settings-password" name="current" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <label for="crypto-settings-password-new">New Password</label>
                                    <input type="password" class="form-control form-control-lg" id="crypto-settings-password-new" name="pwd1" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <label for="crypto-settings-password-new-confirm">Confirm New Password</label>
                                    <input type="password" class="form-control form-control-lg" id="crypto-settings-password-new-confirm" name="pwd2" required>
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
                          /*if(form.current.value != form.real.value) {
                            alert("Note: Make sure you've entered the correct current password!");
                            form.current.focus();
                            return false;
                          }*/                               
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
                <!-- END Change Password -->
            </div>
        </div>
    </div>
</main>


<script type="text/javascript" src="../assets/js/jquery-1.6.4.min.js"></script>
<script type="text/javascript" src="../assets/js/jquery-3.2.1.min.js"></script>
<script src="../assets/js/jquery.min.js"></script>  

<script type="text/javascript">
    function update_profile()
    {
        user_id = <?php echo $user_id; ?>;
        tran_file = document.getElementById("tran_attachment").value; 

        // Get file size
        var fi = document.getElementById('tran_attachment');
        if(fi.files.length > 0)
        {
            for (var i = 0; i <= fi.files.length - 1; i++)
            {
                var fsize = fi.files.item(i).size;
                var get_size_in_MB = Math.round((fsize / 1024 / 1024)).toFixed(2); // Eliminate one "/1024" to get in
            }
        }
        // END Get file size

        if(tran_file == "")
        {
            alert('Please select image first.');
        }
        else if(get_size_in_MB >= 3.072) // Check if file >= 3MB
        {
            alert('File selected is ' + get_size_in_MB + 'MB. Please upload attachment not greater than 3 MB.');
            document.getElementById("tran_attachment").value = "";  
        }
        else
        {
            tran_attachment = $('#tran_attachment');
            file_attachment = tran_attachment.prop('files')[0];    
            formData = new FormData();
            formData.append('user_id', user_id);
            formData.append('file_attachment', file_attachment);
            formData.append('update_profile', 1);

            $.ajax({  
                url:"ajax.php",  
                method:"post",  
                data: formData,
                                      
                contentType:false,
                cache: false,
                processData: false,  
                success:function(data){  
                    if(data == "success")
                    { 
                        alert("Profile update successfully.");
                        location.reload();
                    }
                    else if(data == "format")
                    { 
                        alert("Attachment extension must be; jpg, JPG, jpeg, JPEG, png and PNG only."); 
                    }
                    else
                    {
                        alert("Upload attachment not greater than 3 MB.");
                    }
                }  
            });
        }
    }
</script>