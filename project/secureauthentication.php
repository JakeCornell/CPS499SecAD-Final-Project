<?php
  ini_set("session.cookie_httponly", True);
  ini_set("session.cooke_secure", True);
  /*ini_set('session.gc_maxlifetime', 900);
  session_set_cookie_params(900); //set lifetime for 15 mins*/

  session_start();
  //echo "->auth.php";
  require 'mysql.php';
  if (isset($_POST["username"]) and isset($_POST["password"]) ){
    $username = htmlspecialchars($_POST["username"]);
    $password = htmlspecialchars($_POST["password"]);
    //echo "->auth.php:Debug>has username/password";
    if (mysql_checklogin_secure($username,$password)){ 
      $_SESSION["logged"] = TRUE;
      $_SESSION["browser"] = $_SERVER["HTTP_USER_AGENT"];
      $_SESSION["user"] = $username;
      $_SESSION["superUser"] = isSuperUser($username);
    }else{
	     echo "<script>alert('Invalid username/password or your account is not enabled');</script>";
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
  
  if($_SESSION["browser"] != $_SERVER["HTTP_USER_AGENT"]){
    echo "Session hijacking detected!";
    die();
  }
?>

