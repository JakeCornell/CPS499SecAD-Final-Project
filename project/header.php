<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


<title>My Blog Website</title>
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
			<?php
				session_start();
				if(!isset($_SESSION['logged']) or $_SESSION['logged'] != TRUE){
					echo "<li class=\"nav-item\"><a class=\"nav-link\" href=\"newAccount.php\">Create Account</a></li>";
					echo "<li class=\"nav-item\"><a class=\"nav-link\" href=\"form.php\">Login</a></li>";
				}else{
					echo "<li class=\"nav-item\"><a class=\"nav-link\" href=\"logout.php\">Logout</a></li>";
				} ?>
		    </ul>
		  </div>
		</nav>

