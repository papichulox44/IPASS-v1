<?php                          
    include_once '../conn.php';
    $md_primary_darker = "";
    $md_text = "text-muted";
    $md_body = "";
    $md_bg = "background-color: #eee;";
    if($mode_type == "Dark") //insert
    { 
        $md_primary_darker = "bg-primary-darker";
        $md_text = "text-white";
        $md_body = "bg-gray-darker text-body-color-light";
        $md_bg = "background-color: #343a40;";
    }

    $arrX = array("#f5b1b1","#f8bdf9","#ccb8fb","#b4c8f5","#a3d1d6","#a5d8bc","#b5e094","#e8d17b","#f5ba87","#c7a5a5");
    $randIndex = array_rand($arrX);
    $tagcolor = $arrX[$randIndex];
    $user_id = $row['user_id'];

    if(isset($_POST['btn_add_task']))
    {
        $task_name = $_POST['task_name']; 
        $status_id = $_POST['status_id']; 
        mysqli_query($conn,"INSERT into `task` (task_name, task_status_id, task_list_id, task_created_by, task_date_created) values ('$task_name','$status_id','$status_list_id','$user_id', NOW())") or die(mysqli_error());
        echo "<script>document.location='main_dashboard.php?space_name=$space_name&list_name=$list_name&list_id=$status_list_id'</script>";         
    } 
    if(isset($_POST['btn_rename_status']))
    {
        $status_name = $_POST['status_name']; 
        $status_id = $_POST['status_ids']; 
        mysqli_query($conn, "UPDATE status SET status_name='$status_name' WHERE status_id='$status_id'") or die(mysqli_error());
        echo "<script>document.location='main_dashboard.php?space_name=$space_name&list_name=$list_name&list_id=$status_list_id'</script>";
    }
    if(isset($_POST['btn_delete_status']))
    {
        $txt_delete_status_id = $_POST['txt_delete_status_id']; 
        $txt_total_task = $_POST['txt_total_task']; 
        if($txt_total_task == 0)
        {
            mysqli_query($conn, "DELETE FROM status WHERE status_id='$txt_delete_status_id'") or die(mysqli_error());
            echo "<script>document.location='main_dashboard.php?space_name=$space_name&list_name=$list_name&list_id=$status_list_id'</script>";
        }
        else
        {
            echo "<script type='text/javascript'>alert('Note: Cannot delete status with task, make sure to delete all task of the particular status.');</script>";
        }
    }

    if(isset($_GET['priority']) == 'D Urgent')
    {
        $task_priority = $_GET['priority'];
        $task_id = $_GET['task_id'];        
        mysqli_query($conn, "UPDATE task SET task_priority='$task_priority' WHERE task_id='$task_id'") or die(mysqli_error());
        echo "<script>document.location='main_dashboard.php?space_name=$space_name&list_name=$list_name&list_id=$status_list_id'</script>";
    }
    if(isset($_GET['priority']) == 'C High')
    {
        $task_priority = $_GET['priority'];
        $task_id = $_GET['task_id'];        
        mysqli_query($conn, "UPDATE task SET task_priority='$task_priority' WHERE task_id='$task_id'") or die(mysqli_error());
        echo "<script>document.location='main_dashboard.php?space_name=$space_name&list_name=$list_name&list_id=$status_list_id'</script>";
    }
    if(isset($_GET['priority']) == 'B Normal')
    {
        $task_priority = $_GET['priority'];
        $task_id = $_GET['task_id'];        
        mysqli_query($conn, "UPDATE task SET task_priority='$task_priority' WHERE task_id='$task_id'") or die(mysqli_error());
        echo "<script>document.location='main_dashboard.php?space_name=$space_name&list_name=$list_name&list_id=$status_list_id'</script>";
    }
    if(isset($_GET['priority']) == 'A Low')
    {
        $task_priority = $_GET['priority'];
        $task_id = $_GET['task_id'];        
        mysqli_query($conn, "UPDATE task SET task_priority='$task_priority' WHERE task_id='$task_id'") or die(mysqli_error());
        echo "<script>document.location='main_dashboard.php?space_name=$space_name&list_name=$list_name&list_id=$status_list_id'</script>";
    }
    if(isset($_GET['priority']) == 'Clear')
    {
        $task_priority = $_GET['priority'];
        $task_id = $_GET['task_id'];        
        mysqli_query($conn, "UPDATE task SET task_priority='$task_priority' WHERE task_id='$task_id'") or die(mysqli_error());
        echo "<script>document.location='main_dashboard.php?space_name=$space_name&list_name=$list_name&list_id=$status_list_id'</script>";
    }

    function get_times( $default = '19:00', $interval = '+30 minutes' )
    {
        $output = '';
        $current = strtotime( '00:00' );
        $end = strtotime( '23:59' );

        while( $current <= $end ) {
            $time = date( 'H:i', $current );
            $sel = ( $time == $default ) ? '' : '';
            //$sel = ( $time == $default ) ? ' selected' : '';   // 7:00 pm         

            $output .= "<option value=\"{$time}\"{$sel}>" . date( 'h.i A', $current ) .'</option>';
            $current = strtotime( $interval, $current );
        }
        return $output;
    }
    if(isset($_POST['btn_delete_due_date']))
    {  
        $txt_id = $_POST['txt_id'];
        $due_date_and_time = "0000-00-00 00:00:00";
        //echo "<script type='text/javascript'>alert('$txt_id');</script>";
        mysqli_query($conn, "UPDATE task SET task_due_date = '$due_date_and_time' WHERE task_id='$txt_id'") or die(mysqli_error());
        echo "<script>document.location='main_dashboard.php?space_name=$space_name&list_name=$list_name&list_id=$status_list_id'</script>";
    }

    if(isset($_POST['btn_due_date']))
    {   
        $txt_task_id = $_POST['txt_task_id'];
        $txt_due_date = $_POST['txt_due_date'];
        $txt_due_time = $_POST['txt_due_time'];
        $due_date_and_time = $txt_due_date. " " .$txt_due_time;
        mysqli_query($conn, "UPDATE task SET task_due_date = '$due_date_and_time' WHERE task_id='$txt_task_id'") or die(mysqli_error());
        echo "<script>document.location='main_dashboard.php?space_name=$space_name&list_name=$list_name&list_id=$status_list_id'</script>";
    }

    if(isset($_POST['btn_add_tag']))
    {
        $txt_add_tag = $_POST['txt_add_tag']; 
        mysqli_query($conn,"INSERT into `tags` (tag_name, tag_list_id, tag_color) values ('$txt_add_tag','$status_list_id','$tagcolor')") or die(mysqli_error());
        echo "<script>document.location='main_dashboard.php?space_name=$space_name&list_name=$list_name&list_id=$status_list_id'</script>";        
    }
    if (empty($_GET['tag'])) 
    {}
    else
    {
        $tasktag = $_GET['tag'];
        $task_id = $_GET['task_id'];       
        $find_task = mysqli_query($conn, "SELECT * FROM task WHERE task_id = '$task_id'");
        $result_find_task = mysqli_fetch_array($find_task);
        $current_task_tag = $result_find_task['task_tag'];

        if($current_task_tag == "")
        {
            mysqli_query($conn, "UPDATE task SET task_tag='$tasktag' WHERE task_id='$task_id'") or die(mysqli_error());
            echo "<script>document.location='main_dashboard.php?space_name=$space_name&list_name=$list_name&list_id=$status_list_id'</script>";
        }
        else
        {
            $current_array = explode(",", $current_task_tag); // convert string to array
            array_push($current_array,$tasktag); // insert the new user id to $current_array | ex. "1" then new array ==  [1,2,3,4,5,1]
            if(count($current_array) != count(array_unique($current_array))) // checking for existing element of array.
            {
                echo "<script type='text/javascript'>alert('Tag already assign to that task.');</script>";
                echo "<script>document.location='main_dashboard.php?space_name=$space_name&list_name=$list_name&list_id=$status_list_id'</script>";
            }
            else
            {
                $many_tag = $current_task_tag.",".$tasktag;
                mysqli_query($conn, "UPDATE task SET task_tag='$many_tag' WHERE task_id='$task_id'") or die(mysqli_error());
                echo "<script>document.location='main_dashboard.php?space_name=$space_name&list_name=$list_name&list_id=$status_list_id'</script>";   
            }
        }
    }
    if (empty($_GET['assign'])) 
    {}
    else
    {
        $task_assign_to = $_GET['assign'];
        $task_id = $_GET['task_id'];       
        $find_task = mysqli_query($conn, "SELECT * FROM task WHERE task_id = '$task_id'");
        $result_find_task = mysqli_fetch_array($find_task);
        $current_assign_to = $result_find_task['task_assign_to'];

        if($current_assign_to == "")
        {
            mysqli_query($conn, "UPDATE task SET task_assign_to='$task_assign_to' WHERE task_id='$task_id'") or die(mysqli_error());
        }
        else
        {
            $current_array = explode(",", $current_assign_to); // convert string to array
            array_push($current_array,$task_assign_to); // insert the new user id to $current_array | ex. "1" then new array ==  [1,2,3,4,5,1]
            if(count($current_array) != count(array_unique($current_array))) // checking for existing element of array.
            {
                echo "<script type='text/javascript'>alert('Member already assign to that task.');</script>";
                echo "<script>document.location='main_dashboard.php?space_name=$space_name&list_name=$list_name&list_id=$status_list_id'</script>";
            }
            else
            {
                $many_assign = $current_assign_to.",".$task_assign_to;
                mysqli_query($conn, "UPDATE task SET task_assign_to='$many_assign' WHERE task_id='$task_id'") or die(mysqli_error());
            }
        }

        // Update the DB in table "list" at "list_assign_id"
        $list_id = $_GET['list_id'];
        $select_list_assign_id = mysqli_query($conn, "SELECT * FROM list WHERE list_id = '$list_id'") or die(mysqli_error());
        $fetch_list = mysqli_fetch_array($select_list_assign_id);
        $list_assign_id = $fetch_list['list_assign_id'];
        $array_assign_id = explode(",", $list_assign_id); // convert string to array
        if($list_assign_id == "")
        {
            mysqli_query($conn, "UPDATE list SET list_assign_id='$task_assign_to' WHERE list_id='$list_id'") or die(mysqli_error());
        }
        else
        {
            if (in_array($task_assign_to, $array_assign_id))
            {}
            else
            {
                $multiple_assign = $list_assign_id.",".$task_assign_to;
                mysqli_query($conn, "UPDATE list SET list_assign_id='$multiple_assign' WHERE list_id='$list_id'") or die(mysqli_error());
            }
        }
        echo "<script>document.location='main_dashboard.php?space_name=$space_name&list_name=$list_name&list_id=$status_list_id'</script>";
    }

    if(isset($_POST['btn_remove_tag']))
    {
        $txt_tag_name = $_POST['txt_tag_name'];
        $txt_task_id = $_POST['txt_task_id'];  
        $find_tag = mysqli_query($conn, "SELECT * FROM task WHERE task_id = '$txt_task_id'");
        $result_find_tag = mysqli_fetch_array($find_tag);
        $current_tag = $result_find_tag['task_tag'];
        $current_array = explode(",", $current_tag);  // convert string to array
        $new_arr = array_diff($current_array, array($txt_tag_name));
        $final_array = implode( ",", $new_arr ); // convert array to string
        mysqli_query($conn, "UPDATE task SET task_tag='$final_array' WHERE task_id='$txt_task_id'") or die(mysqli_error());
        echo "<script>document.location='main_dashboard.php?space_name=$space_name&list_name=$list_name&list_id=$status_list_id'</script>";
    }
    if(isset($_POST['btn_remove_member']))
    {
        $task_last_id = $_GET['list_id'];
        $txt_assign_user_id = $_POST['txt_assign_user_id'];

        // ___________________ Update the DB in table "list" at "list_assign_id"
        $count = 0;
        $get_task = mysqli_query($conn,"SELECT * FROM task WHERE task_list_id = '$task_last_id' ORDER BY task_id ASC"); //get last id
        while($fetch_get_task = mysqli_fetch_array($get_task))
        {
            $taskss_id = $fetch_get_task['task_assign_to'];
            $array = explode(",", $taskss_id);  // convert string to array
            if (in_array($txt_assign_user_id, $array))
            {
                $count++;
            }
            else
            {}
        }        

        if($count == 1)
        {
            $find_list = mysqli_query($conn, "SELECT * FROM list WHERE list_id = '$task_last_id'") or die(mysqli_error());
            $result_find_list = mysqli_fetch_array($find_list);
            $list_assign_id = $result_find_list['list_assign_id'];
            $list_array = explode(",", $list_assign_id);  // convert string to array
            $find_different = array_diff($list_array, array($txt_assign_user_id));
            $finalarray = implode( ",", $find_different ); // convert array to string
            mysqli_query($conn, "UPDATE list SET list_assign_id='$finalarray' WHERE list_id = '$task_last_id'") or die(mysqli_error());
        }
        else{}
        // ___________________ End Update the DB in table "list" at "list_assign_id"

        $task_id = $_POST['txt_task_id'];         
        $find_task = mysqli_query($conn, "SELECT * FROM task WHERE task_id = '$task_id'");
        $result_find_task = mysqli_fetch_array($find_task);
        $current_assign_to = $result_find_task['task_assign_to'];
        $current_array = explode(",", $current_assign_to);  // convert string to array
        $new_arr = array_diff($current_array, array($txt_assign_user_id));
        $final_array = implode( ",", $new_arr ); // convert array to string
        mysqli_query($conn, "UPDATE task SET task_assign_to='$final_array' WHERE task_id = '$task_id'") or die(mysqli_error());
        echo "<script>document.location='main_dashboard.php?space_name=$space_name&list_name=$list_name&list_id=$status_list_id'</script>";
    }

    if(isset($_POST['btn_rename_task']))
    {
        $txt_rename_task = $_POST['txt_rename_task']; 
        $txt_task_ids = $_POST['txt_task_ids']; 
        mysqli_query($conn, "UPDATE task SET task_name='$txt_rename_task' WHERE task_id = '$txt_task_ids'") or die(mysqli_error());   
        echo "<script>document.location='main_dashboard.php?space_name=$space_name&list_name=$list_name&list_id=$status_list_id'</script>";      
    }
    if (empty($_GET['delete_task'])) 
    {}
    else
    {
        $task_id = $_GET['task_id'];       
        mysqli_query($conn, "DELETE FROM task WHERE task_id='$task_id'") or die(mysqli_error());
        echo "<script>document.location='main_dashboard.php?space_name=$space_name&list_name=$list_name&list_id=$status_list_id'</script>";
    }
        $no = 1;
        $a = array();

//_______________________________ FILTER STATUS Query
    $filter_status = mysqli_query($conn, "SELECT * FROM filter WHERE filter_space_id = '$space_id' AND filter_user_id = '$user_id' AND filter_name = 'status'");
    if(mysqli_num_rows($filter_status) != 0)
    {
        $filter_status_id_array = 'status_id = '.implode(" OR status_id = ", $status_array).'';
        $findstatus = mysqli_query($conn, "SELECT * FROM status WHERE status_list_id = '$status_list_id' AND $filter_status_id_array");
    }
    else
    {
        $findstatus = mysqli_query($conn, "SELECT * FROM status WHERE status_list_id = '$status_list_id' ORDER BY status_order_no ASC");
    }
//_______________________________ END FILTER STATUS Query

        while($result_findstatus = mysqli_fetch_array($findstatus))
        {
            $status_name = $result_findstatus['status_name'];
            $que = mysqli_query($conn, "SELECT * FROM status WHERE status_name='$status_name' AND status_list_id='$status_list_id'");                
            $res = mysqli_fetch_array($que);  

            $id_stat = $res['status_id']; //get the user_id ex. string = "1,2,3,4,5"
            array_push($a,$id_stat);
        ?>                         
            <style>
                .taskmenu
                {
                    width: 250px; margin: 10px 0px -10px -10px; padding: 5px 10px 5px 10px;
                    background-color: #fcf7e6;
                    box-shadow: 0px 1px 3px 0px rgba(119, 119, 119, 0.23);-moz-box-shadow: 0px 1px 3px 0px rgba(119, 119, 119, 0.23);-webkit-box-shadow: 0px 1px 3px 0px rgba(119, 119, 119, 0.23);
                    display: none;
                }
                /*li:hover {
                    cursor: pointer;
                }*/
                .fortask{
                    cursor: pointer;
                }  
                /*.parent:hover .taskmenu {
                  display: block;
                }
                .taskmenu:hover {
                    display:block; 
                    cursor: pointer; 
                }
                /*.status
                {
                    height: 470px;
                    overflow: hidden;
                }
                .status:hover
                {                    
                    overflow: auto;
                    overflow-x: hidden;
                }
                .status::-webkit-scrollbar {
                  width: 5px;
                  height: 10px;
                }

                .status::-webkit-scrollbar-thumb {
                  background: rgba(0, 0, 0, 0.2);
                }

                .status::-webkit-scrollbar-track {
                  background-color: transparent;
                }
                .status::-webkit-scrollbar-track-piece
                {
                    background-color: transparent;
                    -webkit-border-radius: 60px;
                }*/
                /*.parent:hover .taskmenu {
                  display: block;
                }
                .taskmenu:hover {
                    display:block; 
                    cursor: pointer; 
                }*/

                .myButton {
                    padding: 0px 0px 0px 0px; height:14px; width: 14px; border-radius:50px; position:absolute; display: none;
                }
                .duedateparent:hover .myButton {
                  display: block;
                }

                .rem
                {                    

                    bottom: -2.3em;
                    white-space: nowrap;
                    background-color: #343a40;
                }

                [data-title]:hover:after {
                    opacity: 1;
                    transition: all 0.1s ease 0.5s;
                    visibility: visible;
                }
                [data-title]:after {
                    content: attr(data-title);
                    border-radius: 10px;
                    background-color: #343a40;
                    color: #fff;
                    position: absolute;
                    padding: 5px 10px;
                    bottom: -2.3em;
                    white-space: nowrap;
                    visibility: hidden;
                }
                [data-title] {
                    position: relative;
                }

            </style> 

            <!-- Status from db -->     
                <div class="scrumboard-col block block-themed" style="<?php echo $md_bg; ?> width: 250px;">
                    <div class="block-header" style="height: 45px; padding: 10px 10px 10px 18px; border-top-right-radius: 3px; margin-bottom: 5px; border-radius: 3px; background-color: #fff; border-top: 3px solid <?php echo $res['status_color'];?>; box-shadow: 0px 1px 3px 0px rgba(119, 119, 119, 0.34);-moz-box-shadow: 0px 1px 3px 0px rgba(119, 119, 119, 0.34);-webkit-box-shadow: 0px 1px 3px 0px rgba(119, 119, 119, 0.34);">
                        <h3 class="block-title font-w600 text-muted" style="display: none;" id="status_rename<?php echo $res['status_id']; ?>">
                            <form method="post">
                                <div class="input-group" style="margin-left: -15px;">
                                    <input type="hidden" name="status_ids" value="<?php echo $res['status_id']; ?>">
                                    <input type="text" class="form-control is-valid" placeholder="Status name here..." name="status_name" value="<?php echo $status_name;?>" style="padding: 0px 5px 0px 5px; border-radius: 10px; height: 32px;" required>
                                    <button type="submit" class="btn btn-sm btn-circle btn-outline-secondary mr-0 mb-0" name="btn_rename_status" style="height: 28px; margin-top: 3px;"><i class="fa fa-check"></i></button>
                                    <button type="button" class="btn btn-sm btn-circle btn-outline-secondary mr-0 mb-0" name="btn_cancel_rename" id="<?php echo $res['status_id']; ?>" onclick="hide_rename_status(this.id)" style="height: 28px; margin-top: 3px;"><i class="fa fa-times"></i></button>
                                </div>
                            </form>
                        </h3>
  
                        <h5 class="block-title font-w600 text-muted" id="status_label<?php echo $res['status_id']; ?>"><?php 
                            $new_name = substr($status_name, 0, 17); // get specific character

                            if(strlen($status_name) > 17)
                            {
                                echo '<span data-toggle="popover" title="'.$status_name.'" data-placement="bottom">'.$new_name.'...</span>';
                            }
                            else
                            {
                                echo '<span>'.$status_name.'</span>';
                            }
                        ?></h5>
                            <span class="btn btn-sm btn-circle btn-secondary mr-0 mb-0 text-muted float-right" id="countspan<?php echo $res['status_id']; ?>" style="padding-left: 5px; padding-right: 5px;">    
                                <?php         
                                    // ------------------------- for counting task per status
                                    $task_status_id = $res['status_id'];
                                    $res1 = mysqli_query($conn,"SELECT * FROM task WHERE task_status_id='$task_status_id'");
                                    $count_task = mysqli_num_rows($res1);
                                ?>        
                            </span>
                                                                 
                        <div class="block-options">
                            <div class="dropdown">
                                <button type="button" class="btn-block-option" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-fw fa-ellipsis-v" style="color: <?php echo $res['status_color'];?>;"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-right shadow">
                                    <a class="dropdown-item" id="<?php echo $res['status_id']; ?>" data-toggle="modal" data-target="#modal-add_task">
                                        <i class="fa fa-fw fa-plus mr-5"></i>Add Task
                                    </a>
                                    <?php 
                                    if($user_type == "Admin")
                                    { ?> 
                                        <a class="dropdown-item" id="<?php echo $res['status_id']; ?>" onclick="show_rename_status(this.id)">
                                            <i class="fa fa-fw fa-pencil mr-5"></i>Rename
                                        </a>
                                        <form method="post">
                                            <input type="hidden" name="txt_delete_status_id" value="<?php echo $res['status_id']; ?>">
                                            <input type="hidden" name="txt_total_task" value="<?php echo $count_task; ?>">
                                            <button type="submit" name="btn_delete_status" class="btn btn-sm btn-noborder btn-secondary btn-block"> <i class="fa fa-times mr-5 text-danger"></i>Delete </button>
                                        </form>
                                    <?php } ?> 
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="block-full" style="padding: 5px; background-color: #f0f2f5; display: none;" id="task<?php echo $res['status_id']; ?>">
                        <form method="post">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <button type="button" class="btn btn-alt-secondary btn-noborder mr-5 mb-5" name="btn_hide_add_task" id="<?php echo $res['status_id']; ?>" onclick="hide_add_task(this.id)"><i class="fa fa-times"></i>
                                    </button>
                                </div>
                                <input type="hidden" name="status_id" value="<?php echo $res['status_id']; ?>">
                                <input type="text" class="form-control" placeholder="Add Task.." name="task_name" required>
                                <div class="input-group-prepend">
                                    <button type="submit" hidden="hidden" class="btn btn-alt-secondary btn-noborder mr-5 mb-5" name="btn_add_task"><i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!--<div class="block status" style="background-color: #eeeeee;">    -->
                    <div class="block" data-toggle="slimscroll" data-height="470px" style="<?php echo $md_bg; ?>">
                        <ul class="scrumboard-items block-content list-unstyled" id="sortable<?php echo $no++; ?>" class="connectedSortable" style="width: 290px; margin-left: -20px;">
                            <input type="hidden" id="id_status" name="status_no" value="<?php echo $res['status_id'];?>" style="width: 40px; text-align: center;">
                            <?php
                                $final_status_id = $res['status_id'];
                                $abc = 0;
                                //_______________________________ FILTER // filter query by status at the top
                                include('filter.php');
                            ?>                                         
                        </ul>
                    </div>
                </div>
            <!-- END Status from db --> 
        <?php 
        }
            $count = mysqli_query($conn,"SELECT * FROM status WHERE status_list_id = '$status_list_id'");
            $res_count = mysqli_num_rows($count);

            $status_string = implode( ",", $a ); // Convert array to string
?> 
        <input type="hidden" id="all_status_id" value="<?php echo $status_string; ?>">  
        <input type="hidden" id="total_status" value="<?php echo $res_count; ?>"> 
        <!--<p id="demo"></p>-->  

<script type="text/javascript">
    var all_status_id = document.getElementById("all_status_id").value; // 228,229
    var strArray = all_status_id.split(",");

    for(var i = 0; i < strArray.length; i++){
        document.getElementById("countspan" + strArray[i]).innerHTML = document.getElementById("count" + strArray[i]).value;
    }
</script>

<script type="text/javascript">
    function show_add_task(id) 
    {
        var a = id;
        $("#task" + a).show(); 
    } 
    function hide_add_task(id) 
    {
        var b = id;
        $("#task" + b).hide(); 
    }
    //________________________________________________
    function show_rename_status(id) 
    {
        var a = id;
        $("#status_rename" + a).show(); 
        $("#status_label" + a).hide(); 
    } 
    function hide_rename_status(id) 
    { 
        var b = id;
        $("#status_rename" + b).hide();
        $("#status_label" + b).show(); 
    }
    //________________________________________________
    function show_task_menu(id) 
    {
        var a = id;
        $("#taskmenuid" + a).toggle();
    } 


    function showtaskmenu(id) 
    {
        var a = id;
        $("#taskmenuid" + a).show(); 
    } 
    function hidetaskmenu(id) 
    {
        var b = id;
        $("#taskmenuid" + b).hide(); 
    }


    //________________________________________________
    function show_rename_task(id) 
    {
        var a = id;        
        $("#task_rename" + a).toggle();
        $("#task_real_name" + a).toggle();
    } 
    //________________________________________________
</script>           
<script>
    $(document).ready(function(){
        list_id = <?php echo $status_list_id; ?>;

        var text = "";
        var total_status = document.getElementById("total_status").value;
        for (var i = 1; i <= total_status; i++) 
        {
          text += "#sortable" + i +",";
        }
        var str = text;
        var newStr = str.substring(0, str.length - 1);

        $(newStr).sortable(
        {
            connectWith: '.connectedSortable',
            update : function () 
            {   
                    $.ajax(
                    {
                        type: "POST",
                        url: "update_task_order.php",
                        data: 
                        {
                            list_id:list_id,
                            total_status:total_status,
                            sort1:$("#sortable1").sortable('serialize'),
                            sort2:$("#sortable2").sortable('serialize'),
                            sort3:$("#sortable3").sortable('serialize'),
                            sort4:$("#sortable4").sortable('serialize'),
                            sort5:$("#sortable5").sortable('serialize'),
                        },
                        success: function(html)
                        {}
                    });
            } 
        }).disableSelection();
    });
</script>
