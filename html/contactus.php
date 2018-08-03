<?php
 $name = $_POST['name'];
 $organization = $_POST['organization'];
 $email = $_POST['email'];
 $message = $_POST['message'];

 //log into database
 require_once "login.php";
 $conn = new mysqli($hostname,$username,$password,$database);
 if ($conn->connect_error) die($conn->connect_error);

 //create table contactus(name varchar(100) not null, organization varchar(100), email varchar(100), message text);
 $query='insert into contactus values("'.$name.'","'.$organization.'","'.$email.'","'.$message.'")';
 $result = $conn->query($query);
 if(!$result){die($conn->error);}
 $conn->close();

 echo '<script>location.href="index.html";</script>';

?>