<!DOCTYPE html>
<head>   
    <!--Bootstrap core CSS-->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="../js/html5shiv.min.js"></script>
      <script src="../js/respond.min.js"></script>
    <![endif]-->

    <!-- Custom styles for this template -->
    <link href="../css/custom.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../css/font-awesome.min.css" />
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>

    
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../js/ie10-viewport-bug-workaround.js"></script>
    <script src="../js/oppear_1.1.2.min.js"></script>  
	
<script>

//getStudy is called once a study has been selected
function getStudyData(val){ 	 
	 $("#attribute").val([]);
	 
	 $.ajax({
	   type:"post",
	   url:"ajax_populate.php",
	   data:'currentstudy='+val,
	   success: function(data){
		$("#attributes").html(data);
		
		 $.ajax({					//On initial call to a study display all columns
		   type: "POST",
		   url: "drawtable.php",
		   data: $("form").serialize(), 
		   success: function(data){
				$("#tables").html(data);
		   }
		 });
		 
	   }
	 });
	 
}


// this is the class of the submit button
$(document).ready(function() {
    $("#submit").click(function(e) { // changed
	e.preventDefault();
        $.ajax({
           type: "POST",
           url: "drawtable.php",
           data: $("form").serialize(), 
           success: function(data){
		$("#tables").html(data);
	    }
         });
		return false;
    });
});

</script>

</head>
<body>
<?php

#########
#QUERY DB
#########
 if(isset($_POST["myInput"])){
  $userinput = $_POST["myInput"]; //get study name 
 }
 else{
  $userinput = "Prostate Adenocarcinoma";
 }

 require_once "login.php";
 $conn = new mysqli($hostname,$username,$password,$database);
 if ($conn->connect_error) die($conn->connect_error);

//----- Code Commented by Johan ------------------------------------ 
// To reduce the number of studies the user would have to navigate through
#1. get keyword from user's choice of cancer study
 // $query = 'select keyword from keywords where name="'.$userinput.'"';
 // $result = $conn->query($query);
 // if(!$result){die($conn->error);} 
 // $key = $result->fetch_assoc()['keyword']; #use this for step 2


#2. get all studies that match the keyword
 // $query = 'select id from study where id like "%'.$key.'%"';
 // $result = $conn->query($query);
 // if(!$result){die($conn->error);} 
 
 // $length = $result->num_rows;
 // $allstudies = array();	 #use this to tell the user what are available
 // for ($i=0;$i<$length;$i++){
	// $allstudies[] = $result->fetch_assoc()['id'];
 // }
//-----------------------------------------------------------------------

//--------------------- New code by Johan -------------------------------
	$query = "SELECT s.id,s.name FROM study AS s INNER JOIN keywords AS k ON s.name LIKE CONCAT('%',k.name,'%')" .
			 " WHERE k.name = '" . $userinput . "'";

	$result = $conn->query($query);
	if(!$result){die($conn->error);} 	

	$allstudies = array();
	$length = $result->num_rows;
	while($row = $result->fetch_assoc()){
		$allstudies[] = [ "Name" => $row['name'],
						  "Id" => $row['id'] ];
	}	
//----------------------------------------------------------------------
#######
#loading page visuals
#######
echo <<<_END
	<nav class="navbar navbar-default top-bar affix" data-spy="affix" data-offset-top="250" >
    <div class="container" >
        <!- Brand and toggle get grouped for better mobile display ->
        <div class="navbar-header page-scroll">
            <button data-target="#bs-example-navbar-collapse-1" data-toggle="collapse" class="navbar-toggle" type="button">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
             </button>
            <a href="index.html#home" class="navbar-brand">Home</a>
        </div>
        <!- Collect the nav links, forms, and other content for toggling ->
        <div id="bs-example-navbar-collapse-1" class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="index.html#analytics">Analytics</a></li>
                <li><a href="index.html#about">About</a></li>
                <li><a href="index.html#contact">Contact</a></li>
                <li><a href="redirect.php">Profile</a></li>                                
            </ul>
        </div>
        <!- /.navbar-collapse ->
    </div>
    <!- /.container-fluid ->
</nav>
_END;

echo '<section class="banner-sec" id="home">';

echo '<h2 class="search-query"> You requested the studies for : ' . $userinput . '</h2>';
echo '<h3 class="search-query"> Number of studies available : ' . $length . '</h3>';

#form1 start
echo <<<_END

	<form class="study-option" method="post">
		<div class="form-group">
		<select id="currentinput" class="form-control" name="currentinput" 
				onChange="getStudyData(this.value)" required>
		<option>Please select a study.</option>';
_END;

		for ($i=0;$i<$length;$i++){
		echo '<option value="' . $allstudies[$i]['Id'] . '">' . $allstudies[$i]['Name'] . '</option>';
		}
		echo '</select> </div>';

#3. get columns from study
#form1 continued
//echo '<div class="form-group mx-sm-3 mb-2">';		//Keeping the inputs on one line
echo '<div class="form-group">';		//Keeping the inputs on one line
echo '<select id="attributes" class="form-control" name="attributes[]" multiple placeholder="Select Study First" size="3">';
echo '<option>Please select columns</option>';

echo '</select></div><input type="submit" id="submit" class="btn btn-success btn-lg"/></form>';
#form1 end
#########
#AJAX TABLE: DRAWTABLE.PHP
#########
 echo '<div id="tables">';
 require_once 'drawtable.php'; #the dynamic part
 echo '</div>';

?>
</body>
</html>
