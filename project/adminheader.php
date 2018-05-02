<?php 
  require 'secureauthentication.php';
?>

<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


<title>Admin Page</title>
</head>
	<body>
		<nav class="navbar navbar-default">
		  <div class="container-fluid">
		    <ul class="nav navbar-nav">
			 <li class="nav-item">
				<a class="nav-link" href="index.php">Home</a>
			</li>
			 <li class="nav-item">
				<a class="nav-link" href="admin.php">User Page</a>
			</li>
			 <li class="nav-item">
				<a class="nav-link" href="newpost.php">New Post</a>
			</li>
			 <li class="nav-item">
				<a class="nav-link" href="changepasswordform.php">Change Password</a>
			</li>
				<?php
					session_start();
					if(!isset($_SESSION['superUser']) or $_SESSION['superUser'] == TRUE){
						echo "<li class=\"nav-item\"><a class=\"nav-link\" href=\"manageAccounts.php\">Manage Accounts</a></li>";
					}
				?>
			 <li class="nav-item">
				<a class="nav-link" href="logout.php">Logout</a>
			</li>

				</ul>
			</div>
		</nav>

