<?php
// Start session
session_start();

// Include database connection
require_once 'db_connect.php';

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $email = $conn->real_escape_string($_POST['login-email']);
    $password = $_POST['login-password'];
    
    // Get user from database
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $user_id = $user['user_id'];
        
        // Check if account is locked
        $lockoutCheck = "SELECT COUNT(*) as failed_attempts, 
                            MAX(attempt_time) as last_attempt 
                            FROM login_attempts 
                            WHERE user_id = $user_id 
                            AND successful = 0 
                            AND attempt_time > DATE_SUB(NOW(), INTERVAL 3 MINUTE)";
        
        $lockoutResult = $conn->query($lockoutCheck);
        $lockoutData = $lockoutResult->fetch_assoc();
        
        // If 3 or more failed attempts within last 3 minutes
        if ($lockoutData['failed_attempts'] >= 3) {
            // Calculate time remaining until unlock
            $lastAttempt = strtotime($lockoutData['last_attempt']);
            $unlockTime = $lastAttempt + (3 * 60); // 3 minutes in seconds
            $currentTime = time();
            $timeRemaining = $unlockTime - $currentTime;
            
            if ($timeRemaining > 0) {
                // Account is still locked
                $minutes = floor($timeRemaining / 60);
                $seconds = $timeRemaining % 60;
                echo json_encode([
                    'status' => 'error', 
                    'message' => "Account is locked. Try again in $minutes minute(s) and $seconds second(s)."
                ]);
                exit;
            }
        }
        
        // Verify password
        if (password_verify($password, $user['password'])) {
            // Password is correct, set session variables
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['last_name'] = $user['last_name'];
            $_SESSION['email'] = $user['email'];
            
            $_SESSION['logged_in'] = true;
            
            // Record successful login attempt
            $insertAttempt = "INSERT INTO login_attempts (user_id, successful) 
                              VALUES ($user_id, 1)";
            $conn->query($insertAttempt);
            
            echo json_encode(['status' => 'success', 'message' => 'Login successful!']);
        } else {
            // Password is incorrect
            // Record failed login attempt
            $insertAttempt = "INSERT INTO login_attempts (user_id, successful) 
                                VALUES ($user_id, 0)";
            $conn->query($insertAttempt);
            
            // Get count of recent failed attempts
            $failedAttemptsQuery = "SELECT COUNT(*) as count 
                                    FROM login_attempts 
                                    WHERE user_id = $user_id 
                                    AND successful = 0 
                                    AND attempt_time > DATE_SUB(NOW(), INTERVAL 3 MINUTE)";
            $failedResult = $conn->query($failedAttemptsQuery);
            $failedData = $failedResult->fetch_assoc();
            $attemptsLeft = 3 - $failedData['count'];
            
            if ($attemptsLeft <= 0) {
                echo json_encode([
                    'status' => 'error', 
                    'message' => 'Too many failed login attempts. Account locked for 3 minutes.'
                ]);
            } else {
                echo json_encode([
                    'status' => 'error', 
                    'message' => "Invalid email or password. $attemptsLeft attempt(s) remaining before lockout."
                ]);
            }
        }
    } else {
        // User not found - for security reasons, we'll still record an attempt
        // with a generic user_id of 0 (or you could choose not to record these)
        $insertAttempt = "INSERT INTO login_attempts (user_id, successful) 
                            VALUES (0, 0)";
        $conn->query($insertAttempt);
        
        echo json_encode(['status' => 'error', 'message' => 'Invalid email or password']);
    }
    
    $conn->close();
}
?>