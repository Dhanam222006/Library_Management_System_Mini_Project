<?php
// db.php
$servername = "localhost";
$dbusername = "root";
$dbpassword = "Dhanam@2006"; // put your password
$dbname = "regist";

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");
?>
