<?php session_start();
if (!isset($_SESSION['username']) ||(trim ($_SESSION['username']) == '')){
	header('location:login/index.php');
} ?>
<?php $view = $_GET['view']; ?>
<!doctype html>
<html lang="vi">
<head>
   <title>Quản Lý Thiết Bị</title>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <link rel="icon" href="assets/images/100x100.png" type="image/png" />
   <link rel="icon" href="assets/images/300x300.png" type="image/png" />
   <link rel="stylesheet" href="assets/css/animate.css" type="text/css" />
   <link rel="stylesheet" href="assets/css/font-awesome.css" type="text/css" />
   <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css" />
   <link rel="stylesheet" href="assets/css/templates.css?v=<?php echo date("Ymdhis"); ?>" type="text/css" />
   <script src="assets/js/jquery-3.5.1.min.js"></script>
   <script src="assets/js/axios.min.js"></script>
   <script src="assets/js/vue.js"></script>
   <script src="assets/js/moment.min.js"></script>
   <script src="assets/js/bootstrap.min.js"></script>
</head>
<body>
<header id="header" class="text-center"<?php echo ($view=='view')? 'style="margin-bottom:10px;"' : ''; ?>>
    <div class="container-fluid">
        <center>
            <div class="logo">
                <img src="assets/images/100x100.png" width="60">
            </div>
            <h1>CÔNG TY CỔ PHẦN DƯỢC PHẨM FREMED - QUẢN LÝ THIẾT BỊ <?php echo ($view != 'QC')? 'PHÒNG '.$view : ''; ?></h1>
        </center>
    </div>
</header>
<?php
	if ($view == 'IT' && $_SESSION['phongban'] == 'IT') {
		include 'it/index.php';
	} 
    elseif ($view == 'QC' && $_SESSION['phongban'] == 'QC') {
        include 'qc/index.php';
    }
    elseif ($view == 'view' && $_SESSION['phongban'] == 'view') {
        include 'view/index.php';
    } 
    else {
		header('location:login/index.php');
	}
?>
</body>
</html>
