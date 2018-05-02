<?php 
  require 'adminheader.php';
  $username = $_SESSION['user'];
  $newpassword = $_POST['newpassword'];
  $nocsrftoken = $_POST['nocsrftoken'];
  $sessionnocsrftoken = $_SESSION['nocsrftoken'];

  //debug
  //echo "Debug->nocsrftoken= $nocsrftoken \$sessionnocsrftoken= $sessionnocsrftoken";

  if(!isset($nocsrftoken) or ($nocsrftoken != $sessionnocsrftoken)){
    echo "Cross Site Request Forgery Detected";
    die();
  }

  if (isset($newpassword)){
    if (mysql_change_users_password($username, $newpassword)){
      echo "<script>alert('Password has been changed');</script>";
    }else{
      echo "Failed!";
    }
  } else{
    echo "Cannot change password: username and password is not provided";
  }

  header("refresh:3;url=admin.php");
  die();
?>

