<?php
// sidebar.php
$current_page = basename($_SERVER['PHP_SELF']); // Get current page filename
?>

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

<div class="sidebar">
    <div class="logo">
        <h2><i class="fas fa-book"></i> LMS</h2>
    </div>
    <ul>
        <?php if($current_page != 'index.php'): ?>
        <li><a href="index.php"><i class="fas fa-home"></i> Home</a></li>
        <?php endif; ?>

        <?php if($current_page != 'user login.php'): ?>
        <li><a href="user login.php"><i class="fas fa-sign-in-alt"></i> Login</a></li>
        <?php endif; ?>

        <?php if($current_page != 'register.php'): ?>
        <li><a href="register.php"><i class="fas fa-user-plus"></i> Register</a></li>
        <?php endif; ?>

        <?php if($current_page != 'feedback.php'): ?>
        <li><a href="user login.php"><i class="fas fa-comment-dots"></i> Feedback</a></li>
        <?php endif; ?>

        <?php if($current_page != 'allbooks.php'): ?>
        <li><a href="user login.php"><i class="fas fa-book-open"></i> All Books</a></li>
        <?php endif; ?>

        <?php if($current_page != 'user_history.php'): ?>
        <li><a href="user login.php"><i class="fas fa-exchange-alt"></i> All Transactions</a></li>
        <?php endif; ?>

        <?php if($current_page != 'borrow_return.php'): ?>
        <li><a href="user login.php"><i class="fas fa-arrow-circle-down"></i> Borrow Books</a></li>
        <?php endif; ?>

        <?php if($current_page != 'borrow_return.php'): ?>
        <li><a href="user login.php"><i class="fas fa-arrow-circle-up"></i> Return Books</a></li>
        <?php endif; ?>
        <!-- Logout -->
        <?php if(isset($_SESSION['username'])): ?>
        <li><a href="index.php" class="logout-link"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        <?php endif; ?>
    </ul>
</div>


<style>
/* Reset */
body {
    margin: 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #f0f2f5;
}

/* Sidebar */
.sidebar {
    position: fixed;
    top: 0;
    left: 0;
    height: 100vh;
    width: 200px;
    background: linear-gradient(180deg, #c9dd81ff, #182848);
    color: white;
    padding-top: 20px;
    box-shadow: 5px 0 15px rgba(0,0,0,0.2);
    transition: width 0.3s;
}

.sidebar .logo {
    text-align: center;
    margin-bottom: 30px;
}

.sidebar .logo h2 {
    font-size: 24px;
    font-weight: bold;
}

.sidebar ul {
    list-style: none;
    padding: 0;
}

.sidebar ul li {
    margin: 10px 0;
}

.sidebar ul li a {
    color: white;
    text-decoration: none;
    display: flex;
    align-items: center;
    padding: 12px 20px;
    border-radius: 8px;
    transition: 0.3s;
    font-size: 16px;
}

.sidebar ul li a i {
    margin-right: 15px;
    min-width: 20px;
    text-align: center;
}

/* Hover effect */
.sidebar ul li a:hover {
    background: rgba(29, 72, 121, 0.1);
    transform: translateX(5px);
    box-shadow: 0 0 10px rgba(28, 65, 134, 0.3);
}
.sidebar ul li a.logout-link {
    color: #ff4d4d;
}
.sidebar ul li a.logout-link:hover {
    background: rgba(255, 77, 77, 0.1);
    box-shadow: 0 0 10px rgba(255, 77, 77, 0.5);
}


/* Content */
.content {
    margin-left: 260px;
    padding: 30px;
}
</style>
