<?php
//Sinh ra chuỗi dài 32 ngẫu nhiên, cũng cần lưu chuỗi này vào một cột trong DB
//$salt = random_bytes(32);
/*
$raw_password = 'Fremed@2021';
$staticSalt = md5('Fremed@');
echo $crypt = md5($staticSalt.$raw_password);
*/
?>
<!doctype html>
<html lang="vi">
<head>
   <title>Trang Đăng Nhập</title>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <link rel="icon" href="../assets/images/100x100.png" type="image/png" />
   <link rel="icon" href="../assets/images/300x300.png" type="image/png" />
   <link rel="stylesheet" href="../assets/css/animate.css" type="text/css" />
   <link rel="stylesheet" href="../assets/css/font-awesome.css" type="text/css" />
   <link rel="stylesheet" href="../assets/css/bootstrap.min.css" type="text/css" />
   <!-- login -->
   <link rel="stylesheet" href="style.css?v=<?php echo date("Ymdhis"); ?>" type="text/css" />
   <script src="../assets/js/axios.min.js"></script>
	<script src="../assets/js/vue.js"></script>
	<script src="../assets/js/jquery-3.5.1.min.js"></script>
	<script src="../assets/js/bootstrap.min.js"></script>
</head>
<body>
<?php 
$view = $_GET['view'];

if ($view == 'pass')
{
	include 'pass.php';
}
else
{
	include 'login.php';
}
?>
</body>
</html>