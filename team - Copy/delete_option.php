<?php
    include("../conn.php");
	if(isset($_POST['del']))
	{
		$field_id = $_POST['edit_field_id'];
		$id = $_POST['option_id'];
		mysqli_query($conn,"DELETE from child where child_id = '$id'");

		$select = mysqli_query($conn, "SELECT * FROM child WHERE child_field_id = '$field_id' ORDER BY child_order ASC");
        $count = 0;
        while($fetch_option = mysqli_fetch_array($select))
        {
            $num = $count++;
            $child_id = $fetch_option['child_id'];
			mysqli_query($conn,"UPDATE child set child_order = '$num' where child_id = '$child_id'");
        }
	}
	if(isset($_POST['del_finance']))
	{
		$id = $_POST['option_id'];
		mysqli_query($conn,"DELETE from finance_child where child_id = '$id'");
	}
	if(isset($_POST['del_requirements']))
	{
		$id = $_POST['option_id'];
		mysqli_query($conn,"DELETE from requirement_child where child_id = '$id'");
	}
?>