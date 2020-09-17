<?php
	if ($type == "Textarea")
	{
		$sql = "ALTER TABLE `$table_name`
		    ADD (`$new_name` varchar(1000) CHARACTER SET latin2 NOT NULL)";
		if (mysqli_query($conn, $sql))
		{}
		else 
		{
		    echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
		}
	}
	else if ($type == "Date")
	{
		$sql = "ALTER TABLE `$table_name`
		    ADD (`$new_name` date NOT NULL)";
		if (mysqli_query($conn, $sql))
		{}
		else 
		{
		    echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
		}
	}
	else
	{
		$sql = "ALTER TABLE `$table_name`
		    ADD (`$new_name` varchar(50) CHARACTER SET latin2 NOT NULL)";
		if (mysqli_query($conn, $sql))
		{}
		else 
		{
		    echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
		}
	}
?>