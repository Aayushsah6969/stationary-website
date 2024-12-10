<?php

// session_start();
// if (!isset($_SESSION['username'])) {
//     header('Location: index.php');
//     exit();
// }

require 'db.php';

$username = '@@nishant';
$password = '@@sah@@';

// Hash the password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Prepare and execute the SQL query
$stmt = $conn->prepare("INSERT INTO authenticate (username, password, login_attempts, last_attempt_time, is_blocked, block_until) VALUES (?, ?, 0, NULL, 0, NULL)");
$stmt->bind_param('ss', $username, $hashed_password);

if ($stmt->execute()) {
    echo "New user created successfully.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
