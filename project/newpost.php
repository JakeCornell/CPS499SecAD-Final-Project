<?php 
  require 'adminheader.php';
?>

<div class="jumbotron">

<?php
  function handle_new_post(){
    $title = $_POST['title'];
    $content = $_POST['content'];
    $owner = $_SESSION['user'];

    $nocsrftoken = $_POST['nocsrftoken'];
    $sessionnocsrftoken = $_SESSION['nocsrftoken'];

    if(isset($title) and isset($content)){
      //debug
      //echo "Debug->nocsrftoken= $nocsrftoken sessionnocsrftoken= $sessionnocsrftoken";
      if(!isset($nocsrftoken) or ($nocsrftoken != $sessionnocsrftoken)){
        echo "Cross Site Request Forgery Detected";
        die();
      }

      if(new_post($title,$content,$owner))
        echo "<div class=\"alert alert-success\" role=\"alert\">New Post Added!</div>";
      else
        echo "<div class=\"alert alert-danger\" role=\"alert\">Cannot add Post</div>";
    }
  }

  handle_new_post();
  $rand = bin2hex(openssl_random_pseudo_bytes(16));
  $_SESSION['nocsrftoken'] = $rand;
?>

<form action="newpost.php" method="POST" class="ml-2 mr-5">

  <input type="hidden" name="nocsrftoken" value="<?php echo $rand; ?>" />
  
  <div class="form-group">
    <label for="title">Title</label>
    <input type="text" class="form-control" placeholder="Comment Title" name="title" required/>
  </div>
  <div class="form-group">
    <label for="comment">Content</label>
    <textarea name="content" class="form-control" required cols="100" rows="10"></textarea>
  </div>
  <button class="btn btn-dark" type="submit">
    Submit Post
  </button>
</form>
</div>

