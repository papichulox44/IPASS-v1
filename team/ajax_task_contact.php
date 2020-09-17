<?php  
 include_once '../conn.php';
 if(isset($_POST["task_id"]))  
 {
      $user_type = $_POST["user_type"];
      $select_task = mysqli_query($conn, "SELECT * FROM task WHERE task_id = '".$_POST["task_id"]."'");  
      $fetch_select_task = mysqli_fetch_array($select_task);

      $task_contact = $fetch_select_task['task_contact'];

      $result_select_contact = mysqli_query($conn, "SELECT * FROM contact WHERE contact_id = '$task_contact'");  
      $fetch_select_contact = mysqli_fetch_array($result_select_contact);
 }
 if(isset($_POST["update_contact"]))  
 {
    $contact_id = $_POST['admin_contact_id']; 
    $fname = $_POST['admin_fname']; 
    $mname = $_POST['admin_mname']; 
    $lname = $_POST['admin_lname']; 
    $bdate = $_POST['admin_bdate']; 
    $gender = $_POST['admin_gender'];
    $email = $_POST['admin_email'];  
    $fbname = $_POST['admin_fbname'];
    $messenger = $_POST['admin_messenger'];
    $country = $_POST['admin_country']; 
    $city = $_POST['admin_city']; 
    $zip = $_POST['admin_zip']; 
    $street = $_POST['admin_street']; 
    $cnumber = $_POST['admin_cnumber']; 
    $location = $_POST['admin_location'];

   mysqli_query($conn, "UPDATE contact SET contact_fname='$fname', contact_mname='$mname', contact_lname='$lname', contact_bdate='$bdate', contact_gender='$gender', contact_email='$email', contact_fbname='$fbname', contact_messenger='$messenger', contact_cpnum='$cnumber',  contact_country='$country', contact_city='$city', contact_zip='$zip', contact_street='$street', contact_location='$location' WHERE contact_id = '$contact_id'") or die(mysqli_error());
 }
 ?>         
<!-- Personal Details -->      
    <h2 class="content-heading" style="margin-top: -40px;">
        <span id="id_contact" class="badge float-right mt-5" style="font-size: 13px; color: #fff; background-color: #0d7694;">Contact ID: <?php echo $fetch_select_contact['contact_id'];?></span>
        Personal Details
    </h2>
    <div class="row items-push">
        <div class="col-lg-3">
            <div class="block block-themed text-center">
                <div class="block-content block-content-full block-sticky-options pt-30" style="background-color: #e6e6e6;">
                    <?php if($fetch_select_contact['contact_profile'] != ""): ?>
                        <img style="width: 100%; border-radius: 100%;" src="../client/client_profile/<?php echo $fetch_select_contact['contact_profile']; ?>">
                    <?php else: ?>
                        <img style="width: 100%; border-radius: 100%;" src="../assets/media/photos/avatar.jpg">
                    <?php endif; ?>  
                </div>
                <div class="block-content block-content-full block-content-sm" style="background-color: #0d7694;">
                    <div class="font-w600 text-white mb-5"><?php echo $fetch_select_contact['contact_fname'] . " " . $fetch_select_contact['contact_mname'] . " " . $fetch_select_contact['contact_lname'];?></div>
                    <div class="font-size-sm text-white-op">Contact Name</div>
                </div>
                <div class="block-content text-left">
                    <div class="row items-push">
                        <p class="text-muted">
                            <?php
                                $user_id = $fetch_select_contact['contact_created_by'];
                                $select_user = mysqli_query($conn, "SELECT * FROM user WHERE user_id = '$user_id'");
                                $fetch_select_user = mysqli_fetch_array($select_user);
                            ?>
                            Created by: <?php echo $fetch_select_user['fname'];?> <?php echo $fetch_select_user['mname'];?> <?php echo $fetch_select_user['lname'];?><br>
                            Date: <?php echo $fetch_select_contact['contact_date_created'];?><br>
                            Username:<br> <strong class="badge" style="font-size: 13px; color: #fff; background-color: #0d7694;"><?php echo $fetch_select_contact['contact_email'];?></strong><br>
                            Password:<br> <strong class="badge" style="font-size: 13px; color: #fff; background-color: #0d7694;"><?php echo $fetch_select_contact['contact_password'];?></strong>
                        </p> 
                    </div>
                </div>
            </div>                                   
        </div>
        <?php
            if($user_type == "Admin")
            { ?>
                <div class="col-lg-7 offset-lg-1">
                    <div class="form-group row">
                        <div class="col-md-6">
                             <div class="form-group">
                                <input type="hidden" class="form-control" id="admin_contact_id" value="<?php echo $fetch_select_contact['contact_id'];?>" required>

                                <label for="crypto-settings-street-1">First Name</label>
                                <input type="text" class="form-control" id="admin_fname" value="<?php echo $fetch_select_contact['contact_fname'];?>" required>
                             </div>
                             <div class="form-group">
                                <label for="crypto-settings-street-1">Middle Name</label>
                                <input type="text" class="form-control" id="admin_mname" value="<?php echo $fetch_select_contact['contact_mname'];?>">
                             </div>
                             <div class="form-group">
                                <label for="crypto-settings-street-1">Last Name</label>
                                <input type="text" class="form-control" id="admin_lname" value="<?php echo $fetch_select_contact['contact_lname'];?>" required>
                             </div>
                             <div class="form-group">
                                <label for="crypto-settings-street-1">Birthdate</label>
                                <input type="date" class="form-control" id="admin_bdate" value="<?php echo $fetch_select_contact['contact_bdate'];?>" required>
                             </div>
                             <div class="form-group">
                                <label for="crypto-settings-street-1">Gender</label>
                                <select class="form-control text-muted" id="admin_gender" value="<?php echo $fetch_select_contact['contact_gender'];?>" required>
                                    <option></option>
                                    <?php
                                        if($fetch_select_contact['contact_gender'] == "Male")
                                        {
                                            echo '<option value="Male" selected>Male</option>
                                                  <option value="Female">Female</option>';
                                        }
                                        else if($fetch_select_contact['contact_gender'] == "Female")
                                        {
                                            echo '<option value="Male">Male</option>
                                                  <option value="Female" selected>Female</option>';
                                        }
                                        else
                                        {
                                            echo '<option value="Male">Male</option>
                                                  <option value="Female">Female</option>';
                                        }
                                    ?>
                                </select>
                             </div>
                             <div class="form-group">
                                <label for="crypto-settings-street-1">Email</label>
                                <input type="email" class="form-control" id="admin_email" value="<?php echo $fetch_select_contact['contact_email'];?>" required>
                             </div>
                             <div class="form-group">
                                <label for="crypto-settings-street-1">FB Name</label>
                                <input type="email" class="form-control" id="admin_fbname" value="<?php echo $fetch_select_contact['contact_fbname'];?>" required>
                             </div>
                        </div>
                        <div class="col-md-6">
                             <div class="form-group">
                                    <label for="crypto-settings-street-1">Messenger</label>
                                    <input type="text" class="form-control" id="admin_messenger" value="<?php echo $fetch_select_contact['contact_messenger'];?>">
                             </div>
                             <div class="form-group">
                                <label for="crypto-settings-street-1">Country</label>
                                <select class="form-control text-muted" style="width: 100%;" data-placeholder="Choose one.." id="admin_country" value="<?php echo $fetch_select_contact['contact_country'];?>">
                                    <option></option>
                                    <?php 
                                        if($fetch_select_contact['contact_country'] == $fetch_select_contact['contact_country'])
                                        {
                                            echo '<option value="'.$fetch_select_contact['contact_country'].'" selected>'.$fetch_select_contact['contact_country'].'</option>';
                                            include 'select_country.php';
                                        }
                                        else
                                        {
                                            include 'select_country.php';
                                        }
                                    ?>
                                </select>
                             </div>
                             <div class="form-group">
                                <label for="crypto-settings-street-1">City</label>
                                <input type="text" class="form-control" id="admin_city" value="<?php echo $fetch_select_contact['contact_city'];?>">
                             </div>
                             <div class="form-group">
                                <label for="crypto-settings-street-1">Zip Code</label>
                                <input type="text" class="form-control" id="admin_zip" value="<?php echo $fetch_select_contact['contact_zip'];?>">
                             </div>
                             <div class="form-group">
                                <label for="crypto-settings-street-1">Street</label>
                                <input type="text" class="form-control" id="admin_street" value="<?php echo $fetch_select_contact['contact_street'];?>">
                             </div>
                             <div class="form-group">
                                <label for="crypto-settings-street-1">Contact #</label>
                                <input type="number" class="form-control" id="admin_cnumber" value="<?php echo $fetch_select_contact['contact_cpnum'];?>" required>
                             </div>
                             <div class="form-group">
                                <label for="crypto-settings-street-1">Location</label>
                                <input type="text" class="form-control" id="admin_location" value="<?php echo $fetch_select_contact['contact_location'];?>" required>
                             </div>
                        </div>
                        <div class="col-12">
                             <div class="form-group">
                                <button type="submit" class="btn btn-sm btn-hero btn-noborder btn-primary btn-block" onclick="update_contact()">Update details</button>
                             </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
            }
            else
            { ?>
                <div class="col-lg-7 offset-lg-1">
                    <div class="form-group row">
                        <div class="col-md-6">
                             <div class="form-group">
                                <label for="crypto-settings-street-1">First Name</label>
                                <input type="text" class="form-control form-control-lg" id="crypto-settings-street-1" name="fname" value="<?php echo $fetch_select_contact['contact_fname'];?>" readonly>
                             </div>
                             <div class="form-group">
                                <label for="crypto-settings-street-1">Middle Name</label>
                                <input type="text" class="form-control form-control-lg" id="crypto-settings-street-1" name="fname" value="<?php echo $fetch_select_contact['contact_mname'];?>" readonly>
                             </div>
                             <div class="form-group">
                                <label for="crypto-settings-street-1">Last Name</label>
                                <input type="text" class="form-control form-control-lg" id="crypto-settings-street-1" name="fname" value="<?php echo $fetch_select_contact['contact_lname'];?>" readonly>
                             </div>
                             <div class="form-group">
                                <label for="crypto-settings-street-1">Birthdate</label>
                                <input type="text" class="form-control form-control-lg" id="crypto-settings-street-1" name="fname" value="<?php echo $fetch_select_contact['contact_bdate'];?>" readonly>
                             </div>
                             <div class="form-group">
                                <label for="crypto-settings-street-1">Gender</label>
                                <input type="text" class="form-control form-control-lg" id="crypto-settings-street-1" name="fname" value="<?php echo $fetch_select_contact['contact_gender'];?>" readonly>
                             </div>
                             <div class="form-group">
                                <label for="crypto-settings-street-1">Email</label>
                                <input type="text" class="form-control form-control-lg" id="crypto-settings-street-1" name="fname" value="<?php echo $fetch_select_contact['contact_email'];?>" readonly>
                             </div>
                             <div class="form-group">
                                <label for="crypto-settings-street-1">FB Name</label>
                                <input type="text" class="form-control form-control-lg" id="crypto-settings-street-1" name="fname" value="<?php echo $fetch_select_contact['contact_fbname'];?>" readonly>
                             </div>
                        </div>
                        <div class="col-md-6">
                             <div class="form-group">
                                <label for="crypto-settings-street-1">Messenger</label>
                                <input type="text" class="form-control form-control-lg" id="crypto-settings-street-1" name="fname" value="<?php echo $fetch_select_contact['contact_messenger'];?>" readonly>
                             </div>
                             <div class="form-group">
                                <label for="crypto-settings-street-1">Country</label>
                                <input type="text" class="form-control form-control-lg" id="crypto-settings-street-1" name="fname" value="<?php echo $fetch_select_contact['contact_country'];?>" readonly>
                             </div>
                             <div class="form-group">
                                <label for="crypto-settings-street-1">City</label>
                                <input type="text" class="form-control form-control-lg" id="crypto-settings-street-1" name="fname" value="<?php echo $fetch_select_contact['contact_city'];?>" readonly>
                             </div>
                             <div class="form-group">
                                <label for="crypto-settings-street-1">Zip Code</label>
                                <input type="text" class="form-control form-control-lg" id="crypto-settings-street-1" name="fname" value="<?php echo $fetch_select_contact['contact_zip'];?>" readonly>
                             </div>
                             <div class="form-group">
                                <label for="crypto-settings-street-1">Street</label>
                                <input type="text" class="form-control form-control-lg" id="crypto-settings-street-1" name="fname" value="<?php echo $fetch_select_contact['contact_street'];?>" readonly>
                             </div>
                             <div class="form-group">
                                <label for="crypto-settings-street-1">Contact #</label>
                                <input type="text" class="form-control form-control-lg" id="crypto-settings-street-1" name="fname" value="<?php echo $fetch_select_contact['contact_cpnum'];?>" readonly>
                             </div>
                             <div class="form-group">
                                <label for="crypto-settings-street-1">Location</label>
                                <input type="text" class="form-control form-control-lg" id="crypto-settings-street-1" name="fname" value="<?php echo $fetch_select_contact['contact_location'];?>" readonly>
                             </div>
                        </div>
                    </div>
                </div>
            </div>                        
            <?php
            }
        ?>
        