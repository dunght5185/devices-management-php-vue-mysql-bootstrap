<?php
include 'connection.php';

function selectAll(string $nama_table)
{
   mysqli_set_charset($GLOBALS['connection'], "utf8mb4");

   $query = "SELECT * FROM $nama_table ORDER BY id ASC";

   $result = mysqli_query($GLOBALS['connection'], $query);

   while ($data = mysqli_fetch_assoc($result)) {
      $semua_data[] = $data;
   }

   return $semua_data;
}

function select(string $nama_table, array $yang_mana)
{
   mysqli_set_charset($GLOBALS['connection'], "utf8mb4");

   $query = "SELECT * FROM $nama_table";

   $sql = " WHERE ";

   foreach ($yang_mana as $key => $value)
   {
      if (count($yang_mana) > 1) {
         $sql .= "$key = '$value' AND ";
      } else {
         $sql .= "$key = '$value'";
      }
   }

   $query .= rtrim($sql, " AND ");

   $query .= " ORDER BY name ASC";

   $result = mysqli_query($GLOBALS['connection'], $query);

   while ($data = mysqli_fetch_assoc($result)) {
      $semua_data[] = $data;
   }

   return $semua_data;
}

function insert(string $nama_table, array $data)
{
   mysqli_set_charset($GLOBALS['connection'], "utf8mb4");

   $kolom = '';
   $isi = '';

   foreach ($data as $key => $value) {
      $kolom .= $key . ",";
      $isi   .= "'$value',";
   }
   $kolom = rtrim($kolom, ",");
   $isi = rtrim($isi, ",");

   $query = "INSERT INTO $nama_table ($kolom) VALUES ($isi) ";

   $result = mysqli_query($GLOBALS['connection'], $query);

   return $result;
}

function update(string $nama_table, array $data_set, array $yang_mana)
{
   mysqli_set_charset($GLOBALS['connection'], "utf8mb4");

   $sql = "UPDATE $nama_table SET ";

   foreach ($data_set as $key => $value) {
      $sql .= "$key = '$value', ";
   }

   $sql = rtrim($sql, ", ");

   $sql .= " WHERE ";

   foreach ($yang_mana as $key => $value)
   {
      if (count($yang_mana) > 1) {
         $sql .= "$key = '$value' AND ";
      } else {
         $sql .= "$key = '$value'";
      }
   }

   $query = rtrim($sql, " AND ");

   $result = mysqli_query($GLOBALS['connection'], $query);

   return $result;
}

function delete(string $nama_table, $id)
{
   mysqli_set_charset($GLOBALS['connection'], "utf8mb4");

   $id_column = 'id'; // Assuming the column name for the ID is 'id'
   $delete_id = intval($id);
   $query = "DELETE FROM $nama_table WHERE $id_column = $delete_id";

   $result = mysqli_query($GLOBALS['connection'], $query);

   return $result;
}