
<html>
      <h1>Login</h1>
<?php
  //some code here
  echo "Current time: " . date("Y-m-d h:i:sa")
?>
          <form action="index.php" method="POST" class="form login">
                Username:<input type="text" class="text_field" name="username" 
			required pattern="\w+"
			title="Please enter a valid username"
			onchange="this.setCustomValidity(this.validity.patternMismatch ? this.title : '');" />
			 <br>
                Password: <input type="password" class="text_field" name="password"
			required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}"
			title="Password muist have at least 6 characters with 1 number. 1 lowercase, and 1 UPPERCASE"
			onchange="this.setCustomValidity(this.validity.patternMismatch ? this.title : '');" /> <br>
                <button class="button" type="submit">
                  Login
                </button>
          </form>
  </html>

