<?php
    $md_content = "";
    $md_text = "text-muted";
    $md_block = "block-header-default";
    $md_editor = "";
    $md_table_body = "";
    $md_table_header = "";
    $table = ""; 
    if($mode_type == "Dark") //insert
    { 
        $md_content = "bg-primary-darker";
        $md_text = "text-white";
        $md_block = "bg-gray-darker";
        $md_editor = "#2d3238";
        $md_table_body = "bg-primary-darker text-body-color-light";
        $md_table_header = "bg-gray-darker";
        $table = "bg-primary-darker text-body-color-light";
    }
?>     

<!-- Main Container -->
<main id="main-container">

    <!-- Page Content -->
    <div class="content <?php echo $md_content; ?>">
        
        <!-- Email list -->
        <div class="row row-deck mt-20">
            <div class="col-lg-12">
                <div class="block block-rounded shadow <?php echo $md_table_header; ?>">
                    <div class="block-header content-heading <?php echo $md_table_header; ?>">
                        <h3 class="block-title <?php echo $md_text; ?>">Email list</h3>
                        <button type="button" class="btn btn-sm btn-primary float-right"  data-toggle="modal" data-target="#modal-viewfile">
                            <i class="fa fa-search mr-5"></i>View file
                        </button>
                    </div>
                    <div class="block-content <?php echo $md_text; ?> mb-20">
                        <table class="table table-bordered table-striped table-vcenter table-hover<?php echo $md_table_body?> js-dataTable-full">
                            <thead>
                                <tr>
                                    <th class="text-center">ID</th>
                                    <th class="d-none d-sm-table-cell">Created by</th>
                                    <th class="d-none d-sm-table-cell">Template #</th>
                                    <th>Email Name</th>
                                    <th class="d-none d-sm-table-cell">Email Subject</th>
                                    <th class="text-center">Tools</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $results = mysqli_query($conn, "SELECT * FROM email_format ORDER BY email_name ASC");
                                while($rows = mysqli_fetch_array($results))
                                {
                                    $member_id = $rows['email_created_by'];
                                    $select_user = mysqli_query($conn, "SELECT * FROM user WHERE user_id = '$member_id'");
                                    $fetch_user = mysqli_fetch_array($select_user);
                                    echo '
                                    <tr>
                                        <td class="text-center">'.$rows['email_id'].'</td>
                                        <td class="d-none d-sm-table-cell">'.$fetch_user['fname'][0].' '.$fetch_user['mname'].' '.$fetch_user['lname'].'</td>
                                        <td class="d-none d-sm-table-cell">'.$rows['email_template'].'</td>
                                        <td>'.$rows['email_name'].'</td>
                                        <td class="d-none d-sm-table-cell">'.$rows['email_subject'].'</td>
                                        <td class="text-center">
                                            <input type="hidden" class="form-control" value="'.$rows['email_name'].'" id="assign_email'.$rows['email_id'].'">
                                            <button class="btn btn-sm btn-noborder btn-warning" data-toggle="modal" data-target="#modal-assignemail" id="'.$rows['email_id'].'" onclick="assign_email(this.id)" title="Assign"><i class="si si-grid"></i></button>
                                            <button class="btn btn-sm btn-noborder btn-primary" id="'.$rows['email_id'].'" onclick="edit_email(this.id)" title="Edit"><i class="si si-pencil"></i></button>
                                            <button class="btn btn-sm btn-noborder btn-danger" id="'.$rows['email_id'].'" onclick="delete_email(this.id)" title="Delete"><i class="fa fa-trash"></i></button>
                                        </td>   
                                    </tr>';
                                }?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Email list -->

        <!-- View file -->
        <div class="modal" id="modal-viewfile" tabindex="-1" role="dialog" aria-labelledby="modal-viewfile" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="block block-themed block-transparent mb-0">
                        <div class="block-header bg-primary-dark">
                            <h3 class="block-title">Email content</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                    <i class="si si-close"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content">
                                <div class="block-content" data-toggle="slimscroll" data-height="200px" data-color="#42a5f5" data-opacity="1" data-always-visible="true">
                                    <?php
                                        echo "IPASS/team/email_content/". '<br><br>';
                                        $dir = "email_content/";
                                        // Open a directory, and read its contents
                                        $a = 1;
                                        foreach (array_filter(glob($dir.'*'), 'is_file') as $file)
                                        {
                                            echo $a++ .'. '. str_replace("email_content/","",$file). '<br>';
                                        }
                                    ?>
                                </div>
                                <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END View file -->

        <!-- Assign email -->
        <div class="modal" id="modal-assignemail" tabindex="-1" role="dialog" aria-labelledby="modal-normal" aria-hidden="true" data-backdrop="static">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="block block-themed block-transparent mb-0">
                        <div class="block-header bg-primary-dark">
                            <h3 class="block-title">Email assign</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                    <i class="si si-close"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content" style="margin-bottom: 15px;">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email ID</label>
                                        <input type="text" class="form-control" id="email_assign_id" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email Name</label>
                                        <input type="text" class="form-control" id="email_assign_name" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
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
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>List</label>
                                        <select class="form-control" id="listid" onchange="list(this)">
                                        </select>
                                        <input type="hidden" id="list_id_no" name="list_id" value="">
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-sm btn-hero btn-noborder bg-corporate btn-block text-white" onclick="click_assign_email()">
                                <li class="fa fa-object-ungroup"></li> Assign field
                            </button>

                            <div class="dropdown-divider"></div>
                            <div class="scrumboard js-scrumboard" style="margin: 0px -43px 0px -43px;">
                                <div class="scrumboard-col" style="width: 100%;">
                                    <ul class="scrumboard-items block-content list-unstyled" style="margin-top: -30px;" class="connectedSortable1">
                                        <span id="fetch_assign_email">
                                        </span>
                                    </ul>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Assign email -->

        <!-- CKEditor -->
        <div class="block shadow">
            <div class="block-header <?php echo $md_block; ?>">
                <h3 class="block-title <?php echo $md_text; ?>">Email content editor</h3>
                <div class="block-options">
                    <!--<button type="button" class="btn-block-option">
                        <i class="si si-wrench"></i>
                    </button>-->
                </div>
            </div>
            <div class="block-content" style="background-color: <?php echo $md_editor; ?>;">

                <div class="form-group row">
                    <div class="col-md-8 mb-15">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="<?php echo $md_text; ?>">Email name</label>
                                <input type="text" class="form-control mb-15" id="email_name" placeholder="Please input name...">
                            </div>
                            <div class="col-md-6">
                                <label class="<?php echo $md_text; ?>">Email subject</label>
                                <input type="text" class="form-control mb-15" id="email_subject" placeholder="Please input subject...">
                            </div>                            
                            <div class="col-md-12">
                                <textarea id="js-ckeditor" name="ckeditor"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <textarea class="form-control mb-15" id="email_content" rows="12" placeholder="Paste source here.."></textarea>
                            <button type="button" class="btn btn-block btn-primary" onclick="preview()">
                                <i class="fa fa-search text-white-op"></i> Preview
                            </button>
                        </div>
                        
                        <label class="<?php echo $md_text; ?>">Option</label>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <button type="button" class="btn btn-md btn-noborder btn-danger btn-block" onclick="cancel_email()">
                                        <li class="fa fa-eraser"></li> Cancel
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <button class="btn btn-block btn-primary" onclick="publish()">
                                        <i class="fa fa-upload text-white-op"></i> Publish
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- END CKEditor -->

        <!-- CKEditor -->
        <div class="block shadow">
            <div class="block-header <?php echo $md_block; ?>">
                <h3 class="block-title <?php echo $md_text; ?>">Email view</h3>
                <div class="block-options <?php echo $md_text; ?>">
                    <span id="span_id"></span> <span id="email_id"></span>
                </div>
            </div>
            <div class="block-content" style="background-color: <?php echo $md_editor; ?>;">
                
                <!-- Email template || Can be change depend on template selected -->
                <div style="padding: 20px 0px 0px 0px; background-color: #189AA7;" class="shadow">
                        <img src="../assets/media/photos/header_email.png" style="width: 100%;">
                    <table width="100%" border="0" cellspacing="0" cellpadding="20" style="background-color: #189AA7; color: #5a5f61; font-family:verdana;">
                        <tr id="content_message">
                            <td style="background-color: #fff; border-top: 10px solid #189AA7; border-bottom: 10px solid #189AA7;">
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
                <!-- END Email template || Can be change depend on template selected -->

                <br>

                <label class="<?php echo $md_text; ?>">Test email</label>
                <div class="form-group row">
                    <div class="col-md-8">
                        <input type="text" class="form-control mb-15" id="test_email" placeholder="Please input email...">
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-block btn-primary" onclick="test_send_email()">
                            <i class="fa fa-send-o text-white-op"></i> Send
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <!-- END CKEditor -->

    </div>
    <!-- END Page Content -->

</main>
<!-- END Main Container -->

<script type="text/javascript" src="../assets/js/jquery-1.6.4.min.js"></script>
<script type="text/javascript" src="../assets/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript"> 
    function assign_email(id)
    {        
        document.getElementById("email_assign_id").value = id;
        name = document.getElementById("assign_email" + id).value;
        document.getElementById("email_assign_name").value = name;
        
        document.getElementById("spaceid").selectedIndex = "0";
        document.getElementById("space_id_no").value = "";
        document.getElementById("listid").selectedIndex = "0";
        document.getElementById("list_id_no").value = "";


        display_email_assign();
    }
    function space(select)
    {
        $('#listid')
            .find('option')
            .remove()
            .end()
            .append('<option value="">----- New option -----</option>')
        ;// clear and add value to list combobox

        space_id = (select.options[select.selectedIndex].value); // get space id
        //alert(space_id); //tester
        document.getElementById("space_id_no").value = space_id;

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
    function list(select)
    {
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
    function click_assign_email()
    {
        user_id = "<?php echo $user_id; ?>";
        email_assign_id = document.getElementById("email_assign_id").value;
        space_id_no = document.getElementById("space_id_no").value;
        list_id_no = document.getElementById("list_id_no").value;

        if(list_id_no == "")
        {
            alert('Please select list and try again.');
        }
        else
        {
            $.ajax({
                url: 'ajax.php',
                type: 'POST', 
                async: false,
                data:{
                    user_id:user_id,
                    email_assign_id:email_assign_id,
                    space_id_no:space_id_no,
                    list_id_no:list_id_no,
                    click_assign_email: 1,
                },
                    success: function(data){
                        if(data == "success")
                        {
                            alert('Email assign successfully.');
                            display_email_assign();                          
                        }
                        else
                        {
                            alert('Email already assign in that list!');  
                        }
                    }
            });  
        }      
    }
    function display_email_assign()
    {
        email_id = document.getElementById("email_assign_id").value;
        $.ajax({
            url: 'ajax.php',
            type: 'POST', 
            async: false,
            data:{
                email_id:email_id,
                display_email_assign: 1,
            },
                success: function(response){
                    $('#fetch_assign_email').html(response);
                }
        });
    }

    function edit_email(id)
    {
        <?php            
            $select_email = mysqli_query($conn, "SELECT * FROM email_format ORDER BY email_name ASC");
            while($fetch_email = mysqli_fetch_array($select_email))
            { ?>
                email_id_exist = "<?php echo $fetch_email['email_id'];?>";
                if(id == email_id_exist)
                {
                    document.getElementsByName("ckeditor").value = "<?php echo $fetch_email['email_id'];?>";
                    document.getElementById("email_content").value = "<?php echo $fetch_email['email_id'];?>";
                    document.getElementById("email_name").value = "<?php echo $fetch_email['email_name'];?>";
                    document.getElementById("email_subject").value = "<?php echo $fetch_email['email_subject'];?>";
                    document.getElementById("span_id").innerHTML = "Email ID:";
                    document.getElementById("email_id").innerHTML = "<?php echo $fetch_email['email_id'];?>";
                    document.getElementById("email_subject").focus();
                    get_email_content();
                }
            <?php
            }
        ?> 
    }
    function get_email_content()
    {
        email_name = document.getElementById("email_name").value;
        $.ajax({
            url: 'ajax.php',
            type: 'POST', 
            async: false,
            data:{
                email_name:email_name,
                get_email_content: 1,
            },
                success: function(data){                    
                    document.getElementById("email_content").value = data;
                    preview();
                }
        });
    }

    function delete_email(id)
    {
        if(confirm("Are you sure you want to delete this email? Email ID: " + id))
        {
            $.ajax({
                url: 'ajax.php',
                type: 'POST', 
                async: false,
                data:{
                    id:id,
                    delete_email: 1,
                },
                    success: function(data){  
                        alert("Email deleted successfully.");
                        location.reload();
                    }
            });
        }
    }

    function preview()
    {
        email_content = document.getElementById("email_content").value;
        $.ajax({
            url: 'ajax.php',
            type: 'POST', 
            async: false,
            data:{
                email_content:email_content,
                preview_email: 1,
            },
                success: function(response){
                    $('#content_message').html(response);
                }
        });

        document.getElementById("test_email").focus();
    }

    function cancel_email()
    {
        location.reload();
    }

    function publish()
    {
        email_created_by = "<?php echo $row['user_id']; ?>";
        email_template = "1" // sample can be change once have multiple template
        email_name = document.getElementById("email_name").value;
        email_subject = document.getElementById("email_subject").value;
        email_content = document.getElementById("email_content").value;

        if(email_name == "" || email_subject == "" || email_content == "")
        {
            alert("Please input email content, name and subject then try again.");
        }
        else
        {
            count = 0;
            <?php            
                $select_email = mysqli_query($conn, "SELECT * FROM email_format ORDER BY email_name ASC");
                while($fetch_email = mysqli_fetch_array($select_email))
                { ?>    
                    email_name_exist = "<?php echo $fetch_email['email_name'];?>";
                    if(email_name == email_name_exist)
                    {   
                        count = 1;
                    }
                <?php 
                }
            ?>

            if(count == 1)
            {    
                if(confirm("Email name already exist in our directory, would you like to update that one?"))
                {
                    save_email();
                }
            }
            else
            {
                save_email();
            }
        }
    }
    function save_email()
    {
        $.ajax({
            url: 'ajax.php',
            type: 'POST', 
            async: false,
            data:{
                email_created_by:email_created_by,
                email_template:email_template,
                email_name:email_name,
                email_subject:email_subject,
                email_content:email_content,
                publish: 1,
            },
                success: function(data){
                    if(data == "Insert")
                    {
                        alert('Email save successfully.');
                    }
                    else
                    {                            
                        alert('Email updated successfully.');
                    }
                    location.reload();
                }
        });
    }

    function test_send_email()
    {        
        test_email = document.getElementById("test_email").value;
        email_subject = document.getElementById("email_subject").value;
        email_content = document.getElementById("email_content").value;

        if(test_email == "" || email_subject == "" || email_content== "")
        {
            alert('Please input subject, message & email.');
        }
        else
        {   
            $.ajax({
                url: 'ajax.php',
                type: 'POST', 
                async: false,
                data:{
                    test_email:test_email,
                    email_subject:email_subject,
                    email_content:email_content,
                    test_send_email: 1,
                },
                    success: function(data){    
                        alert(data);
                    }
            }); 
        }
    }

    function delete_assign_field(id)
    {
        if(confirm("Are you sure you want to delete this email assign?"))
        {
            $.ajax({
                url: 'ajax.php',
                type: 'POST', 
                async: false,
                data:{
                    assign_field_id:id,
                    delete_assign_field: 1,
                },
                    success: function(data){  
                        if (data == 'success') 
                        {
                            alert("Email assign deleted successfully.");
                            display_email_assign();
                        }
                    }
            });
        }
    }
</script>
