<?php
$host = 'localhost:3306';  
//$user = 'apexcode_wp220';  
$user = 'root';  
//$pass = 'KeyToOpen';  
$pass = '';  
$db = 'busmate';
$conn = mysqli_connect($host, $user, $pass,$db);  
if(! $conn )  
{  
  //die('Could not connect: ' . mysqli_error());  
   die('{"status":"failed"}');
}  

?>
