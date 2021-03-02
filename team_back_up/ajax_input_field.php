<?php  
    include("../conn.php");
    if(isset($_POST["task_id"]))  
    {
        $space_id = $_POST['space_id'];
        $list_id = $_POST['list_id'];
        $task_id = $_POST['task_id'];
        $select_db = mysqli_query($conn, "SELECT * FROM space WHERE space_id ='$space_id'");
        $fetch_select_db = mysqli_fetch_array($select_db);
        $space_db_table = $fetch_select_db['space_db_table']; // getting the db_table name of the space
        $check_if_task_exist = mysqli_query($conn, "SELECT * FROM $space_db_table WHERE task_id ='$task_id'");
        $fetch_input_value = mysqli_fetch_array($check_if_task_exist);

        $results = mysqli_query($conn, "SELECT * FROM field WHERE field_space_id = '$space_id' ORDER BY field_order ASC");            
        $count_field = mysqli_num_rows($results); 
        $radio_count = 0;
        while($rows = mysqli_fetch_array($results))
        {
            $field_assign_to = $rows['field_assign_to'];
            if($field_assign_to == "")
            {
                $status_id = 0;
            }
            else
            {
                $assign_array = explode(",", $field_assign_to); // convert string to array
                $key = array_search($list_id,$assign_array); // get the key or position of list
                $status_id = $assign_array[$key+1];                
            }

            $select = mysqli_query($conn, "SELECT * FROM status WHERE status_id = '$status_id'");
            $fetch_select = mysqli_fetch_array($select);
            $color1 = $fetch_select['status_color'];
            $order1 = $fetch_select['status_order_no'];
            $order = $order1 + 1;
            if( $color1 == "") { $color = "#ffffff"; }
            else { $color = $color1; }

            if($rows['field_type'] == "Textarea")
            {
                echo'
                    <div class="form-group row">
                        <label class="col-lg-4 col-form-label">';
                        if($order1 != "")
                        {
                            echo '<span class="badge text-white" style="background-color: '.$color.'">'.$order.'</span>&nbsp;';
                        }
                        echo '
                        '.$rows['field_name'].'
                        </label>
                        <div class="col-lg-7">
                            <textarea class="form-control" rows="2" id="field_textarea'.$rows['field_id'].'">'.$fetch_input_value[''.$rows['field_col_name'].''].'</textarea>
                        </div>
                        <div>
                            <button type="button" class="btn btn-sm btn-circle btn-alt-success mr-5 mb-5" id="'.$rows['field_id'].'" onclick="input_field_textarea(this.id)">
                                <i class="fa fa-check"></i>
                            </button>
                        </div>
                    </div>';
            }
            else if($rows['field_type'] == "Text")
            {
                echo'<div class="form-group row">
                        <label class="col-lg-4 col-form-label">';
                        if($order1 != "")
                        {
                            echo '<span class="badge text-white" style="background-color: '.$color.'">'.$order.'</span>&nbsp;';
                        }
                        echo '
                        '.$rows['field_name'].'
                        </label>
                        <div class="col-lg-7">
                            <input type="text" class="form-control" id="field_text'.$rows['field_id'].'" value="'.$fetch_input_value[''.$rows['field_col_name'].''].'">
                        </div>
                        <div>
                            <button type="button" class="btn btn-sm btn-circle btn-alt-success mr-5 mb-5" id="'.$rows['field_id'].'" onclick="input_field_text(this.id)">
                                <i class="fa fa-check"></i>
                            </button>
                        </div>
                    </div>';
            }
            else if($rows['field_type'] == "Email")
            {
                echo'<div class="form-group row">
                        <label class="col-lg-4 col-form-label">';
                        if($order1 != "")
                        {
                            echo '<span class="badge text-white" style="background-color: '.$color.'">'.$order.'</span>&nbsp;';
                        }
                        echo '
                        '.$rows['field_name'].'
                        </label>
                        <div class="col-lg-7">
                            <input type="email" class="form-control" id="field_email'.$rows['field_id'].'" value="'.$fetch_input_value[''.$rows['field_col_name'].''].'">
                        </div>
                        <div>
                            <button type="button" class="btn btn-sm btn-circle btn-alt-success mr-5 mb-5" id="'.$rows['field_id'].'" onclick="input_field_email(this.id)">
                                <i class="fa fa-check"></i>
                            </button>
                        </div>
                    </div>';
            }
            else if($rows['field_type'] == "Dropdown")
            {
                echo'<div class="form-group row">
                        <label class="col-lg-4 col-form-label">';
                        if($order1 != "")
                        {
                            echo '<span class="badge text-white" style="background-color: '.$color.'">'.$order.'</span>&nbsp;';
                        }
                        echo '
                        '.$rows['field_name'].'
                        </label>
                        <div class="col-lg-7">';
                            $field_id = $rows['field_id'];
                            $select_col_name = $fetch_input_value[''.$rows['field_col_name'].''];
                            $select_child_color = mysqli_query($conn, "SELECT * FROM child WHERE child_id = '$select_col_name'");
                            $color_selctor = mysqli_fetch_array($select_child_color);
                            if($color_selctor['child_color'] == "")
                            { $color = ""; }
                            else
                            { $color = "#ffffff"; }
                            echo'
                            <select class="form-control" id="field_dropdown'.$rows['field_id'].'" style="color: '.$color.'; background-color: '.$color_selctor['child_color'].';">
                                <option value="" style="color: #848484; background-color: #ffffff;">Select...</option>
                                ';
                                    $select_field = mysqli_query($conn, "SELECT * FROM child WHERE child_field_id = '$field_id' ORDER BY child_order ASC");
                                    while($fetch_select_field = mysqli_fetch_array($select_field))
                                    {
                                        $selected_option = $select_col_name;
                                        if($selected_option == $fetch_select_field['child_id'])
                                        {
                                            echo'<option value="'.$fetch_select_field['child_id'].'" style="color: #fff; background-color: '.$fetch_select_field['child_color'].';" selected>'.$fetch_select_field['child_name'].'</option>';
                                        }
                                        else
                                        {
                                            echo'<option value="'.$fetch_select_field['child_id'].'" style="color: #fff; background-color: '.$fetch_select_field['child_color'].';">'.$fetch_select_field['child_name'].'</option>';
                                        }
                                    }
                                echo'
                            </select>
                        </div>
                        <div>
                            <button type="button" class="btn btn-sm btn-circle btn-alt-success mr-5 mb-5" id="'.$rows['field_id'].'" onclick="input_field_dropdown(this.id)">
                                <i class="fa fa-check"></i>
                            </button>
                        </div>
                    </div>';
            }
            else if($rows['field_type'] == "Phone")
            {
                echo'<div class="form-group row">
                        <label class="col-lg-4 col-form-label">';
                        if($order1 != "")
                        {
                            echo '<span class="badge text-white" style="background-color: '.$color.'">'.$order.'</span>&nbsp;';
                        }
                        echo '
                        '.$rows['field_name'].'
                        </label>
                        <div class="col-lg-7">
                            <input type="number" class="form-control" id="phone_field'.$rows['field_id'].'" value="'.$fetch_input_value[''.$rows['field_col_name'].''].'">
                        </div>
                        <div>
                            <button type="button" class="btn btn-sm btn-circle btn-alt-success mr-5 mb-5" id="'.$rows['field_id'].'" onclick="input_field_phone(this.id)">
                                <i class="fa fa-check"></i>
                            </button>
                        </div>
                    </div>';
            }
            else if($rows['field_type'] == "Date")
            {
                echo'<div class="form-group row">
                        <label class="col-lg-4 col-form-label">';
                        if($order1 != "")
                        {
                            echo '<span class="badge text-white" style="background-color: '.$color.'">'.$order.'</span>&nbsp;';
                        }
                        echo '
                        '.$rows['field_name'].'
                        </label>
                        <div class="col-lg-7">
                            <input type="date" class="form-control" id="field_date'.$rows['field_id'].'" value="'.$fetch_input_value[''.$rows['field_col_name'].''].'">
                        </div>
                        <div>
                            <button type="button" class="btn btn-sm btn-circle btn-alt-success mr-5 mb-5" id="'.$rows['field_id'].'" onclick="input_field_date(this.id)">
                                <i class="fa fa-check"></i>
                            </button>
                        </div>
                    </div>';
            }
            else if($rows['field_type'] == "Number")
            {
                echo'<div class="form-group row">
                        <label class="col-lg-4 col-form-label">';
                        if($order1 != "")
                        {
                            echo '<span class="badge text-white" style="background-color: '.$color.'">'.$order.'</span>&nbsp;';
                        }
                        echo '
                        '.$rows['field_name'].'
                        </label>
                        <div class="col-lg-7">
                            <input type="number" class="form-control" id="field_number'.$rows['field_id'].'" value="'.$fetch_input_value[''.$rows['field_col_name'].''].'">
                        </div>
                        <div>
                            <button type="button" class="btn btn-sm btn-circle btn-alt-success mr-5 mb-5" id="'.$rows['field_id'].'" onclick="input_field_number(this.id)">
                                <i class="fa fa-check"></i>
                            </button>
                        </div>
                    </div>';
            }
            else
            {
                $radio_count ++;
                echo'<div class="form-group row">
                        <label class="col-lg-4 col-form-label">';
                        if($order1 != "")
                        {
                            echo '<span class="badge text-white" style="background-color: '.$color.'">'.$order.'</span>&nbsp;';
                        }
                        echo '
                        '.$rows['field_name'].'
                        </label>
                        <div class="col-lg-3 col-form-label">
                        <label>Status: '; if($fetch_input_value[''.$rows['field_col_name'].''] == "yes"){ echo 'Yes'; } else { echo 'No'; } echo'</label>
                        </div>
                        <div class="col-lg-4">';
                            echo '
                            <label class="css-control css-control-primary css-radio">
                                <input type="radio" class="css-control-input" name="field_radio" value="yes" id="field_radio'.$rows['field_id'].'"'; if($fetch_input_value[''.$rows['field_col_name'].''] == "yes"){ echo 'checked'; } echo'>
                                <span class="css-control-indicator"></span> Yes
                            </label>
                            <label class="css-control css-control-primary css-radio">
                                <input type="radio" class="css-control-input" name="field_radio" value="no" id="field_radio'.$rows['field_id'].'"'; if($fetch_input_value[''.$rows['field_col_name'].''] == "no"){ echo 'checked'; } echo'>
                                <span class="css-control-indicator"></span> No
                            </label>';       
                            echo '
                        </div>
                        <div>
                            <button type="button" class="btn btn-sm btn-circle btn-alt-success mr-5 mb-5" id="'.$rows['field_id'].','.$radio_count.'" onclick="input_field_radio(this.id)">
                                <i class="fa fa-check"></i>
                            </button>
                        </div>
                    </div>';
            }
        }
    }
    if($count_field == 0)
    {}
    else
    {
        // echo '<div class="row">
        //         <div class="col-12">
        //             <button type="button" class="btn btn-md btn-noborder btn-primary btn-block" onclick="btn_save_input_field()"><li class="fa fa-check"></li> Save</button>
        //         </div>
        //     </div>';
    }
?>    
