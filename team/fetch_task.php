<?php
    if (mysqli_num_rows($findtask) == 0) 
    {}
    else 
    {
        while($result_findstatus = mysqli_fetch_array($findtask))
        {
            $task_id = $result_findstatus['task_id'];
            $total_assign_to = $result_findstatus['task_assign_to']; //get the user_id ex. string = "1,2,3,4,5"
            $assign_to_array = explode(",", $total_assign_to); // eleminate the ","/ comma sign and insert to array ex. [1,2,3,4,5]
            $count_assign_to =  count($assign_to_array);

            $task_tag = $result_findstatus['task_tag']; //get the user_id ex. string = "1,2,3,4,5"
            $assign_task_tag = explode(",", $task_tag); // eleminate the ","/ comma sign and insert to array ex. [1,2,3,4,5]

            $task_assign = $result_findstatus['task_assign_to']; //get the user_id ex. string = "1,2,3,4,5"
            $assign_task_assign = explode(",", $task_assign); // eleminate the ","/ comma sign and insert to array ex. [1,2,3,4,5]

            $select_space = mysqli_query($conn, "SELECT * FROM space WHERE space_id = '$space_id'"); 
            $fetch_select_space = mysqli_fetch_array($select_space);
            $space_db_name = $fetch_select_space['space_db_table']; // get the specific space db_name
            $select_col_in_space_db = mysqli_query($conn, "SELECT * FROM $space_db_name WHERE task_id = '$task_id'");
            $fetch_col_in_space_db = mysqli_fetch_array($select_col_in_space_db);

            if(mysqli_num_rows($filter_tag) == 1)
            {
                if (in_array($tag_filter_value, $assign_task_tag)) // echo if has user_id in db table "task": task_assign_to
                {
                    include('echo_task.php');
                    $abc ++;
                }
            }
            else if(mysqli_num_rows($filter_assign) == 1)
            {
                if (in_array($assign_filter_value, $assign_task_assign)) // echo if has user_id in db table "task": task_assign_to
                {
                    include('echo_task.php');
                    $abc ++;
                }
            }
            else if(mysqli_num_rows($filter_field) == 1)
            {
                $value_array = explode(",,", $field_filter_value); // convert string to array
                if(count($value_array) == 1) // Normal field | textarea,text,email,phone,date,number
                {                       
                    if($fetch_col_in_space_db[''.$field_filter_value.''] == "" || $fetch_col_in_space_db[''.$field_filter_value.''] == "0000-00-00") // check if task has no value in specific column OR a default value "0000-00-00" which is a date
                    {}
                    else
                    {
                        include('echo_task.php');
                        $abc ++;
                    }
                }
                else // If field_type = dropdown || radio
                {                                            
                    $field_value = $value_array[0]; // get only the id
                    $field_col_name = $value_array[1]; // get field column name
                    $field_type = $value_array[2]; // get field type

                    if($fetch_col_in_space_db[''.$field_col_name.''] == $field_value)
                    {
                        include('echo_task.php');
                        $abc ++;
                    }
                }
            }
            else
            {
                include('echo_task.php');
                $abc ++;
            }
        }
    }
    //echo $abc;
?>
<input type="hidden" id="count<?php echo $task_status_id; ?>" value="<?php echo $abc; ?>">