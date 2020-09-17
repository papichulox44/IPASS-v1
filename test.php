<?php 
	$id = $_SESSION['id'];
	include_once 'conn.php';


	// Create function in call query
	$select = '*';
	$condition = 'sampletable WHERE id = $id';

	//call the function


	function query()
	{
		$query = mysqli_query($conn,"Select $select FROM $condition");
	    $row = mysqli_fetch_array($query);	
	}
	
 ?>