<?php

require_once "dbcon.php";
$response = array();
$fp = fopen("log.txt",'a');
fwrite($fp,"---------------------------------------------------------------\n");
if(isset($_REQUEST['userid'])){
	fwrite($fp,$_REQUEST['userid']);
	fwrite($fp,"\n\r");
}else{
fwrite($fp,"No User ID");
	fwrite($fp,"\n\r");
	
}
if(isset($_REQUEST['busid'])){
	fwrite($fp,$_REQUEST['busid']);
	fwrite($fp,"\n\r");
}else{
fwrite($fp,"No Bus ID");
	fwrite($fp,"\n\r");
	
}
if(isset($_REQUEST['lat'])){
	fwrite($fp,$_REQUEST['lat']);
	fwrite($fp,"\n\r");
}
if(isset($_REQUEST['long'])){
	fwrite($fp,$_REQUEST['long']);
	fwrite($fp,"\n\r");
}
fwrite($fp,"---------------------------------------------------------------\n");
fclose($fp);

function isValidJson($strJson) {
    json_decode($strJson);
    return (json_last_error() === JSON_ERROR_NONE);
}

if(isset($_REQUEST['userid'])&&isset($_REQUEST['busid'])&&isset($_REQUEST['lat'])&&isset($_REQUEST['long'])){
	
	$busid = $_REQUEST['busid'];
	$userid = $_REQUEST['userid'];
	$lat = $_REQUEST['lat'];
	$long = $_REQUEST['long'];
	
	$sql = "SELECT * FROM bus where bus_id=".$busid.";";
	//echo $sql;
	$retval=mysqli_query($conn, $sql); 
	if(mysqli_num_rows($retval) >0){ 
		//fetch the details
		$row = mysqli_fetch_assoc($retval);
		//echo $row['last_updated'];
		$d = new DateTime($row['last_updated']);
		$d1 = new DateTime();
		//echo $d->format('Y-m-d\TH:i:s.u'); 
		//echo "<br>";
		//echo $d1->format('Y-m-d\TH:i:s.u'); 
		//echo "<br>";
		$tz = $d1->getTimezone();
		//echo $tz->getName();
		//echo "<br>";
		$minute_difference = (($d->getTimeStamp() - $d1->getTimeStamp())/60);
		$filepointer = fopen($busid.".json",'a+');
		$url=$busid.".json";
		if(filesize($busid.".json")==0)
		{
			fwrite($filepointer,"{'busid':'".$busid."'}");
			fclose($filepointer);
			$filepointer = fopen($busid.".json",'r');
		}
		$contents = fread($filepointer,filesize($busid.".json"));
		//print_r($content);
		if(isValidJson($contents)){echo "valid json";}
		print_r(json_decode($contents));
		
		
		fclose($filepointer);
		
		
		
		
		
		$response['status']="success";
	}else{
		//credentials are wrong i.e., such username and password is not found
		$response['status']="failed";
	}
}
echo json_encode($response);

?>