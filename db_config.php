<?php
$mysqli = new mysqli("localhost","root","","booking");

// Check connection
if ($mysqli->connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli->connect_error;
  exit();
}


function CreateOrUpdateUser($email , $name , $mysqli)
{
	//call for Store procedure from DB to isert or update and get data 
	$sql = "CALL CreateOrUpdateEmployee('$name' , '$email' , @u)";
	return sp_handler($sql, $mysqli);
}


function CreateOrUpdateEvent($event_id, $event_name , $event_date , $version ,$mysqli)
{
	//call for Store procedure from DB to isert or update and get data 
	$sql = "CALL CreateOrUpdateEvents ('$event_id', '$event_name' , '$event_date' , '$version' )";
	if ($result = $mysqli->multi_query($sql)) {
			return $result;
	}
	//return sp_handler($sql, $mysqli);
}


function createParticipation($participation_id , $emloyee_id, $event_id,  $participation_fee, $mysqli){

	//call for Store procedure from DB to isert or update and get data 
	$sql = "CALL CreateParticipations ('$participation_id', '$emloyee_id' , '$event_id' , '$participation_fee' )";
	if ($result = $mysqli->multi_query($sql)) {
			return $result;
	}
	
}


function getParticiaption($mysqli){

	$response = array(
		'total' => 100,
		'totalNotFiltered' => 100,
		'rows' => []
	);


	$sql = "SELECT * FROM `participation_view`";

	$result = $mysqli->query($sql);
	
	if ($result->num_rows > 0) {
	  // output data of each row
	  while($row = $result->fetch_assoc()) {
	    array_push($response['rows'], $row );
	  }
	}
	return $response;
}


function sp_handler($sql, $mysqli){
	if ($result = $mysqli->multi_query($sql)) {

		$data = null;
		while($mysqli->more_results())
			{
			    $mysqli->next_result();
			    if($res = $mysqli->store_result())
			    {
			    	while ($row = $res->fetch_row()){
			    	  $data = $row;
			    	 }
			        $res->free(); 
			    }
			}

		return $data;
	}
	else{
		return false;
	}
}






?>