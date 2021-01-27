<!-- Main Container -->
<main id="main-container" style="margin: -5px -10px 0px -10px;">
    <!-- Page Content -->
    <div class="content <?php echo $md_primary_darker; ?>">
        <!-- Dynamic Table Full -->
        <div class="block block-content block-content-full shadow <?php echo $md_body; ?>">
            <!-- DataTables functionality is initialized with .js-dataTable-full class in js/pages/be_tables_datatables.min.js which was auto compiled from _es6/pages/be_tables_datatables.js -->
            <div class="block-header content-heading">
                <h3 class="block-title" style="color: white;">All Record(s)</h3>

                <!-- <h5 class="float-right" style="color: white;">All Record(s)</h5> -->
                <div class="dropdown float-right">
                    <button type="button" class="btn btn-sm btn-secondary dropdown-toggle" id="ecom-orders-overview-drop" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span>Due Date</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="ecom-orders-overview-drop" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(96px, 31px, 0px);">  
                        <button class="dropdown-item" onclick="tran_all_due_date()">
                            <i class="fa fa-fw fa-circle-o mr-5"></i>All
                        </button>
                        <button class="dropdown-item" onclick="tran_today_due_date()">
                            <i class="fa fa-fw fa-calendar mr-5"></i>Today
                        </button>
                        <button class="dropdown-item" onclick="tran_week_due_date()">
                            <i class="fa fa-fw fa-calendar mr-5"></i>This Week
                        </button>
                        <button class="dropdown-item" onclick="tran_month_due_date()">
                            <i class="fa fa-fw fa-calendar mr-5"></i>This Month
                        </button>
                        <button class="dropdown-item" onclick="tran_year_due_date()">
                            <i class="fa fa-fw fa-calendar mr-5"></i>This Year
                        </button>
                        <span class="filterparent">
                            <form class="dropdown-item filterparent">
                                <i class="fa fa-fw fa-calendar mr-5"></i>Custom Date
                            </form>
                            <div class="dropdown-menu dropdown-menu-right shadow filterchild" style="position: absolute; top: 185px; right: 120px;">
                                <label for="example-datepicker4">Custom date</label>
                                <div class="form-material">
                                    <input type="date" class="js-datepicker form-control" id="txt_date_from_due_date" data-week-start="1" data-today-highlight="true" data-date-format="mm/dd/yy" placeholder="mm/dd/yy" required>
                                    <label for="example-datepicker4">From:</label>
                                </div>
                                <div class="form-material">
                                    <input type="date" class="js-datepicker form-control" id="txt_date_to_due_date" data-week-start="1" data-today-highlight="true" data-date-format="mm/dd/yy" placeholder="mm/dd/yy" required>
                                    <label for="example-datepicker4">To:</label>
                                </div>
                                <div class="form-material">
                                    <button class="btn btn-sm btn-noborder btn-alt-primary btn-block" onclick="tran_custom_due_date()"><i class="fa fa-check-square-o"></i>Go</button>
                                </div>
                            </div>
                        </span> 
                    </div>
                </div>
                     |
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
                                    <input type="date" class="js-datepicker form-control" id="txt_date_from" data-week-start="1" data-today-highlight="true" data-date-format="mm/dd/yy" placeholder="mm/dd/yy" required>
                                    <label for="example-datepicker4">From:</label>
                                </div>
                                <div class="form-material">
                                    <input type="date" class="js-datepicker form-control" id="txt_date_to" data-week-start="1" data-today-highlight="true" data-date-format="mm/dd/yy" placeholder="mm/dd/yy" required>
                                    <label for="example-datepicker4">To:</label>
                                </div>
                                <div class="form-material">
                                    <button class="btn btn-sm btn-noborder btn-alt-primary btn-block" onclick="tran_custom()"><i class="fa fa-check-square-o"></i>Go</button>
                                </div>
                            </div>
                        </span> 
                    </div>
                </div>
            </div>
            <table class="block table table-bordered table-striped table-hover table-vcenter js-dataTable-full <?php echo $md_body; ?>">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Name</th>
                        <th class="d-none d-sm-table-cell">Due_Date</th>
                        <th class="d-none d-sm-table-cell">Date_Created</th>
                        <th class="d-none d-sm-table-cell">Priority</th>
                        <th class="d-none d-sm-table-cell text-center">Assign</th>
                        <th class="d-none d-sm-table-cell text-center">Space</th>
                        <th class="d-none d-sm-table-cell text-center">List</th>
                        <th class="text-center">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        date_default_timezone_set('Asia/Manila');

                        if (isset($_GET['filter']) or isset($_GET['due_date'])) {
                                $filterby = $_GET['filter'];
                                $due_date = $_GET['due_date'];
                                $due_date_filter = '';

                                if($due_date == "All")
                                {                    
                                    $due_date_filter = '';
                                }
                                else if($due_date == "Today")
                                {   
                                    $filter_due = date("Y-m-d");
                                    $due_date_filter = "LIKE '%".$filter_due."%'";
                                }
                                else if($due_date == "This Week")
                                {
                                    $dt = new DateTime();
                                    $dates = []; 
                                    for ($d = 1; $d <= 7; $d++) {
                                        $dt->setISODate($dt->format('o'), $dt->format('W'), $d);
                                        $weekdate = ($dates[$dt->format('D')] = $dt->format('Y-m-d'));
                                    }
                                    $from_due = current($dates); // monday
                                    $to_due = end($dates); // sunday

                                    $due_date_filter = "BETWEEN '".$from_due."' AND '".$to_due."'";
                                }
                                else if($due_date == "This Month")
                                {
                                    $filter_due = date("Y-m");
                                    $due_date_filter = "LIKE '%".$filter_due."%'";
                                }
                                else if($due_date == "This Year")
                                {
                                    $filter_due = date("Y");
                                    $due_date_filter = "LIKE '%".$filter_due."%'";
                                }
                                else if($due_date == "Custom Date")
                                {                    
                                    $get_from_due = $_GET['From_due'];
                                    $get_to_due = $_GET['To_due'];
                                    $due_date_filter = "BETWEEN '".$get_from_due."' AND '".$get_to_due."'";
                                }


                                if($filterby == "All")
                                {                    
                                    if($due_date == "All")
                                    {                    
                                        $select_task = mysqli_query($conn, "SELECT * FROM task ORDER BY task_date_created DESC");                                    }
                                    else
                                    {
                                        $select_task = mysqli_query($conn, "SELECT * FROM task WHERE task_due_date $due_date_filter ORDER BY task_date_created DESC");
                                    }
                                }
                                else if($filterby == "Today")
                                {   
                                    $filter = date("Y-m-d");
                                    $select_task = mysqli_query($conn, "SELECT * FROM task WHERE task_date_created LIKE '%$filter%' AND task_due_date $due_date_filter");
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
                                    $select_task = mysqli_query($conn, "SELECT * FROM task WHERE task_date_created BETWEEN '$from' AND '$to' AND task_due_date $due_date_filter ORDER BY task_date_created DESC");
                                }
                                else if($filterby == "This Month")
                                {
                                    $filter = date("Y-m");
                                    $select_task = mysqli_query($conn, "SELECT * FROM task WHERE task_date_created LIKE '%$filter%' AND task_due_date $due_date_filter ORDER BY task_date_created DESC");
                                }
                                else if($filterby == "This Year")
                                {
                                    $filter = date("Y");
                                    $select_task = mysqli_query($conn, "SELECT * FROM task WHERE task_date_created LIKE '%$filter%' AND task_due_date $due_date_filter ORDER BY task_date_created DESC");
                                }
                                else if($filterby == "Custom Date")
                                {                    
                                    $get_from = $_GET['From'];
                                    $get_to = $_GET['To'];
                                    $select_task = mysqli_query($conn, "SELECT * FROM task WHERE task_date_created BETWEEN '$get_from' AND '$get_to' AND task_due_date $due_date_filter ORDER BY task_date_created DESC");
                                }
                            }

                        $count = 1;
                        // $select_task = mysqli_query($conn, "SELECT * FROM task");
                        while($fetch_task = mysqli_fetch_array($select_task))
                        {
                            $task_status_id = $fetch_task['task_status_id'];
                            $task_list_id = $fetch_task['task_list_id']; // get list id
                            $task_id = $fetch_task['task_id'];

                            $select_list = mysqli_query($conn, "SELECT * FROM list WHERE list_id = '$task_list_id'");
                            $list_name = mysqli_fetch_array($select_list);

                            echo'
                            <tr style="cursor: pointer;" id="taskid_'.$task_id.'" onclick="view_task(this.id)">
                                <td>'.$count++.'</td>
                                <td>';
                                    $task_name = $fetch_task['task_name'];
                                    $new__task_name = substr($task_name, 0, 18); // get only 10 character
                                    if(strlen($task_name) > 18)
                                    {
                                        echo '<span data-toggle="popover" title="'.$fetch_task['task_name'].'" data-placement="bottom">'.$new__task_name.'...</span>';
                                    }
                                    else
                                    {
                                        echo '<span data-toggle="popover" title="'.$fetch_task['task_name'].'" data-placement="bottom">'.$new__task_name.'</span>';
                                    }
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
                                                $new__tag_name = substr($tag_name, 0, 5); // get only 10 character
                                                echo '<span style="background-color: '.$result_get_tag_color['tag_color'].'; color:#fff; padding:2px 7px 2px 5px; border-top-right-radius: 25px; border-bottom-right-radius: 25px; font-size: 11px; margin: 0px 0px 0px 5px;" data-toggle="popover" title="'.$tag_name.'" data-placement="bottom">';
                                                if(strlen($tag_name) > 5)
                                                {
                                                    echo''.$new__tag_name.'..'; 
                                                }
                                                else
                                                {
                                                    echo''.$new__tag_name.''; 
                                                }
                                                echo '</span>';
                                            }                                                        
                                        }
                                    echo '
                                </td>
                                <td class="d-none d-sm-table-cell">'.$fetch_task['task_due_date'].'</td>
                                <td class="d-none d-sm-table-cell">'.$fetch_task['task_date_created'].'</td>
                                <td class="d-none d-sm-table-cell">';
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
                                <td class="d-none d-sm-table-cell text-center">';
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
                                <td class="d-none d-sm-table-cell text-center">';
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
                                <td class="d-none d-sm-table-cell text-center">';

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
                                    echo '<td class="text-center text-white bg-gd-sea" data-toggle="popover" title="'.$fetch_status_name['status_name'].'" data-placement="bottom" data-content="ID: '.$task_status_id.'">Finish</td>';
                                }
                                else
                                {
                                    echo '<td class="text-center text-white" style="background-color: '.$fetch_status_name['status_color'].';">';
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
                        }
                    ?>
                </tbody>
            </table>
        </div>
        <!-- END Dynamic Table Full -->
    </div>
    <!-- END Page Content -->
</main>
<!-- END Main Container -->

<script type="text/javascript">
    function view_task(id)
    {
        new_id = id.replace("taskid_", "");
        space_name = document.getElementById("spacename" + new_id).value;
        list_name = document.getElementById("listname" + new_id).value;
        list_id = document.getElementById("listid" + new_id).value;

        document.location = 'main_dashboard.php?space_name='+space_name+'&list_name='+list_name+'&list_id='+list_id+'&get_task_id='+new_id+'&b=1';
    }
</script>