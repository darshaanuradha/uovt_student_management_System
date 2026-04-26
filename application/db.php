<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'uovt_sms';
$port = 3307; // Define the new port here

$conn = new mysqli($host, $user, $pass, $dbname, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>