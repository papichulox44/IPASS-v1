<?php
	require_once '../conn.php';
	
	if(ISSET($_REQUEST['id'])){
		$id = $_REQUEST['id'];

		$results = mysqli_query($conn, "SELECT * FROM message WHERE `id`='$id'");
		$rows = mysqli_fetch_array($results);
		
		header("Content-Disposition: attachment; filename=".$rows['attachment']);
		header("Content-Type: application/octet-stream;");
		readfile("../assets/media/message/".$rows['attachment']);
	}
?>