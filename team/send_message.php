<?php
	require_once '../conn.php';
	if(!empty($_FILES['image']))
	{
		$message = $_POST['message'];
		$user_id = $_POST['user_id'];
		$reciever_id = $_POST['reciever_id'];
		$code = $user_id .','. $reciever_id;
		$image_name = $_FILES['image']['name'];
		$image_temp = $_FILES['image']['tmp_name'];
		$image_size = $_FILES['image']['size'];
		
		$exp = explode(".", $image_name);
		$ext = end($exp);
		$allowed_ext = array('jpg', 'jpeg', 'png', 'gif', 'docx', 'xlsx' , 'xls' , 'csv' , 'pdf');
			
		if(in_array($ext, $allowed_ext))
		{
			date_default_timezone_set('Asia/Manila');
			//$todays_date = date("y-m-d H:i:sa"); //  original format
			$date = date("ymd-His"); // for unique file name

			$image = $date.' '.$image_name;
			$location = "../assets/media/message/".$image;
			if($image_size < 3000000) // Maximum 3 MB
			{
				move_uploaded_file($image_temp, $location);
				mysqli_query($conn, "INSERT INTO `message` VALUES('', '$user_id', '$message', '$reciever_id', NOW(), '$code', '$image', '1')") or die(mysqli_error());
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
		$reciever_id = $_POST['reciever_id'];
		$user_id = $_POST['user_id'];
		$code = $_POST['code'];
		$message = $_POST['message'];
		mysqli_query($conn,"INSERT into `message` (sender_id, message, reciever_id, chat_date, code, attachment, status) values ('$user_id', '$message', '$reciever_id', NOW(), '$code', '', '1')") or die(mysqli_error());
	}
?>