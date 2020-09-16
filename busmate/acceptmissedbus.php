<?php
require_once "dbcon.php";
// {"ping":"success","input":{"busid":"2","studid":"vigneshmr13@gmail.com","accept":"true"}}

$response = array();
$response['ping']='success';
$response['status']='failed';
if(isset($_POST['busid'])&&isset($_POST['accept'])&&isset($_POST['studid'])){
	$busid = $_POST['busid'];
	$studid = $_POST['studid'];
	$accept = $_POST['accept'];
	
	if($accept=="true"){
	
	$query="UPDATE `missedthebus` SET `acceptance_status`='accepted' WHERE `student_id`='".$studid."' and`requested_bus_id`=".$busid.";";

	if(mysqli_query($conn,$query)){
		$response['status']="success";
	}else{
		$response['status']="failed";
		$response['error']="cannot update";
	}
	}else{
		$query="UPDATE `missedthebus` SET `acceptance_status`='denied' WHERE `student_id`='".$studid."' and`requested_bus_id`=".$busid.";";
	if(mysqli_query($conn,$query)){
		$response['status']="success";
	}else{
		$response['status']="failed";
		$response['error']="cannot update";
	}
	}
}

echo json_encode($response);

?>