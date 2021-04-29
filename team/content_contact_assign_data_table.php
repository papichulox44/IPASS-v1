<?php
  session_start();
  include("../conn.php");
  date_default_timezone_set('Asia/Manila');

  if (isset($_POST['load_country_data'])) {
    $limit = $_POST['limit'];
    $start = $_POST['start'];
    $findcontact = mysqli_query($conn, "SELECT * FROM contact WHERE contact_assign_to != '' ORDER BY contact_fname ASC LIMIT $start, $limit");
    while($result_finduser = mysqli_fetch_array($findcontact))
    {
        $contact_id = $result_finduser['contact_id'];
        $select_task = mysqli_query($conn, "SELECT * FROM task WHERE task_contact = '$contact_id'");
        $count_task = mysqli_num_rows($select_task);
        echo '
        <tr>
            <td>ID #: '.$result_finduser['contact_id'].'</td>
            <td class="font-w600 ">';
                echo'<a href="main_contact_details.php?contact_id='.$contact_id.'">'.$result_finduser['contact_fname'].' '.$result_finduser['contact_mname'].' '.$result_finduser['contact_lname'].'</a>';
                echo'
            </td>
            <td class="d-none d-sm-table-cell text-center">'.$count_task.'</td>
            <td class="d-none d-sm-table-cell">'.$result_finduser['contact_email'].'</td>
            <td class="d-none d-sm-table-cell text-center">'.$result_finduser['contact_cpnum'].'</td>';
            if($result_finduser['contact_profile'] == "")
            {
                echo '<td class="text-center "><img style="width: 37px; border-radius:50px;" src="../assets/media/photos/avatar.jpg"></td>';
            }
            else
            {
                echo '<td class="text-center "><img style="width: 37px; height: 37px; border-radius:50px;" src="../client/client_profile/'.$result_finduser['contact_profile'].'"></td>';
            }
            echo'
        </tr>';
    }
  }

  if (isset($_POST['load_task_search_data'])) {
    $limit = $_POST['limit'];
    $start = $_POST['start'];
    $myInput = $_POST['myInput'];
    $findcontact = mysqli_query($conn, "SELECT * FROM contact WHERE contact_assign_to != '' AND contact_fname LIKE '%$myInput%' OR contact_lname LIKE '%$myInput%' ORDER BY contact_fname ASC LIMIT $start, $limit");
    while($result_finduser = mysqli_fetch_array($findcontact))
    {
        $contact_id = $result_finduser['contact_id'];
        $select_task = mysqli_query($conn, "SELECT * FROM task WHERE task_contact = '$contact_id'");
        $count_task = mysqli_num_rows($select_task);
        echo '
        <tr>
            <td>ID #: '.$result_finduser['contact_id'].'</td>
            <td class="font-w600 ">';
                echo'<a href="main_contact_details.php?contact_id='.$contact_id.'">'.$result_finduser['contact_fname'].' '.$result_finduser['contact_mname'].' '.$result_finduser['contact_lname'].'</a>';
                echo'
            </td>
            <td class="d-none d-sm-table-cell text-center">'.$count_task.'</td>
            <td class="d-none d-sm-table-cell">'.$result_finduser['contact_email'].'</td>
            <td class="d-none d-sm-table-cell text-center">'.$result_finduser['contact_cpnum'].'</td>';
            if($result_finduser['contact_profile'] == "")
            {
                echo '<td class="text-center "><img style="width: 37px; border-radius:50px;" src="../assets/media/photos/avatar.jpg"></td>';
            }
            else
            {
                echo '<td class="text-center "><img style="width: 37px; height: 37px; border-radius:50px;" src="../client/client_profile/'.$result_finduser['contact_profile'].'"></td>';
            }
            echo'
        </tr>';
    }
  }

  mysqli_close($conn);
 ?>
