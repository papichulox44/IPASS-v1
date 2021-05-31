<?php

    $task_status_id = $fetch_task['task_status_id'];
    $task_list_id = $fetch_task['task_list_id']; // get list id
    $task_id = $fetch_task['task_id'];

    $date_today = date('Y-m-d');
    $today = date("Y-m-d"); // Get current date
    $tomorrow = date('Y-m-d', strtotime(' +1 day')); // Get tomorrow date
    $tomorrow2 = date('Y-m-d', strtotime(' +2 day'));
    $tomorrow3 = date('Y-m-d', strtotime(' +3 day'));
    $tomorrow4 = date('Y-m-d', strtotime(' +4 day'));
    $tomorrow5 = date('Y-m-d', strtotime(' +5 day'));
    $tomorrow6 = date('Y-m-d', strtotime(' +6 day'));
    $due_date_time = $fetch_task['task_due_date']; // ex: 2020-12-10 00:00:00
    $ymd = substr($due_date_time, -19, 10); // 2020-12-10 00:00:00 // Y-m-d = 2020-12-10 00

    $select_list = mysqli_query($conn, "SELECT * FROM list WHERE list_id = '$task_list_id'");
    $list_name = mysqli_fetch_array($select_list);

    echo'
    <tr style="cursor: pointer;">
        <td id="taskid_'.$task_id.'" onclick="view_task(this.id)">Task ID: '.$task_id.'</td>
        <td id="taskid_'.$task_id.'" onclick="view_task(this.id)">';
            $task_name = $fetch_task['task_name'];
            echo '<span data-toggle="popover" title="'.$fetch_task['task_name'].'" data-placement="bottom">'.$task_name.'</span>';
                $total_tag_per_task = $fetch_task['task_tag'];
                $tag_array = explode(",", $total_tag_per_task); // convert string to array
                $count_tag = count($tag_array);
                if ($total_tag_per_task == "")
                {}
                else
                {
                    for ($x = 1; $x <= $count_tag; $x++)
                    {
                        $y = $x - 1;
                        $final_tag_name = $tag_array[$y];
                        $get_tag_color = mysqli_query($conn, "SELECT * FROM tags WHERE tag_id = '$final_tag_name'");
                        $result_get_tag_color = mysqli_fetch_array($get_tag_color);
                        $tag_name = $result_get_tag_color['tag_name'];
                        echo '<span style="background-color: '.$result_get_tag_color['tag_color'].'; color:#fff; padding:2px 7px 2px 5px; border-top-right-radius: 25px; border-bottom-right-radius: 25px; font-size: 11px; margin: 0px 0px 0px 5px;" data-toggle="popover" title="'.$tag_name.'" data-placement="bottom">';
                        echo $tag_name;
                        echo '</span>';
                    }
                }
            echo '
        </td>
        <td class="d-none d-sm-table-cell" id="taskid_'.$task_id.'" onclick="view_task(this.id)">';
            if($ymd == $today)
            {
                $task_priority = "D Urgent";
                mysqli_query($conn, "UPDATE task SET task_priority='$task_priority' WHERE task_id='$task_id'") or die(mysqli_error());
                echo'<span class="badge badge-danger">Today</span>';
            }
            else if($ymd == $tomorrow)
            {
                $task_priority = "C High";
                mysqli_query($conn, "UPDATE task SET task_priority='$task_priority' WHERE task_id='$task_id'") or die(mysqli_error());
                echo'<span class="badge badge-warning">Tomorrow</span>';
            }
            else if($due_date_time == "" or $due_date_time == '0000-00-00')
            {
                echo'<span class="badge badge-primary">No Due Date yet!!</span>';
            }
            else if($due_date_time < $date_today)
            {
                echo'<span class="badge badge-info">Overdue</span>';
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


        <td class="d-none d-sm-table-cell" id="taskid_'.$task_id.'" onclick="view_task(this.id)">'.$fetch_task['task_date_created'].'</td>
        <td class="d-none d-sm-table-cell" id="taskid_'.$task_id.'" onclick="view_task(this.id)">';
        if($fetch_task['task_priority'] == "D Urgent")
        {
            echo '<span style="display: none;">D</span><span class="badge badge-danger">Urgent</span>';
        }
        else if($fetch_task['task_priority'] == "C High")
        {
            echo '<span style="display: none;">C</span><span class="badge badge-warning">High</span>';
        }
        else if($fetch_task['task_priority'] == "B Normal")
        {
            echo '<span style="display: none;">B</span><span class="badge badge-primary">Normal</span>';
        }
        else if($fetch_task['task_priority'] == "A Low")
        {
            echo '<span style="display: none;">A</span><span class="badge badge-secondary">Low</span>';
        }
        else
        {}
        echo'
        </td>
        <td class="d-none d-sm-table-cell text-center" id="taskid_'.$task_id.'" onclick="view_task(this.id)">';
        $total_assign_to = $fetch_task['task_assign_to']; // get the assign id
        if ($total_assign_to == 0)
        {
            echo 'Unassign';
        }
        else
        {
            $assign_array = explode(",",$total_assign_to); // string to array
            $count_assign = count($assign_array); // count the array
            for($c = 0; $c < $count_assign; $c++)
            {
                $assign_id = $assign_array[$c];
                $select_user = mysqli_query($conn, "SELECT * FROM user WHERE user_id = '$assign_id'");
                $fetch_user = mysqli_fetch_array($select_user);
                $get_first_letter_in_fname = $fetch_user['fname'];
                $get_first_letter_in_lname = $fetch_user['lname'];
                if($fetch_user['profile_pic'] != "")
                {
                    echo '<img type="button" title="'.$fetch_user['fname'].' '.$fetch_user['lname'].'" src="../assets/media/upload/'.$fetch_user['profile_pic'].'" style="width:33px; height:33px; border-radius:50px; margin: 0px -5px 0px -5px; border: 1px solid #fff;">
                        <span style="display: none;">'.$fetch_user['fname'].' '.$fetch_user['lname'].'</span>';
                }
                else
                {
                    echo '<span class="btn btn-circle" type="button" title="'.$fetch_user['fname'].' '.$fetch_user['lname'].'" style="background-color: '.$fetch_user['user_color'].'; margin: 0px -5px 0px -5px; border: 1px solid #fff;">
                        <i class="text-white" style="font-size: 12px;">'.$get_first_letter_in_fname[0].''.$get_first_letter_in_lname[0].'</i>
                        </span>
                        </span><span style="display: none;">'.$fetch_user['fname'].' '.$fetch_user['lname'].'</span>';
                }
            }
        }
        echo'
        </td>
        <td class="d-none d-sm-table-cell text-center" id="taskid_'.$task_id.'" onclick="view_task(this.id)">';
        $list_space_id = $list_name['list_space_id'];
        $select_space = mysqli_query($conn, "SELECT * FROM space WHERE space_id = '$list_space_id'");
        $fetch_space = mysqli_fetch_array($select_space);

        $space_name = $fetch_space['space_name'];
        echo '<input type="hidden" id="spacename'.$task_id.'" value="'.$space_name.'">';

        $new_name = substr($space_name, 0, 15); // get only 10 character
        if(strlen($space_name) > 15)
        {
            echo '<span data-toggle="popover" title="'.$new_name.'" data-placement="bottom" data-content="ID: '.$list_space_id.'">'.$new_name.'...</span>';
        }
        else
        {
            echo '<span data-toggle="popover" title="'.$new_name.'" data-placement="bottom" data-content="ID: '.$list_space_id.'">'.$new_name.'</span>';
        }
        echo'
        </td>
        <td class="d-none d-sm-table-cell text-center" id="taskid_'.$task_id.'" onclick="view_task(this.id)">';

        $list_name = $list_name['list_name'];
        echo '<input type="hidden" id="listname'.$task_id.'" value="'.$list_name.'">';
        echo '<input type="hidden" id="listid'.$task_id.'" value="'.$task_list_id.'">';

        $new__list_name = substr($list_name, 0, 12); // get only 10 character
        if(strlen($list_name) > 12)
        {
            echo '<span data-toggle="popover" title="'.$new__list_name.'" data-placement="bottom" data-content="ID: '.$task_list_id.'">'.$new__list_name.'...</span>';
        }
        else
        {
            echo '<span data-toggle="popover" title="'.$new__list_name.'" data-placement="bottom" data-content="ID: '.$task_list_id.'">'.$new__list_name.'</span>';
        }
        echo'
        </td>';
        $select_status = mysqli_query($conn, "SELECT * FROM status WHERE status_id = '$task_status_id'");
        $fetch_status_name = mysqli_fetch_array($select_status);

        $select_task_list_id = mysqli_query($conn, "SELECT * FROM status WHERE status_list_id = '$task_list_id' ORDER BY status_order_no DESC LIMIT 1");
        $last_status = mysqli_fetch_array($select_task_list_id);
        $last_status_id = $last_status['status_id'];
        if($last_status_id == $fetch_task['task_status_id']) // identify if task is done
        {
            echo '<td class="text-center text-white bg-gd-sea" data-toggle="popover" title="'.$fetch_status_name['status_name'].'" data-placement="bottom" data-content="ID: '.$task_status_id.'" id="taskid_'.$task_id.'" onclick="view_task(this.id)">Finish</td>';
        }
        else
        {
            echo '<td class="text-center text-white" style="background-color: '.$fetch_status_name['status_color'].';" id="taskid_'.$task_id.'" onclick="view_task(this.id)">';
                $new_name = substr($fetch_status_name['status_name'], 0, 23); // get specific character
                if(strlen($fetch_status_name['status_name']) > 23)
                {
                    echo '<span data-toggle="popover" title="'.$fetch_status_name['status_name'].'" data-placement="bottom" data-content="ID: '.$task_status_id.'">'.$new_name.'...</span>';
                }
                else
                {
                    echo '<span data-toggle="popover" title="'.$fetch_status_name['status_name'].'" data-placement="bottom" data-content="ID: '.$task_status_id.'">'.$new_name.'</span>';
                }
                echo '
            </td>';
        }
        echo'
    </tr>
    ';

?>
