<?php
session_start();

$servername = "srv-db-plesk10.ps.kz:3306";
$username = "mirus_study1";
$password = "Study4me";
$dbname = "mirusdes_study1";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

if (!$conn->set_charset("utf8")) {
    die("Ошибка при загрузке набора символов utf8: %s\n" + $conn->error);
}

?>