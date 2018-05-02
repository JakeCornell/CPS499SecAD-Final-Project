<?php
  require 'header.php';
?>
<div class="jumbotron">
<h1>Login</h1>
<?php
  //some code here
  echo "Current time: " . date("Y-m-d h:i:sa")
?>
<form action="admin.php" method="POST" class="form login">
  <!-- Username:<input type="text" class="text_field" name="username" required pattern="\w+" title="Please enter a valid username" onchange="this.setCustomValidity(this.validity.patternMismatch?this.title:);"/> <br>
  Password: <input type="password" class="text_field" name="password" /> <br>
  <button class="button" type="submit">
    Login
  </button> -->

  <div class="form-group" style="width: 18rem;">
    <label for="username">Username</label>
    <input type="text" class="form-control" name="username" required pattern="\w+" title="Please enter a valid username" onchange="this.setCustomValidity(this.validity.patternMismatch?this.title:);"/>
  </div>

  <div class="form-group" style="width: 18rem;">
    <label for="password">Password</label>
    <input type="password" class="form-control" name="password" required />
  </div>

  <button class="btn btn-dark" type="submit">
    Login
  </button>
</form>
</div>


