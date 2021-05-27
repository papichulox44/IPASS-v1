<?php
  session_start();
  include_once '../conn.php';

  if(empty(isset($_SESSION['user'])))
  {
      header("Location: ../index.php");
  } else {
    
  }
      $res = mysqli_query($conn,"SELECT * FROM user WHERE user_id=".$_SESSION['user']);
      $row = mysqli_fetch_array($res);
?>
