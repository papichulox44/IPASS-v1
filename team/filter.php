<?php
    //echo "<script type='text/javascript'>alert('Low');</script>";
	/*$find_space_id_in_filter = mysqli_query($conn, "SELECT * FROM filter WHERE filter_space_id='$space_id' AND filter_user_id='$user_id'");
    $res_find_space_id_in_filter = mysqli_fetch_array($find_space_id_in_filter);
    $filter_name = $res_find_space_id_in_filter['filter_name'];
    $filter_value = $res_find_space_id_in_filter['filter_value'];*/

    $find_space_id_in_filter = mysqli_query($conn, "SELECT * FROM filter WHERE filter_space_id='$space_id' AND filter_user_id='$user_id' AND filter_name != 'status'");

    $find_space_id_in_sort = mysqli_query($conn, "SELECT * FROM sort WHERE sort_space_id='$space_id' AND sort_user_id='$user_id'");
    $array_fetch = mysqli_fetch_array($find_space_id_in_sort);
    $sort_name = $array_fetch['sort_name'];
    $sort_type = $array_fetch['sort_type'];

    // _____________________________________SORT CONDITION_____________________________________
    if($sort_name == "Date Created")
    {
        $name = "task_date_created";
    }
    else if($sort_name == "Due Date")
    {
        $name = "task_due_date";
    }
    else if($sort_name == "Priority")
    {
        $name = "task_priority";
    }
    else if($sort_name == "Task Name")
    {
        $name = "task_name";
    }
    else
    {
        $name = "task_priority";
    }

    if($sort_type == "Ascending")
    {
        $sort = "ASC";
    }
    else
    {
        $sort = "DESC";
    }
    // _____________________________________END SORT CONDITION_____________________________________

    
    if(mysqli_num_rows($find_space_id_in_filter) == 0)
    {
        $findtask = mysqli_query($conn, "SELECT * FROM task WHERE task_status_id = '$final_status_id' ORDER BY $name $sort"); 
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
        $findtask = mysqli_query($conn, "SELECT * FROM task WHERE task_status_id = '$final_status_id' 
            $datecreated 
            $duedate
            $priority
            ORDER BY $name $sort");
	}
    include('fetch_task.php');
?>