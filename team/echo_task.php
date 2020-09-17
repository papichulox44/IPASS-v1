<?php
echo'                                                 
    <!--<span class="parent" id="'.$result_findstatus['task_id'].'" onmouseover="showtaskmenu(this.id)" onmouseout="hidetaskmenu(this.id)">-->
    <span class="parent">
    <li class="scrumboard-item" style="background-color: #fff; box-shadow: 0px 1px 1px 0px rgba(119, 119, 119, 0.27);-moz-box-shadow: 0px 1px 1px 0px rgba(119, 119, 119, 0.27);-webkit-box-shadow: 0px 1px 1px 0px rgba(119, 119, 119, 0.27);" id="entry_'.$result_findstatus['task_id'].'">
        

            <div class="scrumboard-item-content text-muted" id="task_real_name'.$result_findstatus['task_id'].'" style="padding: 0px 0px 5px 0px;">'.$result_findstatus['task_name'].'</div>
            <div class="scrumboard-item-options">
                <!--<a class="scrumboard-item-handler btn btn-sm btn-alt-warning coupon1" id="coupon1'.$result_findstatus['task_id'].'" href="javascript:void(0)" onmouseover="hover_to_grad(this.id)" onmouseout="mouse_out_to_grab(this.id)"><i class="fa fa-hand-grab-o"></i>
                </a>
                <button class="btn btn-sm btn-alt-warning" id="'.$result_findstatus['task_id'].'" onclick="show_task_menu(this.id)" name="'.$result_findstatus['task_id'].'"><i class="fa fa-ellipsis-v"></i>
                </button>-->
            </div>

            <div class="scrumboard-item-content" id="task_rename'.$result_findstatus['task_id'].'" style="display:none;">
                <form method="post">
                    <div class="input-group">
                        <input type="text" class="form-control is-valid" name="txt_rename_task" value="'.$result_findstatus['task_name'].'" id="task_name'.$result_findstatus['task_id'].'" style="border-radius: 10px; height: 23px; margin-bottom: 5px;" required>
                        <input type="hidden" class="" name="txt_task_ids" value="'.$result_findstatus['task_id'].'" style="border-radius: 10px; height: 23px;">
                        <button type="submit" hidden="hidden" class="btn btn-alt-secondary btn-noborder mr-5 mb-5" name="btn_rename_task"><i class="fa fa-plus"></i></button>
                    </div>
                </form>
            </div>

            <span class="fortask" id="taskmodal'.$result_findstatus['task_id'].'" onclick="show_task_modal(this.id)">

            <form method="post">
            <div class="scrumboard-item-content" style="width:230px;">';
// Priority View ************************ 
                if($result_findstatus['task_priority'] == 'D Urgent')
                {
                    echo '<i class="fa fa-flag text-danger mr-10"></i>';
                }
                else if ($result_findstatus['task_priority'] == 'C High')
                {
                    echo '<i class="fa fa-flag text-warning mr-10"></i>';
                }
                else if ($result_findstatus['task_priority'] == 'B Normal')
                {
                    echo '<i class="fa fa-flag text-info mr-10"></i>';
                }
                else if ($result_findstatus['task_priority'] == 'A Low')
                {
                    echo '<i class="fa fa-flag text-gray mr-10"></i>';
                }
                else
                {} 
// Due Date View ************************ 
                if($result_findstatus['task_due_date'] == '0000-00-00 00:00:00')
                {}
                else
                {
                    $due_date_time = $result_findstatus['task_due_date']; // ex: 2020-12-10 00:00:00
                    $ymd = substr($due_date_time, -19, 10); // 2020-12-10 00:00:00 // Y-m-d = 2020-12-10 00
                    $get_month = substr($due_date_time, -14, 2); // 2020-12-10 00:00:00 // get only month = 12
                    $get_date = substr($due_date_time, -11, 2); // 2020-12-10 00:00:00 // get only date = 10
                    $hm = substr($due_date_time, -8, 5); // 2020-12-10 00:00:00 // get only date = 10
                    $am_or_pm = date("A", strtotime($due_date_time));
                    $array_avv = array(array('01' => 'Jan','02' => 'Feb','03' => 'Mar','04' => 'Apr','05' => 'May','06' => 'Jun','07' => 'Jul','08' => 'Aug','09' => 'Sep','10' => 'Oct','11' => 'Nov','12' => 'Dec')); // array with key and value ex. key=01 and value="Jan"...
                    $month = array_column($array_avv, $get_month); // Get the value of specific key ex: key=02 then value="Feb" 
                    $month_avv = implode( "", $month ); // Convert array to string
                    $today = date("Y-m-d"); // Get current date
                    $tomorrow = date('Y-m-d', strtotime(' +1 day')); // Get tomorrow date
                    echo '<span><!-- add class "class="duedateparent" for hover delete -->
                            <input type="hidden" class="form-control is-valid" name="txt_id" value="'.$result_findstatus['task_id'].'">
                            <button class="myButton btn btn-danger btn-noborder" style="left:25px; top: 30px;" name="btn_delete_due_date"><i class="si si-close" style="padding: 0px 0px 0px 0px;top:-1.1px;left:-1px;"></i></button>
                            <span class="text-muted" style="font-size: 12px;">';
                                if($ymd == $today)
                                {
                                    $task_priority = "D Urgent";
                                    mysqli_query($conn, "UPDATE task SET task_priority='$task_priority' WHERE task_id='$task_id'") or die(mysqli_error());
                                    echo'<span class="text-danger">Today '.$hm.' '.$am_or_pm.'</span>';
                                }
                                else if($ymd == $tomorrow)
                                {   
                                    $task_priority = "C High";
                                    mysqli_query($conn, "UPDATE task SET task_priority='$task_priority' WHERE task_id='$task_id'") or die(mysqli_error());
                                    echo'<span class="text-warning">Tomorrow '.$hm.' '.$am_or_pm.'</span>';
                                }
                                else
                                {
                                    echo''.$month_avv.' '.$get_date.'';
                                }
                        echo'</span>
                          </span>';
                }
        
      echo '</div>
            </form>
            <div class="scrumboard-item-content" style="width:230px; padding: 5px 0px 0px 0px;">';
// Assign Member View ************************ 
                    if ($total_assign_to == "") 
                    {}
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
                                echo'<span data-title="'.$result_get_user_profile['fname'].' '.$result_get_user_profile['lname'].'" class="btn btn-sm btn-circle" style="font-size: 11px; margin: 0px -10px 0px 0px;">
                                        <img style="width:28px; height:28px; border-radius:50px; margin: -10px 0px 5px 0px; border: solid #fff 2px;" src="../assets/media/upload/'.$result_get_user_profile['profile_pic'].'">
                                    </span>';
                            }
                            else
                            {
                                echo'<span data-title="'.$result_get_user_profile['fname'].' '.$result_get_user_profile['lname'].'" class="btn btn-sm btn-circle" style="font-size: 11px; margin: -6px -7px 0px 0px; border: solid #fff 2px; color:#fff; background-color: '.$result_get_user_profile['user_color'].'">'.$get_first_letter_in_fname[0].''.$get_first_letter_in_lname[0].'
                                        <button class="myButton btn btn-danger btn-noborder" style="left:0px; top: -8px;"><i class="si si-close" style="padding: 0px 0px 0px 0px;top:-1.1px;left:-1px;"></i></button>
                                    </span>'; 
                            }
                        }   
                    }
// Tag Assign View ************************ 
      echo '</div>
            <div class="scrumboard-item-content" style="width:230px;">';
                    $total_tag_per_task = $result_findstatus['task_tag'];
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

                            echo'<span style="background-color: '.$result_get_tag_color['tag_color'].'; color:#fff; padding:2px 5px 2px 5px; border-radius:50px; font-size: 11px;">'.$result_get_tag_color['tag_name'].' </span>'; 
                        }                                                        
                    }  
        echo '</div>
        </span>';
        echo '
        <div class="row taskmenu coupon2" id="taskmenuid'.$result_findstatus['task_id'].'">
            <div class="block-options">
                <div class="dropdown">   
                    <button class="btn btn-sm btn-alt-warning" data-toggle="dropdown"><i class="fa fa-calendar-check-o"></i></button>
                    <form method="post">
                        <div class="dropdown-menu dropdown-menu-left shadow">
                            <form method="post">
                                <input type="hidden" name="txt_task_id" value="'.$result_findstatus['task_id'].'" style="border-radius: 10px; height: 23px;">
                                <div class="form-material">
                                    <input type="date" class="js-datepicker form-control" id="example-datepicker4" name="txt_due_date" data-week-start="1" data-autoclose="true" data-today-highlight="true" data-date-format="mm/dd/yy" placeholder="mm/dd/yy" required>
                                    <label for="example-datepicker4">Choose a date</label>
                                </div>
                                <div class="form-material">
                                    <select class="form-control" id="material-select" name="txt_due_time">
                                        <option>...</option>
                                        '.get_times().'
                                    </select>
                                    <label for="material-select">Select time</label>
                                </div>
                                <div class="form-material">
                                    <button class="btn btn-sm btn-noborder btn-alt-primary btn-block" name="btn_due_date"><i class="fa fa-calendar-check-o"></i> Save</button>
                                </div>
                            </form>
                        </div>
                    </form>
                </div>
                <div class="dropdown">
                    <button class="btn btn-sm btn-alt-warning" data-toggle="dropdown"><i class="si si-flag"></i></button>
                    <form method="post">
                        <div class="dropdown-menu dropdown-menu-left shadow">
                            <a href="main_dashboard.php?space_name='.$space_name.'&list_name='.$list_name.'&list_id='.$status_list_id.'&task_id='.$result_findstatus['task_id'].'&priority=D Urgent" class="dropdown-item">
                                <i class="si si-flag text-danger mr-10"></i> Urgent
                            </a>
                            <a href="main_dashboard.php?space_name='.$space_name.'&list_name='.$list_name.'&list_id='.$status_list_id.'&task_id='.$result_findstatus['task_id'].'&priority=C High" class="dropdown-item">
                                <i class="si si-flag text-warning mr-10"></i> High
                            </a>
                            <a href="main_dashboard.php?space_name='.$space_name.'&list_name='.$list_name.'&list_id='.$status_list_id.'&task_id='.$result_findstatus['task_id'].'&priority=B Normal" class="dropdown-item">
                                <i class="si si-flag text-info mr-10"></i> Normal
                            </a>
                            <a href="main_dashboard.php?space_name='.$space_name.'&list_name='.$list_name.'&list_id='.$status_list_id.'&task_id='.$result_findstatus['task_id'].'&priority=A Low" class="dropdown-item">
                                <i class="si si-flag text-gray mr-10"></i> Low
                            </a>
                            <a href="main_dashboard.php?space_name='.$space_name.'&list_name='.$list_name.'&list_id='.$status_list_id.'&task_id='.$result_findstatus['task_id'].'&priority=" class="dropdown-item">
                                <i class="fa fa-times text-danger mr-10"></i> Clear
                            </a>
                        </div>
                    </form>
                </div>
                <div class="dropdown">
                    <button class="btn btn-sm btn-alt-warning" data-toggle="dropdown"><i class="si si-tag"></i></button>
                    <div class="dropdown-menu dropdown-menu-left shadow">';

                    echo'<label class="text-muted">Assigned Tag:&nbsp;</label>';
                        $total_tag = $result_findstatus['task_tag']; //get the user_id ex. string = "1,2,3,4,5"
                        $tag_array = explode(",", $total_tag); // eleminate the ","/ comma sign and insert to array ex. [1,2,3,4,5]
                        $count_tag =  count($tag_array);
                        if ($total_tag == "") 
                        {
                            echo'<label class="text-muted">None</label>';
                        }
                        else
                        {
                            for ($x = 1; $x <= $count_tag; $x++)
                            {
                                $y = $x - 1;
                                $final_tag_name = $tag_array[$y];
                                $que_find_tag = mysqli_query($conn, "SELECT * FROM tags WHERE tag_id = '$final_tag_name'");
                                while($res_que_find_tag = mysqli_fetch_array($que_find_tag))
                                {
                                echo'<form method="post" class="dropdown-item">
                                        <input type="hidden" class="" name="txt_tag_name" value="'.$res_que_find_tag['tag_id'].'" style="border-radius: 10px; height: 23px;"><input type="hidden" class="" name="txt_task_id" value="'.$result_findstatus['task_id'].'" style="border-radius: 10px; height: 23px;">';
                                        echo'<button type="submit" class="btn btn-sm btn-circle btn-danger btn-noborder mr-5" name="btn_remove_tag"><i class="fa fa-times"></i></button>';
                                        echo'<span style="background-color: '.$res_que_find_tag['tag_color'].'; color:#fff; border-radius: 50px; padding: 5px 10px 5px 10px;">'.$res_que_find_tag['tag_name'].'</span>
                                    </form>';
                                }
                            }
                        }     
                    echo'
                        <div class="dropdown-divider"></div>
                        <form method="post">
                            <div class="input-group">
                                <input type="text" class="form-control is-valid text-muted" name="txt_add_tag" placeholder="Add tag..." style="border-radius: 10px; height: 23px; margin-bottom:15px;" required>
                                <button type="submit" hidden="hidden" class="btn btn-alt-secondary btn-noborder mr-5 mb-5" name="btn_add_tag"><i class="fa fa-plus"></i></button>
                            </div>
                        </form>';
                    echo'<label class="text-muted">Available tag:&nbsp;</label>';
                        $search_tag = mysqli_query($conn, "SELECT * FROM tags WHERE tag_list_id = '$status_list_id' ORDER BY tag_name ASC");
                        while($find_tag = mysqli_fetch_array($search_tag))
                        {
                            echo'
                            <a href="main_dashboard.php?space_name='.$space_name.'&list_name='.$list_name.'&list_id='.$status_list_id.'&task_id='.$result_findstatus['task_id'].'&tag='.$find_tag['tag_id'].'" class="dropdown-item" style="background-color: '.$find_tag['tag_color'].'; color:#fff; border-radius: 50px;">'.$find_tag['tag_name'].'
                            </a>'; 
                        }                                                           
                            echo'
                    </div>
                </div>
                <div class="dropdown">
                    <button class="btn btn-sm btn-alt-warning"  data-toggle="dropdown"><i class="fa fa-user-plus"></i></button>
                    <div class="dropdown-menu dropdown-menu-left shadow">';
                        echo'<label class="text-muted">Assigned member:&nbsp;</label>';
                        if ($total_assign_to == "") 
                        {
                            echo'<label class="text-muted">None</label>';
                        }
                        else
                        {
                            for ($x = 1; $x <= $count_assign_to; $x++)
                            {
                                $y = $x - 1; // tricks to get every user_id
                                $final_assign_to_name = $assign_to_array[$y];
                                $get_user_profile = mysqli_query($conn, "SELECT * FROM user WHERE user_id = '$final_assign_to_name'");
                                while($find_search_member = mysqli_fetch_array($get_user_profile))
                                {
                                    $get_first_letter_in_fname = $find_search_member['fname'];                                                                
                                    $get_first_letter_in_lname = $find_search_member['lname'];
                                    echo'<form method="post" class="dropdown-item">
                                            <input type="hidden" name="txt_assign_user_id" value="'.$find_search_member['user_id'].'">
                                            <input type="hidden" name="txt_task_id" value="'.$result_findstatus['task_id'].'">';

                                    if($find_search_member['profile_pic'] != "")
                                        echo'<button type="submit" class="btn btn-sm btn-circle btn-danger btn-noborder mr-5" name="btn_remove_member"><i class="fa fa-times"></i></button><img style="width:28px; border-radius:50px; margin: 0px 10px 0px 0px;" src="../assets/media/upload/'.$find_search_member['profile_pic'].'">';
                                    else
                                        echo'<button type="submit" class="btn btn-sm btn-circle btn-danger btn-noborder mr-5" name="btn_remove_member"><i class="fa fa-times"></i></button><span class="btn btn-sm btn-circle" style="font-size: 11px; width:25px; border-radius:50px; margin: 0px 10px 0px 0px; padding: 8px 0px 0px 0px; color:#fff; background-color: '.$find_search_member['user_color'].'">'.$get_first_letter_in_fname[0].''.$get_first_letter_in_lname[0].'</span>'; 
                                        echo''.$find_search_member['fname'].' '.$find_search_member['mname'].' '.$find_search_member['lname'].'
                                    </form>'; 
                                }
                            }
                        }
                        echo'<div class="dropdown-divider"></div><label class="text-muted">Available member:</label>';
                        $search_member = mysqli_query($conn, "SELECT * FROM user ORDER BY fname ASC");
                        while($find_search_member = mysqli_fetch_array($search_member))
                        {
                            $get_first_letter_in_fname = $find_search_member['fname'];                                                               
                            $get_first_letter_in_lname = $find_search_member['lname'];
                            echo'
                            <a href="main_dashboard.php?space_name='.$space_name.'&list_name='.$list_name.'&list_id='.$status_list_id.'&task_id='.$result_findstatus['task_id'].'&assign='.$find_search_member['user_id'].'" class="dropdown-item" style="border-radius: 50px;">';

                            if($find_search_member['profile_pic'] != "")
                                echo'<img style="width:28px; border-radius:50px; margin: 0px 10px 0px 0px;" src="../assets/media/upload/'.$find_search_member['profile_pic'].'">';
                            else
                                //echo'<img style="width:25px; border-radius:50px; margin: 0px 10px 0px 0px;" src="../assets/media/upload/avatar.jpg">';

                                echo'<span class="btn btn-sm btn-circle" style="font-size: 11px; width:25px; border-radius:50px; margin: 0px 10px 0px 0px; padding: 8px 0px 0px 0px; color:#fff; background-color: '.$find_search_member['user_color'].'">'.$get_first_letter_in_fname[0].''.$get_first_letter_in_lname[0].'</span>'; 
                                echo''.$find_search_member['fname'].' '.$find_search_member['mname'].' '.$find_search_member['lname'].'
                            </a>'; 
                        }                                                           
                            echo'
                    </div>
                </div>                                                  
                <input type="hidden" name="txt_task_id" value="'.$result_findstatus['task_id'].'">
                <button type="button" class="btn btn-sm btn-alt-warning" id="'.$result_findstatus['task_id'].'" onclick="show_rename_task(this.id)"><i class="si si-pencil"></i></button>
                <a href="main_dashboard.php?space_name='.$space_name.'&list_name='.$list_name.'&list_id='.$status_list_id.'&task_id='.$result_findstatus['task_id'].'&delete_task=delete_task">
                <button class="btn btn-sm btn-alt-warning"><i class="fa fa-trash"></i></button></a>
            </div>
        </div>
    </li>
    </span>
        ';
?>