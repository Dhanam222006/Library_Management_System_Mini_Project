<?php
session_start();
include("sidebar2.php");

if (!isset($_SESSION['username'])) {
    header("Location: borrow_return.php");
    exit;
}

$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Library Feedback</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <style>
    body {
      background: linear-gradient(270deg, #1d3557, #d66bd1ff, #a8dadc, #e63946);
      background-size: 800% 800%;
      animation: gradientMove 12s ease infinite;
      font-family: 'Poppins', sans-serif;
      color: #fff;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: flex-start;
      padding-top: 50px;
    }

    @keyframes gradientMove {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

    .feedback-container {
      background: rgba(255,255,255,0.1);
      backdrop-filter: blur(12px);
      border-radius: 20px;
      padding: 30px;
      width: 650px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.3);
      animation: fadeInUp 1s ease;
    }
    @keyframes fadeInUp {
      0% { transform: translateY(50px); opacity: 0; }
      100% { transform: translateY(0); opacity: 1; }
    }

    .form-label { font-weight: 600; }
    .btn-custom {
      background: #e63946;
      border: none;
      transition: all 0.3s ease;
    }
    .btn-custom:hover {
      background: #ff5a5f;
      transform: scale(1.05);
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
  <div class="feedback-container">
    <h2 class="text-center mb-4">Library Feedback</h2>
    <form action="submit_feedback.php" method="POST" autocomplete="off">
      <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text" name="username" class="form-control" required
               autocomplete="off"
               value="<?php echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?>"
               readonly>
      </div>

      <div class="mb-3">
        <label class="form-label">How satisfied are you with our Library Management System?</label>
        <select name="satisfaction" class="form-control" required autocomplete="off">
           <option value="">--Select--</option>
          <option value="Very Satisfied">Very Satisfied</option>
          <option value="Satisfied">Satisfied</option>
          <option value="Neutral">Neutral</option>
          <option value="Unsatisfied">Unsatisfied</option>
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">How easy is it to borrow and return books?</label>
        <select name="ease" class="form-control" required autocomplete="off">
           <option value="">--Select--</option>
          <option value="Very Easy">Very Easy</option>
          <option value="Easy">Easy</option>
          <option value="Average">Average</option>
          <option value="Difficult">Difficult</option>
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">Other Suggestions</label>
        <textarea name="suggestions" rows="3" class="form-control" autocomplete="off"></textarea>
      </div>

      <div class="text-center">
        <button type="submit" class="btn btn-custom px-4 py-2 text-white">Submit</button>
      </div>
    </form>
  </div>
  <!-- Adding arrow symbol in the Back link -->
  <a href="borrow_return.php" class="home-link">&larr; Back</a>
</body>
</html>
