<?php
  ini_set("session.cookie_httponly", True);
  ini_set("session.cookie_secure", True);
  session_start();
  //echo "->auth.php";
  require 'mysql.php';
  if (isset($_POST["username"]) and isset($_POST["password"]) ){
    //echo "->auth.php:Debug>has username/password";
    if (mysql_checklogin_secure($_POST["username"],$_POST["password"])) 
      $_SESSION["logged"] = TRUE;
      $_SESSION["logged"] = TRUE; //change
      $_SESSION["logged"] = TRUE; //change
    else{
	     echo "<script>alert('Invalid username/password');</script>";
	     unset($_SESSION["logged"]); 
    }
  }
  if (!isset($_SESSION["logged"] ) or $_SESSION["logged"] != TRUE) {
    echo "<script>alert('You have not login. Please login first');</script>";
    //echo "->auth.php:Debug>You have not login. Please login first";
    header("Refresh:0; url=form.php");
    //header( 'Location: form.php' ) ;
    die();
  }
?>
