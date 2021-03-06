<?php
 	require 'adminheader.php';
?>

<h1 class="display-4">Welcome, <?php echo htmlspecialchars($_SESSION['user']); ?>!</h1>

<?php
    $rand = bin2hex(openssl_random_pseudo_bytes(16));
    $_SESSION["nocsrftoken"] = $rand;

	echo "<div class=\"row\">";
		echo "<div class=\"col-sm-3\">";
		echo "<h3 class=\"ml-2\">Enabled Posts</h3>";
			show_users_posts($_SESSION['user'], $rand);
		echo "</div>";
		echo "<div class=\"col-sm-3\">";
		echo "<h3 class=\"ml-1\">Disabled Posts</h3>";
			show_disabled_users_posts($_SESSION['user'], $rand);
		echo "</div>";
	echo "</div>";
?>
