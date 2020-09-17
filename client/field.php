<?php
    $status_id = $result_select_status1['status_id'];
    $select_field = mysqli_query($conn, "SELECT * FROM field WHERE field_space_id = '$space_id' ORDER BY field_order ASC");
    while($fetch_select_field = mysqli_fetch_array($select_field))
    {
        $field_assign_to = $fetch_select_field['field_assign_to']; 
        if($field_assign_to != "")  
        {
            $assign_array = explode(",", $field_assign_to);
            $key = array_search($list_id,$assign_array); // get the key or position of list
            $statusid = $assign_array[$key+1];
            if($status_id == $statusid)
            {
                if($fetch_select_field['field_type'] == "Textarea")
                {
                    echo'<div class="form-group row">
                            <label class="col-lg-4">'.$fetch_select_field['field_name'].'</label>
                            <div class="col-lg-8">
                                <textarea class="form-control" rows="2" style="background-color: #fff;" readonly>'.$fetch_input_value[''.$fetch_select_field['field_col_name'].''].'</textarea>
                            </div>
                        </div>';
                }
                else if($fetch_select_field['field_type'] == "Text")
                {
                    echo'<div class="form-group row">
                            <label class="col-lg-4">'.$fetch_select_field['field_name'].'</label>
                            <div class="col-lg-8">
                                <input type="text" class="form-control" value="'.$fetch_input_value[''.$fetch_select_field['field_col_name'].''].'" style="background-color: #fff;" readonly>
                            </div>
                        </div>';
                }
                else if($fetch_select_field['field_type'] == "Email")
                {
                    echo'<div class="form-group row">
                            <label class="col-lg-4">'.$fetch_select_field['field_name'].'</label>
                            <div class="col-lg-8">
                                <input type="email" class="form-control" value="'.$fetch_input_value[''.$fetch_select_field['field_col_name'].''].'" style="background-color: #fff;" readonly>
                            </div>
                        </div>';
                }
                else if($fetch_select_field['field_type'] == "Dropdown")
                {
                    echo'
                    <div class="form-group row">
                        <label class="col-lg-4">'.$fetch_select_field['field_name'].'</label>
                        <div class="col-lg-8">';
                            $field_id = $fetch_select_field['field_id'];
                            $select_col_name = $fetch_input_value[''.$fetch_select_field['field_col_name'].''];
                            $select_child_color = mysqli_query($conn, "SELECT * FROM child WHERE child_id = '$select_col_name'");
                            $color_selctor = mysqli_fetch_array($select_child_color);
                            if($color_selctor['child_color'] == "")
                            { $color = ""; $bgcolor = "#fff";}
                            else
                            { $color = "#ffffff"; $bgcolor = $color_selctor['child_color'];}
                            echo'
                            <select class="form-control" style="color: '.$color.'; background-color: '.$bgcolor.';" disabled="true">
                                <option value="">Select...</option>
                                ';
                                    $select_field1 = mysqli_query($conn, "SELECT * FROM child WHERE child_field_id = '$field_id' ORDER BY child_order ASC");
                                    while($fetch_select_field_child = mysqli_fetch_array($select_field1))
                                    {
                                        $selected_option = $select_col_name;
                                        if($selected_option == $fetch_select_field_child['child_id'])
                                        {
                                            echo'<option value="'.$fetch_select_field_child['child_id'].'" style="color: #fff; background-color: '.$fetch_select_field_child['child_color'].';" selected>'.$fetch_select_field_child['child_name'].'</option>';
                                        }
                                    }
                                echo'
                            </select>
                        </div>
                    </div>';
                }
                else if($fetch_select_field['field_type'] == "Phone")
                {
                    echo'<div class="form-group row">
                            <label class="col-lg-4">'.$fetch_select_field['field_name'].'</label>
                            <div class="col-lg-8">
                                <input type="number" class="form-control" value="'.$fetch_input_value[''.$fetch_select_field['field_col_name'].''].'" style="background-color: #fff;" readonly>
                            </div>
                        </div>';
                }
                else if($fetch_select_field['field_type'] == "Date")
                {
                    echo'<div class="form-group row">
                            <label class="col-lg-4">'.$fetch_select_field['field_name'].'</label>
                            <div class="col-lg-8">
                                <input type="date" class="form-control" value="'.$fetch_input_value[''.$fetch_select_field['field_col_name'].''].'" style="background-color: #fff;" readonly>
                            </div>
                        </div>';
                }
                else if($fetch_select_field['field_type'] == "Number")
                {
                    echo'<div class="form-group row">
                            <label class="col-lg-4">'.$fetch_select_field['field_name'].'</label>
                            <div class="col-lg-8">
                                <input type="number" class="form-control" value="'.$fetch_input_value[''.$fetch_select_field['field_col_name'].''].'" style="background-color: #fff;" readonly>
                            </div>
                        </div>';
                }
                else
                {
                    echo'<div class="form-group row">
                            <label class="col-lg-4">'.$fetch_select_field['field_name'].'</label>
                            <div class="col-lg-8">';
                                if($fetch_input_value[''.$fetch_select_field['field_col_name'].''] == "yes")
                                {
                                    echo '<label class="css-control css-control-primary css-radio">
                                            <input type="radio" class="css-control-input" name="radio-group2" disabled="true" checked>
                                            <span class="css-control-indicator"></span> Yes
                                        </label>
                                        <label class="css-control css-control-primary css-radio">
                                            <input type="radio" class="css-control-input" name="radio-group2" disabled="true">
                                            <span class="css-control-indicator"></span> No
                                        </label>';
                                }
                                else if($fetch_input_value[''.$fetch_select_field['field_col_name'].''] == "no")
                                {
                                    echo '<label class="css-control css-control-primary css-radio">
                                            <input type="radio" class="css-control-input" name="radio-group2" disabled="true">
                                            <span class="css-control-indicator"></span> Yes
                                        </label>
                                        <label class="css-control css-control-primary css-radio">
                                            <input type="radio" class="css-control-input" name="radio-group2" disabled="true" checked>
                                            <span class="css-control-indicator"></span> No
                                        </label>';
                                }
                                else
                                {
                                    echo '<label class="css-control css-control-primary css-radio">
                                            <input type="radio" class="css-control-input" name="radio-group2" disabled="true">
                                            <span class="css-control-indicator"></span> Yes
                                        </label>
                                        <label class="css-control css-control-primary css-radio">
                                            <input type="radio" class="css-control-input" name="radio-group2" disabled="true">
                                            <span class="css-control-indicator"></span> No
                                        </label>';                            
                                }
                                echo'    
                            </div>
                        </div>';
                }
            }
        }        
    }
?>
