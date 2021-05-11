<?php
    include("../conn.php");
    $md_primary_darker = "";
    $md_text = "text-muted";
    $md_body = "";
    if($mode_type == "Dark") //insert
    {
        $md_primary_darker = "bg-primary-darker";
        $md_text = "text-white";
        $md_body = "bg-gray-darker text-body-color-light";
    }

    $user_id = $row['user_id'];

    $userid = $_GET['userid'];
    $select_user = mysqli_query($conn, "SELECT * FROM user WHERE user_id = '$userid'");
    $fetch_select_user = mysqli_fetch_array($select_user);
    $type_of_user = $fetch_select_user['user_type'];


    if(isset($_POST['btn_admin']))
    {
        $user_type = "Admin";
        mysqli_query($conn, "UPDATE user SET user_type='$user_type' WHERE user_id='$userid'") or die(mysqli_error());
        echo "<script>document.location='main_people_details.php?userid=$userid'</script>";
    }
    if(isset($_POST['btn_supervisory']))
    {
        $user_type = "Supervisory";
        mysqli_query($conn, "UPDATE user SET user_type='$user_type' WHERE user_id='$userid'") or die(mysqli_error());
        echo "<script>document.location='main_people_details.php?userid=$userid'</script>";
    }
    if(isset($_POST['btn_member']))
    {
        $user_type = "Member";
        mysqli_query($conn, "UPDATE user SET user_type='$user_type' WHERE user_id='$userid'") or die(mysqli_error());
        echo "<script>document.location='main_people_details.php?userid=$userid'</script>";
    }

    if(isset($_POST['btn_suspended']))
    {
        $user_type = "Suspended";
        mysqli_query($conn, "UPDATE user SET user_type='$user_type' WHERE user_id='$userid'") or die(mysqli_error());
        echo "<script>document.location='main_people_details.php?userid=$userid'</script>";
    }

    if(isset($_POST['btn_delete']))
    {
        if ($type_of_user == 'Admin')
        {
            echo "<script type='text/javascript'>alert('Note: Cannot delete admin.');</script>";
        }
        else
        {
            $get_last_id = mysqli_query($conn,"SELECT task_id FROM task ORDER BY task_id DESC LIMIT 1"); //get last id
            $fetch_get_last_id = mysqli_fetch_array($get_last_id);
            $lastid = $fetch_get_last_id['task_id'];

            $select_tasks = mysqli_query($conn, "SELECT * FROM task");
            while($fetch_select_tasks = mysqli_fetch_array($select_tasks))
            {
                $user_assign = $fetch_select_tasks['task_assign_to']; //get the user_id ex. string = "1,2,3,4,5"
                if($user_assign == ""){}
                else
                {
                    $b = explode(",", $user_assign); // eleminate the ","/ comma sign and insert to array ex. [1,2,3,4,5]
                    //$oyy = implode( "", $b); // Convert array to string
                    if (in_array($userid, $b))
                    {
                        echo "<script type='text/javascript'>alert('Note: Cannot delete member already assign to task.');</script>";
                        echo "<script>document.location='main_people.php'</script>";
                        break;
                    }
                    else
                    {
                        if($lastid == $fetch_select_tasks['task_id'])
                        {
                            $existing_frofile = $fetch_select_user['profile_pic'];
                            if($existing_frofile != "")
                            {
                                array_map('unlink', glob("../assets/media/upload/".$existing_frofile)); // remove image
                            }
                            mysqli_query($conn, "DELETE FROM user WHERE user_id='$userid'") or die(mysqli_error());
                            echo "<script>document.location='main_people.php'</script>";
                        }
                        else
                        {}
                    }
                }
            }
        }
    }
?>
<div class="content <?php echo $md_primary_darker; ?>">
    <div class="block">
        <div class="block-content block-rounded shadow <?php echo $md_body; ?>">
            <!-- Personal Details -->
            <form method="post">
                <h2 class="content-heading <?php echo $md_text; ?>" style="margin-top: -40px;">
                    <span id="id_contact" class="badge bg-gray-dark float-right mt-5" style="font-size: 13px; color: #fff;">ID: <?php echo $fetch_select_user['user_id'];?></span>
                    Personal Details
                </h2>
                <div class="row items-push">
                    <div class="col-lg-4">

                        <div class="block block-themed text-center <?php echo $md_primary_darker; ?>">
                            <div class="block-content block-content-full block-sticky-options pt-30 <?php echo $md_primary_darker; ?>" style="background-color: #e6e6e6;">
                                <?php if($fetch_select_user['profile_pic'] != ""): ?>
                                    <img class="prof" src="../assets/media/upload/<?php echo $fetch_select_user['profile_pic']; ?>">
                                <?php else: ?>
                                    <img class="prof" src="../assets/media/photos/avatar.jpg">
                                <?php endif; ?>
                            </div>
                            <?php
                            if($fetch_select_user['user_type'] == "Admin")
                            {
                                echo'
                            <div class="block-content block-content-full block-content-sm bg-gd-corporate">
                                <div class="font-w600 text-white mb-5">'.$fetch_select_user['fname'].' '.$fetch_select_user['mname'].' '.$fetch_select_user['lname'].'</div>
                                <div class="font-size-sm text-white-op">ADMIN</div>
                            </div>';
                            }
                            else if($fetch_select_user['user_type'] == "Supervisory")
                            {
                                echo'
                            <div class="block-content block-content-full block-content-sm bg-gd-sun">
                                <div class="font-w600 text-white mb-5">'.$fetch_select_user['fname'].' '.$fetch_select_user['mname'].' '.$fetch_select_user['lname'].'</div>
                                <div class="font-size-sm text-white-op">SUPERVISORY</div>
                            </div>';
                            }
                            else if($fetch_select_user['user_type'] == "Member")
                            {
                                echo'
                            <div class="block-content block-content-full block-content-sm bg-gd-earth">
                                <div class="font-w600 text-white mb-5">'.$fetch_select_user['fname'].' '.$fetch_select_user['mname'].' '.$fetch_select_user['lname'].'</div>
                                <div class="font-size-sm text-white-op">MEMBER</div>
                            </div>';
                            }
                            else if($fetch_select_user['user_type'] == "Suspended")
                            {
                                echo'
                            <div class="block-content block-content-full block-content-sm btn-warning">
                                <div class="font-w600 text-white mb-5">'.$fetch_select_user['fname'].' '.$fetch_select_user['mname'].' '.$fetch_select_user['lname'].'</div>
                                <div class="font-size-sm text-white-op">SUSPENDED</div>
                            </div>';
                            }
                            else
                            {
                                echo'
                            <div class="block-content block-content-full block-content-sm bg-gd-pulse">
                                <div class="font-w600 text-white mb-5">'.$fetch_select_user['fname'].' '.$fetch_select_user['mname'].' '.$fetch_select_user['lname'].'</div>
                                <div class="font-size-sm text-white-op">Invalidate</div>
                            </div>';
                            }
                            ?>
                            <div class="block-content">
                                <div class="row items-push">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="form-group row">
                            <div class="col-6">
                                <label for="crypto-settings-street-1">First Name</label>
                                <input type="text" class="form-control form-control-lg" id="crypto-settings-street-1" name="fname" value="<?php echo $fetch_select_user['fname'];?>" readonly>
                            </div>
                            <div class="col-6">
                                <label for="crypto-settings-street-1">Middle Name</label>
                                <input type="text" class="form-control form-control-lg" id="crypto-settings-street-1" name="mname" value="<?php echo $fetch_select_user['mname'];?>" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-6">
                                <label for="crypto-settings-street-1">Last Name</label>
                                <input type="text" class="form-control form-control-lg" name="lname" value="<?php echo $fetch_select_user['lname'];?>" readonly>
                            </div>
                            <div class="col-6">
                                <label for="crypto-settings-street-1">Birthdate</label>
                                <input type="date" class="form-control form-control-lg" id="crypto-settings-street-1" name="bdate" value="<?php echo $fetch_select_user['bdate'];?>" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-6">
                                <label for="crypto-settings-street-1">Email Address</label>
                                <input type="email" class="form-control form-control-lg" name="email" value="<?php echo $fetch_select_user['email'];?>" readonly>
                            </div>
                            <div class="col-6">
                                <label for="crypto-settings-street-1">Contact Number</label>
                                <input type="text" class="form-control form-control-lg" name="cnumber" value="<?php echo $fetch_select_user['contact_number'];?>" placeholder="eg: 0000-000-0000" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-12">
                                <label for="crypto-settings-email">Address</label>
                                <input type="text" class="form-control form-control-lg" id="crypto-settings-email" name="address" placeholder="Enter your email.." value="<?php echo $fetch_select_user['address'];?>" readonly>
                            </div>
                        </div>
                        <h2 class="content-heading <?php echo $md_text; ?>">Note: <small class="<?php echo $md_text; ?>">You can change the user type here or delete a member.</small></h2>
                        <form method="post">
                        <div class="row text-center">
                            <div class="col-md-3 mb-5">
                                <button type="submit" class="btn btn-sm btn-hero btn-noborder bg-gd-sea btn-block" name="btn_admin" style="color: #fff;">Admin</button>
                            </div>
                            <div class="col-md-3 mb-5">
                                <button type="submit" class="btn btn-sm btn-hero btn-noborder bg-gd-sun btn-block" name="btn_supervisory" style="color: #fff;">Supervisory</button>
                            </div>
                            <div class="col-md-2 mb-5">
                                <button type="submit" class="btn btn-sm btn-hero btn-noborder bg-gd-earth btn-block" name="btn_member" style="color: #fff;">Member</button>
                            </div>
                            <div class="col-md-2 mb-5">
                                <button type="submit" class="btn btn-sm btn-hero btn-noborder btn-warning btn-block" name="btn_suspended" style="color: #fff;">Suspended</button>
                            </div>
                            <div class="col-md-2 mb-5">
                                <button type="submit" class="btn btn-sm btn-hero btn-noborder bg-gd-cherry btn-block" name="btn_delete" style="color: #fff;">Delete</button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
