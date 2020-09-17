<?php
    $md_primary_darker = "";
    $md_text = "text-muted";
    $md_body = "";
    $stat = "bg-body-light";
    if($mode_type == "Dark") //insert
    { 
        $md_primary_darker = "bg-primary-darker";
        $md_text = "text-white";
        $md_body = "bg-gray-darker text-body-color-light";
        $stat = "bg-primary-darker";
    }

    /*$filter_status = mysqli_query($conn, "SELECT * FROM filter WHERE filter_space_id='$space_id' AND filter_user_id='$user_id'");
    $fetch_filter_status = mysqli_fetch_array($filter_status);
    $filter_status_name = $fetch_filter_status['filter_name'];
    $filter_status_id = $fetch_filter_status['filter_value'];*/

    $filter_status = mysqli_query($conn, "SELECT * FROM filter WHERE filter_space_id = '$space_id' AND filter_user_id = '$user_id' AND filter_name = 'status'");
?>

<style type="text/css">
    li:hover .aaa 
    {
        color: #575757;
        cursor: pointer;
    }
    .bbb
    {
        margin-left: -40px;
        padding: 10px;
    }
    .scroll
    {
        height: 280px;
        overflow: hidden;
    }
    .scroll:hover
    {
        overflow: scroll;
        overflow-x: hidden;
    }

#style-5::-webkit-scrollbar-track
{
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
    background-color: #F5F5F5;
}

#style-5::-webkit-scrollbar
{
    width: 6px;
    background-color: #F5F5F5;
}
#style-5::-webkit-scrollbar-thumb
{
    background-color: #abadaf;
}
</style>
<div class="row" style="margin-top: 25px;">    
    <div class="col-md-6 col-xl-3" >
        <div class="block block-themed <?php echo $md_body; ?>" style="box-shadow: 0px 1px 3px 0px rgba(119, 119, 119, 0.34);-moz-box-shadow: 0px 1px 3px 0px rgba(119, 119, 119, 0.34);-webkit-box-shadow: 0px 1px 3px 0px rgba(119, 119, 119, 0.34);">
            <div class="block-header bg-gd-aqua">
                <h3 class="block-title">Unassign</h3>
                    <div class="block-options">
                        <!--<button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                            <i class="si si-refresh"></i>
                        </button>-->
                        <button type="button" class="btn-block-option" data-toggle="block-option" data-action="content_toggle"></button>
                    </div>
            </div>
            <div class="block-content">
                <div class="form-group row">
                    <?php
                        $findtask_unassign = mysqli_query($conn, "SELECT * FROM task WHERE task_list_id = '$status_list_id' AND task_assign_to = ''");
                        $unassign_all = mysqli_num_rows($findtask_unassign);

                        $findtask_last_status = mysqli_query($conn, "SELECT * FROM status WHERE status_list_id = '$status_list_id' ORDER BY status_order_no DESC LIMIT 1");
                        $fetch_last = mysqli_fetch_array($findtask_last_status);
                        $last_status_id = $fetch_last['status_id'];

                        $findtask_task = mysqli_query($conn, "SELECT * FROM task WHERE task_status_id = '$last_status_id' AND task_assign_to = ''");
                        $unassign_done = mysqli_num_rows($findtask_task);
                        $unassign_undone = $unassign_all - $unassign_done;
                                        
                        if($unassign_all == 0)
                        {
                            $percentage = 0;
                        }
                        else
                        {
                            $total = $unassign_done / $unassign_all * 100;
                            $percentage = number_format($total)."";
                        }
                    ?>

                    <div class="block-content block-content-full <?php echo $stat; ?>" style="margin: -10px 0px 10px 0px; padding: 10px;">
                        <div class="row">
                            <div class="text-center" style="width: 33.33333333333333%;">
                                <div class="font-w600 text-center mt-5"><span><?php echo $unassign_undone; ?></span></div>
                                <div class="font-size-sm text-muted text-center">Undone</div>
                            </div> 
                            <div class="text-center" style="width: 33.33333333333333%;">
                                <div class="font-w600 text-center mt-5"><span><?php echo $unassign_done; ?></span></div>
                                <div class="font-size-sm text-muted text-center">Done</div>
                            </div>
                            <div class="text-center" style="width: 33.33333333333333%;border: 5px; border-color: black;">
                                <div class="js-pie-chart pie-chart" data-percent="<?php echo $percentage; ?>" data-line-width="4" data-size="50" data-bar-color="#42a5f5" data-track-color="#e9e9e9">
                                    <span><?php echo $percentage; ?>%</span>
                                </div>
                            </div> 
                        </div>
                    </div>

                    <div class="content-side content-side-full" style="margin-top: -30px;">
                        <div class="row" id="unassign_line_indicator">
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="content-side content-side-full scroll" id="style-5">
                        <ul class="nav-main" style="margin-top: -20px;">
                            <?php                        
                                //_______________________________ FILTER STATUS Query at the top
                                if(mysqli_num_rows($filter_status) != 0)
                                {
                                    $filter_status_id_array = 'status_id = '.implode(" OR status_id = ", $status_array).'';
                                    $findstatus = mysqli_query($conn, "SELECT * FROM status WHERE status_list_id = '$status_list_id' AND $filter_status_id_array");
                                }
                                else
                                {
                                    $findstatus = mysqli_query($conn, "SELECT * FROM status WHERE status_list_id = '$status_list_id' ORDER BY status_order_no ASC");
                                }
                                //_______________________________ END FILTER STATUS Query at the top
                                while($result_findstatus = mysqli_fetch_array($findstatus))
                                {   
                                    $status_idss = $result_findstatus['status_id'];
                                    $findtaskper_status = mysqli_query($conn, "SELECT * FROM task WHERE task_status_id = '$status_idss' AND task_assign_to = '' ORDER BY task_name ASC");
                                    $totalcount = mysqli_num_rows($findtaskper_status);
                                    echo '
                                        <li>
                                            <a class="dropdown-item nav-submenu" data-toggle="nav-submenu" style="padding: 5px 0px;">
                                                <i class="fa fa-square" style="color: '.$result_findstatus['status_color'].';"></i>';
                                                $new_name = substr($result_findstatus['status_name'], 0, 20); // get specific character
                                                if(strlen($result_findstatus['status_name']) > 20)
                                                {
                                                    echo '
                                                        <span class="sidebar-mini-hide aaa" style="margin-left: 40px;" data-toggle="popover" title="'.$result_findstatus['status_name'].'" data-placement="bottom">'.$new_name.'...</span>';
                                                }
                                                else
                                                {
                                                    echo '
                                                        <span class="sidebar-mini-hide aaa" style="margin-left: 40px;">'.$result_findstatus['status_name'].'</span>';
                                                }
                                                echo '</span>
                                                <span class="badge" style="background-color: #64b1a0; color: #fff;" id="unassign_status_id'.$result_findstatus['status_id'].'">'.number_format($totalcount).'</span>
                                            </a>
                                            <ul style="border-left: 3px solid '.$result_findstatus['status_color'].';">';
                                                while($result_findtaskper_status = mysqli_fetch_array($findtaskper_status))
                                                    {
                                                        echo '<li class="aaa bbb" id="taskmodal'.$result_findtaskper_status['task_id'].'" onclick="show_task_modal(this.id)">'.$result_findtaskper_status['task_name'].'</li>';
                                                    }                                                    
                                                echo'                                                
                                            </ul>
                                        </li>';                                  
                                }
                            ?>
 
                        </ul>
                    </div>
                    <!-- End Status -->
                </div>
            </div>
        </div>
    </div>      
    <?php    
    // Objective: Fetch USER order by fname ASC 
        $find_list_id = mysqli_query($conn,"SELECT list_assign_id FROM list WHERE list_id='$status_list_id'");
        $result_find_list_id = mysqli_fetch_array($find_list_id);
        $assign = $result_find_list_id['list_assign_id']; 
        $count = explode(",", $assign); // convert string to array
        $total = count($count);
        if($assign == "")
        {
            $BBB = array();  
            $status_color_array = array();
            $findstatus = mysqli_query($conn, "SELECT * FROM status WHERE status_list_id = '$status_list_id' ORDER BY status_order_no ASC");
            while($result_findstatus = mysqli_fetch_array($findstatus))
            {  
                $status_name = $result_findstatus['status_name'];
                $que = mysqli_query($conn, "SELECT * FROM status WHERE status_name='$status_name' AND status_list_id='$status_list_id'");                
                $res = mysqli_fetch_array($que);

                $id_stat = $res['status_id']; //get the user_id ex. string = "1,2,3,4,5"
                array_push($BBB,$id_stat);
                $color_array = $res['status_color']; //get color "#AD0000,#AD0046,#0088AD,#00ADA9,#00ADA9,#AD0000"
                array_push($status_color_array,$color_array);
            }
            $status_idBOX = implode( ",", $BBB ); // Convert array to string
            $status_color_arrays = implode( ",", $status_color_array ); // Convert array to string
        }
        else
        {
            $current_array = explode(",", $assign); // convert string to array
            $count = count($current_array);

            $new_array = [];
            for ($x = 0; $x < $count; $x++)
            {
                $member_id = $current_array[$x];
                $find_member = mysqli_query($conn,"SELECT * FROM user WHERE user_id='$member_id'");
                $result_find_member = mysqli_fetch_array($find_member);
                $fname = $result_find_member['fname'];

                array_push($new_array,$fname); // insert the new user id to $new_array | ex. "1" then new array ==  [1,2,3,4,5,1]
            }
            sort($new_array); // sort the $new_array to asc
            //echo $name = implode( "", $new_array ); // Convert array to string


            $nn = 1;
            for ($y = 0; $y < $count; $y++)
            {
                $mm = $nn++;
                $first_name = $new_array[$y];
                $find_member = mysqli_query($conn,"SELECT * FROM user WHERE fname='$first_name'");
                $result_find_member = mysqli_fetch_array($find_member);
                $user_id = $result_find_member['user_id'];  
                $get_first_letter_in_fname = $result_find_member['fname'];     
                $get_first_letter_in_lname = $result_find_member['lname'];


                echo'<div class="col-md-6 col-xl-3">
                        <div class="block block-themed '.$md_body.'" style="box-shadow: 0px 1px 3px 0px rgba(119, 119, 119, 0.34);-moz-box-shadow: 0px 1px 3px 0px rgba(119, 119, 119, 0.34);-webkit-box-shadow: 0px 1px 3px 0px rgba(119, 119, 119, 0.34);">
                            <div class="block-header" style="background-color: #fff;border-bottom: 1px solid '.$result_find_member['user_color'].';">';
                                if($result_find_member['profile_pic'] != "")
                                {echo'<img style="width: 28px; height: 28px; border-radius:50px;" src="../assets/media/upload/'.$result_find_member['profile_pic'].'">';}
                                else
                                {echo '<span class="btn btn-sm btn-circle" style="color:#fff; font-size: 11px; padding-top: 8px; background-color: '.$result_find_member['user_color'].'">'.$get_first_letter_in_fname[0].''.$get_first_letter_in_lname[0].'</span>';}
                            echo'
                                <h3 class="block-title text-muted ml-5">';
                                    $fullname = $result_find_member['fname'].' '.$result_find_member['mname'].' '.$result_find_member['lname'];
                                    $new_name = substr($fullname, 0, 20); // get specific character
                                    if(strlen($fullname) > 20)
                                    {
                                        echo '
                                        <strong style="color: '.$result_find_member['user_color'].';" data-toggle="popover" title="'.$fullname.'" data-placement="bottom">
                                            '.$new_name.'...
                                        </strong>';
                                    }
                                    else
                                    {
                                        echo '
                                        <strong style="color: '.$result_find_member['user_color'].';">
                                            '.$fullname.'
                                        </strong>';
                                    }
                                    echo '
                                </h3>
                                    <div class="block-options">
                                        <!--<button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                                            <i class="si si-refresh"></i>
                                        </button>-->
                                        <button type="button" class="btn-block-option text-muted" data-toggle="block-option" data-action="content_toggle"></button>
                                    </div>
                            </div>

                            <div class="block-content" style="border-bottom: 2px solid '.$result_find_member['user_color'].';">
                                <div class="form-group row">              
                                    <div class="block-content block-content-full '.$stat.'" style="margin: -10px 0px 10px 0px; padding: 10px;">
                                        <div class="row">                                            
                                            <div class="text-center" style="width: 33.33333333333333%;">
                                                <div class="font-w600 text-center mt-5" id="assign_undone'.$mm.'"></div>
                                                <div class="font-size-sm text-muted">Undone</div>
                                            </div>                                            
                                            <div class="text-center" style="width: 33.33333333333333%;">
                                                <div class="font-w600 text-center mt-5" id="assign_done'.$mm.'"></div>
                                                <div class="font-size-sm text-muted">Done</div>
                                            </div> 
                                            <div class="text-center" style="width: 33.33333333333333%;border: 5px; border-color: black;">';
                                                $all_task_per_user = 0;
                                                $find_all_task_per_list = mysqli_query($conn, "SELECT * FROM task WHERE task_list_id = '$status_list_id'");
                                                while($reult_all_task = mysqli_fetch_array($find_all_task_per_list))
                                                {
                                                    $assign = $reult_all_task['task_assign_to']; //get the user_id ex. string = "1,2,3,4,5"
                                                    $assign_to_array = explode(",", $assign); // eleminate the ","/ comma sign and insert to array ex. [1,2,3,4,5]
                                                    if (in_array($user_id, $assign_to_array)) // echo if has user_id in db table "task": task_assign_to
                                                    {
                                                        $all_task_per_user ++;
                                                    }
                                                    else{}
                                                }
                                                $done_task_per_user = 0;
                                                $find_user_in_last_status = mysqli_query($conn, "SELECT * FROM task WHERE task_status_id = '$last_status_id'");
                                                while($reult_last_status = mysqli_fetch_array($find_user_in_last_status))
                                                {
                                                    $last = $reult_last_status['task_assign_to']; //get the user_id ex. string = "1,2,3,4,5"
                                                    $last_to_array = explode(",", $last); // eleminate the ","/ comma sign and insert to array ex. [1,2,3,4,5]
                                                    if (in_array($user_id, $last_to_array)) // echo if has user_id in db table "task": task_assign_to
                                                    {
                                                        $done_task_per_user ++;
                                                    }
                                                    else{}
                                                }
                                                if($done_task_per_user == 0 && $all_task_per_user == 0)
                                                {
                                                    $addition = 0;
                                                }
                                                else
                                                {
                                                    $addition = $done_task_per_user / $all_task_per_user * 100;
                                                }
                                                $percentage_in_assign = number_format($addition)."";
                                                echo'
                                                <div class="js-pie-chart pie-chart" data-percent="'.$percentage_in_assign.'" data-line-width="4" data-size="50" data-bar-color="'.$result_find_member['user_color'].'" data-track-color="#e9e9e9">
                                                    <span>'.$percentage_in_assign.'%</span>
                                                </div>
                                            </div> 
                                        </div>
                                    </div>

                                    <div class="content-side content-side-full" style="margin-top: -30px;">
                                        <div class="row" id="assign_line_indicator'.$mm.'">
                                        </div>
                                    </div>

                                    <div class="content-side content-side-full scroll" id="style-5">
                                        <ul class="nav-main" style="margin-top: -20px;">';
                                                              
                                            $BBB = array();  
                                            $status_color_array = array();
                                            $task_num = 0;

                                            //_______________________________ FILTER STATUS Query at the top
                                            if(mysqli_num_rows($filter_status) != 0)
                                            {
                                                $filter_status_id_array = 'status_id = '.implode(" OR status_id = ", $status_array).'';
                                                $findstatus = mysqli_query($conn, "SELECT * FROM status WHERE status_list_id = '$status_list_id' AND $filter_status_id_array");
                                            }
                                            else
                                            {
                                                $findstatus = mysqli_query($conn, "SELECT * FROM status WHERE status_list_id = '$status_list_id' ORDER BY status_order_no ASC");
                                            }
                                            //_______________________________ END FILTER STATUS Query at the top
                                            while($result_findstatus = mysqli_fetch_array($findstatus))
                                            {    
                                                $ddd = 0;
                                                $id_stat = $result_findstatus['status_id'];
                                                $findtaskper_status = mysqli_query($conn, "SELECT * FROM task WHERE task_status_id = '$id_stat' ORDER BY task_name ASC");
                                                
                                                $status_name = $result_findstatus['status_name'];
                                                $que = mysqli_query($conn, "SELECT * FROM status WHERE status_name='$status_name' AND status_list_id='$status_list_id'");                
                                                $res = mysqli_fetch_array($que);  

                                                $id_stat = $res['status_id']; //get the user_id ex. string = "1,2,3,4,5"
                                                array_push($BBB,$id_stat);
                                                $color_array = $res['status_color']; //get color "#AD0000,#AD0046,#0088AD,#00ADA9,#00ADA9,#AD0000"
                                                array_push($status_color_array,$color_array);

                                                echo '
                                                    <li>
                                                        <a class="dropdown-item nav-submenu" data-toggle="nav-submenu" style="padding: 5px 0px;">
                                                            <i class="fa fa-square" style="color: '.$result_findstatus['status_color'].';"></i>';
                                                $new_name = substr($result_findstatus['status_name'], 0, 20); // get specific character
                                                if(strlen($result_findstatus['status_name']) > 20)
                                                {
                                                    echo '
                                                        <span class="sidebar-mini-hide aaa" style="margin-left: 40px;" data-toggle="popover" title="'.$result_findstatus['status_name'].'" data-placement="bottom">'.$new_name.'...</span>';
                                                }
                                                else
                                                {
                                                    echo '
                                                        <span class="sidebar-mini-hide aaa" style="margin-left: 40px;">'.$result_findstatus['status_name'].'</span>';
                                                }
                                                echo '</span>
                                                            (<span id="countspanbox'.$mm.''.$id_stat.'"></span>)
                                                        </a>
                                                        <ul style="border-left: 3px solid '.$result_findstatus['status_color'].';">';
                                                            while($result_findtaskper_status = mysqli_fetch_array($findtaskper_status))
                                                                {
                                                                    $assign = $result_findtaskper_status['task_assign_to']; //get the user_id ex. string = "1,2,3,4,5"
                                                                    $assign_to_array = explode(",", $assign); // eleminate the ","/ comma sign and insert to array ex. [1,2,3,4,5]
                                                                    if (in_array($user_id, $assign_to_array)) // echo if has user_id in db table "task": task_assign_to
                                                                    {
                                                                        $ddd ++;
                                                                        $task_num++;
                                                                        echo '<li class="aaa bbb" id="taskmodal'.$result_findtaskper_status['task_id'].'" onclick="show_task_modal(this.id)">'.$result_findtaskper_status['task_name'].'</li>';
                                                                    }
                                                                    else
                                                                    {}
                                                                }                                                    
                                                            echo'                                              
                                                        </ul>
                                                    </li>'; 
                                                    echo'<input type="hidden" id="countbox'.$mm.''.$id_stat.'" value="'.$ddd.'">';                                 
                                                }
                                                echo'<input type="hidden" id="all_task_per_assign'.$mm.'" value="'.$task_num.'">'; 
                                                echo'                 
                                        </ul>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>';
            }
        $status_idBOX = implode( ",", $BBB ); // Convert array to string
        $status_color_arrays = implode( ",", $status_color_array ); // Convert array to string
        }
    ?>                    
</div>
<input type="hidden" id="total" value="<?php echo $total; ?>">
<input type="hidden" id="box_status_id" value="<?php echo $status_idBOX; ?>">
<input type="hidden" id="status_color_arrays" value="<?php echo $status_color_arrays; ?>">    
<script type="text/javascript">
    // _____________________ Unassign line indicator
    var status_color_arrays = document.getElementById("status_color_arrays").value; // ex: "#AD0000,#AD0046,#0088AD,#00ADA9,#00ADA9,#AD0000";
    var color_array = status_color_arrays.split(","); // convert string to array

    var box_status_id1 = document.getElementById("box_status_id").value; // ex: "197,198,199,200,201,238";
    var boxstrArray1 = box_status_id1.split(","); // convert string to array
    var array_count = boxstrArray1.length; // count the element of array

    var all_task = <?php echo $unassign_all;?>;
    container = document.getElementById('unassign_line_indicator');
    for (var b = 0; b < array_count; b++)
    {
        var element = boxstrArray1[b]; // get the id of status
        var unassign_status_total = document.getElementById("unassign_status_id" + element).innerHTML;
        var unassign_percentage_per_status = unassign_status_total / all_task * 100; // Use to get the percentage to set for the width
        var color = color_array[b];
        container.innerHTML += '<div style="height: 5px; margin-top: 10px; width: '+ unassign_percentage_per_status + '%;">' + 
        '<div style="border-bottom: 4px solid ' + color +';"></div></div>';
    }
    if(unassign_status_total == 0 && all_task == 0)
    {
        container.innerHTML += '<div style="height: 5px; margin-top: 10px; width: 100%;">' + 
        '<div style="border-bottom: 4px solid #e9e9e9;"></div></div>';
    }

    // _____________________ End Unassign line indicator

    // _____________________ Assign line indicator
    var total_assign = document.getElementById("total").value;
    for(var i = 0; i < total_assign; i++)
    {
        var m = i + 1;
        assign_line_indicator = document.getElementById('assign_line_indicator' + m);
        var all_task_per_assign = document.getElementById("all_task_per_assign" + m).value;
        //var unassign_status_total = document.getElementById("unassign_status_id" + element).innerHTML;
        for (var c = 0; c < array_count; c++)
        {
            var element = boxstrArray1[c]; // get the id of status
            var total_per_task = document.getElementById("countbox" + m + element).value;
            var unassign_percentage_per_status = total_per_task / all_task_per_assign * 100; // Use to get the percentage to set for the width
            var color = color_array[c];
            assign_line_indicator.innerHTML += '<div style="height: 5px; margin-top: 10px; width: '+ unassign_percentage_per_status + '%;">' + 
            '<div style="border-bottom: 4px solid ' + color +';"></div></div>';
        }
        //alert(all_task_per_assign);
    }
    if(total_per_task == 0 && all_task_per_assign == 0)
    {
        assign_line_indicator.innerHTML += '<div style="height: 5px; margin-top: 10px; width: 100%;">' + 
        '<div style="border-bottom: 4px solid #e9e9e9;"></div></div>';
    }
    // _____________________ End Assign line indicator
</script>
<script type="text/javascript">
    // _____________________ Count task per member per status and count done & undone
    var box_status_id = document.getElementById("box_status_id").value; // ex: "197,198,199,200,201,238";
    var boxstrArray = box_status_id.split(",");
    var count_array = boxstrArray.length;
    var last = count_array - 1;
    var last_status_id = boxstrArray[last];

    var total = document.getElementById("total").value; 
    for(var i = 0; i < total; i++)
    {
        var m = i + 1;
        var all = document.getElementById("all_task_per_assign" + m).value;
        var done = document.getElementById("countbox" + m + last_status_id).value;
        var undone = all - done;
        document.getElementById("assign_done" + m).innerHTML = done;
        document.getElementById("assign_undone" + m).innerHTML = undone;
        var element = boxstrArray[i]; // get the id of status
        for(var e = 0; e < count_array; e++)
        {
            var element = boxstrArray[e]; // get the id of status
            document.getElementById("countspanbox" + m + element).innerHTML = document.getElementById("countbox" + m + element).value;
        }
    }
    // _____________________ End Count task per member per status and count done & undone
</script>