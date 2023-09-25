<?php
include '../../api/function.php';
include 'sql.php';

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: origin, x-requested-with, content-type');
header('Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTION');
header('Content-Type: application/json');

$input = json_decode(file_get_contents("php://input"), TRUE);

if ($_SERVER['REQUEST_METHOD'] == 'GET') {

   if ($_GET['work'] == 'card') {
      $db = 'device_card';
      $data_work = card($db);
      echo json_encode($data_work);
   }

   if ($_GET['work'] == 'phongban') {
      $data_work = selectALL('device_phongban');
      echo json_encode($data_work);
   }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

   $db = 'device_card';

   if ($_POST['work'] == 'add_card') {

      $data_check = array(
         'idban'  => $_POST['idban'],
         'card'   => $_POST['card'],
      );

      $data = checkCode('device_card', $data_check);

      if ($data) {

         $respon = [
            'sukses' => FALSE,
            'pesan' => 'ID Card đã nhập rồi!',
            'tipe' => 'warning',
         ];

      } else {

         $data_device = array(
            'idban'  => $_POST['idban'],
            'name'   => $_POST['name'],
            'card'   => $_POST['card'],
         );

         insert('device_card', $data_device);

         $respon = [
            'sukses' => TRUE,
            'pesan' => 'Đã thêm thành công!',
            'tipe' => 'success',
         ];
      }

      echo json_encode($respon);
   }

   if ($_POST['work'] == 'updata_card') {

      $id_produk = $_POST['id'];

      $data_check = array(
         'idban'  => $_POST['idban'],
         'card'   => $_POST['card'],
      );

      $data = checkCode('device_card', $data_check, $id_produk);

      if ($data) {

         $respon = [
            'sukses' => FALSE,
            'pesan' => 'ID Card đã nhập rồi!',
            'tipe' => 'warning',
         ];

      } else {

         $data_update = array(
            'idban'  => $_POST['idban'],
            'name'   => $_POST['name'],
            'card'   => $_POST['card'],
         );

         $kondisi_where = array('id' => $id_produk);

         $hasil = update('device_card', $data_update, $kondisi_where);

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
}