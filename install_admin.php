<?php
// install_admin.php - run once to create an admin user, then delete this file
require 'db.php';

$username = 'Admin';
$password = 'adminpass'; // change this immediately after install

$hash = password_hash($password, PASSWORD_DEFAULT);

$stmt = $pdo->prepare("SELECT id FROM admins WHERE username = ?");
$stmt->execute([$username]);
if ($stmt->fetch()) {
    echo "Admin already exists. Delete this file after use.";
    exit;
}
$insert = $pdo->prepare("INSERT INTO admins (username, password_hash) VALUES (?, ?)");
$insert->execute([$username, $hash]);
echo "Admin created. Username: {$username}";
