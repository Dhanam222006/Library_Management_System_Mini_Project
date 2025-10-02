<?php
session_start();
include("sidebar.php");
require 'db1.php';

// Generate next customer ID
$result = $conn->query("SELECT MAX(customerid) AS maxid FROM registerdetails");
$row = $result->fetch_assoc();
$maxId = $row['maxid'] ?? 0;

// Convert maxid to number and increment
$nextId = $maxId + 1;
$customerId = str_pad($nextId, 4, '0', STR_PAD_LEFT);

$errors = [];
$successMessage = ''; // Initialize success message

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $email    = trim($_POST['email']);
    $dob      = $_POST['dob'];
    $phone    = trim($_POST['phone']);

    // Validation
    if (!preg_match("/^[a-zA-Z]{1,20}$/", $username)) {
        $errors[] = "Username must be letters only (max 20 characters).";
    }
    if (!preg_match("/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&]).{8,}$/", $password)) {
        $errors[] = "Password must be at least 8 characters and include letters, numbers, and a special character.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email address.";
    }
    if (!preg_match("/^\d{10}$/", $phone)) {
        $errors[] = "Phone number must be exactly 10 digits.";
    }
    if (empty($dob)) {
        $errors[] = "Date of Birth is required.";
    }

    // Insert into database if no errors
    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO registerdetails (customerid, username, password, email, dob, phone) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $customerId, $username, $hashedPassword, $email, $dob, $phone);

        if ($stmt->execute()) {
    $successMessage = "Registration successful!";
    $username = $password = $email = $dob = $phone = '';
    $nextId++;
    $customerId = str_pad($nextId, 4, '0', STR_PAD_LEFT);

    // Add redirect script
    echo "<script>
            setTimeout(function(){
                window.location.href = 'user login.php';
            }, 1000);
          </script>";
} else {
    $errors[] = "Database error: " . $conn->error;
}

    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Customer Registration</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
/* Page background */
body {
  font-family: "Segoe UI", sans-serif;
  background: linear-gradient(135deg, #1e3c72, #2a5298, #dd7ed0ff, #d61680ff);
  background-size: 400% 400%;
  animation: gradientBG 20s ease infinite;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
}

@keyframes gradientBG {
  0% { background-position: 0% 50%; }
  50% { background-position: 100% 50%; }
  100% { background-position: 0% 50%; }
}

.form-container {
  background: rgba(255, 255, 255, 0.1);
  backdrop-filter: blur(15px);
  padding: 40px;
  border-radius: 20px;
  box-shadow: 0 8px 30px rgba(0,0,0,0.3);
  width: 400px;
  color: #fff;
}

.form-container h2 {
  text-align: center;
  margin-bottom: 30px;
}

.form-container input {
  width: 100%;
  padding: 12px;
  margin-bottom: 20px;
  border-radius: 10px;
  border: none;
  outline: none;
}

.form-container input[type="submit"] {
  background: #00b4d8;
  cursor: pointer;
  font-weight: bold;
  transition: all 0.3s ease;
}

.form-container input[type="submit"]:hover {
  background: #0096c7;
  transform: scale(1.05);
}

.back-btn {
  background: rgba(255, 255, 255, 0.3);
  color: #fff;
  padding: 10px 20px;
  border-radius: 10px;
  text-decoration: none;
  display: inline-block;
  transition: all 0.3s ease;
}

.back-btn:hover {
  background: rgba(255, 255, 255, 0.5);
  transform: scale(1.05);
}
/* Registration card */
.registration-card {
    background: #b5c8f186; /* semi-dark transparent card */
    padding: 30px 25px;
    border-radius: 12px;
    width: 700px;
    height: 600px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.4);
}

/* Heading */
.registration-card h2 {
    text-align: center;
    margin-bottom: 25px;
    color: black;
    font-size: 26px;
    font-weight: 600;
}

/* Labels */
label {
    color: black;
    font-weight: 500;
}

/* Input boxes: narrow and centered */
.form-control {
    width: 90%;           /* take most of the card width */
    max-width: 100%;      /* allow it to fill the card */
    margin: 0 auto 10px auto; /* center inside the card */
    height: 35px;         /* comfortable height */
    font-size: 14px;      
    padding: 5px 10px;    
    display: block;
    border-radius: 6px;
}


/* Button smaller and centered */
.btn-primary {
    background-color: #0e67ecff; 
    color: Register;            
    border: none;
    width: 50%;                 
    display: block;
    margin: 15px auto 0 auto;   
    font-size: 15px;            
    font-weight: 600;
    border-radius: 6px;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background-color: #e6e6e6;
    color: #1e3c72;
}

/* Alerts */
.alert a {
    color: #1e3c72;
    text-decoration: underline;
}

/* Input focus effect */
.form-control:focus {
    box-shadow: 0 0 0 0.2rem rgba(255,255,255,0.25);
    border-color: black;
}
.bottom-buttons {
  position: fixed;
  bottom: 20px;
  right: 20px;
  display: flex;
  gap: 10px;
}
.bottom-buttons a {
  text-decoration: none;
}
</style>
</head>
<body>
<div class="registration-card">
    <h2>Customer Registration</h2>

    <!-- Show errors -->
    <?php if (!empty($errors)) : ?>
        <div class="alert alert-danger text-center">
            <?php echo implode("<br>", $errors); ?>
        </div>
    <?php endif; ?>

    <!-- Show success message -->
    <?php if ($successMessage) : ?>
        <div class="alert alert-success text-center">
            <?php echo $successMessage; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action=""  autocomplete="off">
        <div class="mb-3">
            <label>Customer ID</label>
            <input type="text" class="form-control" name="customerid" value="<?php echo $customerId; ?>" readonly>
        </div>
        <div class="mb-3">
            <label>Username</label>
            <input type="text" class="form-control" name="username" placeholder="Username" value="<?php echo $username ?? ''; ?>" required maxlength="20" pattern="[A-Za-z]{1,20}" title="Letters only, max 20 characters">
        </div>
       <div class="mb-3">
    <label>Password</label>
    <input type="password" 
           class="form-control" 
           name="password" 
           placeholder="Password (max 8 chars, include special char)" 
           required 
           maxlength="8" 
           pattern="^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&]).{8}$" 
           title="Exactly 8 characters, must include letters, numbers, and a special character">
</div>
        <div class="mb-3">
            <label>Email ID</label>
            <input type="email" class="form-control" name="email" placeholder="username@gmail.com"value="<?php echo $email ?? ''; ?>" required>
        </div>
        <div class="mb-3">
            <label>Date of Birth</label>
            <input type="date" class="form-control" name="dob" value="<?php echo $dob ?? ''; ?>" required>
        </div>
        <div class="mb-3">
            <label>Phone Number</label>
            <input type="text" class="form-control" name="phone" placeholder="Phone Number" value="<?php echo $phone ?? ''; ?>" required maxlength="10" pattern="\d{10}" title="10 digits only">
        </div>
        <button type="submit" class="btn btn-primary">Register</button>
    </form>
</div>
<div class="bottom-buttons">
  <a href="user login.php" class="btn btn-secondary">Back</a>
</div>

</body>
</html>
