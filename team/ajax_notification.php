<?php 
	include("../conn.php");

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

		$results = mysqli_query($conn, "UPDATE task SET admin_notification = 1 WHERE task_due_date != 0000-00-00");
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

 ?>