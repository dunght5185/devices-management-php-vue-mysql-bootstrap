<?php
$host = 'localhost';
$user = 'gagnnyox_db';
$password = 'eoWDLCE9@o47';
$database = 'gagnnyox_device';

$connection = mysqli_connect($host, $user, $password, $database);

$GLOBALS['connection'] 	= $connection;
$GLOBALS['url'] 		= 'localhost:8081/';


// Set the character set to utf8mb4
$connection->set_charset('utf8mb4');