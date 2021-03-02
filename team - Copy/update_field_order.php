<?php
include_once '../conn.php';

if (!($_POST)) { echo 'This has to be a post jackass!'; }

else 
{
	//$list_id = $_POST['list_id'];
	$space_id = $_POST['space_id'];
	$sort1 = '';
	parse_str($_POST['sort1'], $sort1);
	
	$query = "SELECT field_id FROM field WHERE field_space_id = '$space_id'";
	$result = $conn->query($query) or die('Error, query failed');
	if ($result->num_rows == 0)
	{
	}
	else 
	{
		foreach($sort1['entry'] as $key=>$value) 
		{
			$updatequery = "UPDATE `field` SET field_order = '$key' WHERE field_id = '$value'";	
			$conn->query($updatequery) or die('Error, UPDATE failed!');
		}	
		echo 'an update';
	}
}
?>