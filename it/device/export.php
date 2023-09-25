<?php
include '../../api/connection.php';

// Set the charset to UTF-8
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename="thiet_bi_' . date('Y-m-d') . '.csv"');

// Output file pointer
$output = fopen('php://output', 'w');

// Add Byte Order Mark (BOM)
fwrite($output, "\xEF\xBB\xBF");

// Column names 
$fields = array('LOẠI MÁY', 'NHÂN VIÊN', 'PHÒNG BAN', 'MÃ THIẾT BỊ', 'CODE/IP', 'MAC ADDRESS', 'NGÀY MUA', 'TRẠNG THÁI', 'CHI TIẾT');

// Convert column names to UTF-8 and write as the first row
fputcsv($output, $fields);

// Fetch records from the database 
$query = $connection->query("
    SELECT 
        a.id, a.idmay, a.idban, b.name AS phongban, c.name AS loaimay, a.name, a.service_tag, a.express_code, a.mac_address, a.ngay_mua, a.tinh_trang, a.details
    FROM device_it AS a
    LEFT JOIN device_phongban AS b ON b.id = a.idban
    LEFT JOIN device_loaimay AS c ON c.id = a.idmay
    ORDER BY id ASC
");

if ($query->num_rows > 0) {
    // Output each row of the data 
    while ($row = $query->fetch_assoc()) {
        // Convert values to UTF-8 and write as a row
        $lineData = array(
            $row['loaimay'], $row['name'], $row['phongban'], $row['service_tag'],
            $row['express_code'], $row['mac_address'], $row['ngay_mua'], $row['tinh_trang'], $row['details']
        );
        array_walk($lineData, function (&$value) {
            $value = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
        });
        fputcsv($output, $lineData);
    }
} else {
    // No records found
    fputcsv($output, array('No records found...'));
}

// Close the file pointer
fclose($output);

exit;
?>
