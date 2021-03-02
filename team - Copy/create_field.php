<?php
	require_once '../conn.php';
	include('session.php');
	//$user_id = $row['user_id'];
	if(isset($_POST['create']))
	{
		$space_id = $_POST['space_id'];
		$type = $_POST['type'];
		
		$select_space = mysqli_query($conn, "SELECT * FROM space WHERE space_id = '$space_id'");
	    $fetch_select_space = mysqli_fetch_array($select_space);
	    $table_name = $fetch_select_space['space_db_table'];
		
		date_default_timezone_set('Asia/Manila');
        $todays_date = date("y-m-d H:i:sa"); //  original format
        $length = 2;
        $random =  substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'),1,$length);
        $rand = "_".date("s").$random; // for unique file name

		if(isset($_POST['textarea_name']))
		{	
			$name = $_POST['textarea_name'];
            $new_name = strtolower(str_replace(" ", "_", $name)).$rand;
			$select = mysqli_query($conn, "SELECT * FROM field WHERE field_space_id = '$space_id'");
			$count = mysqli_num_rows($select); 
			if($count == 0)
			{
				mysqli_query($conn,"INSERT into `field` (field_order, field_space_id, field_type, field_name, field_date_create, field_col_name) values ('0', '$space_id', '$type', '$name', NOW(), '$new_name')") or die(mysqli_error());
			}
			else
			{
				mysqli_query($conn,"INSERT into `field` (field_order, field_space_id, field_type, field_name, field_date_create, field_col_name) values ('$count', '$space_id', '$type', '$name', NOW(), '$new_name')") or die(mysqli_error());
			}
			include('create_column.php');
		}
		if(isset($_POST['text_name']))
		{
			$name = $_POST['text_name'];
            $new_name = strtolower(str_replace(" ", "_", $name)).$rand;
			$select = mysqli_query($conn, "SELECT * FROM field WHERE field_space_id = '$space_id'");
			$count = mysqli_num_rows($select); 
			if($count == 0)
			{
				mysqli_query($conn,"INSERT into `field` (field_order, field_space_id, field_type, field_name, field_date_create, field_col_name) values ('0', '$space_id', '$type', '$name', NOW(), '$new_name')") or die(mysqli_error());
			}
			else
			{
				mysqli_query($conn,"INSERT into `field` (field_order, field_space_id, field_type, field_name, field_date_create, field_col_name) values ('$count', '$space_id', '$type', '$name', NOW(), '$new_name')") or die(mysqli_error());
			}
			include('create_column.php');
		}
		if(isset($_POST['email_name']))
		{
			$name = $_POST['email_name'];
            $new_name = strtolower(str_replace(" ", "_", $name)).$rand;
			$select = mysqli_query($conn, "SELECT * FROM field WHERE field_space_id = '$space_id'");
			$count = mysqli_num_rows($select); 
			if($count == 0)
			{
				mysqli_query($conn,"INSERT into `field` (field_order, field_space_id, field_type, field_name, field_date_create, field_col_name) values ('0', '$space_id', '$type', '$name', NOW(), '$new_name')") or die(mysqli_error());
			}
			else
			{
				mysqli_query($conn,"INSERT into `field` (field_order, field_space_id, field_type, field_name, field_date_create, field_col_name) values ('$count', '$space_id', '$type', '$name', NOW(), '$new_name')") or die(mysqli_error());
			}
			include('create_column.php');
		}
		if(isset($_POST['dropdown_name']))
		{
			$name = $_POST['dropdown_name'];
            $new_name = strtolower(str_replace(" ", "_", $name)).$rand;
			$select = mysqli_query($conn, "SELECT * FROM field WHERE field_space_id = '$space_id'");
			$count = mysqli_num_rows($select); 
			if($count == 0)
			{
				mysqli_query($conn,"INSERT into `field` (field_order, field_space_id, field_type, field_name, field_date_create, field_col_name) values ('0', '$space_id', '$type', '$name', NOW(), '$new_name')") or die(mysqli_error());
			}
			else
			{
				mysqli_query($conn,"INSERT into `field` (field_order, field_space_id, field_type, field_name, field_date_create, field_col_name) values ('$count', '$space_id', '$type', '$name', NOW(), '$new_name')") or die(mysqli_error());
			}
			include('create_column.php');
		}
		if(isset($_POST['phone_name']))
		{
			$name = $_POST['phone_name'];
            $new_name = strtolower(str_replace(" ", "_", $name)).$rand;
			$select = mysqli_query($conn, "SELECT * FROM field WHERE field_space_id = '$space_id'");
			$count = mysqli_num_rows($select); 
			if($count == 0)
			{
				mysqli_query($conn,"INSERT into `field` (field_order, field_space_id, field_type, field_name, field_date_create, field_col_name) values ('0', '$space_id', '$type', '$name', NOW(), '$new_name')") or die(mysqli_error());
			}
			else
			{
				mysqli_query($conn,"INSERT into `field` (field_order, field_space_id, field_type, field_name, field_date_create, field_col_name) values ('$count', '$space_id', '$type', '$name', NOW(), '$new_name')") or die(mysqli_error());
			}
			include('create_column.php');
		}
		if(isset($_POST['date_name']))
		{
			$name = $_POST['date_name'];
            $new_name = strtolower(str_replace(" ", "_", $name)).$rand;
			$select = mysqli_query($conn, "SELECT * FROM field WHERE field_space_id = '$space_id'");
			$count = mysqli_num_rows($select); 
			if($count == 0)
			{
				mysqli_query($conn,"INSERT into `field` (field_order, field_space_id, field_type, field_name, field_date_create, field_col_name) values ('0', '$space_id', '$type', '$name', NOW(), '$new_name')") or die(mysqli_error());
			}
			else
			{
				mysqli_query($conn,"INSERT into `field` (field_order, field_space_id, field_type, field_name, field_date_create, field_col_name) values ('$count', '$space_id', '$type', '$name', NOW(), '$new_name')") or die(mysqli_error());
			}
			include('create_column.php');
		}
		if(isset($_POST['number_name']))
		{
			$name = $_POST['number_name'];
            $new_name = strtolower(str_replace(" ", "_", $name)).$rand;
			$select = mysqli_query($conn, "SELECT * FROM field WHERE field_space_id = '$space_id'");
			$count = mysqli_num_rows($select); 
			if($count == 0)
			{
				mysqli_query($conn,"INSERT into `field` (field_order, field_space_id, field_type, field_name, field_date_create, field_col_name) values ('0', '$space_id', '$type', '$name', NOW(), '$new_name')") or die(mysqli_error());
			}
			else
			{
				mysqli_query($conn,"INSERT into `field` (field_order, field_space_id, field_type, field_name, field_date_create, field_col_name) values ('$count', '$space_id', '$type', '$name', NOW(), '$new_name')") or die(mysqli_error());
			}
			include('create_column.php');
		}
		if(isset($_POST['radio_name']))
		{
			$name = $_POST['radio_name'];
            $new_name = strtolower(str_replace(" ", "_", $name)).$rand;
			$select = mysqli_query($conn, "SELECT * FROM field WHERE field_space_id = '$space_id'");
			$count = mysqli_num_rows($select); 
			if($count == 0)
			{
				mysqli_query($conn,"INSERT into `field` (field_order, field_space_id, field_type, field_name, field_date_create, field_col_name) values ('0', '$space_id', '$type', '$name', NOW(), '$new_name')") or die(mysqli_error());
			}
			else
			{
				mysqli_query($conn,"INSERT into `field` (field_order, field_space_id, field_type, field_name, field_date_create, field_col_name) values ('$count', '$space_id', '$type', '$name', NOW(), '$new_name')") or die(mysqli_error());
			}
			include('create_column.php');
		}
	}
?>