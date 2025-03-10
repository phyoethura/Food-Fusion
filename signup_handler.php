<?php
// Start session
session_start();

// Include database connection
require_once 'db_connect.php';

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $firstName = $conn->real_escape_string($_POST['firstname']);
    $lastName = $conn->real_escape_string($_POST['lastname']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];
    
    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    // Check if email already exists
    $checkEmail = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($checkEmail);
    
    if ($result->num_rows > 0) {
        // Email already exists
        echo json_encode(['status' => 'error', 'message' => 'Email already exists']);
    } else {
        // Insert new user
        $sql = "INSERT INTO users (first_name, last_name, email, password) 
                VALUES ('$firstName', '$lastName', '$email', '$hashedPassword')";
        
        if ($conn->query($sql) === TRUE) {
            echo json_encode(['status' => 'success', 'message' => 'Your account has been created successfully!']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error: ' . $conn->error]);
        }
    }
    
    $conn->close();
}
?>