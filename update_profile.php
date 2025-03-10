<?php
// Start session
session_start();

// Include database connection
require_once 'db_connect.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Not logged in']);
    exit;
}

// Get user id from session
$user_id = $_SESSION['user_id'];

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $firstname = $conn->real_escape_string($_POST['firstname']);
    $lastname = $conn->real_escape_string($_POST['lastname']);
    $email = $conn->real_escape_string($_POST['email']);
    
    // Check if email already exists (but not for current user)
    $checkEmailSql = "SELECT user_id FROM users WHERE email = ? AND user_id != ?";
    $checkStmt = $conn->prepare($checkEmailSql);
    $checkStmt->bind_param("si", $email, $user_id);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();
    
    if ($checkResult->num_rows > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Email already in use by another account']);
        $checkStmt->close();
        $conn->close();
        exit;
    }
    $checkStmt->close();
    
    // Initialize the update
    $updateSuccess = false;
    
    // Handle password change if requested
    if (!empty($_POST['current-password']) && !empty($_POST['new-password'])) {
        $currentPassword = $_POST['current-password'];
        $newPassword = $_POST['new-password'];
        
        // Get current password from database
        $passCheckSql = "SELECT password FROM users WHERE user_id = ?";
        $passStmt = $conn->prepare($passCheckSql);
        $passStmt->bind_param("i", $user_id);
        $passStmt->execute();
        $passResult = $passStmt->get_result();
        $userData = $passResult->fetch_assoc();
        $passStmt->close();
        
        // Verify current password
        if (password_verify($currentPassword, $userData['password'])) {
            // Hash new password
            $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            
            // Update user data with new password
            $updateSql = "UPDATE users SET first_name = ?, last_name = ?, email = ?, password = ? WHERE user_id = ?";
            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->bind_param("ssssi", $firstname, $lastname, $email, $hashedNewPassword, $user_id);
            $updateSuccess = $updateStmt->execute();
            $updateStmt->close();
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Current password is incorrect']);
            $conn->close();
            exit;
        }
    } else {
        // Update user data without changing password
        $updateSql = "UPDATE users SET first_name = ?, last_name = ?, email = ? WHERE user_id = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("sssi", $firstname, $lastname, $email, $user_id);
        $updateSuccess = $updateStmt->execute();
        $updateStmt->close();
    }
    
    if ($updateSuccess) {
        // Update session data
        $_SESSION['first_name'] = $firstname;
        $_SESSION['last_name'] = $lastname;
        $_SESSION['email'] = $email;
        
        echo json_encode(['status' => 'success', 'message' => 'Profile updated successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update profile: ' . $conn->error]);
    }
    
    $conn->close();
}
?>