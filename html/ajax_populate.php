<!DOCTYPE html>
<?php
 $currentstudy = $_POST['currentstudy'];

 require_once "login.php";
 $conn = new mysqli($hostname,$username,$password,$database);
 if ($conn->connect_error) die($conn->connect_error);
 
 $query = "DESCRIBE patientinfo_".$currentstudy;//patientinfo_+'study'
 $result = $conn->query($query);
 if(!$result){
	  echo '<option>No columns were found!</option>';
	  die($conn->error);
 } 

 $length = $result->num_rows;
 $columns = array();
 for ($i=0;$i<$length;$i++){
	$columns[] = $result->fetch_assoc()['Field'];
 }
 for ($i=0;$i<$length;$i++){
  echo '<option selected value="' . $columns[$i] . '">' . $columns[$i] . '</option>';
 }
?>