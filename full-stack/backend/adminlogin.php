<?php
session_start();
require 'db.php'; // Assuming db.php sets up $conn for database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $captcha = $_POST['captcha'];

    // Validate CAPTCHA
    if ($captcha !== $_SESSION['captcha_code']) {
        header('Location: index.php?error=Invalid CAPTCHA');
        exit();
    }

    $stmt = $conn->prepare("SELECT password, login_attempts, last_attempt_time, is_blocked, block_until FROM authenticate WHERE username = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashed_password, $login_attempts, $last_attempt_time, $is_blocked, $block_until);
        $stmt->fetch();

        $current_time = new DateTime();
        $block_until_time = new DateTime($block_until);

        // Check if the user is blocked
        if ($is_blocked && $current_time < $block_until_time) {
            header('Location: index.php?error=You have been blocked for 24 hours due to multiple failed login attempts.');
            exit();
        } elseif ($is_blocked && $current_time >= $block_until_time) {
            // Reset block status if block time has passed
            $stmt = $conn->prepare("UPDATE authenticate SET is_blocked = FALSE, login_attempts = 0 WHERE username = ?");
            $stmt->bind_param('s', $username);
            $stmt->execute();
        }

        // Verify password
        if (password_verify($password, $hashed_password)) {
            $_SESSION['username'] = $username;
            $stmt = $conn->prepare("UPDATE authenticate SET login_attempts = 0 WHERE username = ?");
            $stmt->bind_param('s', $username);
            $stmt->execute();
            header('Location: dashboard.php');
            exit();
        } else {
            // Increment login attempts
            $login_attempts++;
            if ($login_attempts >= 3) {
                $block_until_time = (new DateTime())->add(new DateInterval('P1D'));
                $stmt = $conn->prepare("UPDATE authenticate SET login_attempts = ?, is_blocked = TRUE, block_until = ? WHERE username = ?");
                $stmt->bind_param('iss', $login_attempts, $block_until_time->format('Y-m-d H:i:s'), $username);
            } else {
                $stmt = $conn->prepare("UPDATE authenticate SET login_attempts = ? WHERE username = ?");
                $stmt->bind_param('is', $login_attempts, $username);
            }
            $stmt->execute();
            header('Location: index.php?error=Invalid password');
            exit();
        }
    } else {
        header('Location: index.php?error=User not found');
        exit();
    }
}
?>
