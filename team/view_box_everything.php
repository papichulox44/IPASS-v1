<?php
    $md_primary_darker = "";
    $md_text = "text-muted";
    $md_body = "";
    $md_stat = "bg-body-light";
    if($mode_type == "Dark") //insert
    { 
        $md_primary_darker = "bg-primary-darker";
        $md_text = "text-white";
        $md_body = "bg-gray-darker text-body-color-light";
        $md_stat = "bg-primary-darker";
    }
?>
<!-- Main Container -->
<main id="main-container" style="margin: -5px -10px 0px -10px;">
    <!-- Page Content -->
    <!-- Dropdonw filter header -->
    <div class="content">
        <div class="block-header content-heading">
            <h3 class="block-title" style="color: white;">All Record(s)</h3>
            <div class="dropdown float-right">
                <button type="button" class="btn btn-sm btn-secondary dropdown-toggle" id="ecom-orders-overview-drop" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span><?php if (isset($_GET['filter'])) {echo $_GET['filter'];} else { echo "This Week";} ?></span>
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="ecom-orders-overview-drop" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(96px, 31px, 0px);">                                        
                    <button class="dropdown-item" onclick="tran_all()">
                        <i class="fa fa-fw fa-circle-o mr-5"></i>All
                    </button>
                    <button class="dropdown-item" onclick="tran_today()">
                        <i class="fa fa-fw fa-calendar mr-5"></i>Today
                    </button>
                    <button class="dropdown-item" onclick="tran_week()">
                        <i class="fa fa-fw fa-calendar mr-5"></i>This Week
                    </button>
                    <button class="dropdown-item" onclick="tran_month()">
                        <i class="fa fa-fw fa-calendar mr-5"></i>This Month
                    </button>
                    <button class="dropdown-item" onclick="tran_year()">
                        <i class="fa fa-fw fa-calendar mr-5"></i>This Year
                    </button>
                    <span class="filterparent">
                        <form class="dropdown-item filterparent">
                            <i class="fa fa-fw fa-calendar mr-5"></i>Custom Date
                        </form>
                        <div class="dropdown-menu dropdown-menu-right shadow filterchild" style="position: absolute; top: 185px; right: 120px;">
                            <label for="example-datepicker4">Custom date</label>
                            <div class="form-material">
                                <input id="date_from" type="date" class="js-datepicker form-control" data-week-start="1" data-today-highlight="true" data-date-format="mm/dd/yy" placeholder="mm/dd/yy" required>
                                <label for="example-datepicker4">From:</label>
                            </div>
                            <div class="form-material">
                                <input id="date_to" type="date" class="js-datepicker form-control" data-week-start="1" data-today-highlight="true" data-date-format="mm/dd/yy" placeholder="mm/dd/yy" required>
                                <label for="example-datepicker4">To:</label>
                            </div>
                            <div class="form-material">
                                <button class="btn btn-sm btn-noborder btn-alt-primary btn-block" onclick="tran_custom_box()"><i class="fa fa-check-square-o"></i>Go</button>
                            </div>
                        </div>
                    </span> 
                </div>
            </div>
        </div>

        <style type="text/css">
            li:hover .aaa 
            {
                color: #575757;
                cursor: pointer;
            }
            .bbb
            {
                margin-left: -10px;
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
        <div class="row">    
        	<!-- Unassign -->
            <div class="col-md-6 col-xl-3" >
                <div class="block block-themed" style="box-shadow: 0px 1px 3px 0px rgba(119, 119, 119, 0.34);-moz-box-shadow: 0px 1px 3px 0px rgba(119, 119, 119, 0.34);-webkit-box-shadow: 0px 1px 3px 0px rgba(119, 119, 119, 0.34);">
                    <?php

                        //query for filtering data
                        if (isset($_GET['filter']) or isset($get_from)) {
                            $filterby = $_GET['filter'];
                            
                            if($filterby == "All")
                            {                    
                                $findtask_unassign = mysqli_query($conn, "SELECT * FROM task WHERE task_assign_to = ''");
                            }
                            else if($filterby == "Today")
                            {   
                                $filter = date("Y-m-d");
                                $findtask_unassign = mysqli_query($conn, "SELECT * FROM task WHERE task_assign_to = '' and task_date_created LIKE '%$filter%'");
                            }
                            else if($filterby == "This Week")
                            {
                                $dt = new DateTime();
                                $dates = []; 
                                for ($d = 1; $d <= 7; $d++) {
                                    $dt->setISODate($dt->format('o'), $dt->format('W'), $d);
                                    $weekdate = ($dates[$dt->format('D')] = $dt->format('Y-m-d'));
                                }
                                $from = current($dates); // monday
                                $to = end($dates); // sunday
                                $findtask_unassign = mysqli_query($conn, "SELECT * FROM task WHERE task_assign_to = '' and task_date_created BETWEEN '$from' AND '$to'");
                            }
                            else if($filterby == "This Month")
                            {
                                $filter = date("Y-m");
                                $findtask_unassign = mysqli_query($conn, "SELECT * FROM task WHERE task_assign_to = '' and task_date_created LIKE '%$filter%'");
                            }
                            else if($filterby == "This Year")
                            {
                                $filter = date("Y");
                                $findtask_unassign = mysqli_query($conn, "SELECT * FROM task WHERE task_assign_to = '' and task_date_created LIKE '%$filter%'");
                            }
                            else if($filterby == "Custom Date")
                            {                    
                                $get_from = $_GET['From'];
                                $get_to = $_GET['To'];
                                $findtask_unassign = mysqli_query($conn, "SELECT * FROM task WHERE task_assign_to = '' and task_date_created BETWEEN '$get_from' AND '$get_to'");
                            }
                        }
                        else
                        {
                            $dt = new DateTime();
                            $dates = []; 
                            for ($d = 1; $d <= 7; $d++) {
                                $dt->setISODate($dt->format('o'), $dt->format('W'), $d);
                                $weekdate = ($dates[$dt->format('D')] = $dt->format('Y-m-d'));
                            }
                            $from = current($dates); // monday
                            $to = end($dates); // sunday
                            $findtask_unassign = mysqli_query($conn, "SELECT * FROM task WHERE task_assign_to = '' and task_date_created BETWEEN '$from' AND '$to'");
                        }


                        // $findtask_unassign = mysqli_query($conn, "SELECT * FROM task WHERE task_assign_to = ''");
                        $unassign_all = mysqli_num_rows($findtask_unassign);

                        $undone = 0;
                        $done = 0;

                        while($fetch_unassign = mysqli_fetch_array($findtask_unassign))
                        {
                            $task_list_id = $fetch_unassign['task_list_id'];
                            $current_status = $fetch_unassign['task_status_id'];

                            $findtask_last_status = mysqli_query($conn, "SELECT * FROM status WHERE status_list_id = '$task_list_id' ORDER BY status_order_no DESC LIMIT 1");
                            $fetch_last = mysqli_fetch_array($findtask_last_status);
                            $last_status_id = $fetch_last['status_id'];

                            if($current_status != $last_status_id)
                            {
                                $undone++;
                            }
                            else
                            {
                                $done++;
                            }
                        }

                        if($unassign_all == 0)
                        {
                            $percentage = 0;
                        }
                        else
                        {
                            $total = $done / $unassign_all * 100;
                            $percentage = number_format($total)."";
                        }
                    ?>
                    <div class="block-header bg-gd-aqua">
                        <h3 class="block-title">Unassign</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-toggle="block-option" data-action="content_toggle"></button>
                            </div>
                    </div>
                    <div class="block-content <?php echo $md_body; ?>">
                        <div class="form-group row">
                        	<!-- Undone-Done-Percentage -->
                            <div class="block-content block-content-full <?php echo $md_stat; ?>" style="margin: -10px 0px 10px 0px; padding: 10px;">
                                <div class="row">
                                    <div class="text-center" style="width: 33.33333333333333%;">
                                        <div class="font-w600 text-center mt-5"><span><?php echo $undone; ?></span></div>
                                        <div class="font-size-sm text-muted text-center">Undone</div>
                                    </div> 
                                    <div class="text-center" style="width: 33.33333333333333%;">
                                        <div class="font-w600 text-center mt-5"><span><?php echo $done; ?></span></div>
                                        <div class="font-size-sm text-muted text-center">Done</div>
                                    </div>
                                    <div class="text-center" style="width: 33.33333333333333%;border: 5px; border-color: black;">
                                        <div class="js-pie-chart pie-chart" data-percent="<?php echo $percentage; ?>" data-line-width="4" data-size="50" data-bar-color="#42a5f5" data-track-color="#e9e9e9">
                                            <span><?php echo $percentage; ?>%</span>
                                        </div>
                                    </div> 
                                </div>  
                            </div>
                            <div class="content-side content-side-full" style="margin-top: -20px;">
                                <span class="row bg-gd-aqua text-white ml-0 mr-0" style="padding: 5px 5px 5px 20px; cursor: pointer;" onclick="show_content_space_unassign()">Total task: <strong class="ml-5"><?php echo $unassign_all;?>
                                    <input type="hidden" id="filter" value="<?php if (empty($_GET['filter'])){ echo "This Week";} else { echo $_GET['filter']; } ?>">
                                </strong></span>
                            </div>
                        	<!-- END Undone-Done-Percentage -->
                            <div class="content-side content-side-full scroll" id="space_content">
                                <center>
                                    <span id="loader-wrapper">
                                      <img src="../assets/media/photos/logo-ipass.png" class="loader">
                                    </span>
                                </center>
                            </div>
                            <!-- END Unassign space-list-status-task -->
                        </div>
                    </div>
                </div>
            </div> 
        	<!-- END Unassign -->   
        	<!-- Assign  -->   
        	<?php
        		$select_user = mysqli_query($conn,"SELECT * FROM user ORDER BY fname");
        		while($result_find_member = mysqli_fetch_array($select_user))
        		{
        			$user_id = $result_find_member['user_id'];
                    $total_task = 0;
                    $count_done = 0;
                    $count_undone = 0;
                    $get_first_letter_in_fname = $result_find_member['fname'];     
                    $get_first_letter_in_lname = $result_find_member['lname'];

                    //query for filtering data
                    if (isset($_GET['filter']) or isset($get_from)) {
                        $filterby = $_GET['filter'];
                        
                        if($filterby == "All")
                        {                    
                            $select_all_task = mysqli_query($conn, "SELECT * FROM task WHERE task_assign_to != ''");
                        }
                        else if($filterby == "Today")
                        {   
                            $filter = date("Y-m-d");
                            $select_all_task = mysqli_query($conn, "SELECT * FROM task WHERE task_assign_to != '' and task_date_created LIKE '%$filter%'");
                        }
                        else if($filterby == "This Week")
                        {
                            $dt = new DateTime();
                            $dates = []; 
                            for ($d = 1; $d <= 7; $d++) {
                                $dt->setISODate($dt->format('o'), $dt->format('W'), $d);
                                $weekdate = ($dates[$dt->format('D')] = $dt->format('Y-m-d'));
                            }
                            $from = current($dates); // monday
                            $to = end($dates); // sunday
                            $select_all_task = mysqli_query($conn, "SELECT * FROM task WHERE task_assign_to != '' and task_date_created BETWEEN '$from' AND '$to'");
                        }
                        else if($filterby == "This Month")
                        {
                            $filter = date("Y-m");
                            $select_all_task = mysqli_query($conn, "SELECT * FROM task WHERE task_assign_to != '' and task_date_created LIKE '%$filter%'");
                        }
                        else if($filterby == "This Year")
                        {
                            $filter = date("Y");
                            $select_all_task = mysqli_query($conn, "SELECT * FROM task WHERE task_assign_to != '' and task_date_created LIKE '%$filter%'");
                        }
                        else if($filterby == "Custom Date")
                        {                    
                            $get_from = $_GET['From'];
                            $get_to = $_GET['To'];
                            $select_all_task = mysqli_query($conn, "SELECT * FROM task WHERE task_assign_to != '' and task_date_created BETWEEN '$get_from' AND '$get_to'");
                        }
                    }
                    else
                    {
                        $dt = new DateTime();
                        $dates = []; 
                        for ($d = 1; $d <= 7; $d++) {
                            $dt->setISODate($dt->format('o'), $dt->format('W'), $d);
                            $weekdate = ($dates[$dt->format('D')] = $dt->format('Y-m-d'));
                        }
                        $from = current($dates); // monday
                        $to = end($dates); // sunday
                        $select_all_task = mysqli_query($conn, "SELECT * FROM task WHERE task_assign_to != '' and task_date_created BETWEEN '$from' AND '$to'");
                    }

                    // $select_all_task = mysqli_query($conn,"SELECT * FROM task");
                    $total_row = mysqli_num_rows($select_all_task);
                    $percentage_assign = 0;
                    while($fetch_all_task = mysqli_fetch_array($select_all_task))
                    {
                        $task_assign_to = $fetch_all_task['task_assign_to'];
                        $array_assign = explode(",",$task_assign_to);
                        if (in_array($user_id, $array_assign))
                        {
                            $total_task++;
                            $task_list_id = $fetch_all_task['task_list_id'];
                            $last_status = mysqli_query($conn, "SELECT * FROM status WHERE status_list_id = '$task_list_id' ORDER BY status_order_no DESC LIMIT 1");
                            $fetch_last_status = mysqli_fetch_array($last_status);
                            $last_status_id = $fetch_last_status['status_id'];

                            if($fetch_all_task['task_status_id'] == $last_status_id)
                            {
                                $count_done++;
                            }
                            else
                            {
                                $count_undone++;
                            }
                        }
                            if($count_done != 0)
                                {
                                    $total = $count_done / $total_row * 100;
                                    $percentage_assign = number_format($total)."";
                                }
                            else
                                {
                                    $percentage_assign = '0';
                                }
                    }   
        			echo '
                    <div class="col-md-6 col-xl-3" >
                        <div class="block block-themed" style="box-shadow: 0px 1px 3px 0px rgba(119, 119, 119, 0.34);-moz-box-shadow: 0px 1px 3px 0px rgba(119, 119, 119, 0.34);-webkit-box-shadow: 0px 1px 3px 0px rgba(119, 119, 119, 0.34);">
                            <div class="block-header" style="background-color: #fff;border-bottom: 1px solid '.$result_find_member['user_color'].';">';
                            if($result_find_member['profile_pic'] != "")
                            {echo'<img style="width: 28px; height: 28px; border-radius:50px;" src="../assets/media/upload/'.$result_find_member['profile_pic'].'">';}
                            else
                            {echo '<span class="btn btn-sm btn-circle" style="color:#fff; font-size: 11px; padding-top: 8px; background-color: '.$result_find_member['user_color'].'">'.$get_first_letter_in_fname[0].''.$get_first_letter_in_lname[0].'</span>';}
                            echo'
                                <h3 class="block-title text-muted ml-5">';
                                    $fullname = $result_find_member['fname'].' '.$result_find_member['mname'].' '.$result_find_member['lname'];
                                    $new_name = substr($fullname, 0, 17); // get only 10 character
                                    if(strlen($fullname) > 17)
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
                                    echo '</h3>
                                    <div class="block-options">
                                        <!--<button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                                            <i class="si si-refresh"></i>
                                        </button>-->
                                        <button type="button" class="btn-block-option text-muted" data-toggle="block-option" data-action="content_toggle"></button>
                                    </div>
                            </div>
                            <div class="block-content '.$md_body.'" style="border-bottom: 2px solid '.$result_find_member['user_color'].';">
                                <div class="form-group row">   
                                    <div class="block-content block-content-full '.$md_stat.'" style="margin: -10px 0px 10px 0px; padding: 10px;">
                                    	<div class="row">                                            
                                            <div class="text-center" style="width: 33.33333333333333%;">
                                                <div class="font-w600 text-center mt-5">'.$count_undone.'</div>
                                                <div class="font-size-sm text-muted">Undone</div>
                                            </div>                                            
                                            <div class="text-center" style="width: 33.33333333333333%;">
                                                <div class="font-w600 text-center mt-5">'.$count_done.'</div>
                                                <div class="font-size-sm text-muted">Done</div>
                                            </div> 
                                            <div class="text-center" style="width: 33.33333333333333%;border: 5px; border-color: black;">
                                                <div class="js-pie-chart pie-chart" data-percent="0" data-line-width="4" data-size="50" data-bar-color="'.$result_find_member['user_color'].'" data-track-color="#e9e9e9">
                                                    <span>'.$percentage_assign.'%</span>
                                                </div>
                                            </div> 
                                        </div>
                                    </div>
                                    <div class="content-side content-side-full" style="margin-top: -20px;">
                                        <span class="row text-white ml-0 mr-0" style="padding: 5px 5px 5px 20px; background-color: '.$result_find_member['user_color'].'; cursor: pointer;" id="'.$user_id.'" onclick="show_content_space_assign(this.id)">Total task: <strong class="ml-5">'.$total_task.'
                                        <input type="hidden" id="filter" value="'; if (empty($_GET['filter'])){ echo "This Week";} else { echo $_GET['filter']; }echo '">
                                        </strong></span>
                                    </div>
                                    <div class="content-side content-side-full scroll" id="space_content_assign'.$user_id.'">' ;
                                    echo '
                                    <center>
                                        <span id="loader-wrapper'.$user_id.'">
                                          <img src="../assets/media/photos/logo-ipass.png" class="loader">
                                        </span>
                                    </center>
                                    ';
                                        echo'
                                    </div>
                               	</div>
                            </div>
                        </div>
                    </div>
        			';
        		}
        	?>
        	<!-- END Assign  --> 
        </div>
    </div>
    <!-- END Page Content -->
</main>
<!-- END Main Container -->

<script type="text/javascript">
    function show_content_space_unassign()
    {
        var filter = document.getElementById("filter").value        
        $.ajax({
            url: 'ajax.php',
            type: 'POST', 
            async: false,
            data:{
                filter:filter,
                show_space: 1,
            },
                success: function(response){
                    document.getElementById('loader-wrapper').style.display='none'
                    $('#space_content').html(response);
                }
        });
    }

    function show_content_space_assign(id)
    {
        var user_id = id;
        var filter = document.getElementById("filter").value  

        $.ajax({
            url: 'ajax.php',
            type: 'POST', 
            async: false,
            data:{
                user_id:user_id,
                filter:filter,
                show_space_assign: 1,
            },
                success: function(response){
                    document.getElementById('loader-wrapper' +id).style.display='none'
                    $('#space_content_assign'+id).html(response);
                }
        });
    }

    function view_task_box(id)
    {
        // alert(id);
        array = id.split(',');
        task_id = array[0];
        space_name = array[1];
        list_name = array[2];
        list_id = array[3];

        document.location = 'main_dashboard.php?space_name='+space_name+'&list_name='+list_name+'&list_id='+list_id+'&get_task_id='+task_id+'&b=1';
    }
</script>