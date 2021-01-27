<style type="text/css">
  .del:hover{
      background-color: #ef5350;
  }
</style>

<?php  
session_start();
 include_once '../conn.php';
 if(isset($_POST["task_id"]))  
 {   
      $query = "SELECT * FROM task WHERE task_id = '".$_POST["task_id"]."'";  
      $result = mysqli_query($conn, $query);  

      while($taskid = mysqli_fetch_array($result))  
      {  
          $task_id = $taskid['task_id'];

          $task_tag = $taskid['task_tag']; //get the user_id ex. string = "1,2,3,4,5"
          $task_tag_array = explode(",", $task_tag); // eleminate the ","/ comma sign and insert to array ex. [1,2,3,4,5]
          $count_task_tag_array =  count($task_tag_array);

          $total_assign_to = $taskid['task_assign_to']; //get the user_id ex. string = "1,2,3,4,5"
          $assign_to_array = explode(",", $total_assign_to); // eleminate the ","/ comma sign and insert to array ex. [1,2,3,4,5]

          $count_assign_to =  count($assign_to_array);
           echo '   
                        <div class="block-header" style="background-color: #045d71;">
                            <h3 class="block-title" style="color: #fff;">
                            <span id="id_contact" class="badge float-right mt-5" style="font-size: 13px; color: #fff;">Task ID: '.$taskid["task_id"].'</span>
                            '.$taskid["task_name"].'</h3>   
                            <div class="block-options">
                                <button type="button" class="btn-block-option"'; if($_SESSION['user_type'] == 'Admin'){ echo 'onClick="close_task_admin()"'; } else { echo 'onClick="close_task()"'; }  echo 'data-dismiss="modal"> <i class="si si-close"></i> </button>
                            </div>
                        </div>
                      <div class="block block-content">
                          <div class="row items-push horizontal">
                              <div class="col-md-6 vertical">';
// Priority View ************************
                                  if($taskid['task_priority'] == 'D Urgent')
                                  {
                                      echo '<i class="fa fa-flag fa-2x text-danger mr-10"></i>';
                                  }
                                  else if ($taskid['task_priority'] == 'C High')
                                  {
                                      echo '<i class="fa fa-flag fa-2x text-warning mr-10"></i>';
                                  } 
                                  else if ($taskid['task_priority'] == 'B Normal')
                                  {
                                      echo '<i class="fa fa-flag fa-2x text-info mr-10"></i>';
                                  }
                                  else if ($taskid['task_priority'] == 'A Low')
                                  {
                                      echo '<i class="fa fa-flag fa-2x text-gray mr-10"></i>';
                                  }
                                  else
                                  {}

                                  if($taskid['task_priority'] == '')
                                  {}
                                  else
                                  {
                                      echo '<button type="button" class="btn btn-noborder btn-sm btn-circle"  style="color: #fff; height: 20px; margin: 15px 0px 0px -30px;" id="remove_priority'.$task_id.'" onclick="remove_priority(this.id)">
                                              <i class="bg bg-danger si si-close" style="border-radius: 50px;"></i>
                                            </button>';
                                  }
// Assign Member View ************************ 
                                  if ($total_assign_to == "") 
                                  {}
                                  else
                                  {
                                    for ($x = 1; $x <= $count_assign_to; $x++)
                                    {
                                        $y = $x - 1; // tricks to get every user_id
                                        $final_assign_to_name = $assign_to_array[$y];
                                        $get_user_profile = mysqli_query($conn, "SELECT * FROM user WHERE user_id = '$final_assign_to_name'");
                                        $result_get_user_profile = mysqli_fetch_array($get_user_profile);

                                        $get_first_letter_in_fname = $result_get_user_profile['fname'];                                                                
                                        $get_first_letter_in_lname = $result_get_user_profile['lname'];

                                        if($result_get_user_profile['profile_pic'] != "")
                                          echo'<span data-title="'.$result_get_user_profile['fname'].' '.$result_get_user_profile['lname'].'" class="btn btn-sm btn-circle" style="font-size: 11px; margin: 0px -10px 0px -1px;"><img style="width:40px; height: 40px; border-radius:50px; margin: -15px -6px 0px 0px; border: solid #fff 2px;" src="../assets/media/upload/'.$result_get_user_profile['profile_pic'].'">
                                            </span>
                                            <button type="button" class="btn btn-noborder btn-sm btn-circle" style="color: #fff; height: 20px; margin: 15px 0px 0px -17px;" id="remove_assign'.$final_assign_to_name.'" onclick="remove_assign(this.id)">
                                                <i class="bg bg-danger si si-close" style="border-radius: 50px;"></i>
                                            </button>';
                                        else
                                          echo'<span data-title="'.$result_get_user_profile['fname'].' '.$result_get_user_profile['lname'].'" class="btn btn-sm btn-circle" style="width:40px; height: 40px; border-radius:50px; padding: 11px 5px; margin: -5px -15px 0px 0px; border: solid #fff 2px; color: #fff; background-color: '.$result_get_user_profile['user_color'].'">'.$get_first_letter_in_fname[0].''.$get_first_letter_in_lname[0].'
                                            </span>
                                            <button type="button" class="btn btn-noborder btn-sm btn-circle" style="color: #fff; height: 20px; margin: 15px 0px 0px -17px;" id="remove_assign'.$final_assign_to_name.'" onclick="remove_assign(this.id)">
                                                <i class="bg bg-danger si si-close" style="border-radius: 50px;"></i>
                                            </button>'; 
                                    }   
                                  }
                              echo'</div>';
                                $array_avv = array(array('01' => 'Jan','02' => 'Feb','03' => 'Mar','04' => 'Apr','05' => 'May','06' => 'Jun','07' => 'Jul','08' => 'Aug','09' => 'Sep','10' => 'Oct','11' => 'Nov','12' => 'Dec')); // array with key and value ex. key=01 and value="Jan"...
                                $created_date_time = $taskid["task_date_created"];
                                $created_get_month = substr($created_date_time, -14, 2); // 2020-12-10 00:00:00 // get only month = 12
                                $created_get_date = substr($created_date_time, -11, 2); // 2020-12-10 00:00:00 // get only date = 10
                                $created_get_time = substr($created_date_time, -8, 8); // 2020-12-10 00:00:00 // get only time = 00:00:00
                                $created_am_or_pm = date("A", strtotime($created_date_time));
                                $created_month = array_column($array_avv, $created_get_month); // Get the value of specific key ex: key=02 then value="Feb" 
                                $created_month_avv = implode( "", $created_month ); // Convert array to string

                                $due_date_time = $taskid["task_due_date"];
                                $ymd = substr($due_date_time, -19, 10); // 2020-12-10 00:00:00 // Y-m-d = 2020-12-10 00
                                $due_get_month = substr($due_date_time, -14, 2); // 2020-12-10 00:00:00 // get only month = 12
                                $due_get_date = substr($due_date_time, -11, 2); // 2020-12-10 00:00:00 // get only date = 10
                                $hm = substr($due_date_time, -8, 5); // 2020-12-10 00:00:00 // get only date = 10
                                $am_or_pm = date("A", strtotime($due_date_time));
                                $due_month = array_column($array_avv, $due_get_month); // Get the value of specific key ex: key=02 then value="Feb" 
                                $due_month_avv = implode( "", $due_month ); // Convert array to string
                                $today = date("Y-m-d"); // Get current date
                                $tomorrow = date('Y-m-d', strtotime(' +1 day')); // Get tomorrow date

                        echo '<div class="col-md-6" style="margin: -8px 0px 0px 0px;">                          
                                <span style="padding-top: -20px;">Created: '.$created_month_avv.' '.$created_get_date.' '.$created_get_time.' '.$created_am_or_pm.'</span>  
                                <span>&nbsp;|&nbsp;</span>
                                <span style="margin: 0px 0px 0px px;">';
// Date Created & Due Date View ************************ 
                                  if($ymd == $today)
                                  {
                                      $task_priority = "D Urgent";
                                      mysqli_query($conn, "UPDATE task SET task_priority='$task_priority' WHERE task_id='$task_id'") or die(mysqli_error());
                                      echo'<span class="text-danger">Due Date: Today '.$hm.' '.$am_or_pm.'</span>
                                          <button type="button" class="btn btn-noborder btn-sm btn-circle" style="color: #fff; margin: -3px 0px 0px -5px;" id="remove_due_date'.$task_id.'" onclick="remove_due_date(this.id)">
                                            <i class="bg bg-danger si si-close" style="border-radius: 50px;"></i>
                                          </button>';
                                  }
                                  else if($ymd == $tomorrow)
                                  {   
                                      $task_priority = "C High";
                                      mysqli_query($conn, "UPDATE task SET task_priority='$task_priority' WHERE task_id='$task_id'") or die(mysqli_error());
                                      echo'<span class="text-warning">Due Date: Tomorrow '.$hm.' '.$am_or_pm.'</span>
                                          <button type="button" class="btn btn-noborder btn-sm btn-circle" style="color: #fff; margin: -3px 0px 0px -5px;" id="remove_due_date'.$task_id.'" onclick="remove_due_date(this.id)">
                                            <i class="bg bg-danger si si-close" style="border-radius: 50px;"></i>
                                          </button>';
                                  }
                                  else if ($due_date_time == '0000-00-00 00:00:00')
                                  {
                                      echo'Due Date: None';
                                  }
                                  else
                                  {
                                      echo'Due Date: '.$due_month_avv.' '.$due_date_time.'
                                          <button type="button" class="btn btn-noborder btn-sm btn-circle" style="color: #fff; margin: -3px 0px 0px -5px;" id="remove_due_date'.$task_id.'" onclick="remove_due_date(this.id)">
                                            <i class="bg bg-danger si si-close" style="border-radius: 50px;"></i>
                                          </button>';
                                  }
                          echo '</span> 
                                <br>   
                                <div>';
                                    $creator_id = $taskid['task_created_by'];
                                    $get_creators_name = mysqli_query($conn, "SELECT * FROM user WHERE user_id = '$creator_id'");
                                    $fetch_id = mysqli_fetch_array($get_creators_name);
                                    if($creator_id == ''){}
                                    else
                                    {
                                        echo''.$fetch_id['fname'].' '.$fetch_id['lname'].' created this task.';
                                    }
                         echo'
                                  </div>                               
                              </div>
                          </div>
                          <div class="row col-md-12 mt-5 mb-5">';
                              for ($x = 1; $x <= $count_task_tag_array; $x++)
                              {
                                  $y = $x - 1; // tricks to get every user_id
                                  $assign_tag = $task_tag_array[$y];
                                  $get_tag = mysqli_query($conn, "SELECT * FROM tags WHERE tag_id = '$assign_tag'");
                                  $fetch_tags = mysqli_fetch_array($get_tag);
                                echo '<span style="background-color: '.$fetch_tags['tag_color'].'; color:#fff; padding:2px 0px 2px 5px; border-top-right-radius: 25px; border-bottom-right-radius: 25px; font-size: 11px; margin: 0px 0px 0px 5px;">'.$fetch_tags['tag_name'].'
                                  <button type="button" class="btn btn-noborder btn-sm btn-circle" style="color: #fff; height: 20px; padding: 0px 0px 0px 0px;" id="remove_tag'.$assign_tag.'" onclick="remove_tag(this.id)">
                                      <i class="del si si-close" style="border-radius: 50px;"></i>
                                  </button>
                                </span>';
                              }
                          echo'  
                          </div>
                      </div>
                ';  
      }  
      //$output .= "</table></div>";  
      //echo $output;  
 }  
 ?>

 <!--<button type="button" class="btn-block-option" onClick="window.location.reload();" data-dismiss="modal"> <i class="si si-close"></i> </button>-->