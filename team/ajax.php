<?php
    session_start();
    include("../conn.php");
    use PHPMailer\PHPMailer\PHPMailer;
  	require_once 'phpmailer/Exception.php';
  	require_once 'phpmailer/PHPMailer.php';
  	require_once 'phpmailer/SMTP.php';
  	$mail = new PHPMailer(true);

    // ----------------------- DISPLAY ASSIGN EMAIL -----------------------
    if(isset($_POST['display_email_assign']))
    {
        $email_id = $_POST['email_id'];
        $results = mysqli_query($conn, "SELECT * FROM email_assign INNER JOIN list ON email_assign.assign_list_id = list.list_id WHERE email_assign.assign_email_id = '$email_id'");
        while($rows = mysqli_fetch_array($results))
        {
            echo'<li class="scrumboard-item btn-alt-warning" style="box-shadow: 0px 1px 1px 0px rgba(119, 119, 119, 0.27);-moz-box-shadow: 0px 1px 1px 0px rgba(119, 119, 119, 0.27);-webkit-box-shadow: 0px 1px 1px 0px rgba(119, 119, 119, 0.27); height: 20px;">
                        <div class="scrumboard-item-options">
                            <button class="btn btn-sm btn-noborder btn-danger" id="'.$rows['assign_id'].'" onclick="delete_assign_field(this.id)"><i class="fa fa-trash"></i></button>
                        </div>
                        <div class="scrumboard-item-content">';
                            echo'<label>'.$rows['list_name'].'</label>
                        </div>
                </li>';
        }
    }
    // ----------------------- END DISPLAY ASSIGN EMAIL -----------------------
    // ----------------------- ASSIGN EMAIL -----------------------
    if(isset($_POST['click_assign_email']))
    {
        $user_id = $_POST['user_id'];
        $email_assign_id = $_POST['email_assign_id'];
        $space_id_no = $_POST['space_id_no'];
        $list_id_no = $_POST['list_id_no'];

        $select_email_assign = mysqli_query($conn,"SELECT * FROM email_assign WHERE assign_email_id = '$email_assign_id' AND assign_list_id = '$list_id_no'");
        $count = mysqli_num_rows($select_email_assign);
        if($count == 1)
        {
            echo "exist";
        }
        else
        {
            mysqli_query($conn,"INSERT into email_assign (assign_by, assign_email_id, assign_list_id) values ('$user_id', '$email_assign_id', '$list_id_no')") or die(mysqli_error());
            echo "success";
        }
    }
    // ----------------------- END ASSIGN EMAIL -----------------------
    // ----------------------- DELETE ASSIGN EMAIL LIST -----------------------
    if(isset($_POST['delete_assign_field']))
    {
        $assign_field_id = $_POST['assign_field_id'];
        // delete from db
        $sucess_delete = mysqli_query($conn, "DELETE FROM email_assign WHERE assign_id = '$assign_field_id'") or die(mysqli_error());
        // echo "success";
        if ($sucess_delete) {
            echo "success";
        }
    }
    // -----------------------END DELETE ASSIGN EMAIL LIST -----------------------
    // ----------------------- GET EMAIL CONTENT -----------------------
    if(isset($_POST['get_email_content']))
    {
        $email_name = $_POST['email_name'];
        $file_loc = "email_content/".$email_name.".txt";

        $myfile = fopen($file_loc, "r") or die("Unable to open file!");
        echo fread($myfile,filesize($file_loc));
        fclose($myfile);
    }
    // ----------------------- END GET EMAIL CONTENT -----------------------
    // ----------------------- DELETE EMAIL -----------------------
    if(isset($_POST['delete_email']))
    {
        $email_id = $_POST['id'];
        $select_email = mysqli_query($conn,"SELECT * FROM email_format WHERE email_id = '$email_id'");
        $fetch_email = mysqli_fetch_array($select_email);
        $email_name = $fetch_email['email_name'];

        // remove emailname.txt from email_content folder
        $file_loc = "email_content/".$email_name.".txt";
        unlink($file_loc);

        // delete from db
        mysqli_query($conn, "DELETE FROM email_format WHERE email_id = '$email_id'") or die(mysqli_error());
    }
    // ----------------------- END DELETE EMAIL -----------------------
    // ----------------------- PREVIEW EMAIL -----------------------
    if(isset($_POST['preview_email']))
    {
        $email_content = $_POST['email_content'];
        echo '
            <td style="background-color: #fff; border-top: 10px solid #189AA7; border-bottom: 10px solid #189AA7;">
                '.$email_content.'
            </td>
        ';
    }
    // ----------------------- END PREVIEW EMAIL -----------------------
    // ----------------------- PUBLISH EMAIL -----------------------
    if(isset($_POST['publish']))
    {
        $email_created_by = $_POST['email_created_by'];
        $email_template = $_POST['email_template'];
        $email_name = $_POST['email_name'];
        $email_subject = $_POST['email_subject'];
        $email_content = $_POST['email_content'];

        // save to db

        if(file_exists("email_content/".$email_name.".txt")) // if email exist then update
        {
            mysqli_query($conn, "UPDATE email_format SET email_created_by = '$email_created_by', email_template = '$email_template', email_name = '$email_name', email_subject = '$email_subject' WHERE email_name='$email_name'") or die(mysqli_error());
            // save email content to specific location
            $fp = fopen("./email_content/".$email_name.".txt","wb");
            fwrite($fp,$email_content);
            fclose($fp);

            echo "Update";
        }
        else // else create new
        {
            mysqli_query($conn, "INSERT into email_format values ('', '$email_created_by', '$email_template', '$email_name', '$email_subject')") or die(mysqli_error());

            // save email content to specific location
            $fp = fopen("./email_content/".$email_name.".txt","wb");
            fwrite($fp,$email_content);
            fclose($fp);

            echo "Insert";
        }
    }
    // ----------------------- END PUBLISH EMAIL -----------------------
    // ----------------------- SEND EMAIL -----------------------
    if(isset($_POST['test_send_email']))
    {
        $to = $_POST['test_email'];
        $subject = $_POST['email_subject'];
        $email_content = $_POST['email_content'];
        $FirstName = $_POST['FirstName'];

        $task_id = $_POST['task_id'];
        $user_id = $_POST['user_id'];
        $comment = 'Send email to: "'.$to.'"| Email Subject: "'.$subject.'"';
        $date = date('Y-m-d H:i:s');

        $from = 'cesteam@ipassprocessing.com';

        // Message can be change base on template selected
        $message = '
            <div style="padding: 20px 0px 0px 0px; background-color: #189AA7;" class="shadow">
              <img src="../assets/media/photos/header_email.png" style="width: 100%;">
                <table width="100%" border="0" cellspacing="0" cellpadding="20" style="background-color: #47bcde; color: #5a5f61; font-family:verdana;">
                    <tr>
                        <td style="background-color: #fff; border-top: 10px solid #189AA7; border-bottom: 10px solid #189AA7;">
                            '.$email_content.'
                        </td>
                    </tr>
                </table>
                <div style="text-align: center; padding: 20px 0px; color: #fff; background-color: #189AA7;">
                    PROCESSING MADE EASY BY IPASS<br>
                    Rm 1, 2nd Floor, Doña Segunda Complex,<br>
                    Ponciano Street, Davao City, Philippines 8000<br><br>
                    <a href="https://ipassprocessing.com/" style="color: white;">https://ipassprocessing.com/</a>
                </div>
            </div>
        ';

        // Always set content-type when sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        // More headers
        $headers .= 'From: <ipasspmt.site>' . "\r\n";
        // $headers .= 'From: <ipasspmt.site>' . "\r\n";
        $headers .= 'Cc: ipasspmt.site' . "\r\n";

        $send = mail($to,$subject,$message,$headers);
        if($send)
        {
            $comment_insert = mysqli_query($conn, "INSERT INTO comment (comment_task_id, comment_user_id, comment_message, comment_date, comment_type) VALUES ('$task_id', '$user_id', '$comment', '$date', '4')") or die(mysqli_error());
            if ($comment_insert) {
                echo "Email sent successfully.";
            }
        }
        else
        {
            echo "Email not sent.";
        }
    }
    // ----------------------- END SEND EMAIL -----------------------


    // ----------------------- MEMBER UPLOAD PROFILE PICTURE -----------------------
    if(isset($_POST['update_profile']))
    {
        $user_id = $_POST['user_id'];
        $attachment_name = $_FILES['file_attachment']['name'];
        $attachment_temp = $_FILES['file_attachment']['tmp_name'];
        $attachment_size = $_FILES['file_attachment']['size'];

        $exp = explode(".", $attachment_name);
        $ext = end($exp);
        $allowed_ext = array('jpg', 'JPG', 'jpeg', 'JPEG', 'png', 'PNG');
        if(in_array($ext, $allowed_ext)) // check the file extension
        {
            date_default_timezone_set('Asia/Manila');
            //$todays_date = date("y-m-d H:i:sa"); //  original format
            $date = date("His"); // for unique file name

            $words = explode(' ',trim($attachment_name)); // convert name to array
            $get_name = substr($words[0], 0, 6); // get only 6 character of the name

            $image = $date.'-'.$get_name.'.'.$ext;
            $location = "../assets/media/upload/".$image; // upload location
            if($attachment_size < 3000000) // Maximum 3 MB;
            {
                $select_user = mysqli_query($conn, "SELECT * FROM user where user_id = '$user_id'");
                $fetch_user = mysqli_fetch_array($select_user);
                $existing_frofile = $fetch_user['profile_pic'];
                if($existing_frofile != "")
                {
                    array_map('unlink', glob("../assets/media/upload/".$existing_frofile)); // remove image
                }
                move_uploaded_file($attachment_temp, $location);
                $update = mysqli_query($conn, "UPDATE user SET profile_pic = '$image' WHERE user_id='$user_id'") or die(mysqli_error());
                echo "success";
            }
            else
            {
                echo "size";
            }
        }
        else
        {
            echo "format";
        }
    }
    // ----------------------- END MEMBER UPLOAD PROFILE PICTURE -----------------------

    // ----------------------- CHANGE MODE -----------------------
    if(isset($_POST['change_mode']))
    {
        $user_id = $_POST['user_id'];
        $select_mode = mysqli_query($conn,"SELECT * FROM mode WHERE mode_user_id = '$user_id'");
        $fetch_mode = mysqli_fetch_array($select_mode);
        $count = mysqli_num_rows($select_mode);
        if($count == 0) //insert
        {
            mysqli_query($conn,"INSERT into `mode` values ('','$user_id','White')") or die(mysqli_error());
        }
        else //update
        {
            $mode_type = $fetch_mode['mode_type'];
            if($mode_type == "Custom" || $mode_type == "")
            {
                $update = mysqli_query($conn, "UPDATE mode SET mode_type = 'White' WHERE mode_user_id='$user_id'") or die(mysqli_error());
                echo 'White';
            }
            else if($mode_type == "White")
            {
                $update = mysqli_query($conn, "UPDATE mode SET mode_type = 'Dark' WHERE mode_user_id='$user_id'") or die(mysqli_error());
                echo 'Dark';
            }
            else
            {
                $update = mysqli_query($conn, "UPDATE mode SET mode_type = 'Custom' WHERE mode_user_id='$user_id'") or die(mysqli_error());
                echo 'Custom';
            }
        }
    }
    // ----------------------- EDN CHANGE MODE  -----------------------

    // ----------------------- add_task_save -----------------------
    if(isset($_POST['add_task_save']))
    {
        $user_id = $_POST['user_id'];
        $space_id = $_POST['space_id'];
        $list_id = $_POST['list_id'];
        $status_id = $_POST['status_id'];
        $contact_id = $_POST['contact_id'];
        $task_name = $_POST['task_name'];

        // update contact_assign_to
        $select_contact = mysqli_query($conn,"SELECT * FROM contact WHERE contact_id = '$contact_id'");
        $fetch_contact = mysqli_fetch_array($select_contact);
        $new_assign_to = $fetch_contact['contact_assign_to'].','. $space_id.','.$list_id.','.$status_id;

        $update = mysqli_query($conn, "UPDATE contact SET contact_assign_to = '$new_assign_to' WHERE contact_id='$contact_id'") or die(mysqli_error());

        //Send email to client
        $emailfor = "New contact assign";
        include 'email_format.php';
        //END Send email to client

        // insert into task db
        mysqli_query($conn,"INSERT into `task` (task_name, task_status_id, task_list_id, task_created_by, task_date_created, task_assign_to, task_contact) values ('$task_name', '$status_id', '$list_id', '$user_id', NOW(), '$user_id', $contact_id)") or die(mysqli_error());

        // get last task id
        $last_id = mysqli_query($conn,"SELECT * FROM task WHERE task_status_id = '$status_id' ORDER BY task_id DESC LIMIT 1");
        $fetch_last_id = mysqli_fetch_array($last_id);
        $task_id = $fetch_last_id['task_id'];

        // then insert into specific space db
        $select_space = mysqli_query($conn,"SELECT * FROM space WHERE space_id = '$space_id'");
        $fetch_select_space = mysqli_fetch_array($select_space);
        $space_db_name = $fetch_select_space['space_db_table'];
        mysqli_query($conn,"INSERT into `$space_db_name` (task_id) values ('$task_id')") or die(mysqli_error());
    }
    // ----------------------- END add_task_save -----------------------


    // ----------------------- FILTER TASK -----------------------
    if(isset($_POST['fetch_field_dropdown']))
    {
        $space_id = $_POST['space_id'];
        $list_id = $_POST['list_id'];
        $field_id = $_POST['field_id'];

        $select_space_name = mysqli_query($conn, "SELECT * FROM space WHERE space_id = '$space_id'");
        $fetch_space_name = mysqli_fetch_array($select_space_name);
        $space_name = $fetch_space_name['space_name'];

        $select_list_name = mysqli_query($conn, "SELECT * FROM list WHERE list_id = '$list_id'");
        $fetch_list_name = mysqli_fetch_array($select_list_name);
        $list_name = $fetch_list_name['list_name'];

        $select_field_col_name = mysqli_query($conn, "SELECT * FROM field WHERE field_id = '$field_id'");
        $fetch_field_col_name = mysqli_fetch_array($select_field_col_name);

        $select_option = mysqli_query($conn, "SELECT * FROM child WHERE child_field_id = '$field_id' ORDER BY child_order ASC");
        while ($fetch_option = mysqli_fetch_array($select_option))
        {
            echo '<a class="dropdown-item text-center text-white" style="background-color: '.$fetch_option['child_color'].';" href="main_dashboard.php?space_name='.$space_name.'&list_name='.$list_name.'&list_id='.$list_id.'&filter=field&field='.$fetch_option['child_id'].',,'.$fetch_field_col_name['field_col_name'].',,dropdown">'.$fetch_option['child_name'].'</a>';
        }
    }
    if(isset($_POST['fetch_field_radio']))
    {
        $space_id = $_POST['space_id'];
        $list_id = $_POST['list_id'];
        $field_id = $_POST['field_id'];

        $select_field_name = mysqli_query($conn, "SELECT * FROM field WHERE field_id = '$field_id'");
        $fetch_field_name = mysqli_fetch_array($select_field_name);

        echo '<div class="text-center">
                <div style="font-size: 22px; margin-bottom: 20px;">'.$fetch_field_name['field_name'].'<div>
                <div style="background-color: #1b9598; margin-top: 5px; color: #fff; padding: 3px 20px; border-radius: 10px;">
                    <label class="css-control css-control-primary css-radio">
                        <input type="radio" class="css-control-input" name="radio-group2" value="'.$fetch_field_name['field_col_name'].'" onclick="filter_yes(this.value)">
                        <span class="css-control-indicator"></span> Yes
                    </label>
                    <label class="css-control css-control-primary css-radio">
                        <input type="radio" class="css-control-input" name="radio-group2" value="'.$fetch_field_name['field_col_name'].'" onclick="filter_no(this.value)">
                        <span class="css-control-indicator"></span> No
                    </label>
                </div>
            </div>';
    }
    // ----------------------- END FILTER TASK -----------------------

    // ----------------------- MODAL UPPER OPTION / ADD DETAILS -----------------------
    if(isset($_POST['fetch_status']))
    {
        $task_id = $_POST['task_id'];
        $status_list_id = $_POST['list_id'];

        $select_task = mysqli_query($conn, "SELECT * FROM task WHERE task_id = '$task_id'");
        $fetch_select_task = mysqli_fetch_array($select_task);

        $findstatus = mysqli_query($conn, "SELECT * FROM status WHERE status_list_id = '$status_list_id' ORDER BY status_order_no ASC");
        while($result_findstatus = mysqli_fetch_array($findstatus))
        {
            if($fetch_select_task['task_status_id'] == $result_findstatus['status_id'])
            {
                echo '<button type="button" class="dropdown-item" style="background-color: '.$result_findstatus['status_color'].'; color: #fff">
                          <i class="fa fa-square mr-5"></i>'.$result_findstatus['status_name'].'
                </button>';
            }
            else
            {
                echo '<button type="button" class="dropdown-item" id="'.$result_findstatus['status_id'].','.$result_findstatus['status_name'].'" onclick="move_task(this.id)">
                          <i class="fa fa-square mr-5" style="color: '.$result_findstatus['status_color'].';"></i>'.$result_findstatus['status_name'].'
                </button>';
            }
        }
    }
    if(isset($_POST['fetch_email_name']))
    {
        $task_id = $_POST['task_id'];
        $status_list_id = $_POST['list_id'];

        $select_task = mysqli_query($conn, "SELECT email_format.email_name, contact.contact_email, email_format.email_id, email_format.email_subject, email_format.email_name, contact.contact_fname FROM email_assign INNER JOIN email_format ON email_assign.assign_email_id = email_format.email_id INNER JOIN task ON task.task_list_id = email_assign.assign_list_id INNER JOIN contact ON contact.contact_id = task.task_contact WHERE task.task_id = '$task_id'");

        if (isset($_SESSION['set_email'])) {
            $set_email = $_SESSION['set_email'];
        } else {
            $set_email = '';
        }
        echo '<label class="form-control">Email: '.$set_email.'</label><br>';

        echo '
        <script>
        $(document).ready(function(){
          $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myTable tr").filter(function() {
              $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
          });
        });
        </script>
        ';

        echo '
            <input class="form-control" id="myInput" type="text" placeholder="Search Email...">
            <table class="table table-bordered table-hover">
              <thead>
              <tr>
                <th>Email Name</th>
                <th>Action</th>
              </tr>
              </thead>
        ';
        while($result_findstatus = mysqli_fetch_array($select_task))
        {
            $email_name = $result_findstatus['email_name'];
            echo '
              <tbody id="myTable">
              <tr>
                <td>
                <button data-dismiss="modal" data-toggle="modal" data-target="#modal-extra-large" class="dropdown-item" id="'.$result_findstatus['email_id'].'" onclick="fetch_email_name(this.id)">
                <i class="fa fa-square mr-5" style="color: #3f9ce8;"></i><span data-toggle="popover" title="'.$email_name.'" data-placement="bottom">'.substr($email_name, 0, 30).'...</span>
                </button>
                </td>
                <td>
                <button class="btn btn-default" data-dismiss="modal" data-toggle="modal" data-target="#modal-extra-editable-email" onclick="fetch_email_pictures()"><i class="fa fa-edit" style="color: #3f9ce8; font-size:20px;" id="'.$result_findstatus['email_id'].'" onclick="fetch_email_name_editable(this.id)"></i></button>
                </td>
              </tr>
              </tbody>
            <input id="contact_email'.$result_findstatus['email_id'].'" type="hidden" value="'.$result_findstatus['contact_email'].'"></input>
            <input id="email_subject'.$result_findstatus['email_id'].'" type="hidden" value="'.$result_findstatus['email_subject'].'"></input>
            <input id="email_name'.$result_findstatus['email_id'].'" type="hidden" value="'.$result_findstatus['email_name'].'"></input>
            <input id="contact_fname'.$result_findstatus['email_id'].'" type="hidden" value="'.$result_findstatus['contact_fname'].'"></input>
            ';
        }
        echo '</table>';
    }

    if(isset($_POST['display_email_names']))
    {
        $task_status_id = $_POST['task_status_id'];

        $select_task = mysqli_query($conn, "SELECT email_format.email_name, email_format.email_subject, email_format.email_id FROM email_assign INNER JOIN email_format ON email_assign.assign_email_id = email_format.email_id INNER JOIN task ON email_assign.assign_list_id = task.task_list_id WHERE task.task_status_id = $task_status_id GROUP BY email_format.email_name");

        if (isset($_SESSION['set_email'])) {
            $set_email = $_SESSION['set_email'];
        } else {
            $set_email = '';
        }
        echo '<label class="form-control">Email: '.$set_email.'</label><br>';

        echo '
        <script>
        $(document).ready(function(){
          $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#myTable tr").filter(function() {
              $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
          });
        });
        </script>
        ';

        echo '
            <input class="form-control" id="myInput" type="text" placeholder="Search Email...">
            <table class="table table-bordered table-hover">
              <thead>
              <tr>
                <th>Email Name</th>
                <th>Action</th>
              </tr>
              </thead>
        ';

        echo '
        <input id="task_status_id" type="hidden" value="'.$task_status_id.'"></input>
        ';

        while($result_findstatus = mysqli_fetch_array($select_task))
        {
            $email_name = $result_findstatus['email_name'];
            echo '
              <tbody id="myTable">
              <tr>
                <td>
                <button class="dropdown-item">
                <i class="fa fa-square mr-5" style="color: #3f9ce8;"></i><span data-toggle="popover" title="'.$email_name.'" data-placement="bottom">'.substr($email_name, 0, 30).'...</span>
                </button>
                </td>
                <td>
                <button class="btn btn-default" data-dismiss="modal" data-toggle="modal" data-target="#modal-extra-editable-email" onclick="fetch_email_pictures()"><i class="fa fa-edit" style="color: #3f9ce8; font-size:20px;" id="'.$result_findstatus['email_id'].'" onclick="fetch_email_name_editable_blast(this.id)"></i></button>
                </td>
              </tr>
              </tbody>
            <input id="email_subject'.$result_findstatus['email_id'].'" type="hidden" value="'.$result_findstatus['email_subject'].'"></input>
            <input id="email_name'.$result_findstatus['email_id'].'" type="hidden" value="'.$result_findstatus['email_name'].'"></input>
            ';
        }
        echo '</table>';
    }

    if(isset($_POST['move_task']))
    {
        $task_id = $_POST['task_id'];
        $status_id = $_POST['status_id'];
        $status_name = $_POST['status_name'];
        $user_id = $_POST['user_id'];
        $comment = 'Update Phase status to: "'.$status_name.'"';

        $select_task = mysqli_query($conn, "SELECT * FROM task WHERE task_id = '$task_id'");
        $fetch_select_task = mysqli_fetch_array($select_task);
        $task_status_id = $fetch_select_task['task_status_id'];
        $contact_id = $fetch_select_task['task_contact'];
        mysqli_query($conn, "INSERT INTO tbl_movement (contact_id) VALUES ($contact_id)") or die(mysqli_error());

        $move = mysqli_query($conn, "UPDATE task SET task_status_id = '$status_id' WHERE task_id='$task_id'") or die(mysqli_error());

        if($move == true)
        {
            $select_contact = mysqli_query($conn, "SELECT * FROM contact WHERE contact_id = '$contact_id'");
            $fetch_select_contact = mysqli_fetch_array($select_contact);
            $contact_assign_to = $fetch_select_contact['contact_assign_to'];
            $assign_array = explode(",", $contact_assign_to); // convert string to array
            $new_array = str_replace($task_status_id,$status_id,$assign_array); // current,change_to,array
            $new_assign_to = implode(",",$new_array); // convert array to string
            mysqli_query($conn, "UPDATE contact SET contact_assign_to = '$new_assign_to' WHERE contact_id = '$contact_id'") or die(mysqli_error());
            $comment_insert = mysqli_query($conn, "INSERT INTO comment (comment_task_id, comment_user_id, comment_message, comment_date, comment_type) VALUES ($task_id, $user_id, '$comment', NOW(), 3)") or die(mysqli_error());
            echo 'move';
        }
        else
        { echo 'error'; }
    }
    if(isset($_POST['add_priority']))
    {
        $priority = $_POST['priority'];
        $task_id = $_POST['task_id'];
        $user_id = $_POST['user_id'];
        $comment = 'Update Priority to: "'.$priority.'".';

        mysqli_query($conn, "UPDATE task SET task_priority = '$priority' WHERE task_id='$task_id'") or die(mysqli_error());
        mysqli_query($conn, "INSERT INTO comment (comment_task_id, comment_user_id, comment_message, comment_date, comment_type) VALUES ($task_id, $user_id, '$comment', NOW(), 1)") or die(mysqli_error());
    }
    if(isset($_POST['assign_member']))
    {
        $task_id = $_POST['task_id'];
        $member_id = $_POST['member_id'];
        $list_id = $_POST['list_id'];
        $member_name = $_POST['member_name'];
        $user_id = $_POST['user_id'];
        $comment = 'Update Assign Task to: "'.$member_name.'".';

        mysqli_query($conn, "INSERT INTO comment (comment_task_id, comment_user_id, comment_message, comment_date, comment_type) VALUES ($task_id, $user_id, '$comment', NOW(), 1)") or die(mysqli_error());

        $find_task = mysqli_query($conn, "SELECT * FROM task WHERE task_id = '$task_id'");
        $result_find_task = mysqli_fetch_array($find_task);
        $current_assign_to = $result_find_task['task_assign_to'];

        if($current_assign_to == "")
        {
            mysqli_query($conn, "UPDATE task SET task_assign_to='$member_id' WHERE task_id='$task_id'") or die(mysqli_error());
        }
        else
        {
            $current_array = explode(",", $current_assign_to); // convert string to array
            array_push($current_array,$member_id); // insert the new user id to $current_array | ex. "1" then new array ==  [1,2,3,4,5,1]
            if(count($current_array) != count(array_unique($current_array))) // checking for existing element of array.
            {
                echo "error1";
            }
            else
            {
                $many_assign = $current_assign_to.",".$member_id;
                mysqli_query($conn, "UPDATE task SET task_assign_to='$many_assign' WHERE task_id='$task_id'") or die(mysqli_error());
            }
        }

        // Update the DB in table "list" at "list_assign_id"
        $select_list_assign_id = mysqli_query($conn, "SELECT * FROM list WHERE list_id = '$list_id'") or die(mysqli_error());
        $fetch_list = mysqli_fetch_array($select_list_assign_id);
        $list_assign_id = $fetch_list['list_assign_id'];
        $array_assign_id = explode(",", $list_assign_id); // convert string to array
        if($list_assign_id == "")
        {
            mysqli_query($conn, "UPDATE list SET list_assign_id='$member_id' WHERE list_id='$list_id'") or die(mysqli_error());
        }
        else
        {
            if (in_array($member_id, $array_assign_id))
            {}
            else
            {
                $multiple_assign = $list_assign_id.",".$member_id;
                mysqli_query($conn, "UPDATE list SET list_assign_id='$multiple_assign' WHERE list_id='$list_id'") or die(mysqli_error());
            }
        }
    }
    if(isset($_POST['add_due_date']))
    {
        $user_id = $_POST['user_id'];
        $task_id = $_POST['task_id'];
        $txt_date = $_POST['txt_date'];
        $txt_time = $_POST['txt_time'];
        $due_date_and_time = $txt_date. " " .$txt_time;
        $comment = 'Update Due Date to: "'.$due_date_and_time.'".';

        mysqli_query($conn, "INSERT INTO comment (comment_task_id, comment_user_id, comment_message, comment_date, comment_type) VALUES ($task_id, $user_id, '$comment', NOW(), 2)") or die(mysqli_error());
        mysqli_query($conn, "UPDATE task SET task_due_date = '$due_date_and_time' WHERE task_id='$task_id'") or die(mysqli_error());
    }
    if(isset($_POST['assign_tag']))
    {
        $task_id = $_POST['task_id'];
        $tasktag = $_POST['tag_id'];
        $user_id = $_POST['user_id'];
        $tag_name = $_POST['tag_name'];
        $comment = 'Update Tag to: "'.$tag_name.'".';

        $find_task = mysqli_query($conn, "SELECT * FROM task WHERE task_id = '$task_id'");
        $result_find_task = mysqli_fetch_array($find_task);
        $current_task_tag = $result_find_task['task_tag'];

        if($current_task_tag == "")
        {
            mysqli_query($conn, "UPDATE task SET task_tag='$tasktag' WHERE task_id='$task_id'") or die(mysqli_error());
            mysqli_query($conn, "INSERT INTO comment (comment_task_id, comment_user_id, comment_message, comment_date, comment_type) VALUES ($task_id, $user_id, '$comment', NOW(), 1)") or die(mysqli_error());
        }
        else
        {
            $current_array = explode(",", $current_task_tag); // convert string to array
            array_push($current_array,$tasktag); // insert the new user id to $current_array | ex. "1" then new array ==  [1,2,3,4,5,1]
            if(count($current_array) != count(array_unique($current_array))) // checking for existing element of array.
            {
                echo "error1";
            }
            else
            {
                $many_tag = $current_task_tag.",".$tasktag;
                mysqli_query($conn, "UPDATE task SET task_tag='$many_tag' WHERE task_id='$task_id'") or die(mysqli_error());
                mysqli_query($conn, "INSERT INTO comment (comment_task_id, comment_user_id, comment_message, comment_date, comment_type) VALUES ($task_id, $user_id, '$comment', NOW(), 1)") or die(mysqli_error());
            }
        }
    }
    if(isset($_POST['rename_task']))
    {
        $user_id = $_POST['user_id'];
        $task_id = $_POST['task_id'];
        $txt_modal_name = $_POST['txt_modal_name'];
        $comment = 'Update Task Name to: "'.$txt_modal_name.'".';

        mysqli_query($conn, "UPDATE task SET task_name='$txt_modal_name' WHERE task_id = '$task_id'") or die(mysqli_error());
        mysqli_query($conn, "INSERT INTO comment (comment_task_id, comment_user_id, comment_message, comment_date, comment_type) VALUES ($task_id, $user_id, '$comment', NOW(), 1)") or die(mysqli_error());
    }
    if(isset($_POST['delete_task']))
    {
        $space_id = $_POST['space_id'];
        $list_id = $_POST['list_id'];
        $task_id = $_POST['task_id'];
        $select = mysqli_query($conn, "SELECT * FROM task WHERE task_id = '$task_id'");
        $fetch = mysqli_fetch_array($select);
        /*if($fetch['task_contact'] == "")
        {
            mysqli_query($conn, "DELETE FROM task WHERE task_id='$task_id'") or die(mysqli_error());
        }
        else
        {
            echo "error1";
        }*/

        $task_contact = $fetch['task_contact'];
        $select_contact = mysqli_query($conn,"SELECT * FROM contact WHERE contact_id='$task_contact'");
        $fetch_contact = mysqli_fetch_array($select_contact);
        $contact_assign_to = $fetch_contact['contact_assign_to'];

        $select_space = mysqli_query($conn, "SELECT * FROM space WHERE space_id='$space_id'");
        $fetch_space_td_name = mysqli_fetch_array($select_space);
        $space_db = $fetch_space_td_name['space_db_table'];

        mysqli_query($conn, "DELETE FROM $space_db WHERE task_id='$task_id'") or die(mysqli_error());//remove task to specific space
        mysqli_query($conn, "DELETE FROM task WHERE task_id='$task_id'") or die(mysqli_error());//delete task

        // code to identify if contact has only 1 task, then delete contact and remove profile pic
        $assign_array = explode(",", $contact_assign_to); // convert string to array
        $count = count($assign_array);
        $tota_task = 0;
        for($x = 0; $x < $count; $x+=3)
        {
            $tota_task++;
        }

        if($tota_task == 1) // if contact has 1 task
        {
            if($fetch_contact['contact_profile'] != "")
            {
                //remove profile if has
                $existing_frofile = $fetch_contact['contact_profile'];
                array_map('unlink', glob("../client/client_profile/".$existing_frofile)); // remove image
            }
            mysqli_query($conn, "DELETE FROM contact WHERE contact_id='$task_contact'") or die(mysqli_error());//delete contact
        }
        else // else many then, update contact_assign_to
        {
            $key = array_search($space_id,$assign_array); // get the key or position of space
            unset($assign_array[$key]); // remove space_id from array
            unset($assign_array[$key+1]); // remove list_id from array
            unset($assign_array[$key+2]); // remove status_id from array

            $new_assign_to = implode(",",$assign_array); // convert array to string
            $update = mysqli_query($conn, "UPDATE contact SET contact_assign_to = '$new_assign_to' WHERE contact_id='$task_contact'") or die(mysqli_error());
        }
    }
    // ----------------------- END MODAL UPPER OPTION / ADD DETAILS -----------------------

    // ----------------------- MODAL REMOVE DETAILS -----------------------
    if(isset($_POST['remove_priority']))
    {
        $task_id = $_POST['task_id'];
        mysqli_query($conn,"UPDATE task set task_priority = '' where task_id = '$task_id'");
    }
    if(isset($_POST['remove_assign']))
    {
        $task_last_id = $_POST['list_id'];
        $task_id = $_POST['task_id'];
        $txt_assign_user_id = $_POST['assign_id'];

        // ___________________ Update the DB in table "list" at "list_assign_id"
        $count = 0;
        $get_task = mysqli_query($conn,"SELECT * FROM task WHERE task_list_id = '$task_last_id' ORDER BY task_id ASC"); //get last id
        while($fetch_get_task = mysqli_fetch_array($get_task))
        {
            $taskss_id = $fetch_get_task['task_assign_to'];
            $array = explode(",", $taskss_id);  // convert string to array
            if (in_array($txt_assign_user_id, $array))
            {
                $count++;
            }
            else
            {}
        }

        if($count == 1)
        {
            $find_list = mysqli_query($conn, "SELECT * FROM list WHERE list_id = '$task_last_id'") or die(mysqli_error());
            $result_find_list = mysqli_fetch_array($find_list);
            $list_assign_id = $result_find_list['list_assign_id'];
            $list_array = explode(",", $list_assign_id);  // convert string to array
            $find_different = array_diff($list_array, array($txt_assign_user_id));
            $finalarray = implode( ",", $find_different ); // convert array to string
            mysqli_query($conn, "UPDATE list SET list_assign_id='$finalarray' WHERE list_id = '$task_last_id'") or die(mysqli_error());
        }
        else{}
        // ___________________ End Update the DB in table "list" at "list_assign_id"

        $find_task = mysqli_query($conn, "SELECT * FROM task WHERE task_id = '$task_id'");
        $result_find_task = mysqli_fetch_array($find_task);
        $current_assign_to = $result_find_task['task_assign_to'];
        $current_array = explode(",", $current_assign_to);  // convert string to array
        $new_arr = array_diff($current_array, array($txt_assign_user_id));
        $final_array = implode( ",", $new_arr ); // convert array to string
        mysqli_query($conn, "UPDATE task SET task_assign_to='$final_array' WHERE task_id = '$task_id'") or die(mysqli_error());
    }
    if(isset($_POST['remove_due_date']))
    {
        $task_id = $_POST['task_id'];
        mysqli_query($conn,"UPDATE task set task_due_date = '0000-00-00 00:00:00' where task_id = '$task_id'");
    }
    if(isset($_POST['remove_tag']))
    {
        $txt_task_id = $_POST['task_id'];
        $tag_id = $_POST['tag_id'];
        $find_tag = mysqli_query($conn, "SELECT * FROM task WHERE task_id = '$txt_task_id'");
        $result_find_tag = mysqli_fetch_array($find_tag);
        $current_tag = $result_find_tag['task_tag'];
        $current_array = explode(",", $current_tag);  // convert string to array
        $new_arr = array_diff($current_array, array($tag_id));
        $final_array = implode( ",", $new_arr ); // convert array to string
        mysqli_query($conn, "UPDATE task SET task_tag='$final_array' WHERE task_id='$txt_task_id'") or die(mysqli_error());
    }
    // -----------------------  END MODAL REMOVE DETAILS -----------------------

    // -----------------------  ASSIGN FIELD -----------------------
    if(isset($_POST['display_field']))
    {
        echo '<option value=""></option>';
        $space_id = $_POST['space_id'];
        $list_id = $_POST['list_id'];
        $select_field = mysqli_query($conn, "SELECT * FROM field WHERE field_space_id ='$space_id' ORDER BY field_order ASC");
        while($result_select_field = mysqli_fetch_array($select_field))
        {
            $field_assign_to = $result_select_field['field_assign_to'];
            $assign_array = explode(",", $field_assign_to);
            if (in_array($list_id, $assign_array) == false)
            {
                echo '<option value="'.$result_select_field['field_id'].'">'.$result_select_field['field_name'].'</option>';
            }
        }
    }

    if(isset($_POST['display_assign_status']))
    {
        echo'<div class="row" style="padding: 0px 15px;">';
        $space_id = $_POST['space_id'];
        $list_id = $_POST['list_id'];
        $select_status = mysqli_query($conn, "SELECT * FROM status WHERE status_list_id ='$list_id' ORDER BY status_order_no ASC");
        while($result_select_status = mysqli_fetch_array($select_status))
        {
            echo'<div class="col-md-12" style="border-bottom: solid 1px '.$result_select_status['status_color'].'; border-left: solid 1px '.$result_select_status['status_color'].'; border-radius: 3px; padding: 5px 10px; margin: 5px 0px;">
                    <span><strong><i class="fa fa-square" style="color: '.$result_select_status['status_color'].';"></i> &nbsp;'.$result_select_status['status_name'].'</strong></span>';
                    $status_id = $result_select_status['status_id'];
                    $select_field = mysqli_query($conn, "SELECT * FROM field WHERE field_space_id = '$space_id' ORDER BY field_order ASC");
                    while($fetch_select_field = mysqli_fetch_array($select_field))
                    {
                        $field_assign_to = $fetch_select_field['field_assign_to'];

                        if($field_assign_to != "")
                        {
                            $assign_array = explode(",", $field_assign_to);
                            $key = array_search($list_id,$assign_array); // get the key or position of list
                            $statusid = $assign_array[$key+1];

                            if($status_id == $statusid)
                            {
                                echo'<div class="col-md-12" style="background-color: #eaeaea; border-radius: 3px; padding: 5px 10px; margin: 5px 0px; box-shadow: 0px 1px 1px 0px rgba(119, 119, 119, 0.27);-moz-box-shadow: 0px 1px 1px 0px rgba(119, 119, 119, 0.27);-webkit-box-shadow: 0px 1px 1px 0px rgba(119, 119, 119, 0.27);">
                                    <span><strong>&nbsp;'.$fetch_select_field['field_name'].'</strong></span>
                                    <span class="float-right" style="margin-top: -3px;">
                                        <button class="btn btn-sm btn-noborder btn-danger" id="'.$fetch_select_field['field_id'].'" onclick="remove_assign_field(this.id)"><i class="fa fa-trash"></i></button>
                                    </span>
                                </div>';
                            }
                        }
                    }
                echo'</div>';
        }
        echo "</div>";
    }

    if(isset($_POST['update_field_assign']))
    {
        $assign_field_id = $_POST['assign_field_id'];
        $field_assign_to = $_POST['list_id'].','.$_POST['assign_status_id'];

        $select_field = mysqli_query($conn, "SELECT * FROM field WHERE field_id = '$assign_field_id'");
        $fetch_select_field = mysqli_fetch_array($select_field);
        $prev_field_assign_to = $fetch_select_field['field_assign_to'];
        if($prev_field_assign_to == "")
        {
            mysqli_query($conn, "UPDATE field SET field_assign_to = '$field_assign_to' WHERE field_id = '$assign_field_id'") or die(mysqli_error());
        }
        else
        {
            $new_assign = $prev_field_assign_to.','.$field_assign_to;
            mysqli_query($conn, "UPDATE field SET field_assign_to = '$new_assign' WHERE field_id = '$assign_field_id'") or die(mysqli_error());
        }
    }

    if(isset($_POST['remove_assign_field']))
    {
        $list_id = $_POST['list_id'];
        $id = $_POST['id'];

        $select_field = mysqli_query($conn, "SELECT * FROM field WHERE field_id = '$id'");
        $fetch_select_field = mysqli_fetch_array($select_field);
        $field_assign_to = $fetch_select_field['field_assign_to'];

        $assign_array = explode(",", $field_assign_to); // convert string to array
        $count = count($assign_array);
        $tota_assign = 0;
        for($x = 0; $x < $count; $x+=2)
        {
            $tota_assign++;
        }

        if($tota_assign == 1)
        {
            mysqli_query($conn, "UPDATE field SET field_assign_to = '' WHERE field_id = '$id'") or die(mysqli_error());
        }
        else
        {
            $key = array_search($list_id,$assign_array); // get the key or position of list
            unset($assign_array[$key]); // remove list_id from array
            unset($assign_array[$key+1]); // remove status_id from array
            $new_assign = implode(",",$assign_array);
            mysqli_query($conn, "UPDATE field SET field_assign_to = '$new_assign' WHERE field_id = '$id'") or die(mysqli_error());
        }
    }
    // -----------------------  END ASSIGN FIELD -----------------------

    // -----------------------  SAVE NPUT FIELD -----------------------
    if(isset($_POST['save_input_in_task']))
    {
        $id = $_POST['user_id'];
        $space_id = $_POST['space_id'];
        $task_id = $_POST['task_id'];
        $field_id = $_POST['field_id'];
        $input_value = $_POST['input_value'];

        //auto create row specific space db
        $select_db = mysqli_query($conn, "SELECT * FROM space WHERE space_id ='$space_id'");
        $fetch_select_db = mysqli_fetch_array($select_db);
        $space_db_table = $fetch_select_db['space_db_table']; // getting the db_table name of the space

        $check_if_task_exist = mysqli_query($conn, "SELECT * FROM $space_db_table WHERE task_id ='$task_id'");
        $count1 = mysqli_num_rows($check_if_task_exist);
        if($count1 == 0)
        {
            mysqli_query($conn,"INSERT INTO `$space_db_table` (task_id) values ('$task_id')") or die(mysqli_error());
        }

        // another code below
        //$select_db = mysqli_query($conn, "SELECT * FROM space WHERE space_id ='$space_id'");
        //$fetch_select_db = mysqli_fetch_array($select_db);
        $count = mysqli_num_rows($select_db);
        if($count == 1)
        {
            //$space_db_table = $fetch_select_db['space_db_table']; // getting the db_table name of the space
            $slect_field = mysqli_query($conn, "SELECT * FROM field WHERE field_space_id ='$space_id'");
            $count_slect_field = mysqli_num_rows($slect_field);
            for($x = 0; $x < $count_slect_field; $x++)
            {
                //echo $x."<br>";
                $field_id_array = explode(",", $field_id); // convert string to array
                $final_field_id = $field_id_array[$x]; //getting every value from x = 0
                $input_value_array = explode(",", $input_value); // convert string to array
                $final_input_value = $input_value_array[$x]; //getting every value from x = 0

                $select_col_name = mysqli_query($conn, "SELECT * FROM field WHERE field_id ='$final_field_id'");
                $fetch_col_name = mysqli_fetch_array($select_col_name);
                $col_name = $fetch_col_name['field_col_name']; // get the col_name in db
                $field_name = $fetch_col_name['field_name']; // get the field_name in db
                $field_type = $fetch_col_name['field_type']; // get the field_name in db

                // Below is code for adding comment
                $select_if_has_value = mysqli_query($conn, "SELECT * FROM `$space_db_table` WHERE task_id = '$task_id'");
                $result = mysqli_fetch_array($select_if_has_value);
                $col_value = $result[''.$col_name.'']; // get current value

                if($col_value == $final_input_value) // check if current value == new value
                {} // no comment appear
                else if($col_value == "0000-00-00")
                {} // no comment appear - for field type date
                else
                {
                    if ($field_type == "Dropdown")// identify if dropdown
                    {
                        // get the value if specific option
                        $select_child = mysqli_query($conn, "SELECT * FROM `child` WHERE child_id = '$final_input_value'");
                        $fetch_result = mysqli_fetch_array($select_child);
                        $child_name = $fetch_result['child_name']; // get the child name

                        $msg = 'Update field name: "'.$field_name.'" value: "'.$child_name.'".';
                    }
                    else
                    {
                        $msg = 'Update field name: "'.$field_name.'" value: "'.$final_input_value.'".';
                    }
                    mysqli_query($conn,"INSERT into `comment` (comment_task_id, comment_user_id,    , comment_date, comment_type) values ('$task_id', '$id', '$msg', NOW(), '1')") or die(mysqli_error());
                }
                // END code for adding comment

                mysqli_query($conn, "UPDATE `$space_db_table` SET `$col_name` = '$final_input_value' WHERE task_id = '$task_id'") or die(mysqli_error());
            }
            echo "update";
        }
        else
        {
            echo "error1";
        }
    }
    // -----------------------  END SAVE INPUT FIELD -----------------------



    // -----------------------  FETCH CURRENCY -----------------------
    if(isset($_POST['fetch_currency']))
    {
        $md_mode = $_POST['md_mode'];
        $table = "";
        if($md_mode == "Dark") //insert
        {
            $table = "bg-primary-darker text-body-color-light";
        }
        echo '
        <table class="table table-bordered table-striped table-vcenter table-hover'.$table.' js-dataTable-full">
            <thead>
                <tr>
                    <th class="d-none d-sm-table-cell">DATE</th>
                    <th class="d-none d-sm-table-cell">NAME</th>
                    <th>CODE</th>
                    <th class="text-right">Value (USD)</th>
                    <th class="text-right">Value (PHP)</th>
                    <th class="text-center">Tools</th>
                </tr>
            </thead>
            <tbody>';
                $results = mysqli_query($conn, "SELECT * FROM finance_currency ORDER BY currency_name ASC");
                while($rows = mysqli_fetch_array($results))
                {
                    echo '
                    <tr>
                        <td class="d-none d-sm-table-cell">
                            '.$rows['currency_date'].'
                        </td>
                        <td class="d-none d-sm-table-cell">
                            '.$rows['currency_name'].'
                            <input type="hidden" class="form-control" value="'.$rows['currency_name'].'" id="currency_name'.$rows['currency_id'].'">
                        </td>
                        <td>
                            '.$rows['currency_code'].'
                            <input type="hidden" class="form-control" value="'.$rows['currency_code'].'" id="currency_code'.$rows['currency_id'].'">
                        </td>
                        <td class="text-right">
                            '.$rows['currency_val_usd'].'
                            <input type="hidden" class="form-control" value="'.$rows['currency_val_usd'].'" id="currency_val_usd'.$rows['currency_id'].'">
                        </td>
                        <td class="text-right">
                            '.$rows['currency_val_php'].'
                            <input type="hidden" class="form-control" value="'.$rows['currency_val_php'].'" id="currency_val_php'.$rows['currency_id'].'">
                        </td>
                        <td class="text-center">
                            <button class="btn btn-sm btn-noborder btn-primary" data-toggle="modal" data-target="#modal-currency" id="edit_currency'.$rows['currency_id'].'" onclick="edit_currency(this.id)"><i class="si si-pencil"></i></button>
                            <button class="btn btn-sm btn-noborder btn-danger" id="delete_currency'.$rows['currency_id'].'" onclick="delete_currency(this.id)"><i class="fa fa-trash"></i></button>
                        </td>
                    </tr>';
                }
                echo'
            </tbody>
        </table>';
    }
    // -----------------------  FETCH CURRENCY -----------------------
    // -----------------------  CREATE / UPDATE CURRENCY -----------------------
    if(isset($_POST['create_currency']))
    {
        $currency_id = $_POST['currency_id'];

        date_default_timezone_set('Asia/Manila');
        $todays_date = date("y-m-d H:i:sa"); //  original format
        $currency_name = $_POST['currency_name'];
        $currency_code = $_POST['currency_code'];
        $currency_val_usd = $_POST['currency_val_usd'];
        $currency_val_php = $_POST['currency_val_php'];
        if($currency_id == "")
        {
            mysqli_query($conn,"INSERT INTO finance_currency (currency_date, currency_name, currency_code, currency_val_usd, currency_val_php) values ('$todays_date','$currency_name','$currency_code','$currency_val_usd','$currency_val_php')") or die(mysqli_error());
            echo "Insert";
        }
        else
        {
            mysqli_query($conn,"UPDATE finance_currency set currency_date = '$todays_date', currency_name = '$currency_name', currency_code = '$currency_code', currency_val_usd = '$currency_val_usd', currency_val_php = '$currency_val_php' where currency_id = '$currency_id'");
            echo "Update";
        }
    }
    // -----------------------  END CREATE / UPDATE CURRENCY -----------------------
    // -----------------------  DELETE CURRENCY -----------------------
    if(isset($_POST['delete_currency']))
    {
        $currency_id = $_POST['currency_id'];
        mysqli_query($conn,"DELETE from finance_currency where currency_id = '$currency_id'");
    }
    // -----------------------  END DELETE CURRENCY -----------------------

    // -----------------------  CREATE FINANCE PHASE -----------------------
    if(isset($_POST['create_finance_phase']))
    {
        $space_id = $_POST['space_id'];
        $finance_phase_name = $_POST['finance_phase_name'];
        mysqli_query($conn,"INSERT INTO finance_phase (phase_space_id, phase_name) values ('$space_id','$finance_phase_name')") or die(mysqli_error());
    }
    // -----------------------  END CREATE FINANCE PHASE -----------------------
    // -----------------------  FETCH FINANCE PHASE -----------------------
    if(isset($_POST['fetch_finance_phase']))
    {
        $space_id = $_POST['space_id'];
        $results = mysqli_query($conn, "SELECT * FROM finance_phase WHERE phase_space_id = '$space_id' ORDER BY phase_id ASC");
            while($rows = mysqli_fetch_array($results))
            {
                 echo'<li class="scrumboard-item btn-alt-warning" style="box-shadow: 0px 1px 1px 0px rgba(119, 119, 119, 0.27);-moz-box-shadow: 0px 1px 1px 0px rgba(119, 119, 119, 0.27);-webkit-box-shadow: 0px 1px 1px 0px rgba(119, 119, 119, 0.27); height: 20px;">
                        <div class="scrumboard-item-options">
                            <input type="hidden" value="'.$rows['phase_name'].'" id="phase_name'.$rows['phase_id'].'">
                            <button class="btn btn-sm btn-noborder btn-primary" data-toggle="modal" data-target="#modal-editfinancephase" data-dismiss="modal" id="edit_finance_phase'.$rows['phase_id'].'" onclick="edit_finance_phase(this.id)"><i class="si si-pencil"></i></button>
                            <button class="btn btn-sm btn-noborder btn-danger" id="delete_finance_phase'.$rows['phase_id'].'" onclick="delete_finance_phase(this.id)"><i class="fa fa-trash"></i></button>
                        </div>
                        <div class="scrumboard-item-content">
                            <label>'.$rows['phase_name'].'</label>
                            <button type="submit" hidden="hidden" class="btn btn-primary btn-noborder mr-1 mb-5" name="btn_modal_status_names"><i class="fa fa-check"></i></button>
                        </div>
                </li>';
            }
    }
    // -----------------------  END FETCH FINANCE PHASE -----------------------
    // -----------------------  EDIT FINANCE PHASE -----------------------
    if(isset($_POST['edit_finance_phase']))
    {
        $edit_finance_phase_id = $_POST['edit_finance_phase_id'];
        $edit_finance_phase_name = $_POST['edit_finance_phase_name'];
        mysqli_query($conn,"UPDATE finance_phase set phase_name = '$edit_finance_phase_name' where phase_id = '$edit_finance_phase_id'");
    }
    // -----------------------  END EDIT FINANCE PHASE -----------------------
    // -----------------------  DELETE FINANCE PHASE -----------------------
    if(isset($_POST['delete_finance_phase']))
    {
        $field_id = $_POST['field_id'];

        $select_phase = mysqli_query($conn, "SELECT * FROM finance_field WHERE finance_phase_id ='$field_id'");
        $count = mysqli_num_rows($select_phase);
        if($count > 0) // cannot delete if has field under specific phase
        {
            echo 'Delete the field under this phase first to delete this phase.';
        }
        else // delete
        {
            echo 'Phase deleted.';
            mysqli_query($conn,"DELETE from finance_phase where phase_id = '$field_id'");
        }
    }
    // -----------------------  END DELETE FINANCE PHASE -----------------------
    // -----------------------  FINANCE FETCH PHASE SELECTOR -----------------------
    if(isset($_POST['phase_select']))
    {
        $space_id = $_POST['space_id'];
        echo'
        <select class="form-control text-muted mb-10" onchange="status3(this)" style="width: 100%;">
            <option value="">Select phase...</option>';
                $select_phase = mysqli_query($conn, "SELECT * FROM finance_phase WHERE phase_space_id ='$space_id' ORDER BY phase_id ASC");
                while($rows = mysqli_fetch_array($select_phase))
                {
                    echo '<option value="'.$rows['phase_id'].'">'.$rows['phase_name'].'</option>';
                }
        echo '
        </select>';
    }
    // -----------------------  END FINANCE FETCH PHASE SELECTOR -----------------------
    // -----------------------  FINANCE FETCH FIELD BY PHASE -----------------------
    if(isset($_POST['fetch_finance_field_by_phase']))
    {
        $user_type = $_POST['user_type'];
        $task_id = $_POST['task_id'];
        $phase_id = $_POST['phase_id'];

        echo'
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover table-vcenter shad">
                <thead>
                    <tr>
                        <th class="text-center">Tools</th>
                        <th class="text-left">ID</th>
                        <th class="text-left">Payment_name</th>
                        <th class="text-right" style="width: 20%;">CURRENCY</th>
                        <th class="text-right" style="width: 20%;">AMOUNT(USD)</th>
                    </tr>
                </thead>
                <tbody>';
                    $select_field = mysqli_query($conn, "SELECT * FROM finance_field WHERE finance_phase_id = '$phase_id' ORDER BY finance_order ASC");
                    $total_amount = 0;
                    while($fetch_select_field = mysqli_fetch_array($select_field))
                    {
                        $field_id = $fetch_select_field['finance_id'];

                        $select_custom_amount = mysqli_query($conn, "SELECT * FROM finance_field_ca WHERE custom_amount_task_id = '$task_id' AND custom_amount_field_id = '$field_id'");
                        $fetch_custom_amount = mysqli_fetch_array($select_custom_amount);
                        $count1 = mysqli_num_rows($select_custom_amount);

                        $select_finance_field_hs = mysqli_query($conn, "SELECT * FROM finance_field_hide WHERE hideshow_task_id = '$task_id' AND hideshow_field_id = '$field_id' LIMIT 1");
                        $fetch_hs = mysqli_fetch_array($select_finance_field_hs);
                        $count = mysqli_num_rows($select_finance_field_hs);
                        if($count == 1) // if field is hide in specific task
                        {
                            echo'
                            <tr class="bg-danger-light">
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-primary" title="Show" id="show_field_per_task'.$fetch_select_field['finance_id'].'" onclick="show_field_per_task(this.id)">
                                        <i class="fa fa-eye"></i>
                                    </button>';
                        }
                        else
                        {
                            echo'
                            <tr>
                                <td class="text-center">
                                    <button type="button" class="btn btn-sm btn-secondary" title="Hide" id="hide_field_per_task'.$fetch_select_field['finance_id'].'" onclick="hide_field_per_task(this.id)">
                                        <i class="fa fa-eye-slash"></i>
                                    </button>';
                                        if($count1 == 1) // if has custom amount
                                        {
                                            $amount = $fetch_custom_amount['custom_amount_value'] == 0 ? '' : number_format((float)$fetch_custom_amount['custom_amount_value'],2,".",'');
                                            $total_amount += $amount;
                                        }
                                        else
                                        {
                                            $amount = $fetch_select_field['finance_value'] == 0 ? '' : number_format((float)$fetch_select_field['finance_value'],2,".",'');
                                            $total_amount += $amount;
                                        }
                        }
                        echo '
                                    <button type="button" class="btn btn-sm btn-secondary" title="Edit amount" id="edit_amount_per_task'.$fetch_select_field['finance_id'].'" onclick="edit_amount_per_task(this.id)">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                </td>
                                <td>'.$fetch_select_field['finance_id'].'</td>
                                <td>'.$fetch_select_field['finance_name'].'</td>
                                <td class="text-right">'.$fetch_select_field['finance_currency'].'</td>
                                <td class="text-right">';
                                    if($count1 == 1) // if has custom amount
                                    {
                                        echo '
                                        '.number_format($fetch_custom_amount['custom_amount_value'],2).'
                                        <input type="hidden" class="form-control" style="text-align: right;" value="'.$fetch_select_field['finance_name'].'" id="name_field_per_task'.$fetch_select_field['finance_id'].'">
                                        <input type="hidden" class="form-control" style="text-align: right;" value="'.$fetch_custom_amount['custom_amount_value'].'" id="amount_field_per_task'.$fetch_select_field['finance_id'].'">
                                        ';
                                    }
                                    else
                                    {
                                        echo '
                                        '.number_format($fetch_select_field['finance_value'],2).'
                                        <input type="hidden" class="form-control" style="text-align: right;" value="'.$fetch_select_field['finance_name'].'" id="name_field_per_task'.$fetch_select_field['finance_id'].'">
                                        <input type="hidden" class="form-control" style="text-align: right;" value="'.$fetch_select_field['finance_value'].'" id="amount_field_per_task'.$fetch_select_field['finance_id'].'">
                                        ';
                                    }
                                    echo'
                                </td>
                            </tr>';
                    }
                    $total_paid = 0;
                    $total_due = $total_amount - $total_paid;
                    echo'
                    <tr class="table-success">';
                        echo'
                        <td colspan="4" class="text-right font-w600">Total Amount:</td>
                        <td class="text-right font-w600"><input type="hidden" value="'.$total_amount.'" id="totaldue'.$phase_id.'"> '.number_format($total_amount,2).'</td>
                    </tr>
                    <tr>';

                            echo'
                </tbody>
            </table>
        </div>
        ';
        // $select_remarks = mysqli_query($conn, "SELECT * FROM finance_remarks WHERE remarks_to = '$task_id' AND remarks_phase_id = '$phase_id'");
        //                     $fetch_select_remarks = mysqli_fetch_array($select_remarks);
        //                     $remarks_value = $fetch_select_remarks['remarks_value'];
        //                     if($user_type == "Admin")
        //                     {
        //                         echo '
        //                         <td class="text-right font-w600">Select remarks:</td>
        //                         <td class="text-right font-w600">
        //                             <select class="form-control text-muted" id="select_remarks" onchange="select_remarks(this)">
        //                                 <option value=""></option>
        //                                 <option value="Payment received">Payment received</option>
        //                                 <option value="Payment encoded">Payment encoded</option>
        //                                 <option value="On hold">On hold</option>
        //                                 <option value="Pending">Pending</option>
        //                                 <option value="Waiting to be received">Waiting to be received</option>
        //                                 <option value="Refunded">Refunded</option>
        //                             </select>
        //                         </td>
        //                         <td colspan="2" class="text-right font-w600">Remarks:</td>
        //                         <td class="text-right font-w600">';
        //                             if($remarks_value != "")
        //                             {
        //                                 echo '<input type="text" class="form-control" style="text-align: center;" value="'.$fetch_select_remarks['remarks_value'].'" readonly>';
        //                             }
        //                             else
        //                             {
        //                                 echo '<input type="text" class="form-control" style="text-align: center;" value="" readonly>';
        //                             }
        //                             echo '
        //                         </td>
        //                         </tr>';
        //                     }
        //                     else
        //                     {
        //                         echo '
        //                         <td class="text-right font-w600" colspan="4">Remarks:</td>
        //                         <td class="text-right font-w600">
        //                             <input type="text" class="form-control" style="text-align: center;" value="'.$fetch_select_remarks['remarks_value'].'" readonly>
        //                         </td>
        //                         </tr>
        //                         ';
        //                     }

    }
    // -----------------------  END FINANCE FETCH FIELD BY PHASE -----------------------
    // -----------------------  DISPLAY DISCOUNTED AMOUNT -----------------------
    if(isset($_POST['display_discount']))
    {
        $task_id = $_POST['task_id2'];
        $phase_id = $_POST['phase_id2'];
        $select_discount = mysqli_query($conn, "SELECT * FROM finance_discount WHERE discount_phase_id = '$phase_id' AND discount_assign_to = '$task_id'");
        $fetch_select_discount = mysqli_fetch_array($select_discount);
        $discount_id = $fetch_select_discount['discount_id'];
        $discount_amount = $fetch_select_discount['discount_amount'];

        $count = mysqli_num_rows($select_discount);
        if($count == 1)
        {
            echo $discount_id.'|'.$discount_amount;
        }
        else
        {
            echo "|";
        }
    }
    // -----------------------  END DISPLAY DISCOUNTED AMOUNT -----------------------
    // -----------------------  add hide_field_per_task -----------------------
    if(isset($_POST['hide_field_per_task']))
    {
        $user_id = $_POST['user_id'];
        $task_id = $_POST['task_id'];
        $field_id = $_POST['field_id'];

        $select_hide = mysqli_query($conn, "SELECT * FROM finance_field_hide WHERE hideshow_task_id = '$task_id' AND hideshow_field_id = '$field_id'");
        $fetch_select_hide = mysqli_fetch_array($select_hide);
        $hideshow_id = $fetch_select_hide['hideshow_id'];
        mysqli_query($conn,"INSERT INTO finance_field_hide values ('','$user_id','$task_id','$field_id')") or die(mysqli_error());
    }
    // -----------------------  END add hide_field_per_task -----------------------
    // -----------------------  show_field_per_task -----------------------
    if(isset($_POST['show_field_per_task']))
    {
        $user_id = $_POST['user_id'];
        $task_id = $_POST['task_id'];
        $field_id = $_POST['field_id'];

        $select_hide = mysqli_query($conn, "SELECT * FROM finance_field_hide WHERE hideshow_task_id = '$task_id' AND hideshow_field_id = '$field_id'");
        // $fetch_select_hide = mysqli_fetch_array($select_hide);
        // $hideshow_id = $fetch_select_hide['hideshow_id'];
        // $count = mysqli_num_rows($select_hide);
        // if($count == 1)
        while($data = mysqli_fetch_array($select_hide))
        {
      			$hideshow_id = $data['hideshow_id'];
            mysqli_query($conn,"DELETE from finance_field_hide where hideshow_id = '$hideshow_id'") or die(mysqli_error());// delete
            echo 'update';
        }
    }
    // -----------------------  END show_field_per_task -----------------------
    // -----------------------  edit_amount_per_task -----------------------
    if(isset($_POST['save_field_amount_per_task']))
    {
        $user_id = $_POST['user_id'];
        $task_id = $_POST['task_id'];
        $field_id = $_POST['field_id'];
        $field_amount = $_POST['field_amount'];

        $select_custom_amount = mysqli_query($conn, "SELECT * FROM finance_field_ca WHERE custom_amount_task_id = '$task_id' AND custom_amount_field_id = '$field_id'");
        $fetch_custom_amount = mysqli_fetch_array($select_custom_amount);
        $custom_amount_id = $fetch_custom_amount['custom_amount_id'];
        $count = mysqli_num_rows($select_custom_amount);

        if($count == 1)
        {
            mysqli_query($conn, "UPDATE `finance_field_ca` SET `custom_amount_user_id` = '$user_id', `custom_amount_value` = '$field_amount' WHERE custom_amount_id = '$custom_amount_id'") or die(mysqli_error());
            echo 'Amount updated successfully.';
        }
        else
        {
            mysqli_query($conn, "INSERT into finance_field_ca values('','$user_id','$task_id','$field_id','$field_amount')") or die(mysqli_error());
            echo 'Amount change successfully.';
        }
    }
    // -----------------------  END edit_amount_per_task -----------------------

    // -----------------------  ADD REMARKS -----------------------
    if(isset($_POST['add_remarks']))
    {
        $user_id = $_POST['user_id'];
        $task_id = $_POST['task_id'];
        $phase_id = $_POST['phase_id'];
        $remarks_value = $_POST['remarks_value'];

        // echo $user_id. ' '.$task_id. ' '.$phase_id. ' '.$remarks_value;
        $select_remarks = mysqli_query($conn, "SELECT * FROM finance_remarks WHERE remarks_to = '$task_id' AND remarks_phase_id = '$phase_id'");
        // $count = mysqli_num_rows($select_remarks);
        // echo $count;
        $fetch_remarks = mysqli_fetch_array($select_remarks);
        // echo $fetch_remarks;
        $remarks_id = $fetch_remarks['remarks_id'];
        // echo $remarks_id;
        $count = mysqli_num_rows($select_remarks);
        // echo $count;
        if($count == 1)
        {
            mysqli_query($conn, "UPDATE `finance_remarks` SET `remarks_by` = '$user_id', `remarks_value` = '$remarks_value' WHERE remarks_id = '$remarks_id'") or die(mysqli_error());
            echo 'update';
        }
        else
        {
            mysqli_query($conn,"INSERT INTO finance_remarks values (' ','$user_id','$task_id','$phase_id','$remarks_value',' ',' ')") or die(mysqli_error());
            echo 'insert';
        }
    }
    // -----------------------  END ADD REMARKS -----------------------




    // -----------------------  ADD DISCOUNT -----------------------
    if(isset($_POST['add_discount']))
    {
        $disc_id = $_POST['disc_id'];
        $user_id = $_POST['user_id'];
        $phase_id = $_POST['phase_id'];
        $task_id = $_POST['task_id'];
        $disc_amount = $_POST['disc_amount'];

        $select_discount = mysqli_query($conn, "SELECT * FROM finance_discount WHERE discount_phase_id = '$phase_id' AND discount_assign_to = '$task_id'");
        $fetch = mysqli_fetch_array($select_discount);
        $count = mysqli_num_rows($select_discount);

        if($count == 1) // if has existing discount
        {
            $id = $fetch['discount_id'];
            mysqli_query($conn, "UPDATE `finance_discount` SET `discount_by` = '$user_id', `discount_amount` = '$disc_amount' WHERE discount_id = '$disc_id'") or die(mysqli_error());
            echo 'Discount updated successfully.';
        }
        else
        {
            mysqli_query($conn, "INSERT INTO finance_discount (discount_by, discount_phase_id, discount_assign_to, discount_amount) values ('$user_id','$phase_id','$task_id','$disc_amount')") or die(mysqli_error());
            echo 'Discount added successfully.';
        }

    }
    // -----------------------  END ADD DISCOUNT -----------------------

    // -----------------------  Update DISCOUNT -----------------------
    // if(isset($_POST['update_disc_amount']))
    // {
    //     $disc_id = $_POST['disc_id'];
    //     $disc_amount = $_POST['disc_amount'];
    //     $user_id = $_POST['user_id'];
    //
    //     mysqli_query($conn, "UPDATE finance_discount SET discount_by = '$user_id', discount_amount = '$disc_amount' WHERE discount_id = '$disc_id'") or die(mysqli_error());
    //     echo 'success';
    // }
    // -----------------------  END Update DISCOUNT -----------------------


    // -----------------------  SAVE FINANCE TRANSACTION -----------------------
    if(isset($_POST['save_transaction']))
    {
        $user_id = $_POST['user_id'];
        $phase_id = $_POST['phase_id'];
        $task_id = $_POST['task_id'];
        $tran_date = $_POST['tran_date'];
        $tran_method = $_POST['tran_method'];
        $tran_transaction_no = $_POST['tran_transaction_no'];
        $tran_currency = $_POST['tran_currency'];
        $tran_amount = $_POST['tran_amount'];
        $date1 = date('Y-m-d H:i:s');

        $tran_charge = $_POST['tran_charge'];
        $tran_charge_type = $_POST['tran_charge_type'];
        if($tran_charge == "")
        {
            $charge = "|";
        }
        else
        {
            $charge = $tran_charge_type.'|'.$tran_charge;
        }

        $tran_client_rate = $_POST['tran_client_rate'];
        $tran_note = $_POST['tran_note'];
        $tran_initial = $_POST['tran_initial'];
        $tran_usd_rate = $_POST['tran_usd_rate'];
        $tran_usd_total = $_POST['tran_usd_total'];
        $tran_php_rate = $_POST['tran_php_rate'];
        $tran_php_total = $_POST['tran_php_total'];
        $tran_client_php_total = $_POST['tran_client_php_total'];
        $comment = 'Add new payment|Trans. No '.$tran_transaction_no.' |Amount: $'.$tran_usd_total.'';

        $attachment_name = $_FILES['file_attachment']['name'];
        $attachment_temp = $_FILES['file_attachment']['tmp_name'];
        $attachment_size = $_FILES['file_attachment']['size'];
        $exp = explode(".", $attachment_name);
        $ext = end($exp);
        $allowed_ext = array('jpg', 'JPG', 'jpeg', 'JPEG', 'png', 'PNG');
        if(in_array($ext, $allowed_ext)) // check the file extension
        {
            date_default_timezone_set('Asia/Manila');
            //$todays_date = date("y-m-d H:i:sa"); //  original format
            $date = date("His"); // for unique file name

            $words = explode(' ',trim($attachment_name)); // convert name to array
            $get_name = substr($words[0], 0, 6); // get only 6 character of the name

            $image = $date.'-'.$get_name.'.'.$ext;
            $location = "../assets/media/transaction/".$image; // upload location
            if($attachment_size < 10000000) // Maximum 10 MB
            {
                move_uploaded_file($attachment_temp, $location);
                mysqli_query($conn,"INSERT INTO comment (comment_task_id, comment_user_id, comment_message, comment_date, comment_type) values ($task_id, $user_id, '$comment', '$date1', 1)") or die(mysqli_error());
                mysqli_query($conn,"INSERT INTO finance_transaction (val_add_by, val_phase_id, val_assign_to, val_date, val_method, val_transaction_no, val_currency, val_amount, val_charge, val_initial_amount, val_usd_rate, val_usd_total, val_php_rate, val_php_total, val_client_rate, val_client_total, val_note, val_attachment) values ('$user_id','$phase_id','$task_id','$tran_date','$tran_method','$tran_transaction_no','$tran_currency','$tran_amount','$charge','$tran_initial','$tran_usd_rate','$tran_usd_total','$tran_php_rate','$tran_php_total','$tran_client_rate','$tran_client_php_total','$tran_note','$image')") or die(mysqli_error());
                echo "success";
            }
            else
            {
                echo "error3";
            }
        }
        else
        {
            echo "error2";
        }
    }
    // -----------------------  END SAVE FINANCE TRANSACTION -----------------------
    // -----------------------  FETCH TRANSACTION BY PHASE -----------------------
    if(isset($_POST['fetch_transaction_by_phase']))
    {
        $phase_id = $_POST['phase_id'];
        $task_id = $_POST['task_id'];


        $select_discount = mysqli_query($conn, "SELECT * FROM finance_discount WHERE discount_phase_id = '$phase_id' AND discount_assign_to = '$task_id'");
        $fetch_select_discount = mysqli_fetch_array($select_discount);
        $discount_amount = $fetch_select_discount['discount_amount'] == 0 ? '' : number_format((float)$fetch_select_discount['discount_amount'],2,".",'');

        $select_field = mysqli_query($conn, "SELECT * FROM finance_field WHERE finance_phase_id = '$phase_id' AND finance_type = 'text' ORDER BY finance_order ASC");
        $total_amount = 0;
        while($fetch_select_field = mysqli_fetch_array($select_field))
        {
            $field_id = $fetch_select_field['finance_id'];
            //$total_amount += $fetch_select_field['finance_value'] == 0 ? '' : number_format((float)$fetch_select_field['finance_value'],2,".",'');
            $select_custom_amount = mysqli_query($conn, "SELECT * FROM finance_field_ca WHERE custom_amount_task_id = '$task_id' AND custom_amount_field_id = '$field_id'");
            $fetch_custom_amount = mysqli_fetch_array($select_custom_amount);
            $count1 = mysqli_num_rows($select_custom_amount);

            $select_finance_field_hs = mysqli_query($conn, "SELECT * FROM finance_field_hide WHERE hideshow_task_id = '$task_id' AND hideshow_field_id = '$field_id'");
            $fetch_hs = mysqli_fetch_array($select_finance_field_hs);
            $count = mysqli_num_rows($select_finance_field_hs);
            if($count == 0) // check if this field is visible in this task
            {
                if($count1 == 1) // if has custom amount
                {
                    $amount = $fetch_custom_amount['custom_amount_value'] == 0 ? '' : number_format((float)$fetch_custom_amount['custom_amount_value'],2,".",'');
                    $total_amount += $amount;
                }
                else
                {
                    $amount = $fetch_select_field['finance_value'] == 0 ? '' : number_format((float)$fetch_select_field['finance_value'],2,".",'');
                    $total_amount += $amount;
                }
            }
        }

        $query = mysqli_query($conn, "SELECT * FROM tbl_remarks");
        while ($data = mysqli_fetch_array($query)) {
            echo '
                <span style="background-color:'.$data['remarks_color'].';" class="badge text-white">'.$data['remarks_value'].'</span>
            ';
        }

        echo'
        <span style="background-color:red;" class="badge text-white">No Remarks</span>
        <div class="table-responsive">
            <table class="js-table-sections table table-bordered table-striped table-hover table-vcenter shad">
                <thead>
                    <tr>
                        <th class="text-left">Date</th>
                        <th class="text-left">Remittance</th>
                        <th class="text-left">Trans_no</th>
                        <th class="text-center">Currency</th>
                        <th class="text-center">Amount</th>
                        <th class="text-center">Charge</th>
                        <th class="text-center">Initial</th>
                        <th class="text-center">Rate(UPC)</th>
                        <th class="text-right">Amount(USD)</th>
                        <th class="text-right">Amount(PHP)</th>
                        <th class="text-right">Amount(PAID)</th>
                    </tr>
                </thead>
                <tbody>';
                    $USD_tot = 0;
                    $PHP_tot = 0;
                    $PHP_tot_client = 0;
                    $transaction = mysqli_query($conn, "SELECT * FROM finance_transaction WHERE val_phase_id = '$phase_id' AND val_assign_to = '$task_id' ORDER BY val_date DESC");
                    while($rows = mysqli_fetch_array($transaction))
                    {
                        $USD_tot += $rows['val_usd_total'];
                        $PHP_tot += $rows['val_php_total'];
                        $PHP_tot_client += $rows['val_client_total'];

                        $val_php_total = $rows['val_php_total'];
                        $val_client_total = $rows['val_client_total'];
                        $val_remarks = $rows['val_remarks'];
                        $query_remarks = mysqli_query($conn, "SELECT * FROM tbl_remarks WHERE remarks_value = '$val_remarks'");
                        $num = mysqli_num_rows($query_remarks);
                        if ($num) {
                            while($row = mysqli_fetch_array($query_remarks))
                            {
                                $color = $row["remarks_color"];
                                $text = 'text-white';
                            }
                        } else {
                                $color = 'red';
                                $text = 'text-white';
                        }
                        // if ($val_remarks == 'Payment received') {
                        //     $color = 'green';
                        //     $text = 'text-white';
                        // }
                        // if ($val_remarks == 'On hold') {
                        //     $color = '#c7c10c';
                        //     $text = 'text-white';
                        // }
                        // if ($val_remarks == 'Pending') {
                        //     $color = '#b4c04c';
                        //     $text = 'text-white';
                        // }
                        // if ($val_remarks == 'Waiting to be received') {
                        //     $color = 'blue';
                        //     $text = 'text-white';
                        // }
                        // if ($val_remarks == 'Refunded') {
                        //     $color = '#1db394';
                        //     $text = 'text-white';
                        // }
                        // if ($val_remarks == 'Payment encoded') {
                        //     $color = '#45A4AB';
                        //     $text = 'text-white';
                        // }
                        // if ($val_remarks == '') {
                        //     $color = 'red';
                        //     $text = 'text-white';
                        // }
                        echo '
                        <tr style="background-color:'.$color.';" class="'.$text.'">
                            <td>'.$rows['val_date'].'</td>
                            <td>'.$rows['val_method'].'</td>
                            <td>'.$rows['val_transaction_no'].'</td>
                            <td class="text-center">'.$rows['val_currency'].'</td>
                            <td class="text-center">'.number_format($rows['val_amount'],2).'</td>
                            <td class="text-center">'.$rows['val_charge'].'</td>
                            <td class="text-center">'.number_format($rows['val_initial_amount'],2).'</td>
                            <td class="text-center">'.$rows['val_usd_rate'].'|'.$rows['val_php_rate'].'|'.$rows['val_client_rate'].'</td>
                            <td class="text-right">$'.number_format($rows['val_usd_total'],2).'</td>
                            <td class="text-right">₱'.number_format($val_php_total,2).'</td>
                            <td class="text-right">‭₱'.number_format($val_client_total,2).'</td>
                        </tr>
                        ';
                    }
                    $USD_paid = $USD_tot;
                    $PHP_paid = $PHP_tot;
                    $PHP_paid_client = $PHP_tot_client;

                    $USD_depo = 0.00;
                    $PHP_depo = 0.00;
                    $PHP_depo_client = 0.00;

                    if($discount_amount == "") // check if no discount
                    {
                        $USD_bal = $total_amount;
                        $USD_bal = $total_amount - $USD_paid;
                        if($USD_bal < 0)
                        {
                            $USD_depo = $USD_bal * (-1);
                            if($USD_tot == 0)
                            {
                                $PHP_depo = 0.00;
                            }
                            else
                            {
                                $PHP_depo = $USD_depo * $PHP_tot / $USD_tot;
                            }
                            $USD_bal = 0.00;
                        }
                    }
                    else // has discount
                    {
                        if($USD_paid == "0") // if USD paid == 0
                        {
                            $USD_bal = $total_amount - $discount_amount;
                        }
                        else // else USD paid != 0
                        {
                            $deduct = $discount_amount + $USD_paid;
                            $USD_bal = $total_amount - $deduct;
                        }

                        if($USD_bal < 0) // if USD Balace is negative
                        {
                            $USD_depo = $USD_bal * (-1);
                            $PHP_depo = $USD_depo * $PHP_tot / $USD_tot;
                            $USD_bal = 0.00;
                        }
                    }

                    // Code in getting client BALANCE & DEPOSIT
                    if($USD_tot == 0) // check if no USD paid or payment
                    {
                        $PHP_bal = 0;
                        $PHP_bal_client = 0;
                    }
                    else // else has payment
                    {
                        $PHP_bal = $USD_bal * $PHP_tot / $USD_tot;// apply ratio and proportion formula
                        $difference = $PHP_paid - $PHP_paid_client;
                        $PHP_bal_client = $difference + $PHP_bal;// apply ratio and proportion formula
                        if($PHP_depo != 0) // if IPASS php deposit is not equal to 0
                        {
                            $PHP_depo_client = $PHP_depo - $PHP_bal_client;
                            if($PHP_depo_client < 0) // if Client deposit is negative
                            {
                                $PHP_bal_client = $PHP_depo_client * (-1);
                                $PHP_depo_client = 0;
                            }
                            else
                            {
                                $PHP_bal_client = 0;
                            }
                        }

                        if($PHP_bal_client < 0)// if Client balance is negative, meaninng client rate is greater than IPASS rate
                        {
                            $PHP_depo_client = $PHP_bal_client * (-1);
                            $PHP_bal_client = 0;
                        }
                    }
// END IPASS Total amount, Deposit, Balance
                    echo'
                </tbody>
                    <tr>
                        <td colspan="8" class="text-right font-w600">Total Amount:</td>
                        <td class="text-right font-w600">$'.number_format($USD_paid,2).'</td>
                        <td class="text-right font-w600">₱'.number_format($PHP_paid,2).'</td>
                        <td class="text-right font-w600">₱'.number_format($PHP_paid_client,2).'</td>
                    </tr>
                    <tr>
                        <td colspan="8" class="text-right font-w600">Deposit:</td>
                        <td class="text-right font-w600">$'.number_format($USD_depo,2).'</td>
                        <td class="text-right font-w600">₱'.number_format($PHP_depo,2).'</td>
                        <td class="text-right font-w600">₱'.number_format($PHP_depo_client,2).'</td>
                    </tr>
                    <tr class="table-success">
                        <td colspan="7" class="font-w600 text-uppercase">';
                        if($discount_amount == "")
                        {
                            echo 'No discount';
                        }
                        else
                        {
                            echo 'Less '.$discount_amount.' discount';
                        }
                        echo '
                        </td>
                        <td class="text-right font-w600 text-uppercase">Balance:</td>
                        <td class="text-right font-w600">$'.number_format($USD_bal,2).'</td>
                        <td class="text-right font-w600">₱'.number_format($PHP_bal,2).'</td>
                        <td class="text-right font-w600">₱'.number_format($PHP_bal_client,2).'</td>
                    </tr>
            </table>
        </div>
        ';
    }
    // -----------------------  END FETCH TRANSACTION BY PHASE -----------------------


    // -----------------------  CREATE FINANCE FIELD TEXT -----------------------
    if(isset($_POST['create_finance_field_text']))
    {
        $space_id = $_POST['space_id'];
        $field_id = $_POST['field_id'];
        $finance_text_field_id = $_POST['finance_text_field_id'];
        $finance_field_name = $_POST['finance_field_name'];
        $finance_privacy_text = $_POST['finance_privacy_text'];
        $finance_currency_text = $_POST['finance_currency_text'];
        $finance_converter_value = $_POST['finance_converter_value'];

        if($finance_text_field_id == "") // insert
        {
            $select_finance_field = mysqli_query($conn, "SELECT * FROM finance_field WHERE finance_space_id = '$space_id' AND finance_phase_id = '$field_id'");
            $count = mysqli_num_rows($select_finance_field);
            if($count == 0)
            {
                mysqli_query($conn,"INSERT INTO finance_field (finance_space_id, finance_phase_id, finance_name, finance_currency, finance_value, finance_type, finance_privacy) values ('$space_id','$field_id','$finance_field_name','$finance_currency_text','$finance_converter_value','text','$finance_privacy_text')") or die(mysqli_error());
            }
            else
            {
                mysqli_query($conn,"INSERT INTO finance_field (finance_space_id, finance_phase_id, finance_order, finance_name, finance_currency, finance_value, finance_type, finance_privacy) values ('$space_id','$field_id','$count','$finance_field_name','$finance_currency_text','$finance_converter_value','text','$finance_privacy_text')") or die(mysqli_error());
            }
            echo 'Field added successfully.';
        }
        else // update
        {
            mysqli_query($conn, "UPDATE `finance_field` SET `finance_name` = '$finance_field_name', `finance_privacy` = '$finance_privacy_text', `finance_currency` = '$finance_currency_text', `finance_value` = '$finance_converter_value' WHERE finance_id = '$finance_text_field_id'") or die(mysqli_error());
            echo 'Field updated successfully.';
        }
    }
    // -----------------------  END CREATE FINANCE FIELD TEXT -----------------------
    // -----------------------  CREATE FINANCE FIELD DROPDOWN -----------------------
    if(isset($_POST['create_finance_field_dropdown']))
    {
        $space_id = $_POST['space_id'];
        $field_id = $_POST['field_id'];
        $finance_text_field_id = $_POST['finance_text_field_id'];
        $finance_field_name = $_POST['finance_field_name'];
        $finance_privacy_text = $_POST['finance_privacy_text'];

        if($finance_text_field_id == "") // insert
        {
            $select_finance_field = mysqli_query($conn, "SELECT * FROM finance_field WHERE finance_space_id = '$space_id' AND finance_phase_id = '$field_id'");
            $count = mysqli_num_rows($select_finance_field);
            if($count == 0)
            {
                mysqli_query($conn,"INSERT INTO finance_field (finance_space_id, finance_phase_id, finance_name, finance_type, finance_privacy) values ('$space_id','$field_id','$finance_field_name','dropdown','$finance_privacy_text')") or die(mysqli_error());
            }
            else
            {
                mysqli_query($conn,"INSERT INTO finance_field (finance_space_id, finance_phase_id, finance_order, finance_name, finance_type, finance_privacy) values ('$space_id','$field_id','$count','$finance_field_name','dropdown','$finance_privacy_text')") or die(mysqli_error());
            }
            echo 'insert';
        }
        else // update
        {
            mysqli_query($conn, "UPDATE `finance_field` SET `finance_name` = '$finance_field_name', `finance_privacy` = '$finance_privacy_text' WHERE finance_id = '$finance_text_field_id'") or die(mysqli_error());
            echo 'upadate';
        }
    }
    // -----------------------  END CREATE FINANCE FIELD DROPDOWN -----------------------
    // -----------------------  CREATE FINANCE FIELD DROPDOWN OPTION -----------------------
    if(isset($_POST['finance_dropdown_field_id']))
    {
        $id = $_POST['finance_dropdown_field_id'];
        $color_array = array("#d60606","#b90453","#ca0b85","#ce19c1","#AD00A1","#9000AD","#5600AD","#440386","#330365","#0015AD","#005FAD","#0088AD","#00ADA9","#00AD67","#038e56","#05981d","#017514","#00AD1D","#6FAD00","#8ad00c","#bfc304","#AD9000","#d47604","#e67f01","#AD5F00","#827a71","#7da6ab","#5C797C","#3a4e50","#000000");
        $randIndex = array_rand($color_array);
        $option_color = $color_array[$randIndex];
        mysqli_query($conn,"INSERT into finance_child (child_name, child_field_id, child_color) values ('', '$id', '$option_color')") or die(mysqli_error());
    }
    // -----------------------  END CREATE FINANCE FIELD DROPDOWN OPTION  -----------------------
    // -----------------------  FETCH FINANCE FIELD -----------------------
    if(isset($_POST['fetch_finance_field']))
    {
        $space_id = $_POST['space_id'];
        $field_id = $_POST['field_id'];
        $results = mysqli_query($conn, "SELECT * FROM finance_field WHERE finance_space_id = '$space_id' and finance_phase_id = '$field_id' ORDER BY finance_order ASC");
            while($rows = mysqli_fetch_array($results))
            {
                 echo'<li class="scrumboard-item btn-alt-warning" id="entry_'.$rows['finance_id'].'" style="box-shadow: 0px 1px 1px 0px rgba(119, 119, 119, 0.27);-moz-box-shadow: 0px 1px 1px 0px rgba(119, 119, 119, 0.27);-webkit-box-shadow: 0px 1px 1px 0px rgba(119, 119, 119, 0.27); height: 20px;">
                        <div class="scrumboard-item-options">
                            <input type="hidden" value="'.$rows['finance_name'].'" id="finance_field_name'.$rows['finance_id'].'">
                            <input type="hidden" value="'.$rows['finance_privacy'].'" id="finance_field_privacy'.$rows['finance_id'].'">
                            <input type="hidden" value="'.$rows['finance_currency'].'" id="finance_currency'.$rows['finance_id'].'">
                            <input type="hidden" value="'.$rows['finance_value'].'" id="finance_value'.$rows['finance_id'].'">';
                            if($rows['finance_type'] == "text")
                            {
                                echo '<button class="btn btn-sm btn-noborder btn-primary" data-toggle="modal" data-target="#modal-financetext" data-dismiss="modal" id="edit_finance_field'.$rows['finance_id'].'" onclick="edit_finance_field(this.id)"><i class="si si-pencil"></i></button>';
                            }
                            else
                            {
                                echo '<button class="btn btn-sm btn-noborder btn-primary" data-toggle="modal" data-target="#modal-financedropdown" data-dismiss="modal" id="edit_finance_field_dropdown'.$rows['finance_id'].'" onclick="edit_finance_field_dropdown(this.id)"><i class="si si-pencil"></i></button>';
                            }
                            echo '

                            <button class="btn btn-sm btn-noborder btn-danger" id="delete_finance_field'.$rows['finance_id'].'" onclick="delete_finance_field(this.id)"><i class="fa fa-trash"></i></button>
                        </div>
                        <div class="scrumboard-item-content">
                            <a class="scrumboard-item-handler btn btn-sm bg-gd-leaf mr-10" href="javascript:void(0)" style="margin-top: -3.5px;"><i class="fa fa-hand-grab-o text-white"></i></a>';
                            if($rows['finance_type'] == "text") { echo '<i class="fa fa-text-height"></i>'; }
                            else { echo '<i class="fa fa-angle-double-down"></i>'; }
                            echo '
                            <label class="ml-5">'.$rows['finance_name'].'</label>
                            <button type="submit" hidden="hidden" class="btn btn-primary btn-noborder mr-1 mb-5" name="btn_modal_status_names"><i class="fa fa-check"></i></button>
                        </div>
                </li>';
            }
    }
    // -----------------------  END FETCH FINANCE FIELD -----------------------
    // -----------------------  EDIT FINANCE FIELD -----------------------
    if(isset($_POST['edit_finance_field']))
    {
        $edit_finance_field_id = $_POST['edit_finance_field_id'];
        $edit_finance_field_name = $_POST['edit_finance_field_name'];
        $finance_currency = $_POST['finance_currency'];
        $finance_value = $_POST['finance_value'];
        mysqli_query($conn,"UPDATE finance_field set finance_name = '$edit_finance_field_name', finance_currency = '$finance_currency', finance_value = '$finance_value' where finance_id = '$edit_finance_field_id'");
    }
    // -----------------------  END EDIT FINANCE FIELD -----------------------
    // -----------------------  DELETE FINANCE FIELD -----------------------
    if(isset($_POST['delete_finance_field']))
    {
        $field_id = $_POST['field_id'];
        $results = mysqli_query($conn, "SELECT * FROM finance_field WHERE finance_id = '$field_id'");
        $rows = mysqli_fetch_array($results);
        $finance_phase_id = $rows['finance_phase_id'];

        // $select_transaction = mysqli_query($conn, "SELECT * FROM finance_transaction WHERE val_phase_id = '$finance_phase_id'");
        // $count = mysqli_num_rows($select_transaction);
        // if($count > 0) // cannot delete any field if has transaction under specific phase
        // {
        //     echo 'Make sure no transaction is assign to any task that link into this phase.';
        // }
        // else // delete
        // {
        if($rows['finance_type'] == "dropdown") // check if dropdown to delete child
        {
            mysqli_query($conn,"DELETE from finance_child where child_field_id = '$field_id'"); // delete child/option
        }
        mysqli_query($conn,"DELETE from finance_field where finance_id = '$field_id'"); // delete the field
        echo 'Field deleted.';
        // }
    }
    // -----------------------  END DELETE FINANCE FIELD -----------------------


    // -----------------------  SORT FINANCE FIELD -----------------------
    if(isset($_POST['sort_finance']))
    {
        $space_id = $_POST['space_id'];
        $sort1 = '';
        parse_str($_POST['sort1'], $sort1);
        $query = "SELECT finance_id FROM finance_field WHERE finance_space_id = '$space_id'";
        $result = $conn->query($query) or die('Error, query failed');
        if ($result->num_rows == 0)
        {
        }
        else
        {
            foreach($sort1['entry'] as $key=>$value)
            {
                $updatequery = "UPDATE `finance_field` SET finance_order = '$key' WHERE finance_id = '$value'";
                $conn->query($updatequery) or die('Error, UPDATE failed!');
            }
            echo 'update';
        }
    }
    // -----------------------  END SORT FINANCE FIELD -----------------------


    // -----------------------  FETCH FINANCE FIELD TO SELECT OPTION -----------------------
    if(isset($_POST['display_finance_field1']))
    {
        echo '<option value=""></option>';
        $space_id = $_POST['space_id'];
        $select_field = mysqli_query($conn, "SELECT * FROM finance_field WHERE finance_space_id ='$space_id' AND finance_phase_id = '' ORDER BY finance_order ASC");
        while($result_select_field = mysqli_fetch_array($select_field))
        {
            echo '<option value="'.$result_select_field['finance_id'].'">'.$result_select_field['finance_name'].'</option>';
        }
    }
    // -----------------------  END FETCH FINANCE FIELD TO SELECT OPTION -----------------------
    // -----------------------  FETCH FINANCE FIELD TO SELECT OPTION -----------------------
    if(isset($_POST['assign_field_phase']))
    {
        $assign_field_id = $_POST['assign_field_id'];
        $assign_phase_id = $_POST['assign_status_id'];
        mysqli_query($conn, "UPDATE finance_field SET finance_phase_id = '$assign_phase_id' WHERE finance_id = '$assign_field_id'") or die(mysqli_error());
    }
    // -----------------------  END FETCH FINANCE FIELD TO SELECT OPTION -----------------------
    // -----------------------  FETCH ASSGIN FIELD PER PHASE -----------------------
    if(isset($_POST['display_assign_phase']))
    {
        echo'<div class="row" style="padding: 0px 15px;">';
        $space_id = $_POST['space_id'];
        $select_phase = mysqli_query($conn, "SELECT * FROM finance_phase WHERE phase_space_id ='$space_id' ORDER BY phase_id ASC");
        while($result_select_phase = mysqli_fetch_array($select_phase))
        {
            echo'<div class="col-md-12" style="padding: 5px 10px; margin: 5px 0px; border: solid 2px #afafaf;">
                    <span><strong>'.$result_select_phase['phase_name'].'</strong></span>';
                    $phase_id = $result_select_phase['phase_id'];
                    $select_field = mysqli_query($conn, "SELECT * FROM finance_field WHERE finance_phase_id = '$phase_id' ORDER BY finance_order ASC");
                    while($fetch_select_field = mysqli_fetch_array($select_field))
                    {
                        echo'
                        <div class="col-md-12" style="background-color: #eaeaea; border-radius: 3px; padding: 5px 10px; margin: 5px 0px; box-shadow: 0px 1px 1px 0px rgba(119, 119, 119, 0.27);-moz-box-shadow: 0px 1px 1px 0px rgba(119, 119, 119, 0.27);-webkit-box-shadow: 0px 1px 1px 0px rgba(119, 119, 119, 0.27);">
                                <span><strong>&nbsp;'.$fetch_select_field['finance_name'].'</strong></span>
                                <span class="float-right" style="margin-top: -3px;">
                                    <button class="btn btn-sm btn-noborder btn-danger" id="'.$fetch_select_field['finance_id'].'" onclick="remove_assign_field_phase(this.id)"><i class="fa fa-trash"></i></button>
                                </span>
                            </div>';
                    }
                echo'</div>';
        }
        echo "</div>";
    }
    // -----------------------  END FETCH ASSGIN FIELD PER PHASE -----------------------
    // -----------------------  REMOVE ASSGIN FIELD PER PHASE -----------------------
    if(isset($_POST['remove_assign_field_phase']))
    {
        $id = $_POST['id'];
        mysqli_query($conn, "UPDATE finance_field SET finance_phase_id = '' WHERE finance_id = '$id'") or die(mysqli_error());
    }
    // -----------------------  END REMOVE ASSGIN FIELD PER PHASE -----------------------


    // -----------------------  ADD REQUIREMENTS FIELD -----------------------
    if(isset($_POST['create_requirement_field']))
    {
        $space_id = $_POST['space_id'];
        $type = $_POST['type'];
        $privacy = $_POST['privacy'];
        $name = $_POST['name'];

        $select_requirement_field = mysqli_query($conn, "SELECT * FROM requirement_field WHERE requirement_space_id = '$space_id'");
        $count = mysqli_num_rows($select_requirement_field);
        if($count == 0)
        {
            mysqli_query($conn,"INSERT INTO requirement_field values ('','','$space_id','$type','$privacy','$name')") or die(mysqli_error());
        }
        else
        {
            mysqli_query($conn,"INSERT INTO requirement_field values ('','$count','$space_id','$type','$privacy','$name')") or die(mysqli_error());
        }
    }
    // -----------------------  END ADD REQUIREMENTS FIELD -----------------------
    // -----------------------  FETCH REQUIREMENTS FIELD -----------------------
    if(isset($_POST['fetch_requirements_field']))
    {
        $space_id = $_POST['space_id'];
        $results = mysqli_query($conn, "SELECT * FROM requirement_field WHERE requirement_space_id = '$space_id' ORDER BY requirement_order_no ASC");
        while($rows = mysqli_fetch_array($results))
        {
            echo'<li class="scrumboard-item btn-alt-warning" id="entry_'.$rows['requirement_id'].'" style="box-shadow: 0px 1px 1px 0px rgba(119, 119, 119, 0.27);-moz-box-shadow: 0px 1px 1px 0px rgba(119, 119, 119, 0.27);-webkit-box-shadow: 0px 1px 1px 0px rgba(119, 119, 119, 0.27); height: 20px;">
                    <div class="scrumboard-item-options">
                        <input type="hidden" value="'.$rows['requirement_name'].'" id="requirement_name'.$rows['requirement_id'].'">
                        <input type="hidden" value="'.$rows['requirement_privacy'].'" id="requirement_privacy'.$rows['requirement_id'].'">
                        <input type="hidden" value="'.$rows['requirement_type'].'" id="requirement_type'.$rows['requirement_id'].'">';
                            if($rows['requirement_type'] == "Text")
                            {
                                echo '<button class="btn btn-sm btn-noborder btn-primary" data-toggle="modal" data-target="#modal-requirementtext" data-dismiss="modal" id="edit_requirement_field_text'.$rows['requirement_id'].'" onclick="edit_requirement_field_text(this.id)"><i class="si si-pencil"></i></button>';
                            }
                            else
                            {
                                echo '<button class="btn btn-sm btn-noborder btn-primary" data-toggle="modal" data-target="#modal-requirementdropdown" data-dismiss="modal" id="edit_requirement_field_dropdown'.$rows['requirement_id'].'" onclick="edit_requirement_field_dropdown(this.id)"><i class="si si-pencil"></i></button>';
                            }
                            echo '
                        <button class="btn btn-sm btn-noborder btn-danger" id="delete_requirement_field'.$rows['requirement_id'].'" onclick="delete_requirement_field(this.id)"><i class="fa fa-trash"></i></button>
                    </div>
                    <div class="scrumboard-item-content">
                        <a class="scrumboard-item-handler btn btn-sm bg-gd-sea mr-10" href="javascript:void(0)" style="margin-top: -3.5px;"><i class="fa fa-hand-grab-o text-white"></i></a>';
                        if($rows['requirement_type'] == "Text") { echo '<i class="fa fa-text-height"></i>'; }
                        else { echo '<i class="fa fa-angle-double-down"></i>'; }
                        echo '
                        <label class="ml-5">'.$rows['requirement_name'].'</label>
                    </div>
            </li>';
        }
    }
    // -----------------------  END FETCH REQUIREMENTS FIELD -----------------------
    // -----------------------  SORT REQUIREMENTS FIELD -----------------------
    if(isset($_POST['sort_requirement']))
    {
        $space_id = $_POST['space_id'];
        $sort1 = '';
        parse_str($_POST['sort1'], $sort1);
        $query = "SELECT requirement_id FROM requirement_field WHERE requirement_space_id = '$space_id'";
        $result = $conn->query($query) or die('Error, query failed');
        if ($result->num_rows == 0)
        {
        }
        else
        {
            foreach($sort1['entry'] as $key=>$value)
            {
                $updatequery = "UPDATE `requirement_field` SET requirement_order_no = '$key' WHERE requirement_id = '$value'";
                $conn->query($updatequery) or die('Error, UPDATE failed!');
            }
            echo 'update';
        }
    }
    // -----------------------  END SORT REQUIREMENTS FIELD -----------------------
    // -----------------------  UPDATE REQUIREMENTS TEXT & DROPDOWN FIELD -----------------------
    if(isset($_POST['update_requirements_text_field']))
    {
        $field_id = $_POST['field_id'];
        $name = $_POST['name'];
        $privacy = $_POST['privacy'];
        mysqli_query($conn, "UPDATE requirement_field SET requirement_privacy = '$privacy', requirement_name = '$name' WHERE requirement_id = '$field_id'") or die(mysqli_error());
    }
    // -----------------------  END UPDATE REQUIREMENTS TEXT FIELD -----------------------
    // -----------------------  UPDATE REQUIREMENTS TEXT & DROPDOWN FIELD -----------------------
    if(isset($_POST['requirements_add_dropdown_option']))
    {
        $color_array = array("#d60606","#b90453","#ca0b85","#ce19c1","#AD00A1","#9000AD","#5600AD","#440386","#330365","#0015AD","#005FAD","#0088AD","#00ADA9","#00AD67","#038e56","#05981d","#017514","#00AD1D","#6FAD00","#8ad00c","#bfc304","#AD9000","#d47604","#e67f01","#AD5F00","#827a71","#7da6ab","#5C797C","#3a4e50","#000000");
        $randIndex = array_rand($color_array);
        $option_color = $color_array[$randIndex];

        $id = $_POST['field_id'];
        mysqli_query($conn,"INSERT into requirement_child values ('', '', '$id', '$option_color')") or die(mysqli_error());
    }
    // -----------------------  END UPDATE REQUIREMENTS TEXT FIELD -----------------------
    // -----------------------  DELETE REQUIREMENTS FIELD -----------------------
    if(isset($_POST['delete_requirement_field']))
    {
        $field_id = $_POST['field_id'];
        $type = $_POST['type'];
        $results = mysqli_query($conn, "SELECT * FROM requirement_value WHERE value_field_id = '$field_id'");
        $count = mysqli_num_rows($results);
        if($count > 0) // cannot delete any field if has transaction under specific phase
        {
            echo 'Cannot delete field with value into specific task.';
        }
        else
        {
            if($type == "Dropdown") // check if dropdown to delete child
            {
                mysqli_query($conn,"DELETE from requirement_child where child_field_id  = '$field_id'"); // delete child/option
            }
            mysqli_query($conn,"DELETE from requirement_field where requirement_id = '$field_id'"); // delete the field
            echo 'Field deleted.';
        }
    }
    // -----------------------  END DELETE REQUIREMENTS FIELD -----------------------
    // -----------------------  DISPLAY REQUIREMENTS FIELD IN TASK -----------------------
    if(isset($_POST['display_requirements']))
    {
        $task_id = $_POST['task_id'];
        $space_id = $_POST['space_id'];
        $select_db = mysqli_query($conn, "SELECT * FROM requirement_field WHERE requirement_space_id ='$space_id' ORDER BY requirement_order_no ASC");
        $count_field = mysqli_num_rows($select_db);
        while($rows = mysqli_fetch_array($select_db))
        {
            $field_id = $rows['requirement_id'];
            $select_requirement_value = mysqli_query($conn, "SELECT * FROM requirement_value WHERE value_to ='$task_id' AND value_field_id ='$field_id'");
            $field_value = mysqli_fetch_array($select_requirement_value);
            $count = mysqli_num_rows($select_requirement_value);
            if($count == 0) // checking if field has value in specific task
            {
                $value = "";
            }
            else
            {
                $value = $field_value['value_value'];
            }

            if($rows['requirement_type'] == "Text")
            {
                echo'<div class="form-group row">
                        <label class="col-lg-4 col-form-label">'.$rows['requirement_name'].'</label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" id="requirement_input_field'.$rows['requirement_id'].'" value="'.$value.'">
                        </div>
                        <div class="col-lg-2">
                            <button type="button" class="btn btn-sm btn-circle btn-alt-success mr-5 mb-5" id="'.$rows['requirement_id'].'" onclick="save_requirement(this.id)">
                                <i class="fa fa-check"></i>
                            </button>
                        </div>
                    </div>';
            }
            else
            {
                echo'<div class="form-group row">
                        <label class="col-lg-4 col-form-label">'.$rows['requirement_name'].'</label>
                        <div class="col-lg-6">';
                            $select_field1 = mysqli_query($conn, "SELECT * FROM requirement_child WHERE child_id = '$value'");
                            $get_color = mysqli_fetch_array($select_field1);
                            if($get_color['child_color'] == "")
                            { $color = ""; }
                            else
                            { $color = "#ffffff"; }
                            echo'
                            <select class="form-control" id="requirement_input_field'.$rows['requirement_id'].'" style="color: '.$color.'; background-color: '.$get_color['child_color'].';">
                                <option value="">Select...</option>
                                ';
                                    $select_field = mysqli_query($conn, "SELECT * FROM requirement_child WHERE child_field_id = '$field_id' ORDER BY child_id ASC");
                                    while($fetch_select_field = mysqli_fetch_array($select_field))
                                    {
                                        if($fetch_select_field['child_id'] == $value)
                                        {
                                            echo'<option value="'.$fetch_select_field['child_id'].'" style="color: #fff; background-color: '.$fetch_select_field['child_color'].';" selected>'.$fetch_select_field['child_name'].'</option>';
                                        }
                                        else
                                        {
                                            echo'<option value="'.$fetch_select_field['child_id'].'" style="color: #fff; background-color: '.$fetch_select_field['child_color'].';">'.$fetch_select_field['child_name'].'</option>';
                                        }
                                    }
                                echo'
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <button type="button" class="btn btn-sm btn-circle btn-alt-success mr-5 mb-5" id="'.$rows['requirement_id'].'" onclick="save_requirement(this.id)">
                                <i class="fa fa-check"></i>
                            </button>
                        </div>
                    </div>';
            }
        }
	    if($count_field == 0)
	    {}
	    else
	    {
	        // echo '<div class="row">
	        //         <div class="col-12">
	        //             <button type="button" class="btn btn-md btn-noborder btn-primary btn-block" onclick="btn_save_requirements_field()"><li class="fa fa-check"></li> Save</button>
	        //         </div>
	        //     </div>';
	    }
    }
    // -----------------------  END DISPLAY REQUIREMENTS FIELD IN TASK -----------------------
    // -----------------------  REQUIREMENTS GET FIELD ID PER SPACE -----------------------
    if(isset($_POST['requirements_get_field_id']))
    {
        $space_id = $_POST['space_id'];
        $field_array = array();
        $field = mysqli_query($conn, "SELECT * FROM requirement_field WHERE requirement_space_id ='$space_id' ORDER BY requirement_order_no ASC");
        while($fetch_field = mysqli_fetch_array($field))
        {
            $field_id = $fetch_field['requirement_id'];
            array_push($field_array,$field_id); // add value to array $field_array
        }
        $finalarray = implode(",",$field_array); // convert array to string
        echo $finalarray;
    }
    // -----------------------  END REQUIREMENTS GET FIELD ID PER SPACE -----------------------
    // -----------------------  REQUIREMENTS SAVE FIELD VALUE PER TASK -----------------------
    if(isset($_POST['save_requirements_field_value']))
    {
        $user_id = $_POST['user_id'];
        $task_id = $_POST['task_id'];
        $field_id_in_array = $_POST['field_id_in_array'];
        $field_value = $_POST['field_value'];

        $select_field = mysqli_query($conn, "SELECT * FROM requirement_field WHERE requirement_id ='$field_id_in_array'");
        $fetch_select_field = mysqli_fetch_array($select_field);
        $field_name = $fetch_select_field['requirement_name']; // get the field_name in db
        $field_type = $fetch_select_field['requirement_type']; // get the field_name in db

        $select_requirement_value = mysqli_query($conn, "SELECT * FROM requirement_value WHERE value_to ='$task_id' AND value_field_id ='$field_id_in_array'");
        $fetch_field_value = mysqli_fetch_array($select_requirement_value);
        $value_id = $fetch_field_value['value_id'];
        $previous_value = $fetch_field_value['value_value'];

        $count = mysqli_num_rows($select_requirement_value);
        if($count == 0) // check if field has value in specific task
        {
            if($field_value == "") // check if no value
            { }
            else
            {
                mysqli_query($conn,"INSERT into requirement_value values ('', '$user_id', '$task_id', '$field_id_in_array', '$field_value')") or die(mysqli_error());
                if ($field_type == "Dropdown")// identify if dropdown
                {
                    // get the value if specific option
                    $select_child = mysqli_query($conn, "SELECT * FROM `requirement_child` WHERE child_id = '$field_value'");
                    $fetch_result = mysqli_fetch_array($select_child);
                    $child_name = $fetch_result['child_name']; // get the child name

                    $msg = 'Update field name: "'.$field_name.'" value: "'.$child_name.'".';
                }
                else
                {
                    $msg = 'Update field name: "'.$field_name.'" value: "'.$field_value.'".';
                }
                mysqli_query($conn,"INSERT into requirement_comment (comment_task_id, comment_user_id, comment_message, comment_date, comment_type) values ('$task_id', '$user_id', '$msg', NOW(), '1')") or die(mysqli_error());
            }
        }
        else
        {
            mysqli_query($conn, "UPDATE requirement_value SET value_by = '$user_id', value_value = '$field_value' WHERE value_id = '$value_id'") or die(mysqli_error());
            if($field_value == $previous_value) // check if current value == previous value
            {} // no comment appear
            else
            {
                if ($field_type == "Dropdown")// identify if dropdown
                {
                    // get the value if specific option
                    $select_child = mysqli_query($conn, "SELECT * FROM `requirement_child` WHERE child_id = '$field_value'");
                    $fetch_result = mysqli_fetch_array($select_child);
                    $child_name = $fetch_result['child_name']; // get the child name

                    $msg = 'Update field name: "'.$field_name.'" value: "'.$child_name.'".';
                }
                else
                {
                    $msg = 'Update field name: "'.$field_name.'" value: "'.$field_value.'".';
                }
                mysqli_query($conn,"INSERT into requirement_comment (comment_task_id, comment_user_id, comment_message, comment_date, comment_type) values ('$task_id', '$user_id', '$msg', NOW(), '1')") or die(mysqli_error());
            }
        }
    }
    // -----------------------  REQUIREMENTS SAVE FIELD VALUE PER TASK -----------------------
    // -----------------------  REQUIREMENTS SEND COMMENT PER TASK -----------------------
    if(isset($_POST['send_requirement_comment']))
    {
        $task_id = $_POST['task_id'];
        $user_id = $_POST['user_id'];
        $message = $_POST['message'];

        $attachment_name = $_FILES['file_attachment']['name'];
        $attachment_temp = $_FILES['file_attachment']['tmp_name'];
        $attachment_size = $_FILES['file_attachment']['size'];

        if($attachment_name == "")
        {
            mysqli_query($conn,"INSERT into requirement_comment values ('', '$task_id', '$user_id', '$message', NOW(), '', '')") or die(mysqli_error());
            echo "success";
        }
        else
        {
            $exp = explode(".", $attachment_name);
            $ext = end($exp);
            $allowed_ext = array('jpg', 'JPG', 'jpeg', 'JPEG', 'png', 'PNG', 'gif', 'docx', 'xlsx', 'csv', 'pdf');
            if(in_array($ext, $allowed_ext)) // check the file extension
            {
                date_default_timezone_set('Asia/Manila');
                //$todays_date = date("y-m-d H:i:sa"); //  original format
                $date = date("His"); // for unique file name

                $words = explode(' ',trim($attachment_name)); // convert name to array
                $get_name = substr($words[0], 0, 6); // get only 6 character of the name

                $image = $date.'-'.$get_name.'.'.$ext;
                $location = "../assets/media/requirements/".$image; // upload location
                if($attachment_size < 3000000) // Maximum 3 MB
                {
                    move_uploaded_file($attachment_temp, $location);
                    mysqli_query($conn,"INSERT into requirement_comment values ('', '$task_id', '$user_id', '$message', NOW(), '$image', '')") or die(mysqli_error());
                    echo "success";
                }
                else
                {
                    echo "size";
                }
            }
            else
            {
                echo "format";
            }
        }

    }
    // -----------------------  END REQUIREMENTS SEND COMMENT PER TASK -----------------------
    // -----------------------  DISPLAY SEND COMMENT PER TASK -----------------------
    if(isset($_POST['display_requirement_comment']))
    {
        $id = $_POST['id'];
        $select_user = mysqli_query($conn, "SELECT * FROM user WHERE user_id = '$id'");
        $fetch_select_user = mysqli_fetch_array($select_user);
        $user_type = $fetch_select_user['user_type'];

        $task_id = $_POST['task_id'];
        $results = mysqli_query($conn, "SELECT * FROM requirement_comment left join user on user.user_id = requirement_comment.comment_user_id WHERE comment_task_id = '$task_id' ORDER BY comment_date DESC");
        while($rows = mysqli_fetch_array($results))
        {
            echo '
            <tr class="parent">
                <td class="d-none d-sm-table-cell font-w600" style="width: 50px;">
                    <div>';
                        $user_id = $rows['user_id'];
                        $comment_user_id = $rows['comment_user_id'];
                        $comment_type = $rows['comment_type'];

                        $res = mysqli_query($conn, "SELECT * FROM user WHERE user_id = $user_id");
                        $row12 = mysqli_fetch_assoc($res);
                        $get_first_letter_in_fname = $row12['fname'];
                        $get_first_letter_in_lname = $row12['lname'];

                        if($row12['profile_pic'] != "")
                        {
                            echo '<img style="width: 38px;border-radius: 50px;" src="../assets/media/upload/'.$row12['profile_pic'].'">';
                        }
                        else
                        {
                            echo '<span style="padding: 10px 10px; border-radius: 50px; color: #fff; background-color: '.$row12['user_color'].'"><?php echo $get_first_letter_in_fname[0]; echo $get_first_letter_in_lname[0]?></span>';
                        }
                    echo'
                    </div>
                </td>
                <td>
                    <div>';
                        if($user_type == "Member")
                        {
                            if($comment_user_id == $id && $comment_type == "")
                            {
                                echo '
                                <div class="child float-right">
                                    <button type="button" class="btn-block-option" style="margin-top: -3px;" id="'.$rows['comment_id'].'" style="display: none;" onclick="delete_requirement_comment(this.id)">
                                        <i class="si si-close text-danger"></i>
                                    </button>
                                </div>';
                            }
                        }
                        else
                        {
                            echo '
                            <div class="child float-right">
                                <button type="button" class="btn-block-option" style="margin-top: -3px;" id="'.$rows['comment_id'].'" style="display: none;" onclick="delete_requirement_comment(this.id)">
                                    <i class="si si-close text-danger"></i>
                                </button>
                            </div>';
                        }
                    echo'
                            <div class="float-right">
                                <span style="text-align: right; font-size: 11px; font-style: italic;">
                                    '.date('M d Y',strtotime($rows['comment_date'])).' at '.date('h:i A',strtotime($rows['comment_date'])).'
                                </span>
                            </div><strong>'.$row12['fname'].' '.$row12['lname'].'</strong>
                    </div>
                    <div class="text-muted mt-5">
                        <span style="font-size: 13px;">'.$rows['comment_message'].'</span>
                    </div>
                    <div class="text-muted mt-5">';
                        if($rows['comment_attactment'] != "")
                        {
                            $path_info = pathinfo('../assets/media/requirements/'.$rows['comment_attactment'].'');
                            $extension = $path_info['extension']; // get the file extension

                            if($extension == "docx")
                            {
                                echo'<img src="../assets/media/icon/WORD.png" style="float:left; margin: 0px 0px 0px 0px; width: 60px; height: auto; border-radius: 5px; box-shadow: 0 8px 6px -6px #dedede; border: solid 1px #e2e2e2;">
                                    <span class="ml-10">'.$rows['comment_attactment'].'</span>
                                    <input type="hidden" name="txt_image" value="'.$rows['comment_attactment'].'">
                                    <a href="download_image.php?req_comment_id='.$rows['comment_id'].'" class="btn-block-option btn" style="margin: 0px 10px -5px 0px;"><i class="fa fa-download"></i></a>';
                            }
                            else if($extension == "xlsx")
                            {
                                echo'<img src="../assets/media/icon/EXCEL.png" style="float:left; margin: 0px 0px 0px 0px; width: 60px; height: auto; border-radius: 5px; box-shadow: 0 8px 6px -6px #dedede; border: solid 1px #e2e2e2;">
                                    <span class="ml-10">'.$rows['comment_attactment'].'</span>
                                    <input type="hidden" name="txt_image" value="'.$rows['comment_attactment'].'">
                                    <a href="download_image.php?req_comment_id='.$rows['comment_id'].'" class="btn-block-option btn" style="margin: 0px 10px -5px 0px;"><i class="fa fa-download"></i></a>';
                            }
                            else if($extension == "csv")
                            {
                                echo'<img src="../assets/media/icon/CSV.png" style="float:left; margin: 0px 0px 0px 0px; width: 60px; height: auto; border-radius: 5px; box-shadow: 0 8px 6px -6px #dedede; border: solid 1px #e2e2e2;">
                                    <span class="ml-10">'.$rows['comment_attactment'].'</span>
                                    <input type="hidden" name="txt_image" value="'.$rows['comment_attactment'].'">
                                    <a href="download_image.php?req_comment_id='.$rows['comment_id'].'" class="btn-block-option btn" style="margin: 0px 10px -5px 0px;"><i class="fa fa-download"></i></a>';
                            }
                            else if($extension == "pdf")
                            {
                                echo'<img src="../assets/media/icon/PDF.png" style="float:left; margin: 0px 0px 0px 0px; width: 50px; height: auto; border-radius: 5px; box-shadow: 0 8px 6px -6px #dedede; border: solid 1px #e2e2e2;">
                                    <span class="ml-10">'.$rows['comment_attactment'].'</span>
                                    <input type="hidden" name="txt_image" value="'.$rows['comment_attactment'].'">
                                    <a href="download_image.php?req_comment_id='.$rows['comment_id'].'" class="btn-block-option btn" style="margin: 0px 10px -5px 0px;"><i class="fa fa-download"></i></a>';
                            }
                            else
                            {
                                echo'<img src="../assets/media/requirements/'.$rows['comment_attactment'].'" style="float:left; margin: 0px 0px 0px 0px; width: 200px; height: auto; border-radius: 5px; box-shadow: 0 8px 6px -6px #dedede; border: solid 1px #e2e2e2;">
                                <input type="hidden" name="txt_image" value="'.$rows['comment_attactment'].'">
                                <a href="download_image.php?req_comment_id='.$rows['comment_id'].'" class="btn-block-option btn" style="margin: 0px 10px -5px 0px;"><i class="fa fa-download"></i></a>';
                            }
                        }
                        else
                        {}
                    echo'
                    </div>
                </td>
            </tr>
            ';
        }
    }
    // -----------------------  END DISPLAY SEND COMMENT PER TASK -----------------------

    // ----------------------- GET EMAIL CONTENT -----------------------
    if(isset($_POST['get_email_content_to_be_send']))
    {
        $email_name = $_POST['email_name'];
        $file_loc = "./email_content/".$email_name.".txt";

        $myfile = fopen($file_loc, "r") or die("Unable to open file!");
        echo fread($myfile,filesize($file_loc));
        fclose($myfile);
    }
    // ----------------------- END GET EMAIL CONTENT -----------------------
    // ----------------------- SAVE EMAIL SENT IN HISTORY -----------------------
    if(isset($_POST['email_send_history']))
    {
        // date_default_timezone_set('Asia/Manila');
        $user_id = $_POST['user_id'];
        $email_id = $_POST['email_id'];
        $task_id = $_POST['task_id'];
        $contact_email = $_POST['contact_email'];
        $email_content = $_POST['email_content'];

        // Store data from db
        $email_send_history = mysqli_query($conn, "INSERT INTO email_send_history values ('', NOW(), '$user_id', '$email_id', '$contact_email', '$task_id', '$email_content')") or die(mysqli_error());
        if ($email_send_history)
        {
            echo "Email sent successfully.";
        }
    }
    // ----------------------- END SAVE EMAIL SENT IN HISTORY -----------------------

    // ----------------------- DISPLAY SPACE FOR SORT -----------------------
    if(isset($_POST['fetch_space_for_sort']))
    {
        $select_space_sort = mysqli_query($conn, "SELECT * FROM space_sort");
        $count = mysqli_num_rows($select_space_sort);
        if($count == 0) // check if no sort
        {
            $results = mysqli_query($conn, "SELECT * FROM space ORDER BY space_name ASC");
            while($rows = mysqli_fetch_array($results))
            {
                echo '<li class="scrumboard-item btn-alt-warning" id="entry_'.$rows['space_id'].'" style="box-shadow: 0px 1px 1px 0px rgba(119, 119, 119, 0.27);-moz-box-shadow: 0px 1px 1px 0px rgba(119, 119, 119, 0.27);-webkit-box-shadow: 0px 1px 1px 0px rgba(119, 119, 119, 0.27); height: 20px;">
                        <div class="scrumboard-item-content">
                            <a class="scrumboard-item-handler btn btn-sm bg-gd-sea mr-10" href="javascript:void(0)" style="margin-top: -3.5px;"><i class="fa fa-hand-grab-o text-white"></i></a>
                            <label class="ml-5">'.$rows['space_name'].'</label>
                        </div>
                    </li>';
            }
        }
        else // check if has sort
        {
            $results = mysqli_query($conn, "SELECT * FROM space_sort ORDER BY sort_space_order ASC");
            while($rows1 = mysqli_fetch_array($results))
            {
                $space_id = $rows1['sort_space_id'];
                $select_space = mysqli_query($conn, "SELECT * FROM space WHERE space_id = '$space_id'");
                $rows = mysqli_fetch_array($select_space);

                echo '<li class="scrumboard-item btn-alt-warning" id="entry_'.$rows['space_id'].'" style="box-shadow: 0px 1px 1px 0px rgba(119, 119, 119, 0.27);-moz-box-shadow: 0px 1px 1px 0px rgba(119, 119, 119, 0.27);-webkit-box-shadow: 0px 1px 1px 0px rgba(119, 119, 119, 0.27); height: 20px;">
                        <div class="scrumboard-item-content">
                            <a class="scrumboard-item-handler btn btn-sm bg-gd-sea mr-10" href="javascript:void(0)" style="margin-top: -3.5px;"><i class="fa fa-hand-grab-o text-white"></i></a>
                            <label class="ml-5">'.$rows['space_name'].'</label>
                        </div>
                    </li>';
            }
        }
    }
    // ----------------------- END DISPLAY SPACE FOR SORT -----------------------
    // ----------------------- SORT SPACE PER ADMIN -----------------------
    if(isset($_POST['sort_space_per_user']))
    {
        $user_id = $_POST['user_id'];
        $sort1 = '';
        parse_str($_POST['sort1'], $sort1);
        $query = "SELECT * FROM space_sort";
        $result = $conn->query($query) or die('Error, query failed');
        if ($result->num_rows == 0)
        {
            foreach($sort1['entry'] as $key=>$value)
            {
                mysqli_query($conn,"INSERT into space_sort values ('', '$user_id', '$value', '$key')") or die(mysqli_error());
            }
            echo 'insert';
        }
        else
        {
            foreach($sort1['entry'] as $key=>$value)
            {
                $updatequery = "UPDATE `space_sort` SET sort_user_id = '$user_id', sort_space_order = '$key' WHERE sort_space_id = '$value'";
                $conn->query($updatequery) or die('Error, UPDATE failed!');
            }
            echo 'update';
        }
    }
    // ----------------------- END SORT SPACE PER ADMIN -----------------------

    // ----------------------- Show Box Space Unasssign list in Everthing page -----------------------
    if(isset($_POST['show_space']))
    {
            $filter = $_POST['filter'];
            echo '<ul class="nav-main" style="margin-top: -20px;">';

                    $find_space = mysqli_query($conn, "SELECT * FROM space ORDER BY space_name ASC");
                    while($fetch_space = mysqli_fetch_array($find_space))
                    {
                        $space_id = $fetch_space['space_id'];
                        $space_name = $fetch_space['space_name'];
                        //query for filtering data
                        $filter = $_POST['filter'];
                        if ($filter) {
                            $filterby = $filter;

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

                            $find_list = mysqli_query($conn, "SELECT * FROM list WHERE list_space_id = '$space_id' ORDER BY list_name ASC");
                            while($fetch_list = mysqli_fetch_array($find_list))
                            {
                                $list_id = $fetch_list['list_id'];
                                $list_name = $fetch_list['list_name'];
                                //query for filtering data
                                $filter = $_POST['filter'];
                                if ($filter) {
                                    $filterby = $filter;

                                    if($filterby == "All")
                                    {
                                        $findtaskper_list = mysqli_query($conn, "SELECT * FROM task WHERE task_list_id = '$list_id' and task_assign_to = ''");
                                    }
                                    else if($filterby == "Today")
                                    {
                                        $filter = date("Y-m-d");
                                        $findtaskper_list = mysqli_query($conn, "SELECT * FROM task WHERE task_list_id = '$list_id' and task_assign_to = '' and task_date_created LIKE '%$filter%'");
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
                                        $findtaskper_list = mysqli_query($conn, "SELECT * FROM task WHERE task_list_id = '$list_id' and task_assign_to = '' and task_date_created BETWEEN '$from' AND '$to'");
                                    }
                                    else if($filterby == "This Month")
                                    {
                                        $filter = date("Y-m");
                                        $findtaskper_list = mysqli_query($conn, "SELECT * FROM task WHERE task_list_id = '$list_id' and task_assign_to = '' and task_date_created LIKE '%$filter%'");
                                    }
                                    else if($filterby == "This Year")
                                    {
                                        $filter = date("Y");
                                        $findtaskper_list = mysqli_query($conn, "SELECT * FROM task WHERE task_list_id = '$list_id' and task_assign_to = '' and task_date_created LIKE '%$filter%'");
                                    }
                                    else if($filterby == "Custom Date")
                                    {
                                        $get_from = $_GET['From'];
                                        $get_to = $_GET['To'];
                                        $findtaskper_list = mysqli_query($conn, "SELECT * FROM task WHERE task_list_id = '$list_id' and task_assign_to = '' and task_date_created BETWEEN '$get_from' AND '$get_to'");
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
                                    $findtaskper_space = mysqli_query($conn, "SELECT * FROM task WHERE task_list_id = '$list_id' and task_assign_to = '' and task_date_created BETWEEN '$from' AND '$to'");
                                }
                                // $findtaskper_list= mysqli_query($conn, "SELECT * FROM task WHERE task_list_id = '$list_id' AND task_assign_to = ''");
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
                                            //query for filtering data
                                            $filter = $_POST['filter'];
                                            if ($filter) {
                                                $filterby = $filter;

                                                if($filterby == "All")
                                                {
                                                    $findtaskper_status = mysqli_query($conn, "SELECT * FROM task WHERE task_status_id = '$status_idss' and task_assign_to = '' ORDER BY task_name");
                                                }
                                                else if($filterby == "Today")
                                                {
                                                    $filter = date("Y-m-d");
                                                    $findtaskper_status = mysqli_query($conn, "SELECT * FROM task WHERE task_status_id = '$status_idss' and task_assign_to = '' and task_date_created LIKE '%$filter%' ORDER BY task_name");
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
                                                    $findtaskper_status = mysqli_query($conn, "SELECT * FROM task WHERE task_status_id = '$status_idss' and task_assign_to = '' and task_date_created BETWEEN '$from' AND '$to' ORDER BY task_name");
                                                }
                                                else if($filterby == "This Month")
                                                {
                                                    $filter = date("Y-m");
                                                    $findtaskper_status = mysqli_query($conn, "SELECT * FROM task WHERE task_status_id = '$status_idss' and task_assign_to = '' and task_date_created LIKE '%$filter%' ORDER BY task_name");
                                                }
                                                else if($filterby == "This Year")
                                                {
                                                    $filter = date("Y");
                                                    $findtaskper_status = mysqli_query($conn, "SELECT * FROM task WHERE task_status_id = '$status_idss' and task_assign_to = '' and task_date_created LIKE '%$filter%' ORDER BY task_name");
                                                }
                                                else if($filterby == "Custom Date")
                                                {
                                                    $get_from = $_GET['From'];
                                                    $get_to = $_GET['To'];
                                                    $findtaskper_status = mysqli_query($conn, "SELECT * FROM task WHERE task_status_id = '$status_idss' and task_assign_to = '' and task_date_created BETWEEN '$get_from' AND '$get_to' ORDER BY task_name");
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
                                                $findtaskper_status = mysqli_query($conn, "SELECT * FROM task WHERE task_status_id = '$status_idss' and task_assign_to = '' and task_date_created BETWEEN '$from' AND '$to' ORDER BY task_name");
                                            }
                                            // $findtaskper_status = mysqli_query($conn, "SELECT * FROM task WHERE task_status_id = '$status_idss' AND task_assign_to = '' ORDER BY task_name ASC");
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
                                                                        echo '<li class="aaa bbb" id="'.$result_findtaskper_status['task_id'].','.$space_name.','.$list_name.','.$list_id.'" onclick="view_task_box(this.id)">'.$result_findtaskper_status['task_name'].'</li>';
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
                echo '</ul>';
    }
    // ----------------------- End Show Box Space Unasssign list in Everthing page -----------------------

    // ----------------------- Show Box Space Assign list in Everthing page -----------------------
    if(isset($_POST['show_space_assign']))
    {
            $user_id = $_POST['user_id'];
            $filter = $_POST['filter'];
            echo '<ul class="nav-main" style="margin-top: -20px;">';

                    $find_space = mysqli_query($conn, "SELECT * FROM space ORDER BY space_name ASC");
                    while($fetch_space = mysqli_fetch_array($find_space))
                    {
                        $space_id = $fetch_space['space_id'];
                        $space_name = $fetch_space['space_name'];

                        //query for filtering data
                        $filter = $_POST['filter'];
                        if ($filter) {
                            $filterby = $filter;

                            if($filterby == "All")
                            {
                                $findtaskper_space = mysqli_query($conn, "SELECT * FROM task WHERE task_assign_to != ''");
                            }
                            else if($filterby == "Today")
                            {
                                $filter = date("Y-m-d");
                                $findtaskper_space = mysqli_query($conn, "SELECT * FROM task WHERE task_assign_to != '' and task_date_created LIKE '%$filter%'");
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
                                $findtaskper_space = mysqli_query($conn, "SELECT * FROM task WHERE task_assign_to != '' and task_date_created BETWEEN '$from' AND '$to'");
                            }
                            else if($filterby == "This Month")
                            {
                                $filter = date("Y-m");
                                $findtaskper_space = mysqli_query($conn, "SELECT * FROM task WHERE task_assign_to != '' and task_date_created LIKE '%$filter%'");
                            }
                            else if($filterby == "This Year")
                            {
                                $filter = date("Y");
                                $findtaskper_space = mysqli_query($conn, "SELECT * FROM task WHERE task_assign_to != '' and task_date_created LIKE '%$filter%'");
                            }
                            else if($filterby == "Custom Date")
                            {
                                $get_from = $_GET['From'];
                                $get_to = $_GET['To'];
                                $findtaskper_space = mysqli_query($conn, "SELECT * FROM task WHERE task_assign_to != '' and task_date_created BETWEEN '$get_from' AND '$get_to'");
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
                            $findtaskper_space = mysqli_query($conn, "SELECT * FROM task WHERE task_assign_to != '' and task_date_created BETWEEN '$from' AND '$to'");
                        }

                        // $findtaskper_space = mysqli_query($conn, "SELECT * FROM task WHERE task_assign_to = ''");
                        $count_for_space = 0;
                        while($fetch_findtaskper_space = mysqli_fetch_array($findtaskper_space))
                        {

                            $task_assign_to = $fetch_findtaskper_space['task_assign_to'];
                            $array_assign = explode(",",$task_assign_to);
                            if (in_array($user_id, $array_assign))
                            {
                                $task_list_id = $fetch_findtaskper_space['task_list_id'];
                                $select_list = mysqli_query($conn, "SELECT * FROM list WHERE list_id = '$task_list_id'");
                                $fetch_array = mysqli_fetch_array($select_list);
                                if($fetch_array['list_space_id'] == $space_id)
                                {
                                    $count_for_space++;
                                }
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

                            $find_list = mysqli_query($conn, "SELECT * FROM list WHERE list_space_id = '$space_id' ORDER BY list_name ASC");
                            while($fetch_list = mysqli_fetch_array($find_list))
                            {
                                $list_id = $fetch_list['list_id'];
                                $list_name = $fetch_list['list_name'];
                                //query for filtering data
                                $filter = $_POST['filter'];
                                if ($filter) {
                                    $filterby = $filter;

                                    if($filterby == "All")
                                    {
                                        $findtaskper_list = mysqli_query($conn, "SELECT * FROM task WHERE task_list_id = '$list_id' and task_assign_to != ''");
                                    }
                                    else if($filterby == "Today")
                                    {
                                        $filter = date("Y-m-d");
                                        $findtaskper_list = mysqli_query($conn, "SELECT * FROM task WHERE task_list_id = '$list_id' and task_assign_to != '' and task_date_created LIKE '%$filter%'");
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
                                        $findtaskper_list = mysqli_query($conn, "SELECT * FROM task WHERE task_list_id = '$list_id' and task_assign_to != '' and task_date_created BETWEEN '$from' AND '$to'");
                                    }
                                    else if($filterby == "This Month")
                                    {
                                        $filter = date("Y-m");
                                        $findtaskper_list = mysqli_query($conn, "SELECT * FROM task WHERE task_list_id = '$list_id' and task_assign_to != '' and task_date_created LIKE '%$filter%'");
                                    }
                                    else if($filterby == "This Year")
                                    {
                                        $filter = date("Y");
                                        $findtaskper_list = mysqli_query($conn, "SELECT * FROM task WHERE task_list_id = '$list_id' and task_assign_to != '' and task_date_created LIKE '%$filter%'");
                                    }
                                    else if($filterby == "Custom Date")
                                    {
                                        $get_from = $_GET['From'];
                                        $get_to = $_GET['To'];
                                        $findtaskper_list = mysqli_query($conn, "SELECT * FROM task WHERE task_list_id = '$list_id' and task_assign_to != '' and task_date_created BETWEEN '$get_from' AND '$get_to'");
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
                                    $findtaskper_list = mysqli_query($conn, "SELECT * FROM task WHERE task_list_id = '$list_id' and task_assign_to != '' and task_date_created BETWEEN '$from' AND '$to'");
                                }
                                // $findtaskper_list= mysqli_query($conn, "SELECT * FROM task WHERE task_list_id = '$list_id' AND task_assign_to = ''");
                                $list_count = 0;
                                while($task_count = mysqli_fetch_array($findtaskper_list))
                                {
                                    $task_assign_to = $task_count['task_assign_to'];
                                    $array_assign = explode(",",$task_assign_to);
                                    if (in_array($user_id, $array_assign))
                                    {
                                        $list_count++;
                                    }
                                }
                                // $list_count = mysqli_num_rows($findtaskper_list);
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
                                            //query for filtering data
                                            $filter = $_POST['filter'];
                                            if ($filter) {
                                                $filterby = $filter;

                                                if($filterby == "All")
                                                {
                                                    $findtaskper_status = mysqli_query($conn, "SELECT * FROM task WHERE task_status_id = '$status_idss' and task_assign_to != '' ORDER BY task_name");
                                                    $findtaskper_status_count = mysqli_query($conn, "SELECT * FROM task WHERE task_status_id = '$status_idss' and task_assign_to != '' ORDER BY task_name");
                                                }
                                                else if($filterby == "Today")
                                                {
                                                    $filter = date("Y-m-d");
                                                    $findtaskper_status = mysqli_query($conn, "SELECT * FROM task WHERE task_status_id = '$status_idss' and task_assign_to != '' and task_date_created LIKE '%$filter%' ORDER BY task_name");
                                                    $findtaskper_status_count = mysqli_query($conn, "SELECT * FROM task WHERE task_status_id = '$status_idss' and task_assign_to != '' and task_date_created LIKE '%$filter%' ORDER BY task_name");
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
                                                    $findtaskper_status = mysqli_query($conn, "SELECT * FROM task WHERE task_status_id = '$status_idss' and task_assign_to != '' and task_date_created BETWEEN '$from' AND '$to' ORDER BY task_name");
                                                    $findtaskper_status_count = mysqli_query($conn, "SELECT * FROM task WHERE task_status_id = '$status_idss' and task_assign_to != '' and task_date_created BETWEEN '$from' AND '$to' ORDER BY task_name");
                                                }
                                                else if($filterby == "This Month")
                                                {
                                                    $filter = date("Y-m");
                                                    $findtaskper_status = mysqli_query($conn, "SELECT * FROM task WHERE task_status_id = '$status_idss' and task_assign_to != '' and task_date_created LIKE '%$filter%' ORDER BY task_name");
                                                    $findtaskper_status_count = mysqli_query($conn, "SELECT * FROM task WHERE task_status_id = '$status_idss' and task_assign_to != '' and task_date_created LIKE '%$filter%' ORDER BY task_name");
                                                }
                                                else if($filterby == "This Year")
                                                {
                                                    $filter = date("Y");
                                                    $findtaskper_status = mysqli_query($conn, "SELECT * FROM task WHERE task_status_id = '$status_idss' and task_assign_to != '' and task_date_created LIKE '%$filter%' ORDER BY task_name");
                                                    $findtaskper_status_count = mysqli_query($conn, "SELECT * FROM task WHERE task_status_id = '$status_idss' and task_assign_to != '' and task_date_created LIKE '%$filter%' ORDER BY task_name");
                                                }
                                                else if($filterby == "Custom Date")
                                                {
                                                    $get_from = $_GET['From'];
                                                    $get_to = $_GET['To'];
                                                    $findtaskper_status = mysqli_query($conn, "SELECT * FROM task WHERE task_status_id = '$status_idss' and task_assign_to != '' and task_date_created BETWEEN '$get_from' AND '$get_to' ORDER BY task_name");
                                                    $findtaskper_status_count = mysqli_query($conn, "SELECT * FROM task WHERE task_status_id = '$status_idss' and task_assign_to != '' and task_date_created BETWEEN '$get_from' AND '$get_to' ORDER BY task_name");
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
                                                $findtaskper_status = mysqli_query($conn, "SELECT * FROM task WHERE task_status_id = '$status_idss' and task_assign_to != '' and task_date_created BETWEEN '$from' AND '$to' ORDER BY task_name");
                                                $findtaskper_status_count = mysqli_query($conn, "SELECT * FROM task WHERE task_status_id = '$status_idss' and task_assign_to != '' and task_date_created BETWEEN '$from' AND '$to' ORDER BY task_name");
                                            }
                                            // $findtaskper_status = mysqli_query($conn, "SELECT * FROM task WHERE task_status_id = '$status_idss' AND task_assign_to = '' ORDER BY task_name ASC");
                                            $status_count = 0;
                                            while($task_count_status = mysqli_fetch_array($findtaskper_status_count))
                                            {
                                                $task_assign_to = $task_count_status['task_assign_to'];
                                                $array_assign = explode(",",$task_assign_to);
                                                if (in_array($user_id, $array_assign))
                                                {
                                                    $status_count++;
                                                }
                                            }
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

                                                                        echo '<li class="aaa bbb" id="'.$result_findtaskper_status['task_id'].','.$space_name.','.$list_name.','.$list_id.'" onclick="view_task_box(this.id)">'.$result_findtaskper_status['task_name'].'</li>';
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
                echo '</ul>';
    }
    // ----------------------- End Show Box Space Assign list in Everthing page -----------------------

    // ----------------------- GET DATA FOR TABLE SEND HISTORY -----------------------
    if(isset($_POST['display_email_history_table']))
    {
        $task_id = $_POST['task_id'];

        $results = mysqli_query($conn, "SELECT `user`.fname, `user`.mname, `user`.lname, email_format.email_name, email_format.email_subject, email_format.email_id, email_send_history.`email_send_to`, email_send_history.email_send_date, email_send_history.email_content FROM email_send_history INNER JOIN `user` ON email_send_history.email_send_by = `user`.user_id INNER JOIN email_format ON email_send_history.email_format_id = email_format.email_id WHERE email_send_history.email_task_id = '$task_id' ORDER BY email_send_history.email_send_date DESC");
        $count = 1;

        while($rows = mysqli_fetch_array($results))
        {
            $email_name = $rows['email_name'];
            $file_loc = "email_content/".$email_name.".txt";

            $myfile = fopen($file_loc, "r") or die("Unable to open file!");
            $content = fread($myfile,filesize($file_loc));
            // fclose($myfile);

            echo '
                    <tr>
                        <td colspan="1" style="width: 15%;text-align: end;">
                        Date/Time Sent:<br>
                        Sent by:<br>
                        Email Name:<br>
                        Email Subject:<br>
                        Email Address:
                        </td>
                        <td colspan="2" style="width: 25%;">
                        '.$rows["email_send_date"].' <br>
                        '.$rows["fname"].' '.$rows["mname"].' '.$rows["lname"].'<br>
                        '.$rows["email_name"].' <br>
                        '.$rows["email_subject"].' <br>
                        '.$rows["email_send_to"].'
                        </td>
                        <td colspan="3">
                                <div style="padding: 20px 0px 0px 0px; background-color: #00465a; max-height:300px; overflow:auto;" class="shadow">
                                    <img src="http://ipasspmt.site/assets/media/photos/email_header.png" style="width: 100%; height: auto;">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="20" style="background-color: #47bcde; color: #5a5f61; font-family:verdana;">
                                        <tr>
                                            <td style="background-color: #fff; border-top: 20px solid #006786; border-bottom: 20px solid #006786;">
                                                '.$rows["email_content"].'
                                            </td>
                                        </tr>
                                    </table>
                                    <div style="text-align: center; padding: 20px 0px; color: #fff; background-color: #00465a;">
                                        PROCESSING MADE EASY BY IPASS<br>
                                        Rm 1, 2nd Floor, Doña Segunda Complex,<br>
                                        Ponciano Street, Davao City, Philippines 8000<br><br>
                                        <a href="https://ipassprocessing.com/" style="color: #2196f3;">https://ipassprocessing.com/</a>
                                    </div>
                                </div>
                        <td>
                    </tr>
            ';
        }
    }

    // ----------------------- TRANSACTION DETAILS UPDATE -----------------------
    if(isset($_POST['update_transaction']))
    {
        $val_id = $_POST['val_id'];
        $tran_date = $_POST['tran_date'];
        $tran_method = $_POST['tran_method'];
        $tran_transaction_no = $_POST['tran_transaction_no'];
        $tran_amount = $_POST['tran_amount'];
        $tran_client_rate = $_POST['tran_client_rate'];
        $tran_currency = $_POST['tran_currency'];
        $tran_note = $_POST['tran_note'];
        $tran_file = $_POST['file_attachment'];

        $tran_initial = $_POST['tran_initial'];
        $tran_usd_rate = $_POST['tran_usd_rate'];
        $tran_usd_total = $_POST['tran_usd_total'];
        $tran_php_rate = $_POST['tran_php_rate'];
        $tran_php_total = $_POST['tran_php_total'];
        $tran_client_php_total = $_POST['tran_client_php_total'];

        $tran_charge = $_POST['tran_charge'];
        $tran_charge_type = $_POST['tran_charge_type'];
            if($tran_charge == "")
            {
                $charge = "|";
            }
            else
            {
                $charge = $tran_charge_type.'|'.$tran_charge;
            }

            if (empty($tran_file))
            {
                mysqli_query($conn, "UPDATE finance_transaction SET val_date = '$tran_date', val_method = '$tran_method', val_transaction_no = '$tran_transaction_no', val_amount = '$tran_amount', val_client_rate = '$tran_client_rate', val_currency = '$tran_currency', val_note = '$tran_note', val_charge = '$charge', val_initial_amount = '$tran_initial', val_usd_rate = '$tran_usd_rate', val_usd_total = '$tran_usd_total', val_php_rate = '$tran_php_rate', val_php_total = '$tran_php_total', val_client_total = '$tran_client_php_total'  WHERE val_id = '$val_id'") or die(mysqli_error());

                echo 'success';
            }
    }
    // -----------------------END TRANSACTION DETAILS UPDATE -----------------------

    // ----------------------- TRANSACTION DETAILS UPDATE WITH PICTURE -----------------------
    if(isset($_POST['update_transaction_with_picture']))
    {
        $val_id = $_POST['val_id'];
        $tran_date = $_POST['tran_date'];
        $tran_method = $_POST['tran_method'];
        $tran_transaction_no = $_POST['tran_transaction_no'];
        $tran_amount = $_POST['tran_amount'];
        $tran_client_rate = $_POST['tran_client_rate'];
        $tran_currency = $_POST['tran_currency'];
        $tran_note = $_POST['tran_note'];

        $tran_initial = $_POST['tran_initial'];
        $tran_usd_rate = $_POST['tran_usd_rate'];
        $tran_usd_total = $_POST['tran_usd_total'];
        $tran_php_rate = $_POST['tran_php_rate'];
        $tran_php_total = $_POST['tran_php_total'];
        $tran_client_php_total = $_POST['tran_client_php_total'];
        $val_attachment = $_POST['val_attachment'];

        $tran_charge = $_POST['tran_charge'];
        $tran_charge_type = $_POST['tran_charge_type'];
            if($tran_charge == "")
            {
                $charge = "|";
            }
            else
            {
                $charge = $tran_charge_type.'|'.$tran_charge;
            }

        $attachment_name = $_FILES['file_attachment']['name'];
        $attachment_temp = $_FILES['file_attachment']['tmp_name'];
        $attachment_size = $_FILES['file_attachment']['size'];
        $exp = explode(".", $attachment_name);
        $ext = end($exp);
        $allowed_ext = array('jpg', 'JPG', 'jpeg', 'JPEG', 'png', 'PNG');
            if(in_array($ext, $allowed_ext)) // check the file extension
            {
                date_default_timezone_set('Asia/Manila');
                //$todays_date = date("y-m-d H:i:sa"); //  original format
                $date = date("His"); // for unique file name

                $words = explode(' ',trim($attachment_name)); // convert name to array
                $get_name = substr($words[0], 0, 6); // get only 6 character of the name

                $image = $date.'-'.$get_name.'.'.$ext;
                $location = "../assets/media/transaction/".$image; // upload location

                if($attachment_size < 10000000) // Maximum 10 MB
                {
                    unlink('../assets/media/transaction/'.$val_attachment);
                    move_uploaded_file($attachment_temp, $location);
                    mysqli_query($conn, "UPDATE finance_transaction SET val_date = '$tran_date', val_method = '$tran_method', val_transaction_no = '$tran_transaction_no', val_amount = '$tran_amount', val_client_rate = '$tran_client_rate', val_currency = '$tran_currency', val_note = '$tran_note', val_charge = '$charge', val_attachment = '$image'  WHERE val_id = '$val_id'") or die(mysqli_error());
                    echo "success";
                }
            }
    }
    // -----------------------END TRANSACTION DETAILS UPDATE WITH PICTURE -----------------------

    if(isset($_POST['hide_status']))
    {
        $list_id = $_POST['list_id'];
        $task_id = $_POST['task_id'];

        $results_contact = mysqli_query($conn, "SELECT contact.contact_id FROM task INNER JOIN contact ON task.task_contact = contact.contact_id WHERE task.task_id = $task_id LIMIT 1");
        $data = mysqli_fetch_assoc($results_contact);
        $contact_id = $data['contact_id'];

        $results = mysqli_query($conn, "SELECT * FROM status WHERE status_list_id = $list_id ORDER BY status_order_no");
        while($rows = mysqli_fetch_array($results))
        {
            $status_id = $rows['status_id'];
            $status_list_id = $rows['status_list_id'];

            $query_status_details = mysqli_query($conn, "SELECT * FROM tbl_status_details WHERE status_id = $status_id AND status_list_id = $status_list_id AND contact_id = $contact_id AND task_id = $task_id");
            if (mysqli_num_rows($query_status_details)) {
                $tr = '<tr style="background-color: #85b0bd;">';
            } else {
                $tr = '<tr style="cursor: pointer;" id="'.$rows['status_id'].','.$data['contact_id'].','.$list_id.','.$task_id.'" onclick="click_hide_status(this.id)">';
            }

            echo '
            '.$tr.'
                <td>'.$rows['status_name'].'</td>
            </tr>
            ';
        }
    }

    if(isset($_POST['show_status']))
    {
        $list_id = $_POST['list_id'];
        $task_id = $_POST['task_id'];

        $results_contact = mysqli_query($conn, "SELECT contact.contact_id FROM task INNER JOIN contact ON task.task_contact = contact.contact_id WHERE task.task_id = $task_id LIMIT 1");
        $data = mysqli_fetch_assoc($results_contact);
        $contact_id = $data['contact_id'];

        $query = mysqli_query($conn, "SELECT `status`.status_name,tbl_status_details.status_details_id FROM `status` INNER JOIN tbl_status_details ON tbl_status_details.status_id = `status`.status_id WHERE tbl_status_details.contact_id = $contact_id AND tbl_status_details.status_list_id = $list_id AND tbl_status_details.task_id = $task_id ORDER BY tbl_status_details.status_details_id DESC");
        while($rows = mysqli_fetch_array($query))
        {
            echo '
            <tr style="cursor: pointer;" id="'.$rows['status_details_id'].'" onclick="delete_status(this.id)">
                <td>'.$rows['status_name'].'</td>
            </tr>
            ';
        }
    }

    if(isset($_POST['click_hide_status']))
    {
        $status_id = $_POST['status_id'];
        $contact_id = $_POST['contact_id'];
        $statud_list_id = $_POST['statud_list_id'];
        $task_id = $_POST['task_id'];

        $insert_status_details = mysqli_query($conn, "INSERT INTO tbl_status_details (status_id,contact_id,status_list_id,task_id) VALUES ($status_id,$contact_id,$statud_list_id,$task_id)");
        if ($insert_status_details) {
            echo 'success';
        }
    }

    if(isset($_POST['delete_status']))
    {
        $status_details_id = $_POST['status_details_id'];

        $delete_status = mysqli_query($conn, "DELETE FROM tbl_status_details WHERE status_details_id = $status_details_id");
        if ($delete_status) {
            echo 'success';
        }
    }


    if(isset($_POST['fetch_email_pictures']))
    {
        echo '
        <table class="table table-bordered table-striped table-vcenter js-dataTable-full">
            <thead>
                <tr>
                    <th class="text-center">NO.</th>
                    <th class="text-center">Pictures</th>
                    <th class="text-center">Links</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
            <tbody>
        ';
        $query = mysqli_query($conn, "SELECT * FROM email_pictures ORDER BY email_picture_id DESC");
        $count =  1;
        while($rows = mysqli_fetch_array($query))
        {
            echo '
                <tr>
                    <td class="text-center">'.$count++.'</td>
                    <td class="text-center"><a target="_blank" href="./email_picture/'.$rows['email_picture_name'].'"><img style="width: 120px; height: auto;" src="./email_picture/'.$rows['email_picture_name'].'"></a></td>
                    <td class="text-center">http://localhost/ipass/team/email_picture/'.$rows['email_picture_name'].'</td>
                    <td class="text-center">
                        <button type="button" class="btn btn-sm btn-secondary" data-toggle="tooltip" title="View Customer" id="'.$rows['email_picture_name'].'" onclick="delete_email_picture(this.id)">
                            <i class="fa fa-trash-o"></i>
                        </button>
                    </td>
                </tr>
            ';
        }
        echo '
            </tbody>
        </table>
        ';

        // echo "Nag fetch sya";
    }

    if(isset($_POST['save_email_pictures']))
    {
        $info_image = $_POST['email_pictures'];
        $attachment_name = $_FILES['file_attachment']['name'];
        $attachment_temp = $_FILES['file_attachment']['tmp_name'];
        $attachment_size = $_FILES['file_attachment']['size'];
        $exp = explode(".", $attachment_name);
        $ext = end($exp);
        $allowed_ext = array('jpg', 'JPG', 'jpeg', 'JPEG', 'png', 'PNG');
            if(in_array($ext, $allowed_ext)) // check the file extension
            {
                date_default_timezone_set('Asia/Manila');
                //$todays_date = date("y-m-d H:i:sa"); //  original format
                $date = date("His"); // for unique file name

                $words = explode(' ',trim($attachment_name)); // convert name to array
                $get_name = substr($words[0], 0, 6); // get only 6 character of the name

                $image = $date.'-'.$get_name.'.'.$ext;
                $location = "./email_picture/".$image; // upload location

                if($attachment_size < 10000000) // Maximum 10 MB
                {
                    // unlink('../assets/media/transaction/'.$info_image);
                    move_uploaded_file($attachment_temp, $location);
                    $save_data = mysqli_query($conn, "INSERT into email_pictures (email_picture_name) values ('$image')") or die(mysqli_error());
                    if ($save_data) {
                        echo "success";
                    }
                }
            }
    }

    if(isset($_POST['delete_email_picture']))
    {
        $email_name = $_POST['email_pictures'];

        $delete_status = mysqli_query($conn, "DELETE FROM email_pictures WHERE email_picture_name = '$email_name'");
        if ($delete_status) {
            unlink('./email_picture/'.$email_name);
            echo 'success';
        }
    }

    if(isset($_POST['save_input_field']))
    {
        $id = $_POST['user_id'];
        $space_id = $_POST['space_id'];
        $task_id = $_POST['task_id'];
        $field_id = $_POST['field_id'];
        $input_value  = $_POST['input_value'];

        //auto create row specific space db
        $select_db = mysqli_query($conn, "SELECT * FROM space WHERE space_id ='$space_id'");
        $fetch_select_db = mysqli_fetch_array($select_db);
        $space_db_table = $fetch_select_db['space_db_table']; // getting the db_table name of the space

        $check_if_task_exist = mysqli_query($conn, "SELECT * FROM $space_db_table WHERE task_id ='$task_id'");
        $count1 = mysqli_num_rows($check_if_task_exist);
        if($count1 == 0)
        {
            mysqli_query($conn,"INSERT INTO `$space_db_table` (task_id) values ('$task_id')") or die(mysqli_error());
        }
        $count = mysqli_num_rows($select_db);
        if($count == 1)
        {
            $select_col_name = mysqli_query($conn, "SELECT * FROM field WHERE field_id ='$field_id'");
            $fetch_col_name = mysqli_fetch_array($select_col_name);
            $col_name = $fetch_col_name['field_col_name']; // get the col_name in db
            $field_name = $fetch_col_name['field_name']; // get the field_name in db
            $field_type = $fetch_col_name['field_type']; // get the field_name in db

            // Below is code for adding comment
            $select_if_has_value = mysqli_query($conn, "SELECT * FROM `$space_db_table` WHERE task_id = '$task_id'");
            $result = mysqli_fetch_array($select_if_has_value);
            $col_value = $result[''.$col_name.'']; // get current value

            if ($field_type == "Dropdown")// identify if dropdown
            {
                // get the value if specific option
                $select_child = mysqli_query($conn, "SELECT * FROM `child` WHERE child_id = '$input_value'");
                $fetch_result = mysqli_fetch_array($select_child);
                $child_name = $fetch_result['child_name']; // get the child name

                $msg = 'Update field name: "'.$field_name.'" value: "'.$child_name.'".';
            }
            else
            {
                $msg = 'Update field name: "'.$field_name.'" value: "'.$input_value.'".';
            }
            // echo $id;
            // echo $space_id;
            // echo $task_id;
            // echo $field_id;
            // echo $input_value;
            $insert_comment = mysqli_query($conn,"INSERT INTO comment (comment_task_id, comment_user_id, comment_message, comment_date, comment_type) VALUES ('$task_id', '$id', '$msg', NOW(), '1')") or die(mysqli_error());
            if ($insert_comment) {
                $update_space_db_table = mysqli_query($conn, "UPDATE `$space_db_table` SET `$col_name` = '$input_value' WHERE task_id = '$task_id'") or die(mysqli_error());
                if ($update_space_db_table) {
                    echo 'update';
                }
            }
        }
    }

    if(isset($_POST['send_email_blasting']))
    {
        $contact_id = $_POST['contact_id'];
        $email_id = $_POST['email_id'];
        $user_id = $_POST['user_id'];
        $status_id = $_POST['task_status_id'];
        $email_subject = $_POST['email_subject'];
        $email_content = $_POST['email_content'];
        $date = date('Y-m-d H:i:s');

        if (isset($_SESSION['set_email'])) {
            $from = $_SESSION['set_email'];
        } else {
            $from = '';
        }
        $result = mysqli_query($conn, "SELECT * FROM tbl_list_email WHERE list_email_name = '$from'") or die(mysqli_error());
        $data = mysqli_fetch_array($result);
        $pass = $data['list_email_password'];

        foreach($contact_id as $contact_id){
          $query = mysqli_query($conn, "SELECT contact.contact_fname, contact.contact_email, task.task_id, task.task_status_id, task.task_list_id FROM task INNER JOIN contact ON task.task_contact = contact.contact_id WHERE contact.contact_id = '$contact_id'");
          $data = mysqli_fetch_array($query);
              $contact_fname = $data['contact_fname'];
              $contact_email = $data['contact_email'];
              $task_id = $data['task_id'];
              $task_status_id = $data['task_status_id'];
        			$task_list_id = $data['task_list_id'];

              $message = '
              <div style="padding: 20px 0px 0px 0px; background-color: #189AA7;" class="shadow">
                  <img src="https://ipasspmt.com/assets/media/photos/email_header.png" style="width: 100%;">
                  <table width="100%" border="0" cellspacing="0" cellpadding="20" style="background-color: #47bcde; color: #5a5f61; font-family:verdana;">
                      <tr>
                          <td style="background-color: #fff; border-top: 10px solid #189AA7; border-bottom: 10px solid #189AA7;">
                              <p style="margin-top: -5px;">Hi '.$contact_fname.',</p>
                              '.$email_content.'
                          </td>
                      </tr>
                  </table>
                  <div style="text-align: center; padding: 20px 0px; color: #fff; background-color: #189AA7;">
                      PROCESSING MADE EASY BY IPASS<br>
                      Rm 1, 2nd Floor, Doña Segunda Complex,<br>
                      Ponciano Street, Davao City, Philippines 8000<br><br>
                      <a href="https://ipassprocessing.com/" style="color: white;">https://ipassprocessing.com/</a>
                  </div>
              </div>
              ';
                  $mail->isSMTP();
                  $mail->Host = 'smtp.gmail.com';
                  $mail->SMTPAuth = true;
                  $mail->Username = "$from"; // Gmail address which you want to use as SMTP server
                  $mail->Password = "$pass"; // Gmail address Password
                  $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                  $mail->Port = '587';
                  //$mail->setFrom('test_email@ipasspmt.com'); // Gmail address which you used as SMTP server
                  $mail->setFrom("$from");
                  $mail->addAddress("$contact_email"); // Email address where you want to receive emails (you can use any of your gmail address including the gmail address which you used as SMTP server)

                  $mail->isHTML(true);
                  $mail->Subject = "$email_subject";
                  $mail->Body = "$message";
                  $mail->send();
                  mysqli_query($conn, "INSERT INTO email_send_history (email_send_date, email_send_by, email_format_id, email_send_to, email_task_id, email_content, email_blast, email_status_id, email_list_id) values ('$date', '$user_id', '$email_id', '$contact_email', '$task_id', '$email_content', '1', '$status_id', '$task_list_id')") or die(mysqli_error());
        }
        echo "success";
    }

    if(isset($_POST['unset_email_blast']))
    {
        unset($_SESSION['email_blasting']);
    }

    if(isset($_POST['email_blasting_details']))
    {
        // echo "Naa";
        $task_id = $_POST['task_id'];

        $results = mysqli_query($conn, "SELECT `user`.fname, `user`.mname, `user`.lname, email_format.email_name, email_format.email_subject, email_format.email_id, email_send_history.email_send_to, email_send_history.email_send_date, email_send_history.email_content, `status`.status_name FROM email_send_history INNER JOIN `user` ON email_send_history.email_send_by = `user`.user_id INNER JOIN email_format ON email_send_history.email_format_id = email_format.email_id INNER JOIN `status` ON email_send_history.email_status_id = `status`.status_id WHERE email_send_history.email_task_id = $task_id AND email_send_history.email_blast = 1 ORDER BY email_send_history.email_send_date DESC");
        $count = 1;

        while($rows = mysqli_fetch_array($results))
        {
            $email_name = $rows['email_name'];
            $file_loc = "email_content/".$email_name.".txt";

            $myfile = fopen($file_loc, "r") or die("Unable to open file!");
            $content = fread($myfile,filesize($file_loc));
            // fclose($myfile);

            echo '
                    <tr>
                        <td colspan="1" style="width: 15%;text-align: end;"><br>
                        Date/Time Sent:<br>
                        Sent by:<br>
                        Email Name:<br>
                        Email Subject:<br>
                        Email Address:
                        Status:
                        </td>
                        <td colspan="2" style="width: 25%;"><br>
                        '.$rows["email_send_date"].' <br>
                        '.$rows["fname"].' '.$rows["mname"].' '.$rows["lname"].'<br>
                        '.$rows["email_name"].' <br>
                        '.$rows["email_subject"].' <br>
                        '.$rows["email_send_to"].'<br>
                        '.$rows["status_name"].'
                        </td>
                        <td colspan="3">
                                <div style="padding: 20px 0px 0px 0px; background-color: #189AA7;" class="shadow">
                                    <img src="https://ipasspmt.com/assets/media/photos/email_header.png" style="width: 100%;">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="20" style="background-color: #47bcde; color: #5a5f61; font-family:verdana;">
                                        <tr>
                                            <td style="background-color: #fff; border-top: 10px solid #189AA7; border-bottom: 10px solid #189AA7;">
                                                '.$rows["email_content"].'
                                            </td>
                                        </tr>
                                    </table>
                                    <div style="text-align: center; padding: 20px 0px; color: #fff; background-color: #189AA7;">
                                        PROCESSING MADE EASY BY IPASS<br>
                                        Rm 1, 2nd Floor, Doña Segunda Complex,<br>
                                        Ponciano Street, Davao City, Philippines 8000<br><br>
                                        <a href="https://ipassprocessing.com/" style="color: white;">https://ipassprocessing.com/</a>
                                    </div>
                                </div>
                        <td>
                    </tr>
            ';
        }
    }

    if(isset($_POST['save_department']))
    {
        $user_id = $_POST['user_id'];
        $department = $_POST['department'];

        $result = mysqli_query($conn, "UPDATE user SET department = '$department' WHERE user_id = '$user_id'") or die(mysqli_error());
        if ($result) {
            echo 'success';
        }
    }

    if(isset($_POST['save_category']))
    {
        $user_id = $_POST['user_id'];
        $category = $_POST['category'];

        $result = mysqli_query($conn, "UPDATE user SET category = '$category' WHERE user_id = '$user_id'") or die(mysqli_error());
        if ($result) {
            echo 'success';
        }
    }

    if(isset($_POST['add_category']))
    {
        $cat_name = $_POST['cat_name'];

        $result = mysqli_query($conn, "INSERT INTO tbl_category (cat_name) VALUES ('$cat_name')") or die(mysqli_error());
        if ($result) {
            echo 'success';
        }
    }

    if(isset($_POST['add_department']))
    {
        $dep_name = $_POST['dep_name'];

        $result = mysqli_query($conn, "INSERT INTO tbl_department (dep_name) VALUES ('$dep_name')") or die(mysqli_error());
        if ($result) {
            echo 'success';
        }
    }

    if(isset($_POST['filter_services']))
    {
        $space_id = $_POST['space_id'];

        $result = mysqli_query($conn, "SELECT * FROM list WHERE list_space_id = '$space_id' ORDER BY list_name") or die(mysqli_error());
        while($rows = mysqli_fetch_array($result))
        {
          echo '
          <button class="dropdown-item" id="'.$rows['list_id'].'" onclick="filter_list(this.id)">
              <i class="fa fa-fw fa-th-list mr-5"></i>'.$rows['list_name'].'
          </button>
          ';
        }
    }

    if(isset($_POST['filter_list']))
    {
        $list_id = $_POST['list_id'];

        $result = mysqli_query($conn, "SELECT * FROM status WHERE status_list_id = '$list_id' ORDER BY status_order_no") or die(mysqli_error());
        while($rows = mysqli_fetch_array($result))
        {
          echo '
          <button class="dropdown-item">
          <input type="checkbox" id="status" value="'.$rows['status_id'].'">
          <label>'.$rows['status_name'].'</label>
          </button>
          ';
        }
        echo '
          <button class="btn btn-success form-control" onclick="filter_status()">
          Filter
          </button>
        ';
    }

    if(isset($_POST['filter_status']))
    {
        $user_id = $_SESSION['user'];
        $status_id = $_POST['status_id'];
        $array_status_id = join(',', $status_id);
        $delete_filter = mysqli_query($conn, "DELETE FROM filter_status WHERE user_id = $user_id AND filter_name = 'everything'") or die(mysqli_error());
        $result = mysqli_query($conn, "INSERT INTO filter_status (user_id, array_status, filter_name) VALUES ($user_id, '$array_status_id', 'everything')") or die(mysqli_error());
        if ($result) {
          echo 'success';
        }
    }

    if(isset($_POST['delete_filter_status_id']))
    {
        $filter_status_id = $_POST['filter_status_id'];
        $result = mysqli_query($conn, "DELETE FROM filter_status WHERE filter_status_id = $filter_status_id") or die(mysqli_error());
        if ($result) {
          echo 'success';
        }
    }

    if(isset($_POST['to_be_email_blast']))
    {
        $status_id = $_POST['status_id'];
        $result = mysqli_query($conn, "SELECT contact.contact_email, contact.contact_id FROM task INNER JOIN contact ON task.task_contact = contact.contact_id WHERE task_status_id = '$status_id'") or die(mysqli_error());
        while($row = mysqli_fetch_array($result))
        {
          $email_send_to = $row['contact_email'];
          $result_history = mysqli_query($conn, "SELECT * FROM email_send_history WHERE email_send_to = '$email_send_to' AND email_blast = 1 AND email_status_id = $status_id") or die(mysqli_error());
          $count = mysqli_num_rows($result_history);
          echo '
                <tr>
                  <td'; if ($count == 1) {
                    echo 'style="display: none;"';
                  } echo '>
                  <input type="checkbox" id="mag_blast" name="mag_blast" value="'.$row['contact_id'].'" onclick="count_check_email()">
                  <labe>'.$row['contact_email'].'</label><br>
                  </td>
                </tr>
          ';
        }
    }

    if(isset($_POST['done_blasting']))
    {
        $status_id = $_POST['status_id'];
        $result = mysqli_query($conn, "SELECT * FROM email_send_history WHERE email_status_id = '$status_id'") or die(mysqli_error());
        while($row = mysqli_fetch_array($result))
        {
          echo '
                <tr>
                  <td>
                  <label>'.$row['email_send_to'].'</label><br>
                  </td>
                </tr>
          ';
        }
    }

    if(isset($_POST['count_total_blast']))
    {
        $status_id = $_POST['status_id'];
        $result = mysqli_query($conn, "SELECT Count( email_send_history.email_send_id ) AS total_blast FROM email_send_history WHERE email_status_id = '$status_id'") or die(mysqli_error());
        while($row = mysqli_fetch_array($result))
        {
          echo $row['total_blast'];
        }
    }

    if(isset($_POST['show_individual_report']))
    {
        $user_id = $_POST['user_id'];
        $query_user = mysqli_query($conn, "SELECT * FROM user WHERE user_id = $user_id") or die(mysqli_error());
        $data_user = mysqli_fetch_assoc($query_user);
        $name = $data_user['fname'].' '.$data_user['lname'];

        $filter_report = $_POST['filter_report'];
        $filter_from = $_POST['filter_from'];
        $filter_to = $_POST['filter_to'];

        $filter_created = '';
        $filter_assigned = '';
        $filter_unassigned = '';
        $filter_add = '';
        $filter_cf = '';
        $filter_due = '';
        $filter_move = '';
        $filter_wc = '';
        $filter_es = '';
        $filter_ass_due = '';
        if($filter_report == "all")
        {
            $filter_created = '';
            $filter_assigned = '';
            $filter_unassigned = '';
            $filter_add = '';
            $filter_cf = '';
            $filter_due = '';
            $filter_move = '';
            $filter_wc = '';
            $filter_es = '';
            $filter_ass_due = '';
        }
        else if($filter_report == "today")
        {
            $today = date("Y-m-d");
            $filter_created = "AND contact_date_created LIKE '%".$today."%'";
            $filter_assigned = "AND task_date_created LIKE '%".$today."%'";
            $filter_unassigned = "AND task_date_created LIKE '%".$today."%'";
            $filter_add = "AND task.task_date_created LIKE '%".$today."%'";
            $filter_cf = "AND comment_date LIKE '%".$today."%'";
            $filter_due = "AND comment_date LIKE '%".$today."%'";
            $filter_move = "AND comment_date LIKE '%".$today."%'";
            $filter_wc = "AND comment_date LIKE '%".$today."%'";
            $filter_es = "AND comment_date LIKE '%".$today."%'";
            $filter_ass_due = "LIKE '%".$today."%'";
        }
        else if($filter_report == "yesterday")
        {
            $yesterday = date('Y-m-d', strtotime(' -1 day')); // Get tomorrow date
            $filter_created = "AND contact_date_created LIKE '%".$yesterday."%'";
            $filter_assigned = "AND task_date_created LIKE '%".$yesterday."%'";
            $filter_unassigned = "AND task_date_created LIKE '%".$yesterday."%'";
            $filter_add = "AND task.task_date_created LIKE '%".$yesterday."%'";
            $filter_cf = "AND comment_date LIKE '%".$yesterday."%'";
            $filter_due = "AND comment_date LIKE '%".$yesterday."%'";
            $filter_move = "AND comment_date LIKE '%".$yesterday."%'";
            $filter_wc = "AND comment_date LIKE '%".$yesterday."%'";
            $filter_es = "AND comment_date LIKE '%".$yesterday."%'";
            $filter_ass_due = "LIKE '%".$yesterday."%'";
        }
        else if($filter_report == "this_week")
        {
            $dt = new DateTime();
            $dates = [];
            for ($d = 1; $d <= 7; $d++) {
                $dt->setISODate($dt->format('o'), $dt->format('W'), $d);
                $weekdate = ($dates[$dt->format('D')] = $dt->format('Y-m-d'));
            }
            $from = current($dates); // monday
            $to = end($dates); // sunday

            $filter_created = "AND contact_date_created BETWEEN '".$from."' AND '".$to."'";
            $filter_assigned = "AND task_date_created BETWEEN '".$from."' AND '".$to."'";
            $filter_unassigned = "AND task_date_created BETWEEN '".$from."' AND '".$to."'";
            $filter_add = "AND task.task_date_created BETWEEN '".$from."' AND '".$to."'";
            $filter_cf = "AND comment_date BETWEEN '".$from."' AND '".$to."'";
            $filter_due = "AND comment_date BETWEEN '".$from."' AND '".$to."'";
            $filter_move = "AND comment_date BETWEEN '".$from."' AND '".$to."'";
            $filter_wc = "AND comment_date BETWEEN '".$from."' AND '".$to."'";
            $filter_es = "AND comment_date BETWEEN '".$from."' AND '".$to."'";
            $filter_ass_due = "BETWEEN '".$from."' AND '".$to."'";
        }
        else if($filter_report == "month")
        {
            $month = date("Y-m");
            $filter_created = "AND contact_date_created LIKE '%".$month."%'";
            $filter_assigned = "AND task_date_created LIKE '%".$month."%'";
            $filter_unassigned = "AND task_date_created LIKE '%".$month."%'";
            $filter_add = "AND task.task_date_created LIKE '%".$month."%'";
            $filter_cf = "AND comment_date LIKE '%".$month."%'";
            $filter_due = "AND comment_date LIKE '%".$month."%'";
            $filter_move = "AND comment_date LIKE '%".$month."%'";
            $filter_wc = "AND comment_date LIKE '%".$month."%'";
            $filter_es = "AND comment_date LIKE '%".$month."%'";
            $filter_ass_due = "LIKE '%".$month."%'";
        }
        else if($filter_report == "year")
        {
            $year = date("Y");
            $filter_created = "AND contact_date_created LIKE '%".$year."%'";
            $filter_assigned = "AND task_date_created LIKE '%".$year."%'";
            $filter_unassigned = "AND task_date_created LIKE '%".$year."%'";
            $filter_add = "AND task.task_date_created LIKE '%".$year."%'";
            $filter_cf = "AND comment_date LIKE '%".$year."%'";
            $filter_due = "AND comment_date LIKE '%".$year."%'";
            $filter_move = "AND comment_date LIKE '%".$year."%'";
            $filter_wc = "AND comment_date LIKE '%".$year."%'";
            $filter_es = "AND comment_date LIKE '%".$year."%'";
            $filter_ass_due = "LIKE '%".$year."%'";
        }
        else if($filter_report == "custom")
        {
            $filter_created = "AND contact_date_created BETWEEN '".$filter_from." 00:00:00' AND '".$filter_to." 23:59:59'";
            $filter_assigned = "AND task_date_created BETWEEN '".$filter_from." 00:00:00' AND '".$filter_to." 23:59:59'";
            $filter_unassigned = "AND task_date_created BETWEEN '".$filter_from." 00:00:00' AND '".$filter_to." 23:59:59'";
            $filter_add = "AND task.task_date_created BETWEEN '".$filter_from." 00:00:00' AND '".$filter_to." 23:59:59'";
            $filter_cf = "AND comment_date BETWEEN '".$filter_from." 00:00:00' AND '".$filter_to." 23:59:59'";
            $filter_due = "AND comment_date BETWEEN '".$filter_from." 00:00:00' AND '".$filter_to." 23:59:59'";
            $filter_move = "AND comment_date BETWEEN '".$filter_from." 00:00:00' AND '".$filter_to." 23:59:59'";
            $filter_wc = "AND comment_date BETWEEN '".$filter_from." 00:00:00' AND '".$filter_to." 23:59:59'";
            $filter_es = "AND comment_date BETWEEN '".$filter_from." 00:00:00' AND '".$filter_to." 23:59:59'";
            $filter_ass_due = "BETWEEN '".$filter_from." 00:00:00' AND '".$filter_to." 23:59:59'";
        }

        $query_created_count = mysqli_query($conn, "SELECT Count(contact.contact_id) as total_created FROM contact WHERE contact_created_by = $user_id $filter_created") or die(mysqli_error());
        $data_created_count = mysqli_fetch_assoc($query_created_count);
        $created_count = $data_created_count['total_created'];

        $query_assigned_count = mysqli_query($conn, "SELECT Count(task.task_id) as total_assigned FROM task WHERE task_created_by = $user_id $filter_assigned") or die(mysqli_error());
        $data_assigned_count = mysqli_fetch_assoc($query_assigned_count);
        $assigned_count = $data_assigned_count['total_assigned'];

        $query_unassigned_count = mysqli_query($conn, "SELECT Count(task.task_id) as total_unassigned FROM task WHERE task_created_by = $user_id AND task_status_id = '' $filter_unassigned") or die(mysqli_error());
        $data_unassigned_count = mysqli_fetch_assoc($query_unassigned_count);
        $unassigned_count = $data_unassigned_count['total_unassigned'];

        $query_add_count = mysqli_query($conn, "SELECT Count(contact.contact_id) AS total_add FROM contact INNER JOIN task ON task.task_contact = contact.contact_id WHERE contact.contact_created_by = $user_id $filter_add") or die(mysqli_error());
        $data_add_count = mysqli_fetch_assoc($query_add_count);
        $add_count = $data_add_count['total_add'];

        $query_cf_count = mysqli_query($conn, "SELECT Count(comment.comment_id) AS total_cf FROM comment INNER JOIN task ON comment.comment_task_id = task.task_id WHERE comment_user_id = $user_id AND comment_type = 1 $filter_cf") or die(mysqli_error());
        $data_cf_count = mysqli_fetch_assoc($query_cf_count);
        $cf_count = $data_cf_count['total_cf'];

        $query_due_count = mysqli_query($conn, "SELECT Count(comment.comment_id) AS total_due FROM comment INNER JOIN task ON comment.comment_task_id = task.task_id WHERE comment_user_id = $user_id AND comment_type = 2 $filter_due") or die(mysqli_error());
        $data_due_count = mysqli_fetch_assoc($query_due_count);
        $due_count = $data_due_count['total_due'];

        $query_move_count = mysqli_query($conn, "SELECT Count(comment.comment_id) AS total_move FROM comment INNER JOIN task ON comment.comment_task_id = task.task_id WHERE comment_user_id = $user_id AND comment_type = 3 $filter_move") or die(mysqli_error());
        $data_move_count = mysqli_fetch_assoc($query_move_count);
        $move_count = $data_move_count['total_move'];

        $query_wc_count = mysqli_query($conn, "SELECT Count(comment.comment_id) AS total_wc FROM comment INNER JOIN task ON comment.comment_task_id = task.task_id WHERE comment_user_id = $user_id AND comment_type is NULL $filter_wc") or die(mysqli_error());
        $data_wc_count = mysqli_fetch_assoc($query_wc_count);
        $wc_count = $data_wc_count['total_wc'];

        $query_es_count = mysqli_query($conn, "SELECT Count(comment.comment_id) AS total_es FROM comment INNER JOIN task ON comment.comment_task_id = task.task_id WHERE comment_user_id = $user_id AND comment_type = 4 $filter_wc") or die(mysqli_error());
        $data_es_count = mysqli_fetch_assoc($query_es_count);
        $es_count = $data_es_count['total_es'];

        $total_ad = 1;
        $ad_count = 0;
        $find_task = mysqli_query($conn, "SELECT * FROM task WHERE task_date_created $filter_ass_due AND task_assign_to LIKE '%$user_id%' AND task_due_date != '0000-00-00' AND task_due_date IS NOT NULL");
        while($fetct_task_assign = mysqli_fetch_array($find_task)){
          $str_to_array = explode(",",$fetct_task_assign['task_assign_to']);
          if(in_array($user_id,$str_to_array))
          {
            $ad_count = $total_ad++;
          }
        }
        echo '
        <div class="col-lg-12">
          <h3>List Activities of '.$name.'</h3>
          <!-- Block Tabs Animated Slide Up -->
          <div class="block">
              <ul class="nav nav-tabs nav-tabs-block" data-toggle="tabs" role="tablist">
                  <li class="nav-item">
                      <a class="nav-link active" href="#created">Created<span class="badge badge-danger badge-pill font-w300" style="font-size: 9px;" >'.$created_count.'</span></a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="#assigned">Assigned<span class="badge badge-danger badge-pill font-w300" style="font-size: 9px;" >'.$assigned_count.'</span></a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="#unassigned">Unassigned<span class="badge badge-danger badge-pill font-w300" style="font-size: 9px;" >'.$unassigned_count.'</span></a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="#add">Add<span class="badge badge-danger badge-pill font-w300" style="font-size: 9px;" >'.$add_count.'</span></a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="#customfield">Custom Field<span class="badge badge-danger badge-pill font-w300" style="font-size: 9px;" >'.$cf_count.'</span></a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="#duedate">Due Date<span class="badge badge-danger badge-pill font-w300" style="font-size: 9px;" >'.$due_count.'</span></a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="#assigneddue">Assigned Due Date<span class="badge badge-danger badge-pill font-w300" style="font-size: 9px;" >'.$ad_count.'</span></a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="#movement">Movement<span class="badge badge-danger badge-pill font-w300" style="font-size: 9px;" >'.$move_count.'</span></a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="#writtencomments">Written Comments<span class="badge badge-danger badge-pill font-w300" style="font-size: 9px;" >'.$wc_count.'</span></a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="#emailsent">Email Sent<span class="badge badge-danger badge-pill font-w300" style="font-size: 9px;" >'.$es_count.'</span></a>
                  </li>
              </ul>
              <div class="block-content tab-content overflow-hidden">
                  <div class="tab-pane fade fade-up show active" id="created" role="tabpanel">
                    <div style="overflow: auto; height: 300px;" id="scroll_created">
                      <table class="table table-bordered table-hover">
                      <thead>
                        <tr>
                          <td>#</td>
                          <td>Contact Name</td>
                          <td>Date Created</td>
                        <tr>
                      </thead>
                      <tbody id="load_data_created">
                      <tbody>
                      </table>
                    </div>
                  </div>
                  <div class="tab-pane fade fade-up" id="assigned" role="tabpanel">
                    <div style="overflow: auto; height: 300px;" id="scroll_assigned">
                      <table class="table table-bordered table-hover">
                      <thead>
                        <tr>
                          <td>#</td>
                          <td>Task Name</td>
                          <td>Date Created</td>
                        <tr>
                      </thead>
                      <tbody id="load_data_assigned">
                      <tbody>
                      </table>
                    </div>
                  </div>
                  <div class="tab-pane fade fade-up" id="unassigned" role="tabpanel">
                    <div style="overflow: auto; height: 300px;" id="scroll_unassigned">
                      <table class="table table-bordered table-hover">
                      <thead>
                        <tr>
                          <td>#</td>
                          <td>Task Name</td>
                          <td>Date Created</td>
                        <tr>
                      </thead>
                      <tbody id="load_data_unassigned">
                      <tbody>
                      </table>
                    </div>
                  </div>
                  <div class="tab-pane fade fade-up" id="add" role="tabpanel">
                    <div style="overflow: auto; height: 300px;" id="scroll_add">
                      <table class="table table-bordered table-hover">
                      <thead>
                        <tr>
                          <td>#</td>
                          <td>Task Name</td>
                          <td>Date Created</td>
                        <tr>
                      </thead>
                      <tbody id="load_data_add">
                      <tbody>
                      </table>
                    </div>
                  </div>
                  <div class="tab-pane fade fade-up" id="customfield" role="tabpanel">
                    <div style="overflow: auto; height: 300px;" id="scroll_cf">
                      <table class="table table-bordered table-hover">
                      <thead>
                        <tr>
                          <td>#</td>
                          <td>Task Name</td>
                          <td>Comment</td>
                          <td>Date Created</td>
                        <tr>
                      </thead>
                      <tbody id="load_data_cf">
                      <tbody>
                      </table>
                    </div>
                  </div>
                  <div class="tab-pane fade fade-up" id="duedate" role="tabpanel">
                    <div style="overflow: auto; height: 300px;" id="scroll_due">
                      <table class="table table-bordered table-hover">
                      <thead>
                        <tr>
                          <td>#</td>
                          <td>Task Name</td>
                          <td>Comment</td>
                          <td>Date Created</td>
                        <tr>
                      </thead>
                      <tbody id="load_data_due">
                      <tbody>
                      </table>
                    </div>
                  </div>
                  <div class="tab-pane fade fade-up" id="assigneddue" role="tabpanel">
                    <div style="overflow: auto; height: 300px;" id="scroll_assigneddue">
                      <table class="table table-bordered table-hover">
                      <thead>
                        <tr>
                          <td>Task #</td>
                          <td>Task Name</td>
                          <td class="text-center">Due Date</td>
                          <td>Date Created</td>
                        <tr>
                      </thead>
                      <tbody id="load_data_assigneddue">
                      <tbody>
                      </table>
                    </div>
                  </div>
                  <div class="tab-pane fade fade-up" id="movement" role="tabpanel">
                    <div style="overflow: auto; height: 300px;" id="scroll_move">
                      <table class="table table-bordered table-hover">
                      <thead>
                        <tr>
                          <td>#</td>
                          <td>Task Name</td>
                          <td>Comment</td>
                          <td>Date Created</td>
                        <tr>
                      </thead>
                      <tbody id="load_data_move">
                      <tbody>
                      </table>
                    </div>
                  </div>
                  <div class="tab-pane fade fade-up" id="writtencomments" role="tabpanel">
                    <div style="overflow: auto; height: 300px;" id="scroll_wc">
                      <table class="table table-bordered table-hover">
                      <thead>
                        <tr>
                          <td>#</td>
                          <td>Task Name</td>
                          <td>Comment</td>
                          <td>Date Created</td>
                        <tr>
                      </thead>
                      <tbody id="load_data_wc">
                      <tbody>
                      </table>
                    </div>
                  </div>
                  <div class="tab-pane fade fade-up" id="emailsent" role="tabpanel">
                    <div style="overflow: auto; height: 300px;" id="scroll_es">
                      <table class="table table-bordered table-hover">
                      <thead>
                        <tr>
                          <td>#</td>
                          <td>Task Name</td>
                          <td>Comment</td>
                          <td>Date Created</td>
                        <tr>
                      </thead>
                      <tbody id="load_data_es">
                      <tbody>
                      </table>
                    </div>
                  </div>
              </div>
          </div>
      </div>
      <div class="col-lg-12">
        <canvas id="chartdiv"></canvas>
      </div>


      <script>

      var xValues = ["Created", "Assigned", "Unassigned", "Add", "Custom Field", "Due Date", "Assigned Due Date", "Movement", "Written Comments", "Email Sent"];
      var yValues = ['.$created_count.', '.$assigned_count.', '.$unassigned_count.', '.$add_count.', '.$cf_count.', '.$due_count.', '.$ad_count.', '.$move_count.', '.$wc_count.', '.$es_count.'];
      var barColors = ["red","orange","yellow","green","blue","purple","brown ","black","gray","lightblue"];

      new Chart("chartdiv", {
        type: "bar",
        data: {
          labels: xValues,
          datasets: [{
            backgroundColor: barColors,
            data: yValues
          }]
        },
        options: {
          legend: {display: false},
          title: {
            display: true,
            text: "Number of Activities"
          }
        }
      });

        var limit_created = 20;
        var start_created = 0;
        var user_id_created = '.$user_id.';
        var action_created = "inactive";
        function load_created_data(limit_created, start_created, user_id_created){
        filter_report_created = "'.$filter_report.'";
        filter_from_created = "'.$filter_from.'";
        filter_to_created = "'.$filter_to.'";
        $.ajax({
            url:"ajax.php",
            method:"POST",
            data:{
              limit_created:limit_created,
              start_created:start_created,
              user_id_created:user_id_created,
              filter_report_created:filter_report_created,
              filter_from_created:filter_from_created,
              filter_to_created:filter_to_created,
              load_created_data:1},
            cache:false,
            success:function(data)
            {
            $("#load_data_created").append(data);
            if(data == "")
            {
              var start_created = 0;
             action_created = "active";
            }
            else
            {
             action_created = "inactive";
            }
          }
        });
        }

        if(action_created == "inactive")
          {
          action_created = "active";
          load_created_data(limit_created, start_created, user_id_created);
          }
        $("#scroll_created").scroll(function() {
    			if ($("#scroll_created").scrollTop() + $("#scroll_created").height() > $("#scroll_created").height() && action_created == "inactive") {
            action_created = "active";
            start_created = start_created + limit_created;
            setTimeout(function(){
            load_created_data(limit_created, start_created, user_id_created);
            }, 1000);
          }
    		});

        var limit_assigned = 20;
        var start_assigned = 0;
        var user_id_assigned = '.$user_id.';
        var action_assigned= "inactive";
        function load_assigned_data(limit_assigned, start_assgined, user_id_assigned){
        filter_report_assigned = "'.$filter_report.'";
        filter_from_assigned = "'.$filter_from.'";
        filter_to_assigned = "'.$filter_to.'";
        $.ajax({
            url:"ajax.php",
            method:"POST",
            data:{
              limit_assigned:limit_assigned,
              start_assgined:start_assgined,
              user_id_assigned:user_id_assigned,
              filter_report_assigned:filter_report_assigned,
              filter_from_assigned:filter_from_assigned,
              filter_to_assigned:filter_to_assigned,
              load_assigned_data:1},
            cache:false,
            success:function(data)
            {
            $("#load_data_assigned").append(data);
            if(data == "")
            {
              var start_assigned = 0;
             action_assigned = "active";
            }
            else
            {
             action_assigned = "inactive";
            }
          }
        });
        }

        if(action_assigned == "inactive")
          {
          action_assigned = "active";
          load_assigned_data(limit_assigned, start_assigned, user_id_assigned);
          }
        $("#scroll_assigned").scroll(function() {
    			if ($("#scroll_assigned").scrollTop() + $("#scroll_assigned").height() > $("#scroll_assigned").height() && action_assigned == "inactive") {
            action_assigned = "active";
            start_assigned = start_assigned + limit_assigned;
            setTimeout(function(){
            load_assigned_data(limit_assigned, start_assigned, user_id_assigned);
            }, 1000);
          }
    		});

        var limit_unassigned = 20;
        var start_unassigned = 0;
        var user_id_unassigned = '.$user_id.';
        var action_unassigned= "inactive";
        function load_unassigned_data(limit_unassigned, start_unassgined, user_id_unassigned){
        filter_report_unassigned = "'.$filter_report.'";
        filter_from_unassigned = "'.$filter_from.'";
        filter_to_unassigned = "'.$filter_to.'";
        $.ajax({
            url:"ajax.php",
            method:"POST",
            data:{
              limit_unassigned:limit_unassigned,
              start_unassgined:start_unassgined,
              user_id_unassigned:user_id_unassigned,
              filter_report_unassigned:filter_report_unassigned,
              filter_from_unassigned:filter_from_unassigned,
              filter_to_unassigned:filter_to_unassigned,
              load_unassigned_data:1},
            cache:false,
            success:function(data)
            {
            $("#load_data_unassigned").append(data);
            if(data == "")
            {
              var start_unassigned = 0;
             action_unassigned = "active";
            }
            else
            {
             action_unassigned = "inactive";
            }
          }
        });
        }

        if(action_unassigned == "inactive")
          {
          action_unassigned = "active";
          load_unassigned_data(limit_unassigned, start_unassigned, user_id_unassigned);
          }
        $("#scroll_unassigned").scroll(function() {
    			if ($("#scroll_unassigned").scrollTop() + $("#scroll_unassigned").height() > $("#scroll_unassigned").height() && action_unassigned == "inactive") {
            action_unassigned = "active";
            start_unassigned = start_unassigned + limit_unassigned;
            setTimeout(function(){
            load_unassigned_data(limit_unassigned, start_unassigned, user_id_unassigned);
            }, 1000);
          }
    		});

        var limit_add = 20;
        var start_add = 0;
        var user_id_add = '.$user_id.';
        var action_add= "inactive";
        function load_add_data(limit_add, start_add, user_id_add){
        filter_report_add = "'.$filter_report.'";
        filter_from_add = "'.$filter_from.'";
        filter_to_add = "'.$filter_to.'";
        $.ajax({
            url:"ajax.php",
            method:"POST",
            data:{
              limit_add:limit_add,
              start_add:start_add,
              user_id_add:user_id_add,
              filter_report_add:filter_report_add,
              filter_from_add:filter_from_add,
              filter_to_add:filter_to_add,
              load_add_data:1},
            cache:false,
            success:function(data)
            {
            $("#load_data_add").append(data);
            if(data == "")
            {
              var start_add = 0;
             action_add = "active";
            }
            else
            {
             action_add = "inactive";
            }
          }
        });
        }

        if(action_add == "inactive")
          {
          action_add = "active";
          load_add_data(limit_add, start_add, user_id_add);
          }
        $("#scroll_add").scroll(function() {
    			if ($("#scroll_add").scrollTop() + $("#scroll_add").height() > $("#scroll_add").height() && action_add == "inactive") {
            action_add = "active";
            start_add = start_add + limit_add;
            setTimeout(function(){
            load_add_data(limit_add, start_add, user_id_add);
            }, 1000);
          }
    		});

        var limit_cf = 20;
        var start_cf = 0;
        var user_id_cf = '.$user_id.';
        var action_cf = "inactive";
        function load_cf_data(limit_cf, start_cf, user_id_cf){
        filter_report_cf = "'.$filter_report.'";
        filter_from_cf = "'.$filter_from.'";
        filter_to_cf = "'.$filter_to.'";
        $.ajax({
            url:"ajax.php",
            method:"POST",
            data:{
              limit:limit_cf,
              start:start_cf,
              user_id:user_id_cf,
              filter_report:filter_report_cf,
              filter_from:filter_from_cf,
              filter_to:filter_to_cf,
              load_cf_data:1},
            cache:false,
            success:function(data)
            {
            $("#load_data_cf").append(data);
            if(data == "")
            {
              var start_cf = 0;
             action_cf = "active";
            }
            else
            {
             action_cf = "inactive";
            }
          }
        });
        }

        if(action_cf == "inactive")
          {
          action_cf = "active";
          load_cf_data(limit_cf, start_cf, user_id_cf);
          }
        $("#scroll_cf").scroll(function() {
    			if ($("#scroll_cf").scrollTop() + $("#scroll_cf").height() > $("#scroll_cf").height() && action_cf == "inactive") {
            action_cf = "active";
            start_cf = start_cf + limit_cf;
            setTimeout(function(){
            load_cf_data(limit_cf, start_cf, user_id_cf);
            }, 1000);
          }
    		});

        var limit_due = 20;
        var start_due = 0;
        var user_id_due = '.$user_id.';
        var action_due = "inactive";
        function load_due_data(limit_due, start_due, user_id_due){
        filter_report_due = "'.$filter_report.'";
        filter_from_due = "'.$filter_from.'";
        filter_to_due = "'.$filter_to.'";
        $.ajax({
            url:"ajax.php",
            method:"POST",
            data:{
              limit:limit_due,
              start:start_due,
              user_id:user_id_due,
              filter_report:filter_report_due,
              filter_from:filter_from_due,
              filter_to:filter_to_due,
              load_due_data:1},
            cache:false,
            success:function(data)
            {
            $("#load_data_due").append(data);
            if(data == "")
            {
              var start_due = 0;
             action_due = "active";
            }
            else
            {
             action_due = "inactive";
            }
          }
        });
        }

        if(action_due == "inactive")
          {
          action_due = "active";
          load_due_data(limit_due, start_due, user_id_due);
          }
        $("#scroll_due").scroll(function() {
          if ($("#scroll_due").scrollTop() + $("#scroll_due").height() > $("#scroll_due").height() && action_due == "inactive") {
            action_due = "active";
            start_due = start_due + limit_due;
            setTimeout(function(){
            load_due_data(limit_due, start_due, user_id_due);
            }, 1000);
          }
        });

        var limit_move = 20;
        var start_move = 0;
        var user_id_move = '.$user_id.';
        var action_move = "inactive";
        function load_move_data(limit_move, start_move, user_id_move){
        filter_report_move = "'.$filter_report.'";
        filter_from_move = "'.$filter_from.'";
        filter_to_move = "'.$filter_to.'";
        $.ajax({
            url:"ajax.php",
            method:"POST",
            data:{
              limit:limit_move,
              start:start_move,
              user_id:user_id_move,
              filter_report:filter_report_move,
              filter_from:filter_from_move,
              filter_to:filter_to_move,
              load_move_data:1},
            cache:false,
            success:function(data)
            {
            $("#load_data_move").append(data);
            if(data == "")
            {
              var start_move = 0;
             action_move = "active";
            }
            else
            {
             action_move = "inactive";
            }
          }
        });
        }

        if(action_move == "inactive")
          {
          action_move = "active";
          load_move_data(limit_move, start_move, user_id_move);
          }
        $("#scroll_move").scroll(function() {
          if ($("#scroll_move").scrollTop() + $("#scroll_move").height() > $("#scroll_move").height() && action_move == "inactive") {
            action_move = "active";
            start_move = start_move + limit_move;
            setTimeout(function(){
            load_move_data(limit_move, start_move, user_id_move);
            }, 1000);
          }
        });

        var limit_wc = 20;
        var start_wc = 0;
        var user_id_wc = '.$user_id.';
        var action_wc = "inactive";
        function load_wc_data(limit_wc, start_wc, user_id_wc){
        filter_report_wc = "'.$filter_report.'";
        filter_from_wc = "'.$filter_from.'";
        filter_to_wc = "'.$filter_to.'";
        $.ajax({
            url:"ajax.php",
            method:"POST",
            data:{
              limit:limit_wc,
              start:start_wc,
              user_id:user_id_wc,
              filter_report:filter_report_wc,
              filter_from:filter_from_wc,
              filter_to:filter_to_wc,
              load_wc_data:1},
            cache:false,
            success:function(data)
            {
            $("#load_data_wc").append(data);
            if(data == "")
            {
              var start_wc = 0;
             action_wc = "active";
            }
            else
            {
             action_wc = "inactive";
            }
          }
        });
        }

        if(action_wc == "inactive")
          {
          action_wc = "active";
          load_wc_data(limit_wc, start_wc, user_id_wc);
          }
        $("#scroll_wc").scroll(function() {
          if ($("#scroll_wc").scrollTop() + $("#scroll_wc").height() > $("#scroll_wc").height() && action_wc == "inactive") {
            action_wc = "active";
            start_wc = start_wc + limit_wc;
            setTimeout(function(){
            load_wc_data(limit_wc, start_wc, user_id_wc);
            }, 1000);
          }
        });

        var limit_es = 20;
        var start_es = 0;
        var user_id_es = '.$user_id.';
        var action_es = "inactive";
        function load_es_data(limit_es, start_es, user_id_es){
        filter_report_es = "'.$filter_report.'";
        filter_from_es = "'.$filter_from.'";
        filter_to_es = "'.$filter_to.'";
        $.ajax({
            url:"ajax.php",
            method:"POST",
            data:{
              limit:limit_es,
              start:start_es,
              user_id:user_id_es,
              filter_report:filter_report_es,
              filter_from:filter_from_es,
              filter_to:filter_to_es,
              load_es_data:1},
            cache:false,
            success:function(data)
            {
            $("#load_data_es").append(data);
            if(data == "")
            {
              var start_es = 0;
             action_es = "active";
            }
            else
            {
             action_es = "inactive";
            }
          }
        });
        }

        if(action_es == "inactive")
          {
          action_es = "active";
          load_es_data(limit_es, start_es, user_id_es);
          }
        $("#scroll_es").scroll(function() {
          if ($("#scroll_es").scrollTop() + $("#scroll_es").height() > $("#scroll_es").height() && action_es == "inactive") {
            action_es = "active";
            start_es = start_es + limit_es;
            setTimeout(function(){
            load_es_data(limit_es, start_es, user_id_es);
            }, 1000);
          }
        });

        var limit_ad = 10000;
        var start_ad = 0;
        var user_id_ad = '.$user_id.';
        var action_ad = "inactive";
        function load_ad_data(limit_ad, start_ad, user_id_ad){
        filter_report_ad = "'.$filter_report.'";
        filter_from_ad = "'.$filter_from.'";
        filter_to_ad = "'.$filter_to.'";
        $.ajax({
            url:"ajax.php",
            method:"POST",
            data:{
              limit:limit_ad,
              start:start_ad,
              user_id:user_id_ad,
              filter_report:filter_report_ad,
              filter_from:filter_from_ad,
              filter_to:filter_to_ad,
              load_ad_data:1},
            cache:false,
            success:function(data)
            {
            $("#load_data_assigneddue").append(data);
            if(data == "")
            {
              var start_ad = 0;
             action_ad = "active";
            }
            else
            {
             action_ad = "inactive";
            }
          }
        });
        }

        if(action_ad == "inactive")
          {
          action_ad = "active";
          load_ad_data(limit_ad, start_ad, user_id_ad);
          }
        $("#scroll_assigneddue").scroll(function() {
          if ($("#scroll_assigneddue").scrollTop() + $("#scroll_assigneddue").height() > $("#scroll_assigneddue").height() && action_ad == "inactive") {
            action_ad = "active";
            start_ad = start_ad + limit_ad;
            setTimeout(function(){
            load_ad_data(limit_ad, start_ad, user_id_ad);
            }, 1000);
          }
        });


      </script>
      <script src="../assets/js/codebase.core.min.js"></script>
      <script src="../assets/js/codebase.app.min.js"></script>
        ';
    }

    if(isset($_POST['load_created_data']))
    {
        $limit_created = $_POST['limit_created'];
        $start_created = $_POST['start_created'];
        $user_id = $_POST['user_id_created'];

        $filter_report = $_POST['filter_report_created'];
        $filter_from = $_POST['filter_from_created'];
        $filter_to = $_POST['filter_to_created'];

        $filter = '';
        if($filter_report == "all")
        {
            $filter = '';
        }
        else if($filter_report == "today")
        {
            $today = date("Y-m-d");
            $filter = "AND contact_date_created LIKE '%".$today."%'";
        }
        else if($filter_report == "yesterday")
        {
            $yesterday = date('Y-m-d', strtotime(' -1 day'));
            $filter = "AND contact_date_created LIKE '%".$yesterday."%'";
        }
        else if($filter_report == "this_week")
        {
            $dt = new DateTime();
            $dates = [];
            for ($d = 1; $d <= 7; $d++) {
                $dt->setISODate($dt->format('o'), $dt->format('W'), $d);
                $weekdate = ($dates[$dt->format('D')] = $dt->format('Y-m-d'));
            }
            $from = current($dates); // monday
            $to = end($dates); // sunday

            $filter = "AND contact_date_created BETWEEN '".$from."' AND '".$to."'";
        }
        else if($filter_report == "month")
        {
            $month = date("Y-m");
            $filter = "AND contact_date_created LIKE '%".$month."%'";
        }
        else if($filter_report == "year")
        {
            $year = date("Y");
            $due_date_filter = "AND contact_date_created LIKE '%".$year."%'";
        }
        else if($filter_report == "custom")
        {
            $filter = "AND contact_date_created BETWEEN '".$filter_from." 00:00:00' AND '".$filter_to." 23:59:59'";
        }

        $count = 1 + $start_created;
        $query_created = mysqli_query($conn, "SELECT * FROM contact WHERE contact_created_by = $user_id $filter ORDER BY contact_date_created DESC LIMIT $start_created, $limit_created") or die(mysqli_error());
        while($data_created = mysqli_fetch_array($query_created))
        {
          echo '
            <tr>
              <td>'.$count++.'</td>
              <td>'.$data_created['contact_fname'].' '.$data_created['contact_lname'].'</td>
              <td>'.$data_created['contact_date_created'].'</td>
            </tr>
          ';
        }
    }

    if(isset($_POST['load_assigned_data']))
    {
        $limit_assigned = $_POST['limit_assigned'];
        $start_assgined = $_POST['start_assgined'];
        $user_id = $_POST['user_id_assigned'];

        $filter_report = $_POST['filter_report_assigned'];
        $filter_from = $_POST['filter_from_assigned'];
        $filter_to = $_POST['filter_to_assigned'];

        $filter = '';
        if($filter_report == "all")
        {
            $filter = '';
        }
        else if($filter_report == "today")
        {
            $today = date("Y-m-d");
            $filter = "AND task_date_created LIKE '%".$today."%'";
        }
        else if($filter_report == "yesterday")
        {
            $yesterday = date('Y-m-d', strtotime(' -1 day'));
            $filter = "AND task_date_created LIKE '%".$yesterday."%'";
        }
        else if($filter_report == "this_week")
        {
            $dt = new DateTime();
            $dates = [];
            for ($d = 1; $d <= 7; $d++) {
                $dt->setISODate($dt->format('o'), $dt->format('W'), $d);
                $weekdate = ($dates[$dt->format('D')] = $dt->format('Y-m-d'));
            }
            $from = current($dates); // monday
            $to = end($dates); // sunday

            $filter = "AND task_date_created BETWEEN '".$from."' AND '".$to."'";
        }
        else if($filter_report == "month")
        {
            $month = date("Y-m");
            $filter = "AND task_date_created LIKE '%".$month."%'";
        }
        else if($filter_report == "year")
        {
            $year = date("Y");
            $due_date_filter = "AND task_date_created LIKE '%".$year."%'";
        }
        else if($filter_report == "custom")
        {
            $filter = "AND task_date_created BETWEEN '".$filter_from." 00:00:00' AND '".$filter_to." 23:59:59'";
        }

        $count = 1 + $start_assgined;
        $query_assigned = mysqli_query($conn, "SELECT * FROM task WHERE task_created_by = $user_id AND task_status_id != '' $filter ORDER BY task_date_created DESC LIMIT $start_assgined, $limit_assigned") or die(mysqli_error());
        while($data_assigned = mysqli_fetch_array($query_assigned))
        {
          echo '
            <tr>
              <td>'.$count++.'</td>
              <td>'.$data_assigned['task_name'].'</td>
              <td>'.$data_assigned['task_date_created'].'</td>
            </tr>
          ';
        }
    }

    if(isset($_POST['load_unassigned_data']))
    {
        $limit_unassigned = $_POST['limit_unassigned'];
        $start_unassgined = $_POST['start_unassgined'];
        $user_id = $_POST['user_id_unassigned'];

        $filter_report = $_POST['filter_report_unassigned'];
        $filter_from = $_POST['filter_from_unassigned'];
        $filter_to = $_POST['filter_to_unassigned'];

        $filter = '';
        if($filter_report == "all")
        {
            $filter = '';
        }
        else if($filter_report == "today")
        {
            $today = date("Y-m-d");
            $filter = "AND task_date_created LIKE '%".$today."%'";
        }
        else if($filter_report == "yesterday")
        {
            $yesterday = date('Y-m-d', strtotime(' -1 day'));
            $filter = "AND task_date_created LIKE '%".$yesterday."%'";
        }
        else if($filter_report == "this_week")
        {
            $dt = new DateTime();
            $dates = [];
            for ($d = 1; $d <= 7; $d++) {
                $dt->setISODate($dt->format('o'), $dt->format('W'), $d);
                $weekdate = ($dates[$dt->format('D')] = $dt->format('Y-m-d'));
            }
            $from = current($dates); // monday
            $to = end($dates); // sunday

            $filter = "AND task_date_created BETWEEN '".$from."' AND '".$to."'";
        }
        else if($filter_report == "month")
        {
            $month = date("Y-m");
            $filter = "AND task_date_created LIKE '%".$month."%'";
        }
        else if($filter_report == "year")
        {
            $year = date("Y");
            $due_date_filter = "AND task_date_created LIKE '%".$year."%'";
        }
        else if($filter_report == "custom")
        {
            $filter = "AND task_date_created BETWEEN '".$filter_from." 00:00:00' AND '".$filter_to." 23:59:59'";
        }

        $count = 1 + $start_unassgined;
        $query_unassigned = mysqli_query($conn, "SELECT * FROM task WHERE task_created_by = $user_id AND task_status_id = '' $filter ORDER BY task_date_created DESC LIMIT $start_unassgined, $limit_unassigned") or die(mysqli_error());
        while($data_unassigned = mysqli_fetch_array($query_unassigned))
        {
          echo '
            <tr>
              <td>'.$count++.'</td>
              <td>'.$data_unassigned['task_name'].'</td>
              <td>'.$data_unassigned['task_date_created'].'</td>
            </tr>
          ';
        }
    }

    if(isset($_POST['load_add_data']))
    {
        $limit = $_POST['limit_add'];
        $start = $_POST['start_add'];
        $user_id = $_POST['user_id_add'];

        $filter_report = $_POST['filter_report_add'];
        $filter_from = $_POST['filter_from_add'];
        $filter_to = $_POST['filter_to_add'];

        $filter = '';
        if($filter_report == "all")
        {
            $filter = '';
        }
        else if($filter_report == "today")
        {
            $today = date("Y-m-d");
            $filter = "AND task_date_created LIKE '%".$today."%'";
        }
        else if($filter_report == "yesterday")
        {
            $yesterday = date('Y-m-d', strtotime(' -1 day'));
            $filter = "AND task_date_created LIKE '%".$yesterday."%'";
        }
        else if($filter_report == "this_week")
        {
            $dt = new DateTime();
            $dates = [];
            for ($d = 1; $d <= 7; $d++) {
                $dt->setISODate($dt->format('o'), $dt->format('W'), $d);
                $weekdate = ($dates[$dt->format('D')] = $dt->format('Y-m-d'));
            }
            $from = current($dates); // monday
            $to = end($dates); // sunday

            $filter = "AND task_date_created BETWEEN '".$from."' AND '".$to."'";
        }
        else if($filter_report == "month")
        {
            $month = date("Y-m");
            $filter = "AND task_date_created LIKE '%".$month."%'";
        }
        else if($filter_report == "year")
        {
            $year = date("Y");
            $due_date_filter = "AND task_date_created LIKE '%".$year."%'";
        }
        else if($filter_report == "custom")
        {
            $filter = "AND task_date_created BETWEEN '".$filter_from." 00:00:00' AND '".$filter_to." 23:59:59'";
        }

        $count = 1 + $start;
        $query_add = mysqli_query($conn, "SELECT * FROM contact INNER JOIN task ON task.task_contact = contact.contact_id WHERE contact.contact_created_by = $user_id $filter ORDER BY task_date_created DESC  LIMIT $start, $limit") or die(mysqli_error());
        while($data_add = mysqli_fetch_array($query_add))
        {
          echo '
            <tr>
              <td>'.$count++.'</td>
              <td>'.$data_add['task_name'].'</td>
              <td>'.$data_add['task_date_created'].'</td>
            </tr>
          ';
        }
    }

    if(isset($_POST['load_cf_data']))
    {
        $limit = $_POST['limit'];
        $start = $_POST['start'];
        $user_id = $_POST['user_id'];

        $filter_report = $_POST['filter_report'];
        $filter_from = $_POST['filter_from'];
        $filter_to = $_POST['filter_to'];

        $filter = '';
        if($filter_report == "all")
        {
            $filter = '';
        }
        else if($filter_report == "today")
        {
            $today = date("Y-m-d");
            $filter = "AND comment_date LIKE '%".$today."%'";
        }
        else if($filter_report == "yesterday")
        {
            $yesterday = date('Y-m-d', strtotime(' -1 day'));
            $filter = "AND comment_date LIKE '%".$yesterday."%'";
        }
        else if($filter_report == "this_week")
        {
            $dt = new DateTime();
            $dates = [];
            for ($d = 1; $d <= 7; $d++) {
                $dt->setISODate($dt->format('o'), $dt->format('W'), $d);
                $weekdate = ($dates[$dt->format('D')] = $dt->format('Y-m-d'));
            }
            $from = current($dates); // monday
            $to = end($dates); // sunday

            $filter = "AND comment_date BETWEEN '".$from."' AND '".$to."'";
        }
        else if($filter_report == "month")
        {
            $month = date("Y-m");
            $filter = "AND comment_date LIKE '%".$month."%'";
        }
        else if($filter_report == "year")
        {
            $year = date("Y");
            $due_date_filter = "AND comment_date LIKE '%".$year."%'";
        }
        else if($filter_report == "custom")
        {
            $filter = "AND comment_date BETWEEN '".$filter_from." 00:00:00' AND '".$filter_to." 23:59:59'";
        }

        $count = 1 + $start;
        $query = mysqli_query($conn, "SELECT task.task_id, task.task_name, comment.comment_message, comment.comment_date FROM comment INNER JOIN task ON comment.comment_task_id = task.task_id WHERE comment.comment_user_id = $user_id AND comment.comment_type = '1' $filter ORDER BY comment_date DESC LIMIT $start, $limit") or die(mysqli_error());
        while($data = mysqli_fetch_array($query))
        {
          $task_id = $data['task_id'];
          $query_lang = mysqli_query($conn, "SELECT list.list_name, task.task_id, space.space_name, task.task_list_id FROM task INNER JOIN list ON task.task_list_id = list.list_id INNER JOIN space ON list.list_space_id = space.space_id WHERE task.task_id = $task_id") or die(mysqli_error());
          $data_lang = mysqli_fetch_assoc($query_lang);
          $service_name = $data_lang['space_name'];
          $list_name = $data_lang['list_name'];
          $task_list_id = $data_lang['task_list_id'];
          echo '
            <tr style="cursor: pointer;" id="'.$service_name.','.$list_name.','.$task_list_id.','.$task_id.'" onclick="view_lang(this.id)">
              <td>'.$count++.'</td>
              <td>'.$data['task_name'].'</td>
              <td>'.$data['comment_message'].'</td>
              <td>'.$data['comment_date'].'</td>
            </tr>
          ';
        }
    }

    if(isset($_POST['load_due_data']))
    {
        $limit = $_POST['limit'];
        $start = $_POST['start'];
        $user_id = $_POST['user_id'];

        $filter_report = $_POST['filter_report'];
        $filter_from = $_POST['filter_from'];
        $filter_to = $_POST['filter_to'];

        $filter = '';
        if($filter_report == "all")
        {
            $filter = '';
        }
        else if($filter_report == "today")
        {
            $today = date("Y-m-d");
            $filter = "AND comment_date LIKE '%".$today."%'";
        }
        else if($filter_report == "yesterday")
        {
            $yesterday = date('Y-m-d', strtotime(' -1 day'));
            $filter = "AND comment_date LIKE '%".$yesterday."%'";
        }
        else if($filter_report == "this_week")
        {
            $dt = new DateTime();
            $dates = [];
            for ($d = 1; $d <= 7; $d++) {
                $dt->setISODate($dt->format('o'), $dt->format('W'), $d);
                $weekdate = ($dates[$dt->format('D')] = $dt->format('Y-m-d'));
            }
            $from = current($dates); // monday
            $to = end($dates); // sunday

            $filter = "AND comment_date BETWEEN '".$from."' AND '".$to."'";
        }
        else if($filter_report == "month")
        {
            $month = date("Y-m");
            $filter = "AND comment_date LIKE '%".$month."%'";
        }
        else if($filter_report == "year")
        {
            $year = date("Y");
            $due_date_filter = "AND comment_date LIKE '%".$year."%'";
        }
        else if($filter_report == "custom")
        {
            $filter = "AND comment_date BETWEEN '".$filter_from." 00:00:00' AND '".$filter_to." 23:59:59'";
        }

        $count = 1 + $start;
        $query = mysqli_query($conn, "SELECT task.task_id, task.task_name, comment.comment_message, comment.comment_date FROM comment INNER JOIN task ON comment.comment_task_id = task.task_id WHERE comment.comment_user_id = $user_id AND comment.comment_type = '2' $filter ORDER BY comment_date DESC LIMIT $start, $limit") or die(mysqli_error());
        while($data = mysqli_fetch_array($query))
        {
          $task_id = $data['task_id'];
          $query_lang = mysqli_query($conn, "SELECT list.list_name, task.task_id, space.space_name, task.task_list_id FROM task INNER JOIN list ON task.task_list_id = list.list_id INNER JOIN space ON list.list_space_id = space.space_id WHERE task.task_id = $task_id") or die(mysqli_error());
          $data_lang = mysqli_fetch_assoc($query_lang);
          $service_name = $data_lang['space_name'];
          $list_name = $data_lang['list_name'];
          $task_list_id = $data_lang['task_list_id'];
          echo '
            <tr style="cursor: pointer;" id="'.$service_name.','.$list_name.','.$task_list_id.','.$task_id.'" onclick="view_lang(this.id)">
              <td>'.$count++.'</td>
              <td>'.$data['task_name'].'</td>
              <td>'.$data['comment_message'].'</td>
              <td>'.$data['comment_date'].'</td>
            </tr>
          ';
        }
    }

    if(isset($_POST['load_move_data']))
    {
        $limit = $_POST['limit'];
        $start = $_POST['start'];
        $user_id = $_POST['user_id'];

        $filter_report = $_POST['filter_report'];
        $filter_from = $_POST['filter_from'];
        $filter_to = $_POST['filter_to'];

        $filter = '';
        if($filter_report == "all")
        {
            $filter = '';
        }
        else if($filter_report == "today")
        {
            $today = date("Y-m-d");
            $filter = "AND comment_date LIKE '%".$today."%'";
        }
        else if($filter_report == "yesterday")
        {
            $yesterday = date('Y-m-d', strtotime(' -1 day'));
            $filter = "AND comment_date LIKE '%".$yesterday."%'";
        }
        else if($filter_report == "this_week")
        {
            $dt = new DateTime();
            $dates = [];
            for ($d = 1; $d <= 7; $d++) {
                $dt->setISODate($dt->format('o'), $dt->format('W'), $d);
                $weekdate = ($dates[$dt->format('D')] = $dt->format('Y-m-d'));
            }
            $from = current($dates); // monday
            $to = end($dates); // sunday

            $filter = "AND comment_date BETWEEN '".$from."' AND '".$to."'";
        }
        else if($filter_report == "month")
        {
            $month = date("Y-m");
            $filter = "AND comment_date LIKE '%".$month."%'";
        }
        else if($filter_report == "year")
        {
            $year = date("Y");
            $due_date_filter = "AND comment_date LIKE '%".$year."%'";
        }
        else if($filter_report == "custom")
        {
            $filter = "AND comment_date BETWEEN '".$filter_from." 00:00:00' AND '".$filter_to." 23:59:59'";
        }

        $count = 1 + $start;
        $query = mysqli_query($conn, "SELECT task.task_id, task.task_name, comment.comment_message, comment.comment_date FROM comment INNER JOIN task ON comment.comment_task_id = task.task_id WHERE comment.comment_user_id = $user_id AND comment.comment_type = '3' $filter ORDER BY comment_date DESC LIMIT $start, $limit") or die(mysqli_error());
        while($data = mysqli_fetch_array($query))
        {
          $task_id = $data['task_id'];
          $query_lang = mysqli_query($conn, "SELECT list.list_name, task.task_id, space.space_name, task.task_list_id FROM task INNER JOIN list ON task.task_list_id = list.list_id INNER JOIN space ON list.list_space_id = space.space_id WHERE task.task_id = $task_id") or die(mysqli_error());
          $data_lang = mysqli_fetch_assoc($query_lang);
          $service_name = $data_lang['space_name'];
          $list_name = $data_lang['list_name'];
          $task_list_id = $data_lang['task_list_id'];
          echo '
            <tr style="cursor: pointer;" id="'.$service_name.','.$list_name.','.$task_list_id.','.$task_id.'" onclick="view_lang(this.id)">
              <td>'.$count++.'</td>
              <td>'.$data['task_name'].'</td>
              <td>'.$data['comment_message'].'</td>
              <td>'.$data['comment_date'].'</td>
            </tr>
          ';
        }
    }

    if(isset($_POST['load_wc_data']))
    {
        $limit = $_POST['limit'];
        $start = $_POST['start'];
        $user_id = $_POST['user_id'];

        $filter_report = $_POST['filter_report'];
        $filter_from = $_POST['filter_from'];
        $filter_to = $_POST['filter_to'];

        $filter = '';
        if($filter_report == "all")
        {
            $filter = '';
        }
        else if($filter_report == "today")
        {
            $today = date("Y-m-d");
            $filter = "AND comment_date LIKE '%".$today."%'";
        }
        else if($filter_report == "yesterday")
        {
            $yesterday = date('Y-m-d', strtotime(' -1 day'));
            $filter = "AND comment_date LIKE '%".$yesterday."%'";
        }
        else if($filter_report == "this_week")
        {
            $dt = new DateTime();
            $dates = [];
            for ($d = 1; $d <= 7; $d++) {
                $dt->setISODate($dt->format('o'), $dt->format('W'), $d);
                $weekdate = ($dates[$dt->format('D')] = $dt->format('Y-m-d'));
            }
            $from = current($dates); // monday
            $to = end($dates); // sunday

            $filter = "AND comment_date BETWEEN '".$from."' AND '".$to."'";
        }
        else if($filter_report == "month")
        {
            $month = date("Y-m");
            $filter = "AND comment_date LIKE '%".$month."%'";
        }
        else if($filter_report == "year")
        {
            $year = date("Y");
            $due_date_filter = "AND comment_date LIKE '%".$year."%'";
        }
        else if($filter_report == "custom")
        {
            $filter = "AND comment_date BETWEEN '".$filter_from." 00:00:00' AND '".$filter_to." 23:59:59'";
        }

        $count = 1 + $start;
        $query = mysqli_query($conn, "SELECT task.task_id, task.task_name, comment.comment_message, comment.comment_date FROM comment INNER JOIN task ON comment.comment_task_id = task.task_id WHERE comment.comment_user_id = $user_id AND comment.comment_type is null $filter ORDER BY comment_date DESC LIMIT $start, $limit") or die(mysqli_error());
        while($data = mysqli_fetch_array($query))
        {
          $task_id = $data['task_id'];
          $query_lang = mysqli_query($conn, "SELECT list.list_name, task.task_id, space.space_name, task.task_list_id FROM task INNER JOIN list ON task.task_list_id = list.list_id INNER JOIN space ON list.list_space_id = space.space_id WHERE task.task_id = $task_id") or die(mysqli_error());
          $data_lang = mysqli_fetch_assoc($query_lang);
          $service_name = $data_lang['space_name'];
          $list_name = $data_lang['list_name'];
          $task_list_id = $data_lang['task_list_id'];
          echo '
            <tr style="cursor: pointer;" id="'.$service_name.','.$list_name.','.$task_list_id.','.$task_id.'" onclick="view_lang(this.id)">
              <td>'.$count++.'</td>
              <td>'.$data['task_name'].'</td>
              <td>'.$data['comment_message'].'</td>
              <td>'.$data['comment_date'].'</td>
            </tr>
          ';
        }
    }

    if(isset($_POST['load_es_data']))
    {
        $limit = $_POST['limit'];
        $start = $_POST['start'];
        $user_id = $_POST['user_id'];

        $filter_report = $_POST['filter_report'];
        $filter_from = $_POST['filter_from'];
        $filter_to = $_POST['filter_to'];

        $filter = '';
        if($filter_report == "all")
        {
            $filter = '';
        }
        else if($filter_report == "today")
        {
            $today = date("Y-m-d");
            $filter = "AND comment_date LIKE '%".$today."%'";
        }
        else if($filter_report == "yesterday")
        {
            $yesterday = date('Y-m-d', strtotime(' -1 day'));
            $filter = "AND comment_date LIKE '%".$yesterday."%'";
        }
        else if($filter_report == "this_week")
        {
            $dt = new DateTime();
            $dates = [];
            for ($d = 1; $d <= 7; $d++) {
                $dt->setISODate($dt->format('o'), $dt->format('W'), $d);
                $weekdate = ($dates[$dt->format('D')] = $dt->format('Y-m-d'));
            }
            $from = current($dates); // monday
            $to = end($dates); // sunday

            $filter = "AND comment_date BETWEEN '".$from."' AND '".$to."'";
        }
        else if($filter_report == "month")
        {
            $month = date("Y-m");
            $filter = "AND comment_date LIKE '%".$month."%'";
        }
        else if($filter_report == "year")
        {
            $year = date("Y");
            $due_date_filter = "AND comment_date LIKE '%".$year."%'";
        }
        else if($filter_report == "custom")
        {
            $filter = "AND comment_date BETWEEN '".$filter_from." 00:00:00' AND '".$filter_to." 23:59:59'";
        }

        $count = 1 + $start;
        $query = mysqli_query($conn, "SELECT task.task_id, task.task_name, comment.comment_message, comment.comment_date FROM comment INNER JOIN task ON comment.comment_task_id = task.task_id WHERE comment.comment_user_id = $user_id AND comment.comment_type = '4' $filter ORDER BY comment_date DESC LIMIT $start, $limit") or die(mysqli_error());
        while($data = mysqli_fetch_array($query))
        {
          $task_id = $data['task_id'];
          $query_lang = mysqli_query($conn, "SELECT list.list_name, task.task_id, space.space_name, task.task_list_id FROM task INNER JOIN list ON task.task_list_id = list.list_id INNER JOIN space ON list.list_space_id = space.space_id WHERE task.task_id = $task_id") or die(mysqli_error());
          $data_lang = mysqli_fetch_assoc($query_lang);
          $service_name = $data_lang['space_name'];
          $list_name = $data_lang['list_name'];
          $task_list_id = $data_lang['task_list_id'];
          echo '
            <tr style="cursor: pointer;" id="'.$service_name.','.$list_name.','.$task_list_id.','.$task_id.'" onclick="view_lang(this.id)">
              <td>'.$count++.'</td>
              <td>'.$data['task_name'].'</td>
              <td>'.$data['comment_message'].'</td>
              <td>'.$data['comment_date'].'</td>
            </tr>
          ';
        }
    }

    if(isset($_POST['load_ad_data']))
    {
        $limit = $_POST['limit'];
        $start = $_POST['start'];
        $user_id = $_POST['user_id'];

        $filter_report = $_POST['filter_report'];
        $filter_from = $_POST['filter_from'];
        $filter_to = $_POST['filter_to'];

        $filter = '';
        if($filter_report == "all")
        {
            $filter = '';
        }
        else if($filter_report == "today")
        {
            $today = date("Y-m-d");
            $filter = "LIKE '%".$today."%'";
        }
        else if($filter_report == "yesterday")
        {
            $yesterday = date('Y-m-d', strtotime(' -1 day'));
            $filter = "LIKE '%".$yesterday."%'";
        }
        else if($filter_report == "this_week")
        {
            $dt = new DateTime();
            $dates = [];
            for ($d = 1; $d <= 7; $d++) {
                $dt->setISODate($dt->format('o'), $dt->format('W'), $d);
                $weekdate = ($dates[$dt->format('D')] = $dt->format('Y-m-d'));
            }
            $from = current($dates); // monday
            $to = end($dates); // sunday

            $filter = "BETWEEN '".$from."' AND '".$to."'";
        }
        else if($filter_report == "month")
        {
            $month = date("Y-m");
            $filter = "LIKE '%".$month."%'";
        }
        else if($filter_report == "year")
        {
            $year = date("Y");
            $due_date_filter = "LIKE '%".$year."%'";
        }
        else if($filter_report == "custom")
        {
            $filter = "BETWEEN '".$filter_from." 00:00:00' AND '".$filter_to." 23:59:59'";
        }

        $find_task = mysqli_query($conn, "SELECT * FROM task WHERE task_date_created $filter AND task_assign_to LIKE '%$user_id%' AND task_due_date != '0000-00-00' AND task_due_date IS NOT NULL ORDER BY task_due_date DESC LIMIT $start, $limit");
        while($data = mysqli_fetch_array($find_task)){
          $str_to_array = explode(",",$data['task_assign_to']);
          if(in_array($user_id,$str_to_array))
          {
            $date_today = date('Y-m-d');
            $today = date("Y-m-d"); // Get current date
            $tomorrow = date('Y-m-d', strtotime(' +1 day')); // Get tomorrow date
            $tomorrow2 = date('Y-m-d', strtotime(' +2 day'));
            $tomorrow3 = date('Y-m-d', strtotime(' +3 day'));
            $tomorrow4 = date('Y-m-d', strtotime(' +4 day'));
            $tomorrow5 = date('Y-m-d', strtotime(' +5 day'));
            $tomorrow6 = date('Y-m-d', strtotime(' +6 day'));
            $due_date_time = $data['task_due_date']; // ex: 2020-12-10 00:00:00
            $ymd = substr($due_date_time, -19, 10); // 2020-12-10 00:00:00 // Y-m-d = 2020-12-10 00

            $task_id = $data['task_id'];
            $query_lang = mysqli_query($conn, "SELECT list.list_name, task.task_id, space.space_name, task.task_list_id FROM task INNER JOIN list ON task.task_list_id = list.list_id INNER JOIN space ON list.list_space_id = space.space_id WHERE task.task_id = $task_id") or die(mysqli_error());
            $data_lang = mysqli_fetch_assoc($query_lang);
            $service_name = $data_lang['space_name'];
            $list_name = $data_lang['list_name'];
            $task_list_id = $data_lang['task_list_id'];
            echo '
              <tr style="cursor: pointer;" id="'.$service_name.','.$list_name.','.$task_list_id.','.$task_id.'" onclick="view_lang(this.id)">
                <td>Task ID: '.$task_id.'</td>
                <td>'.$data['task_name'].'</td>
                <td class="text-center">';
                if($ymd == $today)
                {
                    $task_priority = "D Urgent";
                    mysqli_query($conn, "UPDATE task SET task_priority='$task_priority' WHERE task_id='$task_id'") or die(mysqli_error());
                    echo'<span class="badge badge-danger">Today</span>';
                }
                else if($ymd == $tomorrow)
                {
                    $task_priority = "C High";
                    mysqli_query($conn, "UPDATE task SET task_priority='$task_priority' WHERE task_id='$task_id'") or die(mysqli_error());
                    echo'<span class="badge badge-warning">Tomorrow</span>';
                }
                else if($due_date_time == "" or $due_date_time == '0000-00-00')
                {
                    echo'<span class="badge badge-primary">No Due Date yet!!</span>';
                }
                else if($due_date_time < $date_today)
                {
                    echo'<span class="badge badge-info">Overdue</span>';
                }
                else if($ymd === $tomorrow2)
                {
                    echo'<span class="badge badge-info">'.date("l", strtotime($due_date_time)).'</span>';
                }
                else if($ymd === $tomorrow3)
                {
                    echo'<span class="badge badge-info">'.date("l", strtotime($due_date_time)).'</span>';
                }
                else if($ymd === $tomorrow4)
                {
                    echo'<span class="badge badge-info">'.date("l", strtotime($due_date_time)).'</span>';
                }
                else if($ymd === $tomorrow5)
                {
                    echo'<span class="badge badge-info">'.date("l", strtotime($due_date_time)).'</span>';
                }
                else if($ymd === $tomorrow6)
                {
                    echo'<span class="badge badge-info">'.date("l", strtotime($due_date_time)).'</span>';
                }
                else
                {
                  echo'<span class="badge badge-success">'.$due_date_time.'</span>';
                }
                echo '
                </td>
                <td>'.$data['task_date_created'].'</td>
              </tr>
            ';
          }
        }
    }

?>
