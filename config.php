<?php
$host = "localhost";
$user = "root";   // user XAMPP mặc định
$pass = "";       // password XAMPP mặc định là rỗng
$db   = "dentalclinic";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Kết nối DB thất bại: " . $conn->connect_error);
}
?>
