<?php
  session_start();
  include("../conn.php");
  date_default_timezone_set('Asia/Manila');

  if (isset($_POST['load_country_data'])) {
      $user_id = $_SESSION['user'];
      $limit = $_POST['limit'];
      $start = $_POST['start'];
      $filter = $_POST['filter'];
      $due_date = $_POST['due_date'];
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

      $batch_status_filter = '';
      $query_filter_status = mysqli_query($conn, "SELECT * FROM filter_status WHERE user_id = $user_id AND filter_name = 'everything'");
      $data = mysqli_fetch_array($query_filter_status);
      $array_status = $data['array_status'];
      if (mysqli_num_rows($query_filter_status) === 1) {
        $value_array = explode(",", $array_status);
        if(count($value_array) === 1)
        {
          $value1 = $value_array[0];
          if($due_date == "All"){
            $batch_status_filter = "WHERE task_status_id = $value1";
          } else {
            $batch_status_filter = "AND task_status_id = $value1";
          }
        }
        else if(count($value_array) === 2)
         {
           $value1 = $value_array[0];
           $value2 = $value_array[1];
           if($due_date == "All"){
             $batch_status_filter = "WHERE task_status_id = $value1 OR task_status_id = $value2";
           } else {
             $batch_status_filter = "AND task_status_id = $value1 OR task_status_id = $value2";
           }
         }
         else if(count($value_array) === 3)
          {
            $value1 = $value_array[0];
            $value2 = $value_array[1];
            $value3 = $value_array[2];
            if($due_date == "All"){
              $batch_status_filter = "WHERE task_status_id = $value1 OR task_status_id = $value2 OR task_status_id = $value3";
            } else {
              $batch_status_filter = "AND task_status_id = $value1 OR task_status_id = $value2 OR task_status_id = $value3";
            }
          }
          else if(count($value_array) === 4)
           {
             $value1 = $value_array[0];
             $value2 = $value_array[1];
             $value3 = $value_array[2];
             $value4 = $value_array[3];
             if($due_date == "All"){
               $batch_status_filter = "WHERE task_status_id = $value1 OR task_status_id = $value2 OR task_status_id = $value3 OR task_status_id = $value4";
             } else {
               $batch_status_filter = "AND task_status_id = $value1 OR task_status_id = $value2 OR task_status_id = $value3 OR task_status_id = $value4";
             }
           }
           else if(count($value_array) === 5)
            {
              $value1 = $value_array[0];
              $value2 = $value_array[1];
              $value3 = $value_array[2];
              $value4 = $value_array[3];
              $value5 = $value_array[4];
              if($due_date == "All"){
                $batch_status_filter = "WHERE task_status_id = $value1 OR task_status_id = $value2 OR task_status_id = $value3 OR task_status_id = $value4 OR task_status_id = $value5";
              } else {
                $batch_status_filter = "AND task_status_id = $value1 OR task_status_id = $value2 OR task_status_id = $value3 OR task_status_id = $value4 OR task_status_id = $value5";
              }
            }
            else if(count($value_array) === 6)
             {
               $value1 = $value_array[0];
               $value2 = $value_array[1];
               $value3 = $value_array[2];
               $value4 = $value_array[3];
               $value5 = $value_array[4];
               $value6 = $value_array[5];
               if($due_date == "All"){
                 $batch_status_filter = "WHERE task_status_id = $value1 OR task_status_id = $value2 OR task_status_id = $value3 OR task_status_id = $value4 OR task_status_id = $value5 OR task_status_id = $value6";
               } else {
                 $batch_status_filter = "AND task_status_id = $value1 OR task_status_id = $value2 OR task_status_id = $value3 OR task_status_id = $value4 OR task_status_id = $value5 OR task_status_id = $value6";
               }
             }
      }



      if($filter == "All")
      {
          if($due_date == "All")
          {
              $select_task = mysqli_query($conn, "SELECT * FROM task $batch_status_filter LIMIT $start, $limit");
          }
          else
          {
              $select_task = mysqli_query($conn, "SELECT * FROM task WHERE task_due_date $due_date_filter $batch_status_filter LIMIT $start, $limit");
          }
      }
      else if($filter == "Today")
      {
          $filter = date("Y-m-d");
          $select_task = mysqli_query($conn, "SELECT * FROM task WHERE task_date_created LIKE '%$filter%' AND task_due_date $due_date_filter LIMIT $start, $limit");
      }
      else if($filter == "This Week")
      {
          $dt = new DateTime();
          $dates = [];
          for ($d = 1; $d <= 7; $d++) {
              $dt->setISODate($dt->format('o'), $dt->format('W'), $d);
              $weekdate = ($dates[$dt->format('D')] = $dt->format('Y-m-d'));
          }
          $from = current($dates); // monday
          $to = end($dates); // sunday
          $select_task = mysqli_query($conn, "SELECT * FROM task WHERE task_date_created BETWEEN '$from' AND '$to' AND task_due_date $due_date_filter LIMIT $start, $limit");
      }
      else if($filter == "This Month")
      {
          $filter = date("Y-m");
          $select_task = mysqli_query($conn, "SELECT * FROM task WHERE task_date_created LIKE '%$filter%' AND task_due_date $due_date_filter LIMIT $start, $limit");
      }
      else if($filter == "This Year")
      {
          $filter = date("Y");
          $select_task = mysqli_query($conn, "SELECT * FROM task WHERE task_date_created LIKE '%$filter%' AND task_due_date $due_date_filter LIMIT $start, $limit");
      }
      else if($filter == "Custom Date")
      {
          $get_from = $_GET['From'];
          $get_to = $_GET['To'];
          $select_task = mysqli_query($conn, "SELECT * FROM task WHERE task_date_created BETWEEN '$get_from' AND '$get_to' AND task_due_date $due_date_filter LIMIT $start, $limit");
      }
      while($fetch_task = mysqli_fetch_array($select_task))
      {
        include 'view_list_everything_table.php';
      }
  }

  if (isset($_POST['load_task_search_data'])) {
      $user_id = $_SESSION['user'];
      $limit = $_POST['limit'];
      $start = $_POST['start'];
      $filter = $_POST['filter'];
      $due_date = $_POST['due_date'];
      $myInput = $_POST['myInput'];
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

      $batch_status_filter = '';
      $query_filter_status = mysqli_query($conn, "SELECT * FROM filter_status WHERE user_id = $user_id AND filter_name = 'everything'");
      $data = mysqli_fetch_array($query_filter_status);
      $array_status = $data['array_status'];
      if (mysqli_num_rows($query_filter_status) === 1) {
        $value_array = explode(",", $array_status);
        if(count($value_array) === 1)
        {
          $value1 = $value_array[0];
          if($due_date == "All"){
            $batch_status_filter = "WHERE task_status_id = $value1";
          } else {
            $batch_status_filter = "AND task_status_id = $value1";
          }
        }
        else if(count($value_array) === 2)
         {
           $value1 = $value_array[0];
           $value2 = $value_array[1];
           if($due_date == "All"){
             $batch_status_filter = "WHERE task_status_id = $value1 OR task_status_id = $value2";
           } else {
             $batch_status_filter = "AND task_status_id = $value1 OR task_status_id = $value2";
           }
         }
         else if(count($value_array) === 3)
          {
            $value1 = $value_array[0];
            $value2 = $value_array[1];
            $value3 = $value_array[2];
            if($due_date == "All"){
              $batch_status_filter = "WHERE task_status_id = $value1 OR task_status_id = $value2 OR task_status_id = $value3";
            } else {
              $batch_status_filter = "AND task_status_id = $value1 OR task_status_id = $value2 OR task_status_id = $value3";
            }
          }
          else if(count($value_array) === 4)
           {
             $value1 = $value_array[0];
             $value2 = $value_array[1];
             $value3 = $value_array[2];
             $value4 = $value_array[3];
             if($due_date == "All"){
               $batch_status_filter = "WHERE task_status_id = $value1 OR task_status_id = $value2 OR task_status_id = $value3 OR task_status_id = $value4";
             } else {
               $batch_status_filter = "AND task_status_id = $value1 OR task_status_id = $value2 OR task_status_id = $value3 OR task_status_id = $value4";
             }
           }
           else if(count($value_array) === 5)
            {
              $value1 = $value_array[0];
              $value2 = $value_array[1];
              $value3 = $value_array[2];
              $value4 = $value_array[3];
              $value5 = $value_array[4];
              if($due_date == "All"){
                $batch_status_filter = "WHERE task_status_id = $value1 OR task_status_id = $value2 OR task_status_id = $value3 OR task_status_id = $value4 OR task_status_id = $value5";
              } else {
                $batch_status_filter = "AND task_status_id = $value1 OR task_status_id = $value2 OR task_status_id = $value3 OR task_status_id = $value4 OR task_status_id = $value5";
              }
            }
            else if(count($value_array) === 6)
             {
               $value1 = $value_array[0];
               $value2 = $value_array[1];
               $value3 = $value_array[2];
               $value4 = $value_array[3];
               $value5 = $value_array[4];
               $value6 = $value_array[5];
               if($due_date == "All"){
                 $batch_status_filter = "WHERE task_status_id = $value1 OR task_status_id = $value2 OR task_status_id = $value3 OR task_status_id = $value4 OR task_status_id = $value5 OR task_status_id = $value6";
               } else {
                 $batch_status_filter = "AND task_status_id = $value1 OR task_status_id = $value2 OR task_status_id = $value3 OR task_status_id = $value4 OR task_status_id = $value5 OR task_status_id = $value6";
               }
             }
      }

      if ($myInput === 'No Due Date') {
        if ($array_status) {
          $input_filter = "AND task_due_date is null";
        } else {
          if($due_date == "All"){
            $input_filter = "WHERE task_due_date is null";
          } else {
            $input_filter = "AND task_due_date is null";
          }
        }
      }
      else if ($myInput === 'Overdue'){
        $overdue = date('Y-m-d', strtotime(' -1 day'));
        $start_date = '2020-01-01';
        if ($array_status) {
          $input_filter = "AND task_due_date BETWEEN '$start_date' AND '$overdue'";
        } else {
          if($due_date == "All"){
            $input_filter = "WHERE task_due_date BETWEEN '$start_date' AND '$overdue'";
          } else {
            $input_filter = "AND task_due_date BETWEEN '$start_date' AND '$overdue'";
          }
        }
      }
      else if ($myInput === 'Today'){
        $today = date('Y-m-d');
        if ($array_status) {
          $input_filter = "AND task_due_date = '$today'";
        } else {
          if($due_date == "All"){
            $input_filter = "WHERE task_due_date = '$today'";
          } else {
            $input_filter = "AND task_due_date = '$today'";
          }
        }
      }
      else if ($myInput === 'Tomorrow'){
        $tomorrow = date('Y-m-d', strtotime(' +1 day'));
        if ($array_status) {
          $input_filter = "AND task_due_date = '$tomorrow'";
        } else {
          if($due_date == "All"){
            $input_filter = "WHERE task_due_date = '$tomorrow'";
          } else {
            $input_filter = "AND task_due_date = '$tomorrow'";
          }
        }
      }
      else if ($myInput === 'Urgent'){
        $priority = 'D Urgent';
        if ($array_status) {
          $input_filter = "AND task_priority = '$priority'";
        } else {
          if($due_date == "All"){
            $input_filter = "WHERE task_priority = '$priority'";
          } else {
            $input_filter = "AND task_priority = '$priority'";
          }
        }
      }
      else if ($myInput === 'High'){
        $priority = 'C High';
        if ($array_status) {
          $input_filter = "AND task_priority = '$priority'";
        } else {
          if($due_date == "All"){
            $input_filter = "WHERE task_priority = '$priority'";
          } else {
            $input_filter = "AND task_priority = '$priority'";
          }
        }
      }
      else if ($myInput === 'Normal'){
        $priority = 'B Normal';
        if ($array_status) {
          $input_filter = "AND task_priority = '$priority'";
        } else {
          if($due_date == "All"){
            $input_filter = "WHERE task_priority = '$priority'";
          } else {
            $input_filter = "AND task_priority = '$priority'";
          }
        }
      }
      else if ($myInput === 'Low'){
        $priority = 'A Low';
        if ($array_status) {
          $input_filter = "AND task_priority = '$priority'";
        } else {
          if($due_date == "All"){
            $input_filter = "WHERE task_priority = '$priority'";
          } else {
            $input_filter = "AND task_priority = '$priority'";
          }
        }
      }
      else if ($myInput === 'Monday' || $myInput === 'Tuesday' || $myInput === 'Wednesday' || $myInput === 'Thursday' || $myInput === 'Friday' || $myInput === 'Saturday' || $myInput === 'Sunday'){
        $today = date("Y-m-d");
        if (date("l", strtotime($today)) === 'Monday') {
          if ($myInput === 'Monday') {
            $date_result = date("Y-m-d");
            if ($array_status) {
              $input_filter = "AND task_due_date = '$date_result'";
            } else {
              if($due_date == "All"){
                $input_filter = "WHERE task_due_date = '$date_result'";
              } else {
                $input_filter = "AND task_due_date = '$date_result'";
              }
            }
          }
          else if ($myInput === 'Tuesday') {
            $date_result = date('Y-m-d', strtotime(' +1 day'));
            if ($array_status) {
              $input_filter = "AND task_due_date = '$date_result'";
            } else {
              if($due_date == "All"){
                $input_filter = "WHERE task_due_date = '$date_result'";
              } else {
                $input_filter = "AND task_due_date = '$date_result'";
              }
            }
          }
          else if ($myInput === 'Wednesday') {
            $date_result = date('Y-m-d', strtotime(' +2 day'));
            if ($array_status) {
              $input_filter = "AND task_due_date = '$date_result'";
            } else {
              if($due_date == "All"){
                $input_filter = "WHERE task_due_date = '$date_result'";
              } else {
                $input_filter = "AND task_due_date = '$date_result'";
              }
            }
          }
          else if ($myInput === 'Thursday') {
            $date_result = date('Y-m-d', strtotime(' +3 day'));
            if ($array_status) {
              $input_filter = "AND task_due_date = '$date_result'";
            } else {
              if($due_date == "All"){
                $input_filter = "WHERE task_due_date = '$date_result'";
              } else {
                $input_filter = "AND task_due_date = '$date_result'";
              }
            }
          }
          else if ($myInput === 'Friday') {
            $date_result = date('Y-m-d', strtotime(' +4 day'));
            if ($array_status) {
              $input_filter = "AND task_due_date = '$date_result'";
            } else {
              if($due_date == "All"){
                $input_filter = "WHERE task_due_date = '$date_result'";
              } else {
                $input_filter = "AND task_due_date = '$date_result'";
              }
            }
          }
          else if ($myInput === 'Saturday') {
            $date_result = date('Y-m-d', strtotime(' +5 day'));
            if ($array_status) {
              $input_filter = "AND task_due_date = '$date_result'";
            } else {
              if($due_date == "All"){
                $input_filter = "WHERE task_due_date = '$date_result'";
              } else {
                $input_filter = "AND task_due_date = '$date_result'";
              }
            }
          }
          else if ($myInput === 'Sunday') {
            $date_result = date('Y-m-d', strtotime(' +6 day'));
            if ($array_status) {
              $input_filter = "AND task_due_date = '$date_result'";
            } else {
              if($due_date == "All"){
                $input_filter = "WHERE task_due_date = '$date_result'";
              } else {
                $input_filter = "AND task_due_date = '$date_result'";
              }
            }
          }
        }
        else if (date("l", strtotime($today)) === 'Tuesday') {
          if ($myInput === 'Monday') {
            $date_result = date('Y-m-d', strtotime(' +6 day'));
            if ($array_status) {
              $input_filter = "AND task_due_date = '$date_result'";
            } else {
              if($due_date == "All"){
                $input_filter = "WHERE task_due_date = '$date_result'";
              } else {
                $input_filter = "AND task_due_date = '$date_result'";
              }
            }
          }
          else if ($myInput === 'Tuesday') {
            $date_result = date("Y-m-d");
            if ($array_status) {
              $input_filter = "AND task_due_date = '$date_result'";
            } else {
              if($due_date == "All"){
                $input_filter = "WHERE task_due_date = '$date_result'";
              } else {
                $input_filter = "AND task_due_date = '$date_result'";
              }
            }
          }
          else if ($myInput === 'Wednesday') {
            $date_result = date('Y-m-d', strtotime(' +1 day'));
            if ($array_status) {
              $input_filter = "AND task_due_date = '$date_result'";
            } else {
              if($due_date == "All"){
                $input_filter = "WHERE task_due_date = '$date_result'";
              } else {
                $input_filter = "AND task_due_date = '$date_result'";
              }
            }
          }
          else if ($myInput === 'Thursday') {
            $date_result = date('Y-m-d', strtotime(' +2 day'));
            if ($array_status) {
              $input_filter = "AND task_due_date = '$date_result'";
            } else {
              if($due_date == "All"){
                $input_filter = "WHERE task_due_date = '$date_result'";
              } else {
                $input_filter = "AND task_due_date = '$date_result'";
              }
            }
          }
          else if ($myInput === 'Friday') {
            $date_result = date('Y-m-d', strtotime(' +3 day'));
            if ($array_status) {
              $input_filter = "AND task_due_date = '$date_result'";
            } else {
              if($due_date == "All"){
                $input_filter = "WHERE task_due_date = '$date_result'";
              } else {
                $input_filter = "AND task_due_date = '$date_result'";
              }
            }
          }
          else if ($myInput === 'Saturday') {
            $date_result = date('Y-m-d', strtotime(' +4 day'));
            if ($array_status) {
              $input_filter = "AND task_due_date = '$date_result'";
            } else {
              if($due_date == "All"){
                $input_filter = "WHERE task_due_date = '$date_result'";
              } else {
                $input_filter = "AND task_due_date = '$date_result'";
              }
            }
          }
          else if ($myInput === 'Sunday') {
            $date_result = date('Y-m-d', strtotime(' +5 day'));
            if ($array_status) {
              $input_filter = "AND task_due_date = '$date_result'";
            } else {
              if($due_date == "All"){
                $input_filter = "WHERE task_due_date = '$date_result'";
              } else {
                $input_filter = "AND task_due_date = '$date_result'";
              }
            }
          }
        }
        else if (date("l", strtotime($today)) === 'Wednesday') {
          if ($myInput === 'Monday') {
            $date_result = date('Y-m-d', strtotime(' +5 day'));
            if ($array_status) {
              $input_filter = "AND task_due_date = '$date_result'";
            } else {
              if($due_date == "All"){
                $input_filter = "WHERE task_due_date = '$date_result'";
              } else {
                $input_filter = "AND task_due_date = '$date_result'";
              }
            }
          }
          else if ($myInput === 'Tuesday') {
            $date_result = date('Y-m-d', strtotime(' +6 day'));
            if ($array_status) {
              $input_filter = "AND task_due_date = '$date_result'";
            } else {
              if($due_date == "All"){
                $input_filter = "WHERE task_due_date = '$date_result'";
              } else {
                $input_filter = "AND task_due_date = '$date_result'";
              }
            }
          }
          else if ($myInput === 'Wednesday') {
            $date_result = date("Y-m-d");
            if ($array_status) {
              $input_filter = "AND task_due_date = '$date_result'";
            } else {
              if($due_date == "All"){
                $input_filter = "WHERE task_due_date = '$date_result'";
              } else {
                $input_filter = "AND task_due_date = '$date_result'";
              }
            }
          }
          else if ($myInput === 'Thursday') {
            $date_result = date('Y-m-d', strtotime(' +1 day'));
            if ($array_status) {
              $input_filter = "AND task_due_date = '$date_result'";
            } else {
              if($due_date == "All"){
                $input_filter = "WHERE task_due_date = '$date_result'";
              } else {
                $input_filter = "AND task_due_date = '$date_result'";
              }
            }
          }
          else if ($myInput === 'Friday') {
            $date_result = date('Y-m-d', strtotime(' +2 day'));
            if ($array_status) {
              $input_filter = "AND task_due_date = '$date_result'";
            } else {
              if($due_date == "All"){
                $input_filter = "WHERE task_due_date = '$date_result'";
              } else {
                $input_filter = "AND task_due_date = '$date_result'";
              }
            }
          }
          else if ($myInput === 'Saturday') {
            $date_result = date('Y-m-d', strtotime(' +3 day'));
            if ($array_status) {
              $input_filter = "AND task_due_date = '$date_result'";
            } else {
              if($due_date == "All"){
                $input_filter = "WHERE task_due_date = '$date_result'";
              } else {
                $input_filter = "AND task_due_date = '$date_result'";
              }
            }
          }
          else if ($myInput === 'Sunday') {
            $date_result = date('Y-m-d', strtotime(' +4 day'));
            if ($array_status) {
              $input_filter = "AND task_due_date = '$date_result'";
            } else {
              if($due_date == "All"){
                $input_filter = "WHERE task_due_date = '$date_result'";
              } else {
                $input_filter = "AND task_due_date = '$date_result'";
              }
            }
          }
        }
        else if (date("l", strtotime($today)) === 'Thursday') {
          if ($myInput === 'Monday') {
            $date_result = date('Y-m-d', strtotime(' +4 day'));
            if ($array_status) {
              $input_filter = "AND task_due_date = '$date_result'";
            } else {
              if($due_date == "All"){
                $input_filter = "WHERE task_due_date = '$date_result'";
              } else {
                $input_filter = "AND task_due_date = '$date_result'";
              }
            }
          }
          else if ($myInput === 'Tuesday') {
            $date_result = date('Y-m-d', strtotime(' +5 day'));
            if ($array_status) {
              $input_filter = "AND task_due_date = '$date_result'";
            } else {
              if($due_date == "All"){
                $input_filter = "WHERE task_due_date = '$date_result'";
              } else {
                $input_filter = "AND task_due_date = '$date_result'";
              }
            }
          }
          else if ($myInput === 'Wednesday') {
            $date_result = date('Y-m-d', strtotime(' +6 day'));
            if ($array_status) {
              $input_filter = "AND task_due_date = '$date_result'";
            } else {
              if($due_date == "All"){
                $input_filter = "WHERE task_due_date = '$date_result'";
              } else {
                $input_filter = "AND task_due_date = '$date_result'";
              }
            }
          }
          else if ($myInput === 'Thursday') {
            $date_result = date("Y-m-d");
            if ($array_status) {
              $input_filter = "AND task_due_date = '$date_result'";
            } else {
              if($due_date == "All"){
                $input_filter = "WHERE task_due_date = '$date_result'";
              } else {
                $input_filter = "AND task_due_date = '$date_result'";
              }
            }
          }
          else if ($myInput === 'Friday') {
            $date_result = date('Y-m-d', strtotime(' +1 day'));
            if ($array_status) {
              $input_filter = "AND task_due_date = '$date_result'";
            } else {
              if($due_date == "All"){
                $input_filter = "WHERE task_due_date = '$date_result'";
              } else {
                $input_filter = "AND task_due_date = '$date_result'";
              }
            }
          }
          else if ($myInput === 'Saturday') {
            $date_result = date('Y-m-d', strtotime(' +2 day'));
            if ($array_status) {
              $input_filter = "AND task_due_date = '$date_result'";
            } else {
              if($due_date == "All"){
                $input_filter = "WHERE task_due_date = '$date_result'";
              } else {
                $input_filter = "AND task_due_date = '$date_result'";
              }
            }
          }
          else if ($myInput === 'Sunday') {
            $date_result = date('Y-m-d', strtotime(' +3 day'));
            if ($array_status) {
              $input_filter = "AND task_due_date = '$date_result'";
            } else {
              if($due_date == "All"){
                $input_filter = "WHERE task_due_date = '$date_result'";
              } else {
                $input_filter = "AND task_due_date = '$date_result'";
              }
            }
          }
        }
        else if (date("l", strtotime($today)) === 'Friday') {
          if ($myInput === 'Monday') {
            $date_result = date('Y-m-d', strtotime(' +3 day'));
            if ($array_status) {
              $input_filter = "AND task_due_date = '$date_result'";
            } else {
              if($due_date == "All"){
                $input_filter = "WHERE task_due_date = '$date_result'";
              } else {
                $input_filter = "AND task_due_date = '$date_result'";
              }
            }
          }
          else if ($myInput === 'Tuesday') {
            $date_result = date('Y-m-d', strtotime(' +4 day'));
            if ($array_status) {
              $input_filter = "AND task_due_date = '$date_result'";
            } else {
              if($due_date == "All"){
                $input_filter = "WHERE task_due_date = '$date_result'";
              } else {
                $input_filter = "AND task_due_date = '$date_result'";
              }
            }
          }
          else if ($myInput === 'Wednesday') {
            $date_result = date('Y-m-d', strtotime(' +5 day'));
            if ($array_status) {
              $input_filter = "AND task_due_date = '$date_result'";
            } else {
              if($due_date == "All"){
                $input_filter = "WHERE task_due_date = '$date_result'";
              } else {
                $input_filter = "AND task_due_date = '$date_result'";
              }
            }
          }
          else if ($myInput === 'Thursday') {
            $date_result = date('Y-m-d', strtotime(' +6 day'));
            if ($array_status) {
              $input_filter = "AND task_due_date = '$date_result'";
            } else {
              if($due_date == "All"){
                $input_filter = "WHERE task_due_date = '$date_result'";
              } else {
                $input_filter = "AND task_due_date = '$date_result'";
              }
            }
          }
          else if ($myInput === 'Friday') {
            $date_result = date("Y-m-d");
            if ($array_status) {
              $input_filter = "AND task_due_date = '$date_result'";
            } else {
              if($due_date == "All"){
                $input_filter = "WHERE task_due_date = '$date_result'";
              } else {
                $input_filter = "AND task_due_date = '$date_result'";
              }
            }
          }
          else if ($myInput === 'Saturday') {
            $date_result = date('Y-m-d', strtotime(' +1 day'));
            if ($array_status) {
              $input_filter = "AND task_due_date = '$date_result'";
            } else {
              if($due_date == "All"){
                $input_filter = "WHERE task_due_date = '$date_result'";
              } else {
                $input_filter = "AND task_due_date = '$date_result'";
              }
            }
          }
          else if ($myInput === 'Sunday') {
            $date_result = date('Y-m-d', strtotime(' +2 day'));
            if ($array_status) {
              $input_filter = "AND task_due_date = '$date_result'";
            } else {
              if($due_date == "All"){
                $input_filter = "WHERE task_due_date = '$date_result'";
              } else {
                $input_filter = "AND task_due_date = '$date_result'";
              }
            }
          }
        }
        else if (date("l", strtotime($today)) === 'Saturday') {
          if ($myInput === 'Monday') {
            $date_result = date('Y-m-d', strtotime(' +2 day'));
            if ($array_status) {
              $input_filter = "AND task_due_date = '$date_result'";
            } else {
              if($due_date == "All"){
                $input_filter = "WHERE task_due_date = '$date_result'";
              } else {
                $input_filter = "AND task_due_date = '$date_result'";
              }
            }
          }
          else if ($myInput === 'Tuesday') {
            $date_result = date('Y-m-d', strtotime(' +3 day'));
            if ($array_status) {
              $input_filter = "AND task_due_date = '$date_result'";
            } else {
              if($due_date == "All"){
                $input_filter = "WHERE task_due_date = '$date_result'";
              } else {
                $input_filter = "AND task_due_date = '$date_result'";
              }
            }
          }
          else if ($myInput === 'Wednesday') {
            $date_result = date('Y-m-d', strtotime(' +4 day'));
            if ($array_status) {
              $input_filter = "AND task_due_date = '$date_result'";
            } else {
              if($due_date == "All"){
                $input_filter = "WHERE task_due_date = '$date_result'";
              } else {
                $input_filter = "AND task_due_date = '$date_result'";
              }
            }
          }
          else if ($myInput === 'Thursday') {
            $date_result = date('Y-m-d', strtotime(' +5 day'));
            if ($array_status) {
              $input_filter = "AND task_due_date = '$date_result'";
            } else {
              if($due_date == "All"){
                $input_filter = "WHERE task_due_date = '$date_result'";
              } else {
                $input_filter = "AND task_due_date = '$date_result'";
              }
            }
          }
          else if ($myInput === 'Friday') {
            $date_result = date('Y-m-d', strtotime(' +6 day'));
            if ($array_status) {
              $input_filter = "AND task_due_date = '$date_result'";
            } else {
              if($due_date == "All"){
                $input_filter = "WHERE task_due_date = '$date_result'";
              } else {
                $input_filter = "AND task_due_date = '$date_result'";
              }
            }
          }
          else if ($myInput === 'Saturday') {
            $date_result = date("Y-m-d");
            if ($array_status) {
              $input_filter = "AND task_due_date = '$date_result'";
            } else {
              if($due_date == "All"){
                $input_filter = "WHERE task_due_date = '$date_result'";
              } else {
                $input_filter = "AND task_due_date = '$date_result'";
              }
            }
          }
          else if ($myInput === 'Sunday') {
            $date_result = date('Y-m-d', strtotime(' +1 day'));
            if ($array_status) {
              $input_filter = "AND task_due_date = '$date_result'";
            } else {
              if($due_date == "All"){
                $input_filter = "WHERE task_due_date = '$date_result'";
              } else {
                $input_filter = "AND task_due_date = '$date_result'";
              }
            }
          }
        }
        else if (date("l", strtotime($today)) === 'Sunday') {
          if ($myInput === 'Monday') {
            $date_result = date('Y-m-d', strtotime(' +1 day'));
            if ($array_status) {
              $input_filter = "AND task_due_date = '$date_result'";
            } else {
              if($due_date == "All"){
                $input_filter = "WHERE task_due_date = '$date_result'";
              } else {
                $input_filter = "AND task_due_date = '$date_result'";
              }
            }
          }
          else if ($myInput === 'Tuesday') {
            $date_result = date('Y-m-d', strtotime(' +2 day'));
            if ($array_status) {
              $input_filter = "AND task_due_date = '$date_result'";
            } else {
              if($due_date == "All"){
                $input_filter = "WHERE task_due_date = '$date_result'";
              } else {
                $input_filter = "AND task_due_date = '$date_result'";
              }
            }
          }
          else if ($myInput === 'Wednesday') {
            $date_result = date('Y-m-d', strtotime(' +3 day'));
            if ($array_status) {
              $input_filter = "AND task_due_date = '$date_result'";
            } else {
              if($due_date == "All"){
                $input_filter = "WHERE task_due_date = '$date_result'";
              } else {
                $input_filter = "AND task_due_date = '$date_result'";
              }
            }
          }
          else if ($myInput === 'Thursday') {
            $date_result = date('Y-m-d', strtotime(' +4 day'));
            if ($array_status) {
              $input_filter = "AND task_due_date = '$date_result'";
            } else {
              if($due_date == "All"){
                $input_filter = "WHERE task_due_date = '$date_result'";
              } else {
                $input_filter = "AND task_due_date = '$date_result'";
              }
            }
          }
          else if ($myInput === 'Friday') {
            $date_result = date('Y-m-d', strtotime(' +5 day'));
            if ($array_status) {
              $input_filter = "AND task_due_date = '$date_result'";
            } else {
              if($due_date == "All"){
                $input_filter = "WHERE task_due_date = '$date_result'";
              } else {
                $input_filter = "AND task_due_date = '$date_result'";
              }
            }
          }
          else if ($myInput === 'Saturday') {
            $date_result = date('Y-m-d', strtotime(' +6 day'));
            if ($array_status) {
              $input_filter = "AND task_due_date = '$date_result'";
            } else {
              if($due_date == "All"){
                $input_filter = "WHERE task_due_date = '$date_result'";
              } else {
                $input_filter = "AND task_due_date = '$date_result'";
              }
            }
          }
          else if ($myInput === 'Sunday') {
            $date_result = date("Y-m-d");
            if ($array_status) {
              $input_filter = "AND task_due_date = '$date_result'";
            } else {
              if($due_date == "All"){
                $input_filter = "WHERE task_due_date = '$date_result'";
              } else {
                $input_filter = "AND task_due_date = '$date_result'";
              }
            }
          }
        }
      }
      else {
        if ($array_status) {
          $input_filter = "AND task_name LIKE '%$myInput%'";
        } else {
          if($due_date == "All"){
            $input_filter = "WHERE task_name like '%$myInput%'";
          } else {
            $input_filter = "AND task_name LIKE '%$myInput%'";
          }
        }
      }

      if($filter == "All")
      {
          if($due_date == "All")
          {
              $select_task = mysqli_query($conn, "SELECT * FROM task $batch_status_filter $input_filter LIMIT $start, $limit");
          }
          else
          {
              $select_task = mysqli_query($conn, "SELECT * FROM task WHERE task_due_date $due_date_filter $batch_status_filter $input_filter LIMIT $start, $limit");
          }
      }
      else if($filter == "Today")
      {
          $filter = date("Y-m-d");
          $select_task = mysqli_query($conn, "SELECT * FROM task WHERE task_date_created LIKE '%$filter%' AND task_due_date $due_date_filter $input_filter LIMIT $start, $limit");
      }
      else if($filter == "This Week")
      {
          $dt = new DateTime();
          $dates = [];
          for ($d = 1; $d <= 7; $d++) {
              $dt->setISODate($dt->format('o'), $dt->format('W'), $d);
              $weekdate = ($dates[$dt->format('D')] = $dt->format('Y-m-d'));
          }
          $from = current($dates); // monday
          $to = end($dates); // sunday
          $select_task = mysqli_query($conn, "SELECT * FROM task WHERE task_date_created BETWEEN '$from' AND '$to' AND task_due_date $due_date_filter $input_filter LIMIT $start, $limit");
      }
      else if($filter == "This Month")
      {
          $filter = date("Y-m");
          $select_task = mysqli_query($conn, "SELECT * FROM task WHERE task_date_created LIKE '%$filter%' AND task_due_date $due_date_filter $input_filter LIMIT $start, $limit");
      }
      else if($filter == "This Year")
      {
          $filter = date("Y");
          $select_task = mysqli_query($conn, "SELECT * FROM task WHERE task_date_created LIKE '%$filter%' AND task_due_date $due_date_filter $input_filter LIMIT $start, $limit");
      }
      else if($filter == "Custom Date")
      {
          $get_from = $_GET['From'];
          $get_to = $_GET['To'];
          $select_task = mysqli_query($conn, "SELECT * FROM task WHERE task_date_created BETWEEN '$get_from' AND '$get_to' AND task_due_date $due_date_filter $input_filter LIMIT $start, $limit");
      }
      while($fetch_task = mysqli_fetch_array($select_task))
      {
        include 'view_list_everything_table.php';
      }
  }

  mysqli_close($conn);
 ?>
