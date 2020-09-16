<?php
require_once "dbcon.php";
$response = array();
$sql = "SELECT `bus_name` FROM `bus`;";
$retval=mysqli_query($conn, $sql);  
	if(mysqli_num_rows($retval) >0){ 
	$i=0;
		$total =mysqli_num_rows($retval);
		$response['total'] = mysqli_num_rows($retval);
		while($row = mysqli_fetch_assoc($retval)){  
		
		$response["Bus".$i]=$row['bus_name'];
		$i++;
 }
		$response['status']="success";
		
	}else{
		//credentials are wrong i.e., such username and password is not found
		$response['status']="failed";
	}

echo json_encode($response);
?>