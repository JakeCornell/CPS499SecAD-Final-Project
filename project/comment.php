<?php
  require 'header.php'; 
  require 'mysql.php';
?>

<div class="jumbotron">

<?php

  session_start();

  $postid = $_REQUEST['postid'];
  if(!isset($postid)){
    echo "Bad Request!";
    die();
  }

  function handle_new_comment($postid){
    $title = $_POST['title'];
    $content = $_POST['content'];
    if(isset($_SESSION['user']))
      $commenter = $_SESSION['user'];
    else
      $commenter = "Guest";

    $nocsrftoken = $_POST['nocsrftoken'];
    $sessionnocsrftoken = $_SESSION['nocsrftoken'];

    if(isset($title) and isset($content)){
      //debug
      //echo "Debug->nocsrftoken= $nocsrftoken sessionnocsrftoken= $sessionnocsrftoken";
      if(!isset($nocsrftoken) or ($nocsrftoken != $sessionnocsrftoken)){
        echo "Cross Site Request Forgery Detected";
        die();
      }

      if(new_comment($postid,$title,$content,$commenter))
        echo "<div class=\"alert alert-success\" role=\"alert\">New Comment Added!</div>";
      else
        echo "<div class=\"alert alert-danger\" role=\"alert\">Cannot add comment</div>";
    }
  }

  handle_new_comment($postid);
  display_singlepost($postid);
  display_comments($postid);
  $rand = bin2hex(openssl_random_pseudo_bytes(16));
  $_SESSION['nocsrftoken'] = $rand;
?>

<form action="comment.php?postid=<?php echo $postid; ?>" method="POST" class="ml-2 mr-5">

  <input type="hidden" name="nocsrftoken" value="<?php echo $rand; ?>" />

  <div class="form-group">
    <label for="title">Title</label>
    <input type="text" class="form-control" placeholder="Comment Title" name="title" required/>
  </div>
  <div class="form-group">
    <label for="comment">Comment</label>
    <textarea class="form-control" name="content" required cols="10" rows="5"></textarea>
  </div>
  <button class="btn btn-dark" type="submit">
    Submit Comment
  </button>
</form>
</div>

