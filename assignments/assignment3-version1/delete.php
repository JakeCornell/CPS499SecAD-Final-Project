<?php
	require 'admin.php';

	$postid = $_REQUEST['postid'];
  	if(!isset($postid)){
    	echo "Bad Request!";
    	die();
  	}

  	$nocsrftoken = $_GET['token'];
  	$sessionnocsrftoken = $_SESSION['nocsrftoken'];

  	if(!isset($nocsrftoken) or ($nocsrftoken != $sessionnocsrftoken)){
    	echo "Cross Site Request Forgery Detected";
    	die();
  	}

  	if(delete_post($postid))
  		echo "Post deleted!";
  	else
  		echo "Post could not be deleted!";
?>

