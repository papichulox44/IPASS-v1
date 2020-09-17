<?php
    include("../conn.php");
	if(isset($_POST['edit']))
	{
		$field_id = $_POST['edit_field_id'];
		$field_name = $_POST['edit_field_name'];
		mysqli_query($conn,"UPDATE field set field_name = '$field_name' where field_id = '$field_id'");
	}
?>