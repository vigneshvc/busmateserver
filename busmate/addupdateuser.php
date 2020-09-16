<?php
require_once "dbcon.php";
$response = array();

if(isset($_REQUEST['mailid']) && isset($_REQUEST['password']) && isset($_REQUEST['busid']) && isset($_REQUEST['stopid'])){

$mailid=$_REQUEST['mailid'];
$password=$_REQUEST['password'];
$busname = $_REQUEST['busid'];
$stopname = $_REQUEST['stopid'];
$uname = $_REQUEST['username'];
$ucontact = $_REQUEST['usercontact'];


$stopid=-1;
	
$q = "SELECT `stop_id` FROM `stop` where stop_name='".$stopname."';";
$retval=mysqli_query($conn, $q);  
	if(mysqli_num_rows($retval) == 1){ 
		$row = mysqli_fetch_assoc($retval);
		$stopid = $row['stop_id'];
	}
	else{
   die('{"status":"failed","error":"stop id fetch failed"}');
	}	
	$busid=-1;
	
$q = "SELECT `bus_id` FROM `bus` where bus_name='".$busname."';";
$retval=mysqli_query($conn, $q);  
	if(mysqli_num_rows($retval) == 1){ 
		$row = mysqli_fetch_assoc($retval);
		$busid = $row['bus_id'];
	}
	else{
   die('{"status":"failed","error":"bus id fetch failed"}');
	}

$sql = "SELECT  `student_loginid`, `passhash`, `stop_id`, `pref_bus_id` FROM `student` WHERE student_loginid='".$mailid."';";
$retval=mysqli_query($conn, $sql);  
	if(mysqli_num_rows($retval) >0){
		
	$query="UPDATE `student` SET `passhash`='".md5($password)."',`student_name`='".$uname."',`student_contact`='".$ucontact."',`stop_id`=".$stopid.",`pref_bus_id`=".$busid." WHERE student_loginid='".$mailid."';";
	if(mysqli_query($conn,$query)){
		$response['status']="success";
	}else{
		$response['status']="failed";
		$response['error']="cannot update";
	}
	}else{
		$query="INSERT INTO `student`(`student_loginid`, `passhash`, `stop_id`, `pref_bus_id`,`student_name`,`student_contact`) VALUES ('".$mailid."','".md5($password)."',".$stopid."
		,".$busid.",'".$uname."','".$ucontact."');";
	if(mysqli_query($conn,$query)){
		$response['status']="success";
	}else{
		$response['status']="failed";
		$response['error']="cannot create new user";
	}
	}
}
else{
	$response['status']="failed";
}
echo json_encode($response);
?>