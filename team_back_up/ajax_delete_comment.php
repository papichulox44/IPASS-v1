<?php
	include("../conn.php");
	if(isset($_POST['del']))
	{
		$comment_id = $_POST['id'];

        $que = mysqli_query($conn, "SELECT comment_attactment FROM comment WHERE comment_id='$comment_id'");                
        $res = mysqli_fetch_array($que); 
		$attachment_name = $res['comment_attactment'];
        if($attachment_name == "")
        {
			mysqli_query($conn, "DELETE FROM comment WHERE comment_id='$comment_id'") or die(mysqli_error());
		}
	    else
	    {
			array_map('unlink', glob("../assets/media/comment/".$attachment_name));
			mysqli_query($conn, "DELETE FROM comment WHERE comment_id='$comment_id'") or die(mysqli_error());
	    }
	}
	if(isset($_POST['delete_requirement_comment']))
	{
		$comment_id = $_POST['id'];

        $que = mysqli_query($conn, "SELECT comment_attactment FROM requirement_comment WHERE comment_id='$comment_id'");       
        $res = mysqli_fetch_array($que); 
		$attachment_name = $res['comment_attactment'];
        if($attachment_name == "")
        {
			mysqli_query($conn, "DELETE FROM requirement_comment WHERE comment_id='$comment_id'") or die(mysqli_error());
		}
	    else
	    {
			array_map('unlink', glob("../assets/media/requirements/".$attachment_name));
			mysqli_query($conn, "DELETE FROM requirement_comment WHERE comment_id='$comment_id'") or die(mysqli_error());
	    }
	}
?>