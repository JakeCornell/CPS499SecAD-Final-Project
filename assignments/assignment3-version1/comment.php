<?php
  require 'mysql.php';
  require 'header.php'; 
  
  session_start();

  $postid = $_REQUEST['postid'];
  if(!isset($postid)){
    echo "Bad Request!";
    die();
  }

  function handle_new_comment($postid){
    $title = $_POST['title'];
    $content = $_POST['content'];
    $commenter = $_POST['commenter'];

    $nocsrftoken = $_POST['nocsrftoken'];
    $sessionnocsrftoken = $_SESSION['nocsrftoken'];

    if(isset($title) and isset($content)){
      if(!isset($nocsrftoken) or ($nocsrftoken != $sessionnocsrftoken)){
        echo "Cross Site Request Forgery Detected";
        die();
      }

      if(new_comment($postid,$title,$content,$commenter))
        echo "Comment added!";
      else
        echo "Cannot add comment!";
    }
  }

  handle_new_comment($postid);
  display_singlepost($postid);
  display_comments($postid);
  $rand = bin2hex(openssl_random_pseudo_bytes(16));
  $_SESSION['nocsrftoken'] = $rand;
?>

<form action="comment.php?postid=<?php echo $postid; ?>" method="POST" class="form login">
                <input type="hidden" name="nocsrftoken" value="<?php echo $rand; ?>" />
                Your Name: <input type="text" name="commenter" required/>
                <br>
                Title: <input type="text" name="title" required/>
                <br>
                Content: <textarea name="content" required cols="100" rows="10"></textarea>
                <br>
                <button class="button" type="submit">
                  Submit Comment
                </button>
</form>

