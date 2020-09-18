<?php 
	include("../conn.php");

	//------------------------------------------------------------------------------------------
	if (isset($_POST['due_date'])) {

		$results = mysqli_query($conn, "SELECT task.task_name, `user`.fname, `user`.mname, `user`.lname, task.task_due_date, task.admin_notification FROM task INNER JOIN `user` ON task.task_created_by = `user`.user_id WHERE task.task_due_date != 0000-00-00 ORDER BY task.admin_notification, task.task_due_date DESC");
		$row = mysqli_num_rows($results);
		if ($row) {
	        while($rows = mysqli_fetch_array($results))
	        {
	            echo'
		            <li>
		                <div class="list-timeline-time text-white">'.$rows['task_name'].'</div>
		                <i class="list-timeline-icon fa fa-calendar '; if($rows['admin_notification'] == 0){ echo 'bg-danger';} else { echo 'bg-success'; } echo '"></i>
		                <div class="list-timeline-content">
		                    <p class="font-w600 text-white">Due Date Task: '.$rows['task_due_date'].'</p>
		                    <p class="text-white">Created by: '.$rows['fname'].' '.$rows['mname'].' '.$rows['lname'].'</p>
		                </div>
		            </li>';
	        }
	     } else {

	     	echo '
	     		<li>
	     			<div class="list-timeline-time text-white">No Records for Due Date....</div>
	     		</li>
	     	';
	     }
        mysqli_close($conn);
	}

	if (isset($_POST['update_due_date'])) {

		$results = mysqli_query($conn, "UPDATE task SET admin_notification = 1 WHERE task_due_date != 0000-00-00 AND admin_notification = 0");
		if ($results) {
			echo 'success';
		}
		mysqli_close($conn);
	}
	
	if (isset($_POST['count_due_date'])) {

		$results = mysqli_query($conn, "SELECT Count(task.admin_notification) AS count FROM task INNER JOIN `user` ON task.task_created_by = `user`.user_id WHERE task.admin_notification != 1 AND task.task_due_date != 0000-00-00 ");
		while($rows = mysqli_fetch_array($results))
		{
			echo $rows['count'];
		}
		mysqli_close($conn);
	}
	//------------------------------------------------------------------------------------------

	//------------------------------------------------------------------------------------------

	if (isset($_POST['creating_contacts'])) {

		$results = mysqli_query($conn, "SELECT `user`.fname, `user`.mname, `user`.lname, contact.contact_mname, contact.contact_fname, contact.contact_lname, contact.contact_date_created, contact.admin_notification FROM contact INNER JOIN `user` ON contact.contact_created_by = `user`.user_id ORDER BY contact.admin_notification, contact.contact_date_created DESC");
        while($rows = mysqli_fetch_array($results))
        {
            echo'
	            <li>
	                <div class="list-timeline-time">'.$rows['contact_date_created'].'</div>
	                <i class="list-timeline-icon fa fa-address-book '; if($rows['admin_notification'] == 0){ echo 'bg-danger';} else { echo 'bg-success'; } echo '"></i>
	                <div class="list-timeline-content">
	                    <p class="font-w600 text-white">Contact Name: '.$rows['contact_fname'].' '.$rows['contact_mname'].' '.$rows['contact_lname'].'</p>
	                    <p class="text-white">Created by: '.$rows['fname'].' '.$rows['mname'].' '.$rows['lname'].'</p>
	                </div>
	            </li>';
        }
        mysqli_close($conn);
	}

	if (isset($_POST['count_creating_contacts'])) {

		$results = mysqli_query($conn, "SELECT Count(contact.admin_notification) AS count FROM contact INNER JOIN `user` ON contact.contact_created_by = `user`.user_id WHERE contact.admin_notification != 1");
		while($rows = mysqli_fetch_array($results))
		{
			echo $rows['count'];
		}
		mysqli_close($conn);
	}

	if (isset($_POST['update_creating_contacts'])) {

		$results = mysqli_query($conn, "UPDATE contact SET admin_notification = 1 WHERE admin_notification = 0");
		if ($results) {
			echo 'success';
		}
		mysqli_close($conn);
	}
	//------------------------------------------------------------------------------------------


	//------------------------------------------------------------------------------------------
	if (isset($_POST['creating_comments'])) {

		$results = mysqli_query($conn, "SELECT `user`.fname, `user`.mname, `user`.lname, task.task_name, `comment`.comment_message, `comment`.comment_date, `comment`.comment_attactment, `comment`.admin_notification FROM `comment` INNER JOIN task ON `comment`.comment_task_id = task.task_id INNER JOIN `user` ON `comment`.comment_user_id = `user`.user_id ORDER BY `comment`.admin_notification ASC, `comment`.comment_date DESC");
        while($rows = mysqli_fetch_array($results))
        {
            echo'
	            <li style="cursor: pointer;">
	                <div class="row">
	                    <div class="col-sm-6">
	                        <i class="si si-pencil '; if($rows['admin_notification'] == 0){ echo 'text-danger';} else { echo 'text-success'; } echo '"></i>
	                        <div class="font-w600 text-white">Task Name: '.$rows['task_name'].'</div>
	                        <div class="font-w600 text-white">Comment by: '.$rows['fname'].' '.$rows['mname'].' '.$rows['lname'].'</div>
	                        <div class="font-size-xs text-muted text-white">'.$rows['comment_date'].'</div>
	                    </div>

	                    <div class="col-sm-6">
	                        <br>
	                        <br>
	                        <div class="font-w600 text-white">'.$rows['comment_message'].'</div>
	                    </div>
	                </div>
	            </li>';
        }
        mysqli_close($conn);
	}

	if (isset($_POST['count_creating_comments'])) {

		$results = mysqli_query($conn, "SELECT Count(comment.admin_notification) AS count FROM `comment` INNER JOIN task ON `comment`.comment_task_id = task.task_id INNER JOIN `user` ON `comment`.comment_user_id = `user`.user_id WHERE comment.admin_notification != 1");
		while($rows = mysqli_fetch_array($results))
		{
			echo $rows['count'];
		}
		mysqli_close($conn);
	}

	if (isset($_POST['update_creating_comments'])) {

		$results = mysqli_query($conn, "UPDATE comment SET admin_notification = 1 WHERE admin_notification = 0");
		if ($results) {
			echo 'success';
		}
		mysqli_close($conn);
	}
	//------------------------------------------------------------------------------------------

	//------------------------------------------------------------------------------------------
	if (isset($_POST['creating_remarks'])) {

		$results = mysqli_query($conn, "SELECT task.task_name, finance_remarks.admin_notification, finance_remarks.remarks_value, `user`.fname, `user`.mname, `user`.lname FROM finance_remarks INNER JOIN `user` ON finance_remarks.remarks_by = `user`.user_id INNER JOIN task ON finance_remarks.remarks_to = task.task_id ORDER BY finance_remarks.admin_notification ASC, finance_remarks.remarks_id DESC");
        while($rows = mysqli_fetch_array($results))
        {
            echo'
	            <li style="cursor: pointer;">
	                <div class="row">
	                    <div class="col-sm-6">
	                        <i class="si si-pencil '; if($rows['admin_notification'] == 0){ echo 'text-danger';} else { echo 'text-success'; } echo '"></i>
	                        <div class="font-w600 text-white">Task Name: '.$rows['task_name'].'</div>
	                        <div class="font-w600 text-white">Remarks by: '.$rows['fname'].' '.$rows['mname'].' '.$rows['lname'].'</div>
	                    </div>

	                    <div class="col-sm-6">
	                        <br>
	                        <div class="font-w600 text-white">Remarks: <span class="badge '; 
	                        if ($rows['remarks_value'] == 'Payment received') {
	                       		echo 'badge-success';
	                        } 
	                        if ($rows['remarks_value'] == 'On hold') {
	                       		echo 'badge-warning';
	                        } 
	                        if ($rows['remarks_value'] == 'Pending') {
	                       		echo 'badge-warning';
	                        } 
	                        if ($rows['remarks_value'] == 'Waiting to be received') {
	                       		echo 'badge-primary';
	                        } 
	                        if ($rows['remarks_value'] == 'Refunded') {
	                       		echo 'badge-danger';
	                        } 
	                        if ($rows['remarks_value'] == 'Payment encoded') {
	                       		echo 'badge-info';
	                        } 

	                        echo'">'.$rows['remarks_value'].'</span></div>
	                    </div>
	                </div>
	            </li>';
        }
        mysqli_close($conn);
	}

	if (isset($_POST['count_creating_remarks'])) {

		$results = mysqli_query($conn, "SELECT Count(finance_remarks.admin_notification) AS count FROM finance_remarks INNER JOIN `user` ON finance_remarks.remarks_by = `user`.user_id INNER JOIN task ON finance_remarks.remarks_to = task.task_id WHERE finance_remarks.admin_notification != 1");
		while($rows = mysqli_fetch_array($results))
		{
			echo $rows['count'];
		}
		mysqli_close($conn);
	}

	if (isset($_POST['update_creating_remarks'])) {

		$results = mysqli_query($conn, "UPDATE finance_remarks SET admin_notification = 1 WHERE admin_notification = 0");
		if ($results) {
			echo 'success';
		}
		mysqli_close($conn);
	}
	//------------------------------------------------------------------------------------------

	//------------------------------------------------------------------------------------------
	if (isset($_POST['creating_assigned_task'])) {

		$results = mysqli_query($conn, "SELECT `user`.fname, `user`.mname, `user`.lname, task.task_assign_to, task.task_date_created, task.task_name, task.admin_notification_assigned_task FROM task INNER JOIN `user` ON task.task_created_by = `user`.user_id ORDER BY task.admin_notification_assigned_task ASC, task.task_created_by DESC");
        while($rows = mysqli_fetch_array($results))
        {
            echo'
	            <li style="cursor: pointer;">
	                <div class="row">
	                    <div class="col-sm-6">
	                        <i class="si si-user-follow '; if($rows['admin_notification_assigned_task'] == 0){ echo 'text-danger';} else { echo 'text-success'; } echo '"></i>
	                        <div class="font-w600 text-white">Task Name: '.$rows['task_name'].'</div>
	                        <div class="font-w600 text-white">Created by: '.$rows['fname'].' '.$rows['mname'].' '.$rows['lname'].'</div>
	                        <div class="font-size-xs text-muted text-white"> -'.$rows['task_date_created'].'</div>
	                    </div>

	                    <div class="col-sm-6">
	                        <br>
	                        <br>
	                        <div class="font-w600 text-white">'; 
	                        $total_assign_to = $rows['task_assign_to']; // get the assign id
                                if ($total_assign_to == 0) 
                                {
                                    echo 'Unassign';
                                }
                                else
                                {
                                    $assign_array = explode(",",$total_assign_to); // string to array
                                    $count_assign = count($assign_array); // count the array
                                    for($c = 0; $c < $count_assign; $c++)
                                    {
                                        $assign_id = $assign_array[$c];
                                        $select_user = mysqli_query($conn, "SELECT * FROM user WHERE user_id = '$assign_id'");
                                        $fetch_user = mysqli_fetch_array($select_user);
                                        $get_first_letter_in_fname = $fetch_user['fname'];     
                                        $get_first_letter_in_lname = $fetch_user['lname'];
                                        if($fetch_user['profile_pic'] != "")
                                        {
                                            echo '<img type="button" title="'.$fetch_user['fname'].' '.$fetch_user['lname'].'" src="../assets/media/upload/'.$fetch_user['profile_pic'].'" style="width:33px; height:33px; border-radius:50px; margin: 0px -5px 0px -5px; border: 1px solid #fff;">
                                                <span style="display: none;">'.$fetch_user['fname'].' '.$fetch_user['lname'].'</span>';
                                        }
                                        else
                                        {
                                            echo '<span class="btn btn-circle" type="button" title="'.$fetch_user['fname'].' '.$fetch_user['lname'].'" style="background-color: '.$fetch_user['user_color'].'; margin: 0px -5px 0px -5px; border: 1px solid #fff;">
                                                <i class="text-white" style="font-size: 12px;">'.$get_first_letter_in_fname[0].''.$get_first_letter_in_lname[0].'</i>
                                                </span>
                                                </span><span style="display: none;">'.$fetch_user['fname'].' '.$fetch_user['lname'].'</span>';
                                        }
                                    }
                                }    

	                        echo'</div>
	                    </div>
	                </div>
	            </li>';
        }
        mysqli_close($conn);
	}

	if (isset($_POST['count_creating_assigned_task'])) {

		$results = mysqli_query($conn, "SELECT Count(task.admin_notification_assigned_task) AS count FROM task INNER JOIN `user` ON task.task_created_by = `user`.user_id WHERE task.admin_notification_assigned_task != 1");
		while($rows = mysqli_fetch_array($results))
		{
			echo $rows['count'];
		}
		mysqli_close($conn);
	}

	if (isset($_POST['update_creating_assigned_task'])) {

		$results = mysqli_query($conn, "UPDATE task SET admin_notification_assigned_task = 1 WHERE admin_notification_assigned_task = 0");
		if ($results) {
			echo 'success';
		}
		mysqli_close($conn);
	}
	//------------------------------------------------------------------------------------------

 ?>