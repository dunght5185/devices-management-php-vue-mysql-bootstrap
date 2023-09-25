<?php
include '../../api/function.php';
include 'sql.php';

echo $db;
// Filter the excel data 
function filterData(&$str){ 
    $str = preg_replace("/\t/", "\\t", $str); 
    $str = preg_replace("/\r?\n/", "\\n", $str); 
    if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"'; 
} 
 
// Excel file name for download 
$fileName = "thiet_bi_" . date('Y-m-d') . ".xls"; 
 
// Column names 
$fields = array('LOẠI MÁY', 'NHÂN VIÊN', 'PHÒNG BAN', 'MÃ THIẾT BỊ', 'CODE/IP', 'MAC ADDRESS', 'NGÀY MUA', 'TRẠNG THÁI', 'CHI TIẾT'); 
 
// Display column names as first row 
$excelData = implode("\t", array_values($fields)) . "\n"; 
 
// Fetch records from database 
$query = $db->query("
	SELECT 
		a.id, a.idmay, a.idban, b.name AS phongban, c.name AS loaimay, a.name, a.service_tag, a.express_code, a.mac_address, a.ngay_mua, a.tinh_trang, a.details
	FROM device_it AS a
	LEFT 
     	JOIN device_phongban AS b 
     	ON b.id = a.idban
  	LEFT 
    	JOIN device_loaimay AS c 
    	ON c.id = a.idmay
	ORDER BY id ASC
"); 
if($query->num_rows > 0){ 
    // Output each row of the data 
    while($row = $query->fetch_assoc())
    { 
        $lineData = array($row['loaimay'], $row['name'], $row['phongban'], $row['service_tag'], $row['express_code'], $row['mac_address'], $row['ngay_mua'], $row['tinh_trang'], $row['details']); 
        array_walk($lineData, 'filterData'); 
        $excelData .= implode("\t", array_values($lineData)) . "\n"; 
    } 
}else{ 
    $excelData .= 'No records found...'. "\n"; 
} 
 
// Headers for download 
header("Content-Type: application/vnd.ms-excel"); 
header("Content-Disposition: attachment; filename=\"$fileName\""); 
 
// Render excel data 
echo $excelData; 
 
exit;