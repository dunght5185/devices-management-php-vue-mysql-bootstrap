<?php
include '../../api/connection.php';

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: origin, x-requested-with, content-type');
header('Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTION');
header('Content-Type: application/json');

$res_Output = array('error' => false);
 
$username  = $_POST['username'];
$password  = $_POST['password'];
$password1 = $_POST['password1'];
$password2 = $_POST['password2'];

if($password1 != $password2)
{
	$res_Output['error'] = true;
	$res_Output['message'] = "Mật khảu mới không giống nhau";
}
else
{
	$staticSalt = md5('Fremed@');
	$crypt = md5($staticSalt.$password);

	mysqli_set_charset($GLOBALS['connection'], "utf8mb4");
	$sql 	 = "select * from device_users where username='$username' and password='$crypt'";
	$query = mysqli_query($GLOBALS['connection'], $sql);
 
	if($query->num_rows>0){
		$row 		= $query->fetch_array();
		$id 		= $row['id'];
		$pass 	= md5($staticSalt.$password2);

		$sqlpass	= "update device_users set password='$pass' where id=$id";
		$result 	= mysqli_query($GLOBALS['connection'], $sqlpass);

		if (!$result) {

			$res_Output['error'] = true;
			$res_Output['message'] = "Cập nhật thất bại!";
		}

	} else {

		$res_Output['error'] = true;
		$res_Output['message'] = "Tài khoản hoặc mật khẩu không đúng";
	}
}

echo json_encode($res_Output);
?>