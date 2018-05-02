<?php
	require 'adminheader.php';

  if(isset($_SESSION['superUser']) and $_SESSION['superUser'] == TRUE){
    $username = $_GET['username'];
    if(!isset($username)){
      echo "Bad Request!";
      die();
    }

    $nocsrftoken = $_GET['token'];
    $sessionnocsrftoken = $_SESSION['nocsrftoken'];

    //echo "Debug->nocsrftoken= $nocsrftoken \$sessionnocsrftoken= $sessionnocsrftoken";
    if(!isset($nocsrftoken) or ($nocsrftoken != $sessionnocsrftoken)){
      echo "Cross Site Request Forgery Detected";
      die();
    }

    if(approve_account($username)){
      echo "User Approved!";
      header("Refresh:0; url=manageAccounts.php");
      die();
    }else{
      echo "User could not be approved";
      header("Refresh:0; url=manageAccounts.php");
      die();
    }
  }else{
    echo "<script>alert('Must be a Super User to access this page');</script>";
    header("Refresh:0; url=admin.php");
    die();
  }
?>

