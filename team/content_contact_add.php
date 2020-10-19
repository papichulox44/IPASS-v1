<?php
    $md_primary_darker = "";
    $md_text = "text-muted";
    $md_body = "";
    if($mode_type == "Dark") //insert
    { 
        $md_primary_darker = "bg-primary-darker";
        $md_text = "text-white";
        $md_body = "bg-gray-darker text-body-color-light";
    }

    $length = 10;    
    $random =  substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'),1,$length);

    if(isset($_POST['btn_save_contact']))
    {
        $space_id = $_POST['space_id']; 
        $list_id = $_POST['list_id']; 
        $status_id = $_POST['status_id'];
        if($space_id == "" || $list_id == "" || $status_id == "") 
        {
            $assign_to = "";
        }
        else
        {
            $assign_to = $space_id . ',' . $list_id . ',' .$status_id;
            // ADD TASK
        }

        echo '<script>alert("'.$assign_to.'");</script>';
        $contact_id = $_POST['contact_id'];

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
        $password = $_POST['password'];
        $nationality = $_POST['nationality'];
        $status = $_POST['status'];
        $user_id = $row['user_id'];


        $task_name = $fname . ' ' . $mname . ' ' . $lname;

        $find_contact = mysqli_query($conn, "SELECT * FROM contact WHERE contact_id = '$contact_id'");
        $fetch_find_contact = mysqli_fetch_array($find_contact);
        if(mysqli_num_rows($find_contact) == 0) // check if contact id exist
        {
            $contact = mysqli_query($conn, "SELECT * FROM contact WHERE contact_fname = '$fname' AND contact_mname = '$mname' AND contact_lname = '$lname' AND contact_email = '$email'");
            if(mysqli_num_rows($contact) == 0) // check if contact details exist
            {
                mysqli_query($conn,"INSERT into `contact` (contact_fname, contact_mname, contact_lname, contact_bdate, contact_gender, contact_email, contact_fbname, contact_messenger, contact_cpnum,contact_country, contact_city, contact_zip, contact_street, contact_location, contact_date_created, contact_created_by, contact_assign_to, contact_password, contact_status, contact_nationality) values ('$fname','$mname','$lname','$bdate','$gender','$email','$fbname','$messenger','$cnumber','$country','$city','$zip','$street','$location', NOW(), '$user_id', '$assign_to', '$random', '$status', '$nationality')") or die(mysqli_error());

                if($assign_to != "") // check if member click the assign to combobox specially in status
                {
                    $select_space_for_email = mysqli_query($conn,"SELECT * from space WHERE space_id = '$space_id'");
                    $fetch_space = mysqli_fetch_array($select_space_for_email);
                    $space_name = $fetch_space['space_name'];
                    
                    //Send email to client
                    /*$emailfor = "New contact";
                    include 'email_format.php';*/
                    //END Send email to client

                    $contact = mysqli_query($conn, "SELECT * FROM contact WHERE contact_fname = '$fname' AND contact_mname = '$mname' AND contact_lname = '$lname' AND contact_email = '$email'");
                    $fetch_contact = mysqli_fetch_array($contact);
                    $current_contact_id = $fetch_contact['contact_id'];

                    mysqli_query($conn,"INSERT into `task` (task_name, task_status_id, task_list_id, task_created_by, task_date_created, task_assign_to, task_contact) values ('$task_name', '$status_id', '$list_id', '$user_id', NOW(), '$user_id', $current_contact_id)") or die(mysqli_error()); 

// ________________________________ insert into specific space_db ________________________________
                    $last_id = mysqli_query($conn,"SELECT * FROM task WHERE task_status_id = '$status_id' ORDER BY task_id DESC LIMIT 1"); // get last task id
                    $fetch_last_id = mysqli_fetch_array($last_id);  
                    $task_id = $fetch_last_id['task_id'];

                    $select_space = mysqli_query($conn,"SELECT * FROM space WHERE space_id = '$space_id'");
                    $fetch_select_space = mysqli_fetch_array($select_space);  
                    $space_db_name = $fetch_select_space['space_db_table'];
                    mysqli_query($conn,"INSERT into `$space_db_name` (task_id) values ('$task_id')") or die(mysqli_error()); 

// ________________________________ update list_assign ________________________________                    
                    $find_list = mysqli_query($conn, "SELECT * FROM list WHERE list_id = '$list_id'");
                    $result_find_list = mysqli_fetch_array($find_list);
                    $current_assign_id = $result_find_list['list_assign_id'];

                    // below is check the list user_id 
                    if($current_assign_id == "") // if no member id to specific list then insert user_id to list_assign_id, else update
                    {
                        mysqli_query($conn, "UPDATE list SET list_assign_id = '$user_id' WHERE list_id='$list_id'") or die(mysqli_error()); 
                    }
                    else
                    {
                        $current_array = explode(",", $current_assign_id); // convert string to array
                        array_push($current_array,$user_id); // insert the new user id to $current_array | ex. "1" then new array ==  [1,2,3,4,5,1]
                        if(count($current_array) != count(array_unique($current_array))) // checking for existing element of array.
                        {}
                        else
                        {
                            $many_assign = $current_assign_id.",".$user_id;
                            mysqli_query($conn, "UPDATE list SET list_assign_id='$many_assign' WHERE list_id='$list_id'") or die(mysqli_error());

                        }
                    }
                    //echo "<script type='text/javascript'>alert($current_contact_id);</script>";
                }
            }
            else
            {
                echo '<script type=\'text/javascript\'>'; 
                echo 'alert("It seems that " + "'.$task_name.'" + " is already created.\nEmail: " + "'.$email.'" + "\nPlease try again.");'; 
                echo '</script>'; 
            }
            echo "<script>document.location='main_contact_add.php'</script>";  
        }
        else // update contact information if exist
        {              
            mysqli_query($conn, "UPDATE contact SET contact_fname = '$fname', contact_mname = '$mname', contact_lname = '$lname', contact_bdate = '$bdate', contact_gender = '$gender', contact_email = '$email', contact_fbname = '$fbname', contact_messenger = '$messenger', contact_cpnum = '$cnumber', contact_country = '$country', contact_city = '$city', contact_zip = '$zip', contact_street = '$street', contact_location = '$location', contact_assign_to = '$assign_to', contact_status = '$status', contact_nationality = '$nationality' WHERE contact_id='$contact_id'") or die(mysqli_error()); 
            if($assign_to != "") // check if member click the assign to combobox specially in status
            {
                mysqli_query($conn,"INSERT into `task` (task_name, task_status_id, task_list_id, task_created_by, task_date_created, task_assign_to, task_contact) values ('$task_name', '$status_id', '$list_id', '$user_id', NOW(), '$user_id', '$contact_id')") or die(mysqli_error()); 

// ________________________________ insert into specific space_db ________________________________
                $last_id = mysqli_query($conn,"SELECT * FROM task WHERE task_status_id = '$status_id' ORDER BY task_id DESC LIMIT 1"); // get last task id
                $fetch_last_id = mysqli_fetch_array($last_id);  
                $task_id = $fetch_last_id['task_id'];

                $select_space = mysqli_query($conn,"SELECT * FROM space WHERE space_id = '$space_id'");
                $fetch_select_space = mysqli_fetch_array($select_space);  
                $space_db_name = $fetch_select_space['space_db_table'];
                mysqli_query($conn,"INSERT into `$space_db_name` (task_id) values ('$task_id')") or die(mysqli_error()); 
// ________________________________ update list_assign ________________________________
                $find_list = mysqli_query($conn, "SELECT * FROM list WHERE list_id = '$list_id'");
                $result_find_list = mysqli_fetch_array($find_list);
                $current_assign_id = $result_find_list['list_assign_id'];

                if($current_assign_id == "") // if no member id to specific list then insert user_id to list_assign_id, else update
                {
                    mysqli_query($conn, "UPDATE list SET list_assign_id = '$user_id' WHERE list_id='$list_id'") or die(mysqli_error()); 
                }
                else
                {
                    $current_array = explode(",", $current_assign_id); // convert string to array
                    array_push($current_array,$user_id); // insert the new user id to $current_array | ex. "1" then new array ==  [1,2,3,4,5,1]
                    if(count($current_array) != count(array_unique($current_array))) // checking for existing element of array.
                    {}
                    else
                    {
                        $many_assign = $current_assign_id.",".$user_id;
                        mysqli_query($conn, "UPDATE list SET list_assign_id='$many_assign' WHERE list_id='$list_id'") or die(mysqli_error());
                    }
                }

                $select_space_for_email = mysqli_query($conn,"SELECT * from space WHERE space_id = '$space_id'");
                $fetch_space = mysqli_fetch_array($select_space_for_email);
                $space_name = $fetch_space['space_name'];
                
                //Send email to client
                /*$emailfor = "New contact";
                include 'email_format.php';*/
                //END Send email to client
            } 
            echo "<script>document.location='main_contact_add.php'</script>";  
        }
    }

    if (empty($_GET['delete_contact'])) 
    {}
    else
    {
        $unassignid = $_GET['unassignid'];
        mysqli_query($conn, "DELETE FROM contact WHERE contact_id = '$unassignid'") or die(mysqli_error());
        echo "<script>document.location='main_contact_add.php'</script>";  
    }
?>     

            <!-- Main Container -->
            <main id="main-container">
                <!-- Page Content -->
                <div class="content <?php echo $md_primary_darker; ?>">  

                    <div class="block block-rounded shadow <?php echo $md_body; ?>">
                        <form method="post">
                            <div class="block-header content-heading <?php echo $md_body; ?>">
                                <h3 class="block-title <?php echo $md_text; ?>">Add Contact</h3>
                                <div class="block-options">
                                    <span id="id_contact" class="badge badge-success" style="font-size: 13px;">ID: None</span>
                                </div>
                            </div>

                            <div class="block-content">
                                <div class="row items-push">
                                    <div class="col-md-6">
                                        <input type="hidden" class="form-control" id="contact_id" name="contact_id">
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label">First Name<span class="text-danger"> *</span></label>
                                            <div class="col-lg-8">
                                                <input type="text" class="form-control" id="fname" name="fname" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label">Middle Name</label>
                                            <div class="col-lg-8">
                                                <input type="text" class="form-control" id="mname" name="mname">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label">Last Name<span class="text-danger"> *</span></label>
                                            <div class="col-lg-8">
                                                <input type="text" class="form-control" id="lname" name="lname" required>
                                            </div>
                                        </div>                                        
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label">Birthdate<span class="text-danger"> *</span></label>
                                            <div class="col-lg-8">
                                                <input type="date" class="form-control" id="bdate" name="bdate" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label">Gender<span class="text-danger"> *</span></label>
                                            <div class="col-lg-8">
                                                <select class="form-control text-muted" id="gender" name="gender" required>
                                                    <option></option>
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label">Status<span class="text-danger"> *</span></label>
                                            <div class="col-lg-8">
                                                <select class="form-control text-muted" id="status" name="status" required>
                                                    <option></option>
                                                    <option value="Married">Married</option>
                                                    <option value="Single">Single</option>
                                                    <option value="Widow">Widow</option>
                                                    <option value="Annuled">Annuled</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label">Nationality<span class="text-danger"> *</span></label>
                                            <div class="col-lg-8">
                                                <input type="text" class="form-control" id="nationality" name="nationality" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label">Email<span class="text-danger"> *</span></label>
                                            <div class="col-lg-8">
                                                <input type="email" class="form-control" id="email" name="email" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label">Fb Name<span class="text-danger"> *</span></label>
                                            <div class="col-lg-8">
                                                <input type="email" class="form-control" id="fbname" name="fbname" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label">Messenger</label>
                                            <div class="col-lg-8">
                                                <input type="text" class="form-control" id="messenger" name="messenger">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label">Contact #<span class="text-danger"> *</span></label>
                                            <div class="col-lg-8">
                                                <input type="text" class="form-control" placeholder="eg: 0000-000-0000" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');" id="cnumber" name="cnumber" required>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label">Country</label>
                                            <div class="col-lg-8">
                                                <select class="form-control text-muted" id="example-select2" style="width: 100%;" data-placeholder="Choose one.." name="country"> <!-- add "js-select2" to class to have a search input -->
                                                    <option></option>
                                                    <?php include 'select_country.php'; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label">City</label>
                                            <div class="col-lg-8">
                                                <input type="text" class="form-control" id="city" name="city">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label">Zip Code</label>
                                            <div class="col-lg-8">
                                                <input type="text" class="form-control" id="zip" name="zip">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label">Street</label>
                                            <div class="col-lg-8">
                                                <input type="text" class="form-control" id="street" name="street">                                            
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-lg-3 col-form-label">Location<span class="text-danger"> *</span></label>
                                            <div class="col-lg-8">
                                                <input type="text" class="form-control" id="location" name="location" required>                                                
                                                <input type="hidden" class="form-control" id="password" name="password" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="block-header content-heading <?php echo $md_body; ?>">
                                <h3 class="block-title <?php echo $md_text; ?>">Assign to</h3>
                            </div>
                            <div class="block-content">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Space</label>
                                            <select class="form-control" id="spaceid" onchange="space(this)">
                                                <option value="">Please select</option>
                                                    <?php
                                                        $findspace = mysqli_query($conn, "SELECT * FROM space ORDER BY space_name ASC");
                                                        while($result_findspace = mysqli_fetch_array($findspace))
                                                        {
                                                            echo'<option value="'.$result_findspace['space_id'].'">'.$result_findspace['space_name'].'</option>';
                                                        }
                                                    ?>
                                            </select>
                                            <input type="hidden" id="space_id_no" name="space_id" value="">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>List</label>
                                            <select class="form-control" id="listid" onchange="list(this)">
                                            </select>
                                            <input type="hidden" id="list_id_no" name="list_id" value="">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select class="form-control" id="statusid" onchange="status_services(this)">
                                            </select>
                                            <input type="hidden" id="status_id_no" name="status_id" value="">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Option</label>
                                        <div class="form-group row">
                                            <div class="col-sm-6">
                                                <button type="submit" class="btn btn-primary btn-block" name="btn_save_contact">Save</button>
                                            </div>
                                            <div class="col-sm-6">
                                                <button class="btn btn-danger btn-block" onclick="window.location.reload();">Cancel</button> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="block-header content-heading <?php echo $md_body; ?>">
                            <h3 class="block-title <?php echo $md_text; ?>">Payment phase</h3>
                            </div>
                            <div class="block-content">
                                <div class="form-group row"> 
                                    <div class="col-lg-3">
                                        <select class="form-control text-muted" onchange="status3(this)" style="width: 100%;" id="phase_selector">                                  
                                        </select>
                                        <input type="hidden" value="" id="txt_select_phase">
                                    </div><br><br><br>
                                    <div class="col-lg-12" id="finance_container">  
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>    

                     <!-- Dynamic Table Full -->
                    <div class="block block-rounded shadow <?php echo $md_body; ?>">
                        <div class="block-header content-heading <?php echo $md_body; ?>">
                            <h3 class="block-title <?php echo $md_text; ?>">Unassign contact</h3>
                        </div>
                        <div class="block-content block-content-full">
                            <table class="table table-striped table-vcenter js-dataTable-full <?php echo $md_body; ?>">
                                <thead>
                                    <tr>
                                        <th class="text-center">No.</th>
                                        <th>Name</th>
                                        <th class="d-none d-sm-table-cell">Email</th>
                                        <th class="d-none d-sm-table-cell text-center" style="width: 15%;">Number</th>
                                        <th class="d-none d-sm-table-cell text-center">Tools</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $countuser = 1;
                                    $findcontact = mysqli_query($conn, "SELECT * FROM contact WHERE contact_assign_to = '' ORDER BY contact_fname ASC");
                                    while($result_finduser = mysqli_fetch_array($findcontact))
                                    {
                                        echo '
                                        <tr>
                                            <td class="text-center">'.$countuser++.'</td>
                                            <td class="font-w600">'.$result_finduser['contact_fname'].' '.$result_finduser['contact_mname'].' '.$result_finduser['contact_lname'].'</td>
                                            <td class="d-none d-sm-table-cell">'.$result_finduser['contact_email'].'</td>
                                            <td class="d-none d-sm-table-cell text-center">'.$result_finduser['contact_cpnum'].'</td>
                                            <td class="d-none d-sm-table-cell text-center">
                                                <button type="button" class="btn btn-sm btn-noborder btn-primary mr-5 mb-5" id="'.$result_finduser['contact_id'].'" onclick="edit_contact(this.id)">
                                                    <i class="fa fa-edit"></i>
                                                </button>                                                    
                                                <a href="main_contact_add.php?unassignid='.$result_finduser['contact_id'].'&delete_contact=delete_contact">
                                                <button class="btn btn-sm btn-noborder btn-danger mr-5 mb-5"><i class="fa fa-trash"></i></button></a>
                                            </td>
                                        </tr>';
                                    }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- END Dynamic Table Full -->       
                </div>
                <!-- END Page Content -->
            </main>
            <!-- END Main Container -->

<script type="text/javascript">
    phase_id = document.getElementById("txt_select_phase").value;
    finance_container = document.getElementById('finance_container');
    if(phase_id == "")
    {
        no_selected();
    }
    function no_selected()
    {
        finance_container.innerHTML += '<label for="crypto-settings-street-1">No phase selected</label>' +
        '<div class="table-responsive">' +
            '<table class="table table-bordered table-striped table-hover <?php echo $md_body; ?>">' +
                '<thead>' +
                    '<tr>' +
                        '<th style="width: 100px;">ID</th>' +
                        '<th>Name</th>' +
                        '<th class="text-right" style="width: 20%;">CURRENCY</th>' +
                        '<th class="text-right" style="width: 20%;">AMOUNT</th>' +
                    '</tr>' +
                '</thead>' +
                '<tbody>' +
                    '<tr>' +
                        '<td colspan="3" class="text-right font-w600">Total Amount:</td>' +
                        '<td class="text-right">0.00</td>' +
                    '</tr>' +
                    '<tr>' +
                        '<td colspan="3" class="text-right font-w600">Total Paid:</td>' +
                        '<td class="text-right">0.00</td>' +
                    '</tr>' +
                    '<tr class="table-success">' +
                        '<td colspan="3" class="text-right font-w600 text-uppercase text-muted">Total Due:</td>' +
                        '<td class="text-right font-w600 text-muted">0.00</td>' +
                    '</tr>' +
                '</tbody>' +
            '</table>' +
        '</div>';
    }
    function status3(select)
    {
        status_id = (select.options[select.selectedIndex].value); // get phase id
        document.getElementById("txt_select_phase").value = status_id;
        phase_id1 = document.getElementById("txt_select_phase").value;
        finance_container.innerHTML = "";
        if(phase_id1 == "")
        {
            no_selected();
        }
        <?php 
            include_once '../conn.php';
            $select_phase = mysqli_query($conn, "SELECT * FROM finance_phase ORDER BY phase_id ASC");         
            while($rows = mysqli_fetch_array($select_phase))
            {
                $phase_id = $rows['phase_id'];
                $phase_name = $rows['phase_name'];
                ?>
                    var phase_id = <?php echo $phase_id; ?>;
                    var phase_name = "<?php echo $phase_name; ?>";
                    if(status_id == phase_id)
                    {
                        finance_container.innerHTML += '<label for="crypto-settings-street-1">'+phase_name+'</label>' +
                        '<div class="table-responsive">' +
                            '<table class="table table-bordered table-striped table-hover <?php echo $md_body; ?>">' +
                                '<thead>' +
                                    '<tr>' +
                                        '<th style="width: 100px;">ID</th>' +
                                        '<th>Name</th>' +
                                        '<th class="text-right" style="width: 20%;">CURRENCY</th>' +
                                        '<th class="text-right" style="width: 20%;">AMOUNT</th>' +
                                    '</tr>' +
                                '</thead>' +
                                '<tbody>' +
                                    <?php
                                        $select_field = mysqli_query($conn, "SELECT * FROM finance_field WHERE finance_phase_id = '$phase_id' ORDER BY finance_order ASC");
                                        $total_amount = 0;
                                        while($fetch_select_field = mysqli_fetch_array($select_field))
                                        {
                                            $amount = $fetch_select_field['finance_value'] == 0 ? '' : number_format((float)$fetch_select_field['finance_value'],2,".",'');
                                            ?>
                                            '<tr>' +
                                                '<td><?php echo ''.$fetch_select_field['finance_id'].''; ?></td>' +
                                                '<td><?php echo ''.$fetch_select_field['finance_name'].''; ?></td>' +
                                                '<td class="text-right"><?php echo ''.$fetch_select_field['finance_currency'].''; ?></td>' +
                                                '<td class="text-right"><?php echo ''.number_format($fetch_select_field['finance_value'],2).''; ?></td>' +
                                            '</tr>' +
                                            <?php
                                            $total_amount += $amount;
                                        }
                                        $total_paid = 0.00;
                                        $total_due = $total_amount - $total_paid;
                                    ?>
                                    '<tr>' +
                                        '<td colspan="3" class="text-right font-w600">Total Amount:</td>' +
                                        '<td class="text-right"><?php echo ''.number_format($total_amount,2).''; ?></td>' +
                                    '</tr>' +
                                    '<tr>' +
                                        '<td colspan="3" class="text-right font-w600">Total Paid:</td>' +
                                        '<td class="text-right"><?php echo ''.number_format($total_paid,2).''; ?></td>' +
                                    '</tr>' +
                                    '<tr class="table-success">' +
                                        '<td colspan="3" class="text-right font-w600 text-uppercase text-muted">Total Due:</td>' +
                                        '<td class="text-right font-w600 text-muted"><?php echo ''.number_format($total_due,2).''; ?></td>' +
                                    '</tr>' +
                                '</tbody>' +
                            '</table>' +
                        '</div>';
                    }
                <?php
            }
        ?>
    }

    function space(select)
    {
        $('#phase_selector')
            .find('option')
            .remove()
            .end()
            .append('<option value="">----- New option -----</option>')
        ;// clear and add value to list combobox
        
        $('#listid')
            .find('option')
            .remove()
            .end()
            .append('<option value="">----- New option -----</option>')
        ;// clear and add value to list combobox

         $('#statusid')
            .find('option')
            .remove()
            .end()
            .append('<option value="">----- New option -----</option>')
        ;// clear and add value to status combobox
        document.getElementById("space_id_no").value = "";
        document.getElementById("txt_select_phase").value = "";
        document.getElementById("list_id_no").value = ""; 
        document.getElementById("status_id_no").value = ""; 

        space_id = (select.options[select.selectedIndex].value); // get space id
        //alert(space_id); //tester
        document.getElementById("space_id_no").value = space_id;

        <?php
            include_once '../conn.php';
            $select_phase = mysqli_query($conn, "SELECT * FROM finance_phase ORDER BY phase_id ASC");         
            while($rows = mysqli_fetch_array($select_phase))
            {?>
                if (space_id == '<?php echo $rows['phase_space_id'] ?>')
                {
                    var x = document.getElementById("phase_selector");
                    var option = document.createElement("option");
                    option.value = "<?php echo $rows['phase_id'] ?>";
                    option.text = "<?php echo $rows['phase_name'] ?>";
                    x.add(option);
                }
            <?php
            }
        ?>  
        <?php
            include_once '../conn.php';
            $findlist = mysqli_query($conn, "SELECT * FROM list");
            while($result_findlist = mysqli_fetch_array($findlist))
            {?>
                if (space_id == '<?php echo $result_findlist['list_space_id'] ?>')
                {
                    var x = document.getElementById("listid");
                    var option = document.createElement("option");
                    option.value = "<?php echo $result_findlist['list_id'] ?>";
                    option.text = "<?php echo $result_findlist['list_name'] ?>";
                    x.add(option);
                }
            <?php
            }
        ?>
    }

    function phase(select)
    {
        phase_id = (select.options[select.selectedIndex].value); // get list id
        document.getElementById("txt_select_phase").value = phase_id;
    }

    function list(select)
    {
        $('#statusid')
            .find('option')
            .remove()
            .end()
            .append('<option value="">----- New option -----</option>')
        ;// clear and add value to status combobox
        document.getElementById("status_id_no").value = "";

        list_id = (select.options[select.selectedIndex].value); // get list id
        //alert(list_id); //tester
        document.getElementById("list_id_no").value = list_id;
        <?php
            include_once '../conn.php';
            $findstatus = mysqli_query($conn, "SELECT * FROM status ORDER BY status_order_no ASC");
            while($result_findstatus = mysqli_fetch_array($findstatus))
            {?>
                if (list_id == '<?php echo $result_findstatus['status_list_id'] ?>')
                {
                    var x = document.getElementById("statusid");
                    var option = document.createElement("option");
                    option.value = "<?php echo $result_findstatus['status_id'] ?>";
                    option.text = "<?php echo $result_findstatus['status_name'] ?>";
                    x.add(option);
                }
            <?php
            }
        ?>
    }

    function status_services(select)
    {
        status_id = (select.options[select.selectedIndex].value); // get list id
        //alert('ok');
        document.getElementById("status_id_no").value = status_id;
        alert("Nag alert");
    }
    function edit_contact(id) 
    {
        document.getElementById("fname").focus();
        var a = id;
        document.getElementById("contact_id").value = a;
        //alert(a);
        <?php 
            include_once '../conn.php';
            $findcontact = mysqli_query($conn, "SELECT * FROM contact");
            while($result_findcontact = mysqli_fetch_array($findcontact))
            {?>
                if (a == '<?php echo $result_findcontact['contact_id'] ?>')
                {
                    document.getElementById("id_contact").innerHTML = "ID: " + a; 

                    document.getElementById("fname").value = "<?php echo $result_findcontact['contact_fname'] ?>";
                    document.getElementById("mname").value = "<?php echo $result_findcontact['contact_mname'] ?>";
                    document.getElementById("lname").value = "<?php echo $result_findcontact['contact_lname'] ?>";
                    document.getElementById("bdate").value = "<?php echo $result_findcontact['contact_bdate'] ?>";
                    document.getElementById("gender").value = "<?php echo $result_findcontact['contact_gender'] ?>";
                    document.getElementById("email").value = "<?php echo $result_findcontact['contact_email'] ?>";
                    document.getElementById("fbname").value = "<?php echo $result_findcontact['contact_fbname'] ?>";
                    document.getElementById("messenger").value = "<?php echo $result_findcontact['contact_messenger'] ?>";
                    document.getElementById("cnumber").value = "<?php echo $result_findcontact['contact_cpnum'] ?>";
                    document.getElementById("example-select2").value = "<?php echo $result_findcontact['contact_country'] ?>";
                    document.getElementById("city").value = "<?php echo $result_findcontact['contact_city'] ?>";
                    document.getElementById("zip").value = "<?php echo $result_findcontact['contact_zip'] ?>";
                    document.getElementById("street").value = "<?php echo $result_findcontact['contact_street'] ?>";
                    document.getElementById("location").value = "<?php echo $result_findcontact['contact_location'] ?>";
                    document.getElementById("password").value = "<?php echo $result_findcontact['contact_password'] ?>";
                    document.getElementById("status").value = "<?php echo $result_findcontact['contact_status'] ?>";
                    document.getElementById("nationality").value = "<?php echo $result_findcontact['contact_nationality'] ?>";
                }
            <?php
            }
        ?> 
    } 
</script>