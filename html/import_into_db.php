<html>
<body>
<?php
 require_once "login.php";
 $conn = new mysqli($hostname,$username,$password,$database);
 if ($conn->connect_error) die($conn->connect_error);

//get query from python 
$json_params = file_get_contents("php://input");
$query = json_decode($json_params);

//send query to db
$result = $conn->query($query);
if(!$result){
	die($conn->error);
}
$conn->close();

?>
</body>
</html>