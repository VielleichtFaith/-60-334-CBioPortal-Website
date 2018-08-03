<!DOCTYPE html>
<link href="../css/drawtable.css" rel="stylesheet">

<?php

 require_once "login.php";
 $conn = new mysqli($hostname,$username,$password,$database);
 if ($conn->connect_error) die($conn->connect_error);
#####
#read serialized array
#####
if (isset($_POST['currentinput']) && isset($_POST['attributes'])){
 $currentstudy = $_POST['currentinput'];
 $columns = $_POST['attributes']; //get study name 

#3. select the study that user wants and display it
#column attributes

 $query = "DESCRIBE patientinfo_".$currentstudy;//patientinfo_+'study'
 $result = $conn->query($query);
 if(!$result){die($conn->error);} 

#rows of patient data per study
 $colarray = $columns;
 $imparray = implode(",", $colarray);
 $query = "select ".$imparray." from patientinfo_".$currentstudy; //patientinfo_+'study'
 $result = $conn->query($query);
 if(!$result){die($conn->error);}
 $conn->close();

##########
#Create CSV file
##########
 $download = array();
 foreach($result as $row){ 		//rows
  $download[] = $row;
 }
 echo '<form action="download.php" method="post">';
 echo '<input type="hidden" name="dl" value=\''.json_encode($download).'\'/>';
 echo '<button type="submit" id="submit" class="btn btn-search">Download File</button>';
 echo '</form>';

###########
#DRAW TABLE
###########

 echo '<div id="table_ajax"><table class="wp-table">';
 
 echo '<thead>';
 foreach($columns as $col){ //column headers
    echo "<th>$col</th>" ;
 }	
 echo '</thead>';

 foreach($result as $row){ 		//rows
	
 echo '<tr>';
   foreach($row as $data){ 	//columns
     echo "<td>$data</td>" ;
	}	
      echo "</tr>";
  }	 
 echo '</table></div>';
###########
#/END DRAW TABLE
###########
}

	
?>
