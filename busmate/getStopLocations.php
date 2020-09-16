<?php
require_once "dbcon.php";
$response = array();
$response['status']="failed";
if(isset($_POST['stopid'])){
	$stopid = $_POST['stopid'];
	$q = "SELECT `stop_id`, `stop_name`, `latitude`, `longitude` FROM `stop` WHERE `stop_id`=".$stopid;
	$retval=mysqli_query($conn, $q);
	if(mysqli_num_rows($retval) >0){ 
		$response["status"]="success";
		$row = mysqli_fetch_assoc($retval);
		$response["latitude"] = $row['latitude'];
		$response["stopName"] = $row['stop_name'];
		$response["longitude"] = $row['longitude'];
	}else{
   die('{"status":"failed","error":"No Such Stop IDs"}');
}
}
echo json_encode($response);
?>