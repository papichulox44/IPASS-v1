<?php 
	include("../conn.php");

	//------------------------------------------------------------------------------------------
	if (isset($_POST['due_date'])) {

		$results = mysqli_query($conn, "SELECT task.task_name, `user`.fname, `user`.mname, `user`.lname, task.task_due_date, task.admin_notification FROM task INNER JOIN `user` ON task.task_created_by = `user`.user_id WHERE task.task_due_date != 0000-00-00 ORDER BY task.admin_notification, task.task_due_date DESC");
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

		$results = mysqli_query($conn, "SELECT Count(task.admin_notification) AS count FROM task WHERE task.admin_notification != 1 AND task.task_due_date != 0000-00-00 ");
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

		$results = mysqli_query($conn, "SELECT Count(contact.admin_notification) AS count FROM contact WHERE contact.admin_notification != 1");
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
 ?>