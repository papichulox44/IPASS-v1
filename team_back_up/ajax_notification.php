<?php 
	session_start();
	$user_type = $_SESSION['user_type'];
	$user_id = $_SESSION['user'];
	include("../conn.php");

	//------------------------------------------------------------------------------------------
	if (isset($_POST['due_date'])) {
		$results = mysqli_query($conn, "SELECT task.task_name, `user`.fname, `user`.mname, `user`.lname, task.task_due_date, task.admin_notification, list.list_id, task.task_id, list.list_name, space.space_name FROM task INNER JOIN `user` ON task.task_created_by = `user`.user_id INNER JOIN list ON task.task_list_id = list.list_id INNER JOIN space ON list.list_space_id = space.space_id WHERE task.task_due_date != 0000-00-00 AND task.admin_notification = 0 ORDER BY task.admin_notification ASC, task.task_due_date DESC");

		$row = mysqli_num_rows($results);
		if ($row) {
	        while($rows = mysqli_fetch_array($results))
	        {
	            echo'
		            <li style="cursor: pointer;" id="'.$rows['space_name'].','.$rows['list_name'].','.$rows['list_id'].','.$rows['task_id'].'" onclick="click_due_date(this.id)">
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
	     			<div class="list-timeline-time text-white">No Notification for Due Date....</div>
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
		if ($user_type == 'Admin') {
			$results = mysqli_query($conn, "SELECT `user`.fname, `user`.mname, `user`.lname, contact.contact_mname, contact.contact_fname, contact.contact_lname, contact.contact_date_created, contact.admin_notification, contact.contact_id FROM contact INNER JOIN `user` ON contact.contact_created_by = `user`.user_id WHERE contact.admin_notification = 0 ORDER BY contact.admin_notification, contact.contact_date_created DESC");
		} else {
			$results = mysqli_query($conn, "SELECT `user`.fname, `user`.mname, `user`.lname, contact.contact_mname, contact.contact_fname, contact.contact_lname, contact.contact_date_created, contact.user_notification, contact.contact_id FROM contact INNER JOIN `user` ON contact.contact_created_by = `user`.user_id WHERE contact.user_notification = 0 AND contact.contact_created_by = $user_id ORDER BY contact.user_notification, contact.contact_date_created DESC");	
		}

		$row = mysqli_num_rows($results);
		if ($row) {
	        while($rows = mysqli_fetch_array($results))
	        {
	            echo'
		            <li style="cursor: pointer;" id="'.$rows['contact_id'].'" onclick="click_creating_contacts(this.id)">
		                <div class="list-timeline-time">'.$rows['contact_date_created'].'</div>
						<i class="list-timeline-icon fa fa-address-book bg-danger"></i>
		                <div class="list-timeline-content">
		                    <p class="font-w600 text-white">Contact Name: '.$rows['contact_fname'].' '.$rows['contact_mname'].' '.$rows['contact_lname'].'</p>
		                    <p class="text-white">Created by: '.$rows['fname'].' '.$rows['mname'].' '.$rows['lname'].'</p>
		                </div>
		            </li>';
	        }
	    } else {
	    		echo'
		            <li>
		                <div class="list-timeline-time"></div>
		                <i class="list-timeline-icon fa fa-address-book bg-danger"></i>
		                <div class="list-timeline-content">
		                    <p class="font-w600 text-white">No Notification for Creating Contacts....</p>
		                </div>
		            </li>';
	    }
        mysqli_close($conn);
	}

	if (isset($_POST['count_creating_contacts'])) {
		if ($user_type == 'Admin') {
			$results = mysqli_query($conn, "SELECT Count(contact.admin_notification) AS count FROM contact INNER JOIN `user` ON contact.contact_created_by = `user`.user_id WHERE contact.admin_notification != 1");
		} else {
			$results = mysqli_query($conn, "SELECT Count(contact.admin_notification) AS count FROM contact INNER JOIN `user` ON contact.contact_created_by = `user`.user_id WHERE contact.user_notification != 1 AND contact.contact_created_by = $user_id");
		}
		while($rows = mysqli_fetch_array($results))
		{
			echo $rows['count'];
		}
		mysqli_close($conn);
	}

	if (isset($_POST['update_creating_contacts'])) {
		if ($user_type == 'Admin') {
			$results = mysqli_query($conn, "UPDATE contact SET admin_notification = 1 WHERE admin_notification = 0");
		} else {
			$results = mysqli_query($conn, "UPDATE contact SET user_notification = 1 WHERE user_notification = 0 AND contact.contact_created_by = $user_id");
		}
		if ($results) {
			echo 'success';
		}
		mysqli_close($conn);
	}
	//------------------------------------------------------------------------------------------


	//------------------------------------------------------------------------------------------
	if (isset($_POST['creating_comments'])) {
		if ($user_type == 'Admin') {
			$results = mysqli_query($conn, "SELECT `user`.fname, `user`.mname, `user`.lname, task.task_name, `comment`.comment_message, `comment`.comment_date, `comment`.comment_attactment, `comment`.admin_notification, list.list_id, space.space_name, list.list_name, task.task_id, `comment`.comment_id FROM `comment` INNER JOIN task ON `comment`.comment_task_id = task.task_id INNER JOIN `user` ON `comment`.comment_user_id = `user`.user_id INNER JOIN list ON task.task_list_id = list.list_id INNER JOIN space ON list.list_space_id = space.space_id WHERE `comment`.admin_notification = 0 ORDER BY `comment`.admin_notification ASC, `comment`.comment_date DESC");
		} else {
			$results = mysqli_query($conn, "SELECT `user`.fname, `user`.mname, `user`.lname, task.task_name, `comment`.comment_message, `comment`.comment_date, `comment`.comment_attactment, `comment`.user_notification, list.list_id, space.space_name, list.list_name, task.task_id, `comment`.comment_id FROM `comment` INNER JOIN task ON `comment`.comment_task_id = task.task_id INNER JOIN `user` ON `comment`.comment_user_id = `user`.user_id INNER JOIN list ON task.task_list_id = list.list_id INNER JOIN space ON list.list_space_id = space.space_id WHERE `comment`.user_notification = 0 AND comment.comment_user_id = $user_id ORDER BY `comment`.user_notification ASC, `comment`.comment_date DESC");
		}
		$row = mysqli_num_rows($results);
		if ($row) {
	        while($rows = mysqli_fetch_array($results))
	        {
	            echo'
		            <li style="cursor: pointer;" id="'.$rows['space_name'].','.$rows['list_name'].','.$rows['list_id'].','.$rows['task_id'].','.$rows['comment_id'].'" onclick="click_comments(this.id)">
		                <div class="row">
		                    <div class="col-sm-6">
		                        <i class="si si-pencil text-danger"></i>
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
	    } else {
	    	echo'
		            <li>
		                <div class="row">
		                    <div class="col-sm-6">
		                        <i class="si si-pencil text-danger"></i>
		                        <div class="font-w600 text-white">No Notification for Comment....</div>
		                    </div>

		                    <div class="col-sm-6">
		                    </div>
		                </div>
		            </li>';
	    }
        mysqli_close($conn);
	}

	if (isset($_POST['count_creating_comments'])) {
		if ($user_type == 'Admin') {
			$results = mysqli_query($conn, "SELECT Count(comment.admin_notification) AS count FROM `comment` INNER JOIN task ON `comment`.comment_task_id = task.task_id INNER JOIN `user` ON `comment`.comment_user_id = `user`.user_id WHERE comment.admin_notification != 1");
		} else {
			$results = mysqli_query($conn, "SELECT Count(comment.user_notification) AS count FROM `comment` INNER JOIN task ON `comment`.comment_task_id = task.task_id INNER JOIN `user` ON `comment`.comment_user_id = `user`.user_id WHERE comment.user_notification != 1 AND comment.comment_user_id = $user_id");
		}
		while($rows = mysqli_fetch_array($results))
		{
			echo $rows['count'];
		}
		mysqli_close($conn);
	}

	if (isset($_POST['update_creating_comments'])) {
		if ($user_type == 'Admin') {
			$results = mysqli_query($conn, "UPDATE comment SET admin_notification = 1 WHERE admin_notification = 0");
		} else {
			$results = mysqli_query($conn, "UPDATE comment SET user_notification = 1 WHERE user_notification = 0 AND comment.comment_user_id = $user_id");
		}
		if ($results) {
			echo 'success';
		}
		mysqli_close($conn);
	}
	//------------------------------------------------------------------------------------------

	//------------------------------------------------------------------------------------------
	if (isset($_POST['creating_remarks'])) {

		$results = mysqli_query($conn, "SELECT finance_transaction.val_id, finance_transaction.val_remarks, finance_transaction.admin_notification, task.task_id, task.task_name, `user`.fname, `user`.mname, `user`.lname, list.list_id, list.list_name, space.space_name, finance_transaction.val_transaction_no FROM finance_transaction INNER JOIN task ON finance_transaction.val_assign_to = task.task_id INNER JOIN `user` ON finance_transaction.val_add_by = `user`.user_id INNER JOIN list ON task.task_list_id = list.list_id INNER JOIN space ON list.list_space_id = space.space_id WHERE finance_transaction.admin_notification = 0 ORDER BY finance_transaction.admin_notification ASC, finance_transaction.val_id DESC
");
		$row = mysqli_num_rows($results);
		if ($row) {
	        while($rows = mysqli_fetch_array($results))
	        {
	            echo'
		            <li style="cursor: pointer;" id="'.$rows['space_name'].','.$rows['list_name'].','.$rows['list_id'].','.$rows['task_id'].','.$rows['val_id'].'" onclick="click_remarks(this.id)">
		                <div class="row">
		                    <div class="col-sm-6">
		                        <i class="si si-pencil '; if($rows['admin_notification'] == 0){ echo 'text-danger';} else { echo 'text-success'; } echo '"></i><label class="text-white">Task#: '.$rows['task_id'].' | Transaction#: '.$rows['val_transaction_no'].' </label>
		                        <div class="font-w600 text-white">Task Name: '.$rows['task_name'].'</div>
		                        <div class="font-w600 text-white">Remarks by: '.$rows['fname'].' '.$rows['mname'].' '.$rows['lname'].'</div>
		                    </div>

		                    <div class="col-sm-6">
		                        <br>
		                        <div class="font-w600 text-white">Remarks: <span class="badge '; 
		                        if ($rows['val_remarks'] == 'Payment received') {
		                       		echo 'badge-success';
		                       		$remarks = 'Payment received';
		                        } 
		                        if ($rows['val_remarks'] == 'On hold') {
		                       		echo 'badge-warning';
		                       		$remarks = 'On hold';
		                        } 
		                        if ($rows['val_remarks'] == 'Pending') {
		                       		echo 'badge-warning';
		                       		$remarks = 'Pending';
		                        } 
		                        if ($rows['val_remarks'] == 'Waiting to be received') {
		                       		echo 'badge-primary';
		                       		$remarks = 'Waiting to be received';
		                        } 
		                        if ($rows['val_remarks'] == 'Refunded') {
		                       		echo 'badge-danger';
		                       		$remarks = 'Refunded';
		                        } 
		                        if ($rows['val_remarks'] == 'Payment encoded') {
		                       		echo 'badge-info';
		                       		$remarks = 'Payment encoded';
		                        } 
		                        if ($rows['val_remarks'] == '') {
		                       		echo 'badge-danger';
		                       		$remarks = 'No Remarks';
		                        } 

		                        echo'">'.$remarks.'</span></div>
		                    </div>
		                </div>
		            </li>';
	        }
	    } else {
	    	echo'
		            <li>
		                <div class="row">
		                    <div class="col-sm-6">
		                        <i class="si si-pencil text-danger"></i>
		                        <div class="font-w600 text-white">No Notification for Remarks....</div>
		                    </div>

		                    <div class="col-sm-6">
		                    </div>
		                </div>
		            </li>';
	    }
        mysqli_close($conn);
	}

	if (isset($_POST['count_creating_remarks'])) {

		$results = mysqli_query($conn, "SELECT Count(finance_transaction.admin_notification) AS count FROM finance_transaction INNER JOIN `user` ON finance_transaction.val_add_by = `user`.user_id INNER JOIN task ON finance_transaction.val_assign_to = task.task_id WHERE finance_transaction.admin_notification != 1");
		while($rows = mysqli_fetch_array($results))
		{
			echo $rows['count'];
		}
		mysqli_close($conn);
	}

	if (isset($_POST['update_creating_remarks'])) {

		$results = mysqli_query($conn, "UPDATE finance_transaction SET admin_notification = 1 WHERE admin_notification = 0");
		if ($results) {
			echo 'success';
		}
		mysqli_close($conn);
	}
	//------------------------------------------------------------------------------------------

	//------------------------------------------------------------------------------------------
	if (isset($_POST['creating_assigned_task'])) {
		if ($user_type == 'Admin') {
			$results = mysqli_query($conn, "SELECT `user`.fname, `user`.mname, `user`.lname, task.task_assign_to, task.task_date_created, task.task_name, task.admin_notification_assigned_task, list.list_name, list.list_id, space.space_name, task.task_id FROM task INNER JOIN `user` ON task.task_created_by = `user`.user_id INNER JOIN list ON task.task_list_id = list.list_id INNER JOIN space ON list.list_space_id = space.space_id WHERE task.admin_notification_assigned_task = 0 ORDER BY task.admin_notification_assigned_task ASC, task.task_created_by DESC");
		} else {
			$results = mysqli_query($conn, "SELECT `user`.fname, `user`.mname, `user`.lname, task.task_assign_to, task.task_date_created, task.task_name, task.user_notification, list.list_name, list.list_id, space.space_name, task.task_id FROM task INNER JOIN `user` ON task.task_created_by = `user`.user_id INNER JOIN list ON task.task_list_id = list.list_id INNER JOIN space ON list.list_space_id = space.space_id WHERE task.user_notification = 0 AND task.task_assign_to LIKE '%$user_id%' ORDER BY task.user_notification ASC, task.task_created_by DESC");
		}
		$row = mysqli_num_rows($results);
		if ($row) {
	        while($rows = mysqli_fetch_array($results))
	        {
	            echo'
		            <li style="cursor: pointer;" id="'.$rows['space_name'].','.$rows['list_name'].','.$rows['list_id'].','.$rows['task_id'].'" onclick="click_assigned_task(this.id)">
		                <div class="row">
		                    <div class="col-sm-6">
		                        <i class="si si-user-follow text-danger"></i>
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
	    } else {
	    	echo'
		            <li>
		                <div class="row">
		                    <div class="col-sm-6">
		                        <i class="si si-user-follow text-danger"></i>
		                        <div class="font-w600 text-white">No Notification for Assigned Task....</div>
		                    </div>

		                    <div class="col-sm-6">
		                    </div>
		                </div>
		            </li>';
	    }
        mysqli_close($conn);
	}

	if (isset($_POST['count_creating_assigned_task'])) {
		if ($user_type == 'Admin') {
			$results = mysqli_query($conn, "SELECT Count(task.admin_notification_assigned_task) AS count FROM task INNER JOIN `user` ON task.task_created_by = `user`.user_id WHERE task.admin_notification_assigned_task != 1");
		} else {
			$results = mysqli_query($conn, "SELECT Count(task.user_notification) AS count FROM task INNER JOIN `user` ON task.task_created_by = `user`.user_id WHERE task.user_notification != 1 AND task.task_assign_to LIKE '%$user_id%'");
		}
		while($rows = mysqli_fetch_array($results))
		{
			echo $rows['count'];
		}
		mysqli_close($conn);
	}

	if (isset($_POST['update_creating_assigned_task'])) {
		if ($user_type == 'Admin') {
			$results = mysqli_query($conn, "UPDATE task SET admin_notification_assigned_task = 1 WHERE admin_notification_assigned_task = 0");
		} else {
			$results = mysqli_query($conn, "UPDATE task SET user_notification = 1 WHERE user_notification = 0 AND task.task_assign_to LIKE '%$user_id%'");
		}
		if ($results) {
			echo 'success';
		}
		mysqli_close($conn);
	}
	//------------------------------------------------------------------------------------------

	//------------------------------------------------------------------------------------------
	// Update each table for every click of the notification

	//Due Date Update when clicking
	if (isset($_POST['click_due_date'])) {
		$task_id = $_POST['task_id'];
		$results = mysqli_query($conn, "UPDATE task SET admin_notification = 1 WHERE task_id = $task_id");
		if ($results) {
			echo 'success';
		}
		mysqli_close($conn);
	}

	//Creating Contacts Update when clicking
	if (isset($_POST['click_creating_contacts'])) {
		$contact_id = $_POST['contact_id'];
		if ($user_type == 'Admin') {
			$results = mysqli_query($conn, "UPDATE contact SET admin_notification = 1 WHERE contact_id = $contact_id");
			if ($results) {
				echo 'admin';
			}
		} else {
			$results = mysqli_query($conn, "UPDATE contact SET user_notification = 1 WHERE contact_id = $contact_id");
			if ($results) {
				echo 'user';
			}
		}
		mysqli_close($conn);
	}

	//Comment Update when clicking
	if (isset($_POST['click_comments'])) {
		$comment_id = $_POST['comment_id'];
		if ($user_type == 'Admin') {
			$results = mysqli_query($conn, "UPDATE comment SET admin_notification = 1 WHERE comment_id = $comment_id");
			if ($results) {
				echo 'success';
			}
		} else {
			$results = mysqli_query($conn, "UPDATE comment SET user_notification = 1 WHERE comment_id = $comment_id");
			if ($results) {
				echo 'success';
			}
		}
		mysqli_close($conn);
	}

	//Remarks Update when clicking
	if (isset($_POST['click_remarks'])) {
		$val_id = $_POST['val_id'];
		$results = mysqli_query($conn, "UPDATE finance_transaction SET admin_notification = 1 WHERE val_id = $val_id");
		if ($results) {
			echo 'success';
		}
		mysqli_close($conn);
	}

	//Assigned Task Update when clicking
	if (isset($_POST['click_assigned_task'])) {
		$task_id = $_POST['task_id'];
		if ($user_type == 'Admin') {
			$results = mysqli_query($conn, "UPDATE task SET admin_notification_assigned_task = 1 WHERE task_id = $task_id");
			if ($results) {
				echo 'success';
			}
		} else {
			$results = mysqli_query($conn, "UPDATE task SET user_notification = 1 WHERE task_id = $task_id");
			if ($results) {
				echo 'success';
			}
		}
		mysqli_close($conn);
	}
	// END Update each table for every click of the notification
	//-----------------------------------------------------------------------------------------
 ?>