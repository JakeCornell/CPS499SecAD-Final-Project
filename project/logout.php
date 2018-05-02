<?php 
  session_start();
  session_destroy();

  require 'header.php';

  echo "<p>You have been logged out! </p>";
  echo "<p>Redirecting you now!</p>";

  header("refresh:2;url=index.php");
?>



