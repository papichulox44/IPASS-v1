<?php
    $space_id = $_GET['space'];
    $list_id = $_GET['list'];
    $status_id = $_GET['status'];

    $contact_id = $row['contact_id'];
    $select_task = mysqli_query($conn, "SELECT * FROM task WHERE task_contact ='$contact_id' and task_list_id = '$list_id'");
    $fetch_select_task = mysqli_fetch_array($select_task);
    $task_id = $fetch_select_task['task_id'];
    
    $select_status_order_no = mysqli_query($conn, "SELECT * FROM status WHERE status_id ='$status_id'");
    $fetch_order_no = mysqli_fetch_array($select_status_order_no);
    $status_order = $fetch_order_no['status_order_no'];

    $select_last_status = mysqli_query($conn,"SELECT * FROM status WHERE status_list_id = '$list_id' ORDER BY status_order_no DESC LIMIT 1");
    $fetch_select_last_status = mysqli_fetch_array($select_last_status);
    $last_status_id = $fetch_select_last_status['status_id'];

    $status = mysqli_query($conn, "SELECT * FROM status WHERE status_list_id ='$list_id' ORDER BY status_order_no ASC");
    $count_status = mysqli_num_rows($status);
    $count = 0;
    while($fetch_status = mysqli_fetch_array($status))
    {
        $count ++;
        if($status_id == $fetch_status['status_id'])
        {
            $z = $count;
        }
    }
    if($count_status == 1)
    {
        $percentage = 0;
    }
    else
    {
        $minus = 1 / ($count_status - 1) * 100;
        $percentage = number_format(($z / ($count_status - 1) * 100) - $minus)."";   
    }
?>
    <!-- Page Content -->
    <div class="content">  

        <div class="row">
            <div class="col-md-12">
                <div class="block block-content shad">
                    <!-- Progress Details -->      
                    <h2 class="content-heading" style="margin-top: -40px;">
                        Progress 
                        <small>in 
                            <?php
                                $select_space = mysqli_query($conn, "SELECT * FROM space WHERE space_id ='$space_id'");
                                $fetch_space = mysqli_fetch_array($select_space);
                                echo $fetch_space['space_name'];
                            ?>  
                            <span id="id_contact" class="badge float-right mt-5" style="font-size: 13px; color: #fff; background-color: #0d7694;">Task ID: <?php echo $task_id;?></span>
                        </small>
                    </h2>
                    <div class="row items-push">
                        <div class="col-md-5">
                            <div class="block block-themed text-center">
                                <div style="background: #eee; padding: 15px;">
                                    <div class="py-20 text-center" style="background-color: #fff;">
                                        <div class="js-pie-chart pie-chart" data-percent="<?php echo $percentage; ?>" data-line-width="9" data-size="180" data-bar-color="#42a5f5" data-track-color="#e9e9e9">
                                            <span>
                                                <?php 
                                                if($percentage == 100)
                                                {
                                                    // echo '<i class="fa fa-4x fa-trophy text-muted"></i>';
                                                    echo '<img style="height: 150px;" src="../assets/media/photos/logo-ipass.png">';
                                                }
                                                else
                                                {
                                                    // echo '<i class="fa fa-4x fa-cog fa-spin text-primary"></i>';
                                                    echo '<img class="fa fa-4x fa-cog fa-spin text-primary" style="height: 150px;" src="../assets/media/photos/logo-ipass.png">';
                                                }
                                                ?>
                                            </span>
                                        </div>
                                        <br>
                                    <?php 
                                        if($percentage == 100)
                                        {
                                            echo '<div class="block-content-full block-content-sm" style="background-color: #0d7694;">
                                                    <div class="font-w600 text-white" style="font-size: 70px;">'.$percentage.'%</div>
                                                    <div class="text-uppercase text-white" style="margin-top: -16px;">Complete</div>';
                                                    $select_status = mysqli_query($conn, "SELECT * FROM status WHERE status_id ='$status_id' ORDER BY status_order_no ASC");
                                                    $result_select_status = mysqli_fetch_array($select_status);
                                                    echo'
                                                    <div class="text-uppercase text-white" style="padding: 5px 10px; color: #fff; margin-bottom: -20px; background-color: #013c4c;">Status: '.$result_select_status['status_name'].'</div>
                                                </div>';
                                        }
                                        else
                                        {
                                            echo '<div class="block-content-full block-content-sm" style="background-color: #0d7694;">
                                                    <div class="font-w600 text-white" style="font-size: 70px;">'.$percentage.'%</div>
                                                    <div class="text-uppercase text-white" style="margin-top: -16px;">Progress</div>';
                                                    $select_status = mysqli_query($conn, "SELECT * FROM status WHERE status_id ='$status_id' ORDER BY status_order_no ASC");
                                                    $result_select_status = mysqli_fetch_array($select_status);
                                                    echo'
                                                    <div class="text-uppercase text-white" style="padding: 5px 10px; color: #fff; margin-bottom: -20px; background-color: #013c4c;">Status: '.$result_select_status['status_name'].'</div>
                                                </div>';
                                        }
                                    ?>
                                    </div>
                                </div>
                                <div class="block-header block-header-default" style="background-color: #0d7694;">
                                        <h1 class="block-title text-white text-left">Requirements</h1>
                                    </div>
                                <div data-toggle="slimscroll" data-height="280px" data-color="#42a5f5" data-opacity="1" data-always-visible="true">
                                    <br>
                                    <?php 
                                    $space_id = $_GET['space'];
                                    $task_id = $task_id;
                                    $select_db = mysqli_query($conn, "SELECT * FROM requirement_field WHERE requirement_space_id ='$space_id' ORDER BY requirement_order_no ASC");
                                    $count_field = mysqli_num_rows($select_db);
                                    while($rows = mysqli_fetch_array($select_db))
                                    {
                                        $field_id = $rows['requirement_id'];
                                        $select_requirement_value = mysqli_query($conn, "SELECT * FROM requirement_value WHERE value_to ='$task_id' AND value_field_id ='$field_id'");
                                        $field_value = mysqli_fetch_array($select_requirement_value);
                                        $count = mysqli_num_rows($select_requirement_value);
                                        if($count == 0) // checking if field has value in specific task
                                        {
                                            $value = "";
                                        }
                                        else
                                        {
                                            $value = $field_value['value_value'];
                                        }

                                        if($rows['requirement_type'] == "Text")
                                        {
                                            echo'<div class="form-group row">
                                                    <label class="col-lg-4 col-form-label">'.$rows['requirement_name'].'</label>
                                                    <div class="col-lg-8">
                                                        <input disabled type="text" class="form-control" id="requirement_input_field'.$rows['requirement_id'].'" value="'.$value.'">
                                                    </div>
                                                </div>';
                                        }
                                        else
                                        {
                                            echo'<div class="form-group row">
                                                    <label class="col-lg-4 col-form-label">'.$rows['requirement_name'].'</label>
                                                    <div class="col-lg-8">';
                                                        $select_field1 = mysqli_query($conn, "SELECT * FROM requirement_child WHERE child_id = '$value'");
                                                        $get_color = mysqli_fetch_array($select_field1);
                                                        if($get_color['child_color'] == "")
                                                        { $color = ""; }
                                                        else
                                                        { $color = "#ffffff"; }
                                                        echo'
                                                        <select class="form-control" id="requirement_input_field'.$rows['requirement_id'].'" style="color: '.$color.'; background-color: '.$get_color['child_color'].';" disabled>
                                                            <option value="">Select...</option>
                                                            ';
                                                                $select_field = mysqli_query($conn, "SELECT * FROM requirement_child WHERE child_field_id = '$field_id' ORDER BY child_id ASC");
                                                                while($fetch_select_field = mysqli_fetch_array($select_field))
                                                                {
                                                                    if($fetch_select_field['child_id'] == $value)
                                                                    {
                                                                        echo'<option disabled value="'.$fetch_select_field['child_id'].'" style="color: #fff; background-color: '.$fetch_select_field['child_color'].';" selected>'.$fetch_select_field['child_name'].'</option>';
                                                                    }
                                                                }
                                                            echo'
                                                        </select>
                                                    </div>
                                                </div>';
                                        }
                                    }
                                     ?>
                                </div>

                            </div>                                   
                        </div> 
                        <div class="col-md-7">
                            <select class="form-control text-muted mb-10" id="phase_id" onchange="show_list_of_payment()" style="width: 100%;">
                            <option disabled="disabled" selected="selected">Select phase...</option>
                            <?php 
                            $space_id = $_GET['space'];

                                $select_phase = mysqli_query($conn, "SELECT * FROM finance_phase WHERE phase_space_id ='$space_id' ORDER BY phase_id ASC");
                                while($rows = mysqli_fetch_array($select_phase))
                                {
                                    echo '<option value="'.$rows['phase_id'].'">'.$rows['phase_name'].'</option>';
                                }
                             ?>
                            </select>
                            <div class="table responsive" id="fetch_list_of_payment">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="block shad">
                    <div class="block-header block-header-default" style="background-color: #0d7694;">
                        <h1 class="block-title text-white">Field</h1>
                        <div class="block-options">
                            <button type="button" class="btn-block-option text-white" data-toggle="block-option" data-action="content_toggle"></button>
                        </div>
                    </div>
                    <div class="block-content"> 
                        <div class="row items-push">
                            <?php                          

                                $select_db = mysqli_query($conn, "SELECT * FROM space WHERE space_id ='$space_id'");
                                $fetch_select_db = mysqli_fetch_array($select_db);
                                $space_db_table = $fetch_select_db['space_db_table']; // getting the db_table name of the space
                                $check_if_task_exist = mysqli_query($conn, "SELECT * FROM $space_db_table WHERE task_id ='$task_id'");
                                $fetch_input_value = mysqli_fetch_array($check_if_task_exist);

                                $select_status1 = mysqli_query($conn, "SELECT * FROM status WHERE status_list_id ='$list_id' ORDER BY status_order_no ASC");
                                while($result_select_status1 = mysqli_fetch_array($select_status1))
                                {
                                    $status_name = $result_select_status1['status_name'];
                                    if($status_order >= $result_select_status1['status_order_no'])
                                    {
                                        echo '<div class="col-md-6">
                                            <div class="block" style="box-shadow:0px 2px 4px #b3b3b3;">
                                                <div class="block-header block-header-default" style="height: 30px; background-color: #77979f; ">
                                                    <h3 class="block-title text-white">';
                                                        $new_name = substr($status_name, 0, 25); // get specific character

                                                        if(strlen($status_name) > 25)
                                                        {
                                                            echo '<span data-toggle="popover" title="'.$status_name.'" data-placement="bottom">'.$new_name.'...</span>';
                                                        }
                                                        else
                                                        {
                                                            echo '<span>'.$status_name.'</span>';
                                                        }
                                                        echo '
                                                    </h3>
                                                    <div class="block-options">';
                                                    $last_status_order = $count_status - 1;
                                                    if($last_status_order == $result_select_status1['status_order_no'])
                                                    {
                                                        echo '<span class="ml-10 text-white" style="padding: 5px; background-color: #2d9e04;">DONE</span>';
                                                    }
                                                    else if($status_order == $result_select_status1['status_order_no'])
                                                    {
                                                        echo '<span class="ml-10 text-white" style="padding: 5px; background-color: #ff9c07;">In Progress</span>';
                                                    }
                                                    else if($status_order >= $result_select_status1['status_order_no'])
                                                    {
                                                        echo '<span class="ml-10 text-white" style="padding: 5px; background-color: #0d7694;">Complete</span>';
                                                    }
                                                    else
                                                    {
                                                    }
                                                    echo'<button type="button" class="btn-block-option text-white" data-toggle="block-option" data-action="content_toggle"></button>
                                                    </div>
                                                </div>
                                                <div class="block-content" style="background-color: #e9e9e9; ">';
                                                include("field.php");
                                          echo '</div>
                                            </div>
                                        </div>';
                                    }
                                    else
                                    {

                                    }
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</div>

<!-- Fade In Modal -->
        <div class="modal fade" id="modal-currency" tabindex="-1" role="dialog" aria-labelledby="modal-fadein" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="block block-themed block-transparent mb-0">
                        <div class="block-header bg-primary-dark">
                            <h3 class="block-title">USD Rate</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                    <i class="si si-close"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content">
                            <table class="table table-bordered table-striped table-hover table-vcenter shad">
                                <tr>
                                    <th class="text-center">VALUE (PHP)</th>
                                </tr>   
                                <tbody>
                                    <?php 
                                    $select_currency = mysqli_query($conn, "SELECT * FROM finance_currency WHERE currency_code = 'USD'");
                                    foreach ($select_currency as $data) {
                                        echo '
                                        <tr>
                                            <td class="text-center">'.$data['currency_val_php'].'</td>
                                        </tr>
                                        ';
                                    }
                                     ?>
                                </tbody>                             
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Fade In Modal -->

<script>

    function show_list_of_payment()
    {
        task_id = <?php echo $task_id; ?>;
        phase_id = document.getElementById("phase_id").value;

        $("#modal-currency").modal();
        $.ajax({
        url:"ajax.php",
        method:"post",
        data:{
            task_id:task_id,
            phase_id:phase_id,
            fetch_finance_field_by_phase: 1,},
        success:function(response){
             $('#fetch_list_of_payment').html(response);
        }
    });
    }

</script>