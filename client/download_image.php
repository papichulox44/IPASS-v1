<?php
	require_once '../conn.php';
	
	if(ISSET($_REQUEST['comment_id'])){
		$file = $_REQUEST['comment_id'];

		$results = mysqli_query($conn, "SELECT * FROM comment WHERE `comment_id`='$file'");
		$rows = mysqli_fetch_array($results);
	
		header("Content-Disposition: attachment; filename=".$rows['comment_attactment']);
		header("Content-Type: application/octet-stream;");
		readfile("../assets/media/comment/".$rows['comment_attactment']);
	}
?>