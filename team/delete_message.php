<?php
	include("../conn.php");
	if(isset($_POST['del']))
	{
		$id = $_POST['id'];

        $que = mysqli_query($conn, "SELECT attachment FROM message WHERE id = '$id'");                
        $res = mysqli_fetch_array($que); 
		$attachment = $res['attachment'];
        if($attachment == "")
        {
			mysqli_query($conn, "DELETE FROM message WHERE id = '$id'") or die(mysqli_error());
		}
	    else
	    {
			array_map('unlink', glob("../assets/media/message/".$attachment));// remove image
			mysqli_query($conn, "DELETE FROM message WHERE id = '$id'") or die(mysqli_error());
	    }
	}
?>