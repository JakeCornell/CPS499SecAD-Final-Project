<?php 
  require 'secureauthentication.php';
  $username = $_SESSION['user'];
  $newpassword = $_POST['newpassword'];
  $nocsrftoken = $_POST['nocsrftoken'];
  $sessionnocsrftoken = $_SESSION['nocsrftoken'];


  if(!isset($nocsrftoken) or ($nocsrftoken != $sessionnocsrftoken)){
    echo "Cross Site Request Forgery Detected";
    die();
  }

  if (isset($newpassword)){
    if (mysql_change_users_password($username, $newpassword)){
      echo "<script>Password has been changed</script>";
    }else{
      echo "Failed!";
    }
  } else{
    echo "Cannot change password: username and password is not provided";
  }
?>

<h2> Authenticated and active session!</h2>
<a href="index.php">Admin page </a> | <a href="logout.php">Logout</a> 

