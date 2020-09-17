<?php
include_once '../conn.php';

if (!($_POST)) { echo 'This has to be a post jackass!'; }

else 
{
	$list_id = $_POST['list_id'];
	$space_id = $_POST['space_id'];
	$sort1 = '';
	parse_str($_POST['sort1'], $sort1);
	
	$query = "SELECT status_id FROM status WHERE status_list_id = '$list_id'";
	$result = $conn->query($query) or die('Error, query failed');
	if ($result->num_rows == 0)
	{
	}
	else 
	{
		foreach($sort1['entry'] as $key=>$value) 
		{
			$updatequery = "UPDATE `status` SET status_order_no = '$key' WHERE status_id = '$value'";	
			$conn->query($updatequery) or die('Error, UPDATE failed!');
		}	
		echo 'an update';
	}
}
?>