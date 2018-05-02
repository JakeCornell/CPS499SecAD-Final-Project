<?php
	require 'header.php';
	require 'mysql.php';

  if(!isset($_SESSION['logged']) or $_SESSION['logged'] == FALSE){
    function handle_new_user(){
      $firstName = $_POST['firstname'];
      $lastName = $_POST['lastname'];
      $username = $_POST['username'];
      $password = $_POST['password'];
      $email = $_POST['email'];
      $phone = $_POST['phonenum'];
      $nocsrftoken = $_POST['nocsrftoken'];
      $sessionnocsrftoken = $_SESSION['nocsrftoken'];

      if(isset($username) and isset($password)){
        if(!isset($nocsrftoken) or ($nocsrftoken != $sessionnocsrftoken)){
          echo "Cross Site Request Forgery Detected";
          die();
        }

        if(!exists($username)){
          if(create_new_user($firstName, $lastName, $username, $password, $email, $phone))
            echo "<script>alert('Account created. Your account will have to be approved before you will be able to login!');</script>";
          else
            echo "<script>alert('Account could not be created');</script>";
        }else{
          echo "<script>alert('Username already in use');</script>";
        }
      }
    }

    handle_new_user();
    $rand = bin2hex(openssl_random_pseudo_bytes(16));
    $_SESSION["nocsrftoken"] = $rand;
  }else{
    echo "<script>alert('Cannot be logged in to reach this page');</script>";
    header("Refresh:0; url=index.php");
    die();
  }
	
?>

<div class="jumbotron">
<h1>Create New Account</h1>
<form action="newAccount.php" method="POST" class="form login">

  <input type="hidden" name="nocsrftoken" value="<?php echo $rand; ?>" />

  <div class="form-row">
    <div class="col">
      <label for="firstname">First Name</label>
      <input class="form-control" type="text" name="firstname" placeholder="First Name" required pattern="\w+" title="Please enter a valid name" onchange="this.setCustomValidity(this.validity.patternMismatch?this.title:);">
    </div>
    <div class="col">
      <label for="lastname">Last Name</label>
      <input class="form-control" type="text" name="lastname" placeholder="Last Name" required pattern="[a-zA-Z ]+" title="Please enter a valid name" onchange="this.setCustomValidity(this.validity.patternMismatch?this.title:);">
    </div>
  </div>

  <div class="form-group mt-2" style="width: 18rem;">
    <label for="username">Username</label>
    <input type="text" class="form-control" name="username" placeholder="username" required pattern="\w+" title="Please enter a valid username" onchange="this.setCustomValidity(this.validity.patternMismatch?this.title:);"/>
  </div>

  <div class="form-group" style="width: 18rem;">
    <label for="password">Password</label>
    <input type="password" class="form-control" name="password" placeholder="password" required pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}" title="Password must have at least 6 characters with 1 number, 1 lowercase, and 1 UPPERCASE" onchange="this.setCustomValidity(this.validity.patternMismatch?this.title: );" />
  </div>

  <div class="form-row">
    <div class="col">
      <label for="email">Email</label>
      <input class="form-control" type="email" name="email" required placeholder="example@example.com"">
    </div>
    <div class="col">
      <label for="phone">Phone</label>
      <input class="form-control" type="text" name="phonenum" placeholder="(555)555-5555" required pattern="[\(]\d{3}[\)]\d{3}[\-]\d{4}" title="Correct Format: (555)555-5555" onchange="this.setCustomValidity(this.validity.patternMismatch?this.title: );">
    </div>
  </div>

  <button class="btn btn-dark mt-3" type="submit">
    Create Account
  </button>
</form>
</div>
