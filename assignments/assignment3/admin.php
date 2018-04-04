<?php 
  require 'secureauthentication.php';
?>
<h2> Welcome <?php echo htmlspecialchars($_POST['username']); ?> !</h2>
<a href="changepasswordform.php">Change Password</a> | <a href="logout.php">Logout</a> 
