<?php 
  require 'secureauthentication.php';
?>
<h2> Welcome <?php echo $_SESSION['username']; ?> !</h2>
<a href="changepasswordform.php">Change Password</a> | <a href="logout.php">Logout</a> 
