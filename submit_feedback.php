<?php
// submit_feedback.php

// db.php
$servername = "localhost";
$dbusername = "root";
$dbpassword = "Dhanam@2006"; // put your password
$dbname = "feedback";

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->set_charset("utf8mb4");

// your DB connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $satisfaction = $_POST['satisfaction'];
    $ease = $_POST['ease'];
    $suggestions = trim($_POST['suggestions']);

    $stmt = $conn->prepare("INSERT INTO feedback (username, satisfaction, ease, suggestions) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $satisfaction, $ease, $suggestions);

    if ($stmt->execute()) {
        header("Location: thankyou.php?user=" . urlencode($username));
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
