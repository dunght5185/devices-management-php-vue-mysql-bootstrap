<?php
include '../../api/function.php';
include 'sql.php';

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: origin, x-requested-with, content-type');
header('Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTION');
header('Content-Type: application/json');

$input = json_decode(file_get_contents("php://input"), TRUE);

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

   if ($_GET['work'] == 'exportData') {
      $db = 'device_it';
      $data_work = device($db);
      echo json_encode($data_work);
      header('Content-Type: text/csv');
      header('Access-Control-Expose-Headers: ["Content-Disposition","Content-Type","My-Custom-Header"]');
   }

   if ($_GET['work'] == 'device_it') {
      $db = 'device_it';
      $data_work = device($db);
      echo json_encode($data_work);
   }

   if ($_GET['work'] == 'phongban') {
      $data_work = selectALL('device_phongban');
      echo json_encode($data_work);
   }

   if ($_GET['work'] == 'loaimay') {
      $data_where = array('idban' => 6);
      $data_work  = select('device_loaimay', $data_where);
      echo json_encode($data_work);
   }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

   $db = 'device_it';

   if ($_POST['work'] == 'add_device') {

      $data_check = array('service_tag'  => $_POST['service_tag']);

      $data = checkCode($db, $data_check);

      if ($data) {

         $respon = [
            'sukses' => FALSE,
            'pesan' => 'Mã sản phẩm đã nhập rồi!',
            'tipe' => 'warning',
         ];

      } else {

         $data_device = array(
            'idmay'  => $_POST['idmay'],
            'idban'  => $_POST['idban'],
            'name'   => $_POST['name'],
            'service_tag'  => $_POST['service_tag'],
            'express_code' => $_POST['express_code'],
            'mac_address'  => $_POST['mac_address'],
            'ngay_mua'     => $_POST['ngay_mua'],
            'tinh_trang'   => $_POST['tinh_trang'],
            'details'     => $_POST['details'],
         );

         insert($db, $data_device);

         $respon = [
            'sukses' => TRUE,
            'pesan' => 'Đã thêm thành công!',
            'tipe' => 'success',
         ];
      }

      echo json_encode($respon);
   }

   if ($_POST['work'] == 'add_newDevice') {
    $db = 'device_loaimay';

      $data_check = array('id'  => $_POST['id']);

      $data = checkCode($db, $data_check);

      if ($data) {

         $respon = [
            'sukses' => FALSE,
            'pesan' => 'Mã sản phẩm đã nhập rồi!',
            'tipe' => 'warning',
         ];

      } else {

         $data_device = array(
            'id'  => $_POST['id'],
            'idban'  => $_POST['idban'],
            'name'   => $_POST['name'],
         );

         insert($db, $data_device);

         $respon = [
            'sukses' => TRUE,
            'pesan' => 'Đã thêm thiết bị thành công!',
            'tipe' => 'success',
         ];
      }

      echo json_encode($respon);
   }

   if ($_POST['work'] == 'updata_device') {

      $id_produk = $_POST['id'];

      $data_check = array('service_tag'  => $_POST['service_tag']);

      $data = checkCode($db, $data_check, $id_produk);

      if ($data) {

         $respon = [
            'sukses' => FALSE,
            'pesan' => 'Mã sản phẩm đã nhập rồi!',
            'tipe' => 'warning',
         ];

      } else {

         $data_update = array(
            'idmay'  => $_POST['idmay'],
            'idban'  => $_POST['idban'],
            'name'   => $_POST['name'],
            'service_tag'  => $_POST['service_tag'],
            'express_code' => $_POST['express_code'],
            'mac_address'  => $_POST['mac_address'],
            'ngay_mua'     => $_POST['ngay_mua'],
            'tinh_trang'   => $_POST['tinh_trang'],
            'details'     => $_POST['details'],
         );

         $kondisi_where = array('id' => $id_produk);

         $hasil = update($db, $data_update, $kondisi_where);

         if (!$hasil) {
            $respon = [
               'sukses' => FALSE,
               'pesan' => 'Cập nhật thất bại!',
               'tipe' => 'warning',
            ];
         } else {
            $respon = [
               'sukses' => TRUE,
               'pesan' => 'Đã cập nhật thành công!',
               'tipe' => 'success',
            ];
         }

      }

      echo json_encode($respon);
   }

   if ($_POST['work'] == 'delete_device') {
      $db = 'device_it';
      $id_produk = $_POST['id'];
      
      $result = delete($db, $id_produk);
      
      if ($result) {
         $respon = [
            'sukses' => true,
            'pesan' => 'Đã xóa thành công!',
            'tipe' => 'success',
         ];
      } else {
         $respon = [
            'sukses' => false,
            'pesan' => 'Xóa thất bại!',
            'tipe' => 'warning',
         ];
      }

      // Send the JSON response
      header('Content-Type: application/json');

      echo json_encode($respon);
   }

}