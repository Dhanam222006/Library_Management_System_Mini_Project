<?php
session_start();
require 'db2.php';

if (!isset($_SESSION['username']) || !isset($_SESSION['customerid'])) {
    die("Please login first.");
}

$username = $_SESSION['username'];
$customerid = $_SESSION['customerid'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Transaction History</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
 <style>
    /* Animated blue gradient background */
    body {
      background: linear-gradient(270deg, #1e3c72, #2a5298, #3a7bd5, #00d2ff);
      background-size: 800% 800%;
      animation: gradientMove 20s ease infinite;
      font-family: 'Segoe UI', sans-serif;
      min-height: 100vh;
    }

    @keyframes gradientMove {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    /* Card styling */
    .card {
      background: rgba(255, 255, 255, 0.95);
      border-radius: 15px;
      box-shadow: 0 8px 30px rgba(0,0,0,0.3);
      padding: 30px;
    }

    h3 {
      font-weight: 700;
      margin-bottom: 10px;
    }

    table th, table td {
      vertical-align: middle;
      text-align: center;
    }

    /* Table hover animation */
    table.table-hover tbody tr:hover {
      background: rgba(0, 123, 255, 0.1);
      transition: 0.3s;
    }

    /* Back button style */
    .btn-primary {
      background: #0d6efd;
      border: none;
      transition: all 0.3s ease;
    }
    .btn-primary:hover {
      background: #0b5ed7;
      transform: scale(1.05);
    }

    /* Centering the container */
    .container {
      margin-top: 60px;
      margin-bottom: 60px;
    }
  </style>

</head>
<body class="bg-light">
<div class="container mt-5">
  <div class="card shadow p-4">
    <h3 class="text-center text-primary">📖 My Transaction History</h3>
    <p class="text-center"><b>User:</b> <?php echo $username; ?> | <b>ID:</b> <?php echo $customerid; ?></p>
    
    <table class="table table-bordered table-hover mt-3">
      <thead class="table-primary">
        <tr>
          <th>ID</th>
          <th>Book</th>
          <th>Action</th>
          <th>Date</th>
        </tr>
      </thead>
      <tbody>
      <?php
      $q = $conn->prepare("SELECT id, book_name, action, action_date FROM transactions WHERE customerid=? ORDER BY action_date DESC");
      $q->bind_param("s", $customerid);
      $q->execute();
      $res = $q->get_result();
      while($row = $res->fetch_assoc()){
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['book_name']}</td>
                <td>{$row['action']}</td>
                <td>{$row['action_date']}</td>
              </tr>";
      }
      ?>
      </tbody>
    </table>
    <div class="text-center">
      <a href="borrow_return.php" class="btn btn-primary">⬅ Back</a>
    </div>
  </div>
</div>
</body>
</html>
