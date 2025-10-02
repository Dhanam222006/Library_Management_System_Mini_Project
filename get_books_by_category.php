<?php
require 'db2.php';

$category = $_GET['category'] ?? '';
if (!$category) { echo json_encode([]); exit; }

$stmt = $conn->prepare("SELECT id, title FROM books WHERE category=? ORDER BY title ASC");
$stmt->bind_param("s", $category);
$stmt->execute();
$res = $stmt->get_result();
$books = [];
while ($row = $res->fetch_assoc()) {
    $books[] = $row;
}
echo json_encode($books);
?>
