<?php
  session_start();
  include_once '../conn.php';

  if(!isset($_SESSION['user']))
  {
      header("Location: ../index.php");
  }
      $res = mysqli_query($conn,"SELECT * FROM user WHERE user_id=".$_SESSION['user']);
      $row = mysqli_fetch_array($res);
?>