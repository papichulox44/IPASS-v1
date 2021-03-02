<style type="text/css">

tbody > tr:hover {

    cursor: pointer;

}

</style>

<?php

    $a = 1;

    $b = 1;

    $c = 1;

    $d = 1;

    $e = 1;



//_______________________________ FILTER STATUS Query

    $filter_status = mysqli_query($conn, "SELECT * FROM filter WHERE filter_space_id = '$space_id' AND filter_user_id = '$user_id' AND filter_name = 'status'");

    if(mysqli_num_rows($filter_status) != 0)

    {

        $filter_status_id_array = 'status_id = '.implode(" OR status_id = ", $status_array).'';

        $findstatus = mysqli_query($conn, "SELECT * FROM status WHERE status_list_id = '$status_list_id' AND $filter_status_id_array");

    }

    else

    {

        // $findstatus = mysqli_query($conn, "SELECT * FROM status WHERE status_list_id = '$status_list_id' ORDER BY status_order_no ASC");
        echo '
        <div class="text-center"></div>
        <div class="text-center">
        <img src="./services.gif">
        </div>
        '; 

    }

//_______________________________ END FILTER STATUS Query



    while($result_findstatus = mysqli_fetch_array($findstatus))

    {

        /*$status_name = $result_findstatus['status_name'];

        $que = mysqli_query($conn, "SELECT * FROM status WHERE status_name='$status_name' AND status_list_id='$status_list_id'");*/

        $status_id = $result_findstatus['status_id'];

        $que = mysqli_query($conn, "SELECT * FROM status WHERE status_id='$status_id' AND status_list_id='$status_list_id'");        

        $res = mysqli_fetch_array($que); 

        $final_status_id = $res['status_id'];



        $select_task = mysqli_query($conn, "SELECT * FROM task WHERE task_status_id = '$final_status_id' AND task_list_id = '$status_list_id'");

        $count = mysqli_num_rows($select_task);

        ?>

        <div class="block block-bordered block-rounded <?php echo $md_body; ?>" style="width: 100%; border-left: 5px solid <?php echo $result_findstatus['status_color'];?>; box-shadow: 0px 1px 1px 0px rgba(119, 119, 119, 0.35);-moz-box-shadow: 0px 1px 1px 0px rgba(119, 119, 119, 0.35);-webkit-box-shadow: 0px 1px 1px 0px rgba(119, 119, 119, 0.35);">

            <div class="block-header" role="tab" id="accordion2_h<?php echo $a++;?>">

                <span style="background-color: <?php echo $result_findstatus['status_color'];?>; padding: 3px 10px; border-radius: 3px;"><a class="font-w600" data-toggle="collapse" data-parent="#accordion2" href="#accordion2_q<?php echo $c++;?>" aria-expanded="true" aria-controls="accordion2_q<?php echo $d++;?>" style="color: #fff;"><?php echo $result_findstatus['status_name'];?></a>

                </span>

                <div class="block-options">

                    <!--<span class="btn btn-sm btn-secondary" style="background-color: <?php echo $result_findstatus['status_color'];?>; color: #fff;">

                        Task: <?php echo $count; ?>

                    </span>-->

                    <button type="button" class="btn btn-sm btn-secondary float-right" data-toggle="modal" data-target="#modal-add_task">

                        <i class="fa fa-plus text-success mr-5"></i>Add

                    </button>

                </div>

            </div>

            <div id="accordion2_q<?php echo $e++;?>" class="collapse cl show" role="tabpanel" aria-labelledby="accordion2_h<?php echo $b++;?>" style="width: 100%; padding:0px 20px 20px 20px;"> <!-- put "show" in class if you want an active-->
                <div style="overflow-x: scroll; width: 100%;">
                <table class="block table table-striped table-hover table-bordered table-vcenter js-dataTable-full <?php echo $md_body; ?>">

                    <thead>

                        <tr>

                            <th class="text-center">ID</th>

                            <th>NAME</th>

                            <th class="d-none d-sm-table-cell">DUE</th>

                            <th>PRIORITY</th>

                            <th class="d-none d-sm-table-cell text-center">Date Updated</th>

                            <th class="d-none d-sm-table-cell text-center">ASSIGN</th>

                            <?php

//_______________________________ auto create th

                                 $select_db_tb_column = mysqli_query($conn, "SELECT * FROM add_column WHERE column_space_id = '$space_id' AND column_user_id = '$user_id'");

                                while($fetch_select_column = mysqli_fetch_array($select_db_tb_column))

                                {

                                    $col_name = $fetch_select_column['column_name'];

                                    $select_tb_field = mysqli_query($conn, "SELECT * FROM field WHERE field_space_id ='$space_id' AND field_col_name = '$col_name'");

                                    $fetch_name = mysqli_fetch_array($select_tb_field);



                                    $field_name = $fetch_name['field_name']; // get the name

                                    /*$sub = substr($field_name, 0, 10); // get only 10 character

                                    $new_name = str_replace(" ", "_", $sub); // change space to "_"



                                    if(strlen($field_name) > 10)

                                    {

                                        echo '<th class="d-none d-sm-table-cell text-center" title="'.$field_name.'">'.$new_name.'...</th>';

                                    }

                                    else

                                    {

                                        echo '<th class="d-none d-sm-table-cell text-center">'.$new_name.'</th>';

                                    }*/

                                    echo '<th class="d-none d-sm-table-cell text-center">'.$field_name.'</th>';

                                }
//_______________________________ END auto create th

                            ?>

                        </tr>

                    </thead>

                    <tbody>

                        <?php


    // ------------------------------------------------ for counting total filter

    $find_space_id_in_filter = mysqli_query($conn, "SELECT * FROM filter WHERE filter_space_id='$space_id' AND filter_user_id='$user_id' AND filter_name != 'status'");

    if(mysqli_num_rows($find_space_id_in_filter) === 0)

    {

        $findtask = mysqli_query($conn, "SELECT * FROM task WHERE task_status_id = '$final_status_id' ORDER BY task_priority DESC"); 

    }

    else 

    {

        $datecreated = '';
        $duedate = '';
        $priority = '';
        if(mysqli_num_rows($filter_date_created) === 1)
        {
            if($filter_value_created === 'Today')
            {
                $cur = date('Y-m-d');
                $datecreated = "AND task_date_created LIKE '%".$cur."%'";
            }
            else if($filter_value_created === 'This week')
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
            else if($filter_value_created === 'This month')
            {
                $cur = date('Y-m');
                $datecreated = "AND task_date_created LIKE '%".$cur."%'";
            }
            else
            {
                $from = substr($filter_value_created, -21, 10);
                $to = substr($filter_value_created, -10, 10);
                $datecreated = "AND task_date_created BETWEEN '".$from."' AND '".$to."'";
            }
        }
        if(mysqli_num_rows($filter_due_date) === 1)
        {
            if($filter_value_due_date === 'Today')
            {
                $cur = date('Y-m-d');
                $duedate = "AND task_due_date LIKE '%".$cur."%'";
            }
            else if($filter_value_due_date === 'This week')
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
                // $cur = date("Y-m");
                // $duedate = "AND task_due_date LIKE '%".$cur."%'";
                $from = substr($filter_value_due_date, -21, 10);
                $to = substr($filter_value_due_date, -10, 10);
                $duedate = "AND task_due_date BETWEEN '".$from."' AND '".$to."'";
            }
        }
        if(mysqli_num_rows($filter_priority) === 1)
        {
            if($filter_value_priority === 'Urgent')
            {
                $task_priority = 'D Urgent';
                $priority = "AND task_priority = '".$task_priority."'";
            }
            else if($filter_value_priority === 'High')
            {
                $task_priority = 'C High';
                $priority = "AND task_priority = '".$task_priority."'";
            }
            else if($filter_value_priority === 'Normal')
            {
                $task_priority = 'B Normal';
                $priority = "AND task_priority = '".$task_priority."'";
            }
            else if($filter_value_priority === 'Low')
            {
                $task_priority = 'A Low';
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


                            //$findtask = mysqli_query($conn, "SELECT * FROM task WHERE task_status_id = '$final_status_id' ORDER BY task_priority DESC"); 

                            while($result_findstatus = mysqli_fetch_array($findtask))

                            {

                                $task_id = $result_findstatus['task_id'];

                                $total_assign_to = $result_findstatus['task_assign_to']; //get the user_id ex. string = "1,2,3,4,5"

                                $assign_to_array = explode(",", $total_assign_to); // eleminate the ","/ comma sign and insert to array ex. [1,2,3,4,5]

                                $count_assign_to =  count($assign_to_array);

                                $date_today = date('Y-m-d');

                                $due_date_time = $result_findstatus['task_due_date']; // ex: 2020-12-10 00:00:00

                                $ymd = substr($due_date_time, -19, 10); // 2020-12-10 00:00:00 // Y-m-d = 2020-12-10 00

                                // $get_month = substr($due_date_time, -14, 2); // 2020-12-10 00:00:00 // get only month = 12

                                // $get_date = substr($due_date_time, -11, 2); // 2020-12-10 00:00:00 // get only date = 10

                                // $hm = substr($due_date_time, -8, 5); // 2020-12-10 00:00:00 // get only date = 10

                                // $am_or_pm = date("A", strtotime($due_date_time));

                                // $array_avv = array(array('01' => 'Jan','02' => 'Feb','03' => 'Mar','04' => 'Apr','05' => 'May','06' => 'Jun','07' => 'Jul','08' => 'Aug','09' => 'Sep','10' => 'Oct','11' => 'Nov','12' => 'Dec')); // array with key and value ex. key=01 and value="Jan"...

                                // $month = array_column($array_avv, $get_month); // Get the value of specific key ex: key=02 then value="Feb" 

                                // $month_avv = implode( "", $month ); // Convert array to string

                                $today = date('Y-m-d'); // Get current date

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

                        ?>

                    </tbody>

                </table>

                </div>

            </div>

        </div>

    <?php

    }

?> 