<?php
	
	require('db_config.php');
	$params = $columns = $totalRecords = $data = array();

	$params = $_REQUEST;

	$columns = array(
		0 => 'employee_name',
		1 => 'employee_mail', 
		2 => 'event_name',
		3 => 'event_date',
		4 => 'participation_fee'
	);

	$where_condition = $sqlTot = $sqlRec = "";

	if( !empty($params['search']['value']) ) {
		$where_condition .=	" WHERE ";
		$where_condition .= " ( employee_name LIKE '%".$params['search']['value']."%' ";    
		$where_condition .= " OR employee_mail LIKE '%".$params['search']['value']."%' ";
		$where_condition .= " OR event_date LIKE '%".$params['search']['value']."%' )";
	}

	$sql_query = " SELECT * FROM participation_view ";
	$sqlTot .= $sql_query;
	$sqlRec .= $sql_query;
	
	if(isset($where_condition) && $where_condition != '') {

		$sqlTot .= $where_condition;
		$sqlRec .= $where_condition;
	}

 	$sqlRec .=  " ORDER BY ". $columns[$params['order'][0]['column']]."   ".$params['order'][0]['dir']."  LIMIT ".$params['start']." ,".$params['length']." ";

	$queryTot = mysqli_query($mysqli, $sqlTot) or die("Database Error:". mysqli_error($mysqli));

	$totalRecords = mysqli_num_rows($queryTot);

	$queryRecords = mysqli_query($mysqli, $sqlRec) or die("Error to Get the Post details.");

	//calculate total fee

	$sql_count = " SELECT CAST(SUM(participation_fee) AS DECIMAL(6,2)) as total_fee FROM `participation_view` ";

	if(isset($where_condition) && $where_condition != '') {

		$sql_count .= $where_condition;
	}

	$queryCount = mysqli_query($mysqli, $sql_count) or die("Database Error:". mysqli_error($mysqli));
	$countRow = mysqli_fetch_assoc($queryCount); 
	$sum = $countRow['total_fee'];

	//end fee calculation 


	while( $row = mysqli_fetch_row($queryRecords) ) { 
		$data[] = $row;
	}	

	$json_data = array(
		"draw"            => intval( $params['draw'] ),   
		"recordsTotal"    => intval( $totalRecords ),  
		"recordsFiltered" => intval($totalRecords),
		"data"            => $data,
		"sum"            =>  $sum

	);

	echo json_encode($json_data);
?>