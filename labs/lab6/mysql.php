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
    echo "->mysql.php:Debug>->mysql_checklogin_secure"; //for debug only; delete this line after the complete development
    
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
?>
