<?php
    include("../conn.php");
	if(isset($_POST['edit'])){
		$option_id = $_POST['option_id'];
		$option_name = $_POST['option_name'];
		$colorpicker = $_POST['colorpicker'];		
		mysqli_query($conn,"UPDATE child set child_name = '$option_name', child_color = '$colorpicker' where child_id = '$option_id'");
	}
	if(isset($_POST['edit_finance'])){
		$option_id = $_POST['option_id'];
		$option_name = $_POST['option_name'];
		$colorpicker = $_POST['colorpicker'];		
		mysqli_query($conn,"UPDATE finance_child set child_name = '$option_name', child_color = '$colorpicker' where child_id = '$option_id'");
	}	
	if(isset($_POST['edit_requirements'])){
		$option_id = $_POST['option_id'];
		$option_name = $_POST['option_name'];
		$colorpicker = $_POST['colorpicker'];		
		mysqli_query($conn,"UPDATE requirement_child set child_name = '$option_name', child_color = '$colorpicker' where child_id = '$option_id'");
	}	
?>