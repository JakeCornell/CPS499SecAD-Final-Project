<?php
	require 'adminheader.php';

	$postid = $_REQUEST['postid'];
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

  	if(delete_post($postid))
  		echo "Post Deleted!";
  	else
  		echo "Post could not be deleted";

    header("refresh:0;url=admin.php");
    die();
?>

