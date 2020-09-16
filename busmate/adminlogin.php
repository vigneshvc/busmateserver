<?php
require_once "dbcon.php";
$response = array();
 if(isset($_REQUEST['username']) && isset($_REQUEST['password'])){
	$username = $_REQUEST['username'];
	$password = $_REQUEST['password'];
	
	$sql = "SELECT * FROM busmateadmin where username='".$username."' and password='".$password."';";
	//echo $sql;
	$retval=mysqli_query($conn, $sql);  
	if(mysqli_num_rows($retval) >0){ 
		//fetch the details
		$response['username'] = $username;
		$row = mysqli_fetch_assoc($retval);
		$response['bus_id'] = $row['bus_id'];
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
 