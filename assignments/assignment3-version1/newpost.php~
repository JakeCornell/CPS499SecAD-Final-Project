<?php 
  require 'secureauthentication.php';
  require 'mysql.php';

  $username = $_REQUEST['username'];
  $newpassword = $_REQUEST['newpassword'];
  $nocsrftoken = $_POST["nocsrftoken"];
  if(!isset($nocsrftoken) or ($nocsrftoken!=$_SESSION['nocsrftoken'])){
	echo "Cross-site request forgery is detected!";
	die();
  }

  new_post();

?>

<form action="index.php" method="POST" enctype="multipart/form-data">
    Title: <input type="text" name="title" /><br/>
    Text: <textarea name="text" cols="80" rows="5">
        </textarea><br/>

    <input type="submit" name="Add" value="Add">

</form>
