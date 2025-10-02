<?php
// dashboard.php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit;
}
require 'db.php';
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <style>
body {
    background: linear-gradient(135deg, #3a6186, #89253e); /* Dark blue/purple gradient */
    color: #fff;
    min-height: 100vh;
}

.sidebar {
    min-height: 100vh;
    background: linear-gradient(180deg, #2c3e50, #3498db); /* Gradient sidebar */
    color: #fff;
}

.sidebar a {
    color: #fff;
}

.sidebar a:hover {
    background-color: rgba(255, 255, 255, 0.2);
    color: #fff;
}

.card {
    background-color: rgba(255, 255, 255, 0.1); /* Semi-transparent cards */
    border: none;
    color: #fff;
}

.card h6 {
    font-weight: bold;
}

.card h3 {
    font-size: 2rem;
}

.list-group-item {
    background: transparent;
    border: none;
    color: #fff;
}

.list-group-item-action:hover {
    background-color: rgba(255, 255, 255, 0.2);
}


    
  </style>
</head>
<body>
<div class="d-flex">
  <nav class="sidebar bg-white border-end p-3" style="width:250px;">
    <a href="dashboard.php" class="d-block mb-3 h5 text-decoration-none">Admin Panel</a>
    <div class="list-group">
      <a href="books.php" class="list-group-item list-group-item-action">Book Info</a>
      <a href="books.php?action=add" class="list-group-item list-group-item-action">Add Book</a>
      <a href="transactions.php" class="list-group-item list-group-item-action">All Transactions</a>
      <a href="logout.php" class="list-group-item list-group-item-action text-danger">Logout</a>
    </div>
  </nav>

  <main class="flex-grow-1 p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h3>Welcome, <?php echo htmlspecialchars($_SESSION['admin_username']); ?></h3>
    </div>

    <div class="row">
      <div class="col-md-4">
        <!-- small stats -->
        <?php
        $booksCount = $pdo->query("SELECT COUNT(*) FROM books")->fetchColumn();
        $borrowed = $pdo->query("SELECT COUNT(*) FROM transactions WHERE action='borrow'")->fetchColumn();
        $returned = $pdo->query("SELECT COUNT(*) FROM transactions WHERE action='return'")->fetchColumn();
        ?>
        <div class="card mb-3">
          <div class="card-body">
            <h6>Total books</h6>
            <h3><?php echo (int)$booksCount; ?></h3>
          </div>
        </div>
        <div class="card mb-3">
          <div class="card-body">
            <h6>Borrow actions</h6>
            <h3><?php echo (int)$borrowed; ?></h3>
          </div>
        </div>
        <div class="card">
          <div class="card-body">
            <h6>Return actions</h6>
            <h3><?php echo (int)$returned; ?></h3>
          </div>
        </div>
      </div>

      <div class="col-md-8">
        <div class="card">
          <div class="card-body">
            <h5>Recent Book Activity</h5>
            <?php
            $recent = $pdo->query("SELECT t.*, b.title FROM transactions t JOIN books b ON b.id=t.book_id ORDER BY t.action_date DESC LIMIT 8")->fetchAll();
            if ($recent):
            ?>
              <ul class="list-group">
                <?php foreach($recent as $r): ?>
                  <li class="list-group-item">
                    <?php echo htmlspecialchars($r['title']); ?> — <?php echo htmlspecialchars($r['action']); ?> by <?php echo htmlspecialchars($r['user_name']); ?> on <?php echo htmlspecialchars($r['action_date']); ?>
                  </li>
                <?php endforeach; ?>
              </ul>
            <?php else: ?>
              <p class="text-muted">No recent activity.</p>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </main>
</div>
</body>
</html>
