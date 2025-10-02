<?php
?><!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Library Management System</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

     body {
    background: linear-gradient(135deg, #2c85d8ff, #d82854ff); /* Dark blue/purple gradient */
    color: #fff;
    min-height: 100vh;


    }

    @keyframes gradientBG {
      0% { background-position: 0% 50%; }
      50% { background-position: 100% 50%; }
      100% { background-position: 0% 50%; }
    }

 nav {
    position: sticky;
    top: 0;
    z-index: 10;
    background: rgba(0,0,0,0.2); /* slight dark overlay */
    backdrop-filter: blur(10px);  /* makes content behind blurry */
    padding: 20px 50px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

    nav h1 {
      font-size: 28px;
      font-weight: bold;
      color: #fcfeffff;
    }
    nav ul {
      list-style: none;
      display: flex;
      gap: 30px;
    }
    nav ul li a {
      text-decoration: none;
      color: white;
      font-size: 18px;
      position: relative;
      padding-bottom: 5px;
    }
    nav ul li a::after {
      content: "";
      position: absolute;
      width: 0%;
      height: 2px;
      left: 0;
      bottom: 0;
      background: #00b4d8;
      transition: width 0.3s ease-in-out;
    }
    nav ul li a:hover::after {
      width: 100%;
    }

    .row {
      display: flex;
      align-items: center;
      justify-content: space-around;
      flex-wrap: wrap;
      min-height: 90vh;
      padding: 50px;
    }
    .row1 {
      flex-basis: 40%;
      min-width: 300px;
      animation: fadeInLeft 2s ease;
    }
    .row1 h1 {
      font-size: 42px;
      margin-bottom: 20px;
      line-height: 1.3;
    }
    .row1 p {
      font-size: 20px;
      margin-bottom: 20px;
    }
    .row1 img {
      max-width: 100%;
      animation: fadeInRight 2s ease;
    }

    .btn {
      display: inline-block;
      background: #f09058ff;
      color: #fff;
      padding: 12px 35px;
      border-radius: 30px;
      text-decoration: none;
      font-size: 18px;
      transition: all 0.4s ease-in-out;
      box-shadow: 0 0 10px rgba(0,180,216,0.6);
    }
    .btn:hover {
      background: #0096c7;
      box-shadow: 0 0 20px rgba(0,180,216,1);
      transform: scale(1.05);
    }

    @keyframes fadeInLeft {
      from { opacity: 0; transform: translateX(-50px); }
      to { opacity: 1; transform: translateX(0); }
    }
    @keyframes fadeInRight {
      from { opacity: 0; transform: translateX(50px); }
      to { opacity: 1; transform: translateX(0); }
    }

    /* Footer */
    .footer {
      background: rgba(0, 0, 0, 0.9);
      padding: 40px 20px;
      text-align: center;
      color: #8a8a8a;
      font-size: 14px;
    }
    .footer h3 {
      color: #00b4d8;
      margin-bottom: 10px;
    }
    .footer p {
      margin-bottom: 15px;
    }
    .footer hr {
      border: none;
      height: 1px;
      background: #555;
      margin: 20px 0;
    }
  </style>
</head>
<body>
  <nav>
    <h1>Library Management System</h1>
    <ul>
      <li><a href="login.php">Admin-Login</a></li>
      <li><a href="user login.php">User-Login</a></li>
      <li><a href="user login.php">All-Books</a></li>
      <li><a href="contact.php">Contact</a></li>
    </ul>
  </nav>

  <div class="row">
    <div class="row1">
      <h1>Welcome! Dive Into a World of Books and Resources</h1>
      <p>Begin your journey with this Library Management System</p>
      <a href="user login.php" class="btn">Login →</a>
    </div>
    <div class="row1">
      <img src="frtimg.png" alt="Library Illustration">
    </div>
  </div>

  <div class="footer">
    <h3>Contact Us</h3>
    <p>+91 56892 45781 | LibraryLMS@gmail.com</p>
    <h3>About Us</h3>
    <p>This Library Management System ensures better organization of books and helps with borrowing books in a simple and reliable way.</p>
    <hr>
    <p class="copyright">Copyright 2025 - Easy Borrowing of Books</p>
  </div>
</body>
</html>
