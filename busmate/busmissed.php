<?php
require_once "dbcon.php";
$response=array();
$response['status']="failed";
if(isset($_REQUEST['uname'])){
	$uname = $_REQUEST['uname'];
	$q = "SELECT `requestid`, `student_id`, `stop_name`, `requested_bus_id`, `acceptance_status`, `request_timestamp` FROM `missedthebus` WHERE `student_id` ='".$uname."' and acceptance_status='accepted';";
$retval=mysqli_query($conn, $q);  
	if(mysqli_num_rows($retval) >0){ 
		$row = mysqli_fetch_assoc($retval);
		$requested_bus_id = $row['requested_bus_id'];
		$sql = "delete from missedthebus where student_id='".$uname."'";  
		if(mysqli_query($conn, $sql)){  
		//echo "Record deleted successfully";  
		}else{  
		//echo "Could not deleted record: ". mysqli_error($conn);  
		}
		die('{"found":"true","busno":"'.$requested_bus_id.'"}');
	}
	else{
		$q = "SELECT `requestid`, `student_id`, `stop_name`, `requested_bus_id`, `acceptance_status`, `request_timestamp` FROM `missedthebus` WHERE `student_id` ='".$uname."' and acceptance_status is null;";
$retval=mysqli_query($conn, $q);  
	if(mysqli_num_rows($retval) >0){ 
		$row = mysqli_fetch_assoc($retval);		
		die('{"found":"waiting"}');
	}
	else{
	
		
		
		
   die('{"found":"alldenied","error":"stop id fetch failed - check userid"}');
	}
	}
}
else if(isset($_POST['username'])){
	$uname = $_POST['username'];
	
$q = "SELECT `stop_id`,`pref_bus_id` FROM `student` where student_loginid='".$uname."';";
$retval=mysqli_query($conn, $q);  
	if(mysqli_num_rows($retval) == 1){ 
		$row = mysqli_fetch_assoc($retval);
		$stopid = $row['stop_id'];
		$prefbusid = $row['pref_bus_id'];
	}
	else{
   die('{"status":"failed","error":"stop id fetch failed - check userid"}');
	}
	/* if(isset($_POST['clat']) && isset($_POST['clong'])){ */
		$q = "SELECT `latitude`,`longitude`,`stop_name` FROM `stop` where stop_id='".$stopid."';";
$retval=mysqli_query($conn, $q);
	if(mysqli_num_rows($retval) == 1){ 
		$row = mysqli_fetch_assoc($retval);
		$latitude = $row['latitude'];
		$longitude = $row['longitude'];
		$stop_name = $row['stop_name'];
		
	}
	else{
   die('{"status":"failed","error":"stop location fetch failed - contact server admin"}');
	}
	
	/* else{
	die('{"status":"failed","error":"Userlocation not found"}');
	} */
	
	//  FOUND DATA - latitude,longitude,clat,clong,stop_name,stopid,prefbusid,uname
	//echo $latitude.",".$longitude.",".$stop_name.",".$stopid.",".$prefbusid.",".$uname;
	
	$q = "SELECT `bus_id` FROM `route` WHERE bus_id<>".$prefbusid.";";
$retval=mysqli_query($conn, $q);  
	if(mysqli_num_rows($retval) > 0){ 
	 while($row = mysqli_fetch_assoc($retval)){
		$sql = 'INSERT INTO `missedthebus`(`student_id`, `stop_name`,`stop_id`, `requested_bus_id`) VALUES ("'.$uname.'","'.$stop_name.'",'.$stopid.','.$row["bus_id"].');';
		//echo $sql."\n\r";
		if(mysqli_query($conn, $sql)){  
			//successful entry
			}else{  
			 //die('{"status":"failed","error":"DB insertion error -'.mysqli_error($conn).'"}'); 
			 die('{"status":"failed","error":"DB insertion error"}'); 
			}  
	 }
	}
	else{
   die('{"status":"failed","error":"No alternate bus found"}');
	}
	}
	$response['status']="success";
	
	

echo json_encode($response);
?>