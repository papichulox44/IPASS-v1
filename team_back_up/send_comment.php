<?php
	require_once '../conn.php';
	include('session.php');
	$user_id = $row['user_id'];
	if(!empty($_FILES['image']))
	{
		//$msg = $_POST['msg'];msg
		$msg = $_POST['msg'];
		$task_id = $_POST['task_id'];
		$image_name = $_FILES['image']['name'];
		$image_temp = $_FILES['image']['tmp_name'];
		$image_size = $_FILES['image']['size'];
		
		$exp = explode(".", $image_name);
		$ext = end($exp);
		$allowed_ext = array('jpg', 'JPG', 'jpeg', 'JPEG', 'png', 'PNG', 'gif', 'docx', 'xlsx', 'csv', 'pdf');
			
		if(in_array($ext, $allowed_ext))
		{
			date_default_timezone_set('Asia/Manila');
			//$todays_date = date("y-m-d H:i:sa"); //  original format
			$date = date("His"); // for unique file name

			$image = $date.'-'.$image_name;
			$location = "../assets/media/comment/".$image;
			if($image_size < 3000000) // Maximum 3 MB
			{
				move_uploaded_file($image_temp, $location);
				mysqli_query($conn, "INSERT INTO `comment` VALUES('', '$task_id', '$user_id', '$msg', NOW(), '$image' ,'')") or die(mysqli_error());
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
	else
	{
		if(isset($_POST['msg'])){	
			$id = $_POST['id'];
			$task_id = $_POST['task_id'];	
			$msg = $_POST['msg'];
			mysqli_query($conn,"INSERT into `comment` (comment_task_id, comment_user_id, comment_message, comment_date) values ('$task_id', '$id', '$msg', NOW())") or die(mysqli_error());
		}
	}
?>