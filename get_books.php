<?php
require 'db2.php';

$category = $_GET['category'] ?? 'all';

if($category === 'all'){
    $res = $conn->query("SELECT id, title FROM books");
} else {
    $stmt = $conn->prepare("SELECT id, title FROM books WHERE category=?");
    $stmt->bind_param("s", $category);
    $stmt->execute();
    $res = $stmt->get_result();
}

$books = [];
while($row = $res->fetch_assoc()){
    $books[] = $row;
}

echo json_encode($books);
