
<html>
      <h1>Login</h1>
<?php
  echo "Current time: " . date("Y-m-d h:i:sa")
?>
          <form action="admin.php" method="POST" class="form login">
                Username:<input type="text" class="text_field" name="username" 
                required pattern="\w+" title="Please enter a valid username" onchange="this.setCustomValidity(this.validity.patternMismatch?this.title:);"/> <br>
                Password: <input type="password" class="text_field" name="password" /> <br>
                <button class="button" type="submit">
                  Login
                </button>
          </form>
  </html>


