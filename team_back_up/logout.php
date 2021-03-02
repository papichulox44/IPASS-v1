<?php
include ("session.php");
$user_id = $row['user_id'];
mysqli_query($conn, "UPDATE user SET log = '0' WHERE user_id = '$user_id'") or die(mysqli_error());

if(!isset($_SESSION['user']))
{
	header("Location:../index.php");
}
else if(isset($_SESSION['user'])!="")
{
	header("Location:../index.php");
}

if(isset($_GET['logout']))
{
	session_destroy();
	unset($_SESSION['user']);
	header("Location:../index.php");
}
?>