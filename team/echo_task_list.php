<?php
echo'
    <tr class"hoverme" id="taskmodal'.$result_findstatus['task_id'].'" onclick="show_task_modal(this.id)" data-toggle="modal" data-target="#modal-extra-large">
    <input type="hidden" value="'.$result_findstatus['task_name'].'" id="rename'.$result_findstatus['task_id'].'">
        <button type="button" class="view_data" hidden="hidden" value="'.$result_findstatus['task_id'].'" id="btnStartVisit'.$result_findstatus['task_id'].'"></button>
        <td class="text-center">Task ID: '.$result_findstatus['task_id'].'</td>
        <td class="font-w600">'.$result_findstatus['task_name'].'';
            $total_tag_per_task = $result_findstatus['task_tag'];
            $tag_array = explode(",", $total_tag_per_task); // convert string to array
            $count_tag = count($tag_array);
            if ($total_tag_per_task === "")
            {}
            else
            {
                for ($x = 1; $x <= $count_tag; $x++)
                {
                    $y = $x - 1;
                    $final_tag_name = $tag_array[$y];
                    $get_tag_color = mysqli_query($conn, "SELECT * FROM tags WHERE tag_id = '$final_tag_name'");
                    $result_get_tag_color = mysqli_fetch_array($get_tag_color);
                    echo'<span style="background-color: '.$result_get_tag_color['tag_color'].'; color:#fff; padding:2px 7px 2px 5px; border-top-right-radius: 25px; border-bottom-right-radius: 25px; font-size: 11px; margin: 0px 0px 0px 5px;">'.$result_get_tag_color['tag_name'].' </span>';
                }
            }
        echo'
        </td>
        <td class="d-none d-sm-table-cell">';
            if($ymd === $today)
            {
                $task_priority = "D Urgent";
                mysqli_query($conn, "UPDATE task SET task_priority='$task_priority' WHERE task_id='$task_id'") or die(mysqli_error());
                echo'<span class="badge badge-danger">Today</span>';
            }
            else if($ymd === $tomorrow)
            {
                $task_priority = "C High";
                mysqli_query($conn, "UPDATE task SET task_priority='$task_priority' WHERE task_id='$task_id'") or die(mysqli_error());
                echo'<span class="badge badge-warning">Tomorrow</span>';
            }
            else if(is_null($due_date_time) or $due_date_time === '0000-00-00')
            {
                echo'<span class="badge badge-primary">No Due Date yet!!</span>';
                // echo date("l");
            }
            else if($due_date_time < $date_today)
            {
                echo'<span class="badge badge-danger">Overdue</span>';
            }
            else if($ymd === $tomorrow2)
            {
                echo'<span class="badge badge-info">'.date("l", strtotime($due_date_time)).'</span>';
            }
            else if($ymd === $tomorrow3)
            {
                echo'<span class="badge badge-info">'.date("l", strtotime($due_date_time)).'</span>';
            }
            else if($ymd === $tomorrow4)
            {
                echo'<span class="badge badge-info">'.date("l", strtotime($due_date_time)).'</span>';
            }
            else if($ymd === $tomorrow5)
            {
                echo'<span class="badge badge-info">'.date("l", strtotime($due_date_time)).'</span>';
            }
            else if($ymd === $tomorrow6)
            {
                echo'<span class="badge badge-info">'.date("l", strtotime($due_date_time)).'</span>';
            }
            else
            {
              echo'<span class="badge badge-success">'.$due_date_time.'</span>';
            }
        echo'
        </td>
        <td>';
        if($result_findstatus['task_priority'] === "D Urgent")
        {
            echo '<span style="display: none;">D</span><span class="badge badge-danger">Urgent</span>';
        }
        else if($result_findstatus['task_priority'] === "C High")
        {
            echo '<span style="display: none;">C</span><span class="badge badge-warning">High</span>';
        }
        else if($result_findstatus['task_priority'] === "B Normal")
        {
            echo '<span style="display: none;">B</span><span class="badge badge-primary">Normal</span>';
        }
        else if($result_findstatus['task_priority'] === "A Low")
        {
            echo '<span style="display: none;">A</span><span class="badge badge-secondary">Low</span>';
        }
        else
        {}
        $comment_query = mysqli_query($conn, "SELECT `comment`.comment_date FROM `comment` WHERE `comment`.comment_task_id = '$task_id' ORDER BY `comment`.comment_date DESC LIMIT 1");
        $data = mysqli_fetch_assoc($comment_query);
        $date_updated = $data['comment_date'];
        echo'
        <td class="text-center">
            '.$date_updated.'
        </td>
        </td>
        <td class="d-none d-sm-table-cell text-center">';
        if ($total_assign_to === 0)
        {
            echo 'Unassign';
        }
        else
        {
            for ($x = 1; $x <= $count_assign_to; $x++)
            {
                $y = $x - 1; // tricks to get every user_id
                $final_assign_to_name = $assign_to_array[$y];
                $get_user_profile = mysqli_query($conn, "SELECT * FROM user WHERE user_id = '$final_assign_to_name'");
                $result_get_user_profile = mysqli_fetch_array($get_user_profile);

                $get_first_letter_in_fname = $result_get_user_profile['fname'];
                $get_first_letter_in_lname = $result_get_user_profile['lname'];

                if($result_get_user_profile['profile_pic'] != "")
                {
                    echo '<img type="button" title="'.$result_get_user_profile['fname'].' '.$result_get_user_profile['lname'].'" src="../assets/media/upload/'.$result_get_user_profile['profile_pic'].'" style="width:33px; height:33px; border-radius:50px; margin: 0px -5px 0px -5px; border: 1px solid #fff;">
                            <span style="display: none;">'.$result_get_user_profile['fname'].' '.$result_get_user_profile['lname'].'</span>';
                }
                else
                {
                    echo '<span class="btn btn-circle" type="button" title="'.$result_get_user_profile['fname'].' '.$result_get_user_profile['lname'].'" style="background-color: '.$result_get_user_profile['user_color'].'; margin: 0px -5px 0px -5px; border: 1px solid #fff;">
                            <i class="text-white" style="font-size: 12px;">'.$get_first_letter_in_fname[0].''.$get_first_letter_in_lname[0].'</i>
                            </span>
                            </span><span style="display: none;">'.$result_get_user_profile['fname'].' '.$result_get_user_profile['lname'].'</span>';
                }
            }
        }
        echo'
        </td>';
//_______________________________ auto create td
        $select_space = mysqli_query($conn, "SELECT * FROM space WHERE space_id = '$space_id'");
        $fetch_tb_name = mysqli_fetch_array($select_space);
        $space_tb_name = $fetch_tb_name['space_db_table']; // get the table name of the space

        $select_tb_column = mysqli_query($conn, "SELECT * FROM add_column WHERE column_space_id = '$space_id' AND column_user_id = '$user_id'");
        while($select_column = mysqli_fetch_array($select_tb_column))
        {
            $col_name1 = $select_column['column_name']; // get the tb_column_name

            //identify type of field or column
            $select_field = mysqli_query($conn, "SELECT * FROM field WHERE field_space_id = '$space_id' AND field_col_name ='$col_name1'");
            $fetch_field = mysqli_fetch_array($select_field);

            $select_tb_field1 = mysqli_query($conn, "SELECT * FROM $space_tb_name WHERE task_id = '$task_id'");
            $fetch_name1 = mysqli_fetch_array($select_tb_field1);
            if( $fetch_field['field_type'] === "Dropdown")
            {
                $child_id = $fetch_name1[''.$col_name1.'']; // get the child id
                $select_drop_down_child = mysqli_query($conn, "SELECT * FROM child WHERE child_id = '$child_id'");
                $fetch_child = mysqli_fetch_array($select_drop_down_child);
                $child_name = $fetch_child['child_name'];
                $child_color = $fetch_child['child_color'];

                echo '<td class="d-none d-sm-table-cell text-center text-white" style="background-color: '.$child_color.';">'.$child_name.'</td>';
            }
            else
            {
                echo '<td class="d-none d-sm-table-cell text-center">'.$fetch_name1[''.$col_name1.''].'</td>';
            }
        }
//_______________________________ END auto create td
        echo'
    </tr>';
?>
