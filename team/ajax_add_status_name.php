<?php
	include_once '../conn.php';
	if(isset($_POST['statusname'])){	
		$arrX = array("bg-gray-darker", "bg-gray-dark", "bg-default-light", "bg-default", "bg-elegance-light", "bg-elegance", "bg-flat-light", "bg-flat", "bg-corporate-light", "bg-corporate", "bg-earth-light", "bg-earth", "bg-success", "bg-warning", "bg-pulse-light", "bg-pulse");
        $randIndex = array_rand($arrX);
        $status_color = $arrX[$randIndex];	
		$statusname = $_POST['statusname'];
        $status_list_id = $_POST['status_list_id'];
		mysqli_query($conn,"INSERT into `status` (status_name, status_color, status_list_id, 	status__date_created) values ('$statusname','$status_color','$status_list_id',NOW())") or die(mysqli_error());
	}
?>