<?php
require 'db2.php';

$book_id = intval($_GET['book_id'] ?? 0);
$res = $conn->query("SELECT total_count, available_count FROM books WHERE id=$book_id");
if ($row = $res->fetch_assoc()) {
    echo json_encode($row);
} else {
    echo json_encode(['total_count' => 0, 'available_count' => 0]);
}
