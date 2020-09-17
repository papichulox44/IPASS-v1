<?php
session_start();
include_once '../conn.php';

if(!isset($_SESSION['contact']))
{
  header("Location: sign_in.php");
}
  $res = mysqli_query($conn,"SELECT * FROM contact WHERE contact_id=".$_SESSION['contact']);
  $row = mysqli_fetch_array($res);
//$user_id = $row['user_id'];
//mysqli_query($conn, "UPDATE user SET log = '0' WHERE user_id = '$user_id'") or die(mysqli_error());

if(!isset($_SESSION['contact']))
{
	header("Location:sign_in.php");
}
else if(isset($_SESSION['contact'])!="")
{
	header("Location:sign_in.php");
}

if(isset($_GET['logout']))
{
	session_destroy();
	unset($_SESSION['contact']);
	header("Location:sign_in.php");
}
?>