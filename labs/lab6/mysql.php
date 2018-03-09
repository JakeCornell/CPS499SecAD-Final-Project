<?php
  echo "->mysql.php"; //for debug only; delete this line after the complete development
  //Security principle: Never use the root database account in the web application
  $mysqli = new mysqli('localhost', 'sp2018secad' /*Database username*/,
                                    'dees'  /*Database password*/, 
                                    'sp2018secad' /*Database name*/);

  if ($mysqli->connect_error) {
      die('Connect Error (' . $mysqli->connect_errno . ') '
              . $mysqli->connect_error);
  }
  echo "->mysql.php:Debug>Connected to the database"; //for debug only; delete this line after the complete development
  function mysql_checklogin_insecure($username, $password) {
    global $mysqli;
    echo "->mysql.php:Debug>->mysql_checklogin_insecure"; //for debug only; delete this line after the complete development
    $sql = "SELECT * FROM users where username=\"" . $username . "\"";
    $sql.= " and password=password(\"". $password . "\");";
    echo "->mysql.php:Debug>sql=$sql"; //for debug only; delete this line after the complete development
    $result = $mysqli->query($sql);
    if ($result->num_rows == 1) {
    	echo "->mysql.php:Debug>:username/password found"; //for debug only; delete this line after the complete development
      return TRUE;
    } else {
      echo "->mysql.php:Debug>:username/password NOT found"; //for debug only; delete this line after the complete development
    }
    return FALSE;

  }



function mysql_checklogin_secure($username, $password) {
    global $mysqli;
    echo "->mysql.php:Debug>->mysql_checklogin_insecure"; //for debug only; delete this line after the complete development
    $prepared_sql = "SELECT * FROM users where username=?";
    . " and password=password(?);";
    //echo "->mysql.php:Debug>sql=$sql"; //for debug only; delete this line after the complete development
    //$result = $mysqli->query($sql);
    if(!$stmt = $mysql->prepare($prepared_sql)) echo "Prepared Statment Error";
    $stmt->bind_param("ss",$username, $password);
    if(!$stmt->execute()) echo "Execute Error";
    if(!$stmt->store_result()) echo "Store Error";
    $result = $stmt;

    if ($result->num_rows == 1) {
    	echo "->mysql.php:Debug>:username/password found"; //for debug only; delete this line after the complete development
      return TRUE;
    } else {
      echo "->mysql.php:Debug>:username/password NOT found"; //for debug only; delete this line after the complete development
    }
    return FALSE;

  }
?>
