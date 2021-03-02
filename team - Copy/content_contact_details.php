<?php
    $md_primary_darker = "";
    $md_text = "text-muted";
    $md_body = "";
    $md_heading = "";
    if($mode_type == "Dark") //insert
    { 
        $md_primary_darker = "bg-primary-darker";
        $md_text = "text-white";
        $md_body = "bg-gray-darker text-body-color-light";
        $md_heading = "bg-earth-dark";
    }

    include("../conn.php");
    $contact_id = $_GET['contact_id'];
    $select_contact = mysqli_query($conn, "SELECT * FROM contact WHERE contact_id = '$contact_id'");
    $fetch_select_contact = mysqli_fetch_array($select_contact);

    $contact_assign_to = $fetch_select_contact['contact_assign_to']; // string 0,1,2

    $select_task = mysqli_query($conn, "SELECT * FROM task WHERE task_contact = '$contact_id'");
    $fetch_select_task_id = mysqli_fetch_array($select_task);
?>

<!-- Main Container -->
<main id="main-container">
    <!-- Page Content -->
    <div class="content <?php echo $md_primary_darker; ?>">  
        <div class="block block-rounded shadow">
            <div class="block-content <?php echo $md_body; ?>">  
                <!-- Personal Details -->
                    <h2 class="content-heading <?php echo $md_text; ?>" style="margin-top: -40px;">
                        <span id="id_contact" class="badge bg-gray-dark float-right mt-5" style="font-size: 13px; color: #fff;">Contact ID: <?php echo $fetch_select_contact['contact_id'];?></span>
                        Personal Details
                    </h2>
                    <div class="row items-push">
                        <div class="col-lg-4">

                            <div class="block block-themed text-center <?php echo $md_primary_darker; ?>">
                                <div class="block-content block-content-full block-sticky-options pt-30 <?php echo $md_primary_darker; ?>" style="background-color: #e6e6e6;">
                                    <?php if($fetch_select_contact['contact_profile'] != ""): ?>
                                        <img class="prof" src="../client/client_profile/<?php echo $fetch_select_contact['contact_profile']; ?>">
                                    <?php else: ?>
                                        <img class="prof" src="../assets/media/photos/avatar.jpg">
                                    <?php endif; ?>  
                                </div>
                                <div class="block-content block-content-full block-content-sm bg-gray-dark">
                                    <div class="font-w600 text-white mb-5"><?php echo $fetch_select_contact['contact_fname'] . " " . $fetch_select_contact['contact_mname'] . " " . $fetch_select_contact['contact_lname'];?></div>
                                    <div class="font-size-sm text-white-op">Contact Name</div>
                                </div>
                                <div class="block-content text-left">
                                    <div class="row items-push">
                                        <p class="<?php echo $md_text; ?>">
                                            <?php
                                                $user_id = $fetch_select_contact['contact_created_by'];
                                                $select_user = mysqli_query($conn, "SELECT * FROM user WHERE user_id = '$user_id'");
                                                $fetch_select_user = mysqli_fetch_array($select_user);
                                            ?>
                                            Created by: <?php echo $fetch_select_user['fname'];?> <?php echo $fetch_select_user['mname'];?> <?php echo $fetch_select_user['lname'];?><br>
                                            Date: <?php echo $fetch_select_contact['contact_date_created'];?><br>
                                            Username:<br> <strong class="badge bg-gray-dark" style="font-size: 13px; color: #fff;"><?php echo $fetch_select_contact['contact_email'];?></strong><br>
                                            Password:<br> <strong class="badge bg-gray-dark" style="font-size: 13px; color: #fff;"><?php echo $fetch_select_contact['contact_password'];?></strong>
                                        </p> 
                                    </div>
                                </div>
                            </div>                                   
                        </div>
                        <div class="col-lg-8">
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
                                        <label for="crypto-settings-street-1">Email</label>
                                        <input type="text" class="form-control form-control-lg" id="crypto-settings-street-1" name="fname" value="<?php echo $fetch_select_contact['contact_email'];?>" readonly>
                                     </div>
                                     <div class="form-group">
                                        <label for="crypto-settings-street-1">Birthdate</label>
                                        <input type="text" class="form-control form-control-lg" id="crypto-settings-street-1" name="fname" value="<?php echo $fetch_select_contact['contact_bdate'];?>" readonly>
                                     </div>
                                     <div class="form-group">
                                        <label for="crypto-settings-street-1">Gender</label>
                                        <input type="text" class="form-control form-control-lg" id="crypto-settings-street-1" name="fname" value="<?php echo $fetch_select_contact['contact_gender'];?>" readonly>
                                     </div>
                                </div>
                                <div class="col-md-6">
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
                                        <label for="crypto-settings-street-1">State</label>
                                        <input type="text" class="form-control form-control" id="crypto-settings-street-1" name="fname" value="<?php echo $fetch_select_contact['contact_location'];?>" readonly>
                                     </div>
                                </div>
                            </div>
                        </div>
                    </div>                                 
                <!-- End Personal Details -->   

                    <h2 class="content-heading <?php echo $md_text; ?>" style="margin-top: -40px;">
                        <span id="id_contact" class="badge bg-gray-dark float-right" style="font-size: 13px; color: #fff;">Task ID: <?php echo $fetch_select_task_id['task_id'];?></span>
                        Assign to
                    </h2>
<?php
    $assign_array = explode(",", $contact_assign_to);
    $count = count($assign_array);
    for($x = 0; $x < $count; $x+=3)
    {
        $y = $x;
        $space_id = $assign_array[$y];
        $list_id = $assign_array[$y + 1];
        $status_id = $assign_array[$y + 2]; // get the value of array per key

        $select_space = mysqli_query($conn, "SELECT * FROM space WHERE space_id = '$space_id'");
        $fetch_select_space = mysqli_fetch_array($select_space);
        $select_list = mysqli_query($conn, "SELECT * FROM list WHERE list_id = '$list_id'");
        $fetch_select_list = mysqli_fetch_array($select_list);
        $select_status = mysqli_query($conn, "SELECT * FROM status WHERE status_id = '$status_id'");
        $fetch_select_status = mysqli_fetch_array($select_status);

        ?>
            <!-- Assign to -->
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Space</label>
                        <input type="text" class="form-control form-control" value="<?php echo $fetch_select_space['space_name'];?>" readonly>
                   </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>List</label>
                        <input type="text" class="form-control form-control" value="<?php echo $fetch_select_list['list_name'];?>" readonly>
                   </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Status</label>
                        <input type="text" class="form-control form-control" value="<?php echo $fetch_select_status['status_name'];?>" readonly>
                   </div>
                </div>
            </div>                                 
        <!-- End Assign to --> 
        <?php
    }
?>  
   
            </div>
        </div>
    </div>
    <!-- END Page Content -->
</main>
<!-- END Main Container -->