<?php  
    include("../conn.php");
    // ----------------------- EMAIL HISTORY -----------------------
    if(isset($_POST['display_email_history_table']))
    { 
        $task_id = $_POST['task_id'];

        $results = mysqli_query($conn, "SELECT `user`.fname, `user`.mname, `user`.lname, email_format.email_name, email_format.email_subject, email_format.email_id, email_send_history.`email_send_to`, email_send_history.email_send_date FROM email_send_history INNER JOIN `user` ON email_send_history.email_send_by = `user`.user_id INNER JOIN email_format ON email_send_history.email_format_id = email_format.email_id WHERE email_send_history.email_task_id = '$task_id' ORDER BY email_send_history.email_send_date DESC");
        $count = 1;
        ?>
        <table class="js-table-sections table table-bordered table-hover">
            <thead>
                <tr>
                    <th style="width: 30px;"></th>
                    <th>Email Name</th>
                    <th style="width: 15%;">Sent by</th>
                    <th class="d-none d-sm-table-cell" style="width: 20%;">Date sent</th>
                </tr>
            </thead>
        <?php
        while($rows = mysqli_fetch_array($results))
        {
            $email_name = $rows['email_name'];
            $file_loc = "email_content/".$email_name.".txt";

            $myfile = fopen($file_loc, "r") or die("Unable to open file!");
            $content = fread($myfile,filesize($file_loc));
            // fclose($myfile);
            $fullname = $rows["fname"];
            ?>
            <tbody class="js-table-sections-header">
                <tr>
                    <td class="text-center">
                        <i class="fa fa-angle-right"></i>
                    </td>
                    <td class="font-w600"><?php echo $rows["email_name"]; ?></td>
                    <td><?php echo $fullname; ?></td>
                    <td class="d-none d-sm-table-cell">
                        <em class="text-muted"><?php echo $rows["email_send_date"]; ?></em>
                    </td>
                </tr>
            </tbody>
            <tbody>
                <tr>
                    <td class="text-center"></td>
                    <td class="font-w600 text-success">+ $105,00</td>
                    <td class="font-size-sm">Stripe</td>
                    <td class="d-none d-sm-table-cell">
                        <span class="font-size-sm text-muted">October 6, 2017 12:16</span>
                    </td>
                </tr>
            </tbody>
            <?php
        }?>
        </table>
        <?php
    }
    // ----------------------- END EMAIL HISTORY -----------------------
?>