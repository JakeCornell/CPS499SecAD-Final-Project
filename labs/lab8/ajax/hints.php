<?php 
  require 'mysql.php';
	// get the q parameter from URL
	$query = $_REQUEST["q"];
	if(!isset($query)) exit; 
	$prepared_sql = "SELECT city, state, zip  FROM zips WHERE city LIKE ?;";
	if(!$stmt = $mysqli->prepare($prepared_sql))
	      echo "Prepared Statement Error";
	$query = "%".$query."%";     
  $stmt->bind_param('s', $query); 
  if(!$stmt->execute()) echo "Execute failed ";
  $city = NULL;
  $state = NULL;
  $zip = NULL;
  if(!$stmt->bind_result($city,$state,$zip)) echo "Binding failed ";
  //this will bind each row with the variables
  $num_rows = 0;
  while($stmt->fetch()){
    echo htmlentities($city) . ", " . htmlentities($state) . ", " . htmlentities($zip) . "<br>";
    $num_rows++;
  }
  if($num_rows==0) echo "No matching";
?>

