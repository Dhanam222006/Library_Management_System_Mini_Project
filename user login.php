<?php
session_start();
include("sidebar.php");

// ----------------- DB connections -----------------
$regisDbHost = 'localhost';
$regisDbName = 'regist';

$loginDbHost = 'localhost';
$loginDbName = 'login';

$dbUser = 'root';
$dbPass = 'Dhanam@2006';

try {
    // connect to regist DB
    $regisPdo = new PDO(
        "mysql:host=$regisDbHost;dbname=$regisDbName;charset=utf8mb4",
        $dbUser,
        $dbPass,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    // connect to login DB
    $loginPdo = new PDO(
        "mysql:host=$loginDbHost;dbname=$loginDbName;charset=utf8mb4",
        $dbUser,
        $dbPass,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch (PDOException $e) {
    die("DB Connection failed: " . htmlspecialchars($e->getMessage()));
}

// ----------------- Handle login -----------------
$error = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $password === '') {
        $error = "Both fields are required.";
    } else {
        // Fetch customer from regist.registerdetails
        $stmt = $regisPdo->prepare('SELECT customerid, password FROM registerdetails WHERE username = ?');
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // ✅ Save in session (make sure key matches borrow_return.php)
            $_SESSION['username']    = $username;
            $_SESSION['customerid'] = $user['customerid'];  // match borrow_return.php

            // ✅ Optional: store login event in login.users table
            $stmt = $loginPdo->prepare("INSERT INTO users (username, password, created_at) VALUES (?, ?, NOW())");
            $stmt->execute([$username, $password]);  // (plain password not recommended!)

            // ✅ Redirect to borrow_return.php
            header("Location: borrow_return.php");
            exit;
        } else {
            $error = "Invalid username or password.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
 <style>
    /* --- Your Glassmorphism CSS --- */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Open Sans", sans-serif;
    }
    body {
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      width: 100%;
      padding: 0 10px;
    }
    body::before {
      content: "";
      position: absolute;
      width: 100%;
      height: 100%;
      background: url("login.jpg"), #000;
      background-position: center;
      background-size: cover;
    }
    .wrapper {
      width: 400px;
      border-radius: 8px;
      padding: 30px;
      text-align: center;
      border: 1px solid rgba(255, 255, 255, 0.5);
      backdrop-filter: blur(8px);
      -webkit-backdrop-filter: blur(8px);
    }
    form {
      display: flex;
      flex-direction: column;
    }
    h2 {
      font-size: 2rem;
      margin-bottom: 20px;
      color: #fff;
    }
    .input-field {
      position: relative;
      border-bottom: 2px solid #ccc;
      margin: 15px 0;
    }
    .input-field label {
      position: absolute;
      top: 50%;
      left: 0;
      transform: translateY(-50%);
      color: #fff;
      font-size: 16px;
      pointer-events: none;
      transition: 0.15s ease;
    }
    .input-field input {
      width: 100%;
      height: 40px;
      background: transparent;
      border: none;
      outline: none;
      font-size: 16px;
      color: #fff;
    }
    .input-field input:focus~label,
    .input-field input:valid~label {
      font-size: 0.8rem;
      top: 10px;
      transform: translateY(-120%);
    }
    .forget {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin: 25px 0 35px 0;
      color: #fff;
    }
    #remember {
      accent-color: #fff;
    }
    .wrapper a {
      color: #efefef;
      text-decoration: none;
    }
    .wrapper a:hover {
      text-decoration: underline;
    }
    button {
      background: #fff;
      color: #000;
      font-weight: 600;
      border: none;
      padding: 12px 20px;
      cursor: pointer;
      border-radius: 3px;
      font-size: 16px;
      border: 2px solid transparent;
      transition: 0.3s ease;
    }
    button:hover {
      color: #fff;
      border-color: #fff;
      background: rgba(255, 255, 255, 0.15);
    }
    .register {
      text-align: center;
      margin-top: 30px;
      color: #fff;
    }
    .home-link {
      position: fixed;
      bottom: 20px;
      right: 20px;
      color: #fff;
      font-size: 18px;
      text-decoration: none;
      font-weight: bold;
      background: rgba(255, 255, 255, 0.1);
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
<body>
  <div class="wrapper">
    <form method="post" autocomplete="off">
      <h2>Login</h2>

      <?php if ($error): ?>
        <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
      <?php endif; ?>

      <div class="input-field">
        <input type="text" name="username" required>
        <label>Enter your username</label>
      </div>
      <div class="input-field">
        <input type="password" name="password" required>
        <label>Enter your password</label>
      </div>
      <button type="submit">Login</button>
      <div class="register">
        <p>Don't have an account?<a href="register.php"> Register</a></p>
      </div>
    </form>
  </div>
  <a href="index.php" class="home-link">Back</a>
</body>
</html>
