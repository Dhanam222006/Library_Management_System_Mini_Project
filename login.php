<?php
// login.php
session_start();
if (isset($_SESSION['admin_id'])) {
    header('Location: dashboard.php');
    exit;
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Admin Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
     body {
      background-image: url("logo.jpg");
  background-size: cover;
  background-repeat: no-repeat;
  background-position: center center;
  /* Optional: add this for a fixed/parallax feel */
  background-attachment: fixed;
  height: 100%;  font-family: sans-serif; display: flex; align-items: center; justify-content: center; min-height: 100vh; margin: 0;
    }
    .home-link {
      position: fixed;
      bottom: 20px;
      right: 20px;
      color: white;
      font-size: 18px;
      text-decoration: none;
      font-weight: bold;
      background: rgba(24, 5, 46, 0.94);
      padding: 8px 14px;
      border-radius: 6px;
      backdrop-filter: blur(4px);
      transition: 0.3s;
    }
    .home-link:hover {
      background: rgba(55, 89, 238, 0.93);
    }
    </style>
</head>
<body class="bg-light">
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-4">
      <div class="card shadow-sm">
        <div class="card-body">
          <h4 class="card-title mb-3 text-center">Admin Login</h4>
          <?php if(isset($_GET['error'])): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($_GET['error']); ?></div>
          <?php endif; ?>
          <form method="post" action="process_login.php"  autocomplete="off">
            <div class="mb-3">
              <label class="form-label">Username</label>
              <input name="username" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Password</label>
              <input type="password" name="password" class="form-control" required>
            </div>
            <button class="btn btn-primary w-100">Login</button>
          </form>
          
        </div>
      </div>
    </div>
  </div>
</div>
  <a href="index.php" class="home-link">Back</a>
</body>
</html>
