<?php 
	session_start();
	include("../conn.php");

	if (isset($_POST['show_steps'])) {
		
		$space_id = $_POST['space_id'];
		$user_id = $_POST['user_id'];
		$final_status_id = $_POST['final_status_id'];
		$md_body = $_POST['md_body'];
		$i = $_POST['i'];

		// <script src="../assets/js/plugins/datatables/jquery.dataTables.min.js"></script>
  //       <script src="../assets/js/plugins/datatables/dataTables.bootstrap4.min.js"></script>
  //       <script src="../assets/js/pages/be_tables_datatables.min.js"></script>


		echo '
		
		

		<table class="table table-striped table-hover table-bordered table-vcenter js-dataTable-full '.$md_body.'">
                    <thead>
                        <tr>
                            <th class="text-center">Task</th>
                            <th>NAME</th>
                            <th class="d-none d-sm-table-cell">DUE</th>
                            <th>PRIORITY</th>
                            <th class="d-none d-sm-table-cell text-center">ASSIGN</th>

		';
		$select_db_tb_column = mysqli_query($conn, "SELECT * FROM add_column WHERE column_space_id = '$space_id' AND column_user_id = '$user_id'");
                                while($fetch_select_column = mysqli_fetch_array($select_db_tb_column))
                                {
                                    $col_name = $fetch_select_column['column_name'];
                                    $select_tb_field = mysqli_query($conn, "SELECT * FROM field WHERE field_space_id ='$space_id' AND field_col_name = '$col_name'");
                                    $fetch_name = mysqli_fetch_array($select_tb_field);

                                    $field_name = $fetch_name['field_name']; // get the name
                                    echo '<th class="d-none d-sm-table-cell text-center">'.$field_name.'</th>';
                                }
                                echo '</tr>
                    </thead> <tbody>';
		// ------------------------------------------------ for counting total filter
    $find_space_id_in_filter = mysqli_query($conn, "SELECT * FROM filter WHERE filter_space_id='$space_id' AND filter_user_id='$user_id' AND filter_name != 'status'");
    if(mysqli_num_rows($find_space_id_in_filter) == 0)
    {
        $findtask = mysqli_query($conn, "SELECT * FROM task WHERE task_status_id = '$final_status_id' ORDER BY task_priority DESC"); 
    }
    else 
    {
        $datecreated = "";
        $duedate = "";
        $priority = "";
        if(mysqli_num_rows($filter_date_created) == 1)
        {
            if($filter_value_created == "Today")
            {
                $cur = date("Y-m-d");
                $datecreated = "AND task_date_created LIKE '%".$cur."%'";
            }
            else if($filter_value_created == "This week")
            {
                $dt = new DateTime();
                $dates = []; 
                for ($d = 1; $d <= 7; $d++) {
                    $dt->setISODate($dt->format('o'), $dt->format('W'), $d);
                    $weekdate = ($dates[$dt->format('D')] = $dt->format('Y-m-d'));
                }
                $from = current($dates);
                $to = end($dates);
                $datecreated = "AND task_date_created BETWEEN '".$from."' AND '".$to."'";
            }
            else if($filter_value_created == "This month")
            {
                $cur = date("Y-m");
                $datecreated = "AND task_date_created LIKE '%".$cur."%'";
            }
            else
            {
                $from = substr($filter_value_created, -21, 10);
                $to = substr($filter_value_created, -10, 10);
                $datecreated = "AND task_date_created BETWEEN '".$from."' AND '".$to."'";
            }
        }
        if(mysqli_num_rows($filter_due_date) == 1)
        {
            if($filter_value_due_date == "Today")
            {
                $cur = date("Y-m-d");
                $duedate = "AND task_due_date LIKE '%".$cur."%'";
            }
            else if($filter_value_due_date == "This week")
            {
                $dt = new DateTime();
                $dates = []; 
                for ($d = 1; $d <= 7; $d++) {
                    $dt->setISODate($dt->format('o'), $dt->format('W'), $d);
                    $weekdate = ($dates[$dt->format('D')] = $dt->format('Y-m-d'));
                }
                $from = current($dates);
                $to = end($dates);
                $duedate = "AND task_due_date BETWEEN '".$from."' AND '".$to."'";
            }
            else
            {
                $cur = date("Y-m");
                $duedate = "AND task_due_date LIKE '%".$cur."%'";
            }
        }
        if(mysqli_num_rows($filter_priority) == 1)
        {
            if($filter_value_priority == "Urgent")
            {
                $task_priority = "D Urgent";
                $priority = "AND task_priority = '".$task_priority."'";
            }
            else if($filter_value_priority == "High")
            {
                $task_priority = "C High";
                $priority = "AND task_priority = '".$task_priority."'";
            }
            else if($filter_value_priority == "Normal")
            {
                $task_priority = "B Normal";
                $priority = "AND task_priority = '".$task_priority."'";
            }
            else if($filter_value_priority == "Low")
            {
                $task_priority = "A Low";
                $priority = "AND task_priority = '".$task_priority."'";
            }
            else
            {}
        }

        // get task base on filter cobination

        $findtask = mysqli_query($conn, "SELECT * FROM task WHERE task_status_id = '$final_status_id' 
            $datecreated 
            $duedate
            $priority
            ORDER BY task_priority DESC");
    }
//_______________________________ END FILTER
    						$total_task = mysqli_num_rows($findtask);
    						echo 'Total Task: '.number_format($total_task).'';
                            //$findtask = mysqli_query($conn, "SELECT * FROM task WHERE task_status_id = '$final_status_id' ORDER BY task_priority DESC"); 
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

  
                                    $task_tag = $result_findstatus['task_tag']; //get the user_id ex. string = "1,2,3,4,5"
                                    $assign_task_tag = explode(",", $task_tag); // eleminate the ","/ comma sign and insert to array ex. [1,2,3,4,5]

                                    $task_assign = $result_findstatus['task_assign_to']; //get the user_id ex. string = "1,2,3,4,5"
                                    $assign_task_assign = explode(",", $task_assign); // eleminate the ","/ comma sign and insert to array ex. [1,2,3,4,5]

                                    $select_space = mysqli_query($conn, "SELECT * FROM space WHERE space_id = '$space_id'"); 
                                    $fetch_select_space = mysqli_fetch_array($select_space);
                                    $space_db_name = $fetch_select_space['space_db_table']; // get the specific space db_name
                                    $select_col_in_space_db = mysqli_query($conn, "SELECT * FROM $space_db_name WHERE task_id = '$task_id'");
                                    $fetch_col_in_space_db = mysqli_fetch_array($select_col_in_space_db);

                                    $filter_tag = mysqli_query($conn, "SELECT * FROM filter WHERE filter_space_id = '$space_id' AND filter_user_id = '$user_id' AND filter_name = 'tag'");
                                    $filter_assign = mysqli_query($conn, "SELECT * FROM filter WHERE filter_space_id = '$space_id' AND filter_user_id = '$user_id' AND filter_name = 'assign'");
                                    $filter_field = mysqli_query($conn, "SELECT * FROM filter WHERE filter_space_id = '$space_id' AND filter_user_id = '$user_id' AND filter_name = 'field'");
                                    
                                    if(mysqli_num_rows($filter_tag) == 1)
                                    {
                                        if (in_array($tag_filter_value, $assign_task_tag)) // echo if has user_id in db table "task": task_assign_to
                                        {	

                                            include('echo_task_list.php');
                                        }
                                    }
                                    else if(mysqli_num_rows($filter_assign) == 1)
                                    {
                                        if (in_array($assign_filter_value, $assign_task_assign)) // echo if has user_id in db table "task": task_assign_to
                                        {
                                            include('echo_task_list.php');
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
                                                include('echo_task_list.php');
                                            }
                                        }
                                        else // If field_type = dropdown || radio
                                        {                                            
                                            $field_value = $value_array[0]; // get only the id
                                            $field_col_name = $value_array[1]; // get field column name
                                            $field_type = $value_array[2]; // get field type

                                            if($fetch_col_in_space_db[''.$field_col_name.''] == $field_value)
                                            {
                                                include('echo_task_list.php');
                                            }
                                        }
                                    }
                                    else
                                    {
                                        include('echo_task_list.php');
                                    }
                                }
                            }
                            echo '</tbody>
                </table>';
                            mysqli_close($conn);
	}
 ?>