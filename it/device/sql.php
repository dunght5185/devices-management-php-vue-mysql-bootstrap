<?php

function device(string $nama_table)
{
   mysqli_set_charset($GLOBALS['connection'], "utf8mb4");

   $query = "
      SELECT 
         a.id, a.idmay, a.idban, b.name AS phongban, c.name AS loaimay, a.name, a.service_tag, a.express_code, a.mac_address, a.ngay_mua, a.tinh_trang, a.details
      FROM $nama_table AS a 
      LEFT 
         JOIN device_phongban AS b 
         ON b.id = a.idban
      LEFT 
         JOIN device_loaimay AS c 
         ON c.id = a.idmay
   ";

   $result = mysqli_query($GLOBALS['connection'], $query);

   while ($data = mysqli_fetch_assoc($result)) {

      if ($data['ngay_mua'] == '0000-00-00') {
         $data['ngay_mua'] = '';
      } else {
         $data['ngay_mua'] = new DateTime($data['ngay_mua']);
         $data['ngay_mua'] = $data['ngay_mua']->format('d/m/Y');
      }

      $semua_data[] = $data;
   }

   return $semua_data;
}

function checkCode(string $nama_table, array $data, &$id=0)
{
   $service_tag   = $data['service_tag'];
   $where         = ($id != 0) ? ' AND a.id <>'.$id : '';

   $query = "
      SELECT a.id FROM $nama_table AS a
      WHERE a.service_tag = '$service_tag' $where";

   $result = mysqli_query($GLOBALS['connection'], $query);
   $semua_data = mysqli_fetch_assoc($result);
   
   return $semua_data;
}