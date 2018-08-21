<?php
	//header('Content-Type: application/json'); //this makes it redundant to call json.parse in your javascript that takes the value of echo

	//log into database
	require_once "login.php";
	$conn = new mysqli($hostname,$username,$password,$database);
	if ($conn->connect_error) die($conn->connect_error);

	// $query = "SELECT name FROM keywords"; 	//Changed by Johan 
	$query = "select DISTINCT k.name from study as s INNER JOIN keywords as k on s.name LIKE CONCAT('%',k.name,'%')";
	$result_array = $conn->query($query);
	if (!$result_array) die($conn->error);

	$new_array = array();
	while( $row = mysqli_fetch_assoc( $result_array)){
    		$new_array[] = $row['name']; // Inside while loop
	}
	//convert the PHP array into JSON format, so it works with javascript
	echo json_encode($new_array);
	//echo "<script> var keywords = ". $json_array."; </script>";
	$conn->close();
    ?>
