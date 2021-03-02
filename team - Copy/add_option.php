<?php
	require_once '../conn.php';
	include('session.php');

	if(isset($_POST['edit_field_id']))
	{
		$color_array = array("#d60606","#b90453","#ca0b85","#ce19c1","#AD00A1","#9000AD","#5600AD","#440386","#330365","#0015AD","#005FAD","#0088AD","#00ADA9","#00AD67","#038e56","#05981d","#017514","#00AD1D","#6FAD00","#8ad00c","#bfc304","#AD9000","#d47604","#e67f01","#AD5F00","#827a71","#7da6ab","#5C797C","#3a4e50","#000000");
		$randIndex = array_rand($color_array);
        $option_color = $color_array[$randIndex];

		$id = $_POST['edit_field_id'];
		$select = mysqli_query($conn, "SELECT * FROM child WHERE child_field_id = '$id'");
		$count = mysqli_num_rows($select); 
		if($count == 0)
		{
			mysqli_query($conn,"INSERT into child (child_name, child_field_id, child_order, child_color) values ('', '$id', '0', '$option_color')") or die(mysqli_error());
		}
		else
		{
			mysqli_query($conn,"INSERT into child (child_name, child_field_id, child_order, child_color) values ('', '$id', '$count', '$option_color')") or die(mysqli_error());
		}
	}
?>