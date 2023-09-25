<?php
include '../../api/connection.php';
session_start();

$res_Output = array('error' => false);
 
$username = $_POST['username'];
$password = $_POST['password'];
 
if($username=='')
{
	$res_Output['error'] = true;
	$res_Output['message'] = "UserFirstName is required";
}
else if($password=='')
{
	$res_Output['error'] = true;
	$res_Output['message'] = "Your Password is required";
}
else
{
	$staticSalt = md5('Fremed@');
	$crypt = md5($staticSalt.$password);

	mysqli_set_charset($GLOBALS['connection'], "utf8mb4");
	$sql 	 = "select * from device_users where username='$username' and password='$crypt'";
	$query = mysqli_query($GLOBALS['connection'], $sql);
 
	if($query->num_rows>0){
		$row=$query->fetch_array();
		$_SESSION['username']	= $row['id'];
		$_SESSION['phongban']	= $row['phongban'];
		$res_Output['phongban']	= $row['phongban'];
		$res_Output['message'] 	= "Login Successful";
	}
	else{
		$res_Output['error'] 	= true;
		$res_Output['message'] 	= "User Login Failed. User not Found";
	}
}

header("Content-type: application/json");
echo json_encode($res_Output);
die(); 
?>