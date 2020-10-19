<?php
    $contact_id = $row['contact_id'];
    if(isset($_POST['update']))
    {

        $contact_id =  $row['contact_id'];

        $fname = $_POST['fname']; 
        $mname = $_POST['mname']; 
        $lname = $_POST['lname']; 
        $bdate = $_POST['bdate']; 
        $gender = $_POST['gender'];
        $email = $_POST['email'];  
        $fbname = $_POST['fbname'];
        $messenger = $_POST['messenger'];
        $country = $_POST['country']; 
        $city = $_POST['city']; 
        $zip = $_POST['zip']; 
        $street = $_POST['street']; 
        $cnumber = $_POST['cnumber']; 
        $location = $_POST['location'];
        $status = $_POST['status'];
        $nationality = $_POST['nationality'];

        $update = mysqli_query($conn, "UPDATE contact SET contact_fname='$fname', contact_mname='$mname', contact_lname='$lname', contact_bdate='$bdate', contact_gender='$gender', contact_email='$email', contact_fbname='$fbname', contact_messenger='$messenger', contact_cpnum='$cnumber',  contact_country='$country', contact_city='$city', contact_zip='$zip', contact_street='$street', contact_location='$location', contact_status='$status', contact_nationality='$nationality' WHERE contact_id = '$contact_id'") or die(mysqli_error());

        if($update == true)
        {
            echo "<script>document.location='personal_details.php'</script>";  
        }
        else
        {
            echo "";
        }
    }
    
?>

<!-- Main Container -->
<main id="main-container">
    <!-- Page Content -->
    <div class="content">  
        <div class="block content" style="box-shadow:0px 2px 4px #b3b3b3;">
            <!-- Personal Details -->      
            <h2 class="content-heading" style="margin-top: -40px;">
                <span id="id_contact" class="badge float-right mt-5" style="font-size: 13px; color: #fff; background-color: #0d7694;">Contact ID: <?php echo $row['contact_id']; ?></span>
                Personal Details
            </h2>
            <div class="row items-push">
                    <div class="col-lg-4">
                        <div class="block block-themed text-center">
                            <div class="block-content block-content-full block-sticky-options pt-30" style="background-color: #e6e6e6;">
                                <?php if($row['contact_profile'] != ""): ?>
                                    <img class="prof" src="client_profile/<?php echo $row['contact_profile']; ?>">
                                <?php else: ?>
                                    <img class="prof" src="../assets/media/photos/avatar.jpg">
                                <?php endif; ?>  
                            </div>
                            <div class="block-content block-content-full block-content-sm" style="background-color: #0d7694;">
                                <div class="font-w600 text-white mb-5"><?php echo $row['contact_fname'] . " " . $row['contact_mname'] . " " . $row['contact_lname'];?></div>
                                <div class="font-size-sm text-white-op">Contact Name</div>
                            </div>
                        </div>   
                        <div class="row">
                            <div class="col-12 mb-10">
                                 <style type="text/css">
                                    .inputlable 
                                    {
                                        border-radius: 10px;
                                        background: #064d87;
                                        color: #fff;
                                        text-align: center;
                                        padding-bottom: 32px;
                                    }
                                </style>
                                <input class="form-control inputlable bg-corporate" type="file" name="file" required="" id="tran_attachment">
                            </div>
                            <div class="col-12">
                                <button type="button" class="btn btn-sm btn-hero btn-noborder btn-primary btn-block" onclick="update_profile()">Upload profile</button>
                            </div>
                        </div>                              
                    </div> 

                <div class="col-lg-8">
                    <form method="post">
                        <div class="form-group row">
                            <div class="col-md-6">
                                 <div class="form-group">
                                    <label for="crypto-settings-street-1">First Name</label>
                                    <input type="text" class="form-control" id="crypto-settings-street-1" name="fname" value="<?php echo $row['contact_fname'];?>" required>
                                 </div>
                                 <div class="form-group">
                                    <label for="crypto-settings-street-1">Middle Name</label>
                                    <input type="text" class="form-control" id="crypto-settings-street-1" name="mname" value="<?php echo $row['contact_mname'];?>">
                                 </div>
                                 <div class="form-group">
                                    <label for="crypto-settings-street-1">Last Name</label>
                                    <input type="text" class="form-control" id="crypto-settings-street-1" name="lname" value="<?php echo $row['contact_lname'];?>" required>
                                 </div>
                                 <div class="form-group">
                                    <label for="crypto-settings-street-1">Birthdate</label>
                                    <input type="date" class="form-control" id="crypto-settings-street-1" name="bdate" value="<?php echo $row['contact_bdate'];?>" required>
                                 </div>
                                 <div class="form-group">
                                    <label for="crypto-settings-street-1">Gender</label>
                                    <select class="form-control text-muted" name="gender" value="<?php echo $row['contact_gender'];?>" required>
                                        <option></option>
                                        <?php
                                            if($row['contact_gender'] == "Male")
                                            {
                                                echo '<option value="Male" selected>Male</option>
                                                      <option value="Female">Female</option>';
                                            }
                                            else if($row['contact_gender'] == "Female")
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
                                    <label for="crypto-settings-street-1">Status</label>
                                    <select class="form-control text-muted" id="admin_status" name="status" required>
                                        <option disabled="" selected=""></option>
                                        <option value="Married" <?php if($row['contact_status'] == "Married") { echo 'selected'; } ?>>Married</option>
                                        <option value="Single" <?php if($row['contact_status'] == "Single") { echo 'selected'; } ?>>Single</option>
                                        <option value="Widow" <?php if($row['contact_status'] == "Widow") { echo 'selected'; } ?>>Widow</option>
                                        <option value="Annuled" <?php if($row['contact_status'] == "Annuled") { echo 'selected'; } ?>>Annuled</option>
                                    </select>
                                 </div>
                                 <div class="form-group">
                                    <label for="crypto-settings-street-1">Nationality</label>
                                    <input type="text" class="form-control" id="admin_nationality" name="nationality" value="<?php echo $row['contact_nationality'];?>" required>
                                 </div>
                                 <div class="form-group">
                                    <label for="crypto-settings-street-1">Email</label>
                                    <input type="email" class="form-control" id="crypto-settings-street-1" name="email" value="<?php echo $row['contact_email'];?>" required>
                                 </div>
                                 
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="crypto-settings-street-1">FB Name</label>
                                    <input type="email" class="form-control" id="crypto-settings-street-1" name="fbname" value="<?php echo $row['contact_fbname'];?>" required>
                                 </div>
                                 <div class="form-group">
                                    <label for="crypto-settings-street-1">Messenger</label>
                                    <input type="text" class="form-control" id="crypto-settings-street-1" name="messenger" value="<?php echo $row['contact_messenger'];?>">
                                 </div>
                                 <div class="form-group">
                                    <label for="crypto-settings-street-1">Country</label>
                                    <select class="form-control text-muted" id="example-select2" style="width: 100%;" data-placeholder="Choose one.." name="country" value="<?php echo $row['contact_country'];?>">
                                        <option></option>
                                        <?php 
                                            if($row['contact_country'] == $row['contact_country'])
                                            {
                                                echo '<option value="'.$row['contact_country'].'" selected>'.$row['contact_country'].'</option>';
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
                                    <input type="text" class="form-control" id="crypto-settings-street-1" name="city" value="<?php echo $row['contact_city'];?>">
                                 </div>
                                 <div class="form-group">
                                    <label for="crypto-settings-street-1">Zip Code</label>
                                    <input type="text" class="form-control" id="crypto-settings-street-1" name="zip" value="<?php echo $row['contact_zip'];?>">
                                 </div>
                                 <div class="form-group">
                                    <label for="crypto-settings-street-1">Street</label>
                                    <input type="text" class="form-control" id="crypto-settings-street-1" name="street" value="<?php echo $row['contact_street'];?>">
                                 </div>
                                 <div class="form-group">
                                    <label for="crypto-settings-street-1">Contact #</label>
                                    <input type="number" class="form-control" id="crypto-settings-street-1" name="cnumber" value="<?php echo $row['contact_cpnum'];?>" required>
                                 </div>
                                 <div class="form-group">
                                    <label for="crypto-settings-street-1">Location</label>
                                    <input type="text" class="form-control" id="crypto-settings-street-1" name="location" value="<?php echo $row['contact_location'];?>" required>
                                 </div>
                            </div>

                            <div class="col-6">
                            </div>
                            <div class="col-12">
                                 <div class="form-group">
                                    <button type="submit" name="update" class="btn btn-sm btn-hero btn-noborder btn-primary btn-block">Update details</button>
                                 </div>
                            </div>
                        </div>    
                    </form>                                        
                </div>
            </div>                   
        <!-- End Personal Details -->  
        </div> 
    </div>
    <!-- END Page Content -->
</main>
<!-- END Main Container -->


<script type="text/javascript" src="../assets/js/jquery-1.6.4.min.js"></script>
<script type="text/javascript" src="../assets/js/jquery-3.2.1.min.js"></script>
<script src="../assets/js/jquery.min.js"></script>  

<script type="text/javascript">
    function update_profile()
    {
        contact_id = <?php echo $contact_id; ?>;
        tran_file = document.getElementById("tran_attachment").value; 
        tran_attachment = $('#tran_attachment');
        file_attachment = tran_attachment.prop('files')[0];    
        formData = new FormData();
        formData.append('contact_id', contact_id);
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
</script>