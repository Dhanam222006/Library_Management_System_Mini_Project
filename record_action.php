<?php
// record_action.php
session_start();
if (!isset($_SESSION['admin_id'])) { exit('auth'); }
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $book_id = (int)$_POST['book_id'];
    $action = $_POST['action']; // 'borrow' or 'return'
    $user = trim($_POST['user_name'] ?? '');
    $note = trim($_POST['note'] ?? '');

    $pdo->beginTransaction();
    try {
        $stmt = $pdo->prepare("INSERT INTO transactions (book_id, action, user_name, note) VALUES (?, ?, ?, ?)");
        $stmt->execute([$book_id, $action, $user, $note]);

        if ($action === 'borrow') {
            $upd = $pdo->prepare("UPDATE books SET available_count = GREATEST(0, available_count - 1) WHERE id = ?");
            $upd->execute([$book_id]);
        } else {
            $upd = $pdo->prepare("UPDATE books SET available_count = LEAST(total_count, available_count + 1) WHERE id = ?");
            $upd->execute([$book_id]);
        }
        $pdo->commit();
        header('Location: transactions.php?book_id=' . $book_id . '&msg=action-recorded');
        exit;
    } catch (Exception $e) {
        $pdo->rollBack();
        exit('Error: ' . $e->getMessage());
    }
}
