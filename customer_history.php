<?php
// customer_history.php
session_start();
require 'db.php';
if (!isset($_SESSION['username']) || !isset($_SESSION['customerid'])) {
    header("Location: login.php"); exit;
}
$username = $_SESSION['username'];
$customerid = $_SESSION['customerid'];

$stmt = $conn->prepare("SELECT id, book_name, action, action_date FROM transactions WHERE customerid = ? ORDER BY action_date DESC");
$stmt->bind_param('s', $customerid);
$stmt->execute();
$res = $stmt->get_result();
$history = $res->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>My History</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body{ background: linear-gradient(180deg,#eef8ff,#ffffff); padding:30px; font-family:Inter,system-ui,Arial; }
    .card{ border-radius:14px; box-shadow:0 10px 30px rgba(2,6,23,0.06); }
    .badge-borrow { background:#dbeafe; color:#1e3a8a; }
    .badge-return { background:#dcfce7; color:#065f46; }
  </style>
</head>
<body>
<div class="container">
  <div class="d-flex align-items-center justify-content-between mb-3">
    <h3>Transactions history — <?php echo htmlspecialchars($username); ?></h3>
    <a href="borrow_return.php" class="btn btn-outline-primary">Back</a>
  </div>

  <div class="card p-3">
    <?php if (count($history) === 0): ?>
      <div class="text-center p-5 text-muted">No transactions yet.</div>
    <?php else: ?>
      <div class="list-group">
        <?php foreach($history as $row): ?>
          <div class="list-group-item d-flex justify-content-between align-items-start">
            <div>
              <div class="fw-bold"><?php echo htmlspecialchars($row['book_name']); ?></div>
              <div class="text-muted small"><?php echo date('M j, Y H:i', strtotime($row['action_date'])); ?></div>
            </div>
            <div>
              <?php if ($row['action'] === 'borrowed'): ?>
                <span class="badge badge-borrow rounded-pill px-3 py-2">Borrowed</span>
              <?php else: ?>
                <span class="badge badge-return rounded-pill px-3 py-2">Returned</span>
              <?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</div>
</body>
</html>
