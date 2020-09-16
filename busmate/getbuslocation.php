<?php
require_once "dbcon.php";

$response = array();

if(isset($_REQUEST['busid'])){
	
$busid = $_REQUEST['busid']; 

$lat = "13.2004";
$long =  "80";
$busname = 'madhavaram';

$sql = "SELECT * FROM bus where bus_id='".$busid."';";
	//echo $sql;
	$retval=mysqli_query($conn, $sql);  
	if(mysqli_num_rows($retval) >0){ 
		//fetch the details
		$row = mysqli_fetch_assoc($retval);
		$response['busname'] = $row['bus_name'];
		$response['lat'] = $row['latitude'];
		$response['long'] = $row['longitude'];
		$response['busid']=$row['bus_id'];
		$response['status']="success";
		
	}else{
		//credentials are wrong i.e., such username and password is not found
		$response['status']="failed";
	}

}else{
	$response['status'] = "failed";
}
echo json_encode($response);

?>