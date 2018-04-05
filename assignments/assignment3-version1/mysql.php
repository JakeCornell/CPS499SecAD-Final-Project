<?php
  //Security principle: Never use the root database account in the web application
  $mysqli = new mysqli('localhost', 'sp2018secad' /*Database username*/,
                                    'dees'  /*Database password*/, 
                                    'sp2018secad' /*Database name*/);

  if ($mysqli->connect_error) {
      die('Connect Error (' . $mysqli->connect_errno . ') '
              . $mysqli->connect_error);
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



  function mysql_checklogin_secure($username, $password) {
    global $mysqli;
    $prepared_sql = "SELECT * FROM users where username = ?"
                    . " and password=password(?)";

    if(!$stmt = $mysqli->prepare($prepared_sql))
      echo "Prepared Statement Error";

    $stmt->bind_param("ss", $username, $password);

    if(!$stmt->execute()) echo "Execute Error";

    if(!$stmt->store_result()) echo "Store_result Error";

    if($stmt->num_rows == 1) return TRUE;

    return FALSE;
  }


  function mysql_change_users_password($username, $newpassword) {
    global $mysqli; 
    $prepared_sql = "UPDATE users  SET password=password(?) WHERE username = ?;";

    if(!$stmt = $mysqli->prepare($prepared_sql))
      echo "Prepared Statement Error";

    $stmt->bind_param("ss", $newpassword, $username);

    if(!$stmt->execute()){
	echo "Execute Error:UPDATE users SET password=password(?) WHERE username= ?;";
	return FALSE;
    }
    return TRUE;

  }


  function show_posts(){
	global $mysqli;
	$sql = "SELECT * FROM posts";
	$result = $mysqli->query($sql);
	if($result->num_rows > 0){
	  while($row = $result->fetch_assoc()){
		$postid = $row["id"];
		echo "<h3>Post " . $postid . " - " . $row["title"]. " </h3>";
		echo $row["text"] . "<br>";
		echo "<a href='comment.php?postid=$postid'>";
		$sql = "SELECT * FROM comments WHERE postid='$postid';";
		$comments = $mysqli ->query($sql);
		if ($comments->num_rows > 0){
			echo $comments->num_rows . " comments </a>";
		}else{
			echo "Post your first comment </a>";
		}
	  }
	} else { echo "No post in this blog yet <br>"; }
  }


  function display_comments($postid){
	global $mysqli;
	echo "Comment for Postid= $postid <br>";
	$prepared_sql = "select title, content from comments where postid=?;";
	if(!$stmt = $mysqli->prepare($prepared_sql)){
		echo "Prepared Statement Error";
	}
	$stmt->bind_param('i', $postid);
	if(!$stmt->execute()) echo "Execute failed";
	$title = NULL;
	$content = NULL;
	if(!$stmt->bind_result($title,$content)) echo "Binding failed";
	$num_rows = 0;
	while($stmt->fetch()){
		echo "Comment title:" . htmlentities($title) . "<br>";
		echo htmlentities($content) . "<br>";
		$num_rows++;
	}
       if($num_rows==0) echo "No comment for this post. PLease post your comment";
  }

  function new_post($title,$content,$commenter){
	global $mysqli;
	$preapred_sql = "INSERT into posts (title,content,commenter) VALUES (?,?,?);";
	if(!$stmt = $mysqli->preapre($prepared_sql)){
		echo "Prepared Statement Error";
	}
	$stmt->bind_param("sssi", htmlspecialchars($title), htmlspecialchars($content), htmlspecialchars($commenter));

	if(!$stmt->execute()) { echo "Execute Error"; return FALSE; }
	return TRUE;
  }

  function new_comment($postid,$title,$content,$commenter){
	global $mysqli;
	$preapred_sql = "INSERT into comments (title,content,commenter,postid) VALUES (?,?,?,?);";
	if(!$stmt = $mysqli->preapre($prepared_sql)){
		echo "Prepared Statement Error";
	}
	$stmt->bind_param("sssi", htmlspecialchars($title), htmlspecialchars($content), htmlspecialchars($commenter),$postid);

	if(!$stmt->execute()) { echo "Execute Error"; return FALSE; }
	return TRUE;
  }


?>
