<?php
  session_start();
  include_once '../conn.php';

  if(!isset($_SESSION['contact']))
  {
      header("Location: sign_in.php");
  }
      $res = mysqli_query($conn,"SELECT * FROM contact WHERE contact_id=".$_SESSION['contact']);
      $row = mysqli_fetch_array($res);
?>