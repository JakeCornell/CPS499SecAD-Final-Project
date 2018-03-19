
<html>
      <h1>Change the password </h1>
<?php
  //some code here
  require "secureauthentication.php";
  echo "Current time: " . date("Y-m-d h:i:sa");

?>
          <form action="changepassword.php" method="POST" class="form login">
                Username: <input type="text" name="username" />  <br>
                New Password: <input type="password" name="newpassword" /> <br>
                <button class="button" type="submit">
                  Change password
                </button>
          </form>
  </html>

