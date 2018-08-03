<?php
session_start();
if (!isset($_SESSION) || $_SESSION['loggedin'] == false){
 echo '<script>location.href="signin.html";</script>';
}
else{
 echo '<form id="myForm" method="post" action="profile.php"><input type="hidden" name="username" id="username" value="'.$_SESSION['username'].'"/></form>'; //Redirect to signin.html
 echo '<script>document.getElementById("myForm").submit();</script>';
}

?>