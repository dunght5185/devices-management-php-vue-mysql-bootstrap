<?php

function card(string $nama_table)
{
   mysqli_set_charset($GLOBALS['connection'], "utf8mb4");

   $query = "
      SELECT 
         a.id, a.idban, b.name AS phongban, a.name, a.card
      FROM $nama_table AS a 
      LEFT 
         JOIN device_phongban AS b 
         ON b.id = a.idban
   ";

   $result = mysqli_query($GLOBALS['connection'], $query);

   while ($data = mysqli_fetch_assoc($result)) {
      $semua_data[] = $data;
   }

   return $semua_data;
}

function checkCode(string $nama_table, array $data, &$id=0)
{

   $card  = $data['card'];
   $where = ($id != 0) ? ' AND a.id <>'.$id : '';

   $query = "
      SELECT a.id FROM $nama_table AS a
      WHERE a.card = '$card' $where";

   $result = mysqli_query($GLOBALS['connection'], $query);
   $semua_data = mysqli_fetch_assoc($result);
   
   return $semua_data;
}