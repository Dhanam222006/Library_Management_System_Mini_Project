<?php
$servername = "localhost";
$usename = "root";          // Your DB username
$password = "Dhanam@2006";   // Your DB password
$dbname   = "regist";        // Database name

$conn = new mysqli($servername, $usename, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>