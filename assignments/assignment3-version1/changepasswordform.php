<?php
  require "admin.php";
?>

<h1>Change the password </h1>
<?php
  echo "Current time: " . date("Y-m-d h:i:sa");
?>
          <form action="changepassword.php" method="POST" class="form login">
                <?php
                  $rand = bin2hex(openssl_random_pseudo_bytes(16));
                  $_SESSION["nocsrftoken"] = $rand;
                ?> 

                <input type="hidden" name="nocsrftoken" value="<?php echo $rand; ?>" />

                <?php echo "Change Password for ' " . $_SESSION['user'] . "'"; ?>
                <br>
                New Password: <input type="password" name="newpassword" 
                required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" 
                title="Password must have at least 6 characters with 1 number, 1 lowercase, and 1 UPPERCASE" 
                onchange="this.setCustomValidity(this.validity.patternMismatch?this.title: );" /> <br>
                <button class="button" type="submit">
                  Change password
                </button>
          </form>
  </html>


