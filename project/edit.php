<?php 
  require 'adminheader.php';
?>
<div class="jumbotron">

<?php

  $postid = $_REQUEST['postid'];
  if(!isset($postid)){
    echo "Bad Request!";
    die();
  }

  handle_update($postid);

  $prepared_sql = "SELECT title, content FROM posts where postid=?";

  if(!$stmt = $mysqli->prepare($prepared_sql))
    echo "Prepared Statement Error";

  $stmt->bind_param('i', $postid);

  if(!$stmt->execute())
    echo "Execute Error";

  $title = NULL;
  $content = NULL;

  if(!$stmt->bind_result($title,$content))
    echo "Binding Failed";

  if(!$stmt->fetch())
    echo "Fetch Failed!";

  function handle_update($postid){
    $title = $_POST['title'];
    $content = $_POST['content'];

    $nocsrftoken = $_POST['nocsrftoken'];
    $sessionnocsrftoken = $_SESSION['nocsrftoken'];

    if(isset($title) and isset($content)){
      //debug
      //echo "Debug->nocsrftoken= $nocsrftoken sessionnocsrftoken= $sessionnocsrftoken";
      if(!isset($nocsrftoken) or ($nocsrftoken != $sessionnocsrftoken)){
        echo "Cross Site Request Forgery Detected";
        die();
      }

      if(update_post($postid,$title,$content))
        echo "<div class=\"alert alert-success\" role=\"alert\">Post Updated!</div>";
      else
        echo "<div class=\"alert alert-danger\" role=\"alert\">Cannot Update Post</div>";
    }
  }

  
  $rand = bin2hex(openssl_random_pseudo_bytes(16));
  $_SESSION['nocsrftoken'] = $rand;
?>

<form action="edit.php?postid=<?php echo $postid; ?>" method="POST" class="ml-2 mr-5">

  <input type="hidden" name="nocsrftoken" value="<?php echo $rand; ?>" />

  <div class="form-group">
    <label for="title">Title</label>
    <input type="text" class="form-control" name="title" value="<?php echo htmlentities($title); ?>" required/>
  </div>

  <div class="form-group">
    <label for="content">Title</label>
    <textarea name="content" class="form-control" required cols="100" rows="10"><?php echo htmlentities($content); ?></textarea>
  </div>

  <button class="btn btn-dark" type="submit">
    Update Post
  </button>
</form>
</div>

