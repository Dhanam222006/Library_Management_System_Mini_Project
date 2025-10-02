<?php
$user = $_GET['user'] ?? "User";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Thank You</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <style>
    /* 🔹 Animated gradient background */
    body {
      background: linear-gradient(270deg, #6db4b1ff, #769094ff, #ca37a6ec, #3e84caff);
      background-size: 800% 800%;
      animation: gradientMove 15s ease infinite;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      font-family: 'Poppins', sans-serif;
      color: #333;
      margin: 0;
    }

    @keyframes gradientMove {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    /* 🔹 Thank you card */
    .thankyou-box {
      text-align: center;
      background: rgba(255, 255, 255, 0.95);
      padding: 40px 50px;
      border-radius: 20px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.2);
      animation: fadeIn 1s ease-in-out;
    }

    /* 🔹 Animated green checkmark */
    .checkmark {
      width: 120px;
      height: 120px;
      border-radius: 50%;
      display: inline-block;
      background: #28a745;
      position: relative;
      margin-bottom: 20px;
      box-shadow: 0 0 20px rgba(40,167,69,0.5);
    }

    .checkmark::after {
      content: '';
      position: absolute;
      left: 34px;
      top: 18px;
      width: 35px;
      height: 65px;
      border: solid white;
      border-width: 0 8px 8px 0;
      transform: rotate(45deg);
      animation: draw 0.6s ease forwards;
    }

    /* 🔹 Animations */
    @keyframes fadeIn {
      from {opacity: 0; transform: scale(0.9);}
      to {opacity: 1; transform: scale(1);}
    }

    @keyframes draw {
      from {height: 0;}
      to {height: 65px;}
    }

    h1 {
      font-weight: 700;
      color: #28a745;
      margin-bottom: 10px;
    }

    p {
      color: #555;
      font-size: 1.1rem;
    }
  </style>
</head>
<body>
  <div class="thankyou-box">
    <div class="checkmark"></div>
    <h1>Thank You, <?php echo htmlspecialchars($user); ?>!</h1>
    <p>Your feedback has been successfully submitted.</p>
  </div>
  <script>
    setTimeout(function() {
      window.location.href = "index.php";
    }, 3000);
  </script>
</body>
</html>
