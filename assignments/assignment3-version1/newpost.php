<?php 
  require 'admin.php';

  function handle_new_post(){
    $title = $_POST['title'];
    $content = $_POST['content'];
    $owner = $_POST['owner'];
    $nocsrftoken = $_POST['nocsrftoken'];
    $sessionnocsrftoken = $_SESSION['nocsrftoken'];

    if(isset($title) and isset($content)){
      if(!isset($nocsrftoken) or ($nocsrftoken != $sessionnocsrftoken)){
        echo "Cross Site Request Forgery Detected";
        die();
      }

      if(new_post($title,$content,$owner))
        echo "Post added!";
      else
        echo "Post was not added!";
    }
  }

  handle_new_post();
  $rand = bin2hex(openssl_random_pseudo_bytes(16));
  $_SESSION['nocsrftoken'] = $rand;
?>


<form action="newpost.php" method="POST" class="form login">
                <input type="hidden" name="nocsrftoken" value="<?php echo $rand; ?>" />
                Your Name: <input type="text" name="owner" required/>
                <br>
                Title: <input type="text" name="title" required/>
                <br>
                Content: <textarea name="content" required cols="100" rows="10"></textarea>
                <br>
                <button class="button" type="submit">
                  Submit Post
                </button>
</form>

