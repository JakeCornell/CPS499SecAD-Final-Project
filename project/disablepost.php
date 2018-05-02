<?php
	require 'adminheader.php';

  $postid = $_GET['postid'];
  if(!isset($postid)){
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

  if(disable_post($postid)){
    echo "Post Disabled!";
    header("Refresh:0; url=admin.php");
    die();
  }else{
    echo "Post could not be Disabled";
    header("Refresh:0; url=admin.php");
    die();
  }
  
?>

