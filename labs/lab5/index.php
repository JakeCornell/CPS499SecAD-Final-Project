<?php
	session_start();    
	if (checklogin($_POST["username"],$_POST["password"])) {
	  $_SESSION["logged"] = TRUE;
    else{
	     echo "<script>alert('Invalid username/password');</script>";
	     unset($_SESSION["logged"]); 
    }
?>
	<h2> Welcome <?php echo $_POST['username']; ?> !</h2>
<?php		
	/*}else{
		echo "<script>alert('Invalid username/password');</script>";
		die();
	}*/
	function checklogin($username, $password) {
		$account = array("admin","1234");
		if (($username== $account[0]) and ($password == $account[1])) 
		  return TRUE;
		else return FALSE;
  	}
?>
