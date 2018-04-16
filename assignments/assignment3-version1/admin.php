<?php 
  require 'secureauthentication.php';
?>

<html>
<head>
	<title>Administrator of My Blog</title>
</head>
	<body>
		<h2> Welcome <?php echo htmlspecialchars($_SESSION['user']); ?> !</h2>
		<a href="index.php">Home</a> | <a href="adminpage.php">Admin Page</a> | <a href="newpost.php">New Post</a> | <a href="changepasswordform.php">Change Password</a> | <a href="logout.php">Logout</a><br>
