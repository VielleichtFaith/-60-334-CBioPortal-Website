<?php
	
	require_once "login.php";
	
	function getTopTypes($conn){
		$query = "SELECT (CASE WHEN name LIKE '%prostate%' THEN 'Prostate'
			 WHEN name LIKE '%breast%' THEN 'Breast'
			 WHEN name LIKE '%lung%' THEN 'Lung'
			 WHEN name LIKE '%lymph%' THEN 'Lymphoid'
			 WHEN name LIKE '%stomach%' or name LIKE '%esopha%' THEN 'Esophagus/Stomach'
			 WHEN name like '%pancre%' or name like '%insu%' THEN 'Pancreas'
			 WHEN name like '%bladder%' or name like '%urothe%' THEN 'Bladder'
			 WHEN name like '%brain%' or name like 'glio%' or name like '%medull%' or name like '%ngs%' THEN 'Brain' END) as type,
			COUNT(*) as count      
			FROM study
			GROUP BY (CASE WHEN name LIKE '%prostate%' THEN 'Prostate'
						 WHEN name LIKE '%breast%' THEN 'Breast'
						 WHEN name LIKE '%lung%' THEN 'Lung'
						 WHEN name LIKE '%lymph%' THEN 'Lymphoid'
						 WHEN name LIKE '%stomach%' or name LIKE '%esopha%' THEN 'Esophagus/Stomach'
						 WHEN name like '%pancre%' or name like '%insu%' THEN 'Pancreas'
						 WHEN name like '%bladder%' or name like '%urothe%' THEN 'Bladder'
						 WHEN name like '%brain%' or name like 'glio%' or name like '%medull%' or name like '%ngs%' THEN 'Brain' END)
			HAVING type is not NULL";	
			 
		$result = $conn->query($query);

		if(!$result) die("Problem with query");
		
		$data = array();
		while($row = $result->fetch_assoc()){
			$object = [ "Type" => $row['type'] ,
						"Count" => $row['count'] ];
			array_push($data,$object);
		}	
		
		header("application/json; charset=utf-8");
		echo json_encode($data);
		
	}	
	
	
	function getTopStudies($conn){
		
		$conn_schema = new mysqli("localhost","root","","information_schema");
		
		if($conn_schema->connect_error) die($conn_schema->connect_error);
		
		//Get the studies with the most number of cases from all tables
		$query_schema = "SELECT table_name,table_rows from INFORMATION_SCHEMA.TABLES WHERE table_name like 'patientinfo_%'
						ORDER BY table_rows DESC LIMIT 10";
		
		$result_schema = $conn_schema->query($query_schema);
		
		if(!$result_schema) die("Problem with query");
		
		$where_clause = "(";
		$count = $result_schema->num_rows;
		
		for($i=0; $i < $count; $i++){
			$row = $result_schema->fetch_assoc();
			$where_clause = $where_clause . "'" . substr($row['table_name'],12);			
			if($i == ($count - 1))
				$where_clause .= "')";
			else
				$where_clause .= "',";
		}
		
		//Use the top 10 study id list to get the names of the studies
		$query = "SELECT name FROM study WHERE id in " . $where_clause;
		$result = $conn->query($query);
		
		if(!$result) die("Problem with query");

		$row_schema = $result_schema->data_seek(0);		//Reset the pointer
		
		$data = array();
		
		while($row = $result->fetch_assoc()){
			$row_schema = $result_schema->fetch_assoc();
			$object = [ 
				"Name" => $row['name'] ,
				"Num_Rows" => $row_schema['table_rows']];
			array_push($data,$object);
		}
		
		
		header("application/json; charset=utf-8");
		echo json_encode($data);
		
		// while($row = $result_schema->fetch_assoc()){
			// // echo $row['table_name'] . " - " . $row["table_rows"] . "<br>";	
		// }	
		
	}
	
	if(isset($_POST['cmd'])){
		
		$conn = new mysqli($hostname,$username,$password,$database);
		if ($conn->connect_error) die($conn->connect_error);
	
		switch($_POST['cmd']){
			case 'GetTypes':
				getTopTypes($conn);
				break;
			case 'GetTopStudies':
				getTopStudies($conn);
				break;	
		}	
	}	
	
?>