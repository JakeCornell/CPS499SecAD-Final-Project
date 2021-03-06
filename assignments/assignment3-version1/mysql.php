<?php
  session_start();
  $mysqli = new mysqli('localhost', 'sp2018secad' /*Database username*/,
                                    'dees'  /*Database password*/, 
                                    'sp2018secad' /*Database name*/);

  if ($mysqli->connect_error) {
      die('Connect Error (' . $mysqli->connect_errno . ') '
              . $mysqli->connect_error);
  }

  function mysql_checklogin_secure($username, $password) {
    global $mysqli;
    $prepared_sql = "SELECT * FROM users where username = ?"
                    . " and password=password(?)";

    if(!$stmt = $mysqli->prepare($prepared_sql))
      echo "Prepared Statement Error";

    $stmt->bind_param("ss", $username, $password);

    if(!$stmt->execute()) echo "Execute Error";

    if(!$stmt->store_result()) echo "Store_result Error";

    if($stmt->num_rows == 1) return true;

    return false;

  }

  function mysql_checklogin_insecure($username, $password) {
    global $mysqli;
    $sql = "SELECT * FROM users where username=\"" . $username . "\"";
    $sql.= " and password=password(\"". $password . "\");";
    $result = $mysqli->query($sql);
    if ($result->num_rows == 1) {
      return TRUE;
    } 
      return FALSE;

  }


  function mysql_change_users_password($username, $newpassword){
    global $mysqli;  
    $prepared_sql = "UPDATE users SET password=password(?) where username = ?";
    if(!$stmt = $mysqli->prepare($prepared_sql))
      echo "Prepared Statement Error";
    $stmt->bind_param("ss", $newpassword, $username);
    if(!$stmt->execute()){
      echo "Execute Error: UPDATE users SET password=password(?) where username = ?";
      return FALSE;
    } 
    return TRUE;
  }


  function show_posts(){
    global $mysqli;
    $sql = "SELECT * FROM posts";
    $result = $mysqli->query($sql);

    if($result->num_rows > 0){
      while ($row = $result->fetch_assoc()) {
        $postid = $row["postid"];
        echo "<h3>Post " . $postid . " - " . htmlentities($row["title"]) . "</h3>";
        echo "<p>" . htmlentities($row["content"]) . "</p>";
        echo "<a href='comment.php?postid=$postid'>";
        $sql = "SELECT * FROM comments WHERE postid='$postid';";
        $comments =$mysqli->query($sql);
        if($comments->num_rows > 0){
          echo $comments->num_rows . " comments </a>";
        }else{
          echo "Post your first comment </a>";
        }
      }
    }else{
      echo "No post in this blog yet <br>";
    }
  }

  function admin_posts(){
    global $mysqli;
    $sql = "SELECT * FROM posts";
    $result = $mysqli->query($sql);
    $rand = bin2hex(openssl_random_pseudo_bytes(16));
    $_SESSION["nocsrftoken"] = $rand;

    if($result->num_rows > 0){
      while ($row = $result->fetch_assoc()) {
        $postid = $row["postid"];
        echo "<h3>Post " . $postid . " - " . htmlentities($row["title"]) . "</h3>";
        echo "<p>" . htmlentities($row["content"]) . "</p><br>";
        echo "<a href='edit.php?postid=". $postid . "'>Edit</a> | ";
        echo "<a href='delete.php?postid=". $postid . "&token=" . $rand . "'>Delete</a>";
      }
    }else{
      echo "No post in this blog yet <br>";
    }
  }


  function display_comments($postid){
    global $mysqli;
    echo "Comments for Postid= $postid <br>";
    $prepared_sql = "SELECT title, content FROM comments WHERE postid=?;";

    if(!$stmt = $mysqli->prepare($prepared_sql))
      echo "Prepared Statement Error";
    
    $stmt->bind_param('i', $postid);
    
    if(!$stmt->execute())
      echo "Execute Failed";

    $title = NULL;
    $content = NULL;

    if(!$stmt->bind_result($title,$content))
      echo "Binding Failed";

    $num_rows = 0;
    while ($stmt->fetch()) {
      echo "<br>Comment title: " . htmlentities($title) . "<br>";
      echo htmlentities($content) . "<br><br>";
      $num_rows++;
    }

    if($num_rows == 0)
      echo "No comment for this post. Please post your comment";
  }


  function new_comment($postid, $title, $content, $commenter){
    global $mysqli;
    $prepared_sql = "INSERT into comments (title,content,commenter,postid) VALUES (?,?,?,?);";

    if(!$stmt = $mysqli->prepare($prepared_sql))
      echo "Prepared Statement Error";

    $stmt->bind_param('sssi', htmlspecialchars($title),
                              htmlspecialchars($content),
                              htmlspecialchars($commenter), $postid);

    if(!$stmt->execute()){
      echo "Execute Error";
      return FALSE;
    }

    return TRUE;
  }



  function display_singlepost($postid){
    global $mysqli;
    echo "Post for id = $postid <br>";
    $prepared_sql = "SELECT * FROM posts WHERE postid=?";
    if(!$stmt = $mysqli->prepare($prepared_sql))
      echo "Prepared Statement Error";
    $stmt->bind_param('i', $postid);

    if(!$stmt->execute())
      echo "Execute Failed";

    if(!$stmt->bind_result($postid,$title,$content,$time,$owner))
      echo "Binding Failed";

    if($stmt->fetch()){
      echo "Post title: " . htmlentities($title) . "<br>";
      echo htmlentities($content) . "<br>";
      echo "Submitted By: " . htmlentities($owner) . "<br><br>";
    }

  }

  
  function new_post($title,$content,$owner){
    global $mysqli;
    $prepared_sql = "INSERT into posts (title,content,timesub,owner) VALUES (?,?,now(),?);";

    if(!$stmt = $mysqli->prepare($prepared_sql))
      echo "Prepared Statement Error";

    $stmt->bind_param('sss',  htmlspecialchars($title),
                              htmlspecialchars($content),
                              htmlspecialchars($owner));

    if(!$stmt->execute()){
      echo "Execute Error";
      return FALSE;
    }

    return TRUE;
  }
  

  function update_post($postid,$title,$content){
    global $mysqli;
    $prepared_sql = "UPDATE posts SET title=?, content=? where postid = ?";

    if(!$stmt = $mysqli->prepare($prepared_sql))
      echo "Prepared Statement Error";

    $stmt->bind_param('ssi',  htmlspecialchars($title), 
                              htmlspecialchars($content), 
                              $postid);

    if(!$stmt->execute()){
      echo "Execute Error: Did not update post";
      return FALSE;
    } 

    return TRUE;
  }


  function delete_post($postid){
    global $mysqli;
    $prepared_sql = "DELETE FROM posts WHERE postid=?";

    if(!$stmt = $mysqli->prepare($prepared_sql))
      echo "Prepared Statement Error";

    $stmt->bind_param('i', $postid);

    if(!$stmt->execute()){
      echo "Execute Error: Did not delete() post";
      return FALSE;
    } 

    return TRUE;
  }

?>
