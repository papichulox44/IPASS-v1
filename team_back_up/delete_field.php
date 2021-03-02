<?php
    include("../conn.php");
	if(isset($_POST['del']))
	{
		$id = $_POST['field_id'];
		$space_id = $_POST['space_id'];

		$select_space = mysqli_query($conn, "SELECT * FROM space WHERE space_id = '$space_id'");
	    $fetch_select_space = mysqli_fetch_array($select_space);
	    $table_name = $fetch_select_space['space_db_table'];

        $results = mysqli_query($conn, "SELECT * FROM field WHERE field_id = '$id'");
        $rows = mysqli_fetch_array($results);
		$field_name = $rows['field_col_name'];

	    $select_space_table = mysqli_query($conn, "SELECT * FROM $table_name WHERE $field_name != ''"); // no value
	    $count = mysqli_num_rows($select_space_table);
	    if($count == 0) // if 0 then pwd
	    {
	    	if($rows['field_type'] == "Dropdown")
	        {
				mysqli_query($conn,"DELETE from child where child_field_id = '$id'");
			}
			mysqli_query($conn,"DELETE from field where field_id = '$id'");
		    
	        $sql = "ALTER TABLE `$table_name`
	            DROP `$field_name`";
			if (mysqli_query($conn, $sql))
			{}
			else 
			{
			    echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
			}
	    }
	    else
	    {
	    	$select_space_table1 = mysqli_query($conn, "SELECT * FROM $table_name WHERE $field_name != '0000-00-00'"); // check if field == date
	    	$count1 = mysqli_num_rows($select_space_table1);
	    	if($count1 == 0) // if 0 then pwd
	    	{
	    		mysqli_query($conn,"DELETE from field where field_id = '$id'");
		        $sql = "ALTER TABLE `$table_name`
		            DROP `$field_name`";
				if (mysqli_query($conn, $sql))
				{}
				else 
				{
				    echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
				}
	    	}
	    	else
	    	{
	    		echo 'Has';
	    	}
	    }
	}
?>