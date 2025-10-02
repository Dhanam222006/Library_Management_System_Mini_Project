<?php
session_start();
require 'db2.php';

// Force JSON output
header('Content-Type: application/json');

// Ensure user is logged in
if (!isset($_SESSION['username']) || !isset($_SESSION['customerid'])) {
    echo json_encode(['success' => false, 'message' => 'Please login first']);
    exit;
}

$username = $_SESSION['username'];
$customerid = $_SESSION['customerid'];
$action = $_POST['action'] ?? '';
$book_id = intval($_POST['book_id'] ?? 0);

if (!$action || !$book_id) {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit;
}

// Fetch the book record
$bookQuery = $conn->prepare("SELECT * FROM books WHERE id = ?");
$bookQuery->bind_param("i", $book_id);
$bookQuery->execute();
$book = $bookQuery->get_result()->fetch_assoc();

if (!$book) {
    echo json_encode(['success' => false, 'message' => 'Book not found']);
    exit;
}

$total = (int)$book['total_count'];
$available = (int)$book['available_count'];
$title = $book['title'];

// Normalize action strings
if ($action === "borrowed") $action = "borrow";
if ($action === "returned") $action = "return";

$action = strtolower($action);
if ($action !== "borrow" && $action !== "return") {
    echo json_encode(['success' => false, 'message' => 'Invalid action type']);
    exit;
}

// Function to get last transaction record for this user and book
$lastStmt = $conn->prepare("
    SELECT action 
    FROM transactions
    WHERE customerid = ? AND book_id = ?
    ORDER BY action_date DESC, id DESC
    LIMIT 1
");
$lastStmt->bind_param("si", $customerid, $book_id);
$lastStmt->execute();
$lastRes = $lastStmt->get_result();
$lastRow = $lastRes->fetch_assoc();
$lastAction = $lastRow['action'] ?? null;

// Enforce restrictions

if ($action === "borrow") {
    // if lastAction is "borrow", then they have not returned yet
    if ($lastAction === "borrow") {
        echo json_encode([
            'success' => false,
            'message' => "You have already borrowed '$title'. Please return it before borrowing again."
        ]);
        exit;
    }
}

if ($action === "return") {
    // If lastAction is null, user never borrowed this book
    if ($lastAction === null) {
        echo json_encode([
            'success' => false,
            'message' => "You cannot return '$title' because you never borrowed it."
        ]);
        exit;
    }
    // If lastAction is "return", then the book was already returned
    if ($lastAction === "return") {
        echo json_encode([
            'success' => false,
            'message' => "You have already returned '$title'. Please borrow it first if you want to return again."
        ]);
        exit;
    }
}

// Check availability / limits

if ($action === "borrow") {
    if ($available <= 0) {
        echo json_encode([
            'success' => false,
            'message' => "Book '$title' is not available to borrow."
        ]);
        exit;
    }
    $newAvailable = $available - 1;
} elseif ($action === "return") {
    if ($available >= $total) {
        // means all copies are already in stock
        echo json_encode([
            'success' => false,
            'message' => "Cannot return more than the total stock for '$title'."
        ]);
        exit;
    }
    $newAvailable = $available + 1;
}

// Perform update & transaction record

$updateStmt = $conn->prepare("UPDATE books SET available_count = ? WHERE id = ?");
$updateStmt->bind_param("ii", $newAvailable, $book_id);
$updateStmt->execute();

$insertStmt = $conn->prepare("
    INSERT INTO transactions (book_id, book_name, action, user_name, customerid, action_date)
    VALUES (?, ?, ?, ?, ?, NOW())
");
$insertStmt->bind_param("issss", $book_id, $title, $action, $username, $customerid);
$insertStmt->execute();

echo json_encode([
    'success' => true,
    'message' => "Book '$title' $action successful. Available: $newAvailable",
    'displayAction' => ucfirst($action)
]);
exit;
?>
