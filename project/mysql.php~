<?php
  session_start();
  //Security principle: Never use the root database account in the web application
  $mysqli = new mysqli('localhost', 'sp2018secad' /*Database username*/,
                                    'dees'  /*Database password*/, 
                                    'sp2018secad' /*Database name*/);

  if ($mysqli->connect_error) {
      die('Connect Error (' . $mysqli->connect_errno . ') '
              . $mysqli->connect_error);
  }


  function mysql_checklogin_secure($username, $password) {
    global $mysqli;
    
    $prepared_sql = "SELECT * FROM users where approved=1 and enabled=1 and username = ?"
                    . " and password=password(?)";

    if(!$stmt = $mysqli->prepare($prepared_sql))
      echo "Prepared Statement Error";

    $stmt->bind_param("ss", $username, $password);

    if(!$stmt->execute()) echo "Execute Error";

    if(!$stmt->store_result()) echo "Store_result Error";

    if($stmt->num_rows == 1) return true;

    return false;

  }

  function isSuperUser($username){
    global $mysqli;

    $prepared_sql = "SELECT * FROM super_users WHERE username=?";

    if(!$stmt = $mysqli->prepare($prepared_sql))
      echo "Prepared Statement Error";

    $stmt->bind_param("s", $username);

    if(!$stmt->execute()) echo "Execute Error";

    if(!$stmt->store_result()) echo "Store_result Error";

    if($stmt->num_rows == 1) return TRUE;

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
    $sql = "SELECT * FROM posts WHERE enabled=1";
    $result = $mysqli->query($sql);

    if($result->num_rows > 0){
      while ($row = $result->fetch_assoc()) {
        $postid = $row["postid"];
        echo "<div class=\"card border-dark w-75 ml-2 mb-2\">";
        echo "<div class=\"card-header\">User: " . htmlentities($row["owner"]) . "</div>";
        echo "<div class=\"card-body\">";
        echo "<h5 class=\"card-title\">" . htmlentities($row["title"]) . "</h5>";
        echo "<p class=\"card-text\">" . htmlentities($row["content"]) . "</p>";
        echo "<a class=\"card-link\" href='comment.php?postid=$postid'>";
        $sql = "SELECT * FROM comments WHERE postid='$postid';";
        $comments =$mysqli->query($sql);
        if($comments->num_rows > 0){
          echo $comments->num_rows . " comments </a>";
        }else{
          echo "Post your first comment </a>";
        }
        echo "</div>";
        echo "<div class=\"card-footer\">Submitted: ". htmlentities($row["timesub"]) ."</div>";
        echo "</div>";
      }
    }else{
      echo "No post in this blog yet <br>";
    }
  }

  function show_users_posts($username,$rand){
    global $mysqli;
    $sql = "SELECT postid,title,content,timesub FROM posts WHERE owner=? and enabled=1";

    if(!$result = $mysqli->prepare($sql))
      echo "Prepared Statement Error";

    $result->bind_param("s", $username);

    if(!$result->execute()) echo "Execute Error";

    if(!$result->bind_result($postid,$title,$content,$timesub))
      echo "Binding Failed";

    $num_rows = 0;
    while ($row = $result->fetch()) {
      echo "<div class=\"card border-dark w-75 ml-2 mb-2\">";
      echo "<div class=\"card-header\">Post " . $postid . "</div>";
      echo "<div class=\"card-body\">";
      echo "<h4 class=\"card-title\">" . htmlentities($title) . "</h4>";
      echo "<p class=\"card-text\">" . htmlentities($content) . "</p>";
      echo "<a class=\"btn btn mr-1\" href='edit.php?postid=". $postid . "'>Edit</a>";
      echo "<a class=\"btn btn mr-1\" href='disablepost.php?postid=". $postid . "&token=" . $rand . "'>Disable</a>";
      echo "<a class=\"btn btn mr-1\" href='delete.php?postid=". $postid . "&token=" . $rand . "'>Delete</a>";
      echo "</div>";
      echo "<div class=\"card-footer\">Submitted: ". htmlentities($timesub) ."</div>";
      echo "</div>";
      $num_rows++;
    }

    if($num_rows == 0)
      echo "<p>No Posts created.</p>";
    
  }

  function show_disabled_users_posts($username,$rand){
    global $mysqli;
    $sql = "SELECT postid,title,content,timesub FROM posts WHERE owner=? and enabled=0";

    if(!$result = $mysqli->prepare($sql))
      echo "Prepared Statement Error";

    $result->bind_param("s", $username);

    if(!$result->execute()) echo "Execute Error";

    if(!$result->bind_result($postid,$title,$content,$timesub))
      echo "Binding Failed";

    $num_rows = 0;
    while ($row = $result->fetch()) {
      echo "<div class=\"card border-dark w-75 ml-2 mb-2\">";
      echo "<div class=\"card-header\">Post " . $postid . "</div>";
      echo "<div class=\"card-body\">";
      echo "<h5 class=\"card-title\">" . htmlentities($title) . "</h5>";
      echo "<p class=\"card-text\">" . htmlentities($content) . "</p>";
      echo "<a class=\"btn btn-dark mr-1\" href='edit.php?postid=". $postid . "'>Edit</a>";
      echo "<a class=\"btn btn-warning mr-1\" href='enablepost.php?postid=". $postid . "&token=" . $rand . "'>Enable</a>";
      echo "<a class=\"btn btn-danger\" href='delete.php?postid=". $postid . "&token=" . $rand . "'>Delete</a>";
      echo "</div>";
      echo "<div class=\"card-footer\">Submitted: ". htmlentities($timesub) ."</div>";
      echo "</div>";
      $num_rows++;
    }

    if($num_rows == 0)
      echo "<p>No Posts created.</p>";
  }

  function display_singlepost($postid){
    global $mysqli;
    echo "<div class=\"card border-dark mx-2 my-2 py-1\">";
    $prepared_sql = "SELECT title,content,owner FROM posts WHERE postid=? and enabled=1";

    if(!$stmt = $mysqli->prepare($prepared_sql))
      echo "Prepared Statement Error";

    $stmt->bind_param('i', $postid);

    if(!$stmt->execute())
      echo "Execute Failed";

    if(!$stmt->bind_result($title,$content,$owner))
      echo "Binding Failed";

    if($stmt->fetch()){
      echo "<div class=\"card-header\">". htmlentities($title) ."</div>";
      echo "<div class=\"card-body\">";
      echo "<p class=\"card-text\">" . htmlentities($content) . "</p>";
      echo "<p class=\"card-text\">Submitted By: " . htmlentities($owner) . "</p>";
      echo "</div>";
    }
    echo "</div>";
  }

  function display_comments($postid){
    global $mysqli;
    echo "<div class=\"card border-dark mx-2 my-2 py-1\">";
    echo "<div class=\"card-header\">Comments</div>";
    echo "<div class=\"card-body\">";
    $prepared_sql = "SELECT title, content, commenter FROM comments WHERE postid=?;";

    if(!$stmt = $mysqli->prepare($prepared_sql))
      echo "Prepared Statement Error";
    
    $stmt->bind_param('i', $postid);
    
    if(!$stmt->execute())
      echo "Execute Failed";

    $title = NULL;
    $content = NULL;

    if(!$stmt->bind_result($title,$content,$commenter))
      echo "Binding Failed";

    $num_rows = 0;
    while ($stmt->fetch()) {
      echo "<h6 class=\"card-subtitle text-muted pl-2\">Comment title: " . htmlentities($title) . "</h6>";
      echo "<p class=\"card-text pl-2\">" . htmlentities($content) . "<br>";
      echo "Submitted by: " . htmlentities($commenter) . "</p>";
      $num_rows++;
    }

    if($num_rows == 0)
      echo "<p class=\"card-text pl-2\">No comment for this post. Please post your comment</p>";

    echo "</div>";
    echo "</div>";
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

  function new_post($title,$content,$owner){
    global $mysqli;
    $prepared_sql = "INSERT into posts (title,content,timesub,owner,enabled) VALUES (?,?,now(),?,1);";

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

  function exists($username){
    global $mysqli;
    $prepared_sql = "SELECT * FROM users WHERE username=?";

    if(!$stmt = $mysqli->prepare($prepared_sql))
      echo "Prepared Statement Error";

    $stmt->bind_param("s", $username);

    if(!$stmt->execute()) echo "Execute Error";

    if(!$stmt->store_result()) echo "Store_result Error";

    if($stmt->num_rows == 1) return true;

    return false;
  }

  function create_new_user($firstName, $lastName, $username, $password, $email, $phone){
    global $mysqli;
    $prepared_sql = "INSERT into users (username,password,FirstName,LastName,email,phone,approved,enabled) VALUES (?,password(?),?,?,?,?,0,0);";

    if(!$stmt = $mysqli->prepare($prepared_sql))
      echo "Prepared Statement Error";

    $stmt->bind_param('ssssss',  htmlspecialchars($username),
                              htmlspecialchars($password),
                              htmlspecialchars($firstName),
                              htmlspecialchars($lastName),
                              htmlspecialchars($email),
                              htmlspecialchars($phone));

    if(!$stmt->execute()){
      echo "Execute Error";
      return FALSE;
    }

    return TRUE;
  }

  function show_accounts_to_be_approved($rand){
    global $mysqli;
    $sql = "SELECT * FROM users WHERE approved=0 and enabled=0";

    $result = $mysqli->query($sql);

    if($result->num_rows > 0){
      while ($row = $result->fetch_assoc()) {
        $username = htmlentities($row["username"]);
        echo "<div class=\"card border-dark mb-2\">";
        echo "<div class=\"card-header\">User: " . $username . "</div>";
        echo "<div class=\"card-body\">";
        echo "<a class=\"btn btn-dark\" href='approve.php?username=". $username . "&token=" . $rand . "'>Approve</a>";
        echo "</div>";
        echo "</div>";
      }
    }else{
      echo "No users to approve";
    }
  }

  function show_disabled_accounts($rand){
    global $mysqli;
    $sql = "SELECT * FROM users WHERE approved=1 and enabled=0";

    $result = $mysqli->query($sql);

    if($result->num_rows > 0){
      while ($row = $result->fetch_assoc()) {
        $username = htmlentities($row["username"]);
        echo "<div class=\"card border-dark mb-2\">";
        echo "<div class=\"card-header\">User: " . $username . "</div>";
        echo "<div class=\"card-body\">";
        echo "<a class=\"btn btn-dark\" href='enable.php?username=". $username . "&token=" . $rand . "'>Enable</a>";
        echo "</div>";
        echo "</div>";
      }
    }else{
      echo "No users to enable";
    }
  }

  function show_active_accounts($rand){
    global $mysqli;
    $sql = "SELECT * FROM users WHERE approved=1 and enabled=1";

    $result = $mysqli->query($sql);

    if($result->num_rows > 0){
      while ($row = $result->fetch_assoc()) {
        $username = htmlentities($row["username"]);
        echo "<div class=\"card border-dark mb-2\">";
        echo "<div class=\"card-header\">User: " . $username . "</div>";
        echo "<div class=\"card-body\">";
        echo "<a class=\"btn btn-warning\" href='disable.php?username=". $username . "&token=" . $rand . "'>Disable</a>";
        echo "</div>";
        echo "</div>";
      }
    }else{
      echo "No users to enable";
    }
  }

  function approve_account($username){
    global $mysqli;
    $prepared_sql = "UPDATE users SET approved=1,enabled=1 WHERE username=?";

    if(!$stmt = $mysqli->prepare($prepared_sql))
      echo "Prepared Statement Error";

    $stmt->bind_param('s', $username);

    if(!$stmt->execute()){
      echo "Execute Error: Did not Approve User";
      return FALSE;
    } 

    return TRUE;
  }

  function disable_account($username){
    global $mysqli;
    $prepared_sql = "UPDATE users SET enabled=0 WHERE username=?";

    if(!$stmt = $mysqli->prepare($prepared_sql))
      echo "Prepared Statement Error";

    $stmt->bind_param('s', $username);

    if(!$stmt->execute()){
      echo "Execute Error: Did not Diasble account";
      return FALSE;
    } 

    return TRUE;
  }

  function enable_account($username){
    global $mysqli;
    $prepared_sql = "UPDATE users SET enabled=1 WHERE username=?";

    if(!$stmt = $mysqli->prepare($prepared_sql))
      echo "Prepared Statement Error";

    $stmt->bind_param('s', $username);

    if(!$stmt->execute()){
      echo "Execute Error: Did not Enable account";
      return FALSE;
    } 

    return TRUE;
  }

  function enable_post($postid){
    global $mysqli;
    $prepared_sql = "UPDATE posts SET enabled=1 WHERE postid=?";

    if(!$stmt = $mysqli->prepare($prepared_sql))
      echo "Prepared Statement Error";

    $stmt->bind_param('i', $postid);

    if(!$stmt->execute()){
      echo "Execute Error: Did not Enable Post";
      return FALSE;
    } 

    return TRUE;
  }

  function disable_post($postid){
    global $mysqli;
    $prepared_sql = "UPDATE posts SET enabled=0 WHERE postid=?";

    if(!$stmt = $mysqli->prepare($prepared_sql))
      echo "Prepared Statement Error";

    $stmt->bind_param('i', $postid);

    if(!$stmt->execute()){
      echo "Execute Error: Did not Disable Post";
      return FALSE;
    } 

    return TRUE;
  }
?>
