<?php
  //some code here
  require "adminheader.php";
?>
<div class="jumbotron">
<h1>Change your password </h1>
<?php
  echo "Current time: " . date("Y-m-d h:i:sa");
?>
<form action="changepassword.php" method="POST" class="form login">
  <?php
    $rand = bin2hex(openssl_random_pseudo_bytes(16));
    $_SESSION["nocsrftoken"] = $rand;
  ?> 

  <input type="hidden" name="nocsrftoken" value="<?php echo $rand; ?>" />

  <div class="form-group" style="width: 18rem;">
    <label for="username">Username</label>
    <input type="text" class="form-control" value="<?php echo $_SESSION['user']; ?>" readonly />
  </div>

  <div class="form-group" style="width: 18rem;">
    <label for="password">Password</label>
    <input type="password" class="form-control" name="newpassword" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" title="Password must have at least 6 characters with 1 number, 1 lowercase, and 1 UPPERCASE" onchange="this.setCustomValidity(this.validity.patternMismatch?this.title: );" />
  </div>

  <button class="btn btn-dark" type="submit">
    Change password
  </button>
</form>
</div>

