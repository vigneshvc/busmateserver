 <?php
require_once "dbcon.php";
$response = array();
 if(isset($_REQUEST['username']) && isset($_REQUEST['password'])){
	$username = $_REQUEST['username'];
	$password = $_REQUEST['password'];
	
	$passhash = md5($password);
	$sql = "SELECT * FROM student where student_loginid='".$username."' and passhash='".$passhash."';";
	//echo $sql;
	$retval=mysqli_query($conn, $sql);  
	if(mysqli_num_rows($retval) >0){ 
		//fetch the details
		$response['username'] = $username;
		$row = mysqli_fetch_assoc($retval);
		$response['stop_id'] = $row['stop_id'];
		$response['pref_bus_id'] = $row['pref_bus_id'];
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
 