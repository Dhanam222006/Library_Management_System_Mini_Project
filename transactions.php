<?php
// transactions.php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}
require 'db.php';

$book_id = isset($_GET['book_id']) ? (int)$_GET['book_id'] : 0;

if ($book_id) {
    $bstmt = $pdo->prepare("SELECT * FROM books WHERE id = ?");
    $bstmt->execute([$book_id]);
    $book = $bstmt->fetch();
    $stmt = $pdo->prepare("SELECT * FROM transactions WHERE book_id = ? ORDER BY action_date DESC");
    $stmt->execute([$book_id]);
    $transactions = $stmt->fetchAll();
} else {
    // show all transactions
    $book = null;
    $transactions = $pdo->query("SELECT t.*, b.title FROM transactions t LEFT JOIN books b ON b.id=t.book_id ORDER BY t.action_date DESC")->fetchAll();
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Transactions</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
  body {
            background-color: #afb9d4ff; /* A nice dark blue */
            /* Optional: makes text readable */
        }

        </style>
</head>
<body>
<div class="container py-4">
  <a href="dashboard.php" class="btn btn-outline-secondary mb-3">Back</a>
  <h3><?php echo $book ? 'Transactions for "' . htmlspecialchars($book['title']) . '"' : 'All Transactions'; ?></h3>

  <?php if ($book): ?>
    <div class="mb-3">
      <a href="books.php?action=edit&id=<?php echo (int)$book['id']; ?>" class="btn btn-outline-primary btn-sm">Edit Book</a>
    </div>
  <?php endif; ?>

  <div class="card">
    <div class="card-body">
      <?php if ($transactions): ?>
        <table class="table">
          <thead>
            <tr><th>Book</th><th>Action</th><th>User</th><th>Date</th></tr>
          </thead>
          <tbody>
            <?php foreach($transactions as $t): ?>
              <tr>
                <td><?php echo isset($t['title']) ? htmlspecialchars($t['title']) : (isset($book['title']) ? htmlspecialchars($book['title']) : ''); ?></td>
                <td><?php echo htmlspecialchars($t['action']); ?></td>
                <td><?php echo htmlspecialchars($t['user_name']); ?></td>
                <td><?php echo htmlspecialchars($t['action_date']); ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php else: ?>
        <p class="text-muted">No transactions found.</p>
      <?php endif; ?>
    </div>
  </div>
</div>
</body>
</html>
