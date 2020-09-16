<?php
require_once "dbcon.php";
$response = array();
$response["found"]="false";
if(isset($_POST['busid'])){
		
		$busid = $_POST['busid'];
	
	$q = "SELECT `requestid`, `student_id`,`stop_id`, `stop_name`, `acceptance_status`, `request_timestamp` FROM `missedthebus` WHERE `requested_bus_id`=".$busid." and acceptance_status is null;";
	//echo $q;
	$retval=mysqli_query($conn, $q);
	if(mysqli_num_rows($retval) > 0){ 
		$response["found"]="true";
		$row = mysqli_fetch_assoc($retval);
		$response["studentID"] = $row['student_id'];
		$response["stopName"] = $row['stop_name'];
		$response["stopID"] = $row['stop_id'];
	}else{
   die('{"status":"success","found":"false","requestedbusid":"'.$busid.'","error":"No Missed Person"}');
}
}
echo json_encode($response);
?>