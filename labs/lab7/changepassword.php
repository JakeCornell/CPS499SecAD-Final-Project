<?php 
  require 'secureauthentication.php';
  $username = $_REQUEST['username'];
  $newpassword = $_REQUEST['newpassword'];
  if (isset($username) and isset($newpassword) ){
    if($username!=$_SESSION["username"]){
	echo "Cannot change";
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
