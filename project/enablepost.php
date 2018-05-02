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

  if(enable_post($postid)){
    echo "Post Enabled!";
    header("Refresh:0; url=admin.php");
    die();
  }else{
    echo "Post could not be Enabled";
    header("Refresh:0; url=admin.php");
    die();
  }
  
?>

