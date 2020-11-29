<?php 

require('db_config.php');

$response = array(
	 "status" => false,
	 "message" => '',
	 "data" => array()
);

try{
	if($_POST){
		if($_POST['action'] === 'import' && $_FILES){
			
			if ($_FILES['file']['type'] === 'application/json') {

				$data = json_decode ( file_get_contents($_FILES['file']['tmp_name'] ) );

				//insert employees in db 

				foreach ($data as $key) {
					$employee_result 	= CreateOrUpdateUser($key->employee_mail ,
															 $key->employee_name,
															 $mysqli );
					$event_result 		= CreateOrUpdateEvent(  $key->event_id , 
																$key->event_name, 
																$key->event_date,
																array_key_exists("version",$key) ? $key->version : null,
																$mysqli );

						if ($employee_result && $event_result) {

							$participation = createParticipation(   $key->participation_id , 
																	$employee_result[0], 
																	$key->event_id,
																	$key->participation_fee,
																	$mysqli );

							$response['status'] = true;
							//response with success 
							$response['message'] = 'Data imported successfully.';
						
						}
						else
						{
								//response with errors 
								$response['message'] = $employee_result ? $event_result : $employee_result;
						}
						
				}
				
			}
			else
			{
				$response['message'] = "Invalid file type uploaded.";

			}

		}
		else{

			$response['message'] = "Invalid action or file is missing.";
		}
	}
	else{
		$response['message'] = "Invalid Method.";
	}
}
catch(\Exception $e){
		$response['message'] = $e->getMessage();
}
finally {
   echo json_encode($response);
}

?>