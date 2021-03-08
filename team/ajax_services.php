<?php
	session_start();
	include("../conn.php");

	if (isset($_POST['show_steps'])) {

		$space_id = $_POST['space_id'];
		$user_id = $_POST['user_id'];
		$final_status_id = $_POST['final_status_id'];
		$md_body = $_POST['md_body'];
        $i = $_POST['i'];
        $j = $_POST['j'];
        $k = $_POST['k'];
        $l = $_POST['l'];
        $limit = $_POST['limit'];
        $start = $_POST['start'];


        //--------------- datecreated query
        $filter_date_created = mysqli_query($conn, "SELECT * FROM filter WHERE filter_space_id = '$space_id' AND filter_user_id = '$user_id' AND filter_name = 'datecreated'");
        $fetch_filter_date_created = mysqli_fetch_array($filter_date_created);
        $filter_value_created = $fetch_filter_date_created['filter_value'];

        //--------------- duedate query
        $filter_due_date = mysqli_query($conn, "SELECT * FROM filter WHERE filter_space_id = '$space_id' AND filter_user_id = '$user_id' AND filter_name = 'duedate'");
        $fetch_filter_due_date = mysqli_fetch_array($filter_due_date);
        $filter_value_due_date = $fetch_filter_due_date['filter_value'];

        //--------------- priority query
        $filter_priority = mysqli_query($conn, "SELECT * FROM filter WHERE filter_space_id = '$space_id' AND filter_user_id = '$user_id' AND filter_name = 'priority'");
        $fetch_filter_priority = mysqli_fetch_array($filter_priority);
        $filter_value_priority = $fetch_filter_priority['filter_value'];

		// ------------------------------------------------ for counting total filter
    $find_space_id_in_filter = mysqli_query($conn, "SELECT * FROM filter WHERE filter_space_id='$space_id' AND filter_user_id='$user_id' AND filter_name != 'status'");
    if(mysqli_num_rows($find_space_id_in_filter) === 0)
    {
        $findtask = mysqli_query($conn, "SELECT * FROM task WHERE task_status_id = '$final_status_id' LIMIT $start, $limit");
        $count_task = mysqli_query($conn, "SELECT Count(task.task_id) AS final_total_task FROM task WHERE task_status_id = '$final_status_id'");
        $data = mysqli_fetch_assoc($count_task);
        $final_total_task = $data['final_total_task'];
    }
    else
    {
        $datecreated = "";
        $duedate = "";
        $priority = "";
        if(mysqli_num_rows($filter_date_created) === 1)
        {
            if($filter_value_created === "Today")
            {
                $cur = date("Y-m-d");
                $datecreated = "AND task_date_created LIKE '%".$cur."%'";
            }
            else if($filter_value_created === "This week")
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
            else if($filter_value_created === "This month")
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
        if(mysqli_num_rows($filter_due_date) === 1)
        {
            if($filter_value_due_date === "Today")
            {
                $cur = date("Y-m-d");
                $duedate = "AND task_due_date LIKE '%".$cur."%'";
            }
            else if($filter_value_due_date === "This week")
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
            else if($filter_value_due_date === "This month")
            {
                $cur = date("Y-m");
                $duedate = "AND task_due_date LIKE '%".$cur."%'";
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
            if($filter_value_priority === "Urgent")
            {
                $task_priority = "D Urgent";
                $priority = "AND task_priority = '".$task_priority."'";
            }
            else if($filter_value_priority === "High")
            {
                $task_priority = "C High";
                $priority = "AND task_priority = '".$task_priority."'";
            }
            else if($filter_value_priority === "Normal")
            {
                $task_priority = "B Normal";
                $priority = "AND task_priority = '".$task_priority."'";
            }
            else if($filter_value_priority === "Low")
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
            LIMIT $start, $limit");

        $count_task = mysqli_query($conn, "SELECT Count(task.task_id) AS final_total_task FROM task WHERE task_status_id = '$final_status_id'
            $datecreated
            $duedate
            $priority");
        $data = mysqli_fetch_assoc($count_task);
        $final_total_task = $data['final_total_task'];
    }
//_______________________________ END FILTER

                            $count = 1;
                            while($result_findstatus = mysqli_fetch_array($findtask))
                            {
                                $task_id = $result_findstatus['task_id'];
                                $total_assign_to = $result_findstatus['task_assign_to']; //get the user_id ex. string = "1,2,3,4,5"
                                $assign_to_array = explode(",", $total_assign_to); // eleminate the ","/ comma sign and insert to array ex. [1,2,3,4,5]
                                $count_assign_to =  count($assign_to_array);

                                $date_today = date('Y-m-d');
                                $due_date_time = $result_findstatus['task_due_date']; // ex: 2020-12-10 00:00:00
                                $ymd = substr($due_date_time, -19, 10); // 2020-12-10 00:00:00 // Y-m-d = 2020-12-10 00
                                $today = date("Y-m-d"); // Get current date
																$tomorrow = date('Y-m-d', strtotime(' +1 day')); // Get tomorrow date
																$tomorrow2 = date('Y-m-d', strtotime(' +2 day'));
																$tomorrow3 = date('Y-m-d', strtotime(' +3 day'));
																$tomorrow4 = date('Y-m-d', strtotime(' +4 day'));
																$tomorrow5 = date('Y-m-d', strtotime(' +5 day'));
                                $tomorrow6 = date('Y-m-d', strtotime(' +6 day'));


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
                                $fetch_filter_tag = mysqli_fetch_array($filter_tag);
                                $tag_filter_value = $fetch_filter_tag['filter_value'];
                                $filter_assign = mysqli_query($conn, "SELECT * FROM filter WHERE filter_space_id = '$space_id' AND filter_user_id = '$user_id' AND filter_name = 'assign'");
                                $fetch_filter_assign = mysqli_fetch_array($filter_assign);
                                $assign_filter_value = $fetch_filter_assign['filter_value'];
                                $filter_field = mysqli_query($conn, "SELECT * FROM filter WHERE filter_space_id = '$space_id' AND filter_user_id = '$user_id' AND filter_name = 'field'");
                                $fetch_filter_field = mysqli_fetch_array($filter_field);
                                $field_filter_value = $fetch_filter_field['filter_value'];

                                if(mysqli_num_rows($filter_tag) === 1)
                                {
                                    if (in_array($tag_filter_value, $assign_task_tag)) // echo if has user_id in db table "task": task_assign_to
                                    {

                                        include('echo_task_list.php');
                                    }
                                }
                                else if(mysqli_num_rows($filter_assign) === 1)
                                {
                                    if (in_array($assign_filter_value, $assign_task_assign)) // echo if has user_id in db table "task": task_assign_to
                                    {
                                        include('echo_task_list.php');
                                    }
                                }
                                else if(mysqli_num_rows($filter_field) === 1)
                                {
                                    $value_array = explode(",,", $field_filter_value); // convert string to array
                                    if(count($value_array) == 1) // Normal field | textarea,text,email,phone,date,number
                                    {
                                        if($fetch_col_in_space_db[''.$field_filter_value.''] === "" || $fetch_col_in_space_db[''.$field_filter_value.''] === "0000-00-00") // check if task has no value in specific column OR a default value "0000-00-00" which is a date
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

                                        if($fetch_col_in_space_db[''.$field_col_name.''] === $field_value)
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

    echo '
        <script>
            var seen'.$l.' = {};
            table = document.getElementById("service_list'.$l.'");
            tr = table.getElementsByTagName("tr");
            for (i = 0; i < tr.length; i++) {
                td = tr[i].getElementsByTagName("td")[0];
                if (seen'.$l.'[td.textContent]) {
                    tr[i].remove();
                } else {
                    seen'.$l.'[td.textContent]=true;
                }
            }

            temp_total = document.getElementById("total_task'.$j.'").innerHTML;
            var rowCountTotal = $("#service_list'.$l.' tr:visible").length;
            if(temp_total === "0"){
                document.getElementById("total_task'.$j.'").innerHTML = 10;
                } else {
                document.getElementById("total_task'.$j.'").innerHTML = rowCountTotal;
                }
             document.getElementById("final_total_task'.$j.'").innerHTML = '.$final_total_task .';

            $(document).ready(function(){
              $("#myInput'.$k.'").on("keyup", function() {
                var inputlength = this.value.length;
                var value = $(this).val();
                $("#service_list'.$l.' tr").filter(function() {
                    var rowCount = $("#service_list'.$l.' tr:visible").length;
                    if(inputlength == "0"){
                        document.getElementById("total_search'.$j.'").innerHTML = 0;
                        document.getElementById("total_task'.$j.'").innerHTML = rowCount;
                       var seen'.$l.' = {};
                        table = document.getElementById("service_list'.$l.'");
                        tr = table.getElementsByTagName("tr");
                        for (i = 0; i < tr.length; i++) {
                            td = tr[i].getElementsByTagName("td")[0];
                            if (seen'.$l.'[td.textContent]) {
                                tr[i].remove();
                            } else {
                                seen'.$l.'[td.textContent]=true;
                            }
                        }


                    } else {
                        document.getElementById("total_search'.$j.'").innerHTML = rowCount;
                    }
                  $(this).toggle($(this).text().indexOf(value) > -1)

                });
              });
            });


        document.getElementById("myInput'.$k.'").onkeypress = function(event){
            if (event.keyCode == 13 || event.which == 13){
								var custom_field = document.getElementById("custom_field'.$k.'").value;
                var myInput = document.getElementById("myInput'.$k.'").value;
                var search_value = document.getElementById("search_value'.$k.'").value;
                array = search_value.split(",")
                space_id = array[0];
                user_id = array[1];
                final_status_id = array[2];
                md_body = array[3];
                t = array[4];

                $.ajax({
                    url: "ajax_services.php",
                    type: "POST",
                    async: false,
                    data:{
                        space_id: space_id,
                        user_id:user_id,
                        final_status_id: final_status_id,
                        md_body: md_body,
                        t: t,
                        myInput: myInput,
												custom_field: custom_field,
                        show_search:1,
                    },
                    cache:false,
                    success: function(data){
                        $("#service_list'.$k.'").append(data);
                    }
                });

            }
        };
        </script>
        ';
	}

    if (isset($_POST['show_search'])) {

        $space_id = $_POST['space_id'];
        $user_id = $_POST['user_id'];
        $final_status_id = $_POST['final_status_id'];
        $md_body = $_POST['md_body'];
        $t = $_POST['t'];
				$myInput = $_POST['myInput'];
        $custom_field = $_POST['custom_field'];

        //--------------- datecreated query
        $filter_date_created = mysqli_query($conn, "SELECT * FROM filter WHERE filter_space_id = '$space_id' AND filter_user_id = '$user_id' AND filter_name = 'datecreated'");
        $fetch_filter_date_created = mysqli_fetch_array($filter_date_created);
        $filter_value_created = $fetch_filter_date_created['filter_value'];

        //--------------- duedate query
        $filter_due_date = mysqli_query($conn, "SELECT * FROM filter WHERE filter_space_id = '$space_id' AND filter_user_id = '$user_id' AND filter_name = 'duedate'");
        $fetch_filter_due_date = mysqli_fetch_array($filter_due_date);
        $filter_value_due_date = $fetch_filter_due_date['filter_value'];

        //--------------- priority query
        $filter_priority = mysqli_query($conn, "SELECT * FROM filter WHERE filter_space_id = '$space_id' AND filter_user_id = '$user_id' AND filter_name = 'priority'");
        $fetch_filter_priority = mysqli_fetch_array($filter_priority);
        $filter_value_priority = $fetch_filter_priority['filter_value'];

        // ------------------------------------------------ for counting total filter
    $find_space_id_in_filter = mysqli_query($conn, "SELECT * FROM filter WHERE filter_space_id='$space_id' AND filter_user_id='$user_id' AND filter_name != 'status'");
    if(mysqli_num_rows($find_space_id_in_filter) === 0)
    {
			if ($custom_field === '') {
				if ($myInput === 'No Due Date') {
					$findtask = mysqli_query($conn, "SELECT * FROM task WHERE task_status_id = '$final_status_id' AND task_due_date is null");
						}
				else if ($myInput === 'Overdue'){
					$overdue = date('Y-m-d', strtotime(' -1 day'));
					$start = '2020-01-01';
					$findtask = mysqli_query($conn, "SELECT * FROM task WHERE task_status_id = '$final_status_id' AND task_due_date BETWEEN '".$start."' AND '".$overdue."'");
				}
				else if ($myInput === 'Today'){
					$today = date('Y-m-d');
					$findtask = mysqli_query($conn, "SELECT * FROM task WHERE task_status_id = '$final_status_id' AND task_due_date = '$today'");
				}
				else if ($myInput === 'Tomorrow'){
					$tomorrow = date('Y-m-d', strtotime(' +1 day'));
					$findtask = mysqli_query($conn, "SELECT * FROM task WHERE task_status_id = '$final_status_id' AND task_due_date = '$tomorrow'");
				}
				else {
					$findtask = mysqli_query($conn, "SELECT * FROM task WHERE task_status_id = '$final_status_id' AND task_name LIKE '%$myInput%'");
				}
			} else {
				$select_space = mysqli_query($conn, "SELECT * FROM space WHERE space_id = '$space_id'");
				$fetch_tb_name = mysqli_fetch_array($select_space);
				$space_tb_name = $fetch_tb_name['space_db_table']; // get the table name of the space

				$select_field = mysqli_query($conn, "SELECT * FROM field WHERE field_col_name = '$custom_field'");
				$result_field = mysqli_fetch_array($select_field);
				$field_type = $result_field['field_type'];
				if ($field_type === 'Dropdown') {
					$select_child_id = mysqli_query($conn, "SELECT child.child_id FROM field INNER JOIN child ON child.child_field_id = field.field_id WHERE field.field_col_name = '$custom_field' AND child.child_name LIKE '%$myInput%'");
					$data =  mysqli_fetch_assoc($select_child_id);
					$input = $data['child_id'];
					$findtask = mysqli_query($conn, "SELECT * FROM task INNER JOIN $space_tb_name ON $space_tb_name.task_id = task.task_id WHERE task.task_status_id = '$final_status_id' AND $space_tb_name.$custom_field = $input");
				} else {
					$findtask = mysqli_query($conn, "SELECT * FROM task INNER JOIN $space_tb_name ON $space_tb_name.task_id = task.task_id WHERE task.task_status_id = '$final_status_id' AND $space_tb_name.$custom_field LIKE '%$myInput%'");
				}
			}
    }
    else
    {
        $datecreated = "";
        $duedate = "";
        $priority = "";
        if(mysqli_num_rows($filter_date_created) === 1)
        {
            if($filter_value_created === "Today")
            {
                $cur = date("Y-m-d");
                $datecreated = "AND task_date_created LIKE '%".$cur."%'";
            }
            else if($filter_value_created === "This week")
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
            else if($filter_value_created === "This month")
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
        if(mysqli_num_rows($filter_due_date) === 1)
        {
            if($filter_value_due_date === "Today")
            {
                $cur = date("Y-m-d");
                $duedate = "AND task_due_date LIKE '%".$cur."%'";
            }
            else if($filter_value_due_date === "This week")
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
            else if($filter_value_due_date === "This month")
            {
                $cur = date("Y-m");
                $duedate = "AND task_due_date LIKE '%".$cur."%'";
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
            if($filter_value_priority === "Urgent")
            {
                $task_priority = "D Urgent";
                $priority = "AND task_priority = '".$task_priority."'";
            }
            else if($filter_value_priority === "High")
            {
                $task_priority = "C High";
                $priority = "AND task_priority = '".$task_priority."'";
            }
            else if($filter_value_priority === "Normal")
            {
                $task_priority = "B Normal";
                $priority = "AND task_priority = '".$task_priority."'";
            }
            else if($filter_value_priority === "Low")
            {
                $task_priority = "A Low";
                $priority = "AND task_priority = '".$task_priority."'";
            }
            else
            {}
        }


        // get task base on filter cobination
				if ($custom_field === '') {
					$findtask = mysqli_query($conn, "SELECT * FROM task WHERE task_status_id = '$final_status_id' $datecreated $duedate $priority AND task_name LIKE '%$myInput%'");
				} else {
					$select_space = mysqli_query($conn, "SELECT * FROM space WHERE space_id = '$space_id'");
					$fetch_tb_name = mysqli_fetch_array($select_space);
					$space_tb_name = $fetch_tb_name['space_db_table']; // get the table name of the space

					$select_field = mysqli_query($conn, "SELECT * FROM field WHERE field_col_name = '$custom_field'");
					$result_field = mysqli_fetch_array($select_field);
					$field_type = $result_field['field_type'];
					if ($field_type === 'Dropdown') {
						$select_child_id = mysqli_query($conn, "SELECT child.child_id FROM field INNER JOIN child ON child.child_field_id = field.field_id WHERE field.field_col_name = '$custom_field' AND child.child_name LIKE '%$myInput%'");
						$data =  mysqli_fetch_assoc($select_child_id);
						$input = $data['child_id'];
						$findtask = mysqli_query($conn, "SELECT * FROM task INNER JOIN $space_tb_name ON $space_tb_name.task_id = task.task_id WHERE task.task_status_id = '$final_status_id' $datecreated $duedate $priority AND $space_tb_name.$custom_field = $input");
					} else {
						$findtask = mysqli_query($conn, "SELECT * FROM task INNER JOIN $space_tb_name ON $space_tb_name.task_id = task.task_id WHERE task.task_status_id = '$final_status_id' $datecreated $duedate $priority AND $space_tb_name.$custom_field LIKE '%$myInput%'");
					}
				}
    }
//_______________________________ END FILTER
        while($result_findstatus = mysqli_fetch_array($findtask))
        {
            $task_id = $result_findstatus['task_id'];
            $total_assign_to = $result_findstatus['task_assign_to']; //get the user_id ex. string = "1,2,3,4,5"
            $assign_to_array = explode(",", $total_assign_to); // eleminate the ","/ comma sign and insert to array ex. [1,2,3,4,5]
            $count_assign_to =  count($assign_to_array);

            $date_today = date('Y-m-d');
            $due_date_time = $result_findstatus['task_due_date']; // ex: 2020-12-10 00:00:00
            $ymd = substr($due_date_time, -19, 10); // 2020-12-10 00:00:00 // Y-m-d = 2020-12-10 00
            $today = date("Y-m-d"); // Get current date
            $tomorrow = date('Y-m-d', strtotime(' +1 day')); // Get tomorrow date
						$tomorrow2 = date('Y-m-d', strtotime(' +2 day'));
						$tomorrow3 = date('Y-m-d', strtotime(' +3 day'));
						$tomorrow4 = date('Y-m-d', strtotime(' +4 day'));
						$tomorrow5 = date('Y-m-d', strtotime(' +5 day'));
						$tomorrow6 = date('Y-m-d', strtotime(' +6 day'));

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
            $fetch_filter_tag = mysqli_fetch_array($filter_tag);
            $tag_filter_value = $fetch_filter_tag['filter_value'];
            $filter_assign = mysqli_query($conn, "SELECT * FROM filter WHERE filter_space_id = '$space_id' AND filter_user_id = '$user_id' AND filter_name = 'assign'");
            $fetch_filter_assign = mysqli_fetch_array($filter_assign);
            $assign_filter_value = $fetch_filter_assign['filter_value'];
            $filter_field = mysqli_query($conn, "SELECT * FROM filter WHERE filter_space_id = '$space_id' AND filter_user_id = '$user_id' AND filter_name = 'field'");
            $fetch_filter_field = mysqli_fetch_array($filter_field);
            $field_filter_value = $fetch_filter_field['filter_value'];

            if(mysqli_num_rows($filter_tag) === 1)
            {
                if (in_array($tag_filter_value, $assign_task_tag)) // echo if has user_id in db table "task": task_assign_to
                {

                    include('echo_task_list.php');
                }
            }
            else if(mysqli_num_rows($filter_assign) === 1)
            {
                if (in_array($assign_filter_value, $assign_task_assign)) // echo if has user_id in db table "task": task_assign_to
                {
                    include('echo_task_list.php');
                }
            }
            else if(mysqli_num_rows($filter_field) === 1)
            {
                $value_array = explode(",,", $field_filter_value); // convert string to array
                if(count($value_array) == 1) // Normal field | textarea,text,email,phone,date,number
                {
                    if($fetch_col_in_space_db[''.$field_filter_value.''] === "" || $fetch_col_in_space_db[''.$field_filter_value.''] === "0000-00-00") // check if task has no value in specific column OR a default value "0000-00-00" which is a date
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

                    if($fetch_col_in_space_db[''.$field_col_name.''] === $field_value)
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
		mysqli_close($conn);
 ?>
