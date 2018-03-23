<?php 
  require 'secureauthentication.php';
  $username = $_REQUEST['username'];
  $newpassword = $_REQUEST['newpassword'];
  $nocsrftoken = $_POST["nocsrftoken"];
  $sessionnocsrftoken = $_SESSION["nocsrftoken"];

  if (isset($username) and isset($newpassword) ){
    if($username!=$_SESSION["username"]){
	echo "Cannot change password: '" . $_SESSION["username"] . "' CANNOT change password for '$username'";
	die();
    }
    echo "changing password for '$username' <br>";
    if (mysql_change_users_password($username, $newpassword)){
      echo "Success!";
    }else{
      echo "Failed!";
    }
  } else{
    echo "Cannot change password: username and password is not provided";
  }

?>
<h2> Authenticated and active session!</h2>
<a href="index.php">Admin page </a> | <a href="logout.php">Logout</a> 
