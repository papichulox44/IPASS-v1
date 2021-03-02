<!-- Unassign space-list-status-task -->
                            
                            	<ul class="nav-main" style="margin-top: -20px;">
                                <?php
                                    $find_space = mysqli_query($conn, "SELECT * FROM space ORDER BY space_name ASC");
                                    while($fetch_space = mysqli_fetch_array($find_space))
                                    {
                                        $space_id = $fetch_space['space_id'];

                                        //query for filtering data
                                        if (isset($_GET['filter']) or isset($get_from)) {
                                            $filterby = $_GET['filter'];
                                            
                                            if($filterby == "All")
                                            {                    
                                                $findtaskper_space = mysqli_query($conn, "SELECT * FROM task WHERE task_assign_to = ''");
                                            }
                                            else if($filterby == "Today")
                                            {   
                                                $filter = date("Y-m-d");
                                                $findtaskper_space = mysqli_query($conn, "SELECT * FROM task WHERE task_assign_to = '' and task_date_created LIKE '%$filter%'");
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
                                                $findtaskper_space = mysqli_query($conn, "SELECT * FROM task WHERE task_assign_to = '' and task_date_created BETWEEN '$from' AND '$to'");
                                            }
                                            else if($filterby == "This Month")
                                            {
                                                $filter = date("Y-m");
                                                $findtaskper_space = mysqli_query($conn, "SELECT * FROM task WHERE task_assign_to = '' and task_date_created LIKE '%$filter%'");
                                            }
                                            else if($filterby == "This Year")
                                            {
                                                $filter = date("Y");
                                                $findtaskper_space = mysqli_query($conn, "SELECT * FROM task WHERE task_assign_to = '' and task_date_created LIKE '%$filter%'");
                                            }
                                            else if($filterby == "Custom Date")
                                            {                    
                                                $get_from = $_GET['From'];
                                                $get_to = $_GET['To'];
                                                $findtaskper_space = mysqli_query($conn, "SELECT * FROM task WHERE task_assign_to = '' and task_date_created BETWEEN '$get_from' AND '$get_to'");
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
                                            $findtaskper_space = mysqli_query($conn, "SELECT * FROM task WHERE task_assign_to = '' and task_date_created BETWEEN '$from' AND '$to'");
                                        }

                                        // $findtaskper_space = mysqli_query($conn, "SELECT * FROM task WHERE task_assign_to = ''");
                                        $count_for_space = 0;
                                        while($fetch_findtaskper_space = mysqli_fetch_array($findtaskper_space))
                                        { 
                                            $task_list_id = $fetch_findtaskper_space['task_list_id'];
                                            $select_list = mysqli_query($conn, "SELECT * FROM list WHERE list_id = '$task_list_id'");
                                            $fetch_array = mysqli_fetch_array($select_list);
                                            if($fetch_array['list_space_id'] == $space_id)
                                            {
                                                $count_for_space++;
                                            }
                                        }
                                        echo '
                                        <li>
                                            <a class="dropdown-item nav-submenu" data-toggle="nav-submenu" style="padding: 5px 0px;">
                                                <i class="fa fa-th-large text-secondary mr-1"></i>';
                                                    $new_name = substr($fetch_space['space_name'], 0, 18); // get specific character
                                                    if(strlen($fetch_space['space_name']) > 18)
                                                    {
                                                        echo '<span class="sidebar-mini-hide aaa" style="margin-left: 40px;" data-toggle="popover" title="'.$fetch_space['space_name'].'" data-placement="bottom">'.$new_name.'...</span>';
                                                    }
                                                    else
                                                    {
                                                        echo '<span class="sidebar-mini-hide aaa" style="margin-left: 40px;">'.$fetch_space['space_name'].'</span>';
                                                    }

                                                    if($count_for_space != 0)
                                                    {
                                                        echo '<span class="badge ml-5" style="background-color: #64b1a0; color: #fff;">'.number_format($count_for_space).'</span>';
                                                    }
                                                echo'
                                            </a>'
                                            ;

                                            //query for filtering data
                                            if (isset($_GET['filter']) or isset($get_from)) {
                                                $filterby = $_GET['filter'];
                                                
                                                if($filterby == "All")
                                                {                    
                                                    $find_list = mysqli_query($conn, "SELECT * FROM list INNER JOIN task ON task.task_list_id = list.list_id WHERE list_space_id = '$space_id' and task_assign_to = ''");
                                                }
                                                else if($filterby == "Today")
                                                {   
                                                    $filter = date("Y-m-d");
                                                    $find_list = mysqli_query($conn, "SELECT * FROM list INNER JOIN task ON task.task_list_id = list.list_id WHERE list_space_id = '$space_id' and task_assign_to = '' and task_date_created LIKE '%$filter%'");
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
                                                    $find_list = mysqli_query($conn, "SELECT * FROM list INNER JOIN task ON task.task_list_id = list.list_id WHERE list_space_id = '$space_id' and task_assign_to = '' and task_date_created BETWEEN '$from' AND '$to'");
                                                }
                                                else if($filterby == "This Month")
                                                {
                                                    $filter = date("Y-m");
                                                    $find_list = mysqli_query($conn, "SELECT * FROM list INNER JOIN task ON task.task_list_id = list.list_id WHERE list_space_id = '$space_id' and task_assign_to = '' and task_date_created LIKE '%$filter%'");
                                                }
                                                else if($filterby == "This Year")
                                                {
                                                    $filter = date("Y");
                                                    $find_list = mysqli_query($conn, "SELECT * FROM list INNER JOIN task ON task.task_list_id = list.list_id WHERE list_space_id = '$space_id' and task_assign_to = '' and task_date_created LIKE '%$filter%'");
                                                }
                                                else if($filterby == "Custom Date")
                                                {                    
                                                    $get_from = $_GET['From'];
                                                    $get_to = $_GET['To'];
                                                    $find_list = mysqli_query($conn, "SELECT * FROM list INNER JOIN task ON task.task_list_id = list.list_id WHERE list_space_id = '$space_id' and task_assign_to = '' and task_date_created BETWEEN '$get_from' AND '$get_to'");
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
                                                $find_list = mysqli_query($conn, "SELECT * FROM list INNER JOIN task ON task.task_list_id = list.list_id WHERE list_space_id = '$space_id' and task_assign_to = '' and task_date_created BETWEEN '$from' AND '$to' ORDER BY list_name ASC");
                                            }

                                            // $find_list = mysqli_query($conn, "SELECT * FROM list INNER JOIN task ON task.task_list_id = list.list_id WHERE list_space_id = '$space_id' ORDER BY list_name ASC");
                                            while($fetch_list = mysqli_fetch_array($find_list))
                                            {           
                                                $list_id = $fetch_list['list_id'];             
                                                $findtaskper_list= mysqli_query($conn, "SELECT * FROM task WHERE task_list_id = '$list_id' AND task_assign_to = ''");
                                                $list_count = mysqli_num_rows($findtaskper_list);
                                                echo'
                                                <ul>
                                                    <li>
                                                        <a class="dropdown-item nav-submenu" data-toggle="nav-submenu" style="padding: 5px 0px;">
                                                            <i class="fa fa-folder text-warning mr-1"></i>';
                                                            $new_name = substr($fetch_list['list_name'], 0, 17); // get specific character
                                                            if(strlen($fetch_list['list_name']) > 17)
                                                            {
                                                                echo '<span class="sidebar-mini-hide aaa" style="margin-left: 40px;" data-toggle="popover" title="'.$fetch_list['list_name'].'" data-placement="bottom">'.$new_name.'...</span>';
                                                            }
                                                            else
                                                            {
                                                                echo '<span class="sidebar-mini-hide aaa" style="margin-left: 40px;">'.$fetch_list['list_name'].'</span>';
                                                            }
                                                            if($list_count != 0)
                                                            {
                                                                echo '<span class="badge ml-5" style="background-color: #64b1a0; color: #fff;">'.number_format($list_count).'</span>';
                                                            }
                                                            echo'
                                                        </a>';
                                                        $find_status = mysqli_query($conn, "SELECT * FROM status WHERE status_list_id = '$list_id' ORDER BY status_order_no ASC");
                                                        while($fetch_status = mysqli_fetch_array($find_status))
                                                        {
                                                            $status_idss = $fetch_status['status_id'];
                                                            $findtaskper_status = mysqli_query($conn, "SELECT * FROM task WHERE task_status_id = '$status_idss' AND task_assign_to = '' ORDER BY task_name ASC");
                                                            $status_count = mysqli_num_rows($findtaskper_status);
                                                            echo'
                                                            <ul>
                                                                <li>
                                                                            <a class="dropdown-item nav-submenu" data-toggle="nav-submenu" style="padding: 5px 0px;">
                                                                                <i class="fa fa-square" style="color: '.$fetch_status['status_color'].';"></i>';
                                                                                $new_name = substr($fetch_status['status_name'], 0, 14); // get specific character
                                                                                if(strlen($fetch_status['status_name']) > 14)
                                                                                {
                                                                                    echo '<span class="sidebar-mini-hide aaa" style="margin-left: 40px;" data-toggle="popover" title="'.$fetch_status['status_name'].'" data-placement="bottom">'.$new_name.'...</span>';
                                                                                }
                                                                                else
                                                                                {
                                                                                    echo '<span class="sidebar-mini-hide aaa" style="margin-left: 40px;">'.$fetch_status['status_name'].'</span>';
                                                                                }
                                                                                if($status_count != 0)
                                                                                {
                                                                                    echo '<span class="badge ml-5" style="background-color: #64b1a0; color: #fff;">'.number_format($status_count).'</span>';
                                                                                }
                                                                                echo'
                                                                            </a>
                                                                            <ul style="border-left: 3px solid '.$fetch_status['status_color'].';">';
                                                                                while($result_findtaskper_status = mysqli_fetch_array($findtaskper_status))
                                                                                    {
                                                                                        echo '<li class="aaa bbb" >'.$result_findtaskper_status['task_name'].'</li>';
                                                                                    }                                                    
                                                                                echo'                                                
                                                                            </ul>
                                                                        </li>                                          
                                                            </ul>
                                                            ';
                                                        }
                                                        echo'
                                                    </li>                                            
                                                </ul>';
                                            }
                                        echo'
                                        </li>';
                                    }
                                ?>
                                </ul>