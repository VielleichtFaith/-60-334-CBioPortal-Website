<?php
 session_start();

if (!isset($_SESSION) || $_SESSION['loggedin'] == false){
 $_SESSION['username']=$_POST['username'];
 $_username=$_POST['username'];
 $_password=$_POST['password'];
 $_email=$_POST['email'];

 //log into database
 require_once "login.php";
 $conn = new mysqli($hostname,$username,$password,$database);
 if ($conn->connect_error) die($conn->connect_error);
 
 //check if username exists
 $query = 'select * from users where username="'.$_username.'"';
 $result= $conn->query($query);
 
 if($_POST['signin'] == "Sign In"){ 		//SIGN IN button clicked
   if(mysqli_num_rows($result) >=1){ 		//username exists, check password match
     if (mysqli_fetch_assoc($result)['password'] == $_password){
       $_SESSION['loggedin']=true;		//logged in! 
       if ($_username == "admin"){
           $_SESSION['admin']=true;		//yay admin logged in!
       }
       else{
           $_SESSION['admin']=false;		//oh, not admin
       }
       echo "<script>location.href='profile.html';</script>"; //Redirect to profile.html
     }
     else{						//password doesn't match
       $_SESSION['loggedin']=false;
       echo '<script type="text/javascript">alert("Password is incorrect.");</script>';
       echo '<script>location.href="signin.html";</script>'; //Redirect to signin.html
     } 
   }
   else{				//username does not exist
       $_SESSION['loggedin']=false;
       echo '<script type="text/javascript">alert("Username does not exist.");</script>';
       echo '<script>location.href="signin.html";</script>'; //Redirect to signin.html
   }
 }
 else if($_POST['signin'] == "Sign Up"){ 		//SIGN UP button clicked
   if(mysqli_num_rows($result) >=1){ 		//username exists, check password match
     $_SESSION['loggedin']=false;
     echo '<script type="text/javascript">alert("Username is unavailable.");</script>';
     echo '<script>location.href="signin.html";</script>'; //Redirect to signin.html
   }
   else{					//username is unique, please proceed to insert
     $query = 'insert into users values ("'.$_username.'","'.$_password.'","'.$_email.'")';
     $result= $conn->query($query);
     if (!$result) die($conn->error);
     $_SESSION['loggedin']=true;		//logged in! 
     $_SESSION['admin']=false;			//not admin

     echo '<form id="myForm" method="post" action="profile.php"><input type="hidden" name="username" id="username" value="'.$_SESSION['username'].'"/></form>'; //Redirect to signin.html
     echo '<script>document.getElementById("myForm").submit();</script>';
    }
 }
 $conn->close();
}

?>