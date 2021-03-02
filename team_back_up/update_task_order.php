<?php
include_once '../conn.php';

if (!($_POST)) { echo 'This has to be a post jackass!'; }

else {
	$list_id = $_POST['list_id'];
	$total_status = $_POST['total_status'];

	$query = "SELECT task_id FROM task WHERE task_list_id = '$list_id'";
	$result = $conn->query($query) or die('Error, query failed');
	if ($result->num_rows == 0)
	{
	}
	else 
	{
		$stacks = array();
		$que = mysqli_query($conn, "SELECT * FROM status WHERE status_list_id='$list_id'");	
	    while($res = mysqli_fetch_array($que))
	    {
			$add_array = $res['status_id'];
			array_push($stacks, $add_array);
		} 

		for ($x = 1; $x <= $total_status; $x++) 
		{
			$sort_str = "sort".$x;
			$sort = "sort$x";
			$ww = "sort";
			$$ww = '';
			parse_str($_POST[$sort_str], $$ww);

			$y = $x - 1;
			$id_status = $stacks[$y];
			foreach($$ww['entry'] as $key=>$value)
			{
				$updatequery = "UPDATE `task` SET task_order_no = '$key', task_status_id = '$id_status' WHERE task_id = '$value' AND task_list_id = '$list_id'";	
				$conn->query($updatequery) or die('Error, UPDATE failed!');
			}
		}
	}
}
?>